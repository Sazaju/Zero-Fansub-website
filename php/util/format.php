<?php

function formatHtml($html) {
	// remove useless spaces and tabs
	$html = preg_replace("#( |\t)+#i", " ", $html);
	
	// place newlines to separate tags & content
	$html = preg_replace("#\n*#i", "", $html);
	$html = preg_replace("#>#i", "$0\n", $html);
	$html = preg_replace("#<#i", "\n$0", $html);
	$html = preg_replace("#\n+#i", "\n", $html);
	
	// indent lines depending of tag depths
	$explodedHtml = explode("\n", $html);
	$closingTags = preg_filter("#</(.+)>#iu", "$1", $explodedHtml);
	$openingTags = preg_filter("#<(".implode("|", $closingTags).")( .*)?(?!/)>#iu", "$1", $explodedHtml);
	foreach($closingTags as $max => $close) {
		$min = -1;
		foreach($openingTags as $line => $open) {
			if ($line > $max) {
				break;
			}
			else if ($open == $close) {
				$min = $line;
			}
		}
		
		if ($min == -1) {
			throw new Exception("no opening tag find for $close (line $max)");
		}
		
		for($line = $min + 1; $line < $max ; $line ++) {
			$explodedHtml[$line] = "    ".$explodedHtml[$line];
		}
		$openingTags[$min] = null;
	}
	$openingTags = array_filter($openingTags);
	if (!empty($openingTags)) {
		throw new Exception("no closing tag find for : ".var_dump($openingTags));
	}
	$html = implode("\n", $explodedHtml);
	
	return $html;
}

?>