<?php
/*
	A pin is an invisible element allowing to fix some problematic points with the
	floating CSS positioning. As its code may not change, the generating of the
	HTML code is already done after the instanciation.
*/

class PageTitleComponent extends DefaultHtmlComponent {
	function __construct($title) {
		$this->setClass('pageTitle');
		$this->setContent($title);
	}
	
	public function getHtmlTag() {
		return 'h1';
	}
}
?>