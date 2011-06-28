<?php
/*
	A menu is a component giving a list of entries in a specific block.
*/

require_once("simpleblockcomponent.php");

class Menu extends SimpleBlockComponent {
	private $ordered = false;
	
	function __construct() {
		$this->setClass('menu');
	}
	
	public function setOrdered($bool) {
		$this->ordered = $bool;
	}
	
	public function isOrdered() {
		return $this->ordered;
	}
	
	public function addEntry($name, $link) {
		$this->content .= '<li><a href="'.$link.'">'.$name.'</a></li>';
	}
	
	public function getContent() {
		$tag = $this->isOrdered() ? 'ol' : 'ul';
		return '<'.$tag.'>'.$this->content.'</'.$tag.'>';
	}
}
?>
