<?php
class PatchChangeFieldType extends ComposedPatchInstruction implements IPatchCompleteInstruction {
	public function __construct() {
		parent::__construct(new PatchSelectField(),'.type=',new PatchFieldTypeValue());
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getField() {
		return $this->getInnerInstruction(0)->getField();
	}
	
	public function getTypeValue() {
		return $this->getInnerValue(2);
	}
}
?>