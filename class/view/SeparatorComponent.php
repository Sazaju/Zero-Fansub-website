<?php
/*
	A separator is like a pin, except it is visible.
*/

class SeparatorComponent extends DefaultHtmlComponent {
	function __construct() {
		$this->setClass('separator');
		$this->generateHtml();
	}
	
	public function getHtmlTag() {
		return 'hr';
	}
	
	public function isAutoClose() {
		return false;
	}
	
	private static $instance = null;
	public static function getInstance() {
		if (SeparatorComponent::$instance === null) {
			SeparatorComponent::$instance = new SeparatorComponent();
		}
		return SeparatorComponent::$instance;
	}
}
?>