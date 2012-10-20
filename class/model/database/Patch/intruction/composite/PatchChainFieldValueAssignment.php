<?php
class PatchChainFieldValueAssignment extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct('(',new ListPatchInstruction(new PatchFieldValueAssignment(),','),')');
	}
	
	public function getAssignments() {
		$assignments = array();
		foreach($this->getInnerInstruction(1)->getAllInstructions() as $instruction) {
			$assignments[$instruction->getField()] = $instruction->getFieldValue();
		}
		return $assignments;
	}
}
?>