<?php
/*
	This is the basic implementation of a navigation component (nav tag), which displays major navigation links (no concrete rule on how to decide what is a major link).
*/

class NavigationComponent extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'nav';
	}
	
	public function isAutoClose() {
		return false;
	}
}
?>