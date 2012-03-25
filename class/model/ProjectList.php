<?php
/*
	A project list is a list able to take the projects of the team and format it in a convenient way.
*/

class ProjectList {
	private $projects = array();
	
	public function addProject(Project $project) {
		$this->projects[] = $project;
	}
	
	public function getProjects() {
		return $this->projects;
	}
	
	public function isEmpty() {
		return empty($this->projects);
	}
	
	public function sortByNames() {
		usort($this->projects, array('Project', 'nameSorter'));
	}
}
?>