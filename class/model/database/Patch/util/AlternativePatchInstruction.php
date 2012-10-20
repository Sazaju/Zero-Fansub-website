<?php
class AlternativePatchInstruction extends AbstractPatchInstruction {
	private $alternatives;
	private $compatibleInstruction;
	
	public function __construct() {
		$this->alternatives = AbstractPatchInstruction::toInstructionOnly(func_get_args());
	}
	
	function __clone() {
		$alternatives = array();
		foreach($this->alternatives as $element) {
			$alternatives[] = clone $element;
		}
		$this->alternatives = $alternatives;
		$this->compatibleInstruction = $this->compatibleInstruction === null ? null : clone $this->compatibleInstruction;
	}
	
	public function getAlternatives() {
		return $this->alternatives;
	}
	
	protected function getRegex() {
		$globaleRegex = "";
		foreach($this->alternatives as $instruction) {
			$regex = $instruction->getRegex();
			$globaleRegex .= "|(?:$regex)";
		}
		$globaleRegex = substr($globaleRegex, 1);
		return "(?:$globaleRegex)";
	}
	
	protected function applyValue($value) {
		foreach($this->alternatives as $instruction) {
			if ($instruction->isSyntaxicallyCompatible($value)) {
				$instruction->setValue($value);
				$this->compatibleInstruction = $instruction;
			} else {
				continue;
			}
		}
	}
	
	public function getCompatibleInstruction() {
		return $this->compatibleInstruction;
	}
}
?>