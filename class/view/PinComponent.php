<?php
/*
	A pin is an invisible element allowing to fix some problematic points with the
	floating CSS positioning. As its code may not change, the generating of the
	HTML code is already done after the instanciation.
*/

class PinComponent extends DefaultHtmlComponent {
	function __construct() {
		$this->setClass('pin');
		$this->generateHtml();
	}
	
	public function getHtmlTag() {
		return 'hr';
	}
	
	public function isAutoClose() {
		return true;
	}
	
	private static $instance = null;
	public static function getInstance() {
		if (PinComponent::$instance === null) {
			PinComponent::$instance = new PinComponent();
		}
		return PinComponent::$instance;
	}
}
?>