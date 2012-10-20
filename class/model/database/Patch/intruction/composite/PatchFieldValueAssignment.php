<?php
class PatchFieldValueAssignment extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct(new FieldPatchRegex(),'=',new PatchFieldValue());
	}
	
	public function getField() {
		return $this->getInnerValue(0);
	}
	
	public function getFieldValue() {
		return $this->getInnerValue(2);
	}
}
?>