<?php
/*
	This is the basic implementation of a header component (header tag).
*/

class HeaderComponent extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'header';
	}
	
	public function isAutoClose() {
		return false;
	}
}
?>