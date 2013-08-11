<?php
	$page = PageContent::getInstance();
	$page->setClass('dossiers');
	
	$page->addComponent(new Title("Dossiers", 1));
	
	foreach(Dossier::getAllDossiers() as $dossier) {
		$title = new SimpleBlockComponent();
		
		$title->addComponent(new Title($dossier->getTitle(), 2));
		
		$author = $dossier->getAuthor();
		if ($author instanceof TeamMember) {
			$author = $author->getPseudo();
		}
		$timestamp = strftime("%d/%m/%Y", $dossier->getTimestamp());
		$subtitle = $timestamp." par ".$author;
		$title->addComponent(new Title($subtitle, 4));
		
		$page->addComponent(new Link("?page=dossier&id=".$dossier->getID(), $title));
	}
?>