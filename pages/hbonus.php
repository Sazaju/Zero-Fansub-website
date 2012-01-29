<?php
/*
TODO add the advertising on each news page, except home:

<h2>[Zero] BlogBang</h2>
<h4>00/00/00 par db0</h4>
<div class="p"><script src="http://www.blogbang.com/demo/js/blogbang_ad.php?id=6ee3436cd7"
type="text/javascript"></script>
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t64.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=64" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>
*/

	$page = PageContent::getInstance();
	$page->addComponent(new Title("Zéro fansub", 1));
	$page->addComponent(new Archives());
	
	$newsList = array();
	foreach(News::getAllUnclassableNews() as $news) {
		// TODO remove the 'test' feature when the refinement will be completed
		if ($news->getTimestamp() !== null && $news->getTimestamp() <= time() || isset($_GET['test'])) {
			$hMode = $_SESSION[MODE_H];
			if (!$hMode && $news->displayInNormalMode() || $hMode && $news->displayInHentaiMode()) {
				$newsList[] = $news;
			}
		}
	}
	usort($newsList, array('News', 'timestampSorter'));
	foreach($newsList as $news) {
		$page->addComponent(new NewsComponent($news));
	}
	
	// rewrite the archive header as a footer
	$page->addComponent(new Archives());
?>
