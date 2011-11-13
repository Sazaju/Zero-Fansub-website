<?php
/*
	An anchor allows to go to a specific place of a web page. It is used after the # character in
	URLs.
*/

class Anchor extends DefaultHtmlComponent {
	private $name = null;
	
	public function __construct($name = 'anchor') {
		$this->setName($name);
	}
	
	public function getHtmlTag() {
		return 'a';
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setOnClick($javascript) {
		$this->onClick = $javascript;
	}
	
	public function getOnClick() {
		return $this->onClick;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getOptions() {
		$name = $this->getName();
		$namePart = $name === null ? '' : ' name="'.$name.'"';
		return parent::getOptions().$namePart;
	}
}
?>
