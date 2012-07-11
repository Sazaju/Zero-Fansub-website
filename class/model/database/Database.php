<?php
/*
	The database class wrap all the needed database code (PDO-based) with the
	specific data of this website. In particular, a testing mode is available,
	working on a separated database which is auto initialized (if needed).
	
	Static methods are available to create and get the default database. This default database is
	used by default in the persistent components.
*/

class Database {
	/********************************************\
	                    STATIC
	\********************************************/
	private static $defaultDatabase = null;
	
	public static function getDefaultDatabase() {
		if (Database::$defaultDatabase === null) {
			Database::$defaultDatabase = new Database();
		}
		return Database::$defaultDatabase;
	}
	
	/********************************************\
	            CONSTRUCTOR & DB INIT
	\********************************************/
	private $connection = null;
	
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
			$this->connection->exec('CREATE TABLE "translator" (
				id       INTEGER UNIQUE NOT NULL,
				source   TEXT UNIQUE NOT NULL,
				
				PRIMARY KEY (id)
			)');
		} catch(PDOException $ex) {
			if ($this->connection->errorCode() == 'HY000') {
				// maybe the table already exists, just ignore this part
			} else {
				throw $ex;
			}
		}
		
		try {
			$this->connection->exec('CREATE TABLE "structure" (
				class       VARCHAR(128) NOT NULL,
				field       VARCHAR(128) NOT NULL,
				type        VARCHAR(128) NOT NULL,
				mandatory   BOOLEAN NOT NULL,
				translator  INTEGER NOT NULL,
				start       INTEGER NOT NULL,
				authorStart VARCHAR(128) NOT NULL,
				stop        INTEGER,
				authorStop  VARCHAR(128),
				
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
				class       VARCHAR(128) NOT NULL,
				field       VARCHAR(128) NOT NULL,
				start       INTEGER NOT NULL,
				authorStart VARCHAR(128) NOT NULL,
				stop        INTEGER,
				
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
			field     VARCHAR(128) NOT NULL,
			key       INTEGER NOT NULL,
			timestamp INTEGER NOT NULL,
			value     '.$table->getColumnType().',
			author    VARCHAR(128) NOT NULL,
			
			PRIMARY KEY (class, field, key, timestamp)
		)');
		$this->connection->exec('CREATE TABLE IF NOT EXISTS "archive_'.$table->getName().'" (
			class     VARCHAR(128) NOT NULL,
			field     VARCHAR(128) NOT NULL,
			key       INTEGER NOT NULL,
			timestamp INTEGER NOT NULL,
			value     '.$table->getColumnType().',
			author    VARCHAR(128) NOT NULL,
			archive   INTEGER NOT NULL,
			
			PRIMARY KEY (class, field, key, timestamp)
		)');
	}
	
	/********************************************\
	                     USERS
	\********************************************/
	public function addUser($id, $password) {
		$statement = $this->connection->prepare('INSERT INTO "user" (id, passhash) VALUES (?, ?)');
		$statement->execute(array($id, $this->generateSaltedHash($password, $this->createRandomSalt())));
	}
	
	public function updateUserPassword($id, $newPassword) {
		$statement = $this->connection->prepare('UPDATE "user" SET passhash = ? WHERE id = ?');
		$statement->execute(array($this->generateSaltedHash($newPassword, $this->createRandomSalt()), $id));
	}
	
	/********************************************\
	                     USERS
	\********************************************/
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
	
	/********************************************\
	                   TABLES
	\********************************************/
	private function getTableNames() {
		$tables = $this->getDataTableNames();
		$tables[] = "property";
		$tables[] = "structure";
		$tables[] = "structure_key";
		$tables[] = "user";
		return $tables;
	}
	
	private function getDataTableNames() {
		$tables = array();
		foreach($this->getExistingTypes() as $type) {
			$tables[] = "working_".$type;
			$tables[] = "archive_".$type;
		}
		return $tables;
	}
	
	/********************************************\
	                  STRUCTURE
	\********************************************/
	public function updateStructure(StructureDiff $diff, $authorId) {
		if (!$this->isRegisteredUser($authorId)) {
			throw new Exception("There is no user ".$authorId);
		} else {
			$time = time();
			$this->connection->beginTransaction();
			foreach($diff->toArray() as $descriptor) {
				$class = $descriptor->getClass();
				
				if ($descriptor instanceof AddFieldDiff) {
					$data = $descriptor->getNewValue();
					$fieldName = $data['field'];
					$table = $data['table'];
					$type = $table->getName();
					$translatorID = $this->saveAndGetTranslatorID($data['translator']);
					$property = array('class' => $class,
								'field' => $fieldName,
								'type' => $type,
								'mandatory' => $data['mandatory'],
								'translator' => $translatorID,
								'start' => $time,
								'authorStart' => $authorId);
					
					$insert = $this->connection->prepare('INSERT INTO "structure" (class, field, type, mandatory, translator, start, authorStart, stop, authorStop) VALUES (:class, :field, :type, :mandatory, :translator, :start, :authorStart, NULL, NULL)');
					foreach($property as $key => $value) {
						$insert->bindParam(':'.$key, $property[$key]);
					}
					$insert->execute($property);
					$this->initMissingTable($table);
					
					$select = $this->connection->prepare('SELECT DISTINCT key FROM "working_'.$type.'" WHERE class = ?');
					$select->execute(array($class));
					$array = $select->fetchAll(PDO::FETCH_COLUMN);
					$insert = $this->connection->prepare('INSERT INTO "working_'.$type.'" (class, key, field, timestamp, value, author) VALUES (?, ?, ?, ?, ?, ?)');
					foreach($array as $key) {
						$value = null;
						$insert->execute(array($class, $key, $fieldName, $time, $value, $authorId));
					}
				} else if ($descriptor instanceof RemoveFieldDiff) {
					$data = $descriptor->getOldValue();
					$fieldName = $data['field'];
					$discard = $this->connection->prepare('UPDATE "structure" SET authorStop = ? WHERE class = ? AND field = ? and stop IS NULL');
					$discard->execute(array($authorId, $class, $fieldName));
					$discard = $this->connection->prepare('UPDATE "structure" SET stop = ? WHERE class = ? AND field = ? and stop IS NULL');
					$discard->execute(array($time, $class, $fieldName));
					$this->archiveValues($data['type'], $class, $fieldName, $time);
				} else if ($descriptor instanceof ChangeKeyDiff) {
					$fieldNames = $descriptor->getNewValue();
					$discard = $this->connection->prepare('UPDATE "structure_key" SET stop = ? WHERE class = ? and stop IS NULL');
					$discard->execute(array($time, $class));
					$insert = $this->connection->prepare('INSERT INTO "structure_key" (class, field, start, authorStart, stop) VALUES (:class, :field, :start, :authorStart, NULL)');
					foreach($fieldNames as $name) {
						$insert->execute(array($class, $name, $time, $authorId));
					}
				} else if ($descriptor instanceof ChangeTypeDiff) {
					$fieldName = $descriptor->getField();
					
					// retrieve the current property data
					$select = $this->connection->prepare('SELECT * FROM "structure" WHERE class = ? AND field = ? AND stop IS NULL');
					$select->execute(array($class, $fieldName));
					$property = $select->fetch(PDO::FETCH_ASSOC);
					
					// terminate the current property
					$discard = $this->connection->prepare('UPDATE "structure" SET authorStop = ? WHERE class = ? AND field = ? and stop IS NULL');
					$discard->execute(array($authorId, $class, $fieldName));
					$discard = $this->connection->prepare('UPDATE "structure" SET stop = ? WHERE class = ? AND field = ? and stop IS NULL');
					$discard->execute(array($time, $class, $fieldName));
					
					// start the updated property
					$property['type'] = $descriptor->getNewValue();
					$property['start'] = $time;
					$property['authorStart'] = $authorId;
					unset($property['stop']);
					unset($property['authorStop']);
					$insert = $this->connection->prepare('INSERT INTO "structure" (class, field, type, mandatory, translator, start, authorStart, stop, authorStop) VALUES (:class, :field, :type, :mandatory, :translator, :start, :authorStart, NULL, NULL)');
					foreach($property as $key => $value) {
						$insert->bindParam(':'.$key, $property[$key]);
					}
					$insert->execute($property);
					
					// retrieve the obsolete values
					$select = $this->connection->prepare('SELECT key, value FROM "working_'.$descriptor->getOldValue().'" WHERE class = ? AND field = ?');
					$select->execute(array($class, $fieldName));
					$array = $select->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
					
					// archive the obsolete values
					$this->archiveValues($descriptor->getOldValue(), $class, $fieldName, $time);
					
					// save the new values
					$update = $this->connection->prepare('INSERT INTO "working_'.$descriptor->getNewValue().'" (class, key, field, timestamp, value, author) VALUES (?, ?, ?, ?, ?, ?)');
					foreach($array as $key => $values) {
						$value = $values[0];
						$update->execute(array($class, $key, $fieldName, $time, $value, $authorId));
					}
				} else if ($descriptor instanceof ChangeTranslatorDiff) {
					$fieldName = $descriptor->getField();
					
					// instantiate old translator
					$oldSource = $descriptor->getOldValue();
					$oldName = Debug::getClassNameFromSourceCode($oldSource);
					$oldSource = Debug::changeClassNameInSourceCode($oldSource, $oldName, $oldName."_obsolete_".$class."_".$fieldName);
					$oldName = Debug::getClassNameFromSourceCode($oldSource);
					eval($oldSource);
					$oldReflector = new ReflectionClass($oldName);
					$oldTranslator = $oldReflector->newInstance();
					
					// instantiate new translator
					$newSource = $descriptor->getNewValue();
					$newName = Debug::getClassNameFromSourceCode($newSource);
					$newReflector = new ReflectionClass($newName);
					$newTranslator = $newReflector->newInstance();
					
					// retrieve the current property data
					$select = $this->connection->prepare('SELECT * FROM "structure" WHERE class = ? AND field = ? AND stop IS NULL');
					$select->execute(array($class, $fieldName));
					$property = $select->fetch(PDO::FETCH_ASSOC);
					
					// terminate the current property
					$discard = $this->connection->prepare('UPDATE "structure" SET authorStop = ? WHERE class = ? AND field = ? and stop IS NULL');
					$discard->execute(array($authorId, $class, $fieldName));
					$discard = $this->connection->prepare('UPDATE "structure" SET stop = ? WHERE class = ? AND field = ? and stop IS NULL');
					$discard->execute(array($time, $class, $fieldName));
					
					// start the updated property
					$newTranslatorID = $this->saveAndGetTranslatorID($descriptor->getNewValue());
					$property['translator'] = $newTranslatorID;
					$property['start'] = $time;
					$property['authorStart'] = $authorId;
					unset($property['stop']);
					unset($property['authorStop']);
					$insert = $this->connection->prepare('INSERT INTO "structure" (class, field, type, mandatory, translator, start, authorStart, stop, authorStop) VALUES (:class, :field, :type, :mandatory, :translator, :start, :authorStart, NULL, NULL)');
					foreach($property as $key => $value) {
						$insert->bindParam(':'.$key, $property[$key]);
					}
					$insert->execute($property);
					
					// retrieve the obsolete values
					$select = $this->connection->prepare('SELECT key, value FROM "working_'.$property['type'].'" WHERE class = ? AND field = ?');
					$select->execute(array($class, $fieldName));
					$array = $select->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
					
					$componentReflector = new ReflectionClass($class);
					$component = $componentReflector->newInstance();
					$field = $component->getPersistentField($fieldName);
					$isUpdateNeeded = false;
					foreach($array as $key => $values) {
						$oldValue = $values[0];
						$oldTranslator->setPersistentValue($field, $oldValue);
						$newValue = $newTranslator->getPersistentValue($field->get());
						if ($oldValue != $newValue) {
							$isUpdateNeeded = true;
							break;
						}
					}
					
					if ($isUpdateNeeded) {
						// archive the obsolete values
						$this->archiveValues($property['type'], $class, $fieldName, $time);
						
						// save the new values
						$update = $this->connection->prepare('INSERT INTO "working_'.$property['type'].'" (class, key, field, timestamp, value, author) VALUES (?, ?, ?, ?, ?, ?)');
						foreach($array as $key => $values) {
							$oldValue = $values[0];
							$oldTranslator->setPersistentValue($field, $oldValue);
							$newValue = $newTranslator->getPersistentValue($field->get());
							$update->execute(array($class, $key, $fieldName, $time, $newValue, $authorId));
						}
					}
				} else {
					// TODO implement other cases
					throw new Exception('Not implemented yet: '.$descriptor);
				}
			}
			$this->connection->commit();
		}
	}
	
	private function saveAndGetTranslatorID($translatorSource) {
		$select = $this->connection->prepare('SELECT id FROM "translator" WHERE source = ?');
		$select->execute(array($translatorSource));
		$array = $select->fetch();
		if ($array !== false) {
			return $array[0];
		} else {
			$select = $this->connection->prepare('SELECT MAX(id) FROM "translator"');
			$select->execute();
			$array = $select->fetch();
			$id = $array[0] + 1;
			
			$insert = $this->connection->prepare('INSERT INTO "translator" (id, source) VALUES (:id, :source)');
			$insert->execute(array($id, $translatorSource));
			return $id;
		}
	}
	
	private function getSavedTranslator($id) {
		$select = $this->connection->prepare('SELECT source FROM "translator" WHERE id = ?');
		$select->execute(array($id));
		$array = $select->fetch();
		return $array[0];
	}
	
	private function getFieldsForClass($class, $exceptionIfUnknown = true) {
		$statement = $this->connection->prepare('SELECT field, type, mandatory, translator, start FROM "structure" WHERE class = ? AND stop IS NULL');
		$statement->execute(array($class));
		$fields = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
		if ($exceptionIfUnknown && empty($fields)) {
			throw new Exception("No known structure for $class");
		} else {
			foreach($fields as $field => $array) {
				$array = $array[0];
				settype($array['mandatory'], 'boolean');
				$fields[$field] = $array;
			}
			return $fields;
		}
	}
	
	private function getIDFieldsForClass($class) {
		$statement = $this->connection->query('SELECT field FROM "structure_key" WHERE class = "'.$class.'" AND stop IS NULL');
		$fields = $statement->fetchAll(PDO::FETCH_COLUMN);
		return $fields;
	}
	
	public function isUpdatedStructure(PersistentComponent $component) {
		return !$this->getStructureDiff($component)->isEmpty();
	}
	
	public function getStructureDiff(PersistentComponent $component) {
		$class = $component->getClass();
		$fields = $this->getFieldsForClass($class, false);
		$diff = new StructureDiff();
		foreach($component->getPersistentFields() as $name => $field) {
			$table = $field->getTranslator()->getPersistentTable($field);
			$type = $table->getName();
			$translator = get_class($field->getTranslator());
			$translator = Debug::getClassSourceCode($translator);
			$mandatory = $field->isMandatory();
			
			if (!array_key_exists($name, $fields)) {
				$diff->addDiff(new AddFieldDiff($class, $name, $table, $mandatory, $translator));
			} else {
				$property = $fields[$name];
				unset($fields[$name]);
				$savedTranslator = $this->getSavedTranslator($property['translator']);
				if ($property['type'] != $type) {
					$diff->addDiff(new ChangeTypeDiff($class, $name, $property['type'], $type));
				} else if ($property['mandatory'] != $mandatory) {
					$diff->addDiff(new ChangeMandatoryDiff($class, $name, $property['mandatory'], $mandatory));
				} else if ($savedTranslator != $translator) {
					$diff->addDiff(new ChangeTranslatorDiff($class, $name, $savedTranslator, $translator));
				} else {
					// no modification, do not add a diff
				}
			}
		}
		
		foreach($fields as $name => $property) {
			$diff->addDiff(new RemoveFieldDiff($class, $name, $property['type'], $property['mandatory'], $property['translator']));
		}
		
		$componentKey = array_keys($component->getIDFields());
		$savedIDFields = $this->getIDFieldsForClass($class);
		if (count(array_diff_assoc($savedIDFields, $componentKey)) > 0 || count(array_diff_assoc($componentKey, $savedIDFields)) > 0) {
			$diff->addDiff(new ChangeKeyDiff($class, $savedIDFields, $componentKey));
		}
		
		return $diff;
	}
	
	public function isKnownStructure($structure) {
		if (is_object($structure)) {
			$structure = get_class($structure);
		} else if (is_string($structure)) {
			// considered as the name of the class, let as is
		} else {
			throw new Exception($structure." cannot be interpreted as an object or its class name");
		}
		$statement = $this->connection->prepare('SELECT COUNT(field) FROM "structure" WHERE class = ? AND stop IS NULL');
		$statement->execute(array($structure));
		$counter = $statement->fetchColumn();
		return $counter > 0;
	}
	
	private function checkStructureIsWellKnown(PersistentComponent $component) {
		if (!$this->isKnownStructure($component->getClass())) {
			throw new Exception("Not known structure: ".$component->getClass());
		} else if ($this->isUpdatedStructure($component)) {
			throw new Exception("Not same structure for ".$component->getClass().": ".$this->getStructureDiff($component));
		}
	}
	
	/********************************************\
	                  DATA TYPES
	\********************************************/
	private function getExistingTypes() {
		$statement = $this->connection->query('SELECT DISTINCT type FROM "structure"');
		$types = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
		return $types;
	}
	
	private function getTypesForClass($class) {
		$types = array();
		foreach($this->getFieldsForClass($class) as $field => $array) {
			$types[$field] = $array['type'];
		}
		return $types;
	}
	
	/********************************************\
	                    SAVE
	\********************************************/
	public function save(PersistentComponent $component, $authorId) {
		if (!$this->isRegisteredUser($authorId)) {
			throw new Exception("There is no user ".$authorId);
		} else {
			$class = $component->getClass();
			$savedFields = $this->getFieldsForClass($class);
			
			$key = $component->getInternalKey();
			$isNew = empty($key);
			$savedValues = null;
			$IDString = $component->getIDString();
			if ($isNew) {
				if ($this->isIDAvailableForComponent($component)) {
					// ID available, can save the new element
				} else {
					throw new Exception("Cannot save $component, its ID $IDString is already used");
				}
				
				$key = $this->getNewKey();
				$component->setInternalKey($key);
			} else {
				$savedValues = $this->getSavedValuesFor($key);
				$savedValues = $savedValues[$key];
			}
			
			$time = time();
			$currentFields = $component->getPersistentFields();
			$this->connection->beginTransaction();
			foreach($currentFields as $name => $field) {
				if (!$isNew && !array_key_exists($name, $savedFields)) {
					throw new Exception("No field $name for the component $component");
				} else if ($savedFields[$name]['mandatory'] && $field->get() === null) {
					throw new Exception("The mandatory field $name is not specified for the component $component");
				} else {
					$translator = $field->getTranslator();
					$value = $translator->getPersistentValue($field->get());
					if ($isNew || $savedValues[$name] !== "".$value /*$savedValues only contains strings*/) {
						$type = $translator->getPersistentTable($field);
						
						if (!$isNew) {
							$this->archiveValues($type->getName(), $class, $name, $time, array($key));
						}
						$statement = $this->connection->prepare('INSERT INTO "working_'.$type->getName().'" (class, key, field, timestamp, value, author) VALUES (?, ?, ?, ?, ?, ?)');
						$statement->execute(array($class, $key, $name, $time, $value, $authorId));
						
					}
					unset($savedFields[$name]);
				}
			}
			if (!empty($savedFields)) {
				throw new Exception("Saved field(s) not seen for the component $class with the key $key: ".implode(", ", array_keys($savedFields)));
			}
			$this->connection->commit();
		}
	}
	
	private function getSavedValuesFor($key) {
		// TODO improve to take arrays of keys
		$data = array();
		$data[$key] = array();
		foreach($this->getExistingTypes() as $type) {
			$statement = $this->connection->prepare('SELECT field, value FROM "working_'.$type.'" WHERE key = ?');
			$statement->execute(array($key));
			foreach($statement->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_COLUMN) as $name => $array) {
				$data[$key][$name] = $array[0];
			}
		}
		return $data;
	}
	
	/********************************************\
	                    LOAD
	\********************************************/
	public function load(PersistentComponent $component) {
		$this->checkStructureIsWellKnown($component);
		$class = $component->getClass();
		
		$key = $component->getInternalKey();
		if (empty($key)) {
			throw new Exception("No key has been assigned to the component $component");
		}
		$savedValues = $this->getSavedValuesFor($key);
		foreach($component->getPersistentFields() as $name => $field) {
			if (!array_key_exists($name, $savedValues[$key])) {
				throw new Exception("No field $name for the component $component");
			} else {
				$translator = $field->getTranslator();
				$translator->setPersistentValue($field, $savedValues[$key][$name]);
				unset($savedValues[$key][$name]);
			}
		}
		if (!empty($savedValues[$key])) {
			throw new Exception("Saved field(s) not used for the component $component: ".implode(", ", array_keys($savedValues[$key])));
		}
	}
	
	public function loadAll($class) {
		$reflector = new ReflectionClass($class);
		$this->checkStructureIsWellKnown($reflector->newInstance());
		
		$statement = $this->connection->query('SELECT type FROM "structure" WHERE class = ?');
		$statement->execute(array($class));
		$type = $statement->fetchColumn();
		
		$statement = $this->connection->prepare('SELECT DISTINCT key FROM "working_'.$type.'" WHERE class = ?');
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
	
	/********************************************\
	                 MISCELLANEOUS
	\********************************************/
	private function createRandomSalt() {
		$salt = '';
		for($i = 0 ; $i < 2 ; $i ++) {
			$salt .= chr(rand(32, 126));
		}
		return $salt;
	}
	
	private function generateSaltedHash($password, $salt) {
		return $salt.md5($salt.$password);
	}
	
	public function getNewKey() {
		// TODO create property save/load methods
		$key = $this->connection->query('SELECT value FROM "property" WHERE name = "lastKey"')->fetchColumn();
		$key++;
		$this->connection->exec('UPDATE "property" SET value = "'.$key.'" WHERE name = "lastKey"');
		return $key;
	}
	
	public function clear() {
		foreach($this->getTableNames() as $name) {
			$this->connection->exec('DROP TABLE "'.$name.'"');
		}
	}
	
	private function archiveValues($type, $class, $field, $time, $keys = null) {
		$archiveAll = $keys === null;
		
		$source = '"working_'.$type.'" WHERE class = ? AND field = ?';
		if (!$archiveAll) {
			$source .= ' AND key = ?';
		}
		$copy = $this->connection->prepare('INSERT INTO "archive_'.$type.'" (class, key, field, timestamp, value, author, archive) SELECT class, key, field, timestamp, value, author, '.$time.' as archive FROM '.$source);
		$clean = $this->connection->prepare('DELETE FROM '.$source);
		if (!$archiveAll) {
			foreach($keys as $key) {
				$copy->execute(array($class, $field, $key));
				$clean->execute(array($class, $field, $key));
			}
		} else {
			$copy->execute(array($class, $field));
			$clean->execute(array($class, $field));
		}
	}
	
	public function isIDAvailableForComponent(PersistentComponent $component) {
		$class = $component->getClass();
		$IDFields = $component->getIDFields();
		$correspondingKeys = null;
		foreach($IDFields as $name => $field) {
			$statement = $this->connection->prepare('SELECT type FROM "structure" WHERE class = ? AND field = ? AND stop IS NULL');
			$statement->execute(array($class, $name));
			$type = $statement->fetchColumn();
			
			$statement = $this->connection->prepare('SELECT key FROM "working_'.$type.'" WHERE class = ? AND field = ? AND value = ?');
			$value = $field->getTranslator()->getPersistentValue($field->get());
			$statement->execute(array($class, $name, $value));
			$keys = $statement->fetchAll(PDO::FETCH_COLUMN);
			if ($correspondingKeys === null) {
				$correspondingKeys = $keys;
			} else {
				$correspondingKeys = array_intersect($correspondingKeys, $keys);
			}
		}
		
		return empty($correspondingKeys);
	}
}
?>