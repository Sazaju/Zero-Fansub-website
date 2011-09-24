<?php
	$page = PageContent::getInstance();
	$page->setTitle("Séries");

	$useImageLists = !isset($_GET['noImage']);
	if ($useImageLists) {
		$page->addComponent(new IndexLink("page=".$_GET['page']."&noImage", new Title("Voir la liste sans images", 2)));
	}
	else {
		$page->addComponent(new IndexLink("page=".$_GET['page'], new Title("Voir la liste avec images", 2)));
	}
?>
<?php
	$page->addComponent(new Title("Projets en cours", 2));
	
	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isRunning()) {
			$list->addComponent($project);
		}
	}
?>
<?php
	$page->addComponent(new Title("Projets termin&eacute;s", 2));

	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isFinished()) {
			$list->addComponent($project);
		}
	}
?>
<?php
	$page->addComponent(new Title("Projets futurs", 2));

	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if (!$project->isStarted() && !$project->isLicensed() && !$project->isAbandonned()) {
			$list->addComponent($project);
		}
	}
?>
<?php
	$page->addComponent(new Title("Projets abandonn&eacute;s", 2));

	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isAbandonned()) {
			$list->addComponent($project);
		}
	}
?>
<?php
	$page->addComponent(new Title("Projets licenci&eacute;s", 2));

	$list = new ProjectList();
	$list->useImage($useImageLists);
	$page->addComponent($list);
	foreach(Project::getNonHentaiProjects() as $project) {
		if ($project->isLicensed()) {
			$list->addComponent($project);
		}
	}
?>
<?php
	$hentaiLink = new IndexLink("page=havert", "Voir les projets Hentaï");
	$hentaiLink->setStyle("text-align: center; font-size: 25px;");
	$page->addComponent($hentaiLink);
?>
