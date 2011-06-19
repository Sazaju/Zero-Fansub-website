<?php
/*
	An image is a simple picture which can have some attributes.
*/

require_once("defaulthtmlcomponent.php");

class Image extends DefaultHtmlComponent {
	private $html = '';
	private $source = '';
	private $alternative = '';
	
	public function setSource($url) {
		$this->source = $url;
	}
	
	public function getSource() {
		return $this->source;
	}
	
	public function setAlternative($alt) {
		$this->alternative = $alt;
	}
	
	public function getAlternative() {
		return $this->alternative;
	}
	
	public function generateHtml() {
		$id = $this->getId();
		$class = $this->getClass();
		$style = $this->getStyle();
		$source = $this->getSource();
		$alt = $this->getAlternative();
		$idPart = !empty($id) ? ' id="'.$id.'"' : '';
		$classPart = !empty($class) ? ' class="'.$class.'"' : '';
		$stylePart = !empty($style) ? ' style="'.$style.'"' : '';
		$sourcePart = ' src="'.$source.'"';
		$altPart = !empty($alt) ? ' alt="'.$alt.'"' : '';
		$options = $idPart.$classPart.$stylePart.$sourcePart.$altPart;
		
		$this->html = '<img'.$options.' />';
	}
	
	public function getHtml() {
		return $this->html;
	}
}
?>
