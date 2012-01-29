<?php
class BBCodeParser {
	private $descriptors = array();
	
	public function addDescriptor(BBCodeDescriptor $descriptor) {
		if (empty($descriptor)) {
			throw new Exception("Cannot take an empty descriptor.");
		} else {
			foreach($this->descriptors as $d) {
				if (strcasecmp($d->getTag(), $descriptor->getTag()) === 0) {
					if ($descriptor === $d) {
						// this is the same, no need to add it
						return;
					} else {
						throw new Exception($d->getTag()." is already assigned to another descriptor");
					}
				}
			}
			
			$this->descriptors[] = $descriptor;
		}
	}
	
	public function translate($string) {
		$exploder = new StringExploder();
		$flagMap = array();
		$descriptorMap = array();
		foreach($this->descriptors as $descriptor) {
			$openTag = $descriptor->getTag();
			$closeTag = '/'.$openTag;
			$exploder->addDescriptor(new StringExploderDescriptor("#\\[$openTag(=[^\\]]+)?\\]#", $openTag));
			if ($descriptor->hasCloseTag()) {
				$exploder->addDescriptor(new StringExploderDescriptor("#\\[$closeTag\\]#", $closeTag));
				$flagMap[$openTag] = $closeTag;
			}
			$descriptorMap[$openTag] = $descriptor;
		}
		$array = $exploder->parse($string);
		
		while(count($array) > 1 || is_array($array[0])) {
			$closeIndex = -1;
			foreach($array as $index => $chunk) {
				if (is_array($chunk) && $chunk[1][0] === '/') {
					$closeIndex = $index;
					break;
				}
			}
			
			$openIndex = -1;
			foreach($array as $index => $chunk) {
				if (is_array($chunk) && $chunk[1][0] !== '/') {
					if ($closeIndex !== -1 && $index >= $closeIndex) {
						break;
					} else {
						$openIndex = $index;
					}
				}
			}
			
			if ($openIndex === -1) {
				if ($closeIndex === -1) {
					break; // no more tag can be computed
				} else {
					$tag = $array[$closeIndex][0];
					throw new Exception("Alone closing tag '$tag' at $closeIndex");
				}
			}
			
			$openTag = $array[$openIndex][0];
			$openFlag = $array[$openIndex][1];
			$descriptor = $descriptorMap[$openFlag];
			unset($array[$openIndex]);
			
			$extractParameter = function($openTag) {
				$parts = preg_split('#=#', substr($openTag, 1, strlen($openTag)-2), 2, PREG_SPLIT_NO_EMPTY);
				return count($parts) > 1 ? $parts[1] : null;
			};
			
			if (!$descriptor->hasCloseTag()) {
				$descriptor = new BBCodeDescriptor($descriptor->getTag(), $descriptor->getOpenTagCallback());
				$descriptor->setContent(null);
				$descriptor->setParameter($extractParameter($openTag));
				$array[$openIndex] = $descriptor;
			} else if ($closeIndex === -1) {
				throw new Exception("Alone opening tag '$openTag' at $openIndex");
			} else {
				$closeTag = $array[$closeIndex][0];
				$closeFlag = $array[$closeIndex][1];
				unset($array[$closeIndex]);
				if ($flagMap[$openFlag] !== $closeFlag) {
					$extract = substr($string, $openIndex, $closeIndex - $openIndex + strlen($closeTag));
					throw new Exception("Crossing tags for '$extract' at $openIndex");
				} else {
					$content = array();
					$contentIndex = $openIndex + strlen($openTag);
					while ($contentIndex < $closeIndex) {
						$row = $array[$contentIndex];
						unset($array[$contentIndex]);
						$content[] = $row;
						$row = $row instanceof BBCodeDescriptor ? $row->toString() : $row;
						$contentIndex += strlen($row);
					}
					if (count($content) == 1) {
						$content = $content[0];
					} else if (count($content) == 0) {
						$content = null;
					}
					
					$descriptor = new BBCodeDescriptor($descriptor->getTag(), $descriptor->getOpenTagCallback(), $descriptor->getCloseTagCallback(), $descriptor->getContentCallback());
					$descriptor->setContent($content);
					$descriptor->setParameter($extractParameter($openTag));
					$array[$openIndex] = $descriptor;
				}
			}
			ksort($array);
		}
		
		$root = new BBCodeDescriptor(null, null);
		$root->setContent($array);
		
		$html = $root->generateHTML();
		return $html;
	}
}

