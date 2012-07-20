<?php
	try {
		$url = new Url();
		
		/***************************************\
		         READ GENERIC QUERY VARS
		\***************************************/
		$page = 'news';
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
		if (!in_array($page, array('project', 'news', 'about', 'contact', 'bug', 'projects',
		                           'team', 'xdcc', 'havert', 'dossiers', 'dossier', 'partenariat',
		                           'kanaiiddl', 'recrutement', 'dakko', 'dons', 'dl', 'recruit'))) {
			throw new Exception("Inexistant page ".$page);
		}
		
		try {
			$id = Url::getCurrentUrl()->getQueryVar('page');
			PageContent::getInstance()->setClass($id);
			
			$page = Page::getPage($id);
			$content = $page->getContent();
			if ($page->useBBCode()) {
				$content = Format::convertTextToHTML($content);
			}
			PageContent::getInstance()->addComponent(new SimpleTextComponent($content));
		} catch(Exception $e) {
			require_once("interface/pages/$page.php");
		}
		PageContent::getInstance()->writeNow();
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
