<?php
/*
	A simple block is a simple container for other components (div tag).
*/

require_once('defaultblockcomponent.php');

class SimpleBlockComponent extends DefaultBlockComponent {
	private $innerHtml = '';
	private $subcomponents = array();
	
	public function addComponent(IHtmlComponent $component) {
		$this->subcomponents[] = $component;
	}
	
	public function getComponents() {
		return $this->subcomponents;
	}
	
	public function generateInnerHtml() {
		$content = '';
		foreach($this->subcomponents as $component) {
			$component->generateHtml();
			$content .= $component->getHtml();
		}
		$this->innerHtml = $content;
	}
	
	public function getInnerHtml() {
		return $this->innerHtml;
	}
}
?>
