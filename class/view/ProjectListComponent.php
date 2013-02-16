<?php
class ProjectListComponent extends SimpleListComponent {
	// TODO transform into a static function in SimpleListComponent
	private $list = null;
	private $useImage = false;
	
	public function __construct(ProjectList $list = null) {
		$this->list = $list;
		$this->update();
	}
	
	public function addComponent($project) {
		throw new Exception("You cannot add components. Create a new list.");
	}
	
	public function useImage($boolean) {
		$this->useImage = $boolean;
		$this->update();
	}
	
	private function update() {
		$this->setClass("projectList".($this->useImage ? "Image" : "Text"));
		$this->clear();
		if ($this->list !== null) {
			foreach($this->list->getProjects() as $project) {
				parent::addComponent(Link::createProjectLink($project, $this->useImage));
			}
		}
	}
}
?>