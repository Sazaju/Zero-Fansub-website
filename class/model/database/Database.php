<?php
/*
	The database class wrap all the needed database code (PDO-based) with the
	specific data of this website. In particular, a testing mode is available,
	working on a separated database which is auto initialized (if needed).
	
	Static methods are available to create and get the default database. This default database is
	used by default in the persistent components.
*/

/*
TODO manage transactions with objects representing packages of queries,
then use an executor to execute a list of packages surrounded by begin
& commit.
*/
class Database implements Patchable {
	/********************************************\
	                    STATIC
	\********************************************/
	private static $defaultDatabase = null;
	
	public static function getDefaultDatabase() {
		return Database::$defaultDatabase;
	}
	
	public static function setDefaultDatabase(Database $database) {
		Database::$defaultDatabase = $database;
	}
	
	/********************************************\
	            CONSTRUCTOR & DB INIT
	\********************************************/
	private $connection = null;
	
	public function __construct($driver = 'sqlite', $database = 'database', $host = 'localhost', $user = 'admin', $password = null) {
		if ($driver === 'sqlite') {
			$dbFile = $database.'.sqlite';
			if (!file_exists($dbFile)) {
				file_put_contents($dbFile, '');
				chmod($dbFile, fileperms($dbFile) | 0x0030); // +rw for the group
			}
			$this->connection = new PDO($driver.':'.$dbFile);
		}
		else {
			$this->connection = new PDO($driver.':dbname='.$database.';host='.$host, $user, $password);
		}
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->initDatabase();
	}
	
	private function initDatabase() {
		$c = $this->connection;
		$checkExistence = function($table) use ($c) {$c->prepare('SELECT * FROM "'.$table.'" LIMIT 1');};
		
		try {
			$checkExistence('property');
		} catch(PDOException $ex) {
			$this->connection->exec('CREATE TABLE "property" (
				name     VARCHAR(128),
				value    VARCHAR(128),
				
				PRIMARY KEY (name)
			)');
			$statement = $this->connection->prepare('INSERT INTO "property" (name, value) VALUES (?, ?)');
			$statement->execute(array('lastKey', '0'));
		}
		
		try {
			$checkExistence('working_structure');
		} catch(PDOException $ex) {
			$this->connection->exec('CREATE TABLE "working_structure" (
				class       VARCHAR(128) NOT NULL,
				field       VARCHAR(128) NOT NULL,
				type        VARCHAR(128) NOT NULL,
				mandatory   BOOLEAN NOT NULL,
				timestamp   INTEGER NOT NULL,
				author      VARCHAR(128) NOT NULL,
				
				PRIMARY KEY (class, field)
			)');
		}
		
		try {
			$checkExistence('archive_structure');
		} catch(PDOException $ex) {
			$this->connection->exec('CREATE TABLE "archive_structure" (
				class         VARCHAR(128) NOT NULL,
				field         VARCHAR(128) NOT NULL,
				type          VARCHAR(128) NOT NULL,
				mandatory     BOOLEAN NOT NULL,
				timeCreate    INTEGER NOT NULL,
				authorCreate  VARCHAR(128) NOT NULL,
				timeArchive   INTEGER NOT NULL,
				authorArchive VARCHAR(128) NOT NULL,
				
				PRIMARY KEY (class, field, timeCreate)
			)');
		}
		
		try {
			$checkExistence('working_key');
		} catch(PDOException $ex) {
			$this->connection->exec('CREATE TABLE "working_key" (
				class       VARCHAR(128) NOT NULL,
				field       VARCHAR(128) NOT NULL,
				timestamp   INTEGER NOT NULL,
				author      VARCHAR(128) NOT NULL,
				
				PRIMARY KEY (class, field)
			)');
		}
		
		try {
			$checkExistence('archive_key');
		} catch(PDOException $ex) {
			$this->connection->exec('CREATE TABLE "archive_key" (
				class         VARCHAR(128) NOT NULL,
				field         VARCHAR(128) NOT NULL,
				timeCreate    INTEGER NOT NULL,
				authorCreate  VARCHAR(128) NOT NULL,
				timeArchive   INTEGER NOT NULL,
				authorArchive VARCHAR(128) NOT NULL,
				
				PRIMARY KEY (class, field, timeCreate)
			)');
		}
		
		try {
			$checkExistence('user');
		} catch(PDOException $ex) {
			$this->connection->exec('CREATE TABLE "user" (
				id       VARCHAR(128) NOT NULL,
				passhash CHAR(34),
				
				PRIMARY KEY (id)
			)');
			$this->addUser('admin');
			$this->setUserPassword('admin', 'admin');
		}
	}
	
