<?php
	$leftCol = new NavigationComponent();
	$leftCol->setId("colLeft");
	
	$corners = null;
	if ($_SESSION[MODE_H]) {
		$corners = CornerImage::getHentaiImages();
	} else {
		$corners = CornerImage::getNotHentaiImages();
	}
	$corner = $corners[array_rand($corners)];
	$corner->setClass("cornerImage");
	$leftCol->addComponent($corner);
	
	$menu = new Menu();
	$menu->addEntry(new Link("index.php", "Accueil"));
	$menu->addEntry(Link::newWindowLink("http://forum.zerofansub.net", "Forum"));
	$menu->addEntry(Link::newWindowLink("http://twitter.com/zero_fansub", "Twitter"));
	$menu->addEntry(Link::newWindowLink("radio", "Radio"));
	$menu->addEntry(new Link("index.php?page=contact", "Contact"));
	$menu->addEntry(new Link("index.php?page=about", "À propos..."));
	$menu->addEntry(new Link("index.php?page=bug", "Signaler un bug"));
	$leftCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu();
	$projectLink = new Link("index.php?page=projects", "Projets");
	$projectLink->setStyle("font-size: 1.5em;");
	$menu->addEntry($projectLink);
	$menu->addEntry(new Link("index.php?page=team", "L'équipe"));
	$menu->addEntry(Link::newWindowLink("http://forum.zerofansub.net/p32750.htm", "Avancement"));
	$menu->addEntry(new Link("index.php?page=recruit", "Recrutement"));
	$menu->addEntry(new Link("torrentsZeroFansub.zip", "Torrent"));
	$leftCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu();
	$menu->addEntry(new Link("index.php?page=dossiers", "Dossiers"));
	$menu->addEntry(Link::newWindowLink("galerie/index.php?spgmGal=Zero_fansub/Images", "Images"));
	$menu->addEntry(Link::createHentaiAccessLink());
	$leftCol->addComponent(new MenuComponent($menu));
	
	$leftCol->writeNow();
?>