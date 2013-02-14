<?php
abstract class AbstractPersistentFieldTranslator implements IPersistentFieldTranslator {
	public function getPersistentValue(PersistentField $field) {
		return $this->translateToPersistentValue($field->get());
	}
	
	public function setPersistentValue(PersistentField $field, $value) {
		$field->set($this->translateFromPersistentValue($value));
	}
}
?>