	private function initMissingTable($type) {
		$type = $type instanceof PersistentType ? $type->getType() : $type;
		
		$column = null;
		if ($type == "boolean") {
			$column = 'BOOLEAN';
		} else if ($type == "integer") {
			$column = 'INTEGER';
		} else if ($type == "double") {
			$column = 'DOUBLE';
		} else if ($type == "string") {
			$column = 'TEXT';
		} else if (preg_match("#^string[0-9]+$#", $type)) {
			$column = 'VARCHAR('.substr($type, 6).')';
		} else {
			throw new Exception("$type is not a managed persistent type");
		}
		
		$this->connection->exec('CREATE TABLE IF NOT EXISTS "working_'.$type.'" (
			class     VARCHAR(128) NOT NULL,
			field     VARCHAR(128) NOT NULL,
			key       INTEGER NOT NULL,
			value     '.$column.',
			timestamp INTEGER NOT NULL,
			author    VARCHAR(128) NOT NULL,
			
			PRIMARY KEY (class, field, key, timestamp)
		)');
		
		$this->connection->exec('CREATE TABLE IF NOT EXISTS "archive_'.$type.'" (
			class         VARCHAR(128) NOT NULL,
			field         VARCHAR(128) NOT NULL,
			key           INTEGER NOT NULL,
			value         '.$column.',
			timeCreate    INTEGER NOT NULL,
			authorCreate  VARCHAR(128) NOT NULL,
			timeArchive   INTEGER NOT NULL,
			authorArchive VARCHAR(128) NOT NULL,
			
			PRIMARY KEY (class, field, key, timeCreate)
		)');
	}
	
	/********************************************\
	                     USERS
	\********************************************/
	public function addUser($id) {
		$statement = $this->connection->prepare('INSERT INTO "user" (id, passhash) VALUES (?, NULL)');
		$statement->execute(array($id));
	}
	
	public function isRegisteredUser($id) {
		$statement = $this->connection->prepare('SELECT count(*) FROM "user" WHERE id = ?');
		$statement->execute(array($id));
		$counter = $statement->fetchColumn();
		return $counter > 0;
	}
	
	public function setUserPassword($id, $password) {
		$hash = $password != null
				? $this->generateSaltedHash($password, $this->createRandomSalt())
				: null;
		$this->setUserHash($id, $hash);
	}
	
	private function setUserHash($id, $hash) {
		$statement = $this->connection->prepare('UPDATE "user" SET passhash = ? WHERE id = ?');
		$statement->execute(array($hash, $id));
	}
	
	public function isValidUserPassword($id, $password) {
		$statement = $this->connection->prepare('SELECT passhash FROM "user" WHERE id = ?');
		$statement->execute(array($id));
		$saltedhash = $statement->fetchColumn();
		$salt = substr($saltedhash, 0, 2);
		return $this->generateSaltedHash($password, $salt) === $saltedhash;
	}
	
	public function isValidUser($id) {
		$statement = $this->connection->prepare('SELECT count(*) FROM "user" WHERE id = ? AND passhash NOT NULL');
		$statement->execute(array($id));
		$counter = $statement->fetchColumn();
		return $counter > 0;
	}
	
	public function getUsers() {
		$statement = $this->connection->prepare('SELECT id FROM "user"');
		$statement->execute(array());
		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}
	
