<?php
abstract class AbstractPatchInstruction {
	abstract protected function getRegex();
	abstract protected function applyValue($value);
	
	private $value;
	public function setValue($value) {
		if ($this->isSyntaxicallyCompatible($value)) {
			$this->value = $value;
			$this->applyValue($value);
		} else {
			throw new Exception("Incompatible value for ".get_class($this).": $value");
		}
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public static function formatRegex($regex, $delimiter) {
		if (strlen($delimiter) > 1) {
			throw new Exception("The delimiter should be a single character");
		} else if ($delimiter == ' ' || $delimiter == '\\') {
			throw new Exception("The delimiter cannot be a space nor a backslash");
		} else {
			return str_replace($delimiter, '\\'.$delimiter, $regex);
		}
	}
	
	public static function toInstructionOnly($array) {
		$result = array();
		foreach($array as $element) {
			if (is_string($element)) {
				$result[] = new TextPatchInstruction($element);
			} else if ($element instanceof AbstractPatchInstruction) {
				$result[] = $element;
			} else {
				throw new Exception("$element is not an instruction");
			}
		}
		return $result;
	}
	
	public function getFormattedRegex($delimiter) {
		return AbstractPatchInstruction::formatRegex($this->getRegex(), $delimiter);
	}
	
	public function isSyntaxicallyCompatible($value) {
		return preg_match('#^'.$this->getFormattedRegex('#').'$#s', $value);
	}
}
?>