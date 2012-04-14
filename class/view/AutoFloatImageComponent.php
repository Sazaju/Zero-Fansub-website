<?php
/*
	An auto-float image is an image placing automatically on the right/left if its height is bigger than
	its width.
*/

class AutoFloatImageComponent extends ImageComponent {
	
	public function __construct($source = '', $title = '', $onRight = true) {
		parent::__construct($source, $title);
		$source = Url::completeUrl($source);
		try {
			$description = getimagesize($source);
			if ($description[0] < $description[1]) {
				if ($onRight) {
					$this->makeRightFloating();
				} else {
					$this->makeLeftFloating();
				}
			}
		} catch(Exception $e) {
			// let as is, because we do not know
		}
	}
	
	public function removeFloating() {
			$this->setStyle(null);
	}
}
?>