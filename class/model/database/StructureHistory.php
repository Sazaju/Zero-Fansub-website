<?php
class StructureHistory {
	private $fields = array();
	private $name = null;
	
	public function __construct() {
		$this->name = new ClassNameHistory();
	}
	
	public function addFieldNameUpdate($fieldId, $name, $from, $authorFrom, $to = null, $authorTo = null) {
		if (!array_key_exists($fieldId, $this->fields)) {
			$this->fields[$fieldId] = new FieldStructureHistory();
		} else {
			// do not overwrite it
		}
		
		$history = $this->fields[$fieldId];
		if ($to === null && $authorTo === null) {
			$history->addNameUpdate($name, $from, $authorFrom);
		} else {
			$history->addNameUpdate($name, $from, $authorFrom, $to, $authorTo);
		}
	}
	
	public function addFieldTypeUpdate($fieldId, $type, $from, $authorFrom, $to = null, $authorTo = null) {
		if (!array_key_exists($fieldId, $this->fields)) {
			$this->fields[$fieldId] = new FieldStructureHistory();
		} else {
			// do not overwrite it
		}
		
		$history = $this->fields[$fieldId];
		if ($to === null && $authorTo === null) {
			$history->addTypeUpdate($type, $from, $authorFrom);
		} else {
			$history->addTypeUpdate($type, $from, $authorFrom, $to, $authorTo);
		}
	}
	
	public function addFieldMandatoryUpdate($fieldId, $mandatory, $from, $authorFrom, $to = null, $authorTo = null) {
		if (!array_key_exists($fieldId, $this->fields)) {
			$this->fields[$fieldId] = new FieldStructureHistory();
		} else {
			// do not overwrite it
		}
		
		$history = $this->fields[$fieldId];
		if ($to === null && $authorTo === null) {
			$history->addMandatoryUpdate($mandatory, $from, $authorFrom);
		} else {
			$history->addMandatoryUpdate($mandatory, $from, $authorFrom, $to, $authorTo);
		}
	}
	
	public function addClassNameUpdate($name, $from, $authorFrom, $to = null, $authorTo = null) {
		$history = $this->name;
		if ($to === null && $authorTo === null) {
			$history->addNameUpdate($name, $from, $authorFrom);
		} else {
			$history->addNameUpdate($name, $from, $authorFrom, $to, $authorTo);
		}
	}
	
	public function getAllFieldIds() {
		return array_keys($this->fields);
	}
	
	public function getUpdateTimes() {
		$times = array();
		$histories = array_values($this->fields);
		$histories[] = $this->name;
		foreach($histories as $field) {
			$times = array_merge($times, $field->getUpdateTimes());
		}
		$times = array_unique($times);
		return $times;
	}
	
	public function getFieldsUpdatesAt($time) {
		$updates = array();
		foreach($this->fields as $fieldId => $history) {
			if ($history->isUpdatedAt($time)) {
				if ($history->isNameUpdatedAt($time)) {
					$updates[$fieldId]['name'] = $history->getNameAt($time);
				} else {
					// do not create the entry.
				}
				if ($history->isTypeUpdatedAt($time)) {
					$updates[$fieldId]['type'] = $history->getTypeAt($time);
				} else {
					// do not create the entry.
				}
				if ($history->isMandatoryUpdatedAt($time)) {
					$updates[$fieldId]['mandatory'] = $history->getMandatoryAt($time);
				} else {
					// do not create the entry.
				}
			} else {
				continue;
			}
		}
		return $updates;
	}
	
	public function getNameUpdateAt($time) {
		if ($this->name->isUpdatedAt($time)) {
			return $this->name->getNameAt($time);
		} else {
			return null;
		}
	}
	
	public function getFieldsValuesAt($time) {
		$values = array();
		foreach($this->fields as $fieldId => $history) {
			$values[$fieldId]['name'] = $history->getNameAt($time);
			$values[$fieldId]['type'] = $history->getTypeAt($time);
			$values[$fieldId]['mandatory'] = $history->getMandatoryAt($time);
		}
		return $values;
	}
	
	public function getNameValueAt($time) {
		return $this->name->getValueAt($time);
	}
	
	public function getAuthorAt($time) {
		$authorRef = null;
		$timeRef = null;
		$histories = array_values($this->fields);
		$histories[] = $this->name;
		foreach($histories as $history) {
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
					throw new Exception("At least two authors seems to have modified the structure at the same time ($author & $authorRef at $time). This should not be feasible.");
				}
			}
		}
		return $authorRef;
	}
}

class ClassNameHistory {
	private $names = array();
	private $authors = array();
	
	private function addGenericUpdate(&$array, $value, $from, $authorFrom, $to = PHP_INT_MAX, $authorTo = null) {
		settype($from, 'int');
		settype($to, 'int');
		$this->checkFree($array, $from, $to);
		
		$this->checkAuthor($from, $authorFrom);
		$array[$from] = $value;
		$this->authors[$from] = $authorFrom;
		
		if ($authorTo === null) {
			// indefinite period
		} else {
			$this->checkAuthor($to, $authorTo);
			$array[$to] = isset($array[$to]) ? $array[$to] : null;
			$this->authors[$to] = $authorTo;
		}
	}
	
	public function addNameUpdate($name, $from, $authorFrom, $to = PHP_INT_MAX, $authorTo = null) {
		$this->addGenericUpdate($this->names, $name, $from, $authorFrom, $to, $authorTo);
	}
	
	public function isUpdatedAt($time) {
		return array_key_exists($time, $this->authors);
	}
	
	public function getNames() {
		return $this->names;
	}
	
	public function getAuthors() {
		return $this->authors;
	}
	
