<?php
class PatchFieldValue extends AlternativePatchInstruction {
	public function __construct() {
		parent::__construct(
				new PatchBasicValue(),
				new PatchSelectRecordField(false)
		);
	}
}
?>