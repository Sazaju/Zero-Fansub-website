<?php
require_once('ipersistentcomponent.php');
require_once('database/databasenews.php');
require_once('xhtml/htmlnews.php');

class News implements IPersistentComponent {
	private $htmlComponent = null;
	private $databaseComponent = null;
	
	public function __construct(Database $db, $id) {
		$this->databaseComponent = new DatabaseNews();
		$this->databaseComponent->setDatabase($db);
		$this->databaseComponent->setDatabaseId($id);
		$this->htmlComponent = new HtmlNews();
	}
	
	public function getHtmlComponent() {
		return $this->htmlComponent;
	}
	
	public function getDatabaseComponent() {
		return $this->databaseComponent;
	}
	
	public function load() {
		$this->databaseComponent->load();
		$data = $this->databaseComponent->getData();
		$this->htmlComponent->setTitle($data['title']);
		$this->htmlComponent->setText($data['text']);
		$image = new Image($this->databaseComponent->getDatabase(), $data['image_id']);
		$image->load();
		$this->htmlComponent->setImage($image->getHtmlComponent());
	}

	
}
?>
