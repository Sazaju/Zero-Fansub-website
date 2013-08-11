<?php
class PageTitle extends DefaultHtmlComponent {
	function __construct($title) {
		$this->setClass('pageTitle');
		$this->setContent($title);
	}
	
	public function getHtmlTag() {
		return 'h1';
	}
}
?>