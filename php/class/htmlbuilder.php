<?php
/*
	This class allows to build a XHTML page, offering basic methods to
	construct the common parts of the page (doctype, header, ...). This class
	uses a builder pattern.
*/

class HtmlBuilder {
	
	/* FIELDS */
	
	private $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	private $head = '';
	private $title = 'New page';
	private $body = '';
	private $html = '';
	private $components = array();
	
	/* CONFIGURATION METHODS */
	
	public function addComponent(IHtmlComponent $component) {
		$this->components[] = $component;
	}
	
	public function getComponents() {
		return $this->components;
	}
	
	public function setDoctype($doctype) {
		$this->doctype = $doctype;
	}
	
	public function getDoctype() {
		return $this->doctype;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	/* BUILDING METHODS */
	
	private function generateHead() {
		$content = '';
		$content .= '<title>'.$this->title.'</title>';
		/*
			we give a "text/html" content to be compatible with most of the
			explorers, it should be "application/xhtml+xml". See this link :
			
			http://www.pompage.net/traduction/declarations
		*/
		$content .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$this->head = '<head>'.$content.'</head>';
	}
	
	private function generateBody() {
		$content = '';
		foreach($this->components as $component) {
			$component->generateHtml();
			$content .= $component->getHtml();
		}
		$this->body = '<body>'.$content.'</body>';
	}
	
	public function generateHtml() {
		$this->generateHead();
		$this->generateBody();
		
		$this->html = $this->doctype.'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">'.$this->head.$this->body.'</html>';
	}
	
	public function getHtml() {
		return $this->html;
	}
}
?>