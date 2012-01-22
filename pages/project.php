<?php
$page = PageContent::getInstance();
$project = Project::getProject($id);

if ($project->isHentai() && !$_SESSION[MODE_H]) {
	require_once("pages/havert.php");
}
else {
	$page->addComponent(new Title($project->getName(), 1));
	$page->addComponent(new ProjectComponent($project));
}
?>