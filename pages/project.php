<?php
$page = PageContent::getInstance();
$page->setClass('project');
$project = Project::getProject(Url::getCurrentUrl()->getQueryVar('id'));

if ($project->isHentai() && !$_SESSION[MODE_H]) {
	require_once("pages/havert.php");
}
else {
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
	
	$page->addComponent(new Title($project->getName(), 1));
	$page->addComponent(new ProjectComponent($project, Url::getCurrentUrl()->hasQueryVar('showHidden')));
}
?>