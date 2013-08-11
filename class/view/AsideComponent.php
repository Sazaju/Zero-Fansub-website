<?php
/*
	This is the basic implementation of an aside component (aside tag), which displays elements not related to the content of the page.
*/

class AsideComponent extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'aside';
	}
	
	public function isAutoClose() {
		return false;
	}
}
?>