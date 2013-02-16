<?php
/*
	An image is a simple picture which can have some attributes.
*/

class Image extends DefaultHtmlComponent {
	
	public function __construct($source = '', $title = '') {
		$this->setUrl($source);
		$this->setTitle($title);
		$this->setAlternative($title);
	}
	
	public function getHtmlTag() {
		return 'img';
	}
	
	public function isAutoClose() {
		return true;
	}
	
	public function setUrl($url) {
		if ($url == null) {
			$this->removeMetadata('src');
		} else {
			$url = new Url($url);
			$this->setMetadata('src', $url->toString());
		}
	}
	
	public function getUrl() {
		return $this->getMetadata('src');
	}
	
	public function setTitle($title) {
		$this->setMetadata('title', $title, true);
	}
	
	public function getTitle() {
		return $this->getMetadata('title');
	}
	
	public function setAlternative($alt) {
		$this->setMetadata('alt', $alt, true);
	}
	
	public function getAlternative() {
		return $this->getMetadata('alt');
	}
	
	public function makeRightFloating() {
		// TODO play with the class instead of the style
		$this->setStyle("float: right; margin-left: 1em;");
	}
	
	public function makeLeftFloating() {
		// TODO play with the class instead of the style
		$this->setStyle("float: left; margin-right: 1em;");
	}
	
	public function removeFloating() {
		// TODO play with the class instead of the style
		$this->setStyle(null);
	}
	
	public static function createAutoFloatImage($source = '', $title = '', $onRight = true) {
		$image = new Image($source, $title);
		$source = Url::completeUrl($source);
		try {
			$description = getimagesize($source);
			if ($description[0] < $description[1]) {
				if ($onRight) {
					$image->makeRightFloating();
				} else {
					$image->makeLeftFloating();
				}
			}
		} catch(Exception $e) {
			// let as is, because we do not know
		}
		return $image;
	}
}
?>