<?php
interface IPersistentFieldTranslator {
	public function setPersistentValue(PersistentField $field, $value);
	public function getPersistentValue($value);
	public function getPersistentTable(PersistentField $field);
}
?>