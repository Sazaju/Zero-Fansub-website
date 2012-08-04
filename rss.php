<?php
	require_once('baseImport.php');
	
	$url = Url::getCurrentUrl();
	$website = Url::getCurrentDirUrl()->toFullString();
	
	$selected = $url->hasQueryVar('select') ? $url->getQueryVar('select') : NEWSSELECTOR_ALL;
	$hMode = $url->hasQueryVar('h') ? $url->getQueryVar('h') : false;
	$selector = new NewsSelector($selected, $hMode);
	$newsList = News::getAllNews($selector);
	usort($newsList, array('News', 'timestampSorter'));
	
	$limit = 50;
	$default = 10;
	$remaining = $url->hasQueryVar("count")
			? min($limit, intval($url->getQueryVar("count")))
			: $default;
	$items = array();
	foreach($newsList as $news) {
		$remaining --;
		if ($remaining < 0) {
			break;
		}
		
		$title = $news->getTitle();
		$link = $news->getUrl()->toFullString();
		$message = Format::convertTextToHtml($news->getMessage());
		$description = Format::truncateText(strip_tags($message), 300);
		$timestamp = $news->getTimestamp();
		
		$item = '';
		$item .= '<title>'.htmlspecialchars($title).'</title>';
		$item .= '<link>'.htmlspecialchars($link).'</link>';
		$item .= '<guid isPermaLink="true">'.htmlspecialchars($link).'</guid>';
		$item .= '<description>'.htmlspecialchars($description).'</description>';
		$item .= '<pubDate>'.strftime('%a, %d %b %G %H:%M:%S GMT', $timestamp).'</pubDate>';
		
		$items[] = '<item>'.$item.'</item>';
	}
	
	$rss = '';
	$rss .= '<?xml version="1.0" encoding="UTF-8"?>';
	$rss .= '<rss version="2.0">';
	$rss .= '<channel>';
	$rss .= '<title>Zéro Fansub</title>';
	$rss .= '<link>'.htmlspecialchars($website).'</link>';
	$rss .= '<description>'.htmlspecialchars('Les news Zéro Fansub').'</description>';
	$rss .= '<language>fr</language>';
	$rss .= Format::arrayToString($items, '');
	$rss .= '</channel>';
	$rss .= '</rss>';

	echo $rss;
?>