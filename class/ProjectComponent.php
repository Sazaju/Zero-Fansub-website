<?php
class ProjectComponent extends SimpleBlockComponent {
	public function __construct(Project $project) {
		$title = new Title($project->getName(), 3);
		$title->setClass('projectTitle');
		$this->addComponent($title);
		
		$image = new Image('images/series/'.$project->getID().'.jpg');
		$image->setClass('projectPicture');
		$this->addComponent($image);
		
		$this->addComponent(new Title("Informations générales", 2));
		if ($project->hasExternalSource()) {
			$subtitle = new Title("Source : ", 4);
			$subtitle->addComponent($project->getExternalSource());
			$this->addComponent($subtitle);
		}
		
		$array = array(
			array("Titre Original", $project->getOriginalName()),
			array("Site officiel", $project->getOfficialWebsite()),
			array("Année de production", $project->getAiringYear()),
			array("Studio", $project->getStudio()),
			array("Auteur", $project->getAuthor()),
			array("Genre", $project->getGenre()),
			array("Synopsis", $project->getSynopsis()),
			array("Coproduction", $project->getCoproduction()),
			array("Vosta", $project->getVosta()),
		);
		$infos = new SimpleTextComponent();
		$infos->setClass('projectInfos');
		foreach($array as $data) {
			if ($data[1] !== null) {
				$text = new SimpleTextComponent("<b>".$data[0]."</b> ");
				$text->addComponent($data[1]);
				$infos->addLine($text);
			}
		}
		$this->addComponent($infos);
		
		if ($project->getComment() !== null) {
			$this->addComponent("<p></p>");
			$this->addComponent(new Title("Commentaire", 2));
			$this->addComponent($project->getComment());
		}
		
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
			foreach($linkedProjects as $link) {
				$list->addProject($link);
			}
			$list->sortByNames();
			$list = new ProjectListComponent($list);
			$list->useImage(true);
			$this->addComponent($list);
		}
		
		foreach($project->getBonuses() as $bonus) {
			$this->addComponent("<p></p>");
			$this->addComponent(new Title("Bonus : ".$bonus->getTitle(), 2));
			$this->addComponent($bonus->getContent());
		}
		
		$groups = ProjectGroup::getGroupsForProject($project);
		foreach($groups as $group) {
			foreach($group->getBonuses() as $bonus) {
				$this->addComponent("<p></p>");
				$this->addComponent(new Title("Bonus : ".$bonus->getTitle(), 2));
				$this->addComponent($bonus->getContent());
			}
		}
		
		$this->addComponent("<p></p>");
		$url = $project->getDiscussionUrl();
		if ($url == null) {
			$url = new Url("http://zero.xooit.fr/posting.php?mode=reply&t=120");
		}
		$link = Link::newWindowLink($url, new Image("images/interface/avis.png", "Donne ton avis sur le forum !"));
		$link->setClass('discussionLink');
		$this->addComponent($link);
	}
	
	public function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}
}
?>