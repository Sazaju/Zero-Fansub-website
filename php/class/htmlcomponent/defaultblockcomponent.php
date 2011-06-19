<?php
/*
	This is the default implementation of a block component. It gives a basic
	implementation of a component managing an ID, classes, style, ... . All the
	data given by the root tag of this component (div) can be setted through
	this implementation. Extend this class implies to give the content of this
	div, implementing the following methods :
	- public function generateInnerHtml()
	- public function getInnerHtml()
*/

require_once("ihtmlcomponent.php");

abstract class DefaultBlockComponent implements IHtmlComponent {
	private $html = '';
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
	
	abstract public function generateInnerHtml();
	abstract public function getInnerHtml();
	
	public function generateHtml() {
		$idPart = !empty($this->id) ? ' id="'.$this->id.'"' : '';
		$classPart = !empty($this->clazz) ? ' class="'.$this->clazz.'"' : '';
		$stylePart = !empty($this->style) ? ' style="'.$this->style.'"' : '';
		
		$this->generateInnerHtml();
		$options = $idPart.$classPart.$stylePart;
		$this->html = '<div'.$options.'>'.$this->getInnerHtml().'</div>';
	}
	
	public function getHtml() {
		return $this->html;
	}
}
?>
