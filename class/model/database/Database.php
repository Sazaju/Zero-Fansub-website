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
	private $checker = null;
	
	public function __construct($driver = 'sqlite', $database = 'database', $host = 'localhost', $user = 'admin', $password = null) {
		$this->initChecker();
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
	
	private function initChecker() {
		$this->checker = new Checker();
		$db = $this;
		$this->checker->registerCallbacks('propertyDoesNotExist',
			function($name) use ($db) {return !$db->hasProperty($name);},
			function($name) {return "There is already a property '$name'.";}
		);
		$this->checker->registerCallbacks('propertyExists',
			function($name) use ($db) {return $db->hasProperty($name);},
			function($name) {return "There is no property '$name'.";}
		);
		$this->checker->registerCallbacks('knowsClass',
			function($class) use ($db) {return $db->isKnownClass($class);},
			function($class) {return "'$class' is not a known class.";}
		);
		$this->checker->registerCallbacks('doesNotKnowClass',
			function($class) use ($db) {return !$db->isKnownClass($class);},
			function($class) {return "'$class' is already a known class.";}
		);
		$this->checker->registerCallbacks('knowsUser',
			function($name) use ($db) {return $db->isKnownUser($name);},
			function($name) {return "'$name' is not a known user.";}
		);
		$this->checker->registerCallbacks('doesNotKnowUser',
			function($name) use ($db) {return !$db->isKnownUser($name);},
			function($name) {return "'$name' is already a known user.";}
		);
		$this->checker->registerCallbacks('isFunction',
			function($arg) {return is_callable($arg);},
			function($arg) {return "The argument is not a function.";}
		);
		$this->checker->registerCallbacks('isNotFunction',
			function($arg) {return !is_callable($arg);},
			function($arg) {return "The argument is a function.";}
		);
		$this->checker->registerCallbacks('isIdBasedData',
			function($data) {$keys = array_keys($data);return is_int($keys[0]);},
			function($data) {return "The data is not based on IDs.";}
		);
		$this->checker->registerCallbacks('isNotIdBasedData',
			function($data) {$keys = array_keys($data);return is_string($keys[0]);},
			function($data) {return "The data is based on IDs.";}
		);
	}
	
	private function initDatabase() {
		$c = $this->connection;
		$checkExistence = function($table) use ($c) {$c->prepare('SELECT * FROM "'.$table.'" LIMIT 1');};
		
		try {
			$checkExistence('property');
		} catch(PDOException $ex) {
			$this->connection->exec('CREATE TABLE "property" (
				name     VARCHAR(128) NOT NULL,
				value    VARCHAR(128),
				
				PRIMARY KEY (name)
			)');
			$this->createProperty('lastId', '0');
			$this->createProperty('recordTypes', '|');
		}
		
		try {
			$checkExistence('user');
		} catch(PDOException $ex) {
			$this->connection->exec('CREATE TABLE "user" (
				id       INTEGER NOT NULL,
				name     VARCHAR(128) NOT NULL,
				passhash CHAR(34),
				
				UNIQUE (name),
				PRIMARY KEY (id)
			)');
			$this->addUser('admin');
			$this->setUserPassword('admin', 'admin');
		}
		
		foreach(array('class', 'field', 'key') as $type) {
			$t = new PersistentTable($type);
			foreach(array(false, true) as $archiveMode) {
				$t->setArchiveMode($archiveMode);
				try {
					$checkExistence($t->getName());
				} catch(PDOException $ex) {
					$this->connection->exec($t->getCreationScript());
				}
			}
		}
	}
	
	private function initMissingTable($type) {
		$type = $type instanceof PersistentType ? $type->getType() : $type;
		$t = new PersistentTable($type);
		foreach(array(false, true) as $archiveMode) {
			$t->setArchiveMode($archiveMode);
			$this->connection->exec($t->getCreationScript(true));
		}
		
		$types = $this->getProperty('recordTypes');
		if (strpos($types, "|$type|") === false) {
			$this->setProperty('recordTypes', $types.$type.'|');
		} else {
			// do not insert another time
		}
	}
	
	/**********************************\
	             GENERAL
	\**********************************/
	
	public function setCheckerActivity($boolean) {
		$this->checker->setActivated($boolean);
	}
	
	public function isCheckerActivited() {
		return $this->checker->isActivated();
	}
	
	private function getNewDatabaseId() {
		$id = $this->getProperty('lastId');
		settype($id, 'int');
		$id++;
		$this->setProperty('lastId', $id);
		return $id;
	}
	
	private function formatQueryConditions($constraints, &$args = array()) {
		$this->checker->checkIsArray($constraints);
		$this->checker->checkIsArray($args);
		
		$conditions = '';
		foreach($constraints as $field => $value) {
			if (is_scalar($value)) {
				$conditions .= ' AND '.$field.' = ?';
				$args[] = $value;
			} else if (is_array($value)) {
				$conditions .= ' AND '.$field.' IN ('.Format::arrayToString(array_map(function($a) {return '?';}, $value)).')';
				$args = array_merge($args, array_values($value));
			} else {
				throw new Exception(gettype($value)." objects are not managed.");
			}
		}
		return substr($conditions, strlen(' AND '));
	}
	
	private function setWorkingValue($id, $field, $value, $timestamp, $authorId, $type, $constraints = array()) {
		$this->checker->checkIsNotEmpty($id);
		$this->checker->checkIsNotEmpty($field);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		$this->checker->checkIsNotEmpty($type);
		$this->checker->checkIsArray($constraints);
		
		$args = array($value);
		$constraints = array_merge(array('id' => $id), $constraints);
		$conditions = $this->formatQueryConditions($constraints, $args);
		
		$update = $this->connection->prepare('UPDATE "working_'.$type.'" SET '.$field.' = ? WHERE '.$conditions);
		$update->execute($args);
		
		$update = $this->connection->prepare('UPDATE "working_'.$type.'" SET timestamp = ? WHERE '.$conditions);
		$args[0] = $timestamp;
		$update->execute($args);
		
		$update = $this->connection->prepare('UPDATE "working_'.$type.'" SET author_id = ? WHERE '.$conditions);
		$args[0] = $authorId;
		$update->execute($args);
	}
	
	private function copyInArchive($id, $timestamp, $authorId, $type, $columns, $constraints = array()) {
		$this->checker->checkIsNotEmpty($id);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		$this->checker->checkIsNotEmpty($type);
		$this->checker->checkIsArray($constraints);
		$this->checker->checkIsArray($columns);
		
		$columns = Format::arrayToString($columns);
		$args = array();
		$constraints = array_merge(array('id' => $id), $constraints);
		$conditions = $this->formatQueryConditions($constraints, $args);
		$archive = $this->connection->prepare('INSERT INTO "archive_'.$type.'" (id, '.$columns.', timeCreate, authorCreate_id, timeArchive, authorArchive_id) SELECT id, '.$columns.', timestamp as timeCreate, author_id as authorCreate_id, '.$timestamp.' as timeArchive, '.$authorId.' as authorArchive_id FROM "working_'.$type.'" WHERE '.$conditions);
		$archive->execute($args);
	}
	
	public function clear() {
		$tables = array("property", "user");
		$types = array_merge(array('class', 'field', 'key'), $this->getDbTypes());
		foreach($types as $type) {
			$tables[] = "working_$type";
			$tables[] = "archive_$type";
		}
		foreach($tables as $table) {
			$this->connection->exec('DROP TABLE "'.$table.'"');
		}
	}
	
	private function createRandomSalt() {
		$salt = '';
		for($i = 0 ; $i < 2 ; $i ++) {
			$salt .= chr(rand(32, 126));
		}
		return $salt;
	}
	
	private function generateSaltedHash($password, $salt) {
		$this->checker->checkIsNotEmpty($password);
		$this->checker->checkIsNotEmpty($salt);
		
		return $salt.md5($salt.$password);
	}
	
	private function getDbTypes() {
		$list = explode('|', $this->getProperty('recordTypes'));
		$list = array_filter($list);
		return $list;
	}
	
	private function mapDbTypeToPhpType($type) {
		if ($type == 'boolean') {
			return 'bool';
		} else if ($type == 'integer') {
			return 'int';
		} else if ($type == 'double') {
			return 'float';
		} else if (strpos($type, 'string') === 0) {
			return 'string';
		} else {
			throw new Exception("'$type' is not a managed type.");
		}
	}
	
	/**********************************\
	        PROPERTIES - SINGLE
	\**********************************/
	
	public function hasProperty($name) {
		return $this->connection->query('SELECT COUNT(*) FROM "property" WHERE name = "'.$name.'"')->fetchColumn() > 0;
	}
	
	public function createProperty($name, $value = null) {
		$this->checker->checkPropertyDoesNotExist($name);
		
		$statement = $this->connection->prepare('INSERT INTO "property" (name, value) VALUES (?, ?)');
		$statement->execute(array($name, $value));
	}
	
	public function setProperty($name, $value) {
		$this->checker->checkPropertyExists($name);
		
		$this->connection->exec('UPDATE "property" SET value = "'.$value.'" WHERE name = "'.$name.'"');
	}
	
	public function getProperty($name) {
		$this->checker->checkPropertyExists($name);
		
		return $this->connection->query('SELECT value FROM "property" WHERE name = "'.$name.'"')->fetchColumn();
	}
	
	/**********************************\
	       PROPERTIES - MULTIPLE
	\**********************************/
	
	public function getPropertyNames() {
		return $this->connection->query('SELECT name FROM "property"')->fetchAll(PDO::FETCH_COLUMN);
	}
	
	/**********************************\
	          USERS - SINGLE
	\**********************************/
	
	public function addUser($name) {
		$this->checker->checkDoesNotKnowUser($name);
		
		$statement = $this->connection->prepare('INSERT INTO "user" (id, name, passhash) VALUES (?, ?, NULL)');
		$statement->execute(array($this->getNewDatabaseId(), $name));
	}
	
	public function setUserName($oldName, $newName) {
		$this->checker->checkKnowsUser($oldName);
		
		$statement = $this->connection->prepare('UPDATE "user" SET name = ? WHERE name = ?');
		$statement->execute(array($newName, $oldName));
	}
	
	private function getUserId($name) {
		$this->checker->checkKnowsUser($name);
		
		$statement = $this->connection->prepare('SELECT id FROM "user" WHERE name = ?');
		$statement->execute(array($name));
		return $statement->fetchColumn();
	}
	
	private function getUserFromId($userId) {
		$this->checker->checkIsNotEmpty($userId);
		
		$statement = $this->connection->prepare('SELECT name FROM "user" WHERE id = ?');
		$statement->execute(array($userId));
		return $statement->fetchColumn();
	}
	
	public function isKnownUser($name) {
		$statement = $this->connection->prepare('SELECT count(*) FROM "user" WHERE name = ?');
		$statement->execute(array($name));
		$counter = $statement->fetchColumn();
		return $counter > 0;
	}
	
	public function isIdentifiableUser($name) {
		$statement = $this->connection->prepare('SELECT count(*) FROM "user" WHERE name = ? AND passhash NOT NULL');
		$statement->execute(array($name));
		$counter = $statement->fetchColumn();
		return $counter > 0;
	}
	
	private function setUserHash($name, $hash) {
		$this->checker->checkKnowsUser($name);
		
		$statement = $this->connection->prepare('UPDATE "user" SET passhash = ? WHERE name = ?');
		$statement->execute(array($hash, $name));
	}
	
	public function setUserPassword($name, $password) {
		$this->checker->checkKnowsUser($name);
		
		$hash = $password != null ? $this->generateSaltedHash($password, $this->createRandomSalt()) : null;
		$this->setUserHash($name, $hash);
	}
	
	public function isValidUserPassword($name, $password) {
		$this->checker->checkIsNotEmpty($name);
		$this->checker->checkIsNotEmpty($password);
		
		$statement = $this->connection->prepare('SELECT passhash FROM "user" WHERE name = ?');
		$statement->execute(array($name));
		$saltedhash = $statement->fetchColumn();
		$salt = substr($saltedhash, 0, 2);
		return $this->generateSaltedHash($password, $salt) === $saltedhash;
	}
	
	/**********************************\
	         USERS - MULTIPLE
	\**********************************/
	
	public function getUsers() {
		return $this->connection->query('SELECT name FROM "user"')->fetchAll(PDO::FETCH_COLUMN);
	}
	
	/**********************************\
	         CLASSES - SINGLE
	\**********************************/
	
	private function addClass($class, $timestamp, $authorId) {
		$this->checker->checkIsNotEmpty($class);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		
		$statement = $this->connection->prepare('INSERT INTO "working_class" (id, class, timestamp, author_id) VALUES (?, ?, ?, ?)');
		$statement->execute(array($this->getNewDatabaseId(), $class, $timestamp, $authorId));
	}
	
	public function isKnownClass($class) {
		if (is_object($class)) {
			$class = get_class($class);
		} else if (is_string($class)) {
			// considered as the name of the class, let as is
		} else {
			throw new Exception("'$class' cannot be interpreted as an object or its class name");
		}
		return in_array($class, $this->getClasses());
	}
	
	private function getClass($classId) {
		$this->checker->checkIsNotEmpty($classId);
		
		$statement = $this->connection->prepare('SELECT class FROM "working_class" WHERE id = ?');
		$statement->execute(array($classId));
		return $statement->fetchColumn();
	}
	
	private function getClassId($class) {
		$this->checker->checkKnowsClass($class);
		
		$statement = $this->connection->prepare('SELECT id FROM "working_class" WHERE class = ?');
		$statement->execute(array($class));
		return $statement->fetchColumn();
	}
	
	private function copyClassInArchive($classId, $timestamp, $authorId) {
		$this->copyInArchive($classId, $timestamp, $authorId, 'class', array('class'));
	}
	
	private function setClassName($classId, $name, $timestamp, $authorId) {
		$this->copyClassInArchive($classId, $timestamp, $authorId);
		$this->setWorkingValue($classId, 'class', $name, $timestamp, $authorId, 'class');
	}
	
	private function deleteClass($classId, $timestamp, $authorId) {
		$this->checker->checkIsNotEmpty($classId);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		
		foreach($this->getKeyIds($classId) as $keyId) {
			$this->deleteKey($keyId, $timestamp, $authorId);
		}
		
		foreach($this->getFieldIds($classId) as $fieldId) {
			$this->deleteField($fieldId, $timestamp, $authorId);
		}
		
		$this->copyClassInArchive($classId, $timestamp, $authorId);
		$clean = $this->connection->prepare('DELETE FROM "working_class" WHERE id = ?');
		$clean->execute(array($classId));
	}
	
	/**********************************\
	        CLASSES - MULTIPLE
	\**********************************/
	
	public function getClasses() {
		return $this->connection->query('SELECT class FROM "working_class"')->fetchAll(PDO::FETCH_COLUMN);
	}
	
	public function getClassesMetadata($class = null) {
		$classIds = array();
		foreach($this->getClasses() as $class) {
			$classIds[$class] = $this->getClassId($class);
		}
		$metadata = array();
		if (empty($classIds)) {
			// no data to retrieve
		} else {
			foreach($this->getClassIdsMetadata($classIds) as $classId => $meta) {
				$metadata[$class] = $meta;
			}
		}
		return $metadata;
	}
	
	private function getClassIdsMetadata($classIds) {
		$this->checker->checkIsNotEmpty($classIds);
		$this->checker->checkIsArray($classIds);
		
		$diff = array_diff($classIds, array_filter($classIds));
		if(empty($classIds) || !empty($diff)) {
			throw new Exception("(".Format::arrayToString($classIds).") is not a valid set of class IDs.");
		} else {
			$args = array();
			$statement = $this->connection->prepare('SELECT id, class, timestamp, author_id FROM "working_class" WHERE '.$this->formatQueryConditions(array('id' => $classIds), $args));
			$statement->execute($args);
			$metadata = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
			foreach($metadata as $classId => $meta) {
				$meta = $meta[0];
				settype($meta['timestamp'], 'int');
				$meta['author'] = $this->getUserFromId($meta['author_id']);
				unset($meta['author_id']);
				$metadata[$classId] = $meta;
			}
			return $metadata;
		}
	}
	
	/**********************************\
	          FIELDS - SINGLE
	\**********************************/
	
	private function addField($classId, $field, $type, $mandatory, $timestamp, $authorId, $valueCallback = null) {
		$this->checker->checkIsNotEmpty($classId);
		$this->checker->checkIsNotEmpty($field);
		$this->checker->checkIsNotEmpty($type);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		
		$this->initMissingTable($type);
		$fieldId = $this->getNewDatabaseId();
		$statement = $this->connection->prepare('INSERT INTO "working_field" (id, class_id, field, type, mandatory, timestamp, author_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
		$statement->execute(array($fieldId, $classId, $field, $type, $mandatory, $timestamp, $authorId));
		
		$valueCallback = $valueCallback === null ? function($id) {return null;} : $valueCallback;
		$this->completeAllRecords($fieldId, $valueCallback, $timestamp, $authorId);
	}
	
	private function getField($fieldId) {
		$this->checker->checkIsNotEmpty($fieldId);
		
		$statement = $this->connection->prepare('SELECT field FROM "working_field" WHERE id = ?');
		$statement->execute(array($fieldId));
		return $statement->fetchColumn();
	}
	
	private function getFieldId($classId, $field) {
		$this->checker->checkIsNotEmpty($classId);
		$this->checker->checkIsNotEmpty($field);
		
		$statement = $this->connection->prepare('SELECT id FROM "working_field" WHERE class_id = ? AND field = ?');
		$statement->execute(array($classId, $field));
		return $statement->fetchColumn();
	}
	
	private function getFieldClassId($fieldId) {
		$this->checker->checkIsNotEmpty($fieldId);
		
		$statement = $this->connection->prepare('SELECT class_id FROM "working_field" WHERE id = ?');
		$statement->execute(array($fieldId));
		$result = $statement->fetchColumn();
		return $result;
	}
	
	private function getFieldType($fieldId) {
		$this->checker->checkIsNotEmpty($fieldId);
		
		$types = $this->getFieldTypes(array($fieldId));
		return $types[$fieldId];
	}
	
	private function getFieldValues($fieldId) {
		$this->checker->checkIsNotEmpty($fieldId);
		
		$type = $this->getFieldType($fieldId);
		$statement = $this->connection->prepare('SELECT id, value FROM "working_'.$type.'" WHERE field_id = ?');
		$statement->execute($fieldId);
		$result = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP|PDO::FETCH_COLUMN);
		$result = array_map(function($a) {return $a[0];}, $result);
		return $result;
	}
	
	private function copyFieldInArchive($fieldId, $timestamp, $authorId) {
		$this->copyInArchive($fieldId, $timestamp, $authorId, 'field', array('class_id', 'field', 'type', 'mandatory'));
	}
	
	private function setFieldName($fieldId, $name, $timestamp, $authorId) {
		$this->copyFieldInArchive($fieldId, $timestamp, $authorId);
		$this->setWorkingValue($fieldId, 'field', $name, $timestamp, $authorId, 'field');
	}
	
	private function setFieldType($fieldId, $type, $timestamp, $authorId) {
		$values = $this->getFieldValues($fieldId);
		$this->clearRecords($fieldId, $timestamp, $authorId);
		
		$this->copyFieldInArchive($fieldId, $timestamp, $authorId);
		$this->setWorkingValue($fieldId, 'type', $type, $timestamp, $authorId, 'field');
		
		$this->completeAllRecords($fieldId, function($id) use ($values) {return $values[$id];}, $timestamp, $authorId);
	}
	
	private function deleteField($fieldId, $timestamp, $authorId) {
		$this->checker->checkIsNotEmpty($fieldId);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		
		$keyIds = $this->getKeyIdsUsing(array($fieldId));
		if (empty($keyIds)) {
			// no key is using this field, so we can delete
		} else {
			throw new Exception("At least one key uses the field '$fieldId', you cannot delete it.");
		}
		
		$this->clearRecords($fieldId, $timestamp, $authorId);
		
		$this->copyFieldInArchive($fieldId, $timestamp, $authorId);
		$clean = $this->connection->prepare('DELETE FROM "working_field" WHERE id = ?');
		$clean->execute(array($fieldId));
	}
	
	/**********************************\
	         FIELDS - MULTIPLE
	\**********************************/
	
	public function getFieldsForClass($class) {
		$this->checker->checkKnowsClass($class);
		
		$statement = $this->connection->prepare('SELECT field FROM "working_field" WHERE class_id = ?');
		$statement->execute(array($this->getClassId($class)));
		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}
	
	private function getFieldsForIds($fieldIds) {
		$this->checker->checkIsNotEmpty($fieldIds);
		$this->checker->checkIsArray($fieldIds);
		
		$statement = $this->connection->prepare('SELECT id, field FROM "working_field" WHERE '.$this->formatQueryConditions(array('id' => $fieldIds)));
		$statement->execute(array_values($fieldIds));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP|PDO::FETCH_COLUMN);
		$result = array_map(function($a) {return $a[0];}, $result);
		return $result;
	}
	
	private function getFieldIds($classId, $fields = null) {
		$this->checker->checkIsNotEmpty($classId);
		
		$args = array();
		$constraints = array('class_id' => $classId);
		if ($fields === null) {
			// do not constraint the fields to get all of them.
		} else {
			$constraints['field'] = $fields;
		}
		$statement = $this->connection->prepare('SELECT field, id FROM "working_field" WHERE '.$this->formatQueryConditions($constraints, $args));
		$statement->execute($args);
		$result = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP|PDO::FETCH_COLUMN);
		$result = array_map(function($a) {return (int) $a[0];}, $result);
		return $result;
	}
	
	private function getMandatoryFieldIds($classId) {
		$this->checker->checkIsNotEmpty($classId);
		
		$statement = $this->connection->prepare('SELECT id FROM "working_field" WHERE class_id = ? AND mandatory = ?');
		$statement->execute(array($classId, true));
		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}
	
	private function getFieldTypes($fieldIds) {
		$this->checker->checkIsNotEmpty($fieldIds);
		$this->checker->checkIsArray($fieldIds);
		
		$metadata = $this->getFieldIdsMetadata($fieldIds);
		foreach($metadata as $fieldId => $array) {
			$metadata[$fieldId] = $array['type'];
		}
		
		$fieldIds = array_diff($fieldIds, array_keys($metadata));
		if (empty($fieldIds)) {
			// all fields have been retrieved, ignore the following steps
		} else {
			$metadata2 = $this->getFieldIdsArchivedMetadata($fieldIds);
			foreach($metadata2 as $fieldId => $versions) {
				$typeRef = null;
				$timeRef = 0;
				foreach($versions as $array) {
					if ($array['timeCreate'] > $timeRef) {
						$typeRef = $array['type'];
					} else {
						// keep the current one which is more recent
					}
				}
				$metadata[$fieldId] = $typeRef;
			}
		}
		
		return $metadata;
	}
	
	public function getFieldsMetadata($class, $fields = null) {
		$classId = $this->getClassId($class);
		$fieldIds = $this->getFieldIds($classId, $fields);
		$metadata = $this->getFieldIdsMetadata($fieldIds);
		return $this->mapDataToFields($metadata);
	}
	
	private function getFieldIdsMetadata($fieldIds) {
		$this->checker->checkIsNotEmpty($fieldIds);
		$this->checker->checkIsArray($fieldIds);
		
		$diff = array_diff($fieldIds, array_filter($fieldIds));
		if(empty($fieldIds) || !empty($diff)) {
			throw new Exception("(".Format::arrayToString($fieldIds).") is not a valid set of field IDs.");
		} else {
			$args = array();
			$statement = $this->connection->prepare('SELECT id, field, type, mandatory, timestamp, author_id FROM "working_field" WHERE '.$this->formatQueryConditions(array('id' => $fieldIds), $args));
			$statement->execute($args);
			$metadata = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
			foreach($metadata as $fieldId => $meta) {
				$meta = $meta[0];
				settype($meta['mandatory'], 'bool');
				settype($meta['timestamp'], 'int');
				$meta['author'] = $this->getUserFromId($meta['author_id']);
				unset($meta['author_id']);
				$metadata[$fieldId] = $meta;
			}
			return $metadata;
		}
	}
	
	private function mapDataToFieldIds($classId, $fieldData) {
		$this->checker->checkIsNotEmpty($classId);
		$this->checker->checkIsNotEmpty($fieldData);
		$this->checker->checkIsArray($fieldData);
		$this->checker->checkIsNotIdBasedData($fieldData);
		
		$idBased = array();
		$fields = array_keys($fieldData);
		$fieldIds = $this->getFieldIds($classId, $fields);
		foreach($fieldData as $field => $value) {
			$fieldId = $fieldIds[$field];
			$idBased[$fieldId] = $value;
		}
		return $idBased;
	}
	
	private function mapDataToFields($fieldData) {
		$this->checker->checkIsNotEmpty($fieldData);
		$this->checker->checkIsArray($fieldData);
		$this->checker->checkIsIdBasedData($fieldData);
		
		$fieldBased = array();
		$fieldIds = array_keys($fieldData);
		$fields = $this->getFieldsForIds($fieldIds);
		foreach($fieldData as $fieldId => $value) {
			$field = $fields[$fieldId];
			$fieldBased[$field] = $value;
		}
		return $fieldBased;
	}
	
	/**********************************\
	            KEYS - SINGLE
	\**********************************/
	
	private function addKey($fieldIds, $timestamp, $authorId) {
		$this->checker->checkIsNotEmpty($fieldIds);
		$this->checker->checkIsArray($fieldIds);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		
		$statement = $this->connection->prepare('INSERT INTO "working_key" (id, field_id, timestamp, author_id) VALUES (?, ?, ?, ?)');
		foreach($fieldIds as $fieldId) {
			$statement->execute(array($this->getNewDatabaseId(), $fieldId, $timestamp, $authorId));
		}
	}
	
	private function getKey($keyId) {
		$this->checker->checkIsNotEmpty($keyId);
		
		$statement = $this->connection->prepare('SELECT field_id FROM "working_key" WHERE id = ?');
		$statement->execute(array($keyId));
		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}
	
	private function getKeyId($fieldIds) {
		$this->checker->checkIsNotEmpty($fieldIds);
		$this->checker->checkIsArray($fieldIds);
		
		$statement = $this->connection->prepare('SELECT id, fieldId FROM "working_key"');
		$statement->execute(array($class));
		$keys = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP|PDO::FETCH_COLUMN);
		$keys = array_map(function($a) {return $a[0];}, $keys);
		foreach($keys as $id => $ids) {
			$missingFields = array_diff($ids, $fieldIds);
			$excessingFields = array_diff($fieldIds, $ids);
			if (empty($missingFields) && empty($excessingFields)) {
				return $id;
			} else {
				continue;
			}
		}
		return null;
	}
	
	private function copyKeyInArchive($keyId, $timestamp, $authorId) {
		$this->copyInArchive($keyId, $timestamp, $authorId, 'key', array('field_id'));
	}
	
	/*
	No setting function for a key, consider to delete an existing key to
	create a new one. If it becomes necessary, think to copy-paste and
	adapt a similar function (look field-related functions for instance).
	*/
	
	private function deleteKey($keyId, $timestamp, $authorId) {
		$this->copyKeyInArchive($keyId, $timestamp, $authorId);
		$clean = $this->connection->prepare('DELETE FROM "working_key" WHERE id = ?');
		$clean->execute(array($keyId));
	}
	
	/**********************************\
	           KEYS - MULTIPLE
	\**********************************/
	
	public function getKeys($class) {
		$this->checker->checkKnowsClass($class);
		
		$classId = $this->getClassId($class);
		$keyIds = $this->getKeyIds($classId);
		$keys = $this->getKeysForIds($keyIds);
		foreach($keys as $keyId => $fieldIds) {
			$keys[$keyId] = array_values($this->getFieldsForIds($fieldIds));
		}
		return array_values($keys);
	}
	
	private function getKeysForIds($keyIds) {
		$this->checker->checkIsNotEmpty($keyIds);
		$this->checker->checkIsArray($keyIds);
		
		$keys = array();
		foreach($keyIds as $keyId) {
			$keys[$keyId] = $this->getKey($keyId);
		}
		return $keys;
	}
	
	private function getKeyIds($classId) {
		$this->checker->checkIsNotEmpty($classId);
		
		$statement = $this->connection->prepare('SELECT k.id FROM "working_key" AS k JOIN "working_field" as f ON k.field_id = f.id WHERE f.class_id = ?');
		$statement->execute(array($classId));
		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}
	
	private function getKeysOverlapping($fieldIds, $bigger, $smaller) {
		$this->checker->checkIsNotEmpty($fieldIds);
		$this->checker->checkIsArray($fieldIds);
		
		$statement = $this->connection->prepare('SELECT id, field_id FROM "working_key"');
		$statement->execute(array());
		$keys = array();
		$allKeys = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
		$allKeys = array_map(function($a) {
					$ids = array_values($a[0]);
					$ids = array_map(function($a) {return (int) $a;}, $ids);
					return $ids;
				}, $allKeys);
		foreach($allKeys as $id => $ids) {
			$missingFields = array_diff($ids, $fieldIds);
			$excessingFields = array_diff($fieldIds, $ids);
			if ($bigger && empty($excessingFields)
			    || $smaller && empty($missingFields)) {
				$keys[$id] = $ids;
			} else {
				continue;
			}
		}
		return $keys;
	}
	
	private function getKeysContainedIn($fieldIds) {
		return $this->getKeysOverlapping($fieldIds, false, true);
	}
	
	private function getKeyIdsUsing($fieldIds) {
		return $this->getKeysOverlapping($fieldIds, true, false);
	}
	
	private function getKeyIdsCoveredBy($fieldData) {
		$this->checker->checkIsNotEmpty($fieldData);
		$this->checker->checkIsArray($fieldData);
		
		$fieldIds = array_keys($fieldData);
		return $this->getKeysContainedIn($fieldIds);
	}
	
	/**********************************\
	          RECORDS - SINGLE
	\**********************************/
	
	private function addRecord($fieldData, $timestamp, $authorId) {
		$this->checker->checkIsNotEmpty($fieldData);
		$this->checker->checkIsArray($fieldData);
		$this->checker->checkIsIdBasedData($fieldData);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		
		$recordId = $this->getRecordId($fieldData);
		if ($recordId) {
			throw new Exception("A record already exists with the same identifiers ($recordId), you cannot add the record (".Format::arrayToString($this->mapDataToFields($fieldData)).")");
		} else {
			// no record found with the same identifiers, we can go further.
		}
		
		$fieldData = array_filter($fieldData, function($a) {return $a !== null;});
		$fieldIds = array_keys($fieldData);
		$classId = $this->getFieldClassId($fieldIds[0]);
		$mandatoryFields = $this->getMandatoryFieldIds($classId);
		$missingFields = array_diff($mandatoryFields, $fieldIds);
		if (empty($missingFields)) {
			// all the mandatory fields are provided, we can go further.
		} else {
			throw new Exception("Some mandatory fields are missing: ".Format::arrayWithKeysToString($this->mapDataToFields($fieldData)));
		}
		
		$recordId = $this->getNewDatabaseId();
		$fieldIds = $this->getFieldIds($classId);
		$fieldTypes = $this->getFieldTypes($fieldIds);
		foreach($fieldIds as $fieldId) {
			$value = isset($fieldData[$fieldId]) ? $fieldData[$fieldId] : null;
			$type = $fieldTypes[$fieldId];
			$statement = $this->connection->prepare('INSERT INTO "working_'.$type.'" (id, field_id, value, timestamp, author_id) VALUES (?, ?, ?, ?, ?)');
			$statement->execute(array($recordId, $fieldId, $value, $timestamp, $authorId));
		}
		
		return $recordId;
	}
	
	private function getRecordId($fieldData, $keyId = null) {
		$this->checker->checkIsNotEmpty($fieldData);
		$this->checker->checkIsArray($fieldData);
		$this->checker->checkIsIdBasedData($fieldData);
		
		// remove classId by using fieldIds as keys of fieldData (instead of fields)
		if ($keyId === null) {
			$keys = $this->getKeyIdsCoveredBy($fieldData);
			if (count($keys) == 0) {
				$fieldIds = array_keys($fieldData);
				$classId = $this->getFieldClassId($fieldIds[0]);
				$class = $this->getClass($classId);
				throw new Exception("No key found in $class(".Format::arrayToString(array_keys($this->mapDataToFields($fieldData))).")");
			} else {
				$keyIds = array_keys($keys);
				$keyId = $keyIds[0];
			}
		} else {
			// use the given key ID
		}
		$fieldIds = $this->getKey($keyId);
		$fieldTypes = $this->getFieldTypes($fieldIds);
		
		$join = '';
		$where = '';
		$args = array();
		$counter = 0;
		foreach($fieldIds as $fieldId) {
			$value = $fieldData[$fieldId];
			$type = $fieldTypes[$fieldId];
			if ($counter == 0) {
				$join = '"working_'.$type.'" AS t'.$counter;
				$where = 't'.$counter.'.field_id = ? AND t'.$counter.'.value = ?';
			} else {
				$join = ' JOIN "working_'.$type.'" AS t'.$counter.' ON t0.id = t'.$counter.'.id';
				$where = ' AND t'.$counter.'.field_id = ? AND t'.$counter.'.value = ?';
			}
			$args[] = $fieldId;
			$args[] = $value;
			$counter++;
		}
		$statement = $this->connection->prepare('SELECT t0.id FROM '.$join.' WHERE '.$where);
		$statement->execute($args);
		return $statement->fetchColumn();
	}
	
	public function getRecordFromId($recordId) {
		$this->checker->checkIsNotEmpty($recordId);
		
		$classId = $this->getRecordClassId($recordId);
		$fieldIds = $this->getFieldIds($classId);
		$fields = $this->getFieldsForIds($fieldIds);
		$fieldTypes = $this->getFieldTypes($fieldIds);
		$record = array();
		foreach($fieldIds as $fieldId) {
			$type = $fieldTypes[$fieldId];
			$statement = $this->connection->prepare('SELECT value FROM "working_'.$type.'" WHERE id = ? AND field_id = ?');
			$statement->execute(array($recordId, $fieldId));
			$record[$fields[$fieldId]] = $statement->fetchColumn();
		}
		return $record;
	}
	
	public function getRecordFromData($class, $fieldData) {
		$this->checker->checkKnowsClass($class);
		$this->checker->checkIsNotEmpty($fieldData);
		$this->checker->checkIsArray($fieldData);
		
		$classId = $this->getClassId($class);
		$fieldData = $this->mapDataToFieldIds($classId, $fieldData);
		$recordId = $this->getRecordId($fieldData);
		$fieldIds = $this->getFieldIds($classId);
		$fieldTypes = $this->getFieldTypes($fieldIds);
		$record = array();
		foreach($fieldIds as $fieldId) {
			$type = $fieldTypes[$fieldId];
			$statement = $this->connection->prepare('SELECT value FROM "working_'.$type.'" WHERE id = ? AND field_id = ?');
			$statement->execute(array($recordId, $fieldId));
			$record[$field] = $statement->fetchColumn();
		}
		return $record;
	}
	
	private function getRecordClassId($recordId) {
		$this->checker->checkIsNotEmpty($recordId);
		
		foreach($this->getDbTypes() as $type) {
			$statement = $this->connection->prepare('SELECT f.class_id FROM "working_'.$type.'" AS r JOIN "working_field" AS f ON r.field_id = f.id WHERE r.id = ?');
			$statement->execute(array($recordId));
			$classId = $statement->fetchColumn();
			if ($classId === false) {
				continue;
			} else {
				return $classId;
			}
		}
		return null;
	}
	
	private function copyRecordInArchive($recordId, $timestamp, $authorId, $fieldIds = null) {
		$this->checker->checkIsNotEmpty($recordId);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		
		if ($fieldIds === null) {
			$classId = $this->getRecordClassId($recordId);
			$fieldIds = $this->getFieldIds($classId);
		} else {
			// use the given IDs
		}
		$fieldTypes = $this->getFieldTypes($fieldIds);
		foreach($fieldIds as $fieldId) {
			$type = $fieldTypes[$fieldId];
			$this->copyInArchive($recordId, $timestamp, $authorId, $type, array('field_id', 'value'), array('field_id' => $fieldId));
		}
	}
	
	private function setRecordField($recordId, $fieldId, $value, $timestamp, $authorId) {
		$this->copyRecordInArchive($recordId, $timestamp, $authorId, array($fieldId));
		$type = $this->getFieldType($fieldId);
		$this->setWorkingValue($recordId, 'value', $value, $timestamp, $authorId, $type, array('field_id' => $fieldId));
	}
	
	private function deleteRecord($recordId, $timestamp, $authorId) {
		$this->checker->checkIsNotEmpty($recordId);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		
		$classId = $this->getRecordClassId($recordId);
		$fieldIds = $this->getFieldIds($classId);
		$this->copyRecordInArchive($recordId, $timestamp, $authorId, $fieldIds);
		$fieldTypes = $this->getFieldTypes($fieldIds);
		foreach($fieldTypes as $type) {
			$clean = $this->connection->prepare('DELETE FROM "working_'.$type.'" WHERE id = ?');
			$clean->execute(array($recordId));
		}
	}
	
	public function getRecordHistory($class, $fieldData, $from = 0, $to = PHP_INT_MAX) {
		$this->checker->checkIsNotEmpty($class);
		$this->checker->checkIsNotEmpty($fieldData);
		$this->checker->checkIsArray($fieldData);
		
		$classId = $this->getClassId($class);
		$fieldData = $this->mapDataToFieldIds($classId, $fieldData);
		$recordId = $this->getRecordId($fieldData);
		$metadata = $this->getRecordIdsMetadata(array($recordId));
		$metadata = array_shift($metadata);
		$recordData = $this->mapDataToFields($metadata);
		$history = new RecordHistory();
		foreach($recordData as $field => $data) {
			$history->addUpdate($field, $data['value'], $data['timestamp'], $data['author']);
		}
		
		
		$metadata = $this->getRecordIdsArchivedMetadata(array($recordId));
		$metadata = array_shift($metadata);
		if (empty($metadata)) {
			// no archived data, just ignore this phase.
		} else {
			$recordData = $this->mapDataToFields($metadata);
			foreach($recordData as $field => $versions) {
				foreach($versions as $data) {
					$history->addUpdate($field, $data['value'], $data['timeCreate'], $data['authorCreate'], $data['timeArchive'], $data['authorArchive']);
				}
			}
		}
		
		return $history;
	}
	
	/**********************************\
	         RECORDS - MULTIPLE
	\**********************************/
	
	private function getRecordIds($classId) {
		$this->checker->checkIsNotEmpty($classId);
		
		$fieldIds = $this->getFieldIds($classId);
		$fieldTypes = $this->getFieldTypes($fieldIds);
		
		// all records have all the fields, so we look only one field to gather all the IDs
		$fieldIdRef = array_pop($fieldIds);
		$typeRef = $fieldTypes[$fieldIdRef];
		$statement = $this->connection->prepare('SELECT id FROM "working_'.$typeRef.'" WHERE field_id = ?');
		$statement->execute(array($fieldIdRef));
		$result = $statement->fetchAll(PDO::FETCH_COLUMN);
		return $result;
	}
	
	public function getAllRecords($class) {
		$this->checker->checkKnowsClass($class);
		
		$classId = $this->getClassId($class);
		$recordIds = $this->getRecordIds($classId);
		$fieldIds = $this->getFieldIds($classId);
		$fieldTypes = $this->getFieldTypes($fieldIds);
		$record = array();
		foreach($recordIds as $recordId) {
			foreach($fieldIds as $fieldId) {
				$type = $fieldTypes[$fieldId];
				$args = array();
				$statement = $this->connection->prepare('SELECT value FROM "working_'.$type.'" WHERE '.$this->formatQueryConditions(array('id' => $recordId, 'field_id' => $fieldId), $args));
				$statement->execute($args);
				$record[$field] = $statement->fetchColumn();
			}
		}
		return $record;
	}
	
	public function getDataMetadata($class, $records = null) {
		$this->checker->checkKnowsClass($class);
		
		$classId = $this->getClassId($class);
		$recordIds = array();
		if (empty($records)) {
			$recordIds = $this->getRecordIds($classId);
		} else {
			foreach($records as $record) {
				$recordIds[] = $this->getRecordId($class, $record);
			}
		}
		$metadata = $this->getRecordIdsMetadata($recordIds);
		foreach($metadata as $recordId => $meta) {
			$metadata[$recordId] = $this->mapDataToFields($meta);
		}
		return array_values($metadata);
	}
	
	private function getRecordIdsMetadata($recordIds) {
		$this->checker->checkIsNotEmpty($recordIds);
		$this->checker->checkIsArray($recordIds);
		
		$metadata = array();
		foreach($recordIds as $recordId) {
			$classId = $this->getRecordClassId($recordId);
			$fieldIds = $this->getFieldIds($classId);
			$fields = $this->getFieldsForIds($fieldIds);
			$fieldTypes = $this->getFieldTypes($fieldIds);
			$metadata[$recordId] = array();
			foreach($fieldIds as $fieldId) {
				$type = $fieldTypes[$fieldId];
				$args = array();
				$statement = $this->connection->prepare('SELECT field_id, value, timestamp, author_id FROM "working_'.$type.'" WHERE '.$this->formatQueryConditions(array('id' => $recordId, 'field_id' => $fieldId), $args));
				$statement->execute($args);
				$recordMeta = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
				foreach($recordMeta as $fieldId => $meta) {
					$meta = $meta[0];
					settype($meta['value'], $this->mapDbTypeToPhpType($type));
					settype($meta['timestamp'], 'int');
					$meta['author'] = $this->getUserFromId($meta['author_id']);
					unset($meta['author_id']);
					$metadata[$recordId][$fieldId] = $meta;
				}
			}
		}
		return $metadata;
	}
	
	private function getRecordIdsArchivedMetadata($recordIds) {
		$this->checker->checkIsNotEmpty($recordIds);
		$this->checker->checkIsArray($recordIds);
		
		$metadata = array();
		foreach($recordIds as $recordId) {
			$classId = $this->getRecordClassId($recordId);
			$fieldIds = $this->getFieldIds($classId);
			$fields = $this->getFieldsForIds($fieldIds);
			$fieldTypes = $this->getFieldTypes($fieldIds);
			$metadata[$recordId] = array();
			foreach($fieldIds as $fieldId) {
				$type = $fieldTypes[$fieldId];
				$args = array();
				$statement = $this->connection->prepare('SELECT field_id, value, timeCreate, authorCreate_id, timeArchive, authorArchive_id FROM "archive_'.$type.'" WHERE '.$this->formatQueryConditions(array('id' => $recordId, 'field_id' => $fieldId), $args));
				$statement->execute($args);
				$recordMeta = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
				foreach($recordMeta as $fieldId => $metaList) {
					foreach($metaList as $meta) {
						settype($meta['value'], $this->mapDbTypeToPhpType($type));
						settype($meta['timeCreate'], 'int');
						settype($meta['timeArchive'], 'int');
						$meta['authorCreate'] = $this->getUserFromId($meta['authorCreate_id']);
						$meta['authorArchive'] = $this->getUserFromId($meta['authorArchive_id']);
						unset($meta['authorCreate_id']);
						unset($meta['authorArchive_id']);
						$metadata[$recordId][$fieldId][] = $meta;
					}
				}
			}
		}
		return $metadata;
	}
	
	private function completeAllRecords($fieldId, $valueCallback, $timestamp, $authorId) {
		$this->checker->checkIsNotEmpty($fieldId);
		$this->checker->checkIsFunction($valueCallback);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		
		$classId = $this->getFieldClassId($fieldId);
		$recordIds = $this->getRecordIds($classId);
		$fieldType = $this->getFieldType($fieldId);
		foreach($recordIds as $recordId) {
			$statement = $this->connection->prepare('INSERT INTO "working_'.$fieldType.'" (id, field_id, value, timestamp, author_id) VALUES (?, ?, ?, ?, ?)');
			$statement->execute(array($recordId, $fieldId, $valueCallback($recordId), $timestamp, $authorId));
		}
	}
	
	private function clearRecords($fieldId, $timestamp, $authorId) {
		$this->checker->checkIsNotEmpty($fieldId);
		$this->checker->checkIsNotEmpty($timestamp);
		$this->checker->checkIsNotEmpty($authorId);
		
		$type = $this->getFieldType($fieldId);
		$clear = $this->connection->prepare('DELETE FROM "working_'.$type.'" WHERE field_id = ?');
		$clear->execute(array($fieldId));
	}
	
	/********************************************\
	                    PATCH
	\********************************************/
	
	public function applyPatch(Patch $patch) {
		$this->checker->checkIsNotEmpty($patch);
		
		$author = $patch->getUser();
		$authorId = $this->getUserId($author);
		$timestamp = $patch->getTime();
		if (!$this->isKnownUser($author)) {
			throw new Exception("There is no user ".$authorId);
		} else {
			$this->connection->beginTransaction();
			foreach($patch->getInstructions() as $instruction) {
				if ($instruction instanceof PatchAddField) {
					$class = $instruction->getClass();
					$field = $instruction->getField();
					$type = $instruction->getType();
					$mandatory = $instruction->getMandatoryAsBoolean();
					
					if (!$this->isKnownClass($class)) {
						$this->addClass($class, $timestamp, $authorId);
					} else {
						// use the existing one.
					}
					$classId = $this->getClassId($class);
					// TODO exploit the value callback of the function (especially for mandatory fields)
					$this->addField($classId, $field, $type, $mandatory, $timestamp, $authorId);
				} else if ($instruction instanceof PatchRemoveField) {
					$class = $instruction->getClass();
					$field = $instruction->getField();
					
					$classId = $this->getClassId($class);
					$fieldId = $this->getFieldId($classId, $field);
					$this->deleteField($fieldId, $timestamp, $authorId);
				} else if ($instruction instanceof PatchSetClassKey) {
					$class = $instruction->getClass();
					$fields = $instruction->getIDFields();
					
					// TODO exploit several keys (so do not delete)
					$classId = $this->getClassId($class);
					$keyIds = $this->getKeyIds($classId);
					foreach($keyIds as $keyId) {
						$this->deleteKey($keyId, $timestamp, $authorId);
					}
					
					$fieldIds = $this->getFieldIds($classId, $fields);
					$this->addKey($fieldIds, $timestamp, $authorId);
				} else if ($instruction instanceof PatchChangeFieldType) {
					$class = $instruction->getClass();
					$field = $instruction->getField();
					$type = $instruction->getTypeValue();
					
					$classId = $this->getClassId($class);
					$fieldId = $this->getFieldId($classId, $field);
					$this->setFieldType($fieldId, $type, $timestamp, $authorId);
				} else if ($instruction instanceof PatchUser) {
					$name = $instruction->getUser();
					$hash = $instruction->getHash();
					$this->addUser($name);
					$this->setUserHash($name, $hash);
				} else {
					// TODO implement other cases
					throw new Exception("Not implemented yet: ".get_class($instruction));
				}
			}
			$this->connection->commit();
		}
	}
	
	/********************************************\
	                    CHECKS
	\********************************************/
	
	private function check($expected, $result, $logIfExpected, $logIfNotExpected) {
		if ($expected && !$result) {
			throw new Exception($logIfExpected);
		} else if (!$expected && $result) {
			throw new Exception($logIfNotExpected);
		}
	}
	
	
	
	
	/********************************************\
	            PERSISTENT COMPONENTS
	\********************************************/
	
	public function getStructureDiff(PersistentComponent $component) {
		$this->checker->checkIsNotEmpty($component);
		
		$class = $component->getClass();
		$metadata = null;
		if (!$this->isKnownClass($class)) {
			$metadata = array();
		} else {
			$classId = $this->getClassId($class);
			$fieldIds = $this->getFieldIds($classId);
			$metadata = $this->getFieldIdsMetadata($fieldIds);
			$metadata = $this->mapDataToFields($metadata);
		}
		$diff = new StructureDiff();
		foreach($component->getPersistentFields() as $name => $field) {
			$type = $field->getTranslator()->getPersistentType($field)->getType();
			$mandatory = $field->isMandatory();
			
			if (!array_key_exists($name, $metadata)) {
				$diff->addDiff(new AddFieldDiff($class, $name, $type, $mandatory));
			} else {
				$property = $metadata[$name];
				unset($metadata[$name]);
				if ($property['type'] != $type) {
					$diff->addDiff(new ChangeTypeDiff($class, $name, $property['type'], $type));
				} else if ($property['mandatory'] != $mandatory) {
					$diff->addDiff(new ChangeMandatoryDiff($class, $name, $property['mandatory'], $mandatory));
				} else {
					// no modification, do not add a diff
				}
			}
		}
		
		foreach($metadata as $name => $property) {
			$diff->addDiff(new RemoveFieldDiff($class, $name, $property['type'], $property['mandatory']));
		}
		
		$componentKey = array_keys($component->getIDFields());
		
		$savedKeys = $this->isKnownClass($class) ? $this->getkeys($class) : array();
		$savedKey = empty($savedKeys) ? array() : $savedKeys[0];
		if (count(array_diff_assoc($savedKey, $componentKey)) > 0 || count(array_diff_assoc($componentKey, $savedKey)) > 0) {
			$diff->addDiff(new ChangeKeyDiff($class, $savedKey, $componentKey));
		}
		
		return $diff;
	}
	
	private function checkComponentFieldsMapping($databaseFields, $componentFields) {
		$remainingFields = array_diff($componentFields, $databaseFields);
		if (!empty($remainingFields)) {
			throw new UnkownFieldsException($remainingFields);
		} else {
			// all the object fields are known.
		}
		
		$missingFields = array_diff($databaseFields, $componentFields);
		if (!empty($missingFields)) {
			throw new MissingFieldsException($missingFields);
		} else {
			// all the database fields are checked.
		}
	}
	
	private function extractUpdatedData(PersistentComponent $component) {
		$this->checker->checkIsNotEmpty($component);
		
		$recordId = $component->getInternalKey();
		$savedData = $this->getRecordFromId($recordId);
		$componentData = $this->extractComponentData($component);
		
		$this->checkComponentFieldsMapping(array_keys($savedData), array_keys($componentData));
		
		return array_diff_assoc($componentData, $savedData);
	}
	
	private function extractComponentData(PersistentComponent $component) {
		$this->checker->checkIsNotEmpty($component);
		
		$componentData = array();
		foreach($component->getPersistentFields() as $field => $object) {
			$translator = $object->getTranslator();
			$componentData[$field] = $translator->getPersistentValue($object);
		}
		return $componentData;
	}
	
	private function feedComponentWithData(PersistentComponent $component, $data) {
		$this->checker->checkIsNotEmpty($component);
		$this->checker->checkIsNotEmpty($data);
		$this->checker->checkIsArray($data);
		
		$persistentFields = $component->getPersistentFields();
		
		$this->checkComponentFieldsMapping(array_keys($data), array_keys($persistentFields));
		
		foreach($persistentFields as $field => $object) {
			$translator = $object->getTranslator();
			$translator->setPersistentValue($object, $data[$field]);
		}
	}
	
	public function save(PersistentComponent $component, $author) {
		$this->checker->checkIsNotEmpty($component);
		$this->checker->checkKnowsUser($author);
		
		$recordId = $component->getInternalKey();
		$timestamp = time();
		$authorId = $this->getUserId($author);
		$this->connection->beginTransaction();
		if (empty($recordId)) {
			$componentData = $this->extractComponentData($component);
			$classId = $this->getClassId($component->getClass());
			$componentData = $this->mapDataToFieldIds($classId, $componentData);
			$recordId = $this->addRecord($componentData, $timestamp, $authorId);
			$component->setInternalKey($recordId);
		} else {
			$updatedData = $this->extractUpdatedData($component);
			if (empty($updatedData)) {
				// nothing to do, just pass
			} else {
				$classId = $this->getClassId($component->getClass());
				$updatedData = $this->mapDataToFieldIds($classId, $updatedData);
				foreach($updatedData as $fieldId => $value) {
					$this->setRecordField($recordId, $fieldId, $value, $timestamp, $authorId);
				}
			}
		}
		$this->connection->commit();
	}
	
	public function load(PersistentComponent $component) {
		$recordId = $component->getInternalKey();
		$record = array();
		if (empty($recordId)) {
			$class = $component->getClass();
			$data = $this->extractComponentData($component);
			$record = $this->getRecordFromData($class, $data);
			
			$data = $this->mapDataToFieldIds($data);
			$recordId = $this->getRecordId($data);
			$component->setInternalKey($recordId);
		} else {
			$record = $this->getRecordFromId($recordId);
		}
		$this->feedComponentWithData($component, $record);
	}
	
	public function loadAll($class) {
		$classId = $this->getClassId($class);
		$recordIds = $this->getRecordIds($classId);
		$reflector = new ReflectionClass($class);
		$components = array();
		foreach($recordIds as $recordId) {
			$component = $reflector->newInstance();
			$component->setInternalKey($recordId);
			$this->load($component);
			$components[] = $component;
		}
		return $components;
	}
}
?>