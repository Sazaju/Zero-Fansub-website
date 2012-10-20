<?php
class StringTypePatchRegex extends AbstractRegexPatchInstruction {
	protected function getRegex() {
		return 'string(?:[1-9][0-9]*)?';
	}
}
?>