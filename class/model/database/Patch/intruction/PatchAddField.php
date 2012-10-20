<?php
class PatchAddField extends ComposedPatchInstruction implements IPatchCompleteInstruction {
	public function __construct() {
		parent::__construct('+',new PatchSelectField(),'(',new PatchFieldTypeValue(),',',new PatchFieldMandatoryValue(),')');
	}
	
	public function getClass() {
		return $this->getInnerInstruction(1)->getClass();
	}
	
	public function getField() {
		return $this->getInnerInstruction(1)->getField();
	}
	
	public function getType() {
		return $this->getInnerValue(3);
	}
	
	public function getMandatory() {
		return $this->getInnerValue(5);
	}
	
	public function getMandatoryAsBoolean() {
		return $this->getMandatory() == 'mandatory' ? true : false;
	}
}
?>