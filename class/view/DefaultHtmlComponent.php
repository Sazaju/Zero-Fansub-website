<?php
/*
	This is the default implementation of a HTML component. It gives the basic
	setters/getters for the basic options (ID, class, style, ...).
*/

abstract class DefaultHtmlComponent implements IHtmlComponent {
	private $metadata = array();
	private $subcomponents = array();
	private $html = '';
	private $isContentPinned = false;
	private $legend = null;
	
	public function setLegend($legend) {
		$this->legend = $legend;
	}
	
	public function getLegend() {
		return $this->legend;
	}
	
	public function hasLegend() {
		return $this->legend !== null;
	}
	
	public function setContentPinned($boolean) {
		$this->isContentPinned = $boolean;
	}
	
	public function isContentPinned() {
		return $this->isContentPinned;
	}
	
	public function setID($id) {
		$this->setMetaData('id', $id);
	}
	
	public function getID() {
		return $this->getMetaData('id');
	}
	
	public function setClass($class) {
		$this->setMetaData('class', $class);
	}
	
	public function getClass() {
		return $this->getMetaData('class');
	}
	
	public function setStyle($style) {
		$this->setMetaData('style', $style);
	}
	
	public function getStyle() {
		return $this->getMetaData('style');
	}
	
	public function setContent($content) {
		$this->clear();
		$this->addComponent($content);
	}
	
	public function getCurrentHTML() {
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
	
	public function setComponent($index, $component) {
		$this->subcomponents[$index] = $component;
	}
	
	public function isEmpty() {
		return empty($this->subcomponents);
	}
	
	public function clear() {
		$this->subcomponents = array();
	}
	
	public function getMetadataString() {
		$meta = array();
		foreach($this->metadata as $id => $value) {
			$meta[] = $id.($value == null ? '' : '="'.$value.'"');
		}
		$meta = array_filter($meta);
		return Format::arrayToString($meta, ' ');
	}
	
	public function setMetaData($id, $value = null) {
		$this->metadata[$id] = $value;
	}
	
	public function getMetaData($id) {
		return $this->metadata[$id];
	}
	
	public function removeMetaData($id) {
		unset($this->metadata[$id]);
	}
	
	public function getHTMLContent() {
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
			$content .= $pin->getCurrentHTML();
		}
		
		return $content;
	}
	
	public function generateHtml() {
		$this->html = $this->getOpenTag().$this->getHTMLContent().$this->getCloseTag();
	}
	
	public function getOpenTag() {
		$meta = $this->getMetadataString();
		$meta = empty($meta) ? '' : ' '.$meta;
		if ($this->hasLegend()) {
			return '<fieldset'.$meta.'><legend>'.$this->getLegend().'</legend>';
		} else {
			return '<'.$this->getHtmlTag().$meta.($this->isAutoClose() ? '/' : '').'>';
		}
	}
	
	public function getCloseTag() {
		if ($this->hasLegend()) {
			return '</fieldset>';
		} else {
			return $this->isAutoClose() ? '' : '</'.$this->getHtmlTag().'>';
		}
	}
	
	public function getHtml() {
		return $this->html;
	}
}
?>