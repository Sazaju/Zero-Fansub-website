<?php
class OptionalPatchInstruction extends RepetitivePatchInstruction {
	public function __construct(AbstractPatchInstruction $instruction) {
		parent::__construct($instruction, 0, 1);
	}
	
	public function getSingleInstruction() {
		$instructions = $this->getAllInstructions();
		return array_shift($instructions);
	}
}
?>