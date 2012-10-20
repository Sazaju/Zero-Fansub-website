<?php
class PatchChangeRecordField extends ComposedPatchInstruction implements IPatchCompleteInstruction {
	public function __construct() {
		parent::__construct(new PatchSelectRecordField(true),'=',new PatchFieldValue());
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(0)->getIDValues();
	}
	
	public function getField() {
		return $this->getInnerInstruction(0)->getField();
	}
	
	public function getFieldValue() {
		return $this->getInnerValue(2);
	}
}
?>