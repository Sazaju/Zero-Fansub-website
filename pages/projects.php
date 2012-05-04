<?php
	$page = PageContent::getInstance();
	$page->setClass("series");
	
	$page->addComponent(new Title("Séries", 1));
	
	$url = new Url();
	$useImageLists = !$url->hasQueryVar('noImage');
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

	$notLicensedAnimes = array();
	$notLicensedDoujin = array();
	$allProjects = Project::getAllProjects();
	if ($_SESSION[MODE_H] == true) {
		$allProjects = array_filter($allProjects, function(Project $project) {return $project->isHentai();});
	} else {
		$allProjects = array_filter($allProjects, function(Project $project) {return !$project->isHentai();});
	}
	foreach($allProjects as $project) {
		if (!$project->isLicensed()) {
			if ($project->isDoujin()) {
				$notLicensedDoujin[] = $project;
			} else {
				$notLicensedAnimes[] = $project;
			}
		}
	}
	
	$listProcessor = function($title, $projects, $filter, $useImage) {
		$list = new ProjectList();
		foreach($projects as $project) {
			if ($filter === null || call_user_func($filter, $project)) {
				$list->addProject($project);
			}
		}
		
		if (!$list->isEmpty()) {
			$list->sortByNames();
			$list = new ProjectListComponent($list);
			$list->useImage($useImage);
			
			$page = PageContent::getInstance();
			if (is_string($title)) {
				$title = new Title($title, 3);
			}
			$page->addComponent($title);
			$page->addComponent($list);
		}
	};
	
	$hiddenFilter = function(Project $project) {
		return $project->isHidden();
	};
	$licensedFilter = function(Project $project) {
		return $project->isLicensed();
	};
	$runningFilter = function(Project $project) {
		return !$project->isHidden() && $project->isRunning();
	};
	$finishedFilter = function(Project $project) {
		return !$project->isHidden() && $project->isFinished();
	};
	$abandonnedFilter = function(Project $project) {
		return !$project->isHidden() && $project->isAbandonned();
	};
	$intendedFilter = function(Project $project) {
		return !$project->isHidden() && $project->isIntended();
	};
	
	if (TEST_MODE_ACTIVATED) {
		$options = new SimpleBlockComponent();
		$options->setClass('testFeatures');
		$options->addComponent("Options : ");
		
		$link = new Link(Url::getCurrentUrl(), "show hidden");
		if ($link->getUrl()->hasQueryVar('showHidden')) {
			$link->getUrl()->removeQueryVar('showHidden');
			$link->setClass('reverse');
		} else {
			$link->getUrl()->setQueryVar('showHidden');
		}
		$options->addComponent($link);
		
		$page->addComponent($options);
	}
	// TODO limit to authorized access
	if (Url::getCurrentUrl()->hasQueryVar('showHidden')) {
		call_user_func($listProcessor, new Title("Projets cachés", 2), $allProjects, $hiddenFilter, $useImageLists);
	}
	
	$categoryMap = array(
		"subs" => $notLicensedAnimes,
		"scans" => $notLicensedDoujin,
	);
	$filterMap = array(
		"en cours" => $runningFilter,
		"terminés" => $finishedFilter,
		"abandonnés" => $abandonnedFilter,
		"envisagés" => $intendedFilter,
	);
	$page->addComponent(new Title("Non licenciés", 2));
	foreach($categoryMap as $category => $projects) {
		foreach($filterMap as $desc => $filter) {
			call_user_func($listProcessor, ucfirst($category)." ".$desc, $projects, $filter, $useImageLists);
		}
	}
	
	call_user_func($listProcessor, new Title("Licenciés", 2), $allProjects, $licensedFilter, $useImageLists);
?>