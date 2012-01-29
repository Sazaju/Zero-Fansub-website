<?php
	$page = PageContent::getInstance();
	$page->addComponent(new Title("Zéro fansub", 1));
	$page->addComponent(new Archives());
	
	$newsList = array();
	foreach(News::getAllPartnerNews() as $news) {
		// TODO remove the 'test' feature when the refinement will be completed
		if ($news->getTimestamp() !== null && $news->getTimestamp() <= time() || isset($_GET['test'])) {
			$hMode = $_SESSION[MODE_H];
			if (!$hMode && $news->displayInNormalMode() || $hMode && $news->displayInHentaiMode()) {
				$newsList[] = $news;
			}
		}
	}
	usort($newsList, array('News', 'timestampSorter'));
	foreach($newsList as $news) {
		$page->addComponent(new NewsComponent($news));
	}
	
	// rewrite the archive header as a footer
	$page->addComponent(new Archives());
?>
