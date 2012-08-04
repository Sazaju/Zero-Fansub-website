<?php
	$newsList = News::getAllNews();
	
	/******************************\
	       FILTER NEWS : VIEWS
	\******************************/
	$view = 'all';
	if (Url::getCurrentUrl()->hasQueryVar('view')) {
		$view = Url::getCurrentUrl()->getQueryVar('view');
	}
	
	if ($view === 'all') {
		// keep all news
	} else if ($view === 'releases') {
		$newsList = array_filter($newsList, function(News $news) {return $news->isReleasing();});
	} else if ($view === 'team') {
		$newsList = array_filter($newsList, function(News $news) {return $news->isTeamNews();});
	} else if ($view === 'partners') {
		$newsList = array_filter($newsList, function(News $news) {return $news->isPartnerNews();});
	} else if ($view === 'db0company') {
		$newsList = array_filter($newsList, function(News $news) {return $news->isDb0CompanyNews();});
	} else if ($view === 'unclassable') {
		$newsList = array_filter($newsList, function(News $news) {return !$news->isReleasing();});
		$newsList = array_filter($newsList, function(News $news) {return !$news->isTeamNews();});
		$newsList = array_filter($newsList, function(News $news) {return !$news->isPartnerNews();});
		$newsList = array_filter($newsList, function(News $news) {return !$news->isDb0CompanyNews();});
	} else {
		throw new Exception($view." is not managed");
	}
	
	/******************************\
	       FILTER NEWS : H MODE
	\******************************/
	$newsList = array_filter($newsList, function(News $news) {
		// TODO 'showPrepared' only for authorized people
		if ($news->getTimestamp() !== null && $news->getTimestamp() <= time() || Url::getCurrentUrl()->hasQueryVar('showPrepared')) {
			$hMode = $_SESSION[MODE_H];
			return !$hMode && $news->displayInNormalMode() || $hMode && $news->displayInHentaiMode();
		} else {
			return false;
		}
	});
	
	/******************************\
	         FINALIZE LIST
	\******************************/
	usort($newsList, array('News', 'timestampSorter'));
	
	/******************************\
	       BUILD VIEWS ACCESS
	\******************************/
	$viewMap = array(
		'all' => "Dernières news",
		'releases' => "Sorties",
		'team' => "Infos team",
		'partners' => "Partenaires",
		'db0company' => "db0 company",
		'unclassable' => "Bonus",
	);
	$url = Url::getCurrentUrl();
	$viewsLinks = new SimpleBlockComponent();
	foreach($viewMap as $id => $name) {
		$url->setQueryVar('view', $id);
		$viewsLinks->addComponent(new Link(new Url($url), $name));
	}
	
	$views = new SimpleBlockComponent();
	$views->setClass("views");
	$views->addComponent(new Title("Vues", 2));
	$views->addComponent($viewsLinks);
	
	/******************************\
	           FILL PAGE
	\******************************/
	
	$page = PageContent::getInstance();
	$page->addComponent(new Title("Zéro fansub", 1));
	if (TEST_MODE_ACTIVATED) {
		$options = new SimpleBlockComponent();
		$options->setClass('testFeatures');
		$options->addComponent("Options : ");
		
		$link = new Link(Url::getCurrentUrl(), "show prepared");
		if ($link->getUrl()->hasQueryVar('showPrepared')) {
			$link->getUrl()->removeQueryVar('showPrepared');
			$link->setClass('reverse');
		} else {
			$link->getUrl()->setQueryVar('showPrepared');
		}
		$options->addComponent($link);
		
		$link = new Link(Url::getCurrentUrl(), "show all");
		if ($link->getUrl()->hasQueryVar('showAll')) {
			$link->getUrl()->removeQueryVar('showAll');
			$link->setClass('reverse');
		} else {
			$link->getUrl()->setQueryVar('showAll');
		}
		$options->addComponent($link);
		
		$page->addComponent($options);
	}
	
	$page->addComponent($views);
	
	$remaining = 10;
	if (Url::getCurrentUrl()->hasQueryVar('showAll')) {
		// TODO display this option or implement pages
		$remaining = -1;
	}
	foreach($newsList as $news) {
		$page->addComponent(new NewsComponent($news));
		$remaining --;
		if ($remaining == 0) {
			break;
		}
	}

	$page->addComponent($views);
?>