	/********************************************\
	                   TABLES
	\********************************************/
	private function getTableNames() {
		$tables = $this->getDataTableNames();
		$tables[] = "property";
		$tables[] = "working_structure";
		$tables[] = "archive_structure";
		$tables[] = "working_key";
		$tables[] = "archive_key";
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
	public function applyPatch(Patch $patch) {
		$authorId = $patch->getUser();
		$time = $patch->getTime();
		if (!$this->isRegisteredUser($authorId)) {
			throw new Exception("There is no user ".$authorId);
		} else {
			$this->connection->beginTransaction();
			foreach($patch->getInstructions() as $instruction) {
				if ($instruction instanceof PatchAddField) {
					$class = $instruction->getClass();
					$field = $instruction->getField();
					$type = $instruction->getType();
					$mandatory = $instruction->getMandatoryAsBoolean();
					$this->addField($time, $authorId, $class, $field, $type, $mandatory);
				} else if ($instruction instanceof PatchRemoveField) {
					$class = $instruction->getClass();
					$field = $instruction->getField();
					$this->removeFieldAndArchiveRelatedValues($time, $authorId, $class, $field);
				} else if ($instruction instanceof PatchSetClassKey) {
					$class = $instruction->getClass();
					$fields = $instruction->getIDFields();
					$this->changeKey($time, $authorId, $class, $fields);
				} else if ($instruction instanceof PatchChangeFieldType) {
					$class = $instruction->getClass();
					$field = $instruction->getField();
					$type = $instruction->getTypeValue();
					$this->changeTypeAndMoveRelatedValues($time, $authorId, $class, $field, $type);
				} else if ($instruction instanceof PatchUser) {
					$authorId = $instruction->getUser();
					$hash = $instruction->getHash();
					$this->addUser($authorId);
					$this->setUserHash($authorId, $hash);
				} else {
					// TODO implement other cases
					throw new Exception("Not implemented yet: ".get_class($instruction));
				}
			}
			$this->connection->commit();
		}
	}
	
	public function addField($time, $authorId, $class, $fieldName, $type, $mandatory) {
		$property = array('class' => $class,
					'field' => $fieldName,
					'type' => $type,
					'mandatory' => $mandatory,
					'timestamp' => $time,
					'author' => $authorId);
		
		$insert = $this->connection->prepare('INSERT INTO "working_structure" (class, field, type, mandatory, timestamp, author) VALUES (:class, :field, :type, :mandatory, :timestamp, :author)');
		foreach($property as $key => $value) {
			$insert->bindParam(':'.$key, $property[$key]);
		}
		$insert->execute($property);
		$this->initMissingTable($type);
		
		$select = $this->connection->prepare('SELECT DISTINCT key FROM "working_'.$type.'" WHERE class = ?');
		$select->execute(array($class));
		$array = $select->fetchAll(PDO::FETCH_COLUMN);
		$insert = $this->connection->prepare('INSERT INTO "working_'.$type.'" (class, key, field, value, timestamp, author) VALUES (?, ?, ?, ?, ?, ?)');
		foreach($array as $key) {
			$value = null;
			$insert->execute(array($class, $key, $fieldName, $value, $time, $authorId));
		}
	}
	
	public function removeFieldAndArchiveRelatedValues($time, $authorId, $class, $fieldName) {
		$data = $this->getFieldsDataForClass($class);
		$type = $data[$fieldName]['type'];
		$this->archiveValues($time, $authorId, $type, $class, $fieldName);
		
		$source = '"working_structure" WHERE class = ? AND field = ?';
		$copy = $this->connection->prepare('INSERT INTO "archive_structure" (class, field, type, mandatory, timeCreate, authorCreate, timeArchive, authorArchive) SELECT class, field, type, mandatory, timestamp as timeCreate, author as authorCreate, '.$time.' as timeArchive, "'.$authorId.'" as authorArchive FROM '.$source);
		$clean = $this->connection->prepare('DELETE FROM '.$source);
		$copy->execute(array($class, $fieldName));
		$clean->execute(array($class, $fieldName));
	}
	
	public function changeKey($time, $authorId, $class, $newFields) {
		$source = '"working_key" WHERE class = ?';
		$copy = $this->connection->prepare('INSERT INTO "archive_key" (class, field, timeCreate, authorCreate, timeArchive, authorArchive) SELECT class, field, timestamp as timeCreate, author as authorCreate, '.$time.' as timeArchive, "'.$authorId.'" as authorArchive FROM '.$source);
		$clean = $this->connection->prepare('DELETE FROM '.$source);
		$copy->execute(array($class));
		$clean->execute(array($class));
		
		$insert = $this->connection->prepare('INSERT INTO "working_key" (class, field, timestamp, author) VALUES (:class, :field, :timestamp, :author)');
		foreach($newFields as $name) {
			$insert->execute(array($class, $name, $time, $authorId));
		}
	}
	
	public function changeTypeAndMoveRelatedValues($time, $authorId, $class, $fieldName, $newType) {
		// retrieve the current property data
		// TODO use getFieldsDataForClass()
		$select = $this->connection->prepare('SELECT * FROM "working_structure" WHERE class = ? AND field = ?');
		$select->execute(array($class, $fieldName));
		$property = $select->fetch(PDO::FETCH_ASSOC);
		$oldType = $property['type'];
		
		if ($oldType == $newType) {
			throw new Exception("The type for $class.$fieldName is already $newType");
		} else {
			// archive the current property
			$source = '"working_structure" WHERE class = ? AND field = ?';
			$copy = $this->connection->prepare('INSERT INTO "archive_structure" (class, field, type, mandatory, timeCreate, authorCreate, timeArchive, authorArchive) SELECT class, field, type, mandatory, timestamp as timeCreate, author as authorCreate, '.$time.' as timeArchive, "'.$authorId.'" as authorArchive FROM '.$source);
			$clean = $this->connection->prepare('DELETE FROM '.$source);
			$copy->execute(array($class, $fieldName));
			$clean->execute(array($class, $fieldName));
			
			// create the updated property
			$property['type'] = $newType;
			$property['timestamp'] = $time;
			$property['author'] = $authorId;
			$insert = $this->connection->prepare('INSERT INTO "working_structure" (class, field, type, mandatory, timestamp, author) VALUES (:class, :field, :type, :mandatory, :timestamp, :author)');
			foreach($property as $key => $value) {
				$insert->bindParam(':'.$key, $property[$key]);
			}
			$insert->execute($property);
			
			// retrieve the obsolete values
			$select = $this->connection->prepare('SELECT key, value FROM "working_'.$oldType.'" WHERE class = ? AND field = ?');
			$select->execute(array($class, $fieldName));
			$array = $select->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
			
			// archive the obsolete values
			$this->archiveValues($time, $authorId, $oldType, $class, $fieldName);
			
			// save the new values
			$update = $this->connection->prepare('INSERT INTO "working_'.$newType.'" (class, key, field, value, timestamp, author) VALUES (?, ?, ?, ?, ?, ?)');
			foreach($array as $key => $values) {
				$value = $values[0];
				$update->execute(array($class, $key, $fieldName, $value, $time, $authorId));
			}
		}
	}
	
	public function getClasses() {
		$statement = $this->connection->prepare('SELECT DISTINCT class FROM "working_structure"');
		$statement->execute(array());
		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}
	
	public function getFields($class, $addMetadata = false) {
		$fields = $this->getFieldsDataForClass($class);
		if ($addMetadata) {
			// let the full array
		} else {
			$reduced = array();
			foreach($fields as $field => $data) {
				$reduced[] = $field;
			}
			$fields = $reduced;
		}
		return $fields;
	}
	
	private function getFieldsDataForClass($class, $exceptionIfUnknown = true) {
		// TODO move to getFields()
		$statement = $this->connection->prepare('SELECT field, type, mandatory, timestamp, author FROM "working_structure" WHERE class = ?');
		$statement->execute(array($class));
		$fields = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
		if ($exceptionIfUnknown && empty($fields)) {
			throw new Exception("No known structure for $class");
		} else {
			foreach($fields as $field => $array) {
				$array = $array[0];
				settype($array['mandatory'], 'boolean');
				settype($array['timestamp'], 'integer');
				$fields[$field] = $array;
			}
			return $fields;
		}
	}
	
	public function getIDFieldsForClass($class) {
		$statement = $this->connection->query('SELECT field FROM "working_key" WHERE class = "'.$class.'"');
		$fields = $statement->fetchAll(PDO::FETCH_COLUMN);
		return $fields;
	}
	
	public function isUpdatedStructure(PersistentComponent $component) {
		return !$this->getStructureDiff($component)->isEmpty();
	}
	
	public function getStructureDiff(PersistentComponent $component) {
		$class = $component->getClass();
		$fields = $this->getFieldsDataForClass($class, false);
		$diff = new StructureDiff();
		foreach($component->getPersistentFields() as $name => $field) {
			$type = $field->getTranslator()->getPersistentType($field)->getType();
			$mandatory = $field->isMandatory();
			
			if (!array_key_exists($name, $fields)) {
				$diff->addDiff(new AddFieldDiff($class, $name, $type, $mandatory));
			} else {
				$property = $fields[$name];
				unset($fields[$name]);
				if ($property['type'] != $type) {
					$diff->addDiff(new ChangeTypeDiff($class, $name, $property['type'], $type));
				} else if ($property['mandatory'] != $mandatory) {
					$diff->addDiff(new ChangeMandatoryDiff($class, $name, $property['mandatory'], $mandatory));
				} else {
					// no modification, do not add a diff
				}
			}
		}
		
		foreach($fields as $name => $property) {
			$diff->addDiff(new RemoveFieldDiff($class, $name, $property['type'], $property['mandatory']));
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
		$statement = $this->connection->prepare('SELECT COUNT(field) FROM "working_structure" WHERE class = ?');
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
		$statement = $this->connection->query('SELECT DISTINCT type FROM "working_structure" UNION SELECT DISTINCT type FROM "archive_structure" ');
		$types = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
		return $types;
	}
	
	private function getTypesForClass($class) {
		$types = array();
		foreach($this->getFieldsDataForClass($class) as $field => $array) {
			$types[$field] = $array['type'];
		}
		return $types;
	}
	
	/********************************************\
	                    RECORDS
	\********************************************/
	public function save(PersistentComponent $component, $authorId) {
		if (!$this->isRegisteredUser($authorId)) {
			throw new Exception("There is no user ".$authorId);
		} else {
			$class = $component->getClass();
			$savedFields = $this->getFieldsDataForClass($class);
			
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
					$value = $translator->getPersistentValue($field);
					if ($isNew || $savedValues[$name] !== "".$value /*$savedValues only contains strings*/) {
						$type = $field->getTranslator()->getPersistentType($field)->getType();
						
						if (!$isNew) {
							$this->archiveValues($time, $authorId, $type, $class, $name, array($key));
						}
						$statement = $this->connection->prepare('INSERT INTO "working_'.$type.'" (class, key, field, value, timestamp, author) VALUES (?, ?, ?, ?, ?, ?)');
						$statement->execute(array($class, $key, $name, $value, $time, $authorId));
						
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
	
	public function getRecordsForClass($class, $addMetadata = false) {
		$keys = array();
		foreach($this->getExistingTypes() as $type) {
			$statement = $this->connection->prepare('SELECT DISTINCT key FROM "working_'.$type.'" WHERE class = ?');
			$statement->execute(array($class));
			foreach($statement->fetchAll(PDO::FETCH_COLUMN) as $key) {
				$keys[] = $key;
			}
		}
		return $this->getSavedValuesFor($keys, $addMetadata);
	}
	
	private function getSavedValuesFor($keys, $addMetadata = false) {
		if (!is_array($keys)) {
			$records = $this->getSavedValuesFor(array($keys), $addMetadata);
			return $records[$keys];
		} else {
			$records = array();
			foreach($keys as $key) {
				$records[$key] = array();
				$class = null;
				foreach($this->getExistingTypes() as $type) {
					$statement = $this->connection->prepare('SELECT DISTINCT class FROM "working_'.$type.'" WHERE key = ?');
					$statement->execute(array($key));
					$class = $statement->fetchColumn();
					if ($class === null) {
						continue;
					} else {
						break;
					}
				}
				$fields = $this->getFields($class, true);
				foreach($fields as $field => $data) {
					$type = $data['type'];
					$statement = $this->connection->prepare('SELECT value, timestamp, author FROM "working_'.$type.'" WHERE key = ? AND field  = ?');
					$statement->execute(array($key, $field));
					foreach($statement->fetchAll() as $array) {
						$temp = array();
						if ($addMetadata) {
							$temp['value'] = $array['value'];
							$temp['timestamp'] = $array['timestamp'];
							$temp['author'] = $array['author'];
						} else {
							$temp = $array['value'];
						}
					}
					$records[$key][$field] = $temp;
				}
			}
			return $records;
		}
		}
		
	private function getArchivedValuesFor($keys, $addMetadata = false) {
		if (!is_array($keys)) {
			$records = $this->getArchivedValuesFor(array($keys), $addMetadata);
			return $records[$keys];
		} else {
		$records = array();
		foreach($keys as $key) {
			$records[$key] = array();
				$class = null;
			foreach($this->getExistingTypes() as $type) {
					$statement = $this->connection->prepare('SELECT DISTINCT class FROM "archive_'.$type.'" WHERE key = ?');
				$statement->execute(array($key));
					$class = $statement->fetchColumn();
					if ($class === null) {
						continue;
					} else {
						break;
					}
				}
				$fields = $this->getFields($class, true);
				foreach($fields as $field => $data) {// TODO consider also the archived fields
					$type = $data['type'];
					$statement = $this->connection->prepare('SELECT value, timeCreate, authorCreate, timeArchive, authorArchive FROM "archive_'.$type.'" WHERE key = ? AND field  = ?');
					$statement->execute(array($key, $field));
				foreach($statement->fetchAll() as $array) {
						$temp = array();
					if ($addMetadata) {
							$temp['value'] = $array['value'];
							$temp['timeCreate'] = $array['timeCreate'];
							$temp['authorCreate'] = $array['authorCreate'];
							$temp['timeArchive'] = $array['timeArchive'];
							$temp['authorArchive'] = $array['authorArchive'];
					} else {
							$temp = $array['value'];
					}
						$records[$key][$field][] = $temp;
				}
			}
		}
		return $records;
	}
	}
	
	public function load(PersistentComponent $component) {
		$this->checkStructureIsWellKnown($component);
		$class = $component->getClass();
		
		$key = $component->getInternalKey();
		if (empty($key)) {
			throw new Exception("No key has been assigned to the component $component");
		}
		$savedValues = $this->getSavedValuesFor($key);
		foreach($component->getPersistentFields() as $name => $field) {
			if (!array_key_exists($name, $savedValues)) {
				throw new Exception("No field $name for the component $component");
			} else {
				$translator = $field->getTranslator();
				$translator->setPersistentValue($field, $savedValues[$name]);
				unset($savedValues[$name]);
			}
		}
		if (!empty($savedValues)) {
			throw new Exception("Saved field(s) not used for the component $component: ".implode(", ", array_keys($savedValues)));
		}
	}
	
	public function loadAll($class) {
		$reflector = new ReflectionClass($class);
		$this->checkStructureIsWellKnown($reflector->newInstance());
		
		$statement = $this->connection->query('SELECT type FROM "working_structure" WHERE class = ?');
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
	
	public function delete(PersistentComponent $component, $authorId) {
		if (!$this->isRegisteredUser($authorId)) {
			throw new Exception("There is no user ".$authorId);
		} else {
			$class = $component->getClass();
			$key = $component->getInternalKey();
			if (empty($key)) {
				throw new Exception("Cannot delete $component, it is not linked to an existing record");
			} else {
				$savedFields = $this->getFieldsDataForClass($class);
				$time = time();
				$this->connection->beginTransaction();
				foreach($savedFields as $field => $metadata) {
					$this->archiveValues($time, $authorId, $metadata['type'], $class, $field, array($key));
				}
				$this->connection->commit();
			}
		}
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
	
	public function createProperty($id) {
		if ($this->hasProperty($id)) {
			throw new Exception($id." alredy exists as a property.");
		} else {
			$this->connection->exec('UPDATE "property" ADD (name, value) ("'.$id.'", null)');
		}
	}
	
	public function hasProperty($id) {
		return $this->connection->query('SELECT COUNT(*) FROM "property" WHERE name = "'.$id.'"')->fetchColumn() > 0;
	}
	
	public function setProperty($id, $value) {
		if (!$this->hasProperty($id)) {
			throw new Exception($id." is not an existing property.");
		} else {
			$this->connection->exec('UPDATE "property" SET value = "'.$value.'" WHERE name = "'.$id.'"');
		}
	}
	
	public function getProperty($id) {
		if (!$this->hasProperty($id)) {
			throw new Exception($id." is not an existing property.");
		} else {
			return $this->connection->query('SELECT value FROM "property" WHERE name = "'.$id.'"')->fetchColumn();
		}
	}
	
	public function getProperties() {
		$statement = $this->connection->prepare('SELECT name FROM "property"');
		$statement->execute(array());
		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}
	
	public function clear() {
		foreach($this->getTableNames() as $name) {
			$this->connection->exec('DROP TABLE "'.$name.'"');
		}
	}
	
	private function archiveValues($time, $author, $type, $class, $field, $keys = null) {
		$archiveAll = $keys === null;
		
		$source = '"working_'.$type.'" WHERE class = ? AND field = ?';
		if (!$archiveAll) {
			$source .= ' AND key = ?';
		}
		$copy = $this->connection->prepare('INSERT INTO "archive_'.$type.'" (class, key, field, value, timeCreate, authorCreate, timeArchive, authorArchive) SELECT class, key, field, value, timestamp as timeCreate, author as authorCreate, '.$time.' as timeArchive, "'.$author.'" as authorArchive FROM '.$source);
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
			$statement = $this->connection->prepare('SELECT type FROM "working_structure" WHERE class = ? AND field = ?');
			$statement->execute(array($class, $name));
			$type = $statement->fetchColumn();
			
			$statement = $this->connection->prepare('SELECT key FROM "working_'.$type.'" WHERE class = ? AND field = ? AND value = ?');
			$value = $field->getTranslator()->getPersistentValue($field);
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