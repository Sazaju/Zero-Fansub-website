<?php
/*
	This is the basic implementation of a list component (ul/ol tag). The list can be represented as
	an ordered (ol) or not ordered (ul) list, but the effective order of the elements displayed is
	strictly known (the order will be the same you choose to display it ordered or not).
*/

class SimpleListComponent extends DefaultHtmlComponent {
	private $isOrdered = false;
	private $components = array();
	
	public function getHtmlTag() {
		return $this->isOrdered ? 'ol' : 'ul';
	}
	
	public function addComponent($content) {
		parent::addComponent(new ListElement($content));
	}
	
}

class ListElement extends DefaultHtmlComponent {
	public function __construct($content) {
		if ($content instanceof IHtmlComponent) {
			$this->addComponent($content);
		}
		else {
			$this->setContent($content);
		}
	}
	
	public function getHtmlTag() {
		return 'li';
	}
}
?>
