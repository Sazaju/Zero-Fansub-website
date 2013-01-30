<?php

class Format {

	private static function introduceRows(&$array, $index, $content) {
		$exploded = preg_split("#\n#", $content);
		foreach ($exploded as $newRow) {
			$array[$index] = $newRow;
			$index += strlen($newRow);
		}
	}

	public static function indentHtml($html, $tab = "\t", $wrapSize = 80) {
		// remove useless blank characters
		$html = preg_replace("#\s+#i", " ", $html);

		// explode the code
		$exploder = new StringExploder();
		$exploder->addDescriptor(new StringExploderDescriptor("#<[^/\s][^>]*>#", true));
		$exploder->addDescriptor(new StringExploderDescriptor("#</[^>]+>#", false));
		$array = $exploder->parse($html);

		// ignore auto closing tags
		foreach ($array as $index => $row) {
			if (is_array($row) && preg_match("#/>$#", $row[0])) {
				$array[$index] = $row[0];
			} else {
				// do nothing to simple strings
			}
		}

		// consistency check
		$temp = array_filter($array, function($row) {
					return is_array($row);
				});
		$indexStack = array();
		$tagStack = array();
		// var_dump($temp);
		foreach ($temp as $index => $row) {
			if ($row[1]) {
				array_push($indexStack, $index);
			} else {
				$openIndex = array_pop($indexStack);
				$openTag = $temp[$openIndex][0];
				$closeTag = $row[0];
				$tag = substr($closeTag, 2, strlen($closeTag) - 3);
				if (strpos($openTag, '<' . $tag) !== 0) {
					var_dump($temp);
					throw new Exception(htmlentities($closeTag) . " at $index does not close " . htmlentities($openTag) . " at $openIndex.");
				} else {
					unset($temp[$openIndex]);
					unset($temp[$index]);
				}
			}
		}
		if (!empty($temp)) {
			var_dump($temp);
			throw new Exception("Some tags are in conflict.");
		} else {
			// all seems consistent, continue
		}

		$diff = null;
		$refArray = $array;
		do {
			// ignore small tags
			$indexes = null;
			$concat = "";
			foreach ($array as $index => $row) {
				if (is_array($row)) {
					if ($row[1]) {
						$indexes = array($index);
						$concat = $row[0];
					} else if (!empty($indexes)) {
						$indexes[] = $index;
						$concat .= $row[0];
						if (strlen($concat) < $wrapSize) {
							foreach ($indexes as $i) {
								unset($array[$i]);
							}
							$array[$indexes[0]] = $concat;
						}
						$indexes = null;
					} else {
						// closing tag of a higher level, let as is
					}
				} else {
					if (!empty($indexes)) {
						$indexes[] = $index;
						$concat .= $row;
					}
				}
			}
			ksort($array);

			// merge consecutive ignored parts
			$refIndex = null;
			foreach ($array as $index => $row) {
				if (is_string($row)) {
					if ($refIndex !== null) {
						$array[$refIndex] .= $array[$index];
						unset($array[$index]);
					} else {
						$refIndex = $index;
					}
				} else {
					$refIndex = null;
				}
			}
			
// 			$diff = array_diff_assoc($refArray, $array);
			$diff = Format::array_diff_values($refArray, $array);
			$refArray = $array;
		} while (!empty($diff));

		// force new lines around tags which are naturally displayed as blocks
		foreach ($array as $index => $row) {
			if (is_string($row)) {
				$blockTags = "(?:li|ul|ol|div|h\d|hr)";
				$autoCloseTags = "(?:br|hr)";
				$attributes = " ?[^>]*";
				$out = "[^\n]";
				$row = preg_replace("#($out)(<$blockTags$attributes>)#", "$1\n$2", $row);
				$row = preg_replace("#(</\s*$blockTags\s*>)(?=$out)#", "$1\n", $row);
				$row = preg_replace("#(<$autoCloseTags$attributes/>)(?=$out)#", "$1\n", $row);

				Format::introduceRows($array, $index, $row);
			} else {
				// do nothing on array elements
			}
		}
		ksort($array);

		// wrap too long lines
		foreach ($array as $index => $row) {
			if (is_string($row)) {
				if (strlen($row) > $wrapSize) {
					Format::introduceRows($array, $index, wordwrap($row, $wrapSize, "\n", false));
				} else {
					// do nothing to small lines
				}
			} else {
				// do nothing to array parts
			}
		}
		ksort($array);

		// wrap too long open tags, with preindent
		foreach ($array as $index => $row) {
			if (is_array($row) && $row[1]) {
				$content = $row[0];
				if (strlen($content) > $wrapSize) {
					$content = preg_replace("#\s*(\S+\s*=\s*\"[^\"]*\")#", "\n$tab$1", $content);
					$content = preg_replace("#\s*(\S+\s*=\s*'[^']*')#", "\n$tab$1", $content);
					$content = preg_replace("#\n$tab#", " ", $content, 1);
					Format::introduceRows($array, $index, $content);
					$array[$index] = array($array[$index], true);
				} else {
					// do nothing to small lines
				}
			} else {
				// do nothing to simple strings and closing tags
			}
		}
		ksort($array);

		// indent lines
		$indent = "";
		foreach ($array as $index => $row) {
			if (is_array($row)) {
				if ($row[1]) {
					$array[$index] = $indent . $row[0];
					$indent .= $tab;
				} else {
					$indent = substr($indent, strlen($tab));
					$array[$index] = $indent . $row[0];
				}
			} else {
				$array[$index] = $indent . $row;
			}
		}

		// concat all lines
		$html = implode("\n", $array);

		return "\n$html\n";
	}

