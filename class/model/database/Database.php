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
				// table already exists, just ignore this part
			} else {
				throw $ex;
			}
		}
		
		try {
			$this->connection->exec('CREATE TABLE "structure" (
				class      VARCHAR(128) NOT NULL,
				field      VARCHAR(128) NOT NULL,
				type       VARCHAR(128) NOT NULL,
				unicity    BOOLEAN NOT NULL,
				mandatory  BOOLEAN NOT NULL,
				key        BOOLEAN NOT NULL,
				translator VARCHAR(128) NOT NULL,
				start      INTEGER NOT NULL,
				patch      TEXT NOT NULL,
				stop       INTEGER,
				
				PRIMARY KEY (class, field)
			)');
		} catch(PDOException $ex) {
			if ($this->connection->errorCode() == 'HY000') {
				// table already exists, just ignore this part
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
				// table already exists, just ignore this part
			} else {
				throw $ex;
			}
		}
	}
	
	private function initMissingTable($table) {
		$this->connection->exec('CREATE TABLE IF NOT EXISTS "'.$table->getName().'" (
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
			$tables[] = $table;
		}
		return $tables;
	}
	
	public function saveStructure(PersistentComponent $component) {
		$class = $component->getClass();
		$time = time();
		$statement = $this->connection->prepare('INSERT INTO "structure" (class, field, type, unicity, mandatory, key, translator, start, patch, stop) VALUES (?, ?, ?, ?, ?, ?, ?, ?, "", NULL)');
		$tables = array();
		foreach($component->getPersistentFields() as $name => $field) {
			$table = $field->getTranslator()->getPersistentTable($field);
			$tables[] = $table;
			$statement->execute(array($class, $name, $table->getName(), $field->isUnique(), $field->isMandatory(), $field->isKey(), get_class($field->getTranslator()), $time));
		}
		foreach($tables as $table) {
			$this->initMissingTable($table);
		}
	}
	
	private function getTablesForClass($class) {
		$tables = array();
		foreach($this->getPropertiesForClass($class) as $field => $array) {
			$tables[$field] = $array['type'];
		}
		return $tables;
	}
	
	private function getPropertiesForClass($class) {
		$statement = $this->connection->query('SELECT field, type, unicity, mandatory, key, translator, start, patch FROM "structure" WHERE class = "'.$class.'" AND stop IS NULL');
		$properties = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
		foreach($properties as $field => $array) {
			$array = $array[0];
			settype($array['unicity'], 'boolean');
			settype($array['mandatory'], 'boolean');
			settype($array['key'], 'boolean');
			$properties[$field] = $array;
		}
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
				$diff->addField($name);
			} else if ($properties[$name]['type'] != $field->getTranslator()->getPersistentTable($field)->getName()) {
				$diff->changeTable($name, $properties[$name]['type'], $field->getTranslator()->getPersistentTable($field)->getName());
			} else if ($properties[$name]['unicity'] != $field->isUnique()) {
				$diff->changeUnicity($name, $properties[$name]['unicity'], $field->isUnique());
			} else if ($properties[$name]['mandatory'] != $field->isMandatory()) {
				$diff->changeMandatory($name, $properties[$name]['mandatory'], $field->isMandatory());
			} else if ($properties[$name]['key'] != $field->isKey()) {
				$diff->changeKey($name, $properties[$name]['key'], $field->isKey());
			} else if ($properties[$name]['translator'] != get_class($field->getTranslator())) {
				$diff->changeTranslator($name, $properties[$name]['translator'], get_class($field->getTranslator()));
			} else {
				// no modification, do not add a diff
			}
			unset($properties[$name]);
		}
		foreach(array_keys($properties) as $name) {
			$diff->deleteField($name);
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
	
	public function isUnicityConsistent(PersistentComponent $component) {
		$tables = $this->getPersistentTableNames();
		$class = $component->getClass();
		$key = $component->getInternalKey();
		foreach($component->getPersistentFields() as $name => $field) {
			if ($field->isUnique()) {
				$translator = $field->getTranslator();
				$table = $translator->getPersistentTable($field)->getName();
				if (in_array($table, $tables)) {
					$sql = 'SELECT key FROM "'.$table.'" WHERE class = ? AND field = ? AND value = ?';
					$data = array($class, $name, $translator->getPersistentValue($field->get()));
					if ($key !== null) {
						$sql .= ' AND key != ?';
						$data[] = $key;
					}
					$statement = $this->connection->prepare($sql);
					$statement->execute($data);
					$owner = $statement->fetchColumn();
					if (!empty($owner)) {
						return false;
					} else {
						// unique value, continue
					}
				} else {
					// unknown table, what means unique regarding the data in the database
				}
			}
		}
		return true;
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
		if (!$this->isUnicityConsistent($component)) {
			throw new Exception("There is unique fields already used for ".$component);
		} else if (!$this->isMandatoryConsistent($component)) {
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
					$statement = $this->connection->prepare('INSERT INTO "'.$table->getName().'" (class, key, field, timestamp, value, author) VALUES (?, ?, ?, ?, ?, ?)');
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
			$statement = $this->connection->prepare('SELECT value FROM "'.$table->getName().'" WHERE key = ? AND field = ? ORDER BY timestamp DESC');
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
		$statement = $this->connection->prepare('SELECT key FROM "'.$table->getName().'" WHERE class = ? AND field = ? AND value = ? ORDER BY timestamp DESC');
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
		
		$statement = $this->connection->prepare('SELECT DISTINCT key FROM "'.$table.'" WHERE class = ?');
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