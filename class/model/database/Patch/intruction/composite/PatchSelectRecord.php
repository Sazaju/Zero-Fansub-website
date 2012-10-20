<?php
class PatchSelectRecord extends ComposedPatchInstruction {
	public function __construct($useJoker) {
		parent::__construct(new ClassPatchRegex(),new PatchIDValues($useJoker));
	}
	
	public function getClass() {
		return $this->getInnerValue(0);
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(1)->getIDValues();
	}
}
?>