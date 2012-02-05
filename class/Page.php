<?php
class Page {
	private $id = null;
	private $content = null;
	
	public function setContent($content) {
		$this->content = $content;
	}
	
	public function getContent() {
		return $this->content;
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
			
			$page = new Page();
			$page->setID('contact');
			$page->setContent("[title]Contact[/title]


Un commentaire à faire ?
Une critique ?
Un lien mort ?
Une proposition ?
Un lien de streaming ?

Une seule adresse pour contacter la team :


[size=25px][mail]zero.fansub@gmail.com[/mail][/size]");
			Page::$allPages[] = $page;
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
