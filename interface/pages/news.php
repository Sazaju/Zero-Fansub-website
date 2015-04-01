<?php
	$url = Url::getCurrentUrl();
	new NewsSelector();//force class loading for constants
	
	/******************************\
	          LOAD NEWS
	\******************************/
	$selected = $url->hasQueryVar('select') ? $url->getQueryVar('select') : NEWSSELECTOR_ALL;
	$selector = new NewsSelector($selected, $_SESSION[MODE_H]);
	if (Url::getCurrentUrl()->hasQueryVar('showPrepared')) {
		$selector->setPreparedShown(true);
	}
	$newsList = News::getAllNews($selector);
	usort($newsList, array('News', 'timestampSorter'));
	
	/******************************\
	       BUILD VIEWS ACCESS
	\******************************/
	$viewMap = array(
		NEWSSELECTOR_ALL => "Dernières news",
		NEWSSELECTOR_RELEASES => "Sorties",
		NEWSSELECTOR_TEAM => "Infos team",
		NEWSSELECTOR_PARTNERS => "Partenaires",
		NEWSSELECTOR_DB0COMPANY => "db0 company",
		NEWSSELECTOR_MISC => "Bonus",
	);
	$viewsLinks = new SimpleBlockComponent();
	foreach($viewMap as $id => $name) {
		$url->setQueryVar('select', empty($id) ? null : $id, true);
		$viewsLinks->addComponent(new Link(new Url($url), $name));
	}
	
	$views = new HeaderComponent();
	$views->setClass("views");
	$rssUrl = buildRssUrlIfAvailable();
	$title = new Title(null, 2);
	$title->addComponent(new RssLink($rssUrl));
	$title->addComponent("Vues");
	$views->addComponent($title);
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
		
		$link = new Link(Url::getCurrentUrl(), "show old");
		if ($link->getUrl()->hasQueryVar('showOld')) {
			$link->getUrl()->removeQueryVar('showOld');
			$link->setClass('reverse');
		} else {
			$link->getUrl()->setQueryVar('showOld');
		}
		$options->addComponent($link);
		
		$page->addComponent($options);
	}
	
	$page->addComponent($views);
	
	$remaining = 10;
	if (Url::getCurrentUrl()->hasQueryVar('showOld')) {
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