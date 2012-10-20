<?php
class PatchSelectField extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct(new ClassPatchRegex(),'.',new FieldPatchRegex());
	}
	
	public function getClass() {
		return $this->getInnerValue(0);
	}
	
	public function getField() {
		return $this->getInnerValue(2);
	}
}
?>