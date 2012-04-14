<?php
	$page = PageContentComponent::getInstance();
	
	$page->addComponent(new TitleComponent("Dossiers", 1));
	
	foreach(Dossier::getAllDossiers() as $dossier) {
		$title = new SimpleBlockComponent();
		
		$title->addComponent(new TitleComponent($dossier->getTitle(), 2));
		
		$author = $dossier->getAuthor();
		if ($author instanceof TeamMember) {
			$author = $author->getPseudo();
		}
		$timestamp = strftime("%d/%m/%Y", $dossier->getTimestamp());
		$subtitle = $timestamp." par ".$author;
		$title->addComponent(new TitleComponent($subtitle, 4));
		
		$page->addComponent(new LinkComponent("?page=dossier&id=".$dossier->getID(), $title));
	}
?>