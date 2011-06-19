<?php
/*
	This is the default implementation of a block component (div tag). All the
	data given by the root tag of this component (div) can be setted through
	this implementation. Extend this class implies to give the content of this
	div, implementing the following methods :
	- public function generateInnerHtml()
	- public function getInnerHtml()
*/

require_once("defaulthtmlcomponent.php");

abstract class DefaultBlockComponent extends DefaultHtmlComponent {
	private $html = '';
	
	abstract public function generateInnerHtml();
	abstract public function getInnerHtml();
	
	public function generateHtml() {
		$id = $this->getId();
		$class = $this->getClass();
		$style = $this->getStyle();
		$idPart = !empty($id) ? ' id="'.$id.'"' : '';
		$classPart = !empty($class) ? ' class="'.$class.'"' : '';
		$stylePart = !empty($style) ? ' style="'.$style.'"' : '';
		$options = $idPart.$classPart.$stylePart;
		
		$this->generateInnerHtml();
		$this->html = '<div'.$options.'>'.$this->getInnerHtml().'</div>';
	}
	
	public function getHtml() {
		return $this->html;
	}
}
?>
