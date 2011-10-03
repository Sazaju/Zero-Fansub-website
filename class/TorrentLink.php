<?php
/*
	A torrent link is a formatted link used in release descriptions, to give access to the
	torrent of the release.
*/

class TorrentLink extends NewWindowLink {
	private $id = null;
	
	public function __construct() {
		$this->setClass("torrentLink");
		$this->setUrl("http://www.bt-anime.net/index.php?page=tracker&team=Z%e9ro");
		$this->setContent(new Image("images/icones/torrent.png"));
	}
}
?>
