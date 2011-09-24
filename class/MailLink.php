<?php
/*
	A mail link is a mailto link.
*/

class MailLink extends Link {
	public function getUrl() {
		return 'mailto:'.$this->getContent();
	}
	
	public function setUrl($url) {
		$this->setContent($url);
	}
}
?>
