<?php
class StringValuePatchRegex extends AbstractRegexPatchInstruction {
	protected function getRegex() {
		return '"(?:[^\\\\"]|(?:\\\\")|(?:\\\\\\\\))*"';
	}
}
?>