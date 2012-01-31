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
		$text = htmlentities($text);
		$text = Format::parseBBCode($text);
		$text = str_replace("\n", '<br/>', $text);
		return $text;
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
		$array = array_map(function($s){return is_string($s) ? trim($s) : $s;}, $array);
		$array = array_filter($array, function($s){return !empty($s);});
		return $array;
	}
	
	private static $BBCodeParser = null;
	public static function parseBBCode($text) {
		if (Format::$BBCodeParser === null) {
			Format::$BBCodeParser = new BBCodeParser();
			
			/**********************************\
			          NO CLOSING TAGS
			\**********************************/
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("separator", function($tag, $parameter, $content) {return Separator::getInstance()->getHtml();}));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("pin", function($tag, $parameter, $content) {return Pin::getInstance()->getHtml();}));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("advert", function($tag, $parameter, $content) {return "<script src='http://www.blogbang.com/demo/js/blogbang_ad.php?id=6ee3436cd7' type='text/javascript'></script>";}));
			
			/**********************************\
			         NO PARAMETERED TAGS
			\**********************************/
			$notFormattedContent = function($tag, $parameter, $content) {
				return BBCodeDescriptor::contentToString($content);
			};
			$simpleOpenTag = function($tag, $parameter, $content) {return "<$tag>";};
			$simpleCloseTag = function($tag, $parameter, $content) {return "</$tag>";};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("b", $simpleOpenTag, $simpleCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("i", $simpleOpenTag, $simpleCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("u", $simpleOpenTag, $simpleCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("code", $simpleOpenTag, $simpleCloseTag, $notFormattedContent));
			
			/**********************************\
			                SIZE
			\**********************************/
			$sizeOpenTag = function($tag, $parameter, $content) {
				$parameter = is_numeric($parameter) ? $parameter.'em' : $parameter;
				return "<span style='font-size: ".$parameter.";'>";
			};
			$sizeCloseTag = function($tag, $parameter, $content) {return "</span>";};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("size", $sizeOpenTag, $sizeCloseTag));
			
			/**********************************\
			               COLORS
			\**********************************/
			$colorOpenTag = function($tag, $parameter, $content) {
				return "<span style='color: $parameter;'>";
			};
			$colorCloseTag = function($tag, $parameter, $content) {return "</span>";};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("color", $colorOpenTag, $colorCloseTag));
			
			/**********************************\
			              ALIGNEMENT
			\**********************************/
			$alignOpenTag = function($tag, $parameter, $content) {
				if ($tag === 'align') {
					$tag = empty($parameter) ? 'inherited' : $parameter;
				}
				if (in_array($tag, array('left', 'right', 'center', 'justify'))) {
					return "<div style='text-align: $tag;'>";
				} else {
					throw new Exception($tag." is not managed");
				}
			};
			$alignCloseTag = function($tag, $parameter, $content) {
				return "</div>";
			};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("left", $alignOpenTag, $alignCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("right", $alignOpenTag, $alignCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("center", $alignOpenTag, $alignCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("justify", $alignOpenTag, $alignCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("align", $alignOpenTag, $alignCloseTag));
			
			/**********************************\
			         LISTS & LIST ITEMS
			\**********************************/
			$listOpenTag = function($tag, $parameter, $content) {
				if ($tag === 'list') {
					return $parameter === '1' ? '<ol>' : '<ul>';
				} else if ($tag === 'item') {
					return '<li>';
				} else {
					throw new Exception($tag." is not managed");
				}
			};
			$listCloseTag =  function($tag, $parameter, $content) {
				if ($tag === 'list') {
					return $parameter === '1' ? '</ol>' : '</ul>';
				} else if ($tag === 'item') {
					return '</li>';
				} else {
					throw new Exception($tag." is not managed");
				}
			};
			$listContent =  function($tag, $parameter, $content) {
				if ($tag === 'list') {
					$content = Format::trimAndCleanArray($content);
					return BBCodeDescriptor::defaultContentCallback($tag, $parameter, $content);
				}
			};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("list", $listOpenTag, $listCloseTag, $listContent));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("item", $listOpenTag, $listCloseTag));
			
			/**********************************\
			               IMAGES
			\**********************************/
			$imageOpenTag = function($tag, $parameter, $content) {
				if (empty($parameter)) {
					$parameter = $content;
					$content = null;
				}
				if (empty($parameter)) {
					$parameter = $default;
				}
				
				if ($tag === 'img') {
					$image = new Image($parameter, $content);
				} else if (in_array($tag, array('img-left', 'imgl'))) {
					$image = new Image($parameter, $content);
					$image->makeLeftFloating();
				} else if (in_array($tag, array('img-right', 'imgr'))) {
					$image = new Image($parameter, $content);
					$image->makeRightFloating();
				} else if (in_array($tag, array('img-auto', 'imga'))) {
					$image = new AutoFloatImage($parameter, $content);
				} else if (in_array($tag, array('img-auto-right', 'imgar'))) {
					$image = new AutoFloatImage($parameter, $content, true);
				} else if (in_array($tag, array('img-auto-left', 'imgal'))) {
					$image = new AutoFloatImage($parameter, $content, false);
				} else {
					throw new Exception($tag." is not managed");
				}
				return $image->getOpenTag();
			};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img", $imageOpenTag, $simpleCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img-right", $imageOpenTag, $simpleCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("imgr", $imageOpenTag, $simpleCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img-left", $imageOpenTag, $simpleCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("imgl", $imageOpenTag, $simpleCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img-auto", $imageOpenTag, $simpleCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("imga", $imageOpenTag, $simpleCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img-auto-left", $imageOpenTag, $simpleCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("imgal", $imageOpenTag, $simpleCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img-auto-right", $imageOpenTag, $simpleCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("imgar", $imageOpenTag, $simpleCloseTag, null));
			
			/**********************************\
			          GENERIC LINKS
			\**********************************/
			$linkOpenTag = function($tag, $parameter, $content) {
				if (empty($parameter) && empty($content)) {
					$parameter = $default;
					$content = $default;
				} else if (empty($content)) {
					$content = $parameter;
				} else if (empty($parameter)) {
					$parameter = $content;
				} else {
					// nothing is empty, so let as is
				}
				
				if (in_array($tag, array('url', 'ext'))) {
					$link = new Link($parameter, $content);
					if ($tag == 'ext' || $tag == 'url' && !$link->isLocalLink()) {
						$link->openNewWindow(true);
					}
				} else if ($tag == 'mail') {
					$link = new MailLink($parameter, $content);
				} else {
					throw new Exception($tag." is not managed");
				}
				return $link->getOpenTag();
			};
			$linkCloseTag = function($tag, $parameter, $content) {return "</a>";};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("url", $linkOpenTag, $linkCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("ext", $linkOpenTag, $linkCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("mail", $linkOpenTag, $linkCloseTag));
			
			/**********************************\
			          SPECIAL LINKS
			\**********************************/
			$releaseOpenTag = function($tag, $parameter, $content) {
				$parameter = preg_split('#\\|#', $parameter);
				if ($parameter[1] === '*') {
					$parameter[1] = Release::getAllReleasesIDForProject($parameter[0]);
				} else {
					$parameter[1] = Format::trimAndCleanArray(preg_split('#,#', $parameter[1]));
				}
				$link = new ReleaseLink($parameter[0], $parameter[1], null);
				return $link->getOpenTag();
			};
			$projectOpenTag = function($tag, $parameter, $content) {
				if (empty($parameter)) {
					$link = new ProjectLink(Project::getProject($content));
				} else {
					$parameter = preg_split('#\\|#', $parameter);
					try {
						$link = new ProjectLink(Project::getProject($parameter[0]));
					} catch(Exception $e) {
						$link = new ProjectLink(Project::getProject($content));
					}
				}
				return $link->getOpenTag();
			};
			$projectContent = function($tag, $parameter, $content) {
				if (empty($parameter)) {
					$link = new ProjectLink(Project::getProject($content));
				} else {
					$parameter = preg_split('#\\|#', $parameter);
					try {
						$link = new ProjectLink(Project::getProject($parameter[0]));
						if (!empty($content)) {
							$link->setContent(BBCodeDescriptor::contentToHTML($content));
						}
					} catch(Exception $e) {
						$link = new ProjectLink(Project::getProject($content));
					}
					
					if (in_array('image', $parameter)) {
						$link->useImage(true);
					}
				}
				return $link->getCurrentContent();
			};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("release", $releaseOpenTag, $linkCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("project", $projectOpenTag, $linkCloseTag, $projectContent));
			
			/**********************************\
			              SPOILER
			\**********************************/
			$spoilerOpenTag = function($tag, $parameter, $content) {
				static $id = 0;
				$id++;
				$index = 0;
				while(empty($parameter)) {
					$parameter = $content[$index];
					if (is_string($parameter)) {
						$parameter = trim($parameter);
					}
					$index++;
				}
				if ($parameter instanceof BBCodeDescriptor) {
					$parameter = $parameter->generateHTML();
				}
				// TODO show the spoiler if javascript deactivated
				return "<a href=\"#\" onClick=\"show('spoiler$id');return(false)\">$parameter</a><div id=\"spoiler$id\" style=\"display: none;\">";
			};
			$spoilerContent = function($tag, $parameter, $content) {
				$index = 0;
				while(empty($parameter)) {
					$parameter = $content[$index];
					if (is_string($parameter)) {
						$parameter = trim($parameter);
					}
					$index++;
				}
				if ($index > 0) {
					unset($content[$index-1]);
				}
				return BBCodeDescriptor::defaultContentCallback($tag, $parameter, $content);
			};
			$spoilerCloseTag = function($tag, $parameter, $content) {return '</div>';};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("spoiler", $spoilerOpenTag, $spoilerCloseTag, $spoilerContent));
			
			/**********************************\
			              VIDEOS
			\**********************************/
			function parseVideoParameter($parameter) {
				$parameter = preg_split('#\\|#', $parameter);
				$result = array();
				foreach($parameter as $row) {
					$row = preg_split('#:#', $row);
					if (in_array($row[0], array('width', 'height'))) {
						$result[$row[0]] = $row[1];
					} else {
						throw new Exception($row[0]." is not managed");
					}
				}
				if (!isset($result['width']) || $result['width'] <= 0) {
					throw new Exception("The width of the video is not well defined");
				}
				if ($result['height'] <= 0) {
					throw new Exception("The height of the video is not well defined");
				}
				return $result;
			};
			$videoOpenTag = function($tag, $parameter, $content) {
				$parameter = parseVideoParameter($parameter);
				$width = $parameter['width'];
				$height = $parameter['height'];
				return "<object width='$width' height='$height'><param name='allowfullscreen' value='true' /><param name='allowscriptaccess' value='always' /><param name='movie' value='$content' />";
			};
			$videoContent = function($tag, $parameter, $content) {
				$parameter = parseVideoParameter($parameter);
				$width = $parameter['width'];
				$height = $parameter['height'];
				return "<embed src='$content' type='application/x-shockwave-flash' allowfullscreen='true' allowscriptaccess='always' width='$width' height='$height'></embed>";
			};
			$videoCloseTag = function($tag, $parameter, $content) {
				return "</object>";
			};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("video", $videoOpenTag, $videoCloseTag, $videoContent));
		}
		return Format::$BBCodeParser->translate($text);
	}
}

?>
