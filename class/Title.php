<?php
/*
	A title is the equivalent of a hX tag (h1, h2, etc.).
*/

class Title extends DefaultHtmlComponent {
	private $level = 1;
	
	public function __construct($content, $level = 1) {
		$this->setLevel($level);
		if ($content instanceof IHtmlComponent) {
			$this->addComponent($content);
		}
		else {
			$this->setContent($content === null ? $url : $content);
		}
	}
	
	public function getHtmlTag() {
		return 'h'.$this->level;
	}
	
	public function setLevel($level) {
		$this->level = $level;
	}
	
	public function getLevel() {
		return $this->level;
	}
}
?>
