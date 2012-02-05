<?php
	try {
		$url = new Url();
		
		/***************************************\
		         READ GENERIC QUERY VARS
		\***************************************/
		$page = 'home';
		if ($url->hasQueryVar('page')) {
			$page = $url->getQueryVar('page');
		}
		
		$id = null;
		if ($url->hasQueryVar('id')) {
			$id = $url->getQueryVar('id');
		}
		
		/***************************************\
		           SPECIAL FEATURES
		\***************************************/
		if ($url->hasQueryVar(DISPLAY_H_AVERT)) {
			$page = "havert";
		}
		
		/***************************************\
		              PAGE LOADING
		\***************************************/
		// refined pages
		if (in_array($page, array('project', 'home', 'about', 'contact', 'bug', 'projects', 'team', 'xdcc', 'havert', 'dossiers', 'dossier', 'partenariat'))) {
			try {
				$page = Page::getPage(Url::getCurrentUrl()->getQueryVar('page'));
				$content = $page->getContent();
				PageContent::getInstance()->addComponent(new SimpleTextComponent(Format::convertTextToHTML($content)));
			} catch(Exception $e) {
				require_once("pages/$page.php");
			}
		}
		
		// not refined pages
		// TODO remove all when the website will be completely refined
		$pageContent = PageContent::getInstance();
		if (count($pageContent->getComponents()) > 0) {
			$pageContent->writeNow();
		}
		else if (file_exists("pages/$page.php")) {
			echo '<div id="page">';
			require_once("pages/$page.php");
			echo '</div>';
		}
		else {
			throw new Exception("Invalid URL");
		}
	} catch(Exception $e) {
		if (TEST_MODE_ACTIVATED) {
			echo '<div id="page">';
			echo 'Invalid URL, the bug page should be displayed in not testing mode.<br/><br/>';
			echo $e->__toString();
			echo '</div>';
		}
		else {
			$pageContent = PageContent::getInstance();
			$pageContent->clear();
			require_once("pages/bug.php");
			$pageContent->writeNow();
		}
	}
?>
