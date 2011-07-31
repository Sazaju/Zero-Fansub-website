<?php
/*
	A menu is a component giving a list of entries in a specific block.
*/

class Menu extends DefaultHtmlComponent {
	private $ordered = false;
	
	function __construct() {
		$this->setClass('menu');
	}
	
	public function getHtmlTag() {
		return $this->isOrdered() ? 'ol' : 'ul';;
	}
	
	public function setOrdered($bool) {
		$this->ordered = $bool;
	}
	
	public function isOrdered() {
		return $this->ordered;
	}
	
	public function addEntry(Link $link) {
		$link->generateHtml();
		$this->setContent($this->getContent().'<li>'.$link->getHtml().'</li>');
	}
}
?>
