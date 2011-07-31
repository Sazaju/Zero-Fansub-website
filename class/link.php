<?php
/*
	A link is a reference (URL) to another resource.
*/

class Link extends DefaultHtmlComponent {
	private $url = null;
	private $title = null;
	
	public function __construct($url = '#', $content = null) {
		$this->setUrl($url);
		if ($content instanceof IHtmlComponent) {
			$this->addComponent($content);
		}
		else {
			$this->setContent($content === null ? $url : $content);
		}
	}
	
	public function getHtmlTag() {
		return 'a';
	}
	
	public function setUrl($url) {
		$this->url = $url;
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getOptions() {
		$url = $this->getUrl();
		$title = $this->getTitle();
		$urlPart = $url === null ? '' : ' href="'.$url.'"';
		$titlePart = $title === null ? '' : ' title="'.$title.'"';
		return parent::getOptions().$urlPart.$titlePart;
	}
}
?>
