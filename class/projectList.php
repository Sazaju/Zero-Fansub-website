<?php
/*
	A project list is a list giving all the projects of the team.
*/

class ProjectList extends SimpleListComponent implements IPersistentComponent {
	private $databaseComponent = null;
	private $isLoaded = false;
	
	public function __construct() {
		$this->setClass('projectList');
		$this->databaseComponent = new DatabaseProjectList();
	}
	
	public function getDatabaseComponent() {
		return $this->databaseComponent;
	}
	
	public function load() {
		$this->databaseComponent->cacheAll();
		foreach($this->databaseComponent->getCachedComponents() as $component) {
			$component->load();
			$data = $component->getData();
			$image = new Image($data['shortimage_id']);
			$link = new IndexLink('page=project&id='.$data['id'], $image);
			$link->setTitle($data['title']);
			$this->add($link);
		}
		$this->isLoaded = true;
	}
	
	public function isLoaded() {
		return $this->isLoaded;
	}
}
?>
