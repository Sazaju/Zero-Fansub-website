<?php
	$page = PageContent::getInstance();
	$page->setTitle("Avertissement");
	
	$page->addComponent(new Archives());
	
	$content = new SimpleBlockComponent();
	$content->setClass("havert");
	$page->addComponent($content);
	
	$content->addComponent(new Image("images/news/avert.jpg"));
	$content->addComponent(new Title("Vous êtes sur le point d'entrer en mode Hentaï", 2));
	$content->addComponent(new SimpleParagraphComponent("Comme son nom l'indique, vous vous apprêtez à regarder plein de machins dégoûtants interdits aux enfants. Mais bon, si vous êtes majeur, vacciné et consentant, on vous y autorise."));
	
	$okLink = new Link();
	$okLink->setContent("Montrer les machins dégoutants");
	$url = $okLink->getUrl();
	$url->removeQueryVar(DISPLAY_H_AVERT);
	$url->setQueryVar(DISPLAY_H, true);
	$content->addComponent($okLink);
	
	$cancelLink = new Link(Url::indexUrl(), "Garder mon écran propre");
	if (isset($_SERVER["HTTP_REFERER"])) {
		$cancelLink->setUrl(new Url($_SERVER["HTTP_REFERER"]));
	}
	$content->addComponent($cancelLink);
?>
