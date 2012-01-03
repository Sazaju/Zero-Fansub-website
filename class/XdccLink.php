<?php
/*
	A XDCC link is a formatted link used in release descriptions, to give access to the
	XDCC page.
*/

class XdccLink extends Link {
	public function __construct() {
		parent::__construct(null, new Image("images/icones/xdcc.png"));
		$url = new Url('index.php');
		$url->setQueryVar("page", "xdcc");
		parent::setUrl($url);
		$this->setClass("xdccLink");
	}
	
	public function setUrl(Url $url) {
		throw new Exception("You cannot change the URL of this link.");
	}
}
?>
