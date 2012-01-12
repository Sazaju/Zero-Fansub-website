<?php
	$page = PageContent::getInstance();
	$page->addComponent(new Archives());
	
	$newsList = array();
	foreach(News::getAllNews() as $news) {
		// TODO remove the 'test' feature when the refinement will be completed
		if ($news->getTimestamp() !== null && $news->getTimestamp() <= time() || isset($_GET['test'])) {
			$newsList[] = $news;
		}
	}
	usort($newsList, array('News', 'timestampSorter'));
	$remaining = 10;
	foreach($newsList as $news) {
		$page->addComponent(new NewsComponent($news));
		$remaining --;
		if ($remaining == 0) {
			break;
		}
	}

	// rewrite the archive header as a footer
	$page->addComponent(new Archives());
?>
