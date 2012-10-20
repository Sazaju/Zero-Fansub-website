<?php
class PatchNullValue extends TextPatchInstruction {
	public function __construct() {
		parent::__construct("null");
	}
}
?>