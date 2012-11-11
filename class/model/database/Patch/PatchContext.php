<?php
/*
	Each querying function (is...) return a boolean value (true/false) if the answer is known, null otherwise.
*/
class PatchContext {
	private $classes = array();
	
	public function createClass($class) {
		$this->classes[$class] = new ClassData();
	}
	
	public function deleteClass($class) {
		$this->class = $classes[$class];
		$this->class->delete();
	}
	
	public function isExistingClass($class) {
		$answer = null;
		if (array_key_exists($class, $this->class)) {
			$classData = $this->class[$class];
			$answer = !$classData->isDeleted();
		} else {
			// no info about the class
		}
		return $answer;
	}
	
	public function createField($class, $field) {
		if ($this->isExistingClass($class) !== true) {
			$this->createClass($class);
		} else {
			// do not recreate it
		}
		$classData = $this->class[$class];
		$classData->addField($field, new FieldData());
	}
	
	public function isExistingField($class, $field) {
		$answer = null;
		if ($this->isExistingClass($class) === false) {
			$answer = false;
		} else if ($this->isExistingClass($class) === true) {
			$classData = $this->class[$class];
			$fields = $classData->getFields();
			if (array_key_exists($field, $fields)) {
				$fieldData = $fields[$field];
				$answer = !$fieldData->isDeleted();
			} else {
				// class exists, but no info about the field
			}
		} else {
			// do not know if the class exists, so do not know if the field exists
		}
		return $answer;
	}
	
	public function getFieldDataCreatedIfUnkown($class, $field) {
		if ($this->isExistingField($class, $field) === false) {
			throw new Exception("$class.$field is deleted");
		} else {
			if ($this->isExistingField($class, $field) === null) {
				$this->createField($class, $field);
			} else {
				// do not recreate it
			}
			$classData = $this->class[$class];
			$fields = $classData->getFields();
			return $fields[$field];
		}
	}
	
	public function setFieldType($class, $field, $type) {
		$fieldData = $this->getFieldDataCreatedIfUnkown($class, $field);
		$fieldData->setType($type);
	}
	
	public function setFieldTypeCompatibleWithValue($class, $field, $value) {
		$fieldData = $this->getFieldDataCreatedIfUnkown($class, $field);
		$fieldData->considerValue($value);
	}
	
	public function isFieldCompatible($class, $field, $value) {
		$answer = null;
		if ($this->isExistingField($class, $field) === false) {
			throw new Exception("$class.$field is deleted");
		} else if ($this->isExistingField($class, $field) === true) {
			$fieldData = $this->getFieldDataCreatedIfUnkown($class, $field)
			$answer = $fieldData->isCompatible($value);
		} else {
			// no info about the field
		}
		return $answer;
	}
	
	public function setFieldMandatory($class, $field, $mandatory) {
		$fieldData = $this->getFieldDataCreatedIfUnkown($class, $field);
		$fieldData->setMandatory($mandatory);
	}
	
	public function isFieldMandatory($class, $field) {
		$answer = null;
		if ($this->isExistingField($class, $field) === false) {
			throw new Exception("$class.$field is deleted");
		} else if ($this->isExistingField($class, $field) === true) {
			$fieldData = $this->getFieldDataCreatedIfUnkown($class, $field)
			$answer = $fieldData->isMandatory();
		} else {
			// no info about the field
		}
		return $answer;
	}
	
	public function deleteField($class, $field) {
		$fieldData = $this->getFieldDataCreatedIfUnkown($class, $field);
		$fieldData->delete();
	}
	
}

class TypeData {
	private $type;
	private static $INFINITY = -log(0);
	
	public function __construct($type = null) {
		$this->setType($type);
	}
	
	public function setType($type) {
		if (in_array($type, array('boolean', 'array', 'double'))) {
			// keep the value as is
		} else if ($type == "string") {
			$type = "string<".TypeData::$INFINITY;
		} else if (preg_match("#string[0-9]+#", $type)) {
			$type = "string<".substr($type, 6);
		} else if ($type === null) {
			$type = '*';
		} else {
			// TODO resource
			throw new Exception("'$value' cannot be assigned a type");
		}
		$this->type = $type;
	}
	
