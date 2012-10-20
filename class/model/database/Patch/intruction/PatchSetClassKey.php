<?php
class PatchSetClassKey extends ComposedPatchInstruction implements IPatchCompleteInstruction {
	public function __construct() {
		parent::__construct(new ClassPatchRegex(),'=',new PatchIDFields());
	}
	
	public function getClass() {
		return $this->getInnerValue(0);
	}
	
	public function getIDFields() {
		return $this->getInnerInstruction(2)->getIDFields();
	}
}
?>