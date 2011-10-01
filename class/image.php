<?php
/*
	An image is a simple picture which can have some attributes.
*/

class Image extends DefaultHtmlComponent {
	private $source = '';
	private $alternative = '';
	private $title = '';
	
	public function __construct($source = '', $title = '') {
		$this->source = $source;
		$this->title = $title;
		$this->alternative = $title;
	}
	
	public function getHtmlTag() {
		return 'img';
	}
	
	public function setUrl($url) {
		$this->source = $url;
	}
	
	public function getUrl() {
		return $this->source;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setAlternative($alt) {
		$this->alternative = $alt;
	}
	
	public function getAlternative() {
		return $this->alternative;
	}
	
	public function getOptions() {
		$source = $this->getUrl();
		$alt = $this->getAlternative();
		$title = $this->getTitle();
		$sourcePart = ' src="'.$source.'"';
		$altPart = !empty($alt) ? ' alt="'.$alt.'"' : '';
		$titlePart = !empty($title) ? ' title="'.$title.'"' : '';
		return parent::getOptions().$sourcePart.$titlePart.$altPart;
	}
}
?>
