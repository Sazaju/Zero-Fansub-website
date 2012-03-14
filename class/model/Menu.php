<?php
/*
	A menu is a component giving a list of entries in a specific block.
*/

class Menu {
	private $title = null;
	private $entries = array();
	
	public function __construct($title = null) {
		$this->setTitle($title);
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function addEntry($entry) {
		$this->entries[] = $entry;
	}
	
	public function clearEntries() {
		$this->entries = array();
	}
	
	public function getEntries() {
		return $this->entries;
	}
}
?>