	public static function array_diff_values($tab1, $tab2) {
		$result = array();
		foreach($tab1 as $values) {
			if (!in_array($values, $tab2)) {
				$result[] = $values;
			} else {
				continue;
			}
		}
		return $result;
	}
	
	public static function truncateText($text, $maxLength) {
		$length = strlen($text);
		if ($length > $maxLength) {
			$extract = substr($text, 0, $maxLength - 2);
			if ($extract[count($extract)-1] == " ") {
				$extract = rtrim($extract)."...";
			} else {
				$extract = preg_replace('#( [^ ]*$)|(.$)#u', "...", $extract);
			}
			return $extract;
		} else {
			return $text;
		}
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
		$text = htmlspecialchars($text);
		$text = str_replace("  ", '&nbsp ', $text);
		$text = Format::parseBBCode($text);
		$text = str_replace("\n", '<br/>', $text);
		return $text;
	}

	public static function formatSize($size) {
		$step = 1024;
		$units = array('octets', 'kio', 'Mio', 'Gio', 'Tio');
		for ($i = 0; $size > $step && $i < count($units) - 1; ++$i) {
			$size /= $step;
		}
		$size = round($size, 2);
		return $size . ' ' . $units[$i];
	}

	public static function arrayToString($array, $separator = ', ') {
		$string = '';
		foreach ($array as $element) {
			$string .= $separator . $element;
		}
		return substr($string, strlen($separator));
	}

	public static function trimAndCleanArray($array) {
		$array = array_map(function($s) {
					return is_string($s) ? trim($s) : $s;
				}, $array);
		$array = array_filter($array, function($s) {
					return!empty($s);
				});
		return array_values($array);
	}

	private static $BBCodeParser = null;

