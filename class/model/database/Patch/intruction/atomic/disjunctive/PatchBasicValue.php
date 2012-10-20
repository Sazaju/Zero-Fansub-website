<?php
class PatchBasicValue extends AlternativePatchInstruction {
	// TODO add variables or manage recursivity in order to manage not restricted only
	public function __construct() {
		parent::__construct(
				new StringValuePatchRegex(),
				new PatchBooleanValue(),
				new IntegerValuePatchRegex(),
				new PatchNullValue()
		);
	}
}
?>