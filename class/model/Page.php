<?php
class Page {
	private $id = null;
	private $content = null;
	private $useBBCode = null;
	
	public function setContent($content) {
		$this->content = $content;
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function setUseBBCode($boolean) {
		$this->useBBCode = $boolean;
	}
	
	public function useBBCode() {
		return $this->useBBCode;
	}
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
	}
	
	private static $allPages = null;
	public static function getAllPages() {
		if (Page::$allPages === null) {
			Page::$allPages = array();
			
			// $page = new Page();
			// $page->setID('contact');
			// $page->setContent("...");
			// $page->setUseBBCode(true);
			// Page::$allPages[] = $page;
		}
		return Page::$allPages;
	}
	
	public static function getPage($id) {
		foreach(Page::getAllPages() as $page) {
			if ($page->getID() === $id) {
				return $page;
			}
		}
		throw new Exception($id.' si not a known page ID');
	}
}
?>