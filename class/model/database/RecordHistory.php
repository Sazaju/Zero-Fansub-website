<?php
class RecordHistory {
	const ABSENT = "absent";
	
	// TODO consider the structure history to display the full history of the record (removed fields)
	private $fields = array();
	
	public function addUpdate($fieldId, $value, $from, $authorFrom, $to = null, $authorTo = null) {
		if (!array_key_exists($fieldId, $this->fields)) {
			$this->fields[$fieldId] = new FieldValueHistory();
		} else {
			// do not overwrite it
		}
		
		$history = $this->fields[$fieldId];
		if ($to === null && $authorTo === null) {
			$history->addUpdate($value, $from, $authorFrom);
		} else {
			$history->addUpdate($value, $from, $authorFrom, $to, $authorTo);
		}
	}
	
	public function getAllFieldIds() {
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
		foreach($this->fields as $fieldId => $history) {
			if ($history->isUpdatedAt($time)) {
				$updates[$fieldId] = $history->getValueAt($time);
			} else {
				continue;
			}
		}
		return $updates;
	}
	
	public function getValuesAt($time) {
		$values = array();
		foreach($this->fields as $fieldId => $history) {
			$values[$fieldId] = $history->getValueAt($time);
		}
		return $values;
	}
	
	public function getAuthorAt($time) {
		$authorRef = null;
		$timeRef = null;
		foreach($this->fields as $history) {
			$times = $history->getUpdateTimes();
			rsort($times);
			while(!empty($times) && $times[0] > $time) {
				array_shift($times);
			}
			if (empty($times)) {
				// too recent field, ignore it
			} else {
				$author = $history->getAuthorAt($times[0]);
				if ($authorRef === null || $timeRef < $times[0]) {
					$authorRef = $author;
					$timeRef = $times[0];
				} else if ($timeRef > $times[0]) {
					// we already have a better one, ignore it
				} else if ($authorRef == $author) {
					// everything is OK, should be the same
				} else {
					throw new Exception("At least two authors seems to have modified the record at the same time ($author & $authorRef at $time). This should not be feasible.");
				}
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
			$this->values[$to] = isset($this->values[$to]) ? $this->values[$to] : RecordHistory::ABSENT;
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
			$valueRef = RecordHistory::ABSENT;
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
			if ($time >= $fromRef && $time < $toRef && $value !== RecordHistory::ABSENT) {
				throw new Exception("Overlapping between ($from, $to) and ($fromRef, $toRef) which contains '$value'.");
			} else {
				// ignore it
			}
		}
		return;
	}
}
?>