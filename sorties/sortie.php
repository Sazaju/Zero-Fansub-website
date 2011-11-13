<?php
	
	class Sortie extends IndexLink {
		public function __construct(Release $release) {
			$this->setUrl("page=series/".$release->getProject()->getID());
			$this->setClass("sortie");
			$this->addComponent(new Image($release->getHeaderImage(), $release->getProject()->getName()));
		}
	}
	
	$completeList = Release::getAllReleases();
	
	function byReleasingDate(Release $a, Release $b) {
		if ($a->getHeaderImage() === null) {
			return 1;
		}
		$ta = $a->getReleasingTime();
		$tb = $b->getReleasingTime();
		if ($ta == $tb) {
		    return 0;
		}
		return ($ta > $tb) ? -1 : 1;
	}
	usort($completeList, 'byReleasingDate');
	
	$list = new SimpleListComponent();
	$list->setClass("sortieList");
	for($i = 3 ; $i > 0 ; $i --) {
		$release = $completeList[$i-1];
		$list->addComponent(new Sortie($release));
	}
	$list->writeNow();
?>
