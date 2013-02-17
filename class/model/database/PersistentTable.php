<?php
class PersistentTable {
	const WORKING_ONLY = "working";
	const ARCHIVE_ONLY = "archive";
	const ALL_HISTORY = "all";
	private $type;
	private $mode = PersistentTable::WORKING_ONLY;
	
	private function __construct($type) {
		$this->type = $type;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function setMode($mode) {
		$this->mode = $mode;
	}
	
	public function getMode() {
		return $this->mode;
	}
	
	public function isWorkingMode() {
		return $this->getMode() === PersistentTable::WORKING_ONLY;
	}
	
	public function isArchiveMode() {
		return $this->getMode() === PersistentTable::ARCHIVE_ONLY;
	}
	
	public function isUnionMode() {
		return $this->getMode() === PersistentTable::ALL_HISTORY;
	}
	
	public function isArchiveOrUnionMode() {
		return $this->isArchiveMode() || $this->isUnionMode();
	}
	
	public function getName() {
		$name = $this->type;
		if ($this->isWorkingMode()) {
			$name = 'working_'.$name;
		} else if ($this->isArchiveMode()) {
			$name = 'archive_'.$name;
		} else if ($this->isUnionMode()) {
			$name = 'all_'.$name;
		} else {
			throw new NotManagedModeException($this->getMode());
		}
		return $name;
	}
	
	private function getTypeSpecificColumnDescriptors() {
		$columns = array();
		if ($this->type == 'class') {
			$columns[] = new ColumnDescriptor('class', 'VARCHAR(128) NOT NULL');
		} else if ($this->type == 'field') {
			$columns[] = new ColumnDescriptor('class_id', 'INTEGER NOT NULL');
			$columns[] = new ColumnDescriptor('field', 'VARCHAR(128) NOT NULL');
			$columns[] = new ColumnDescriptor('type', 'VARCHAR(128) NOT NULL');
			$columns[] = new ColumnDescriptor('mandatory', 'BOOLEAN NOT NULL');
		} else if ($this->type == 'key') {
			$columns[] = new ColumnDescriptor('field_id', 'INTEGER NOT NULL');
		} else {
			$columns[] = new ColumnDescriptor('field_id', 'INTEGER NOT NULL');
			$dbType = null;
			if ($this->type == "boolean") {
				$dbType = 'BOOLEAN';
			} else if ($this->type == "integer") {
				$dbType = 'INTEGER';
			} else if ($this->type == "double") {
				$dbType = 'DOUBLE';
			} else if ($this->type == "string") {
				$dbType = 'TEXT';
			} else if (preg_match("#^string[0-9]+$#", $this->type)) {
				$dbType = 'VARCHAR('.substr($this->type, 6).')';
			} else {
				throw new Exception("'".$this->type."' is not a managed type.");
			}
			$columns[] = new ColumnDescriptor('value', $dbType);
		}
		return $columns;
	}
	
	private function getCommonColumnDescriptors() {
		$columns = array();
		$columns[] = new ColumnDescriptor('id', 'INTEGER NOT NULL');
		return $columns;
	}
		
	private function getModeSpecificColumnDescriptors() {
		$columns = array();
		if ($this->isArchiveOrUnionMode()) {
			$columns[] = new ColumnDescriptor('timeCreate', 'INTEGER NOT NULL');
			$columns[] = new ColumnDescriptor('authorCreate_id', 'INTEGER NOT NULL');
			$columns[] = new ColumnDescriptor('timeArchive', 'INTEGER NOT NULL');
			$columns[] = new ColumnDescriptor('authorArchive_id', 'INTEGER NOT NULL');
		} else if ($this->isWorkingMode()) {
			$columns[] = new ColumnDescriptor('timestamp', 'INTEGER NOT NULL');
			$columns[] = new ColumnDescriptor('author_id', 'INTEGER NOT NULL');
		} else {
			throw new NotManagedModeException($this->getMode());
		}
		return $columns;
	}
		
	private function getAllColumnDescriptors() {
		$commonColumns = $this->getCommonColumnDescriptors();
		$specificColumns = $this->getTypeSpecificColumnDescriptors();
		$modeColumns = $this->getModeSpecificColumnDescriptors();
		return array_merge($commonColumns, $specificColumns, $modeColumns);
	}
	
	public function getTypeSpecificColumnNames() {
		return array_map(function($d) {return $d->getName();}, $this->getTypeSpecificColumnDescriptors());
	}
	
	public function getModeSpecificColumnNames() {
		return array_map(function($d) {return $d->getName();}, $this->getModeSpecificColumnDescriptors());
	}
	
	public function getCommonColumnNames() {
		return array_map(function($d) {return $d->getName();}, $this->getCommonColumnDescriptors());
	}
	
	public function getAllColumnNames() {
		return array_map(function($d) {return $d->getName();}, $this->getAllColumnDescriptors());
	}
	
	private function getColumnDefinitions() {
		return array_map(function($d) {return $d->getDefinition();}, $this->getAllColumnDescriptors());
	}
	
	private function getConstraints() {
		$constraints = array();
		$specific = $this->isArchiveOrUnionMode() ? ', timeCreate' : '';
		if ($this->type == 'class') {
			$constraints[] = 'PRIMARY KEY (id'.$specific.')';
			$constraints[] = 'UNIQUE(class'.$specific.')';
		} else if ($this->type == 'field') {
			$constraints[] = 'PRIMARY KEY (id'.$specific.')';
			$constraints[] = 'UNIQUE(class_id, field'.$specific.')';
		} else if ($this->type == 'key') {
			$constraints[] = 'PRIMARY KEY (id'.$specific.')';
			$constraints[] = 'UNIQUE (id, field_id'.$specific.')';
		} else {
			$constraints[] = 'PRIMARY KEY (id, field_id'.$specific.')';
		}
		
		if ($this->isArchiveOrUnionMode()) {
			$constraints[] = 'FOREIGN KEY (authorCreate_id) REFERENCES user(id)';
			$constraints[] = 'FOREIGN KEY (authorArchive_id) REFERENCES user(id)';
		} else if ($this->isWorkingMode()) {
			$constraints[] = 'FOREIGN KEY (author_id) REFERENCES user(id)';
			
			// Specific foreign keys which cannot be in archive tables.
			// (can be linked to working or archive stuff)
			if (in_array('class_id', $this->getAllColumnNames())) {
				$constraints[] = 'FOREIGN KEY (class_id) REFERENCES working_class(id)';
			} else if (in_array('field_id', $this->getAllColumnNames())) {
				$constraints[] = 'FOREIGN KEY (field_id) REFERENCES working_field(id)';
			}
		} else {
			throw new NotManagedModeException($this->getMode());
		}
		return $constraints;
	}
	
	public function getCreationScript($ifNotExists = false) {
		if ($this->isUnionMode()) {
			throw new Exception("No creation can be done for the combination of working and archived values.");
		} else {
			$check = $ifNotExists ? 'IF NOT EXISTS' : '';
			$name = $this->getName();
			$columns = Format::arrayToString($this->getColumnDefinitions());
			$constraints = Format::arrayToString($this->getConstraints());
			return 'CREATE TABLE '.$check.' "'.$name.'" ('.$columns.', '.$constraints.')';
		}
	}
	
	private static $tables = array();
	public static function getTableFor($type) {
		if (array_key_exists($type, PersistentTable::$tables)) {
			// do not recreate it
		} else {
			PersistentTable::$tables[$type] = new PersistentTable($type);
		}
		return PersistentTable::$tables[$type];
	}
	
	private static $checker = null;
	private static function getChecker() {
		if (PersistentTable::$checker === null) {
			$checker = new Checker();
			PersistentTable::$checker = $checker;
		} else {
			// use the current one
		}
		return PersistentTable::$checker;
	}
	
	// TODO put private when transfer finished
	public static function formatQueryConditions($constraints, &$args = array()) {
		PersistentTable::getChecker()->checkIsArray($constraints);
		PersistentTable::getChecker()->checkIsArray($args);
		
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
	
	public static function getQueriesToUpdate($type, $column, $ids, $value, $timestamp, $authorId, $constraints = array()) {
		PersistentTable::getChecker()->checkIsNotEmpty($type);
		PersistentTable::getChecker()->checkIsNotEmpty($column);
		PersistentTable::getChecker()->checkIsNotEmpty($ids);
		PersistentTable::getChecker()->checkIsArray($ids);
		PersistentTable::getChecker()->checkIsNotEmpty($timestamp);
		PersistentTable::getChecker()->checkIsNotEmpty($authorId);
		PersistentTable::getChecker()->checkIsArray($constraints);
		
		$args = array($value);
		$constraints = array_merge(array('id' => $ids), $constraints);
		$conditions = PersistentTable::formatQueryConditions($constraints, $args);
		
		// In the following, we do not create a new array each time, because in PHP arrays are given by copy, not reference
		// Source: http://stackoverflow.com/questions/1532618/is-there-a-function-make-a-copy-of-a-php-array-to-another
		$queries = array();
		$queries['UPDATE "working_'.$type.'" SET '.$column.' = ? WHERE '.$conditions] = $args;
		$args[0] = $timestamp;
		$queries['UPDATE "working_'.$type.'" SET timestamp = ? WHERE '.$conditions] = $args;
		$args[0] = $authorId;
		$queries['UPDATE "working_'.$type.'" SET author_id = ? WHERE '.$conditions] = $args;
		return $queries;
	}
	
	
	public static function getQueriesToArchive($type, $ids, $timestamp, $authorId, $constraints = array()) {
		PersistentTable::getChecker()->checkIsNotEmpty($type);
		PersistentTable::getChecker()->checkIsNotEmpty($ids);
		PersistentTable::getChecker()->checkIsArray($ids);
		PersistentTable::getChecker()->checkIsNotEmpty($timestamp);
		PersistentTable::getChecker()->checkIsNotEmpty($authorId);
		PersistentTable::getChecker()->checkIsArray($constraints);
		
		$table = PersistentTable::getTableFor($type);
		$columns = Format::arrayToString($table->getTypeSpecificColumnNames());
		$args = array();
		$constraints = array_merge(array('id' => $ids), $constraints);
		$conditions = PersistentTable::formatQueryConditions($constraints, $args);
		
		$queries = array();
		$queries['INSERT INTO "archive_'.$type.'" (id, '.$columns.', timeCreate, authorCreate_id, timeArchive, authorArchive_id) SELECT id, '.$columns.', timestamp as timeCreate, author_id as authorCreate_id, '.$timestamp.' as timeArchive, '.$authorId.' as authorArchive_id FROM "working_'.$type.'" WHERE '.$conditions] = $args;
		return $queries;
	}
}

class ColumnDescriptor {
	private $name;
	private $parameters;
	
	public function __construct($name, $parameters) {
		$this->name = $name;
		$this->parameters = $parameters;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getDefinition() {
		return $this->name.' '.$this->parameters;
	}
}
?>