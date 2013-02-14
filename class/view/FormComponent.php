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
	
	public function addInput(FormInputComponent $component) {
		$this->addComponent($component);
	}
	
	public function getHtmlTag() {
		return 'form';
	}
	
	public function isAutoClose() {
		return false;
	}
}

class FormInputComponent extends defaultHtmlComponent {
	private $label = null;
	private $value = null;
	private $labelComponent = null;
	private $valueComponent = null;
	private $commentComponent = null;
	private $mandatory = false;
	private $maxLength = null;
	
	// make it private to force the use of static methods
	private function __construct($type, $possibleValues = null, $valueCallback = null) {
		$this->labelComponent = new FormLabelComponent();
		$this->labelComponent->setClass('label');
		$this->valueComponent = new FormValueComponent($type, $possibleValues);
		$this->valueComponent->setClass('input');
		$this->commentComponent = new SimpleTextComponent();
		if ($valueCallback != null) {
			$this->valueComponent->setValueUpdater($valueCallback);
		} else {
			// keep the default callback
		}
		if ($type == 'checkbox') {
			$this->addComponent($this->valueComponent);
			$this->addComponent($this->labelComponent);
			$this->addComponent($this->commentComponent);
		} else if ($type == 'textarea') {
			$this->addComponent($this->labelComponent);
			$this->addComponent($this->commentComponent);
			$this->addComponent($this->valueComponent);
		} else {
			$this->addComponent($this->labelComponent);
			$this->addComponent($this->valueComponent);
			$this->addComponent($this->commentComponent);
		}
		$this->update();
	}
	
	public function setValueRenderer($renderer) {
		$this->valueComponent->setRenderer($renderer);
	}
	
	public function getHtmlTag() {
		return 'span';
	}
	
	public function isAutoClose() {
		return false;
	}
	
	private function getLabelId() {
		$id = preg_replace("#[^a-zA-Z0-9]+#", " ", $this->label);
		$id = trim($id);
		return str_replace(" ", "_", $id);
	}
	
	public function setLabel($label) {
		$this->label = $label;
		$this->update();
	}
	
	private function update() {
		$decoratedLabel = $this->label;
		if (in_array($this->valueComponent->getType(), array('checkbox', 'submit', 'reset'))) {
			// keep it as is
		} else {
			$decoratedLabel .= ': ';
		}
		$this->labelComponent->setContent($decoratedLabel);
		$this->labelComponent->setMetadata('for', $this->getLabelId());
		
		$this->valueComponent->setValue($this->value);
		$this->valueComponent->setMetadata('id', $this->getLabelId());
		
		$limit = $this->getMaxLength();
		if ($limit) {
			$this->valueComponent->setMetadata('maxlength', $limit);
			$this->commentComponent->setContent("(limite: $limit)");
		} else {
			$this->valueComponent->removeMetadata('maxlength');
			$this->commentComponent->setContent('');
		}
		
		$this->setClass('fullInput'.($this->isMandatory() ? ' mandatory' : ''));
	}
	
	public function getLabel() {
		return $this->label;
	}
	
	public function hasLabel() {
		return !empty($this->label);
	}
	
	public function setValue($value) {
		$this->value = $value;
		$this->update();
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function setMandatory($boolean) {
		$this->mandatory = $boolean;
		$this->update();
	}
	
	public function isMandatory() {
		return $this->mandatory;
	}
	
	public function setMaxLength($maxLength) {
		$this->maxLength = $maxLength;
	}
	
	public function getMaxLength() {
		return $this->maxLength;
	}
	
	public static function createBooleanInput($label = null, $value = false) {
		$input = new FormInputComponent('checkbox');
		$input->setLabel($label);
		$input->setValue($value);
		return $input;
	}
	
	public static function createTextInput($label = null, $value = null, $maxLength = null) {
		$input = new FormInputComponent('text');
		$input->setLabel($label);
		$input->setValue($value);
		$input->setMaxLength($maxLength);
		return $input;
	}
	
	public static function createTextAreaInput($label = null, $value = null) {
		$input = new FormInputComponent('textarea');
		$input->setLabel($label);
		$input->setValue($value);
		return $input;
	}
	
	public static function createSelectInput($label = null, $value = null, $list = array()) {
		$input = new FormInputComponent('select', $list);
		$input->setLabel($label);
		$input->setValue($value);
		return $input;
	}
	
	public static function createSubmitInput($text = null) {
		$input = new FormInputComponent('submit');
		$input->setValue($text);
		return $input;
	}
	
	public static function createResetInput($text = null) {
		$input = new FormInputComponent('reset');
		$input->setValue($text);
		return $input;
	}
}

class FormLabelComponent extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'label';
	}
	
	public function isAutoClose() {
		return false;
	}
}

class FormValueComponent extends DefaultHtmlComponent {
	private $tag = 'input';
	private $type = null;
	private $valueCallback = null;
	private $renderer = null;
	
	public function __construct($type, $possibleValues = null) {
		$this->type = $type;
		$this->renderer = function($value) {return $value;};
		if ($type == 'checkbox') {
			$this->tag = 'input';
			$this->setMetadata('type', 'checkbox');
			$this->setValueUpdater(function($comp, $val) {
				$comp->setMetadata('checked', $val ? 'checked' : '');
			});
		} else if ($type == 'text') {
			$this->tag = 'input';
			$this->setMetadata('type', 'text');
			$this->setValueUpdater(function($comp, $val) {
				$comp->setMetadata('value', $val);
			});
		} else if ($type == 'submit') {
			$this->tag = 'input';
			$this->setMetadata('type', 'submit');
			$this->setValueUpdater(function($comp, $val) {
				$comp->setMetadata('value', $val);
			});
		} else if ($type == 'reset') {
			$this->tag = 'input';
			$this->setMetadata('type', 'reset');
			$this->setValueUpdater(function($comp, $val) {
				$comp->setMetadata('value', $val);
			});
		} else if ($type == 'textarea') {
			$this->tag = 'textarea';
			$this->setValueUpdater(function($comp, $val) {
				$comp->setContent($val);
			});
		} else if ($type == 'select') {
			$this->tag = 'select';
			$this->setValueUpdater(function($comp, $val) use ($possibleValues) {
				$list = array();
				foreach($possibleValues as $value) {
					$list[$value] = $comp->render($value);
				}
				natcasesort($list);
				
				$comp->clear();
				foreach($list as $id => $display) {
					$opt = '';
					$opt .= ' id="'.$id.'"';
					$opt .= $val == $id ? ' selected="selected"' : '';
					$comp->addComponent("<option$opt>$display</option>");
				}
			});
		} else {
			throw new Exception("$type is not managed.");
		}
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getHtmlTag() {
		return $this->tag;
	}
	
	public function isAutoClose() {
		return false;
	}
	
	public function setValueUpdater($callback) {
		$this->valueCallback = $callback;
	}
	
	public function setRenderer($callback) {
		$this->renderer = $callback;
	}
	
	public function getRenderer() {
		return $this->renderer;
	}
	
	public function render($value) {
		return call_user_func($this->renderer, $value);
	}
	
	public function setValue($value) {
		call_user_func($this->valueCallback, $this, $value);
	}
}
?>