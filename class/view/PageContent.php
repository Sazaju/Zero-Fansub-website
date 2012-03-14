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
	
	public function __construct($title = null) {
		$this->setID("page");
	}
}
?>