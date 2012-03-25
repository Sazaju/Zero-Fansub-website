<?php
class ProjectBonus {
	private $title = null;
	private $content = null;
	
	public function __construct($title, $content) {
		$this->title = $title;
		$this->content = $content;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getContent() {
		return $this->content;
	}
}
?> 
