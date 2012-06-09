<?php
final class DefaultPersistentFieldTranslator implements IPersistentFieldTranslator {
	public function getPersistentValue($value) {
		if (is_array($value)) {
			throw new Exception("Array management is not implemented yet.");
		} else if (is_resource($value)) {
			throw new Exception("Resource management is not implemented yet.");
		} else if ($value instanceof PersistentComponent) {
			return $value->getInternalKey();
		} else if (is_object($value)) {
			throw new Exception("You have to use a specific translator for ".get_class($value)." objects.");
		} else {
			return $value;
		}
	}
	
	public function setPersistentValue(PersistentField $field, $value) {
		if ($field->isCustomized()) {
			$reflector = new ReflectionClass($field->getType());
			if ($reflector->isSubclassOf('PersistentComponent')) {
				$component = $reflector->newInstance();
				$component->setInternalKey($value);
				$component->load();
			} else {
				throw new Exception("You have to use a specific translator for ".$field->getType()." objects.");
			}
		} else {
			if ($field->isArray()) {
				throw new Exception("Array management is not implemented yet.");
			} else if ($field->isResource()) {
				throw new Exception("Resource management is not implemented yet.");
			} else {
				settype($value, $field->getType());
				$field->set($value);
			}
		}
	}
	
	public function getPersistentTable(PersistentField $field) {
		if ($field->isBoolean()) {
			return PersistentTable::defaultBooleanTable();
		} else if ($field->isInteger()) {
			return PersistentTable::defaultIntegerTable();
		} else if ($field->isDouble()) {
			return PersistentTable::defaultDoubleTable();
		} else if ($field->isString()) {
			return PersistentTable::defaultStringTable($field->getLength());
		} else if ($field->isArray()) {
			throw new Exception("Array management is not implemented yet.");
		} else if ($field->isResource()) {
			throw new Exception("Resource management is not implemented yet.");
		} else if ($field->isCustomized()) {
			if ($field->get() instanceof PersistentComponent) {
				return PersistentTable::defaultIntegerTable();
			} else {
				throw new Exception("You have to use a specific translator for ".$field->getType()." objects.");
			}
		}
	}
}
?> 
