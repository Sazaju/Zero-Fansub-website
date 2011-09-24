<?php
class Check {
	public static function getInputIn($input, $setOfPossibilities, $default = null) {
		return in_array($input, $setOfPossibilities) ? $input : $default;
	}

	public static function getNumericInput($input, $default = null) {
		return is_numeric($input) ? $input : $default;
	}
}
?>