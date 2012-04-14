<?php
/*
	A global container for the page content.
*/

class PageContentComponent extends SimpleBlockComponent {
	private static $instance = null;
	public static function getInstance() {
		if (PageContentComponent::$instance == null) {
			PageContentComponent::$instance = new PageContentComponent();
		}
		return PageContentComponent::$instance;
	}
	
	public function __construct($title = null) {
		$this->setID("page");
	}
}
?>