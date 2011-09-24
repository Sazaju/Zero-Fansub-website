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
		$this->title = new SimpleTextComponent();
		$this->date = new SimpleTextComponent();
		$this->author = new SimpleTextComponent();
		$this->message = new SimpleTextComponent();
		$this->commentUrl = new Link();
		$this->commentAddUrl = new Link();
		$this->twitterUrl = new Link();
		
		$newsFooter = new SimpleTextComponent();
		$newsFooter->addComponent("~ ");
		$this->commentUrl->setContent("Commentaires");
		$this->commentUrl->openNewWindow(true);
		$newsFooter->addComponent($this->commentUrl);
		$newsFooter->addComponent(" - ");
		$this->commentAddUrl->setContent("Ajouter un commentaire");
		$this->commentAddUrl->openNewWindow(true);
		$newsFooter->addComponent($this->commentAddUrl);
		$newsFooter->addComponent(" ~");
		$newsFooter->addLine();
		$newsFooter->addComponent("~ ");
		$this->twitterUrl->setContent("Partager sur <img src='images/autre/logo_twitter.png' border='0' alt='twitter' />");
		$this->twitterUrl->openNewWindow(true);
		$this->twitterUrl->setOnClick("javascript:pageTracker._trackPageview ('/outbound/twitter.com');");
		$newsFooter->addComponent($this->twitterUrl);
		$newsFooter->addComponent(" ou ");
		$newsFooter->addComponent("<a name='fb_share' type='button' share_url='http://zerofansub.net'></a>");
		$newsFooter->addComponent("<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>");
		$newsFooter->addComponent(" ~");
		$newsFooter->addLine();
		
		$newsContent = new SimpleBlockComponent();
		$newsContent->setClass("p");
		$newsContent->addComponent($this->message);
		$newsContent->addComponent($newsFooter);
		
		$this->addComponent("<h2>");
		$this->addComponent($this->title);
		$this->addComponent("</h2>");
		$this->addComponent("<h4>");
		$this->addComponent($this->date);
		$this->addComponent(" par ");
		$this->addComponent($this->author);
		$this->addComponent("</h4>");
		$this->addComponent($newsContent);
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
