<?php
class PatchAddRecord extends ComposedPatchInstruction implements IPatchCompleteInstruction {
	public function __construct() {
		parent::__construct('+',new PatchSelectRecord(false),new PatchChainFieldValueAssignment());
	}
	
	public function getClass() {
		return $this->getInnerInstruction(1)->getClass();
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(1)->getIDValues();
	}
	
	public function getAssignments() {
		return $this->getInnerInstruction(2)->getAssignments();
	}
}
?>