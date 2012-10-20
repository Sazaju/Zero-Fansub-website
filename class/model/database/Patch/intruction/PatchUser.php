<?php
class PatchUser extends ComposedPatchInstruction implements IPatchCompleteInstruction {
	public function __construct() {
		parent::__construct('user(',new StringValuePatchRegex(),new OptionalPatchInstruction(new ComposedPatchInstruction(',',new StringValuePatchRegex())),')');
	}
	
	public function getUser() {
		return Patch::cleanStringValue($this->getInnerValue(1));
	}
	
	public function getHash() {
		$i = $this->getInnerInstruction(2)->getSingleInstruction();
		return $i == null ? null : Patch::cleanStringValue($i->getInnerValue(1));
	}
}
?>