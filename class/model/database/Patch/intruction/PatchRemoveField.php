<?php
class PatchRemoveField extends ComposedPatchInstruction implements IPatchCompleteInstruction {
	public function __construct() {
		parent::__construct('-',new PatchSelectField());
	}
	
	public function getClass() {
		return $this->getInnerInstruction(1)->getClass();
	}
	
	public function getField() {
		return $this->getInnerInstruction(1)->getField();
	}
}
?>