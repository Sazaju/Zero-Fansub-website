<?php
/*
	A XDCC link is a formatted link used in release descriptions, to give access to the
	XDCC page.
*/

class XdccLink extends IndexLink {
	public function __construct() {
		parent::__construct("page=xdcc", new Image("images/icones/xdcc.png"));
		$this->setClass("xdccLink");
	}
}
?>
