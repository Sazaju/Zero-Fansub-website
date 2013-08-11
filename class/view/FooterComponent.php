<?php
/*
	This is the basic implementation of a footer component (footer tag).
*/

class FooterComponent extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'footer';
	}
	
	public function isAutoClose() {
		return false;
	}
}
?>