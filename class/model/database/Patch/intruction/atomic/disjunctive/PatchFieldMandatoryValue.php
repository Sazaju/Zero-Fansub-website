<?php
class PatchFieldMandatoryValue extends AlternativePatchInstruction {
	public function __construct() {
		parent::__construct(
				'mandatory',
				'optional'
		);
	}
}
?>