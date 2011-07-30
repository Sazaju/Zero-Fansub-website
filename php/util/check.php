<?php

function checkInput($input, $setOfPossibilities, $default = null) {
	return in_array($input, $setOfPossibilities) ? $input : $default;
}

function checkNumericInput($input, $default = null) {
	return is_numeric($input) ? $input : $default;
}

?>