<?php
class PersistentTable {
	private $name = null;
	private $columnType = null;
	
	public function __construct($name, $columnType) {
		$this->name = $name;
		$this->columnType = $columnType;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getColumnType() {
		return $this->columnType;
	}
	
	public static function defaultBooleanTable() {
		return new PersistentTable("boolean", 'BOOLEAN');
	}
	
	public static function defaultIntegerTable() {
		return new PersistentTable("integer", 'INTEGER');
	}
	
	public static function defaultDoubleTable() {
		return new PersistentTable("double", 'DOUBLE');
	}
	
	public static function defaultStringTable($length = null) {
		if (empty($length)) {
			return new PersistentTable("string", 'TEXT');
		} else {
			return new PersistentTable("string".$length, 'VARCHAR('.$length.')');
		}
	}
}
?> 
