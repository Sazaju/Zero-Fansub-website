<?php
class ProjectComponent extends SimpleBlockComponent {
	public function __construct(Project $project) {
		$title = new Title($project->getName(), 3);
		$title->setClass('projectTitle');
		$this->addComponent($title);
		
		$image = new Image('images/series/'.$project->getID().'.jpg');
		$image->setClass('projectPicture');
		$this->addComponent($image);
		
		$infos = new SimpleTextComponent();
		$infos->setClass('projectInfos');
		$infos->addLine("<b>Titre Original</b> ".$project->getOriginalName());
		if ($project->hasOfficialWebsite()) {
			$text = new SimpleTextComponent("<b>Site officiel</b> ");
			$text->addComponent($project->getOfficialWebsite());
			$infos->addLine($text);
		}
		$infos->addLine("<b>Année de production</b> ".$project->getAiringYear());
		if ($project->getStudio() != null) {
			$infos->addLine("<b>Studio</b> ".$project->getStudio());
		}
		if ($project->getAuthor() != null) {
			$infos->addLine("<b>Auteur</b> ".$project->getAuthor());
		}
		$infos->addLine("<b>Genre</b> ".($project->isDoujin() ? "Doujin" : $project->getGenre()));
		$infos->addLine("<b>Synopsis</b> ".$project->getSynopsis());
		$this->addComponent(new Title("Informations générales", 2));
		if ($project->hasExternalSource()) {
			$subtitle = new Title("Source : ", 4);
			$subtitle->addComponent($project->getExternalSource());
			$this->addComponent($subtitle);
		}
		$this->addComponent($infos);
		
		$this->addComponent("<p></p>");
		$link = Link::newWindowLink("http://zero.xooit.fr/t471-Liens-morts.htm", "Signaler un lien mort");
		$link->setClass('deadLinks');
		$this->addComponent($link);
		
		$this->addComponent("<p></p>");
		$this->addComponent(new Title($project->isDoujin() ? "Chapitres" : "Épisodes", 2));
		
		$releases = Release::getAllReleasesForProject($project->getID());
		usort($releases, array('ProjectComponent', 'sortReleases'));
		$list = new SimpleListComponent();
		$list->setClass("releaseList");
		foreach($releases as $release)
		{
			$list->addComponent(new ReleaseComponent($release));
		}
		$this->addComponent($list);
		
		$linkedProjects = Project::getProjectsLinkedTo($project);
		if (!empty($linkedProjects)) {
			$this->addComponent("<p></p>");
			$this->addComponent(new Title("Voir aussi", 2));
			
			$list = new ProjectList();
			$list->useImage(true);
			foreach($linkedProjects as $project) {
				$list->addComponent($project);
			}
			$this->addComponent($list);
		}
		
		
	}
	
	public function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}
}
?>