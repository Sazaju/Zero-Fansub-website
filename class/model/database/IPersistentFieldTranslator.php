<?php
interface IPersistentFieldTranslator {
	public function translateToPersistentValue($value);
	public function translateFromPersistentValue($value);
	public function setPersistentValue(PersistentField $field, $value);
	public function getPersistentValue(PersistentField $field);
	public function getPersistentType(PersistentField $field);
	public function getPossiblePersistentValues(PersistentField $field);
}
?>