<?php
class PatchChangeFieldMandatory extends ComposedPatchInstruction implements IPatchCompleteInstruction {
	public function __construct() {
		parent::__construct(new PatchSelectField(),'.mandatory=',new PatchFieldMandatoryValue());
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getField() {
		return $this->getInnerInstruction(0)->getField();
	}
	
	public function getMandatoryValue() {
		return $this->getInnerValue(2);
	}
	
	public function getMandatoryBooleanValue() {
		return $this->getMandatoryValue() == 'mandatory';
	}
}
?>