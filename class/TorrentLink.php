<?php
/*
	A torrent link is a formatted link used in release descriptions, to give access to the
	torrent of the release.
*/

class TorrentLink extends NewWindowLink {
	private $id = null;
	
	public function __construct($torrentId = null) {
		$this->setTorrentID($torrentId);
		$this->setClass("torrentLink");
	}
	
	public function getTorrentID() {
		return $this->id;
	}
	
	public function setTorrentID($id) {
		$this->id = $id;
		if ($id !== null) {
			$this->setUrl("http://bt.fansub-irc.eu/tracker_team/index.php?id_tracker=".$id);
			$this->setContent(new Image("images/icones/torrent.png"));
		}
		else {
			$this->setContent(null);
		}
	}
}
?>
