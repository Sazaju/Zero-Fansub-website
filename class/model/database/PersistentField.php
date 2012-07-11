<?php
class PersistentField {
	private $type = null;
	private $length = null;
	private $mandatory = false;
	private $translator = null;
	private $lock = false;
	private $value = null;
	
	private function __construct($type, $length = null) {
		$this->translator = new DefaultPersistentFieldTranslator();
		if (empty($type)) {
			throw new Exception('A type must be given.');
		} else {
			$this->type = $type;
			$this->length = $length;
		}
	}
	
	public function isBoolean() {
		return $this->type === "boolean";
	}
	
	public function isInteger() {
		return $this->type === "integer";
	}
	
	public function isDouble() {
		return $this->type === "double";
	}
	
	public function isArray() {
		return $this->type === "array";
	}
	
	public function isResource() {
		return $this->type === "resource";
	}
	
	public function isString() {
		return $this->type === "string";
	}
	
	public function isObject($type) {
		return $this->type === $type;
	}
	
	public function isCustomized() {
		return !in_array($this->type, array("boolean", "integer", "double", "array", "resource", "string"));
	}
	
	public function getBasicType() {
		return $this->type;
	}
	
	public function getLength() {
		return $this->length;
	}
	
	public function hasLength() {
		return $this->length !== null;
	}
	
	public static function booleanField() {
		return new PersistentField("boolean");
	}
	
	public static function integerField() {
		return new PersistentField("integer");
	}
	
	public static function doubleField() {
		return new PersistentField("double");
	}
	
	public static function arrayField() {
		return new PersistentField("array");
	}
	
	public static function resourceField() {
		return new PersistentField("resource");
	}
	
	public static function stringField($length = null) {
		return new PersistentField("string", $length);
	}
	
	public static function objectField($class) {
		return new PersistentField($class);
	}
	
	public function mandatory() {
		$this->stressLock();
		$this->mandatory = true;
		return $this;
	}
	
	public function isMandatory() {
		return $this->mandatory;
	}
	
	public function lock() {
		$this->lock = true;
		return $this;
	}
	
	private function stressLock() {
		if ($this->lock) {
			throw new Exception("This field descriptor is locked.");
		} else {
			// all green
		}
	}
	
	public function set($value) {
		$type = gettype($value);
		if ($type === 'object') {
			$type = get_class($value);
		}
		if (!$this->type === $type) {
			throw new Exception('The given value has the type '.$type.', not '.$this->type);
		} else {
			$this->value = $value;
		}
	}
	
	public function get() {
		return $this->value;
	}
	
	public function translateWith(IPersistentFieldTranslator $translator) {
		$this->stressLock();
		$this->translator = $translator;
		return $this;
	}
	
	public function getTranslator() {
		return $this->translator;
	}
	
	public function __toString() {
		return $this->type.'['.$this->value.']';
	}
}
?> 
