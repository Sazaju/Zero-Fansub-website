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
		$mandatory = $field->isMandatory();
		$input = null;
		if ($field->isBoolean()) {
			$value = $field->get();
			$input = FormInputComponent::createBooleanInput($fieldName, $value);
		} else if ($field->isInteger()) {
			$value = $field->get();
			$input = FormInputComponent::createTextInput($fieldName, $value);
		} else if ($field->isDouble()) {
			$value = $field->get();
			$input = FormInputComponent::createTextInput($fieldName, $value);
		} else if ($field->isArray()) {
			$input = $fieldName.' = Array (array not implemented yet)<br/>';
		} else if ($field->isResource()) {
			$value = $field->get();
			$input = $fieldName.' = '.get_class($value).' (resource not implemented yet)<br/>';
		} else if ($field->isString()) {
			// TODO consider length (no length => text area)
			$value = $field->get();
			if ($field->hasLength()) {
				$input = FormInputComponent::createTextInput($fieldName, $value, $field->getLength());
			} else {
				$input = FormInputComponent::createTextAreaInput($fieldName, $value);
			}
		} else if ($field->isCustomized()) {
			$translator = $field->getTranslator();
			$value = $translator->getPersistentValue($field);
			$possible = $translator->getPossiblePersistentValues($field);
			$input = FormInputComponent::createSelectInput($fieldName, $value, $possible);
			$input->setValueRenderer(function($value) use ($translator) {
				return "".$translator->translateFromPersistentValue($value);
			});
		} else {
			throw new Exception("This case should not happen.");
		}
		
		if ($input instanceof FormInputComponent) {
			$input->setMandatory($mandatory);
			$form->addInput($input);
		} else {
			// TODO this case should be removed when all the cases above will be implemented
			$form->addComponent($input);
		}
	}
	$form->addInput(FormInputComponent::createResetInput("RAZ"));
	$form->addInput(FormInputComponent::createSubmitInput("Enregistrer"));
	
	
	$page = PageContent::getInstance();
	$page->setClass('changeRecord');
	$page->addComponent(new Title("Modification Enregistrement ", 1));
	$page->addComponent(new Title($class.'('.Format::arrayWithKeysToString($keyData).')', 2));
	$page->addComponent($form);
?>