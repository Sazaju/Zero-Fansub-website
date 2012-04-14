<?php
	$page = PageContentComponent::getInstance();
	$page->addComponent(new TitleComponent("Avertissement", 1));
	
	$content = new SimpleBlockComponent();
	$content->setClass("havert");
	$content->addComponent(new ImageComponent("images/news/avert.jpg"));
	$content->addComponent(new TitleComponent("Vous êtes sur le point d'entrer en mode Hentaï", 2));
	$content->addComponent("Comme son nom l'indique, vous vous apprêtez à regarder plein de machins dégoûtants interdits aux enfants. Mais bon, si vous êtes majeur, vacciné et consentant, on vous y autorise.");
	$content->addComponent(Format::convertTextToHTML("[separator]"));
	
	$okLink = new LinkComponent();
	$okLink->setContent("Montrer les machins dégoutants");
	$url = $okLink->getUrl();
	$url->removeQueryVar(DISPLAY_H_AVERT);
	$url->setQueryVar(MODE_H, true);
	$content->addComponent($okLink);
	
	$cancelLink = new LinkComponent(Url::indexUrl(), "Garder mon écran propre");
	if (isset($_SERVER["HTTP_REFERER"])) {
		// TODO if the referer is a page needing the H mode, do not use it
		$cancelLink->setUrl(new Url($_SERVER["HTTP_REFERER"]));
	}
	$content->addComponent($cancelLink);
	
	$page->addComponent($content);
?>