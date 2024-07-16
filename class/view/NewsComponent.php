<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/
class NewsComponent extends ArticleComponent {
	public function __construct(News $news) {
		$this->setClass("news");
		
		$title = new Title($news->getTitle(), 2);
		$title->setClass("title");
		$newsUrl = $news->getUrl();
		$this->addComponent(new Link($newsUrl, $title));
		
		$subtitle = new Title(null, 4);
		$subtitle->setClass("subtitle");
		$time = "Préparée";
		$timestamp = $news->getPublicationTime();
		if ($timestamp !== null) {
			$time = date("d/m/Y", $timestamp);
		}
		$subtitle->addComponent($time);
		if (count($news->getAuthors()) > 0) {
			$s = "";
			foreach($news->getAuthors() as $author) {
				$s .= ", ".$author;
			}
			$subtitle->addComponent(" par ".substr($s, 2));
		}
		$this->addComponent($subtitle);
		
		$message = new SimpleTextComponent(Format::convertTextToHtml($news->getMessage()));
		$message->setClass("message");
		$message->setContentPinned(true);
		$this->addComponent($message);
		
		if (/*$timestamp >= strtotime('12 March 2012 14:47') &&*/ $news->isReleasing()) {
			$releases = array();
			foreach($news->getReleasing() as $release) {
				if ($release instanceof Project) {
					$pid = $release->getID();
					if (!array_key_exists($pid, $releases)) {
						$releases[$pid] = array();
					} else {
						// project already listed
					}
				} else if ($release instanceof Release) {
					$pid = $release->getProject()->getID();
					if (!array_key_exists($pid, $releases)) {
						$releases[$pid] = array();
					} else {
						// array already exists, continue
					}
					array_push($releases[$pid], $release->getID());
				} else {
					throw new Exception($release." is not a release nor a project.");
				}
			}
			
			$content = '';
			foreach($releases as $pid => $ids) {
				if (empty($ids)) {
					$content .= '[release='.$pid.'|*][/release]';
				} else {
					$content .= '[release='.$pid.'|'.implode(",", $ids).'][/release]';
				}
				$content .= "\n";
			}
			
			$releasing = new SimpleTextComponent(Format::convertTextToHtml($content));
			$releasing->setLegend('Sorties');
			$releasing->setClass("releases");
			$this->addComponent($releasing);
		}
		
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
		
		$twitterTitle = $news->getTwitterTitle();
		if ($twitterTitle == null) {
			$twitterTitle = "[Zero] ".$news->getTitle();
		}
		$twitterPart = new SimpleTextComponent();
		$twitterPart->setClass("twitter");
		$twitterButton = '<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$newsUrl->toFullString().'" data-text="'.$twitterTitle.'" data-via="zero_fansub" data-lang="fr">Tweeter</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		$twitterPart->addComponent($twitterButton);
		$this->addComponent($twitterPart);
		
		$googlePart = new SimpleTextComponent();
		$googlePart->setClass("google");
		$googleButton = '<div class="g-plusone" data-href="'.$newsUrl->toFullString().'" data-size="medium"></div>';
		$googlePart->addComponent($googleButton);
		$this->addComponent($googlePart);
		$this->setMetaData('itemscope');
		$this->setMetaData('itemtype', 'http://schema.org/Product');
		$title->setMetaData('itemprop', 'name');
		$message->setMetaData('itemprop', 'description');
		$c = $message->getComponent(0);
		$c = preg_replace('#<img #', '<img itemprop="image"', $c);
		$message->setComponent(0, $c);
		
		$facebookPart = new SimpleTextComponent();
		$facebookPart->setClass("facebook");
		$facebookButton = '<div class="fb-like" data-href="'.$newsUrl->toFullString().'" data-send="false" data-layout="button_count" data-width="90" data-show-faces="true"></div>';
		$facebookPart->addComponent($facebookButton);
		$this->addComponent($facebookPart);
	}
}
?>