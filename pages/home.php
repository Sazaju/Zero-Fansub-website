<?php
	/******************************\
	     CHECK NO NULL PROPERTY
	\******************************/
	$newsList = News::getAllNews();
	array_map(function(News $news) {
		$properties = array();
		$properties['isReleasing'] = $news->isReleasing();
		$properties['isTeamNews'] = $news->isTeamNews();
		$properties['isPartnerNews'] = $news->isPartnerNews();
		$properties['isDb0CompanyNews'] = $news->isDb0CompanyNews();
		try {
			array_map(function($name, $property) {
				if ($property === null) {
					throw new Exception($name);
				}
			}, array_keys($properties), $properties);
		} catch(Exception $e) {
			$property = $e->getMessage();
			throw new Exception($property."() is null for the news ".$news->getTitle());
		}
	}, $newsList);
	
	/******************************\
	       FILTER NEWS : VIEWS
	\******************************/
	$view = 'home';
	if (Url::getCurrentUrl()->hasQueryVar('view')) {
		$view = Url::getCurrentUrl()->getQueryVar('view');
	}
	
	if ($view === 'home') {
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
		// TODO remove the 'test' feature when the refinement will be completed
		if ($news->getTimestamp() !== null && $news->getTimestamp() <= time() || isset($_GET['test'])) {
			$hMode = $_SESSION[MODE_H];
			return !$hMode && $news->displayInNormalMode() || $hMode && $news->displayInHentaiMode();
		} else {
			return false;
		}
	});
	
	/******************************\
	         FINALIZE LIST
	\******************************/
	if ($view !== 'home') {
		$advert = new News();
		$advert->setTitle("[Zero] BlogBang");
		$advert->setTimestamp(strtotime("now"));
		$advert->setMessage("[advert]");
		$advert->setCommentId(64);
		$advert->setDisplayInNormalMode(true);
		$advert->setDisplayInHentaiMode(true);
		$advert->setTeamNews(false);
		$advert->setPartnerNews(false);
		$advert->setDb0CompanyNews(false);
		$newsList[] = $advert;
	}
	usort($newsList, array('News', 'timestampSorter'));
	
	/******************************\
	       BUILD VIEWS ACCESS
	\******************************/
	$space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$url = new Url("index.php");
	$url->setQueryVar('page', 'home');
	$viewsLinks = new SimpleBlockComponent();
	$url->removeQueryVar('view');
	$viewsLinks->addComponent(new Link(new Url($url), "Derni&egrave;res news"));
	$viewsLinks->addComponent($space);
	$url->setQueryVar('view', 'releases');
	$viewsLinks->addComponent(new Link(new Url($url), "Sorties"));
	$viewsLinks->addComponent($space);
	$url->setQueryVar('view', 'team');
	$viewsLinks->addComponent(new Link(new Url($url), "Infos team"));
	$viewsLinks->addComponent($space);
	$url->setQueryVar('view', 'partners');
	$viewsLinks->addComponent(new Link(new Url($url), "Partenaires"));
	$viewsLinks->addComponent($space);
	$url->setQueryVar('view', 'db0company');
	$viewsLinks->addComponent(new Link(new Url($url), "db0 company"));
	$viewsLinks->addComponent($space);
	$url->setQueryVar('view', 'unclassable');
	$viewsLinks->addComponent(new Link(new Url($url), "Bonus"));
	
	$views = new SimpleBlockComponent();
	$views->setClass("views");
	$views->addComponent("<h2>Vues</h2>");
	$views->addComponent($viewsLinks);
	
	/******************************\
	           FILL PAGE
	\******************************/
	
	$page = PageContent::getInstance();
	$page->addComponent(new Title("Zéro fansub", 1));
	
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
