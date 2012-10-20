<?php
class RepetitivePatchInstruction extends AbstractPatchInstruction {
	private $instructions = array();
	private $reference;
	private $min;
	private $max;
	
	public function __construct(AbstractPatchInstruction $reference, $min = 0, $max = null) {
		$this->reference = $reference;
		$this->min = $min;
		$this->max = $max;
	}
	
	function __clone() {
		$this->reference = clone $this->reference;
		$instructions = array();
		foreach($this->instructions as $element) {
			$instructions[] = clone $element;
		}
		$this->instructions = $instructions;
	}
	
	public function getReference() {
		return $this->reference;
	}
	
	public function getMin() {
		$this->min = $min;
	}
	
	public function getMax() {
		$this->max = $max;
	}
	
	protected function getRegex() {
		$regex = $this->reference->getRegex();
		$min = $this->min;
		$max = $this->max;
		if ($min === 0 && $max === null) {
			$regex = "(?:$regex)*";
		} else if ($min === 1 && $max === null) {
			$regex = "(?:$regex)+";
		} else if ($min === 0 && $max === 1) {
			$regex = "(?:$regex)?";
		} else if ($min === $max) {
			$regex = "(?:$regex)\{$min\}";
		} else {
			$regex = "(?:$regex)\{$min,$max\}";
		}
		return $regex;
	}
	
	protected function applyValue($value) {
		$regex = $this->reference->getRegex();
		$this->instructions = array();
		while(!empty($value)) {
			$matches = array();
			preg_match('#^('.AbstractPatchInstruction::formatRegex($regex, '#').').*$#s', $value, $matches);
			$chunk = $matches[1];
			$instruction = clone $this->reference;
			$instruction->setValue($chunk);
			$this->instructions[] = $instruction;
			$value = substr($value, strlen($chunk));
		}
	}
	
	public function getAllValues() {
		$values = array();
		foreach($this->instructions as $instruction) {
			$values[] = $instruction->getValue();
		}
		return $values;
	}
	
	public function getAllInstructions() {
		return $this->instructions;
	}
}
?>