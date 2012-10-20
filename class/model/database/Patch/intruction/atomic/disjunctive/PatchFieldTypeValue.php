<?php
class PatchFieldTypeValue extends AlternativePatchInstruction {
	public function __construct() {
		parent::__construct(
				'boolean',
				'integer',
				'double',
				'array',
				'resource',
				new StringTypePatchRegex()
		);
	}
}
?>