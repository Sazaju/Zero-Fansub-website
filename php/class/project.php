<?php
require_once('ipersistentcomponent.php');
require_once('database/databaseproject.php');
require_once('xhtml/htmlproject.php');

class Project implements IPersistentComponent {
	private $htmlComponent = null;
	private $databaseComponent = null;
	
	public function __construct(Database $db, $id) {
		$this->databaseComponent = new DatabaseProject();
		$this->databaseComponent->setDatabase($db);
		$this->databaseComponent->setDatabaseId($id);
		$this->htmlComponent = new HtmlProject();
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
		$this->htmlComponent->setdescription($data['description']);
		$image = new Image($this->databaseComponent->getDatabase(), $data['image_id']);
		$image->load();
		$this->htmlComponent->setImage($image->getHtmlComponent());
	}

	
}
?>