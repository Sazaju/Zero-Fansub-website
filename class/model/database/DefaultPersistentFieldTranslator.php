<?php
final class DefaultPersistentFieldTranslator extends AbstractPersistentFieldTranslator {
	public function translateToPersistentValue($value) {
		throw new Exception("Cannot use this function (field needed).");
	}
	
	public function translateFromPersistentValue($value) {
		throw new Exception("Cannot use this function (field needed).");
	}
	
	public function getPersistentValue(PersistentField $field) {
		$value = $field->get();
		if ($field->isBoolean()) {
			return $value;
		} else if ($field->isInteger()) {
			return $value;
		} else if ($field->isDouble()) {
			return $value;
		} else if ($field->isString()) {
			return $value;
		} else if ($field->isArray()) {
			throw new Exception("Array management is not implemented yet.");
		} else if ($field->isResource()) {
			throw new Exception("Resource management is not implemented yet.");
		} else if ($value instanceof PersistentComponent) {
			return $value->getInternalKey();
		} else {
			throw new Exception("You have to use a specific translator for ".get_class($value)." objects.");
		}
	}
	
	public function getPersistentType(PersistentField $field) {
		if ($field->isBoolean()) {
			return PersistentType::getBooleanType();
		} else if ($field->isInteger()) {
			return PersistentType::getIntegerType();
		} else if ($field->isDouble()) {
			return PersistentType::getDoubleType();
		} else if ($field->isString()) {
			return PersistentType::getStringType($field->getLength());
		} else if ($field->isArray()) {
			throw new Exception("Array management is not implemented yet.");
		} else if ($field->isResource()) {
			throw new Exception("Resource management is not implemented yet.");
		} else if ($field->get() instanceof PersistentComponent) {
			return PersistentType::getIntegerType();
		} else {
			throw new Exception("You have to use a specific translator for ".get_class($value)." objects.");
		}
	}
	
	public function setPersistentValue(PersistentField $field, $value) {
		if ($field->isCustomized()) {
			$reflector = new ReflectionClass($field->getPHPType());
			if ($reflector->isSubclassOf('PersistentComponent')) {
				$component = $reflector->newInstance();
				$component->setInternalKey($value);
				$component->load();
			} else {
				throw new Exception("You have to use a specific translator for ".$field->getPHPType()." objects.");
			}
		} else {
			if ($field->isArray()) {
				throw new Exception("Array management is not implemented yet.");
			} else if ($field->isResource()) {
				throw new Exception("Resource management is not implemented yet.");
			} else {
				if ($value !== null) {
					settype($value, $field->getPHPType());
				} else {
					// keep the null value.
				}
				$field->set($value);
			}
		}
	}
	
	public function getPossiblePersistentValues(PersistentField $field) {
		// we do not know, so we do not return anything
		return null;
	}
}
?> 
