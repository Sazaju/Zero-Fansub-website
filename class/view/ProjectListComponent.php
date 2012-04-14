<?php
class ProjectListComponent extends SimpleListComponent {
	private $useImage = false;
	
	public function __construct(ProjectList $list = null) {
		$this->updateClass();
		if ($list !== null) {
			foreach($list->getProjects() as $project) {
				$this->addComponent(new ProjectLinkComponent($project));
			}
		}
	}
	
	public function addComponent($project) {
		if ($project instanceof ProjectLinkComponent) {
			$project->useImage($this->useImage);
			parent::addComponent($project);
		}
		else {
			throw new Exception("Cannot take components other than project links.");
		}
	}
	
	public function useImage($boolean) {
		$this->useImage = $boolean;
		foreach($this->getComponents() as $listElement) {
			$projectLink = $listElement->getComponent(0);
			$projectLink->useImage($this->useImage);
		}
		$this->updateClass();
	}
	
	private function updateClass() {
		$this->setClass("projectList".($this->useImage ? "Image" : "Text"));
	}
}
?>