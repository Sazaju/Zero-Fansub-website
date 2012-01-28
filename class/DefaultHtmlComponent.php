<?php
/*
	This is the default implementation of a HTML component. It gives the basic
	setters/getters for the basic options (ID, class, style, ...).
*/

abstract class DefaultHtmlComponent implements IHtmlComponent {
	private $id = '';
	private $clazz = '';
	private $style = '';
	private $subcomponents = array();
	private $html = '';
	private $isContentPinned = false;
	
	public function setContentPinned($boolean) {
		$this->isContentPinned = $boolean;
	}
	
	public function isContentPinned() {
		return $this->isContentPinned;
	}
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function setClass($class) {
		$this->clazz = $class;
	}
	
	public function getClass() {
		return $this->clazz;
	}
	
	public function setStyle($style) {
		$this->style = $style;
	}
	
	public function getStyle() {
		return $this->style;
	}
	
	public function setContent($content) {
		$this->clear();
		$this->addComponent($content);
	}
	
	public function getCurrentContent() {
		$this->generateHtml();
		return $this->getHtml();
	}
	
	public function addComponent($component) {
		if ($component !== null) {
			$this->subcomponents[] = $component;
		}
	}
	
	public function addComponents($array) {
		if ($array !== null) {
			foreach($array as $component) {
				$this->addComponent($component);
			}
		}
	}
	
	public function getComponents() {
		return $this->subcomponents;
	}
	
	public function getComponent($index) {
		return $this->subcomponents[$index];
	}
	
	public function isEmpty() {
		return empty($this->subcomponents);
	}
	
	public function clear() {
		$this->subcomponents = array();
	}
	
	public function getOptions() {
		$id = $this->getID();
		$class = $this->getClass();
		$style = $this->getStyle();
		
		$idPart = !empty($id) ? ' id="'.$id.'"' : '';
		$classPart = !empty($class) ? ' class="'.$class.'"' : '';
		$stylePart = !empty($style) ? ' style="'.$style.'"' : '';
		
		return $idPart.$classPart.$stylePart;
	}
	
	public function generateHtml() {
		$content = '';
		foreach($this->subcomponents as $component) {
			if (is_string($component)) {
				$content .= $component;
			}
			else if (is_numeric($component)) {
				$content .= $component;
			}
			else if ($component instanceof IHtmlComponent) {
				if ($component instanceof IPersistentComponent) {
					if (!$component->isLoaded()) {
						$component->load();
					}
				}
				
				$component->generateHtml();
				$content .= $component->getHtml();
			}
			else {
				throw new Exception("Cannot take the component ".$component);
			}
		}
		
		if ($this->isContentPinned) {
			$pin = new Pin();
			$content .= $pin->getCurrentContent();
		}
		
		$this->html = $this->getOpenTag().$content.$this->getCloseTag();
		$this->html = str_replace("\n", '<br/>', $this->html); // TODO extract at a higher level
		$this->html = Format::parseBBCode($this->html); // TODO extract at a higher level
	}
	
	public function getOpenTag() {
		return '<'.$this->getHtmlTag().$this->getOptions().'>';
	}
	
	public function getCloseTag() {
		return '</'.$this->getHtmlTag().'>';
	}
	
	public function getHtml() {
		return $this->html;
	}
	
	public function writeNow() {
		$html = $this->getCurrentContent();
		//$html = Format::indentHtml($html);
		echo $html;
	}
}
?>
