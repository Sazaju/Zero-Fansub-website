<?php
class PatchRemoveRecord extends ComposedPatchInstruction implements IPatchCompleteInstruction {
	public function __construct() {
		parent::__construct('-',new PatchSelectRecord(true));
	}
	
	public function getClass() {
		return $this->getInnerInstruction(1)->getClass();
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(1)->getIDValues();
	}
}
?>