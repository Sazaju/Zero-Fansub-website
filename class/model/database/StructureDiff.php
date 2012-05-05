<?php
class StructureDiff {
	private $diffs = array();
	
	public function addDiff(ElementDiff $diff) {
		$this->diffs[] = $diff;
	}
	
	public function toArray() {
		return $this->diffs;
	}
	
	public function __toString() {
		try {
			$string = "";
			foreach($this->diffs as $diff) {
				$string .= ', '.$diff;
			}
			return '{'.substr($string, 2).'}';
		} catch(Exception $ex) {
			return $ex->getMessage();
		}
	}
	
	public function isEmpty() {
		return empty($this->diffs);
	}
}

abstract class ElementDiff {
	private $oldValue = null;
	private $newValue = null;
	
	public function __construct($oldValue, $newValue) {
		$this->oldValue = $oldValue;
		$this->newValue = $newValue;
	}
	
	public function getOldValue() {
		return $this->oldValue;
	}
	
	public function getNewValue() {
		return $this->newValue;
	}
	
	public function __toString() {
		$oldState = $this->toString($this->getOldValue());
		$newState = $this->toString($this->getNewValue());
		return $this->getNameString().'['.$this->getOperationString().']';
	}
	
	private function toString($value) {
		if (is_array($value)) {
			$value = print_r($value, true);//'['.implode(", ", $value).']';
		} else if ($value == null) {
			$value = "(empty)";
		} else {
			// let as is
		}
		return $value;
	}
	
	abstract protected function getNameString();
	abstract protected function getOperationString();
}

abstract class ComponentDiff extends ElementDiff {
	private $class = null;
	
	public function __construct($class, $oldValue, $newValue) {
		parent::__construct($oldValue, $newValue);
		$this->class = $class;
	}
	
	public function getClass() {
		return $this->class;
	}
	
	protected function getNameString() {
		return $this->class;
	}
}

abstract class FieldDiff extends ElementDiff {
	private $class = null;
	private $field = null;
	
	public function __construct($class, $field, $oldValue, $newValue) {
		parent::__construct($oldValue, $newValue);
		$this->class = $class;
		$this->field = $field;
	}
	
	public function getClass() {
		return $this->class;
	}
	
	public function getField() {
		return $this->field;
	}
	
	protected function getNameString() {
		return $this->class.'.'.$this->field;
	}
}

class AddFieldDiff extends ComponentDiff {
	public function __construct($class, $field, PersistentTable $table, $mandatory, $translator) {
		parent::__construct($class, null, array(
				'field' => $field,
				'table' => $table,
				'mandatory' => $mandatory,
				'translator' => $translator
		));
	}
	
	protected function getOperationString() {
		$data = $this->getNewValue();
		return "fields +".$data['field'];
	}
}

class RemoveFieldDiff extends ComponentDiff {
	public function __construct($class, $field, $type, $mandatory, $translator) {
		parent::__construct($class, array(
				'field' => $field,
				'type' => $type,
				'mandatory' => $mandatory,
				'translator' => $translator
		), null);
	}
	
	protected function getOperationString() {
		$data = $this->getOldValue();
		return "fields -".$data['field'];
	}
}

class RenameFieldDiff extends ComponentDiff {
	public function __construct($class, $oldName, $newName) {
		parent::__construct($class, $oldName, $newName);
	}
	
	protected function getOperationString() {
		return "field ".$this->getOldValue().'->'.$this->getNewValue();
	}
}

class ChangeKeyDiff extends ComponentDiff {
	public function __construct($class, $oldKeys, $newKeys) {
		parent::__construct($class, $oldKeys, $newKeys);
	}
	
	protected function getOperationString() {
		$from = '('.implode(', ', $this->getOldValue()).')';
		$to = '('.implode(', ', $this->getNewValue()).')';
		return "key ".$from.'->'.$to;
	}
}

class ChangeTypeDiff extends FieldDiff {
	public function __construct($class, $field, $oldType, $newType) {
		parent::__construct($class, $field, $oldType, $newType);
	}
	
	protected function getOperationString() {
		return "type ".$this->getOldValue().'->'.$this->getNewValue();
	}
}

class ChangeMandatoryDiff extends FieldDiff {
	public function __construct($class, $field, $oldStatus, $newStatus) {
		parent::__construct($class, $field, $oldStatus, $newStatus);
	}
	
	protected function getOperationString() {
		return "mandatory ".$this->getOldValue().'->'.$this->getNewValue();
	}
}

class ChangeTranslatorDiff extends FieldDiff {
	public function __construct($class, $field, $oldTranslator, $newTranslator) {
		parent::__construct($class, $field, $oldTranslator, $newTranslator);
	}
	
	protected function getOperationString() {
		return "translator ".$this->getOldValue().'->'.$this->getNewValue();
	}
}
?>