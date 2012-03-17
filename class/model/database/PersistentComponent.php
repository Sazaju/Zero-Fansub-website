<?php
class PersistentComponent {
	private $persistentUniqueKey = null;
	
	public function setInternalKey($key) {
		$this->persistentUniqueKey = $key;
	}
	
	public function getInternalKey() {
		return $this->persistentUniqueKey;
	}
	
	public function getClass() {
		return get_class($this);
	}
	
	public function getPersistentFields() {
		$reflector = new ReflectionClass($this);
		$properties = $reflector->getProperties();
		
		$fields = array();
		foreach($properties as $property) {
			$property->setAccessible(true);
			$value = $property->getValue($this);
			if ($value instanceof PersistentField) {
				$fields[$property->getName()] = $value;
			}
		}
		return $fields;
	}
	
	public function getPersistentField($name) {
		$fields = $this->getPersistentFields();
		if (array_key_exists($name, $fields)) {
			return $fields[$name];
		} else {
			throw new Exception("No '$name' field defined for this ".$this->getClass());
		}
	}
	
	public function getKeyName() {
		foreach($this->getPersistentFields() as $name => $field) {
			if ($field->isKey()) {
				return $name;
			} else {
				// not yet find, just continue
			}
		}
		throw new Exception("No key field defined for this ".$this->getClass());
	}
	
	public function save($author) {
		Database::getDefaultDatabase()->save($this, $author);
	}
	
	public function load() {
		Database::getDefaultDatabase()->load($this);
	}
	
	public function __toString() {
		$key = $this->getInternalKey();
		if ($key === null) {
			$key = '-';
		}
		return $this->getClass().' '.$this->getPersistentField($this->getKeyName())->get()." (key $key)";
	}
}
?> 