class BBCodeDescriptor {
	private $tag = null;
	private $content = null;
	private $parameter = null;
	private $openTagCallback = null;
	private $closeTagCallback = null;
	private $contentCallback = null;
	
	public function __construct($tag, $openTagCallback, $closeTagCallback = null, $contentCallback = array('BBCodeDescriptor', 'defaultContentCallback')) {
		$this->tag = $tag;
		$this->openTagCallback = $openTagCallback;
		$this->closeTagCallback = $closeTagCallback;
		$this->contentCallback = $contentCallback;
	}
	
	public function hasCloseTag() {
		return $this->closeTagCallback !== null;
	}
	
	public function getTag() {
		return $this->tag;
	}
	
	public function getOpenTagCallback() {
		return $this->openTagCallback;
	}
	
	public function getCloseTagCallback() {
		return $this->closeTagCallback;
	}
	
	public function getContentCallback() {
		return $this->contentCallback;
	}
	
	public function setContent($content) {
		$this->content = $content;
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function setParameter($parameter) {
		$this->parameter = $parameter;
	}
	
	public function getParameter() {
		return $this->parameter;
	}
	
	public function generateHTMLOpenTag() {
		if ($this->openTagCallback === null) {
			return '';
		} else {
			return call_user_func($this->openTagCallback, $this->getTag(), $this->getParameter(), $this->getContent());
		}
	}
	
	public function generateHTMLCloseTag() {
		if ($this->closeTagCallback === null) {
			return '';
		} else {
			return call_user_func($this->closeTagCallback, $this->getTag(), $this->getParameter(), $this->getContent());
		}
	}
	
	public function generateHTMLContent() {
		if ($this->contentCallback === null) {
			return '';
		} else {
			return call_user_func($this->contentCallback, $this->getTag(), $this->getParameter(), $this->getContent());
		}
	}
	
	public function generateHTML() {
		$html = "";
		$html .= $this->generateHTMLOpenTag();
		$html .= $this->generateHTMLContent();
		if ($this->hasCloseTag()) {
			$html .= $this->generateHTMLCloseTag();
		}
		return $html;
	}
	
	public function toString() {
		$content = BBCodeDescriptor::contentToString($this->content);
		
		$openTag = $this->tag;
		if ($this->parameter !== null) {
			$openTag .= '='.$this->parameter;
		}
		
		$closeTag = '/'.$this->tag;
		return '['.$openTag.']'.$content.'['.$closeTag.']';
	}
	
	public static function defaultContentCallback($tag, $parameter, $content) {
		$html = "";
		if (is_array($content)) {
			foreach($content as $row) {
				if ($row instanceof BBCodeDescriptor) {
					$html .= $row->generateHTML();
				} else if (is_string($row)) {
					$html .= $row;
				} else {
					throw new Exception($row." is not managed");
				}
			}
		} else if ($content instanceof BBCodeDescriptor) {
			$html .= $content->generateHTML();
		} else {
			$html .= $content;
		}
		return $html;
	}
	
	public static function contentToString($contentArray) {
		if (!is_array($contentArray)) {
			$contentArray = array($contentArray);
		}
		$content = "";
		foreach($contentArray as $c) {
			if ($c instanceof BBCodeDescriptor) {
				$content .= $c->toString();
			} else {
				$content .= $c;
			}
		}
		return $content;
	}
}
?>