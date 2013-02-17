<?php
class NotManagedModeException extends Exception {
	public function __construct($mode) {
		parent::__construct("Not in a managed mode ($mode).");
	}
}
?>