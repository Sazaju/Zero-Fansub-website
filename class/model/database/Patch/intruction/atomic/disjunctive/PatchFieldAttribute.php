<?php
class PatchFieldAttribute extends AlternativePatchInstruction {
	public function __construct() {
		parent::__construct(
				'type',
				'mandatory'
		);
	}
}
?>