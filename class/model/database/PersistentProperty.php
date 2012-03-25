<?php
class PersistentProperty extends PersistentComponent {
	private $name = null;
	private $value = null;
	
	public function __construct($name, $value = null) {
		$this->name = PersistentField::stringField(100)->forget()->key()->lock();
		$this->value = PersistentField::stringField(100)->forget()->lock();
		
		if (empty($name)) {
			throw new Exception("The property must have a name");
		}
		
		$this->name = $name;
		$this->value = $value;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setValue($value) {
		$this->value = $value;
	}
	
	public function getValue() {
		return $this->value;
	}
}
?> 
