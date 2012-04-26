<?php
/*
	The database class wrap all the needed database code (PDO-based) with the
	specific data of this website. In particular, a testing mode is available,
	working on a separated database which is auto initialized (if needed).
	
	Static methods are available to create and get the default database. This default database is
	used by default in the persistent components.
*/

class Database {
	private static $defaultDatabase = null;
	private $connection = null;
	private $persistentFields = array();
	
	public static function getDefaultDatabase() {
		if (Database::$defaultDatabase === null) {
			Database::$defaultDatabase = new Database();
		}
		return Database::$defaultDatabase;
	}
	
	public function __construct() {
		if (DB_TYPE === 'sqlite') {
			$dbFile = DB_NAME.'.sqlite';
			if (!file_exists($dbFile)) {
				file_put_contents($dbFile, '');
				chmod($dbFile, fileperms($dbFile) | 0x0030); // +rw for the group
			}
			$this->connection = new PDO(DB_TYPE.':'.$dbFile);
		}
		else {
			$this->connection = new PDO(DB_TYPE.':dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS);
		}
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->initDatabase();
	}
	
	private function initDatabase() {
		// TODO improve the check (exceptions are not precise enough)
		try {
			$this->connection->exec('CREATE TABLE "property" (
				name     VARCHAR(128),
				value    VARCHAR(128),
				
				PRIMARY KEY (name)
			)');
			$statement = $this->connection->prepare('INSERT INTO "property" (name, value) VALUES (?, ?)');
			$statement->execute(array('lastKey', '0'));
		} catch(PDOException $ex) {
			if ($this->connection->errorCode() == 'HY000') {
				// maybe the table already exists, just ignore this part
			} else {
				throw $ex;
			}
		}
		
		try {
			$this->connection->exec('CREATE TABLE "structure" (
				class      VARCHAR(128) NOT NULL,
				field      VARCHAR(128) NOT NULL,
				type       VARCHAR(128) NOT NULL,
				mandatory  BOOLEAN NOT NULL,
				translator VARCHAR(128) NOT NULL,
				start      INTEGER NOT NULL,
				patch      TEXT,
				stop       INTEGER,
				
				PRIMARY KEY (class, field, start)
			)');
		} catch(PDOException $ex) {
			if ($this->connection->errorCode() == 'HY000') {
				// maybe the table already exists, just ignore this part
			} else {
				throw $ex;
			}
		}
		
		try {
			$this->connection->exec('CREATE TABLE "structure_key" (
				class      VARCHAR(128) NOT NULL,
				field      VARCHAR(128) NOT NULL,
				start      INTEGER NOT NULL,
				stop       INTEGER,
				
				PRIMARY KEY (class, field, start)
			)');
		} catch(PDOException $ex) {
			if ($this->connection->errorCode() == 'HY000') {
				// maybe the table already exists, just ignore this part
			} else {
				throw $ex;
			}
		}
		
		try {
			$this->connection->exec('CREATE TABLE "user" (
				id       VARCHAR(128) NOT NULL,
				passhash CHAR(34) NOT NULL,
				
				PRIMARY KEY (id)
			)');
			$this->addUser('admin', 'admin');
		} catch(PDOException $ex) {
			if ($this->connection->errorCode() == 'HY000') {
				// maybe the table already exists, just ignore this part
			} else {
				throw $ex;
			}
		}
	}
	
	private function initMissingTable($table) {
		$this->connection->exec('CREATE TABLE IF NOT EXISTS "working_'.$table->getName().'" (
			class     VARCHAR(128) NOT NULL,
			key       INTEGER NOT NULL,
			field     VARCHAR(128) NOT NULL,
			timestamp INTEGER NOT NULL,
			value     '.$table->getColumnType().',
			author    VARCHAR(128) NOT NULL,
			
			PRIMARY KEY (class, field, key, timestamp)
		)');
		$this->connection->exec('CREATE TABLE IF NOT EXISTS "archive_'.$table->getName().'" (
			class     VARCHAR(128) NOT NULL,
			key       INTEGER NOT NULL,
			field     VARCHAR(128) NOT NULL,
			timestamp INTEGER NOT NULL,
			value     '.$table->getColumnType().',
			author    VARCHAR(128) NOT NULL,
			
			PRIMARY KEY (class, field, key, timestamp)
		)');
	}
	
	public function addUser($id, $password) {
		$statement = $this->connection->prepare('INSERT INTO "user" (id, passhash) VALUES (?, ?)');
		$statement->execute(array($id, $this->generateSaltedHash($password, $this->createRandomSalt())));
	}
	
	private function createRandomSalt() {
		$salt = '';
		for($i = 0 ; $i < 2 ; $i ++) {
			$salt .= chr(rand(32, 126));
		}
		return $salt;
	}
	
	public function updateUserPassword($id, $newPassword) {
		$statement = $this->connection->prepare('UPDATE "user" SET passhash = ? WHERE id = ?');
		$statement->execute(array($this->generateSaltedHash($newPassword, $this->createRandomSalt()), $id));
	}
	
	private function generateSaltedHash($password, $salt) {
		return $salt.md5($salt.$password);
	}
	
	public function isValidUserPassword($id, $password) {
		$statement = $this->connection->prepare('SELECT passhash FROM "user" WHERE id = ?');
		$statement->execute(array($id));
		$saltedhash = $statement->fetchColumn();
		$salt = substr($saltedhash, 0, 2);
		return $this->generateSaltedHash($password, $salt) === $saltedhash;
	}
	
	public function isRegisteredUser($id) {
		$statement = $this->connection->prepare('SELECT count(*) FROM "user" WHERE id = ?');
		$statement->execute(array($id));
		$counter = $statement->fetchColumn();
		return $counter > 0;
	}
	
	public function getNewKey() {
		$key = $this->connection->query('SELECT value FROM "property" WHERE name = "lastKey"')->fetchColumn();
		$key++;
		$this->connection->exec('UPDATE "property" SET value = "'.$key.'" WHERE name = "lastKey"');
		return $key;
	}
	
	public function getConnection() {
		return $this->connection;
	}
	
	public function clear() {
		foreach($this->getTableNames() as $name) {
			$this->connection->exec('DROP TABLE "'.$name.'"');
		}
	}
	
	public function getTableNames() {
		$statement = $this->connection->query('SELECT DISTINCT type FROM "structure"');
		$tables = array("property", "structure", "user");
		foreach($statement->fetchAll(PDO::FETCH_COLUMN) as $table) {
			$tables[] = "working_".$table;
			$tables[] = "archive_".$table;
		}
		return $tables;
	}
	
	public function updateStructure(StructureDiff $diff, $authorId) {
		if (!$this->isRegisteredUser($authorId)) {
			throw new Exception("There is no user ".$authorId);
		} else {
			$components = array();
			foreach($diff->toArray() as $descriptor) {
				$class = $descriptor->getClass();
				$component = null;
				if (array_key_exists($class, $components)) {
					$component = $components[$class];
				} else {
					$reflector = new ReflectionClass($class);
					$component = $reflector->newInstance();
					$components[$class] = $component;
				}
				
				if ($descriptor instanceof FieldDiff) {
					if ($descriptor->isChangedTable()) {
						$field = $component->getPersistentField($descriptor->getField());
						$this->initMissingTable($field->getTranslator()->getPersistentTable($field));
					}
				} else if ($descriptor instanceof ComponentDiff) {
					if ($descriptor->isAddedField()) {
						$field = $component->getPersistentField($descriptor->getNewValue());
						$this->initMissingTable($field->getTranslator()->getPersistentTable($field));
					}
				} else {
					throw new Exception("This case should not happen");
				}
			}
			
			$this->connection->beginTransaction();
			$time = time();
			foreach($diff->toArray() as $descriptor) {
				$class = $descriptor->getClass();
				$patch = $descriptor->getPatch();
				
				$component = $components[$class];
				
				if ($descriptor instanceof ComponentDiff) {
					if ($descriptor->isAddedField()) {
						$fieldName = $descriptor->getNewValue();
						$field = $component->getPersistentField($fieldName);
						$table = $field->getTranslator()->getPersistentTable($field)->getName();
						$row = array('class' => $class,
									'field' => $fieldName,
									'type' => $table,
									'mandatory' => $field->isMandatory(),
									'translator' => get_class($field->getTranslator()),
									'start' => $time,
									'patch' => $patch);
						
						$insert = $this->connection->prepare('INSERT INTO "structure" (class, field, type, mandatory, translator, start, patch, stop) VALUES (:class, :field, :type, :mandatory, :translator, :start, :patch, NULL)');
						foreach($row as $key => $value) {
							$insert->bindParam(':'.$key, $row[$key]);
						}
						$insert->execute($row);
						
						$select = $this->connection->prepare('SELECT DISTINCT key FROM "working_'.$table.'" WHERE class = ?');
						$select->execute(array($class));
						$array = $select->fetchAll(PDO::FETCH_COLUMN);
						$insert = $this->connection->prepare('INSERT INTO "working_'.$table.'" (class, key, field, timestamp, value, author) VALUES (?, ?, ?, ?, ?, ?)');
						foreach($array as $key) {
							$value = null;
							if ($patch !== null) {
								$value = $this->applyPatch($patch, $value);
							} else {
								// no patch, do not change the data
							}
							$insert->execute(array($class, $key, $fieldName, $time, $value, $authorId));
						}
					} else if ($descriptor->isDeletedField()) {
						$fieldName = $descriptor->getOldValue();
						$discard = $this->connection->prepare('UPDATE "structure" SET stop = ? WHERE class = ? AND field = ? and stop IS NULL');
						$discard->execute(array($time, $class, $fieldName));
					} else if ($descriptor->isChangedKey()) {
						$fieldNames = $descriptor->getNewValue();
						$discard = $this->connection->prepare('UPDATE "structure_key" SET stop = ? WHERE class = ? and stop IS NULL');
						$discard->execute(array($time, $class));
						$insert = $this->connection->prepare('INSERT INTO "structure_key" (class, field, start, stop) VALUES (:class, :field, :start, NULL)');
						foreach($fieldNames as $name) {
							$insert->execute(array($class, $name, $time));
						}
					} else {
						// TODO implement other cases
						throw new Exception('Not implemented yet: '.$descriptor);
					}
				} else if ($descriptor instanceof FieldDiff) {
					if ($descriptor->isChangedTable()) {
						$fieldName = $descriptor->getField();
						$field = $component->getPersistentField($fieldName);
						$table = $field->getTranslator()->getPersistentTable($field)->getName();
						$select = $this->connection->prepare('SELECT * FROM "structure" WHERE class = ? AND field = ? AND stop IS NULL');
						$select->execute(array($class, $fieldName));
						$row = $select->fetch(PDO::FETCH_ASSOC);
						unset($row['stop']);
						$row['start'] = $time;
						$row['type'] = $descriptor->getNewValue();
						$select = $this->connection->prepare('SELECT key, value FROM "working_'.$descriptor->getOldValue().'" WHERE class = ? AND field = ?');
						$select->execute(array($class, $fieldName));
						$array = $select->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
						$update = $this->connection->prepare('INSERT INTO "working_'.$descriptor->getNewValue().'" (class, key, field, timestamp, value, author) VALUES (?, ?, ?, ?, ?, ?)');
						foreach($array as $key => $values) {
							$value = $values[0];
							if ($patch !== null) {
								$value = $this->applyPatch($patch, $value);
							} else {
								// no patch, do not change the data
							}
							$update->execute(array($class, $key, $fieldName, $time, $value, $authorId));
						}
						
						$discard = $this->connection->prepare('UPDATE "structure" SET stop = ? WHERE class = ? AND field = ? and stop IS NULL');
						$discard->execute(array($time, $class, $fieldName));
						
						$insert = $this->connection->prepare('INSERT INTO "structure" (class, field, type, mandatory, translator, start, patch, stop) VALUES (:class, :field, :type, :mandatory, :translator, :start, :patch, NULL)');
						foreach($row as $key => $value) {
							$insert->bindParam(':'.$key, $row[$key]);
						}
						$insert->execute($row);
					} else {
						// TODO implement other cases
						throw new Exception('Not implemented yet: '.$descriptor);
					}
				} else {
					throw new Exception("This case should not happen");
				}
			}
			$this->connection->commit();
		}
	}
	
	private function applyPatch($patch, $oldValue) {
		// TODO apply patch
		throw new Exception('Not implemented yet');
	}
	
	private function getTablesForClass($class) {
		$tables = array();
		foreach($this->getPropertiesForClass($class) as $field => $array) {
			$tables[$field] = $array['type'];
		}
		return $tables;
	}
	
	private function getPropertiesForClass($class) {
		$statement = $this->connection->query('SELECT field, type, mandatory, translator, start, patch FROM "structure" WHERE class = "'.$class.'" AND stop IS NULL');
		$properties = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
		foreach($properties as $field => $array) {
			$array = $array[0];
			settype($array['mandatory'], 'boolean');
			$properties[$field] = $array;
		}
		return $properties;
	}
	
	private function getKeyPropertiesForClass($class) {
		$statement = $this->connection->query('SELECT field FROM "structure_key" WHERE class = "'.$class.'" AND stop IS NULL');
		$properties = $statement->fetchAll(PDO::FETCH_COLUMN);
		return $properties;
	}
	
	public function isUpdatedStructure(PersistentComponent $component) {
		return !$this->getStructureDiff($component)->isEmpty();
	}
	
	public function getStructureDiff(PersistentComponent $component) {
		$class = $component->getClass();
		$properties = $this->getPropertiesForClass($class);
		$diff = new StructureDiff();
		foreach($component->getPersistentFields() as $name => $field) {
			if (!array_key_exists($name, $properties)) {
				$diff->addField($class, $name);
			} else if ($properties[$name]['type'] != $field->getTranslator()->getPersistentTable($field)->getName()) {
				$diff->changeTable($class, $name, $properties[$name]['type'], $field->getTranslator()->getPersistentTable($field)->getName());
			} else if ($properties[$name]['mandatory'] != $field->isMandatory()) {
				$diff->changeMandatory($class, $name, $properties[$name]['mandatory'], $field->isMandatory());
			} else if ($properties[$name]['translator'] != get_class($field->getTranslator())) {
				$diff->changeTranslator($class, $name, $properties[$name]['translator'], get_class($field->getTranslator()));
			} else {
				// no modification, do not add a diff
			}
			unset($properties[$name]);
		}
		
		foreach(array_keys($properties) as $name) {
			$diff->deleteField($class, $name);
		}
		
		$componentKey = array_keys($component->getKeyFields());
		$savedKey = $this->getKeyPropertiesForClass($class);
		if (count(array_diff_assoc($savedKey, $componentKey)) > 0 || count(array_diff_assoc($componentKey, $savedKey)) > 0) {
			$diff->changeKey($class, $savedKey, $componentKey);
		}
		
		return $diff;
	}
	
	public function isKnownStructure(PersistentComponent $component) {
		$class = $component->getClass();
		$counter = $this->connection->query('SELECT count(field) FROM "structure" WHERE class = "'.$class.'"')->fetchColumn();
		return $counter > 0;
	}
	
	private function checkStructureIsWellKnown(PersistentComponent $component) {
		if (!$this->isKnownStructure($component)) {
			throw new Exception("Not known structure: ".$component->getClass());
		} else if ($this->isUpdatedStructure($component)) {
			throw new Exception("Not same structure for ".$component->getClass().": ".$this->getStructureDiff($component));
		}
	}
	
	private function getPersistentTableNames() {
		$statement = $this->connection->query('SELECT DISTINCT type FROM "structure"');
		$tables = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
		return $tables;
	}
	
	public function isMandatoryConsistent(PersistentComponent $component) {
		$class = $component->getClass();
		$key = $component->getInternalKey();
		foreach($component->getPersistentFields() as $name => $field) {
			if ($field->isMandatory()) {
				if ($field->get() === null) {
					return false;
				} else {
					// not null value, continue
				}
			}
		}
		return true;
	}
	
	public function save(PersistentComponent $component, $authorId) {
		$this->checkStructureIsWellKnown($component);
		if (!$this->isMandatoryConsistent($component)) {
			throw new Exception("There is not specified mandatory fields for ".$component);
		} else if (!$this->isRegisteredUser($authorId)) {
			throw new Exception("There is no user ".$authorId);
		} else {
			$key = $component->getInternalKey();
			if (empty($key)) {
				$key = $this->getNewKey();
				$component->setInternalKey($key);
			}
			
			$class = $component->getClass();
			$time = time();
			$this->connection->beginTransaction();
			foreach($component->getPersistentFields() as $name => $field) {
				if ($field->hasChanged()) {
					$translator = $field->getTranslator();
					$table = $translator->getPersistentTable($field);
					// archive the saved value
					$statement = $this->connection->prepare('INSERT INTO "archive_'.$table->getName().'" (class, key, field, timestamp, value, author) SELECT class, key, field, timestamp, value, author FROM "working_'.$table->getName().'" WHERE class = ? AND key = ? AND field = ?');
					$statement->execute(array($class, $key, $name));
					$statement = $this->connection->prepare('DELETE FROM "working_'.$table->getName().'" WHERE class = ? AND key = ? AND field = ?');
					$statement->execute(array($class, $key, $name));
					
					// save the new value
					$statement = $this->connection->prepare('INSERT INTO "working_'.$table->getName().'" (class, key, field, timestamp, value, author) VALUES (?, ?, ?, ?, ?, ?)');
					$statement->execute(array($class, $key, $name, $time, $translator->getPersistentValue($field->get()), $authorId));
				}
			}
			$this->connection->commit();
			foreach($component->getPersistentFields() as $name => $field) {
				$field->setAsSaved();
			}
		}
	}
	
	public function load(PersistentComponent $component) {
		$this->checkStructureIsWellKnown($component);
		
		$key = $component->getInternalKey();
		if (empty($key)) {
			throw new Exception("No key has been assigned to the component ".get_class($component));
		}
		foreach($component->getPersistentFields() as $name => $field) {
			$translator = $field->getTranslator();
			$table = $translator->getPersistentTable($field);
			$statement = $this->connection->prepare('SELECT value FROM "working_'.$table->getName().'" WHERE key = ? AND field = ?');
			$statement->execute(array($key, $name));
			$value = $statement->fetchColumn();
			$translator->setPersistentValue($field, $value);
			$field->setAsSaved();
		}
	}
	
	public function loadFromKey(PersistentComponent $component, $key) {
		$this->checkStructureIsWellKnown($component);
		
		$class = $component->getClass();
		$name = $component->getKeyName();
		$field = $component->getPersistentField($name);
		$translator = $field->getTranslator();
		$table = $translator->getPersistentTable($field);
		$statement = $this->connection->prepare('SELECT key FROM "working_'.$table->getName().'" WHERE class = ? AND field = ? AND value = ?');
		$statement->execute(array($class, $name, $key));
		$internalKey = $statement->fetchColumn();
		$component->setInternalKey($internalKey);
		$this->load($component);
	}
	
	public function loadAll($class) {
		$reflector = new ReflectionClass($class);
		$this->checkStructureIsWellKnown($reflector->newInstance());
		
		$statement = $this->connection->query('SELECT type FROM "structure" WHERE class = ?');
		$statement->execute(array($class));
		$table = $statement->fetchColumn();
		
		$statement = $this->connection->prepare('SELECT DISTINCT key FROM "working_'.$table.'" WHERE class = ?');
		$statement->execute(array($class));
		$keys = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
		
		$loaded = array();
		foreach($keys as $key) {
			$component = $reflector->newInstance();
			$component->setInternalKey($key);
			$this->load($component);
			$loaded[] = $component;
		}
		return $loaded;
	}
	
	public function addPersistentField(PersistentField $descriptor) {
		$class = $descriptor->getClass();
		if (!array_key_exists($class, $this->persistentFields)) {
			$this->persistentFields[$class] = array();
		}
		
		$field = $descriptor->getName();
		if (!array_key_exists($field, $this->persistentFields[$class])) {
			$this->persistentFields[$class][$field] = $descriptor;
			$descriptor->lock();
		} else {
			throw new Exception("The descriptor ($class, $field) already exists.");
		}
	}
	
	public function getPersistentField($class, $field) {
		return $this->persistentFields[$class][$field];
	}
	
	public function getPersistentFields($class) {
		return $this->persistentFields[$class];
	}
	
	public function getAllPersistentFields() {
		$list = array();
		foreach($this->persistentFields as $class => $sublist) {
			foreach($sublist as $field => $descriptor) {
				$list[] = $descriptor;
			}
		}
		return $list;
	}
}
?>