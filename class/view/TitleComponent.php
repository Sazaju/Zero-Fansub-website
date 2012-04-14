<?php
/*
	A title is the equivalent of a hX tag (h1, h2, etc.).
*/

class TitleComponent extends DefaultHtmlComponent {
	private $level = null;
	
	public function __construct($content, $level = 1) {
		$this->setLevel($level);
		$this->setContent($content);
	}
	
	public function getHtmlTag() {
		return 'h'.$this->level;
	}
	
	public function isAutoClose() {
		return false;
	}
	
	public function setLevel($level) {
		$this->level = $level;
	}
	
	public function getLevel() {
		return $this->level;
	}
}
?>