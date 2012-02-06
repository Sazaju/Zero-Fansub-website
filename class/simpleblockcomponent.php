<?php
/*
	This is the basic implementation of a block component (div tag).
*/

class SimpleBlockComponent extends DefaultHtmlComponent {
	
	public function getHtmlTag() {
		return 'div';
	}
}
?>