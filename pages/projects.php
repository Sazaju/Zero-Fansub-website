<?php
	$page = PageContent::getInstance();
	$page->setClass("series");
	
	$page->addComponent(new Title("Séries", 1));
	
	$url = new Url();
	$vars = $url->getQueryVars();
	$useImageLists = !array_key_exists('noImage', $vars);
	if ($useImageLists) {
		$url->setQueryVar('noImage');
		$link = new Link($url, "Voir la liste sans images");
		$link->setClass('pictureSwitch');
		$page->addComponent($link);
	}
	else {
		$url->removeQueryVar('noImage');
		$link = new Link($url, "Voir la liste avec images");
		$link->setClass('pictureSwitch');
		$page->addComponent($link);
	}

	$licensedAnimes = array();
	$notLicensedAnimes = array();
	$licensedDoujin = array();
	$notLicensedDoujin = array();
	$allProjects = null;
	if ($_SESSION[MODE_H] == true) {
		$allProjects = Project::getHentaiProjects();
	} else {
		$allProjects = Project::getNonHentaiProjects();
	}
	foreach($allProjects as $project) {
		if (!$project->isHidden()) {
			if ($project->isDoujin()) {
				if ($project->isLicensed()) {
					$licensedDoujin[] = $project;
				} else {
					$notLicensedDoujin[] = $project;
				}
			} else {
				if ($project->isLicensed()) {
					$licensedAnimes[] = $project;
				} else {
					$notLicensedAnimes[] = $project;
				}
			}
		}
	}
	
	$page->addComponent(new Title("Non licenciés", 2));
	
	$page->addComponent(new Title("Projets en cours", 3));
	$list = new ProjectList();
	foreach($notLicensedAnimes as $project) {
		if ($project->isRunning()) {
			$list->addProject($project);
		}
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);
	
	$page->addComponent(new Title("Projets terminés", 3));
	$list = new ProjectList();
	foreach($notLicensedAnimes as $project) {
		if ($project->isFinished()) {
			$list->addProject($project);
		}
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);

	$page->addComponent(new Title("Projets abandonnés", 3));
	$list = new ProjectList();
	foreach($notLicensedAnimes as $project) {
		if ($project->isAbandonned()) {
			$list->addProject($project);
		}
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);

	$page->addComponent(new Title("Projets envisagés", 3));
	$list = new ProjectList();
	foreach($notLicensedAnimes as $project) {
		if (!$project->isStarted() && !$project->isAbandonned()) {
			$list->addProject($project);
		}
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);

	$page->addComponent(new Title("Doujin en cours", 3));
	$list = new ProjectList();
	foreach($notLicensedDoujin as $project) {
		if ($project->isRunning()) {
			$list->addProject($project);
		}
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);
	
	$page->addComponent(new Title("Doujin terminés", 3));
	$list = new ProjectList();
	foreach($notLicensedDoujin as $project) {
		if ($project->isFinished()) {
			$list->addProject($project);
		}
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);
	
	$page->addComponent(new Title("Licenciés", 2));
	$list = new ProjectList();
	foreach($licensedAnimes as $project) {
		$list->addProject($project);
	}
	foreach($licensedDoujin as $project) {
		$list->addProject($project);
	}
	$list->sortByNames();
	$list = new ProjectListComponent($list);
	$list->useImage($useImageLists);
	$page->addComponent($list);
?>

