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
		
		// compatibility for obsolete links
		// TODO remove when the website will be completely refined
		if (preg_match("#^series/#", $page)) {
			$page = 'project';
			$parts = preg_split("#/#", $page);
			$id = $parts[1];
		}
		
		/***************************************\
		              PAGE LOADING
		\***************************************/
		// refined pages
		if (in_array($page, array('project', 'home', 'about', 'contact', 'bug', 'series', 'team', 'xdcc', 'havert'))) {
			require_once("pages/$page.php");
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
			$pagecontent->clear();
			require_once("pages/bug.php");
			$pageContent->writeNow();
		}
	}
?>
