<?php
/*
	A simple text is a simple container for text (span tag).
*/

require_once('defaulthtmlcomponent.php');

class SimpleTextComponent extends DefaulthtmlComponent {
	private $html = '';
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
		
		$this->html = '<span'.$options.'>'.$this->content.'</span>';
	}
	
	public function getHtml() {
		return $this->html;
	}
}
?>
