<?php
/*
	This is the basic implementation of a block component (div tag).
*/

require_once("defaulthtmlcomponent.php");

class SimpleBlockComponent extends DefaultHtmlComponent {
	
	public function getHtmlTag() {
		return 'div';
	}
}
?>
