<?php
/*
	This is the default implementation of a paragraph (p tag). All the
	data given by the root tag of this component (p) can be setted through
	this implementation.
*/

require_once("defaulthtmlcomponent.php");

class Paragraph extends DefaultHtmlComponent {
	private $content = '';
	
	public function addText($text) {
		$this->content = $text;
	}
	
	public function addComponent(IHtmlComponent $component) {
		$component->generateHtml(); // TODO generate at the last moment ?
		$this->text = $component->getHtml();
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function generateHtml() {
		$id = $this->getId();
		$class = $this->getClass();
		$style = $this->getStyle();
		$idPart = !empty($id) ? ' id="'.$id.'"' : '';
		$classPart = !empty($class) ? ' class="'.$class.'"' : '';
		$stylePart = !empty($style) ? ' style="'.$style.'"' : '';
		$options = $idPart.$classPart.$stylePart;
		
		$this->html = '<p'.$options.'>'.$this->content.'</p>';
	}
	
	public function getHtml() {
		return $this->html;
	}
}
?>
