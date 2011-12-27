<?php
	$page = PageContent::getInstance();
	$page->addComponent(new Archives());
	
	$newsList = array();
	foreach(News::getAllNews() as $news) {
		if ($news->getTimestamp() !== null && $news->getTimestamp() <= time() || isset($_GET['test'])) {
			$newsList[] = $news;
		}
	}
	usort($newsList, array('News', 'timestampSorter'));
	foreach($newsList as $news) {
		$page->addComponent($news);
	}

	// rewrite the archive header as a footer
	$page->addComponent(new Archives());
?>
