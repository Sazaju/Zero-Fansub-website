<?php
	
	class Sortie extends IndexLink {
		public function __construct(Project $project, $imageName) {
			$this->setUrl("page=series/".$project->getID());
			$this->setClass("sortie");
			$image = new Image();
			$image->setUrl($imageName);
			$image->setTitle($project->getName());
			$this->addComponent($image);
		}
	}
	
	$completeList = Release::getAllReleases();
	
	function byReleasingDate($a, $b) {
		$a = $a->getReleasingTime();
		$b = $b->getReleasingTime();
		if ($a == $b) {
		    return 0;
		}
		return ($a > $b) ? -1 : 1;
	}
	usort($completeList, 'byReleasingDate');
	
	$list = new SimpleListComponent();
	$list->setClass("sortieList");
	for($i = 3 ; $i > 0 ; $i --) {
		$release = $completeList[$i-1];
		$list->addComponent(new Sortie($release->getProject(), $release->getHeaderImage()));
	}
	$list->writeNow();
?>
