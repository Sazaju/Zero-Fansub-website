<?php
/*
	A project link is a link to a specific project of the team.
*/

class ProjectLinkComponent extends LinkComponent {
	public function __construct(Project $project) {
		parent::__construct();
		$this->setProject($project);
	}
	
	public function setProject(Project $project) {
		$this->project = $project;
		$url = parent::getUrl();
		$url->setQueryVar('page', 'project');
		$url->setQueryVar('id', $project->getID());
		$this->setContent($project->getName());
	}
	
	public function getProject() {
		return $this->project;
	}
	
	public function setUrl(Url $url) {
		throw new Exception("You cannot change the URL directly, change the project.");
	}
	
	public function useImage($boolean) {
		$this->setContent($boolean
				? new ImageComponent("images/series/".$this->project->getID().".png", $this->project->getName())
				: $this->project->getName());
	}
}
?>