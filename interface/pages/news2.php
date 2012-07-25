<?php
	$page = PageContent::getInstance();
	
	$id = Url::getCurrentUrl()->getQueryVar('id');
	$news = News::getNews($id);
	$page->addComponent(new NewsComponent($news));
?>
