<?php

function checkInput($input, $setOfPossibilities, $default = null) {
	return in_array($input, $setOfPossibilities) ? $input : $default;
}

?>