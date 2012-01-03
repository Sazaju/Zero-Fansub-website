<?php
	$page = PageContent::getInstance();
	$page->setTitle("Avertissement");
	
	$page->addComponent(new Archives());
	
	$content = new SimpleBlockComponent();
	$content->setClass("havert");
	$page->addComponent($content);
	
	$content->addComponent(new Image("images/news/avert.jpg"));
	$content->addComponent(new Title("Vous êtes sur le point d'entrer dans la zone Hentaï", 2));
	$content->addComponent(new SimpleParagraphComponent("Comme son nom l'indique, cette partie regorge de machins dégoûtants interdits aux enfants. Mais bon, si vous êtes majeur, vacciné et consentant, on vous autorise à entrer là-dedans."));
	$content->addComponent(new Link("?page=hhentai", "Je rentre !"));
	$content->addComponent(new Link(Url::indexUrl(), "Je sors..."));
?>
