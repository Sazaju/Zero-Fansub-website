<?php
/*
	A dossier component the renderable version of a dossier.
*/
class DossierComponent extends SimpleBlockComponent {
	public function __construct(Dossier $dossier) {
		$this->setClass('dossier');
		
		$this->addComponent(new Title($dossier->getTitle(), 2));
		
		$author = $dossier->getAuthor();
		if ($author instanceof TeamMember) {
			$author = $author->getPseudo();
		}
		$timestamp = strftime("%d/%m/%Y", $dossier->getTimestamp());
		$subtitle = $timestamp." par ".$author;
		$this->addComponent(new Title($subtitle, 4));
		
		$content = new SimpleBlockComponent();
		$content->setClass('content');
		$content->setContent(Format::convertTextToHtml($dossier->getContent()));
		$content->setContentPinned(true);
		$this->addComponent($content);
		
		$id = $dossier->getCommentID();
		$comment = new SimpleTextComponent();
		$comment->setClass('comment');
		$comment->setContent('~ <a href="http://commentaires.zerofansub.net/t'.$id.'.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t='.$id.'" target="_blank">Ajouter un commentaire</a> ~');
		$this->addComponent($comment);
	}
}?>