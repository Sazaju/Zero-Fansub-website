<?php
	$page = PageContent::getInstance();
	$page->setTitle("Séries");

	// TODO manage url in a way we do not have to know what is in to update it.
	$useImageLists = !isset($_GET['noImage']);
	if ($useImageLists) {
		$page->addComponent(new IndexLink("page=".$_GET['page']."&noImage", new Title("Voir la liste sans images", 2)));
	}
	else {
		$page->addComponent(new IndexLink("page=".$_GET['page'], new Title("Voir la liste avec images", 2)));
	}

	$page->addComponent(new Title("Projets en cours", 2));
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isRunning()) {
			$list->addComponent($project);
		}
	}
	
	$page->addComponent(new Title("Projets terminés", 2));
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isFinished()) {
			$list->addComponent($project);
		}
	}

	$page->addComponent(new Title("Projets envisagés", 2));
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if (!$project->isStarted() && !$project->isLicensed() && !$project->isAbandonned()) {
			$list->addComponent($project);
		}
	}

	$page->addComponent(new Title("Projets abandonnés", 2));
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isAbandonned()) {
			$list->addComponent($project);
		}
	}

	$page->addComponent(new Title("Projets licenciés", 2));
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isLicensed()) {
			$list->addComponent($project);
		}
	}

	$hentaiLink = new IndexLink("page=havert", "Voir les projets Hentaï");
	$hentaiLink->setStyle("text-align: center; font-size: 25px;");
	$page->addComponent($hentaiLink);
?>
