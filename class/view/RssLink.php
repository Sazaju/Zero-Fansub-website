<?php
class RssLink extends Link {
	public function __construct(Url $rssUrl, $content = null) {
		parent::__construct($rssUrl);
		$rssImage = new Image('images/icones/rss.png', 'Flux RSS');
		$rssImage->setClass('rss');
		$this->setContent($rssImage);
		$this->setMetaData('type', 'application/rss+xml');
		$this->openNewWindow(true);
	}
}
?>