	public function getGenericValueAt(&$array, $time) {
		if (array_key_exists($time, $array)) {
			return $array[$time];
		} else {
			$timeRef = 0;
			$valueRef = null;
			foreach($array as $cursor => $value) {
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
	
	public function getNameAt($time) {
		return $this->getGenericValueAt($this->names, $time);
	}
	
	public function getAuthorAt($time) {
		return $this->getGenericValueAt($this->authors, $time);
	}
	
	public function getUpdateTimes() {
		return array_keys($this->authors);
	}
	
	private function checkAuthor($time, $author) {
		if (!array_key_exists($time, $this->authors) || $this->authors[$time] == $author) {
			return;
		} else {
			throw new Exception("Author clash at $time: $author vs. ".$this->authors[$time]);
		}
	}
	
	private function checkFree(&$array, $from, $to) {
		if ($from >= $to) {
			throw new Exception("The start time should be strictly inferior to the stop time ($from < $to).");
		} else {
			// continue
		}
		
		ksort($array);
		
		// find period concerned in known periods
		$fromRef = 0;
		$toRef = PHP_INT_MAX;
		foreach($array as $time => $value) {
			if ($time > $fromRef && $time <= $from) {
				$fromRef = $time;
			} else if ($time < $toRef && $time >= $to) {
				$toRef = $time;
			} else {
				// ignore it
			}
		}
		
		// find not null values conflicting
		foreach($array as $time => $value) {
			if ($time >= $fromRef && $time < $toRef && $value !== null) {
				throw new Exception("Overlapping between ($from, $to) and ($fromRef, $toRef).");
			} else {
				// ignore it
			}
		}
		return;
	}
}

class FieldStructureHistory {
	private $names = array();
	private $types = array();
	private $mandatories = array();
	private $authors = array();
	
	private function addGenericUpdate(&$array, $value, $from, $authorFrom, $to = PHP_INT_MAX, $authorTo = null) {
		settype($from, 'int');
		settype($to, 'int');
		$this->checkFree($array, $from, $to);
		
		$this->checkAuthor($from, $authorFrom);
		$array[$from] = $value;
		$this->authors[$from] = $authorFrom;
		
		if ($authorTo === null) {
			// indefinite period
		} else {
			$this->checkAuthor($to, $authorTo);
			$array[$to] = isset($array[$to]) ? $array[$to] : null;
			$this->authors[$to] = $authorTo;
		}
	}
	
	public function addTypeUpdate($type, $from, $authorFrom, $to = PHP_INT_MAX, $authorTo = null) {
		$this->addGenericUpdate($this->types, $type, $from, $authorFrom, $to, $authorTo);
	}
	
	public function addMandatoryUpdate($mandatory, $from, $authorFrom, $to = PHP_INT_MAX, $authorTo = null) {
		$this->addGenericUpdate($this->mandatories, $mandatory, $from, $authorFrom, $to, $authorTo);
	}
	
	public function addNameUpdate($name, $from, $authorFrom, $to = PHP_INT_MAX, $authorTo = null) {
		$this->addGenericUpdate($this->names, $name, $from, $authorFrom, $to, $authorTo);
	}
	
	public function isUpdatedAt($time) {
		return array_key_exists($time, $this->authors);
	}
	
	public function isNameUpdatedAt($time) {
		return array_key_exists($time, $this->names);
	}
	
	public function isTypeUpdatedAt($time) {
		return array_key_exists($time, $this->types);
	}
	
	public function isMandatoryUpdatedAt($time) {
		return array_key_exists($time, $this->mandatories);
	}
	
	public function getNames() {
		return $this->names;
	}
	
	public function getTypes() {
		return $this->types;
	}
	
	public function getMandatories() {
		return $this->mandatories;
	}
	
	public function getAuthors() {
		return $this->authors;
	}
	
	public function getGenericValueAt(&$array, $time) {
		if ($this->isUpdatedAt($time)) {
			return $array[$time];
		} else {
			$timeRef = 0;
			$valueRef = null;
			foreach($array as $cursor => $value) {
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
	
	public function getNameAt($time) {
		return $this->getGenericValueAt($this->names, $time);
	}
	
	public function getTypeAt($time) {
		return $this->getGenericValueAt($this->types, $time);
	}
	
	public function getMandatoryAt($time) {
		return $this->getGenericValueAt($this->mandatories, $time);
	}
	
	public function getAuthorAt($time) {
		return $this->getGenericValueAt($this->authors, $time);
	}
	
	public function getUpdateTimes() {
		return array_keys($this->authors);
	}
	
	private function checkAuthor($time, $author) {
		if (!array_key_exists($time, $this->authors) || $this->authors[$time] == $author) {
			return;
		} else {
			throw new Exception("Author clash at $time: $author vs. ".$this->authors[$time]);
		}
	}
	
	private function checkFree(&$array, $from, $to) {
		if ($from >= $to) {
			throw new Exception("The start time should be strictly inferior to the stop time ($from < $to).");
		} else {
			// continue
		}
		
		ksort($array);
		
		// find period concerned in known periods
		$fromRef = 0;
		$toRef = PHP_INT_MAX;
		foreach($array as $time => $value) {
			if ($time > $fromRef && $time <= $from) {
				$fromRef = $time;
			} else if ($time < $toRef && $time >= $to) {
				$toRef = $time;
			} else {
				// ignore it
			}
		}
		
		// find not null values conflicting
		foreach($array as $time => $value) {
			if ($time >= $fromRef && $time < $toRef && $value !== null) {
				throw new Exception("Overlapping between ($from, $to) and ($fromRef, $toRef).");
			} else {
				// ignore it
			}
		}
		return;
	}
}
?>