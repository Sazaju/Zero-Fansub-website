<?php
	$page = PageContent::getInstance();
	$page->setTitle("Séries");

	$url = new Url();
	$vars = $url->getQueryVars();
	$useImageLists = !array_key_exists('noImage', $vars);
	if ($useImageLists) {
		$url->setQueryVar('noImage');
		$page->addComponent(new Link($url, new Title("Voir la liste sans images", 2)));
	}
	else {
		$url->removeQueryVar('noImage');
		$page->addComponent(new Link($url, new Title("Voir la liste avec images", 2)));
	}

	$page->addComponent(new Title("Projets en cours", 2));
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isRunning() && !$project->isDoujin()) {
			$list->addComponent($project);
		}
	}
	
	$page->addComponent(new Title("Projets terminés", 2));
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isFinished() && !$project->isDoujin()) {
			$list->addComponent($project);
		}
	}

	$page->addComponent(new Title("Projets envisagés", 2));
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if (!$project->isStarted() && !$project->isLicensed() && !$project->isAbandonned() && !$project->isDoujin()) {
			$list->addComponent($project);
		}
	}

	$page->addComponent(new Title("Projets abandonnés", 2));
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isAbandonned() && !$project->isDoujin()) {
			$list->addComponent($project);
		}
	}

	$page->addComponent(new Title("Projets licenciés", 2));
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isLicensed() && !$project->isDoujin()) {
			$list->addComponent($project);
		}
	}
	
	$url = new Url();
	$url->setQueryVar('page', 'havert');
	$hentaiLink = new Link($url, "Voir les projets Hentaï");
	$hentaiLink->setStyle("text-align: center; font-size: 25px;");
	$page->addComponent($hentaiLink);
?>

