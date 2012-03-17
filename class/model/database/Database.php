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
	
	public static function createDefaultDatabase() {
		Database::$defaultDatabase = new Database();
	}
	
	public static function getDefaultDatabase() {
		$db = Database::$defaultDatabase;
		if ($db === null) {
			throw new Exception('default database not created yet');
		}
		else {
			return $db;
		}
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
				class     VARCHAR(128) NOT NULL,
				field     VARCHAR(128) NOT NULL,
				tableName VARCHAR(128) NOT NULL,
				start     INTEGER NOT NULL,
				stop      INTEGER,
				
				PRIMARY KEY (class, field)
			)');
		} catch(PDOException $ex) {
			if ($this->connection->errorCode() == 'HY000') {
				// table already exists, just ignore this part
			} else {
				throw $ex;
			}
		}
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
			$this->connection->exec('DROP TABLE IF EXISTS "'.$name.'"');
		}
	}
	
	public function getTableNames() {
		return array("property", "news", "project");
	}
	
	public function saveStructure(PersistentComponent $component) {
		$class = $component->getClass();
		$time = time();
		$statement = $this->connection->prepare('INSERT INTO "structure" (class, field, tableName, start, stop) VALUES (?, ?, ?, ?, NULL)');
		$tables = array();
		foreach($component->getPersistentFields() as $name => $field) {
			$table = $field->getTranslator()->getPersistentTable($field);
			$tables[] = $table;
			$statement->execute(array($class, $name, $table->getName(), $time));
		}
		foreach($tables as $table) {
			$this->initMissingTable($table);
		}
	}
	
	private function getTablesForClass($class) {
		$statement = $this->connection->query('SELECT field, tableName FROM "structure" WHERE class = "'.$class.'" AND stop IS NULL');
		$tables = $statement->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
		foreach($tables as $field => $array) {
			$tables[$field] = $array[0];
		}
		return $tables;
	}
	
	public function isUpdatedStructure(PersistentComponent $component) {
		return !$this->getStructureDiff($component)->isEmpty();
	}
	
	public function getStructureDiff(PersistentComponent $component) {
		$class = $component->getClass();
		$tables = $this->getTablesForClass($class);
		$diff = new StructureDiff();
		foreach($component->getPersistentFields() as $name => $field) {
			if (!array_key_exists($name, $tables)) {
				$diff->addField($name);
			} else if ($tables[$name] != $field->getTranslator()->getPersistentTable($field)->getName()) {
				$diff->changeTable($name, $tables[$name], $field->getTranslator()->getPersistentTable($field)->getName());
			}
			unset($tables[$name]);
		}
		foreach(array_keys($tables) as $fieldName) {
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
		$statement = $this->connection->query('SELECT DISTINCT tableName FROM "structure"');
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
	
	public function save(PersistentComponent $component) {
		$this->checkStructureIsWellKnown($component);
		if (!$this->isUnicityConsistent($component)) {
			throw new Exception("There is unique fields already used for ".$component);
		} else if (!$this->isMandatoryConsistent($component)) {
			throw new Exception("There is not specified mandatory fields for ".$component);
		}
		
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
				// TODO add author of modification
				$translator = $field->getTranslator();
				$table = $translator->getPersistentTable($field);
				$statement = $this->connection->prepare('INSERT INTO "'.$table->getName().'" (class, key, field, timestamp, value) VALUES (?, ?, ?, ?, ?)');
				$statement->execute(array($class, $key, $name, $time, $translator->getPersistentValue($field->get())));
			}
		}
		$this->connection->commit();
		foreach($component->getPersistentFields() as $name => $field) {
			$field->setAsSaved();
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
		
		$statement = $this->connection->query('SELECT tableName FROM "structure" WHERE class = ?');
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
	
	private function initMissingTable($table) {
		$this->connection->exec('CREATE TABLE IF NOT EXISTS "'.$table->getName().'" (
			class     VARCHAR(128) NOT NULL,
			key       INTEGER NOT NULL,
			field     VARCHAR(128) NOT NULL,
			timestamp INTEGER NOT NULL,
			value     '.$table->getColumnType().',
			
			PRIMARY KEY (class, field, key, timestamp)
		)');
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