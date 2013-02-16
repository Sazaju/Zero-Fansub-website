<?php
/*
	A link is a reference (URL) to another resource.
*/

class Link extends DefaultHtmlComponent {
	private $url = null;
	private $forceFull = null;
	private $content = null;
	
	public function __construct($url = null, $content = null, $forceFull = false) {
		$this->setUrl($url);
		$this->setFullUrlForced($forceFull);
		
		if ($url == null) {
			$this->setContent($content);
		} else {
			$url = new Url($url);
			$this->setContent($content === null ? $url->toString(true) : $content);
		}
	}
	
	public function setNewWindow($boolean) {
		$this->setMetadata('target', $boolean ? '_blank' : null, true);
	}
	
	public function isNewWindow() {
		return $this->getMetadata('target') == '_blank';
	}
	
	public function setFullUrlForced($boolean) {
		$this->forceFull = $boolean;
		$this->update();
	}
	
	public function isFullUrlForced() {
		return $this->forceFull;
	}
	
	public function getHtmlTag() {
		return 'a';
	}
	
	public function isAutoClose() {
		return false;
	}
	
	public function setUrl($url) {
		$this->url = $url;
		$this->update();
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	private function update() {
		$url = $this->getUrl();
		if ($url == null) {
			$this->removeMetadata('href');
		} else {
			$url = new Url($url);
			$url = $url->toString($this->isFullUrlForced());
			$this->setMetadata('href', $url);
		}
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
	
	public function isLocalLink() {
		$url = new Url($this->getUrl());
		return $url->isLocalUrl();
	}
	
	public static function newWindowLink($url = null, $content = null) {
		$link = new Link($url, $content);
		$link->setNewWindow(true);
		return $link;
	}
	
	public static function createHentaiAccessLink() {
		$hentaiLink = new Link();
		$url = new Url($hentaiLink->getUrl());
		if ($_SESSION[MODE_H] == false) {
			$url->setQueryVar(DISPLAY_H_AVERT);
			$hentaiLink->setContent("Hentaï");
		} else {
			$url->setQueryVar(MODE_H, false);
			$hentaiLink->setContent("Tout public");
		}
		$hentaiLink->setUrl($url);
		return $hentaiLink;
	}
	
	public static function createXdccLink() {
		$url = new Url('index.php');
		$url->setQueryVar("page", "xdcc");
		$link = new Link($url, new Image("images/icones/xdcc.png"));
		$link->setClass("xdccLink");
		return $link;
	}
	
	public static function createRssLink(Url $rssUrl, $content = null) {
		$rssImage = new Image('images/icones/rss.png', 'Flux RSS');
		$rssImage->setClass('rss');
		$link = new Link($rssUrl, $rssImage);
		$link->setMetaData('type', 'application/rss+xml');
		$link->setNewWindow(true);
		return $link;
	}
	
	public static function createMailLink($mail, $content = null) {
		$link = new Link('mailto:'.$mail, $content == null ? $mail : $content);
		return $link;
	}
	
	public static function createProjectLink(Project $project, $useImage = false) {
		$url = Url::getCurrentScriptUrl();
		$url->setQueryVar('page', 'project');
		$url->setQueryVar('id', $project->getID());
		$content = $useImage
				? new Image("images/series/".$project->getID().".png", $project->getName())
				: $project->getName();
		$link = new Link($url, $content);
		return $link;
	}
	
	public static function createReleaseLink($projectId, $releaseList, $content = null) {
		if (!is_array($releaseList)) {
			$releaseList = array($releaseList);
		}
		
		$url = new Url();
		if (count($releaseList) > 0) {
			$list = "";
			$first = null;
			foreach($releaseList as $id) {
				if ($first == null) {
					$first = $id;
				}
				$list .= ",".$id;
			}
			$list = substr($list, 1);
			$url->setQueryVar('page', 'project');
			$url->setQueryVar('id', $projectId);
			$url->setQueryVar('show', $list);
			$url->set(URL_FRAGMENT, $first);
		} else {
			throw new Exception("At least one id should be given.");
		}
		
		if ($content === null) {
			$release = Release::getRelease($projectId, $releaseList[0]);
			$content = $release->getCompleteName().(count($releaseList) > 1 ? "+" : "");
		}
		
		$link = new Link($url, $content);
		return $link;
	}
	
	public static function createPartnerLink(Partner $partner, $useImage = false) {
		$content = $useImage
				? new Image($partner->getBannerUrl(), $partner->getName())
				: $partner->getName();
		$link = new Link($partner->getWebsiteUrl(), $content);
		$link->setNewWindow(true);
		return $link;
	}
}
?>