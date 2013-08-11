<?php
	$page = PageContent::getInstance();
	$page->setClass("havert");
	
	$page->addComponent(new Title("Avertissement", 1));
	
	$page->addComponent(new Image("images/news/avert.jpg"));
	$page->addComponent(new Title("Vous êtes sur le point d'entrer en mode Hentaï", 2));
	$page->addComponent(new SimpleParagraphComponent("Comme son nom l'indique, vous vous apprêtez à regarder plein de machins dégoûtants interdits aux enfants. Mais bon, si vous êtes majeur, vacciné et consentant, on vous y autorise."));
	
	$okLink = new Link();
	$okLink->setContent("Montrer les machins dégoutants");
	$url = $okLink->getUrl();
	$url->removeQueryVar(DISPLAY_H_AVERT);
	$url->setQueryVar(MODE_H, true);
	$page->addComponent($okLink);
	
	$cancelLink = new Link(Url::indexUrl(), "Garder mon écran propre");
	if (isset($_SERVER["HTTP_REFERER"])) {
		// TODO if the referer is a page needing the H mode, do not use it
		$cancelLink->setUrl(new Url($_SERVER["HTTP_REFERER"]));
	}
	$page->addComponent($cancelLink);
?>