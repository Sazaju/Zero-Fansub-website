<?php
/*
	An image is a simple picture which can have some attributes.
*/

require_once("defaulthtmlcomponent.php");

class Image extends DefaultHtmlComponent {
	private $source = '';
	private $alternative = '';
	
	public function getHtmlTag() {
		return 'img';
	}
	
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
	
	public function getOptions() {
		$source = $this->getSource();
		$alt = $this->getAlternative();
		$sourcePart = ' src="'.$source.'"';
		$altPart = !empty($alt) ? ' alt="'.$alt.'"' : '';
		return parent::getOptions().$sourcePart.$altPart;
	}
}
?>
