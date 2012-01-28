<?php
class Format {
	public static function indentHtml($html) {
		// remove useless spaces and tabs
		$cleanHtml = preg_replace("#( |\t)+#i", " ", $html);
		
		// indent lines depending of tag depths
		$explodedHtml = Format::separateTagsAndText($cleanHtml);
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
				$array = array();
				//foreach($closingTags as $id => $row) {
				//foreach($openingTags as $id => $row) {
				foreach($explodedHtml as $id => $row) {
					$array[$id] = htmlentities($row);
				}
				throw new Exception("no opening tag find for $close (line $max) in <code>".Debug::toString($array)."</code>");
			}
			
			for($line = $min + 1; $line < $max ; $line ++) {
				$explodedHtml[$line] = "  ".$explodedHtml[$line];
			}
			$openingTags[$min] = null;
		}
		$openingTags = array_filter($openingTags);
		if (!empty($openingTags)) {
			throw new Exception("no closing tag find for : ".var_dump($openingTags));
		}
		$cleanHtml = implode("\n", $explodedHtml);
		
		// strip blank characters
		$cleanHtml = trim($cleanHtml);
		
		return $cleanHtml;
	}

	public static function truncateText($text, $maxLength) {
		if (strlen($text) > $maxLength) {
			$text = substr($text, 0, $maxLength - 3);
			$text = preg_replace("# [^ ]*$#u", "...", $text);
		}
		return $text;
	}

	public static function separateTagsAndText($html) {
		/*
		$text = strip_tags($html);
		$tIndex = 0;
		$hIndex = 0;
		$aIndex = 0;
		$array = array("");
		while($hIndex < strlen($html)) {
			$tChar = substr($text, $iText, 1);
			$hChar = substr($html, $hText, 1);
			if ($tChar == $hChar) {
				$array[$aIndex] .= $tChar;
				$tIndex += 1;
				$hIndex += 1;
			}
			else if ($hChar != "<") {
				throw new Exception("the HTML character is not a tag opening : ".$hChar);
			}
			else {
				$array = 
			}
		}
		*/
		
		$html = preg_replace("#\n+#", "", $html);
		$html = preg_replace("#>#", "$0\n", $html);
		$html = preg_replace("#<#", "\n$0", $html);
		$html = preg_replace("#\\s*\n\\s*#", "\n", $html);
		$html = explode("\n", $html);
		return $html;
	}

	public static function convertTextToHtml($text) {
		$html = nl2br($text);
		return $html;
	}
	
	public static function formatSize($size) {
		$step = 1024;
		$units = array( 'octets', 'kio', 'Mio', 'Gio', 'Tio' );
		for( $i = 0 ; $size > $step && $i < count( $units ) - 1 ; ++ $i ) {
			$size /= $step;
		}
		$size = round( $size, 2 );
		return $size.' '.$units[$i];
	}
	
	public static function arrayToString($array, $separator = ', ') {
		$string = '';
		foreach($array as $element) {
			$string .= $separator.$element;
		}
		return substr($string, strlen($separator));
	}
	
	public static function trimAndCleanArray($array) {
		$array = array_map(function($s){return trim($s);}, $array);
		$array = array_filter($array, function($s){return !empty($s);});
		return $array;
	}
	
	private static $BBCodeParser = null;
	public static function parseBBCode($text) {
		if (Format::$BBCodeParser === null) {
			Format::$BBCodeParser = new BBCodeParser();
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("b", array('Format', 'simpleOpenTag'), array('Format', 'simpleCloseTag')));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("i", array('Format', 'simpleOpenTag'), array('Format', 'simpleCloseTag')));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("u", array('Format', 'simpleOpenTag'), array('Format', 'simpleCloseTag')));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img", array('Format', 'imageOpenTag'), array('Format', 'simpleCloseTag'), null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("url", array('Format', 'linkOpenTag'), array('Format', 'linkCloseTag')));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("release", array('Format', 'releaseOpenTag'), array('Format', 'releaseCloseTag')));
		}
		return Format::$BBCodeParser->translate($text);
	}
	
	public static function simpleOpenTag($tag, $parameter, $content) {
		return "<$tag>";
	}
	
	public static function simpleCloseTag($tag, $parameter, $content) {
		return "</$tag>";
	}
	
	public static function imageOpenTag($tag, $parameter, $content) {
		$image = new Image($parameter, $content);
		return $image->getOpenTag();
	}
	
	public static function linkOpenTag($tag, $parameter, $content) {
		return "<a href='$parameter'>";
	}
	
	public static function linkCloseTag($tag, $parameter, $content) {
		return "</a>";
	}
	
	public static function releaseOpenTag($tag, $parameter, $content) {
		$parameter = preg_split('#\\|#', $parameter);
		if ($parameter[1] === '*') {
			$parameter[1] = Release::getAllReleasesIDForProject($parameter[0]);
		} else {
			$parameter[1] = Format::trimAndCleanArray(preg_split('#,#', $parameter[1]));
		}
		$link = new ReleaseLink($parameter[0], $parameter[1], null);
		return $link->getOpenTag();
	}
	
	public static function releaseCloseTag($tag, $parameter, $content) {
		return "</a>";
	}
}

?>
