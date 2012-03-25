<?php
/*
	A simple text is a simple container for text (span).
*/

class SimpleTextComponent extends DefaultHtmlComponent {
	public function __construct($content = null) {
		$this->setContent($content);
	}
	
	public function addLine($component = null) {
		$this->addComponent($component);
		$this->addComponent("<br />");
	}
	
	public function getHtmlTag() {
		return 'span';
	}
	
	public function isAutoClose() {
		return false;
	}
}
?>