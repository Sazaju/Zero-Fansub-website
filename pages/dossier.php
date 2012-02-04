<?php
	$page = PageContent::getInstance();
	$page->setClass('dossierPage');
	
	$returnLink = new Link("?page=dossiers", "Retour aux dossiers");
	$returnLink->setClass('returnLink');
	$page->addComponent($returnLink);
	
	$page->addComponent('<p></p>');
	
	$url = Url::getCurrentUrl();
	$dossier = new DossierComponent(Dossier::getDossier($url->getQueryVar('id')));
	$page->addComponent($dossier);
?>