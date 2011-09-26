<?php
/*
	A link is a reference (URL) to another resource.
*/

class Link extends DefaultHtmlComponent {
	private $url = null;
	private $title = null;
	private $newWindow = null;
	private $onClick = null;
	
	public function __construct($url = '#', $content = null) {
		$this->setUrl($url);
		if ($content instanceof IHtmlComponent) {
			$this->addComponent($content);
		}
		else {
			$this->setContent($content === null ? $url : $content);
		}
	}
	
	public function openNewWindow($boolean) {
		$this->newWindow = $boolean;
	}
	
	public function getHtmlTag() {
		return 'a';
	}
	
	public function setUrl($url) {
		$this->url = $url;
		if ($url == null) {
			$this->setClass("noUrl");
		}
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	public function setOnClick($javascript) {
		$this->onClick = $javascript;
	}
	
	public function getOnClick() {
		return $this->onClick;
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
		$onClick = $this->getOnClick();
		$newWindow = $this->newWindow;
		$urlPart = $url === null ? '' : ' href="'.$url.'"';
		$titlePart = $title === null ? '' : ' title="'.$title.'"';
		$onClickPart = $onClick === null ? '' : ' onclick="'.$onClick.'"';
		$targetPart = $newWindow === true ? ' target="_blank"' : '';
		return parent::getOptions().$urlPart.$titlePart.$targetPart.$onClickPart;
	}
}
?>
