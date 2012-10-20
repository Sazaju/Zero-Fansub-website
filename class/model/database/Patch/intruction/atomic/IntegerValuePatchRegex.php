<?php
class IntegerValuePatchRegex extends AbstractRegexPatchInstruction {
	protected function getRegex() {
		return '[0-9]+';
	}
}
?>