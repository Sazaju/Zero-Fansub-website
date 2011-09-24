<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/

class News extends SimpleBlockComponent {
	private $title = null;
	private $date = null;
	private $author = null;
	private $message = null;
	private $commentUrl = null;
	private $commentAddUrl = null;
	private $twitterUrl = null;
	
	public function __construct() {
		$this->setClass("news");
		
		$this->title = new Title(null, 2);
		$this->title->setClass("title");
		$this->addComponent($this->title);
		
		$subtitle = new Title(null, 4);
		$subtitle->setClass("subtitle");
		$this->date = new SimpleTextComponent();
		$subtitle->addComponent($this->date);
		$subtitle->addComponent(" par ");
		$this->author = new SimpleTextComponent();
		$subtitle->addComponent($this->author);
		$this->addComponent($subtitle);
		
		$this->message = new SimpleTextComponent();
		$this->message->setClass("message");
		$this->addComponent($this->message);
		
		$footer = new SimpleTextComponent();
		$footer->setClass("footer");
		$footer->addComponent("~ ");
		$this->commentUrl = new NewWindowLink(null, "Commentaires");
		$footer->addComponent($this->commentUrl);
		$footer->addComponent(" - ");
		$this->commentAddUrl = new NewWindowLink(null, "Ajouter un commentaire");
		$footer->addComponent($this->commentAddUrl);
		$footer->addComponent(" ~");
		$footer->addLine();
		$footer->addComponent("~ ");
		$this->twitterUrl = new NewWindowLink(null, "Partager sur <img src='images/autre/logo_twitter.png' border='0' alt='twitter' />");
		$this->twitterUrl->setOnClick("javascript:pageTracker._trackPageview ('/outbound/twitter.com');");
		$footer->addComponent($this->twitterUrl);
		$footer->addComponent(" ou ");
		$footer->addComponent("<a name='fb_share' type='button' share_url='http://zerofansub.net'></a>");
		$footer->addComponent("<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>");
		$footer->addComponent(" ~");
		$footer->addLine();
		$this->addComponent($footer);
	}
	
	public function setTitle($title) {
		$this->title->setContent($title);
	}
	
	public function getTitle() {
		return $this->title->getContent();
	}
	
	public function setDate($date) {
		$this->date->setContent($date);
	}
	
	public function getDate() {
		return $this->date->getContent();
	}
	
	public function setAuthor($author) {
		$this->author->setContent($author);
	}
	
	public function getAuthor() {
		return $this->author->getContent();
	}
	
	public function setMessage($message) {
		$this->message->clear();
		$this->message->addComponent($message);
	}
	
	public function getMessage() {
		$components = $this->message->getComponents();
		return $components[0];
	}
	
	public function setCommentID($id) {
		if ($id !== null) {
			$this->setCommentUrl("http://commentaires.zerofansub.net/t$id.htm");
			$this->setCommentAddUrl("http://commentaires.zerofansub.net/posting.php?mode=reply&t=$id");
		}
	}
	
	public function setCommentUrl($url) {
		$this->commentUrl->setUrl($url);
	}
	
	public function getCommentUrl() {
		return $this->commentUrl->getUrl();
	}
	
	public function setCommentAddUrl($url) {
		$this->commentAddUrl->setUrl($url);
	}
	
	public function getCommentAddUrl() {
		return $this->commentAddUrl->getUrl();
	}
	
	public function setTwitterUrl($url) {
		$this->twitterUrl->setUrl($url);
	}
	
	public function getTwitterUrl() {
		return $this->twitterUrl->getUrl();
	}
}
?>
