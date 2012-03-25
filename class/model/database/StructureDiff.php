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
		$this->diffs[] = new FieldDiff($class, $field, FieldDiff::FIELD, null, $field);
	}
	
	public function renameField($class, $from, $to) {
		$this->diffs[] = new FieldDiff($class, $from, FieldDiff::FIELD, $from, $to);
	}
	
	public function deleteField($class, $field) {
		$this->diffs[] = new FieldDiff($class, $field, FieldDiff::FIELD, $field, null);
	}
	
	public function changeTable($class, $field, $from, $to) {
		$this->diffs[] = new FieldDiff($class, $field, FieldDiff::TABLE, $from, $to, $field);
	}
	
	public function changeUnicity($class, $field, $from, $to) {
		$this->diffs[] = new FieldDiff($class, $field, FieldDiff::UNICITY, $from, $to, $field);
	}
	
	public function changeMandatory($class, $field, $from, $to) {
		$this->diffs[] = new FieldDiff($class, $field, FieldDiff::MANDATORY, $from, $to, $field);
	}
	
	public function changeKey($class, $field, $from, $to) {
		$this->diffs[] = new FieldDiff($class, $field, FieldDiff::KEY, $from, $to, $field);
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

class FieldDiff {
	const FIELD = 0;
	const TABLE = 1;
	const UNICITY = 2;
	const MANDATORY = 3;
	const KEY = 4;
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
	
	public function isAddedField() {
		return $this->focus == FieldDiff::FIELD && empty($this->from) && !empty($this->to);
	}
	
	public function isRenamedField() {
		return $this->focus == FieldDiff::FIELD && empty($this->from) && empty($this->to);
	}
	
	public function isDeletedField() {
		return $this->focus == FieldDiff::FIELD && !empty($this->from) && empty($this->to);
	}
	
	public function isChangedTable() {
		return $this->focus == FieldDiff::TABLE;
	}
	
	public function isChangedUnicity() {
		return $this->focus == FieldDiff::UNICITY;
	}
	
	public function isChangedMandatory() {
		return $this->focus == FieldDiff::MANDATORY;
	}
	
	public function isChangedKey() {
		return $this->focus == FieldDiff::KEY;
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
		if ($this->isAddedField()) {
			return $this->getClass().'+'.$this->getField();
		} else if ($this->isDeletedField()) {
			return $this->getClass().'-'.$this->getField();
		} else if ($this->isRenamedField()) {
			return $this->getClass().'.'.$this->getOldValue().'->'.$this->getNewValue();
		} else {
			$oldState = $this->toString($this->focus, $this->getOldValue());
			$newState = $this->toString($this->focus, $this->getNewValue());
			return $this->getClass().'.'.$this->getField().'['.$oldState.'->'.$newState.']';
		}
	}
	
	private function toString($type, $value) {
		switch($type) {
			case FieldDiff::TABLE:
				return "table ".$value;
			case FieldDiff::TRANSLATOR:
				return "translator ".$value;
			case FieldDiff::UNICITY:
				return $value ? "unique" : "not unique";
			case FieldDiff::MANDATORY:
				return $value ? "mandatory" : "not mandatory";
			case FieldDiff::KEY:
				return $value ? "key" : "not key";
			default:
				return "!!!ERROR: $type is not managed!!!";
		}
	}
}
?> 
