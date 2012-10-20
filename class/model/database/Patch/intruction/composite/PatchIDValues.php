<?php
class PatchIDValues extends ComposedPatchInstruction {
	public function __construct($useJoker) {
		parent::__construct('[',new ListPatchInstruction(
				($useJoker ? new AlternativePatchInstruction(new PatchBasicValue(), PATCH_ID_JOKER) : new PatchBasicValue())
				,','),']');
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(1)->getAllValues();
	}
}
?>