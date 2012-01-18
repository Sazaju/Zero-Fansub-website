<?php
class ProjectComponent extends SimpleBlockComponent {
	public function __construct(Project $project) {
		$title = new Title($project->getName(), 3);
		$title->setClass('projectTitle');
		$this->addComponent($title);
		
		$image = new Image('images/series/heismymaster.jpg');
		$image->setClass("projectPicture");
		$this->addComponent($image);
		
		$infos = new SimpleTextComponent();
		$infos->setClass('projectInfos');
		$infos->addLine("<b>Titre Original</b> ".$project->getOriginalName());
		$infos->addLine("<b>Année de production</b> ".$project->getAiringYear());
		$infos->addLine("<b>Auteur</b> ".$project->getAuthor());
		$infos->addLine("<b>Genre</b> ".($project->isDoujin() ? "Doujin" : "?"));
		$infos->addLine("<b>Synopsis</b> ".$project->getSynopsis());
		$this->addComponent(new Title("Informations générales", 2));
		$this->addComponent($infos);
		
		$this->addComponent("<p></p>");
		
		$link = Link::newWindowLink("http://zero.xooit.fr/t471-Liens-morts.htm", "Signaler un lien mort");
		$link->setClass('deadLinks');
		$this->addComponent($link);
		
		$this->addComponent("<p></p>");
		
		$this->addComponent(new Title("Chapitres", 2));
		
		$releases = Release::getAllReleasesForProject($project->getID());
		usort($releases, array('ProjectComponent', 'sortReleases'));
		$list = new SimpleListComponent();
		$list->setClass("releaseList");
		foreach($releases as $release)
		{
			$list->addComponent(new ReleaseComponent($release));
		}
		$this->addComponent($list);
	}
	
	public function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}
}
?>