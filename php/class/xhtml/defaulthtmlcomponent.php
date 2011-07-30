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
	private $content = '';
	private $html = '';
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
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
	
	public function setContent($code) {
		$this->content = $code;
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function addComponent($component) {
		$this->subcomponents[] = $component;
	}
	
	public function getComponents() {
		return $this->subcomponents;
	}
	
	public function getOptions() {
		$id = $this->getId();
		$class = $this->getClass();
		$style = $this->getStyle();
		
		$idPart = !empty($id) ? ' id="'.$id.'"' : '';
		$classPart = !empty($class) ? ' class="'.$class.'"' : '';
		$stylePart = !empty($style) ? ' style="'.$style.'"' : '';
		
		return $idPart.$classPart.$stylePart;
	}
	
	public function generateHtml() {
		$content = $this->getContent();
		foreach($this->subcomponents as $component) {
			if ($component instanceof IPersistentComponent) {
				if (!$component->isLoaded()) {
					$component->load();
				}
				$component = $component->getHtmlComponent();
			}
			if (!($component instanceof IHtmlComponent)) {
				throw new Exception(get_class($component).' is not a HTML component');
			}
	
			$component->generateHtml();
			$content .= $component->getHtml();
		}
		
		$this->html = '<'.$this->getHtmlTag().$this->getOptions().'>'.$content.'</'.$this->getHtmlTag().'>';
	}
	
	public function getHtml() {
		return $this->html;
	}
}
?>
