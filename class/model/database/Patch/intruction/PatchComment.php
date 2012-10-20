<?php
class PatchComment extends RegexPatchInstruction implements IPatchCompleteInstruction {
	protected function getRegex() {
		return '#[^\n]*\n';
	}
}
?>