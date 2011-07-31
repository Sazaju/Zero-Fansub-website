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
	
	public function getComponents() {
		return $this->components;
	}
	
	public function add(IHtmlComponent $component) {
		$this->components[] = $component;
	}
	
	public function clear() {
		$components = array();
	}
	
	public function getContent() {
		$content = '';
		
		foreach($this->components as $component) {
			$component->generateHtml();
			$content .= '<li>'.$component->getHtml().'</li>';
		}
		
		return $content;
	}
}
?>
