<?php
class PersistentType {
	private $type = null;
	
	private function __construct($type) {
		$this->type = $type;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public static function getBooleanType() {
		return new PersistentType("boolean");
	}
	
	public static function getIntegerType() {
		return new PersistentType("integer");
	}
	
	public static function getDoubleType() {
		return new PersistentType("double");
	}
	
	public static function getStringType($length = null) {
		if (empty($length)) {
			return new PersistentType("string");
		} else {
			return new PersistentType("string".$length);
		}
	}
	
	public function toString() {
		return $this->getType();
	}
}
?> 
