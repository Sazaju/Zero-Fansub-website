<?php
class TextPatchInstruction extends AbstractRegexPatchInstruction {
	private $text;
	
	public function __construct($text) {
		$this->text = $text;
	}
	
	protected function getRegex() {
		return preg_quote($this->text);
	}
}
?>