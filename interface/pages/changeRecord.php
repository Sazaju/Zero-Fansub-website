<?php
	$db = Database::getDefaultDatabase();
	$url = Url::getCurrentUrl();
	$class = $url->getQueryVar('class');
	$table = new Table();
	
	$keyData = array();
	$keys = $db->getKeys($class);
	$key = $keys[0];
	foreach($key as $field) {
		if ($url->hasQueryVar('key_'.$field)) {
			$keyData[$field] = $url->getQueryVar('key_'.$field);
		} else {
			throw new Exception("Incomplete key: the field '".$field."' is not provided");
		}
	}
	
	$component = $db->loadFromData($class, $keyData);
	$fields = $component->getPersistentFields();
	$form = new FormComponent();
	foreach($fields as $fieldName => $field) {
		// TODO consider type of data to constraint the inputs
		$fieldName .= $field->isMandatory() ? '*' : '';
		$value = $field->get();
		if ($field->isBoolean()) {
			$form->addInput($fieldName, $value);
		} else if ($field->isInteger()) {
			$form->addInput($fieldName, $value);
		} else if ($field->isDouble()) {
			$form->addInput($fieldName, $value);
		} else if ($field->isArray()) {
			$form->addComponent($fieldName.' = '.print_r($value, true).'<br/>');
		} else if ($field->isResource()) {
			$form->addComponent($fieldName.' = '.get_class($value).'<br/>');
		} else if ($field->isString()) {
			// TODO consider length (no length => text area)
			$form->addInput($fieldName, $value);
		} else if ($field->isCustomized()) {
			$form->addComponent($fieldName.' = '.get_class($value).'<br/>');
		} else {
			throw new Exception("This case should not happen.");
		}
	}
	
	
	$page = PageContent::getInstance();
	$page->setClass('changeRecord');
	$page->addComponent(new Title("Modification Enregistrement ", 1));
	$page->addComponent(new Title($class.'('.Format::arrayWithKeysToString($keyData).')', 2));
	$page->addComponent($form);
?>