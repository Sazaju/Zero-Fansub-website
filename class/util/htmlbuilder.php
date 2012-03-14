<?php
/*
	This class allows to build a XHTML page, offering basic methods to
	construct the common parts of the page (doctype, header, ...). This class
	uses a builder pattern.
*/

class HTMLBuilder {
	
	/* FIELDS */
	
	private $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	private $head = '';
	private $title = 'New page';
	private $body = '';
	private $html = '';
	private $components = array();
	private $metas = array();
	private $links = array();
	
	/* CONFIGURATION METHODS */
	
	public function addComponent(IHtmlComponent $component) {
		$this->components[] = $component;
	}
	
	public function getComponents() {
		return $this->components;
	}
	
	public function addMeta($metaData) {
		$this->metas[] = $metaData;
	}
	
	public function getMetas() {
		return $this->metas;
	}
	
	public function addLink($linkData) {
		$this->links[] = $linkData;
	}
	
	public function getLinks() {
		return $this->links;
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
	private function createAutoClosingTag($name, array $dataArray) {
		$data = '';
		foreach($dataArray as $attribute => $value) {
			$data .= $attribute.'="'.$value.'" ';
		}
		return '<'.$name.' '.$data.'/>';
	}
	
	private function generateHead() {
		$content = '';
		
		// title tag
		$content .= '<title>'.$this->title.'</title>';
		
		// meta tags
		foreach($this->metas as $metaData) {
			$content .= $this->createAutoClosingTag('meta', $metaData);
		}
		
		// link tags
		foreach($this->links as $linkData) {
			$content .= $this->createAutoClosingTag('link', $linkData);
		}
		
		// finalizing
		$this->head = '<head>'.$content.'</head>';
	}

	// TODO replace by a component
	private function generateBody() {
		$content = '';
		foreach($this->components as $component) {
			$component->generateHTML();
			$content .= $component->getHTML();
		}
		$this->body = '<body>'.$content.'</body>';
	}
	
	public function getBodyComponent() {
		return $this->body;
	}
	
	public function generateHTML() {
		$this->generateHead();
		$this->generateBody();
		
		$this->html = $this->doctype.'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">'.$this->head.$this->body.'</html>';
	}
	
	public function getHTML() {
		return $this->html;
	}
}
?>