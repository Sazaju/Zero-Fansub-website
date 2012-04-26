<?php
class StructureDiff {
	private $diffs = array();
	
	public function __construct($array = null) {
		if ($array !== null) {
			foreach($array as $entry) {
				if ($entry instanceof FieldDiff) {
					// ok, continue
				} else {
					throw new Exception("It must be an array of FieldDiff, one entry is a ".get_class($entry));
				}
			}
			$this->diffs = $array;
		}
	}
	
	public function addField($class, $field) {
		$this->diffs[] = new ComponentDiff($class, ComponentDiff::FIELDS, null, $field);
	}
	
	public function renameField($class, $from, $to) {
		$this->diffs[] = new ComponentDiff($class, ComponentDiff::FIELDS, $from, $to);
	}
	
	public function deleteField($class, $field) {
		$this->diffs[] = new ComponentDiff($class, ComponentDiff::FIELDS, $field, null);
	}
	
	public function changeTable($class, $field, $from, $to) {
		$this->diffs[] = new FieldDiff($class, $field, FieldDiff::TABLE, $from, $to, $field);
	}
	
	public function changeMandatory($class, $field, $from, $to) {
		$this->diffs[] = new FieldDiff($class, $field, FieldDiff::MANDATORY, $from, $to, $field);
	}
	
	public function changeKey($class, $from, $to) {
		$this->diffs[] = new ComponentDiff($class, ComponentDiff::KEY, $from, $to);
	}
	
	public function changeTranslator($class, $field, $from, $to) {
		$this->diffs[] = new FieldDiff($class, $field, FieldDiff::TRANSLATOR, $from, $to);
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

class ElementDiff {}

class FieldDiff extends ElementDiff {
	const TABLE = 1;
	const MANDATORY = 3;
	const TRANSLATOR = 5;
	private $class = null;
	private $field = null;
	private $focus = null;
	private $from = null;
	private $to = null;
	private $patch = null;
	
	public function __construct($class, $field, $focus, $from, $to) {
		$this->class = $class;
		$this->field = $field;
		$this->focus = $focus;
		$this->from = $from;
		$this->to = $to;
	}
	
	public function setPatch($patch) {
		$this->patch = $patch;
	}
	
	public function getPatch() {
		return $this->patch;
	}
	
	public function isChangedTable() {
		return $this->focus == FieldDiff::TABLE;
	}
	
	public function isChangedMandatory() {
		return $this->focus == FieldDiff::MANDATORY;
	}
	
	public function isChangedTranslator() {
		return $this->focus == FieldDiff::TRANSLATOR;
	}
	
	public function getClass() {
		return $this->class;
	}
	
	public function getField() {
		return $this->field;
	}
	
	public function getOldValue() {
		return $this->from;
	}
	
	public function getNewValue() {
		return $this->to;
	}
	
	public function __toString() {
		$oldState = $this->toString($this->focus, $this->getOldValue());
		$newState = $this->toString($this->focus, $this->getNewValue());
		return $this->getClass().'.'.$this->getField().'['.$oldState.'->'.$newState.']';
	}
	
	private function toString($type, $value) {
		switch($type) {
			case FieldDiff::TABLE:
				return "table ".$value;
			case FieldDiff::TRANSLATOR:
				return "translator ".$value;
			case FieldDiff::MANDATORY:
				return $value ? "mandatory" : "not mandatory";
			default:
				return "!!!ERROR: $type is not managed!!!";
		}
	}
}

class ComponentDiff extends ElementDiff {
	const KEY = 0;
	const FIELDS = 1;
	private $class = null;
	private $focus = null;
	private $from = null;
	private $to = null;
	private $patch = null;
	
	public function __construct($class, $focus, $from, $to) {
		$this->class = $class;
		$this->focus = $focus;
		$this->from = $from;
		$this->to = $to;
	}
	
	public function setPatch($patch) {
		$this->patch = $patch;
	}
	
	public function getPatch() {
		return $this->patch;
	}
	
	public function isAddedField() {
		return $this->focus == ComponentDiff::FIELDS && empty($this->from) && !empty($this->to);
	}
	
	public function isRenamedField() {
		return $this->focus == ComponentDiff::FIELDS && empty($this->from) && empty($this->to);
	}
	
	public function isDeletedField() {
		return $this->focus == ComponentDiff::FIELDS && !empty($this->from) && empty($this->to);
	}
	
	public function isChangedKey() {
		return $this->focus == ComponentDiff::KEY;
	}
	
	public function getClass() {
		return $this->class;
	}
	
	public function getOldValue() {
		return $this->from;
	}
	
	public function getNewValue() {
		return $this->to;
	}
	
	public function __toString() {
		if ($this->isAddedField()) {
			return $this->getClass().'+'.$this->getNewValue();
		} else if ($this->isDeletedField()) {
			return $this->getClass().'-'.$this->getOldValue();
		} else if ($this->isRenamedField()) {
			return $this->getClass().'.'.$this->getOldValue().'->'.$this->getNewValue();
		} else {
			$oldState = $this->toString($this->focus, $this->getOldValue());
			$newState = $this->toString($this->focus, $this->getNewValue());
			return $this->getClass().'['.$oldState.'->'.$newState.']';
		}
	}
	
	private function toString($type, $value) {
		if (is_array($value)) {
			$value = implode(", ", $value);
		} else {
			// let as is
		}
		
		if ($value == null) {
			$value = "(empty)";
		} else {
			// let as is
		}
		
		switch($type) {
			case ComponentDiff::KEY:
				return "key ".$value;
			default:
				return "!!!ERROR: $type is not managed!!!";
		}
	}
}
?> 
