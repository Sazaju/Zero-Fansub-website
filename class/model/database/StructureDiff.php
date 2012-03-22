<?php
class StructureDiff {
	private $diffs = array();
	
	public function addField($name) {
		$this->diffs[] = new FieldDiff(FieldDiff::FIELD, null, $name);
	}
	
	public function renameField($from, $to) {
		$this->diffs[] = new FieldDiff(FieldDiff::FIELD, $from, $to);
	}
	
	public function deleteField($name) {
		$this->diffs[] = new FieldDiff(FieldDiff::FIELD, $name, null);
	}
	
	public function changeTable($field, $from, $to) {
		$this->diffs[] = new FieldDiff(FieldDiff::TABLE, $from, $to, $field);
	}
	
	public function changeUnicity($field, $from, $to) {
		$this->diffs[] = new FieldDiff(FieldDiff::UNICITY, $from, $to, $field);
	}
	
	public function changeMandatory($field, $from, $to) {
		$this->diffs[] = new FieldDiff(FieldDiff::MANDATORY, $from, $to, $field);
	}
	
	public function changeKey($field, $from, $to) {
		$this->diffs[] = new FieldDiff(FieldDiff::KEY, $from, $to, $field);
	}
	
	public function changeTranslator($field, $from, $to) {
		$this->diffs[] = new FieldDiff(FieldDiff::TRANSLATOR, $from, $to, $field);
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
	private $focus = null;
	private $from = null;
	private $to = null;
	private $ref = null;
	
	public function __construct($focus, $from, $to, $ref = null) {
		$this->focus = $focus;
		$this->from = $from;
		$this->to = $to;
		$this->ref = $ref;
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
		return $this->focus == FieldDiff::TABLE && !empty($this->from) && !empty($this->to) && !empty($this->ref);
	}
	
	public function isChangedUnicity() {
		return $this->focus == FieldDiff::UNICITY && !empty($this->from) && !empty($this->to) && !empty($this->ref);
	}
	
	public function isChangedMandatory() {
		return $this->focus == FieldDiff::MANDATORY && !empty($this->from) && !empty($this->to) && !empty($this->ref);
	}
	
	public function isChangedKey() {
		return $this->focus == FieldDiff::KEY && !empty($this->from) && !empty($this->to) && !empty($this->ref);
	}
	
	public function isChangedTranslator() {
		return $this->focus == FieldDiff::TRANSLATOR && !empty($this->from) && !empty($this->to) && !empty($this->ref);
	}
	
	public function getOldField() {
		if ($this->focus == FieldDiff::FIELD) {
			return $this->from;
		} else {
			return $this->ref;
		}
	}
	
	public function getNewField() {
		if ($this->focus == FieldDiff::FIELD) {
			return $this->to;
		} else {
			return $this->ref;
		}
	}
	
	public function getOldValue() {
		if ($this->focus == FieldDiff::FIELD) {
			return null;
		} else {
			return $this->from;
		}
	}
	
	public function getNewValue() {
		if ($this->focus == FieldDiff::FIELD) {
			return null;
		} else {
			return $this->to;
		}
	}
	
	public function __toString() {
		if ($this->isAddedField()) {
			return '+'.$this->getNewField();
		} else if ($this->isDeletedField()) {
			return '-'.$this->getOldField();
		} else if ($this->isRenamedField()) {
			return $this->getOldField().'->'.$this->getNewField();
		} else {
			$oldState = $this->toString($this->focus, $this->getOldValue());
			$newState = $this->toString($this->focus, $this->getNewValue());
			return $this->getOldField().'['.$oldState.'->'.$newState.']';
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
