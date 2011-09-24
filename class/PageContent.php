<?php
/*
	A global container for the page content.
*/

class PageContent extends SimpleBlockComponent {
	private $title = null;
	
	public function __construct($title = null) {
		$this->setID("pageContent");
		
		$this->title = new Title($title, 3);
		$this->addComponent($this->title);
	}
	
	public function setTitle($title) {
		$this->title->setContent($title);
	}
	
	public function getTitle() {
		$this->title->getCurrentContent();
	}
}
?>
