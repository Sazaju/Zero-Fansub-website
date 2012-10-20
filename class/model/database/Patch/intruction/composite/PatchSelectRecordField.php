<?php
class PatchSelectRecordField extends ComposedPatchInstruction {
	public function __construct($useJoker) {
		parent::__construct(new PatchSelectRecord($useJoker),'.',new FieldPatchRegex());
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(0)->getIDValues();
	}
	
	public function getField() {
		return $this->getInnerValue(2);
	}
}
?>