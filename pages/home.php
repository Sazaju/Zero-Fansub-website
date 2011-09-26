<?php
	$page = PageContent::getInstance();
	$page->addComponent(new Archives());

	foreach(News::getAllNews() as $news) {
		$page->addComponent($news);
	}

	// rewrite the archive header as a footer
	$page->addComponent(new Archives());
?>