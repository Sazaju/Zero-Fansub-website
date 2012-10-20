<?php
class PatchBooleanValue extends AlternativePatchInstruction {
	public function __construct() {
		parent::__construct(
				'true',
				'false'
		);
	}
}
?>