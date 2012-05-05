<?php
class PersistentComponent {
	private $internalKey = null;
	private $IDFields = array();
	private $registeredFields = array();
	private $lock = false;
	
	public function setInternalKey($key) {
		$this->internalKey = $key;
	}
	
	public function getInternalKey() {
		return $this->internalKey;
	}
	
	public function setIDFields() {
		$this->stressLock();
		
		$fields = array();
		foreach(func_get_args() as $index => $field) {
			if (in_array($field, $this->getPersistentFields(), true)) {
				if (in_array($field, $fields)) {
					throw new Exception("You cannot put the same field (".$name.") twice in the key");
				} else {
					$name = array_search($field, $this->getPersistentFields(), true);
					$fields[$name] = $field;
				}
			} else {
				throw new Exception($field." at the index ".$index." is not a registered field");
			}
		}
		$this->IDFields = $fields;
	}
	
	public function getIDFields() {
		return $this->IDFields;
	}
	
	public function getClass() {
		return get_class($this);
	}
	
	// function with variable list of arguments
	protected function registerPersistentFields() {
		$this->stressLock();
		
		$fields = func_get_args();
		if (count($fields) > 0) {
			// check only persistent fields given
			foreach($fields as $field) {
				if ($field instanceof PersistentField) {
					// continue
				} else {
					throw new Exception($field." is not a persistent field");
				}
			}
			
			// find properties which are persistent fields
			$reflector = new ReflectionClass($this);
			$properties = $reflector->getProperties();
			$candidates = array();
			foreach($properties as $property) {
				$property->setAccessible(true);
				$value = $property->getValue($this);
				if ($value instanceof PersistentField) {
					$candidates[$property->getName()] = $value;
				}
			}
			
			// check and add fields
			foreach($fields as $field) {
				if (in_array($field, $candidates, true)) {
					$name = array_search($field, $candidates, true);
					if (in_array($field, $this->registeredFields, true)) {
						$key = array_search($field, $this->registeredFields, true);
						if ($key == $name) {
							// already registered field, ignore
						} else {
							throw new Exception($field." is already registered for ".$key.", you should not register it for ".$name);
						}
					} else {
						if (isset($this->registeredFields[$name])) {
							throw new Exception($name." is already registered with another field");
						} else {
							$this->registeredFields[$name] = $field;
						}
					}
				} else {
					throw new Exception($field." is not assigned to a property of the persistent component");
				}
			}
		}
	}
	
	public function lockPersistentDefinition() {
		$this->lock = true;
		foreach($this->registeredFields as $name => $field) {
			$field->lock();
		}
	}
	
	public function isPersistentDefinitionLocked() {
		return $this->lock;
	}
	
	private function stressLock() {
		if ($this->lock) {
			throw new Exception("This component is locked.");
		} else {
			// all green
		}
	}
	
	public function getPersistentFields() {
		return $this->registeredFields;
	}
	
	public function getPersistentField($name) {
		$fields = $this->getPersistentFields();
		if (array_key_exists($name, $fields)) {
			return $fields[$name];
		} else {
			throw new Exception("No '$name' field defined for this ".$this->getClass());
		}
	}
	
	public function save($author) {
		Database::getDefaultDatabase()->save($this, $author);
	}
	
	public function load() {
		Database::getDefaultDatabase()->load($this);
	}
	
	public function getIDString() {
		$keyValues = array();
		foreach($this->getIDFields() as $name => $field) {
			$keyValues[] = $field->get();
		}
		return '('.implode(', ', $keyValues).')';
	}
	
	public function __toString() {
		$key = $this->getInternalKey();
		if ($key === null) {
			$key = '-';
		}
		return $this->getClass().$this->getIDString()."[key $key]";
	}
}
?> 
