<?php
/*
	A link is a reference (URL) to another resource.
*/

class Link extends DefaultHtmlComponent {
	private $url = null;
	private $newWindow = null;
	private $forceFull = null;
	
	public function __construct($url = null, $content = null, $forceFull = false) {
		if ($url == null) {
			$url = new Url();
		}
		if (is_string($url)) {
			$url = new Url($url);
		}
		$this->url = $url;
		$this->forceFull = $forceFull;
		if ($content instanceof IHtmlComponent) {
			$this->addComponent($content);
		}
		else {
			$this->setContent($content === null ? $url->toString($forceFull) : $content);
		}
	}
	
	public function openNewWindow($boolean) {
		$this->newWindow = $boolean;
	}
	
	public function forceFull() {
		return $this->forceFull;
	}
	
	public function setForceFull($boolean) {
		$this->forceFull = $boolean;
	}
	
	public function getHtmlTag() {
		return 'a';
	}
	
	public function isAutoClose() {
		return false;
	}
	
	public function setUrl(Url $url) {
		$this->url = $url;
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	public function setOnClick($javascript) {
		$this->setMetadata('onclick', $javascript, true);
	}
	
	public function getOnClick() {
		return $this->getMetadata('onclick');
	}
	
	public function setTitle($title) {
		$this->setMetadata('title', $title, true);
	}
	
	public function getTitle() {
		return $this->getMetadata('title');
	}
	
	public function getMetadataString() {
		$url = $this->getUrl()->toString($this->forceFull);
		$title = $this->getTitle();
		$onClick = $this->getOnClick();
		$newWindow = $this->newWindow;
		$urlPart = $url === null ? '' : ' href="'.$url.'"';
		$titlePart = $title === null ? '' : ' title="'.$title.'"';
		$onClickPart = $onClick === null ? '' : ' onclick="'.$onClick.'"';
		$targetPart = $newWindow === true ? ' target="_blank"' : '';
		return parent::getMetadataString().$urlPart.$titlePart.$targetPart.$onClickPart;
	}
	
	public function isLocalLink() {
		return $this->getUrl()->isLocalUrl();
	}
	
	public static function newWindowLink($url = null, $content = null) {
		$link = new Link($url, $content);
		$link->openNewWindow(true);
		return $link;
	}
	
	public static function CreateHentaiAccessLink($toHentaiString = "Hentaï", $toEveryoneString = "Tout public") {
		$hentaiLink = new Link();
		$url = $hentaiLink->getUrl();
		if ($_SESSION[MODE_H] == false) {
			$url->setQueryVar(DISPLAY_H_AVERT);
			$hentaiLink->setContent($toHentaiString);
		} else {
			$url->setQueryVar(MODE_H, false);
			$hentaiLink->setContent($toEveryoneString);
		}
		return $hentaiLink;
	}
}
?>