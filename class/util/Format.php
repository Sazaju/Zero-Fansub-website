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
	
	private static $BBHandler = null;
	public static function parseBBCode($text) {
		if (Format::$BBHandler === null) {
			$arrayBBCode = array(
				'b'		=> array(
								'type'			=> BBCODE_TYPE_NOARG,
								'open_tag'		=> '<b>',
								'close_tag'		=> '</b>',
							),
				'i'		=> array(
								'type'			=> BBCODE_TYPE_NOARG,
								'open_tag'		=> '<i>',
								'close_tag'		=> '</i>',
								//'childs'		=> 'b',
							),
				'url'	=> array(
								'type'			=> BBCODE_TYPE_OPTARG,
								'open_tag'		=> '<a href="{PARAM}">',
								'close_tag'		=> '</a>',
								'default_arg'	=> '{CONTENT}',
								//'childs'		=> 'b,i,img',
							),
				'img'	=> array(
								'type'			=> BBCODE_TYPE_NOARG,
								'open_tag'		=> '<img src="',
								'close_tag'		=> '" />',
							),
			);
			Format::$BBHandler = bbcode_create($arrayBBCode);
		}
		return bbcode_parse(Format::$BBHandler, $text);
	}
}

?>
