<?php
/*
	A torrent link is a formatted link used in release descriptions, to give access to the
	torrent of the release.
*/

class TorrentLink extends NewWindowLink {
	private $id = null;
	
	public function __construct() {
		$this->setClass("torrentLink");
		$this->setUrl("http://bt.fansub-irc.eu/tracker_team/index.php?id_tracker=26");
		$this->setContent(new Image("images/icones/torrent.png"));
	}
}
?>
