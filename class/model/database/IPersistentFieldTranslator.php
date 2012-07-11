<?php
interface IPersistentFieldTranslator {
	public function setPersistentValue(PersistentField $field, $value);
	public function getPersistentValue(PersistentField $field);
	public function getPersistentType(PersistentField $field);
}
?>