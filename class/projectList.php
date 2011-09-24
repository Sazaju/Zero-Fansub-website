<?php
/*
	A project list is a list able to take the projects of the team and format it in a convenient way.
*/

class ProjectList extends SimpleListComponent {
	private $useImage = false;
	
	public function __construct() {
		$this->setClass("projectList");
	}
	
	public function addComponent($project) {
		if ($project instanceof ProjectLink) {
			// nothing to do
		}
		else if ($project instanceof Project) {
			$project = new ProjectLink($project);
		}
		else {
			throw new Exception("Cannot take components other than projects and project links.");
		}
		
		$project->useImage($this->useImage);
		parent::addComponent($project);
	}
	
	public function useImage($boolean) {
		$this->useImage = $boolean;
		foreach($this->getComponents() as $listElement) {
			$projectLink = $listElement->getComponent(0);
			$projectLink->useImage($this->useImage);
		}
	}
}
?>
