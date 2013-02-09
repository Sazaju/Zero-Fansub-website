<?php
class MissingFieldsException extends DifferentStructureException {
	public function __construct($fields) {
		parent::__construct(is_array($fields)
			? "Some fields are missing in the object: ".Format::arrayToString($fields)."."
			: "The field '$fields' is missing in the object."
		);
	}
}
?>