	public function crossValue($value) {
		$t2 = new TypeData();
		if ($value == "true" || $value == "false") {
			$t2->type = 'boolean';
		} else if (preg_match ('#^".*"$#', $value)) {
			$t2->type = 'string>'.(strlen($value)-2);
		} else if (is_array($value)) {
			$t2->type = 'array';
		} else if (is_numeric($value)) {
			$value = doubleval($value);
			$t2->type = $value % 1 == 0
				? 'numeric'
				: 'double';
		} else {
			// TODO resource
			throw new Exception("'$value' cannot be assigned a type");
		}
		$this->crossType($t2);
	}
	
	public function crossType(TypeData $t2) {
		if ($this->type == '*') {
			$this->type = $t2->type;
		} else if ($this->type == 'boolean' || $this->type == 'array') {
			$this->type = $t2->type == $this->type // no cross compatibility types
				? $this->type
				: null;
		} else if ($this->type == 'numeric') {
			$this->type = $t2->type == $this->type || $t2->type == 'double' || $t2->type == 'integer'
						? $t2->type // $t2 more restrictive
						: null;
		} else if ($this->type == 'integer' || $this->type == 'double') {
			$this->type = $t2->type == $this->type || $t2->type == 'numeric'
				? $this->type // $this more restrictive
				: null;
		} else if (substr($this->type, 0, 6) == 'string') {
			if (substr($t2->type, 0, 6) == 'string') {
				$extractMin = function($string) {
					$r1 = intval(substr($string, 6, 1));
					if ($r1 == '>') {
						return intval(substr($string, 7));
					} else if ($r1 == '<' && $r2 == '>') {
						return 0;
					} else if ($r1 == '=' && $r2 == '>') {
						return intval(substr($string, 7));
					} else if ($r1 == '~' && $r2 == '>') {
						$p = strpos($string, '-', 7);
						return intval(substr($string, 7, p-7-1));
					} else {
						throw new Exception("This case should not happen: $string");
					}
				}
				$extractMax = function($string) {
					$r1 = intval(substr($string, 6, 1));
					if ($r1 == '>') {
						return TypeData::$INFINITY;
					} else if ($r1 == '<' && $r2 == '>') {
						return intval(substr($string, 7));
					} else if ($r1 == '=' && $r2 == '>') {
						return intval(substr($string, 7));
					} else if ($r1 == '~' && $r2 == '>') {
						$p = strpos($string, '-', 7);
						return intval(substr($string, p+1));
					} else {
						throw new Exception("This case should not happen: $string");
					}
				}
				
				$min = max($extractMin($this->type), $extractMin($t2->type));
				$max = min($extractMax($this->type), $extractMax($t2->type));
				if (is_infinite($max)) {
					$this->type = "string>$min";
				} else if ($min = 0) {
					$this->type = "string<$max";
				} else if ($min == $max) {
					$this->type = "string=$max";
				} else if ($min < $max) {
					$this->type = "string~$min-$max";
				} else if ($min > $max) {
					$this->type = null;
				} else {
					throw new Exception("This case should not happen");
				}
			} else {
				$this->type = null;
			}
		} else {
			throw new Exception("Cannot cross types ".$this->type." and ".$t2->type);
		}
	}
	
	public function isInvalid() {
		return $this->type !== null;
	}
}

class FieldData {
	private $deleted = false;
	public function delete() {
		$this->deleted = true;
	}
	
	public function isDeleted() {
		return $this->deleted;
	}
	
	private $type = new TypeData();
	public function considerValue($value) {
		$this->type->crossValue($value);
	}
	
	public function isCompatible($value) {
		$t2 = new TypeData();
		$t2->crossType($this->type);
		$t2->crossValue($value);
		return $t2->isInvalid();
	}
	
	private $mandatory = null;
	public function setMandatory($mandatory) {
		$this->mandatory = $mandatory;
	}
	
	public function isMandatory() {
		return $this->mandatory;
	}
}

class ClassData {
	// TODO consider IDs
	private $deleted = false;
	public function delete() {
		$this->deleted = true;
		foreach($this->getFields() as $field) {
			$field->delete();
		}
	}
	
	public function isDeleted() {
		return $this->deleted;
	}
	
	private $fields = array();
	public function addField($field, FieldData $data) {
		$this->fields[$field] = $data;
	}
	
	public function getFields() {
		return $this->fields;
	}
}
?>