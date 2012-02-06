<?php
/*
	A separator is like a pin, except it is visible.
*/

class Separator extends DefaultHtmlComponent {
	function __construct() {
		$this->setClass('separator');
		$this->generateHtml();
	}
	
	public function getHtmlTag() {
		return 'hr';
	}
	
	private static $instance = null;
	public static function getInstance() {
		if (Separator::$instance === null) {
			Separator::$instance = new Separator();
		}
		return Separator::$instance;
	}
}
?>