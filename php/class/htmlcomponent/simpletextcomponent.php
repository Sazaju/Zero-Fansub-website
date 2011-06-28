<?php
/*
	A simple text is a simple container for text (span).
*/

require_once('defaulthtmlcomponent.php');

class SimpleTextComponent extends DefaulthtmlComponent {
	public function getHtmlTag() {
		return 'span';
	}
}
?>
