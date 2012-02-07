<?php
/*
	A simple paragraph is a simple container for paragraph (p).
*/

class SimpleParagraphComponent extends DefaultHtmlComponent {
	
	public function __construct($content = null) {
		$this->setContent($content);
	}
	
	public function isAutoClose() {
		return false;
	}
	
	public function getHtmlTag() {
		return 'p';
	}
}
?>