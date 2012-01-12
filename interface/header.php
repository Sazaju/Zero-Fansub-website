<?php
class Sortie extends ReleaseLink {
	public function __construct(Release $release) {
		parent::__construct($release->getProject()->getID(), $release->getID());
		$this->setClass("sortie");
		$this->setContent(new Image($release->getHeaderImage(), $release->getCompleteName()));
	}
}

$completeList = Release::getAllReleases();
usort($completeList, array('Release', 'releasingSorter'));

$list = new SimpleListComponent();
$list->setClass("sortieList");
for($i = 3 ; $i > 0 ; $i --) {
	$release = $completeList[$i-1];
	$list->addComponent(new Sortie($release));
}

$header = new SimpleBlockComponent();
$header->setId("header");
$header->addComponent($list);
$header->writeNow();
?>
