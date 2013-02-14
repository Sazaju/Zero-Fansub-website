<?php
/*
	A form is a set of modifiable entries.
*/

class FormComponent extends DefaultHtmlComponent {
	const GET = "get";
	const POST = "post";
	
	public function __construct($action = '#', $method = FormComponent::POST) {
		$this->setAction($action);
		$this->setMethod($method);
	}
	
	public function setAction($url) {
		$this->setMetadata('action', $url);
	}
	
	public function setMethod($method) {
		if (in_array($method, array(FormComponent::GET, FormComponent::POST))) {
			$this->setMetadata('method', $method);
		} else {
			throw new Exception("The method should be ".FormComponent::GET." or ".FormComponent::POST);
		}
	}
	
	public function addInput($label, $value = null, $type = 'text') {
		$id = preg_replace("#[^a-zA-Z0-9]+#", "_", $label);
		$this->addComponent('<label for="'.$id.'">'.$label.': </label>');
		$this->addComponent('<input type="'.$type.'" id="'.$id.'" value="'.$value.'"/>');
		$this->addComponent('<br/>');
	}
	
	public function getHtmlTag() {
		return 'form';
	}
	
	public function isAutoClose() {
		return false;
	}
}
?>