<?php
/*
	A mail link is a mailto link.
*/

class MailLink extends DefaultHtmlComponent {
	private $mail = '';
	
	public function getHtmlTag() {
		return 'a';
	}
	
	public function __construct($mail) {
		$this->setMail($mail);
	}
	
	public function setMail($mail) {
		$this->mail = $mail;
		$this->setContent($mail);
	}
	
	public function getMail() {
		return $this->mail;
	}
	
	public function getOptions() {
		$mail = $this->getMail();
		$mailPart = !empty($mail) ? ' href="mailto:'.$mail.'"' : '';
		
		return parent::getOptions().$mailPart;
	}
}
?>
