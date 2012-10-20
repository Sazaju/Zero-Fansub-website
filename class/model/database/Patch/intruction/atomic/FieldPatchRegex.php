<?php
class FieldPatchRegex extends AbstractRegexPatchInstruction {
	protected function getRegex() {
		return '[0-9a-zA-Z]+';
	}
}
?>