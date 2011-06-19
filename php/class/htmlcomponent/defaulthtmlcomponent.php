<?php
/*
	This is the default implementation of a HTML component. It gives the basic
	setters/getters for the basic options (ID, class, style). Extend this class 
	implies to implement the HTML generation methods :
	- public function generateHtml()
	- public function getHtml()
*/

require_once("ihtmlcomponent.php");

abstract class DefaultHtmlComponent implements IHtmlComponent {
	private $id = '';
	private $clazz = '';
	private $style = '';
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setClass($class) {
		$this->clazz = $class;
	}
	
	public function getClass() {
		return $this->clazz;
	}
	
	public function setStyle($style) {
		$this->style = $style;
	}
	
	public function getStyle() {
		return $this->style;
	}
}
?>
