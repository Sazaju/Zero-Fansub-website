<?php
class PatchAttributes extends ComposedPatchInstruction implements IPatchCompleteInstruction {
	public function __construct() {
		parent::__construct('[time=',new IntegerValuePatchRegex(),',user=',new StringValuePatchRegex(),']');
	}
	
	public function getTime() {
		return $this->getInnerValue(1);
	}
	
	public function getUser() {
		return Patch::cleanStringValue($this->getInnerValue(3));
	}
}
?>