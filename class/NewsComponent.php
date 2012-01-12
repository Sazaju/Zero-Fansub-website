<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/
class NewsComponent extends SimpleBlockComponent {
	public function __construct(News $news) {
		$this->setClass("news");
		
		$this->title = new Title($news->getTitle(), 2);
		$this->title->setClass("title");
		$this->addComponent($this->title);
		
		$subtitle = new Title(null, 4);
		$subtitle->setClass("subtitle");
		$subtitle->addComponent(strftime("%d/%m/%Y", $news->getTimestamp()));
		if ($news->getAuthor() != null) {
			$subtitle->addComponent(" par ".$news->getAuthor());
		}
		$this->addComponent($subtitle);
		
		$this->message = new SimpleTextComponent($news->getMessage());
		$this->message->setClass("message");
		$this->message->setContentPinned(true);
		$this->addComponent($this->message);
		
		$commentId = $news->getCommentID();
		if ($commentId !== null) {
			$commentAccess = new SimpleTextComponent();
			$commentAccess->setClass("comment");
			$commentAccess->addComponent("~ ");
			$commentAccess->addComponent(Link::newWindowLink(new Url("http://commentaires.zerofansub.net/t".$commentId.".htm"), "Commentaires"));
			$commentAccess->addComponent(" - ");
			$commentAccess->addComponent(Link::newWindowLink(new Url("http://commentaires.zerofansub.net/posting.php?mode=reply&t=".$commentId), "Ajouter un commentaire"));
			$commentAccess->addComponent(" ~");
			$this->addComponent($commentAccess);
		}
		
		$this->addComponent("~ ");
		$twitterTitle = $news->getTwitterTitle();
		if ($twitterTitle == null) {
			$twitterTitle = "[Zero] ".$news->getTitle();
		}
		$twitterUrl = Link::newWindowLink("http://twitter.com/home?status=".$twitterTitle, "Partager sur <img src='images/autre/logo_twitter.png' border='0' alt='twitter' />");
		$twitterUrl->setOnClick("javascript:pageTracker._trackPageview ('/outbound/twitter.com');");
		$this->addComponent($twitterUrl);
		$this->addComponent(" ou ");
		$this->addComponent("<a name='fb_share' type='button' share_url='http://zerofansub.net'></a>");
		$this->addComponent("<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>");
		$this->addComponent(" ~");
	}
}
?>
