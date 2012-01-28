<?php
require_once("StringExploder.php");
class BBCodeParser {
	private $descriptors = array();
	
	public function addDescriptor(BBCodeDescriptor $descriptor) {
		if (empty($descriptor)) {
			throw new Exception("Cannot take an empty descriptor.");
		} else {
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
			$exploder->addDescriptor(new StringExploderDescriptor("#\\[$closeTag\\]#", $closeTag));
			$flagMap[$openTag] = $closeTag;
			$descriptorMap[$openTag] = $descriptor;
		}
		$array = $exploder->parse($string);
		
		while(count($array) > 1) {
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
			
			if ($closeIndex === -1) {
				if ($openIndex === -1) {
					break; // no more tag can be computed
				} else {
					$tag = $array[$openIndex][0];
					throw new Exception("Alone opening tag '$tag' at $openIndex");
				}
			} else if ($openIndex === -1) {
				$tag = $array[$closeIndex][0];
				throw new Exception("Alone closing tag '$tag' at $closeIndex");
			} else {
				// normal case, continue the process;
			}
			
			$openTag = $array[$openIndex][0];
			$openFlag = $array[$openIndex][1];
			$descriptor = $descriptorMap[$openFlag];
			unset($array[$openIndex]);
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
				
				$descriptor = new BBCodeDescriptor($descriptor->getTag(), $descriptor->getOpenTagCallback(), $descriptor->getCloseTagCallback(), $descriptor->getContentCallback());
				$descriptor->setContent($content);
				$parts = preg_split('#=#', substr($openTag, 1, strlen($openTag)-2), 2, PREG_SPLIT_NO_EMPTY);
				if (count($parts) > 1) {
					$descriptor->setParameter($parts[1]);
				}
				$array[$openIndex] = $descriptor;
			}
			ksort($array);
		}
		
		$root = new BBCodeDescriptor(null, null, null);
		$root->setContent($array);
		
		return $root->generateHTML();
	}
}

class BBCodeDescriptor {
	private $tag = null;
	private $content = null;
	private $parameter = null;
	private $openTagCallback = null;
	private $closeTagCallback = null;
	private $contentCallback = null;
	
	public function __construct($tag, $openTagCallback, $closeTagCallback, $contentCallback = array('BBCodeDescriptor', 'defaultContentCallback')) {
		$this->tag = $tag;
		$this->openTagCallback = $openTagCallback;
		$this->closeTagCallback = $closeTagCallback;
		$this->contentCallback = $contentCallback;
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
			return call_user_func($this->openTagCallback, $this->getTag(), $this->getParameter(), $this->getContentString());
		}
	}
	
	public function generateHTMLCloseTag() {
		if ($this->closeTagCallback === null) {
			return '';
		} else {
			return call_user_func($this->closeTagCallback, $this->getTag(), $this->getParameter(), $this->getContentString());
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
		$html .= $this->generateHTMLCloseTag();
		return $html;
	}
	
	public function getContentString() {
		$contentArray = $this->content;
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
	
	public function toString() {
		$content = $this->getContentString();
		
		$openTag = $this->tag;
		if ($this->parameter !== null) {
			$openTag .= '='.$this->parameter;
		}
		
		$closeTag = '/'.$this->tag;
		return '['.$openTag.']'.$content.'['.$closeTag.']';
	}
	
	public static function defaultContentCallback($tag, $parameter, $content) {
		$html = "";
		foreach($content as $row) {
			if ($row instanceof BBCodeDescriptor) {
				$html .= $row->generateHTML();
			} else {
				$html .= $row;
			}
		}
		return $html;
	}
}
?>