	public static function parseBBCode($text) {
		if (Format::$BBCodeParser === null) {
			Format::$BBCodeParser = new BBCodeParser();

			/**********************************\
			          NO CLOSING TAGS
			\**********************************/
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("separator", function($tag, $parameter, $content) {
								return Separator::getInstance()->getHtml();
							}));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("pin", function($tag, $parameter, $content) {
								return Pin::getInstance()->getHtml();
							}));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("advert", function($tag, $parameter, $content) {
								return "<script src='http://www.blogbang.com/demo/js/blogbang_ad.php?id=6ee3436cd7' type='text/javascript'></script>";
							}));

			/**********************************\
			       NO PARAMETERED TAGS
			\**********************************/
			$notFormattedContent = function($tag, $parameter, $content) {
						return BBCodeDescriptor::contentToString($content);
					};
			$simpleOpenTag = function($tag, $parameter, $content) {
						return "<$tag>";
					};
			$simpleCloseTag = function($tag, $parameter, $content) {
						return "</$tag>";
					};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("b", $simpleOpenTag, $simpleCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("i", $simpleOpenTag, $simpleCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("u", $simpleOpenTag, $simpleCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("s", $simpleOpenTag, $simpleCloseTag));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("code", $simpleOpenTag, $simpleCloseTag, $notFormattedContent));

			/**********************************\
			                TITLE
			\**********************************/
			$titleOpenTag = function($tag, $parameter, $content) {
						$level = 1;
						if ($parameter === null) {
							// let as is
						}
						else {
							$parameters = preg_split('#\\|#', $parameter);
							$level = $parameters[0];
						}
						return "<h".$level.">";
					};
			$titleContent = function($tag, $parameter, $content) {
						$level = 1;
						static $lastNumbers = array();
						if ($parameter === null) {
							// let as is
						}
						else {
							$parameters = preg_split('#\\|#', $parameter);
							$level = $parameters[0];
							if (count($parameters) == 2) {
								if ($parameters[1] == 'number') {
									if (in_array($level, array_keys($lastNumbers))) {
										$lastNumbers[$level]++;
									} else {
										$lastNumbers[$level] = 1;
									}
									$content = $lastNumbers[$level].". ".$content;
								} else {
									throw new Exception($parameters[1]." is not a known parameter");
								}
							} else {
								// do nothing special
							}
						}
						return $content;
					};
			$titleCloseTag = function($tag, $parameter, $content) {
						$level = 1;
						if ($parameter === null) {
							// let as is
						}
						else {
							$parameters = preg_split('#\\|#', $parameter);
							$level = $parameters[0];
						}
						return "</h".$level.">";
					};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("title", $titleOpenTag, $titleCloseTag, $titleContent));

			/**********************************\
			                SIZE
			\**********************************/
			$sizeOpenTag = function($tag, $parameter, $content) {
						$parameter = is_numeric($parameter) ? $parameter . 'em' : $parameter;
						return "<span style='font-size: " . $parameter . ";'>";
					};
			$sizeCloseTag = function($tag, $parameter, $content) {
						return "</span>";
					};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("size", $sizeOpenTag, $sizeCloseTag));

			/**********************************\
			              COLORS
			\**********************************/
			$colorOpenTag = function($tag, $parameter, $content) {
						return "<span style='color: $parameter;'>";
					};
			$colorCloseTag = function($tag, $parameter, $content) {
						return "</span>";
					};
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
							throw new Exception($tag . " is not managed");
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
							throw new Exception($tag . " is not managed");
						}
					};
			$listCloseTag = function($tag, $parameter, $content) {
						if ($tag === 'list') {
							return $parameter === '1' ? '</ol>' : '</ul>';
						} else if ($tag === 'item') {
							return '</li>';
						} else {
							throw new Exception($tag . " is not managed");
						}
					};
			$listContent = function($tag, $parameter, $content) {
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
							throw new Exception("No image given");
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
							throw new Exception($tag . " is not managed");
						}
						return $image->getCurrentHTML();
					};
			$imageCloseTag = function($tag, $parameter, $content) {
						return "";
					};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img", $imageOpenTag, $imageCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img-right", $imageOpenTag, $imageCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("imgr", $imageOpenTag, $imageCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img-left", $imageOpenTag, $imageCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("imgl", $imageOpenTag, $imageCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img-auto", $imageOpenTag, $imageCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("imga", $imageOpenTag, $imageCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img-auto-left", $imageOpenTag, $imageCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("imgal", $imageOpenTag, $imageCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("img-auto-right", $imageOpenTag, $imageCloseTag, null));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("imgar", $imageOpenTag, $imageCloseTag, null));

			/**********************************\
			          GENERIC LINKS
			\**********************************/
			$linkOpenTag = function($tag, $parameter, $content) {
						if (empty($parameter) && empty($content)) {
							throw new Exception("no data has been given");
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
						} else if ($tag == 'urlk') {
							$parameter = preg_split('#\\|#', $parameter);
							$url = null;
							if (in_array('current', $parameter)) {
								$url = Url::getCurrentUrl();
							} else if (in_array('referer', $parameter)) {
								$url = new Url($_SERVER['HTTP_REFERER']);
							} else {
								throw new Exception("no address keyword has been given (like 'current' or 'referer')");
							}
							$full = false;
							if (in_array('full', $parameter)) {
								$full = true;
							}
							$link = new Link($url, $content, $full);
							if (!$link->isLocalLink()) {
								$link->openNewWindow(true);
							}
						} else if ($tag == 'mail') {
							if (is_numeric($parameter)) {
								$parameter = TeamMember::getMember(intval($parameter))->getMail();
							}
							$link = new MailLink($parameter, $content);
						} else {
							throw new Exception($tag . " is not managed");
						}
						return $link->getOpenTag();
					};
			$linkContent = function($tag, $parameter, $content) {
						if ($tag === 'urlk') {
							if ($content === null) {
								$parameter = preg_split('#\\|#', $parameter);
								$url = null;
								if (in_array('current', $parameter)) {
									$url = Url::getCurrentUrl();
								} else if (in_array('referer', $parameter)) {
									$url = new Url($_SERVER['HTTP_REFERER']);
								} else {
									throw new Exception("no address keyword has been given (like 'current' or 'referer')");
								}
								$full = false;
								if (in_array('full', $parameter)) {
									$full = true;
								}
								$content = $url->toString($full);
							}
						}

						return BBCodeDescriptor::contentToHTML($content);
					};
			$linkCloseTag = function($tag, $parameter, $content) {
						return "</a>";
					};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("url", $linkOpenTag, $linkCloseTag, $linkContent));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("urlk", $linkOpenTag, $linkCloseTag, $linkContent));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("ext", $linkOpenTag, $linkCloseTag, $linkContent));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("mail", $linkOpenTag, $linkCloseTag, $linkContent));

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
			$releaseContent = function($tag, $parameter, $content) {
						if (empty($content)) {
							$parameter = preg_split('#\\|#', $parameter);
							if ($parameter[1] === '*') {
								$parameter[1] = Release::getAllReleasesIDForProject($parameter[0]);
							} else {
								$parameter[1] = Format::trimAndCleanArray(preg_split('#,#', $parameter[1]));
							}

							$projectName = Project::getProject($parameter[0])->getName();

							$numbers = array();
							$others = array();
							foreach ($parameter[1] as $key => $id) {
								if (preg_match("#^ep\\d+$#", $id)) {
									$numbers[] = substr($id, 2);
								} else {
									$others[] = $id;
								}
							}
							sort($numbers);

							if (!empty($numbers)) {
								$ref = 0;
								$last = $numbers[0];
								for ($i = 1; $i < count($numbers); $i++) {
									$current = $numbers[$i];
									if ($current == $last + 1) {
										$numbers[$i] = null;
									} else {
										if ($numbers[$ref] != $last) {
											$numbers[$ref] .= "-" . $last;
										}
										$ref = $i;
									}
									$last = $current;
								}
								if ($numbers[$ref] != $last) {
									$numbers[$ref] .= "-" . $last;
								}
								$numbers = array_filter($numbers);
								$list = implode(", ", $numbers) . ", ";
							}

							foreach ($others as $id) {
								$list = Release::getRelease($parameter[0], $id)->getName() . ", ";
							}
							$list = substr($list, 0, strlen($list) - 2);

							return $projectName . " " . $list;
						} else {
							return BBCodeDescriptor::contentToHTML($content);
						}
					};
			$partnerOpenTag = function($tag, $parameter, $content) {
						if (empty($parameter)) {
							$parameter = $content;
							$content = null;
						}
						$parameter = preg_split('#\\|#', $parameter);
						$partner = null;
						$useImage = false;
						foreach ($parameter as $param) {
							try {
								$partner = Partner::getPartner($param);
							} catch (Exception $e) {
								if ($param === 'image') {
									$useImage = true;
								}
							}
						}
						if ($partner === null) {
							$partner = Partner::getPartner($content);
							$content = null;
						}
						$link = new PartnerLink($partner, BBCodeDescriptor::contentToHTML($content));
						$link->openNewWindow(true);
						if ($useImage) {
							$link->setUseImage(true);
						}
						return $link->getOpenTag();
					};
			$partnerContent = function($tag, $parameter, $content) {
						if (empty($parameter)) {
							$parameter = $content;
							$content = null;
						}
						$parameter = preg_split('#\\|#', $parameter);
						$partner = null;
						$useImage = false;
						foreach ($parameter as $param) {
							try {
								$partner = Partner::getPartner($param);
							} catch (Exception $e) {
								if ($param === 'image') {
									$useImage = true;
								}
							}
						}
						if ($partner === null) {
							$partner = Partner::getPartner($content);
							$content = null;
						}
						$link = new PartnerLink($partner, BBCodeDescriptor::contentToHTML($content));
						$link->openNewWindow(true);
						if ($useImage) {
							$link->setUseImage(true);
						}
						return $link->getHTMLContent();
					};
			$projectOpenTag = function($tag, $parameter, $content) {
						if (empty($parameter)) {
							$link = new ProjectLink(Project::getProject($content));
						} else {
							$parameter = preg_split('#\\|#', $parameter);
							try {
								$link = new ProjectLink(Project::getProject($parameter[0]));
							} catch (Exception $e) {
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
							} catch (Exception $e) {
								$link = new ProjectLink(Project::getProject($content));
							}

							if (in_array('image', $parameter)) {
								$link->useImage(true);
							}
						}
						return $link->getHTMLContent();
					};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("release", $releaseOpenTag, $linkCloseTag, $releaseContent));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("project", $projectOpenTag, $linkCloseTag, $projectContent));
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("partner", $partnerOpenTag, $linkCloseTag, $partnerContent));

			/**********************************\
			             SPOILER
			\**********************************/
			$spoilerOpenTag = function($tag, $parameter, $content) {
						static $id = 0;
						$id++;
						$index = 0;
						while (empty($parameter)) {
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
						return "<a href=\"#\" onclick=\"show('spoiler$id');return(false)\">$parameter</a><object id=\"spoiler$id\" style=\"display: none;\">";
					};
			$spoilerContent = function($tag, $parameter, $content) {
						$index = 0;
						while (empty($parameter)) {
							$parameter = $content[$index];
							if (is_string($parameter)) {
								$parameter = trim($parameter);
							}
							$index++;
						}
						if ($index > 0) {
							unset($content[$index - 1]);
						}
						return BBCodeDescriptor::defaultContentCallback($tag, $parameter, $content);
					};
			$spoilerCloseTag = function($tag, $parameter, $content) {
						return '</object>';
					};
			Format::$BBCodeParser->addDescriptor(new BBCodeDescriptor("spoiler", $spoilerOpenTag, $spoilerCloseTag, $spoilerContent));

			/**********************************\
			              VIDEOS
			\**********************************/

			function parseVideoParameter($parameter) {
				$parameter = preg_split('#\\|#', $parameter);
				$result = array();
				foreach ($parameter as $row) {
					$row = preg_split('#:#', $row);
					if (in_array($row[0], array('width', 'height'))) {
						$result[$row[0]] = $row[1];
					} else {
						throw new Exception($row[0] . " is not managed");
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