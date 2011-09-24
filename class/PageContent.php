<?php
/*
	A global container for the page content.
*/

class PageContent extends SimpleBlockComponent {
	private static $instance = null;
	public static function getInstance() {
		if (PageContent::$instance == null) {
			PageContent::$instance = new PageContent();
		}
		return PageContent::$instance;
	}
	
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
