<?php
class ShortNews implements IPersistentComponent {
	private $htmlComponent = null;
	private $databaseComponent = null;
	private $isLoaded = false;
	
	public function __construct(Database $db, $id) {
		$this->databaseComponent = new DatabaseNews();
		$this->databaseComponent->setDatabase($db);
		$this->databaseComponent->setDatabaseId($id);
		$this->htmlComponent = new HtmlShortNews();
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
		$this->isLoaded = true;
	}

	public function isLoaded(){
		return $this->isLoaded;
	}
}
?>
