<?php
/*
	An image is a simple picture which can have some attributes.
*/

class ImageComponent extends DefaultHtmlComponent {
	private $source = null;
	private $alternative = '';
	private $title = '';
	
	public function __construct($source = '', $title = '') {
		$this->setUrl($source);
		$this->title = $title;
		$this->alternative = $title;
	}
	
	public function getHtmlTag() {
		return 'img';
	}
	
	public function isAutoClose() {
		return true;
	}
	
	public function setUrl($url) {
		$this->source = $url == null ? null : new Url($url);
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
		$sourcePart = ' src="'.$source->toString().'"';
		$altPart = ' alt="'.htmlspecialchars($alt).'"';
		$titlePart = !empty($title) ? ' title="'.htmlspecialchars($title).'"' : '';
		return parent::getOptions().$sourcePart.$titlePart.$altPart;
	}
	
	public function makeRightFloating() {
		$this->setStyle("float: right; margin-left: 1em;");
	}
	
	public function makeLeftFloating() {
		$this->setStyle("float: left; margin-right: 1em;");
	}
}
?>