<?php
/*
	A project link is a link to a specific project of the team.
*/

class ProjectLink extends IndexLink {
	public function __construct(Project $project) {
		parent::__construct("page=series/".$project->getID(), $project->getName());
		$this->project = $project;
	}
	
	public function useImage($boolean) {
		$this->setContent($boolean
				? new Image("images/series/".$this->project->getID().".png", $this->project->getName())
				: $this->project->getName());
	}
}
?>
