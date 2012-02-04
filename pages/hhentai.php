<h3>Hentaï</h3>

<div id="curseur" class="infobulle"></div>
<h2>Projets Hentaï en cours</h2>
<?php
	$list = new ProjectList();
	$list->useImage(true);
	foreach(Project::getHentaiProjects() as $project) {
		if (!$project->isDoujin()) {
			$list->addComponent($project);
		}
	}
	$list->writeNow();
?>
<p></p>

<h3>Doujins</h3>

<div id="curseur" class="infobulle"></div>
<h2>Projets Doujins en cours</h2>
<?php
	$list = new ProjectList();
	$list->useImage(true);
	foreach(Project::getHentaiProjects() as $project) {
		if ($project->isRunning() && $project->isDoujin()) {
			$list->addComponent($project);
		}
	}
	$list->writeNow();
?>
<p style="text-align: center;">
</p>
<h2>Projets Doujins terminés</h2>
<?php
	$list = new ProjectList();
	$list->useImage(true);
	foreach(Project::getHentaiProjects() as $project) {
		if ($project->isFinished() && $project->isDoujin()) {
			$list->addComponent($project);
		}
	}
	$list->writeNow();
?>
