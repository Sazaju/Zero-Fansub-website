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
	
	public function getOldField() {
		if ($this->focus == FieldDiff::FIELD) {
			return $this->from;
		} else if ($this->focus == FieldDiff::TABLE) {
			return $this->ref;
		} else {
			throw new Exception('Not managed case');
		}
	}
	
	public function getNewField() {
		if ($this->focus == FieldDiff::FIELD) {
			return $this->to;
		} else if ($this->focus == FieldDiff::TABLE) {
			return $this->ref;
		} else {
			throw new Exception('Not managed case');
		}
	}
	
	public function getOldTable() {
		if ($this->focus == FieldDiff::FIELD) {
			return null;
		} else if ($this->focus == FieldDiff::TABLE) {
			return $this->from;
		} else {
			throw new Exception('Not managed case');
		}
	}
	
	public function getNewTable() {
		if ($this->focus == FieldDiff::FIELD) {
			return null;
		} else if ($this->focus == FieldDiff::TABLE) {
			return $this->to;
		} else {
			throw new Exception('Not managed case');
		}
	}
	
	public function __toString() {
		if ($this->isAddedField()) {
			return '+'.$this->getNewField();
		} else if ($this->isDeletedField()) {
			return '-'.$this->getOldField();
		} else if ($this->isRenamedField()) {
			return $this->getOlfField().'->'.$this->getNewField();
		} else if ($this->isChangedTable()) {
			return $this->getOlfField().'['.$this->getOldTable().'->'.$this->getNewTable().']';
		} else {
			'?';
		}
	}
}
?> 
