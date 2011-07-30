<?php
class Image implements IPersistentComponent {
	private $htmlComponent = null;
	private $databaseComponent = null;
	private $isLoaded = false;
	
	public function __construct(Database $db, $id) {
		$this->databaseComponent = new DatabaseImage();
		$this->databaseComponent->setDatabase($db);
		$this->databaseComponent->setDatabaseId($id);
		$this->htmlComponent = new HtmlImage();
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
		$this->htmlComponent->setSource($data['url']);
		$this->htmlComponent->setAlternative($data['title']);
		$this->isLoaded = true;
	}

	public function isLoaded(){
		return $this->isLoaded;
	}
}
?>
