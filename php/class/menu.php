<?php
/*
	A menu is a component giving a list of entries in a specific block.
*/

require_once("defaultblockcomponent.php");

class Menu extends DefaultBlockComponent {
	private $innerHtml = '';
	private $entries = array();
	private $ordered = false;
	
	public function setOrdered($bool) {
		$this->ordered = $bool;
	}
	
	public function isOrdered() {
		return $this->ordered;
	}
	
	public function addEntry($name, $link) {
		$this->entries[$name] = $link;
	}
	
	public function removeEntry($name) {
		$this->entries[$name] = null;
		array_filter($this->entries);
	}
	
	public function getEntries() {
		return $this->entries;
	}
	
	public function generateInnerHtml() {
		$content = '';
		foreach($this->entries as $name => $link) {
			$content .= '<li><a href="'.$link.'">'.$name.'</a></li>';
		}
		$tag = $this->isOrdered() ? 'ol' : 'ul';
		$content = "<$tag>".$content."</$tag>";
		$this->innerHtml = $content;
	}
	
	public function getInnerHtml() {
		return $this->innerHtml;
	}
}
?>