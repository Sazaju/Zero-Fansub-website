<?php
/*
	A new window link is a link already configured to open a new window.
*/

class NewWindowLink extends Link {
	public function __construct($url = '#', $content = null) {
		parent::__construct($url, $content);
		$this->openNewWindow(true);
	}
}
?>
