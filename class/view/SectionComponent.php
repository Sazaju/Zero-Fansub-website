<?php
/*
	This is the basic implementation of a section component (section tag), which is linked to the sections just before/after.
*/

class SectionComponent extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'section';
	}
	
	public function isAutoClose() {
		return false;
	}
}
?>