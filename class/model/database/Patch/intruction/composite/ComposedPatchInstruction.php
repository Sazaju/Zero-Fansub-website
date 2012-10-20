<?php
class ComposedPatchInstruction extends AbstractPatchInstruction {
	private $innerInstructions;
	
	public function __construct() {
		$this->innerInstructions = AbstractPatchInstruction::toInstructionOnly(func_get_args());
	}
	
	function __clone() {
		$innerInstructions = array();
		foreach($this->innerInstructions as $element) {
			$innerInstructions[] = clone $element;
		}
		$this->innerInstructions = $innerInstructions;
	}
	
	public function getInnerInstructions() {
		return $this->innerInstructions;
	}
	
	public function getInnerInstruction($index) {
		return $this->innerInstructions[$index];
	}
	
	private function generateRegex($catchInnerInstructions = false) {
		$globalRegex = "";
		foreach($this->innerInstructions as $element) {
			$regex = $element->getRegex();
			$regex = $catchInnerInstructions ? "($regex)" : "(?:$regex)";
			$globalRegex .= $regex;
		}
		return $globalRegex;
	}
	
	public function getInnerValues() {
		$innerValues = array();
		foreach($this->innerInstructions as $instruction) {
			$innerValues[] = $instruction->getValue();
		}
		return $innerValues;
	}
	
	public function getInnerValue($index) {
		return $this->innerInstructions[$index]->getValue();
	}
	
	protected function applyValue($instruction) {
		$regex = $this->generateRegex(true);
		preg_match('#^'.AbstractPatchInstruction::formatRegex($regex, '#').'$#s', $instruction, $matches);
		array_shift($matches); // remove the full match
		foreach($this->innerInstructions as $instruction) {
			$instruction->setValue(array_shift($matches));
		}
	}
	
	protected function getRegex() {
		return $this->generateRegex(false);
	}
}
?>