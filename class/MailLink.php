<?php
/*
	A mail link is a mailto link.
*/

class MailLink extends Link {
	private $mail = '';
	
	public function __construct($mail) {
		$this->setMail($mail);
	}
	
	public function getUrl() {
		return 'mailto:'.$this->mail;
	}
	
	public function setUrl($url) {
		throw new Exception("You cannot change the URL directly, change the mail address.");
	}
	
	public function setMail($mail) {
		parent::setUrl($mail);
		parent::setContent($mail);
		$this->mail = $mail;
	}
	
	public function getMail() {
		return $this->mail;
	}
}
?>
