<?php
/*
	A direct download link is a formatted link used in release descriptions, to give access to the
	file of the release.
*/

class DirectDownloadLink extends SimpleTextComponent {
	private $link = null;
	
	public function __construct($url = null, $content = null) {
		$this->setClass("ddlLink");
		
		$this->link = new Link($url, $content);
		
		$this->addComponent(new Image("images/icones/ddl.png"));
		$this->addComponent(" [ ");
		$this->addComponent($this->link);
		$this->addComponent(" ]");
	}
	
	public function getLink() {
		return $this->link;
	}
}
?>
