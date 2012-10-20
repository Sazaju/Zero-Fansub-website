<?php
class PatchIDFields extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct('[',new ListPatchInstruction(new FieldPatchRegex(),','),']');
	}
	
	public function getIDFields() {
		return $this->getInnerInstruction(1)->getAllValues();
	}
}
?>