<?php
/*
	An auto-float image is an image placing automatically on the right if its height is bigger than
	its width.
*/

class AutoFloatImage extends Image {
	
	public function __construct($source = '', $title = '') {
		parent::__construct($source, $title);
		$description = getimagesize($source);
		if ($description[0] < $description[1]) {
			$this->setStyle("float : right;");
		}
	}
}
?>
