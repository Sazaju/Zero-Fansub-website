<?php
class UnkownFieldsException extends DifferentStructureException {
	public function __construct($fields) {
		parent::__construct(is_array($fields)
			? "Some fields are not known in the database: ".Format::arrayToString($fields)."."
			: "The field '$fields' is unknown in the database."
		);
	}
}
?>