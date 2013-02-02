<?php
class RecordHistory {
	private $fields = array();
	
	public function addUpdate($field, $value, $from, $authorFrom, $to = null, $authorTo = null) {
		if (!array_key_exists($field, $this->fields)) {
			$this->fields[$field] = new FieldValueHistory();
		} else {
			// do not overwrite it
		}
		
		$history = $this->fields[$field];
		if ($to === null && $authorTo === null) {
			$history->addUpdate($value, $from, $authorFrom);
		} else {
			$history->addUpdate($value, $from, $authorFrom, $to, $authorTo);
		}
	}
	
	public function getAllFields() {
		return array_keys($this->fields);
	}
	
	public function getUpdateTimes() {
		$times = array();
		foreach($this->fields as $field) {
			$times = array_merge($times, $field->getUpdateTimes());
		}
		$times = array_unique($times);
		return $times;
	}
	
	public function getUpdatesAt($time) {
		$updates = array();
		foreach($this->fields as $field => $history) {
			if ($history->isUpdatedAt($time)) {
				$updates[$field] = $history->getValueAt($time);
			} else {
				continue;
			}
		}
		return $updates;
	}
	
	public function getValuesAt($time) {
		$values = array();
		foreach($this->fields as $field => $history) {
			$values[$field] = $history->getValueAt($time);
		}
		return $values;
	}
	
	public function getAuthorAt($time) {
		$authorRef = null;
		foreach($this->fields as $field => $history) {
			$author = $history->getAuthorAt($time);
			if ($authorRef === null) {
				$authorRef = $author;
			} else if ($authorRef == $author) {
				// everything is OK, should be the same
			} else {
				throw new Exception("At least two authors seems to have modified a record at the same time ($author & $authorRef). This should not be feasible.");
			}
		}
		return $authorRef;
	}
}

class FieldValueHistory {
	private $values = array();
	private $authors = array();
	
	public function addUpdate($value, $from, $authorFrom, $to = PHP_INT_MAX, $authorTo = null) {
		settype($from, 'int');
		settype($to, 'int');
		$this->checkFree($from, $to);
		
		$this->checkAuthor($from, $authorFrom);
		$this->values[$from] = $value;
		$this->authors[$from] = $authorFrom;
		
		if ($authorTo === null) {
			// indefinite period
		} else {
			$this->checkAuthor($to, $authorTo);
			$this->values[$to] = isset($this->values[$to]) ? $this->values[$to] : null;
			$this->authors[$to] = $authorTo;
		}
	}
	
	public function isUpdatedAt($time) {
		return array_key_exists($time, $this->values);
	}
	
	public function getValues() {
		return $this->values;
	}
	
	public function getValueAt($time) {
		if ($this->isUpdatedAt($time)) {
			return $this->values[$time];
		} else {
			$timeRef = 0;
			$valueRef = null;
			foreach($this->values as $cursor => $value) {
				if ($cursor >= $timeRef && $cursor <= $time) {
					$timeRef = $cursor;
					$valueRef = $value;
				} else {
					continue;
				}
			}
			return $valueRef;
		}
	}
	
	public function getAuthors() {
		return $this->authors;
	}
	
	public function getAuthorAt($time) {
		if ($this->isUpdatedAt($time)) {
			return $this->authors[$time];
		} else {
			$timeRef = 0;
			$authorRef = null;
			foreach($this->authors as $cursor => $author) {
				if ($cursor >= $timeRef && $cursor <= $time) {
					$timeRef = $cursor;
					$authorRef = $author;
				} else {
					continue;
				}
			}
			return $authorRef;
		}
	}
	
	public function getUpdateTimes() {
		return array_keys($this->values);
	}
	
	private function checkAuthor($time, $author) {
		if (!array_key_exists($time, $this->authors) || $this->authors[$time] == $author) {
			return;
		} else {
			throw new Exception("Author clash at $time: $author vs. ".$this->authors[$time]);
		}
	}
	
	private function checkFree($from, $to) {
		if ($from >= $to) {
			throw new Exception("The start time should be strictly inferior to the stop time ($from < $to).");
		} else {
			// continue
		}
		
		ksort($this->values);
		
		// find period concerned in known periods
		$fromRef = 0;
		$toRef = PHP_INT_MAX;
		foreach($this->values as $time => $value) {
			if ($time > $fromRef && $time <= $from) {
				$fromRef = $time;
			} else if ($time < $toRef && $time >= $to) {
				$toRef = $time;
			} else {
				// ignore it
			}
		}
		
		// find not null values conflicting
		foreach($this->values as $time => $value) {
			if ($time >= $fromRef && $time < $toRef && $value !== null) {
				throw new Exception("Overlapping between ($from, $to) and ($fromRef, $toRef) which contains '$value'.");
			} else {
				// ignore it
			}
		}
		return;
	}
}
?>