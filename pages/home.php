<?php
	$page = PageContent::getInstance();
	$page->addComponent(new Archives());

	foreach(News::getAllNews() as $news) {
		if ($news->getTimestamp() <= time()) {
			$page->addComponent($news);
		}
	}

	// rewrite the archive header as a footer
	$page->addComponent(new Archives());
?>