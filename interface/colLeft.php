<?php
	$leftCol = new SimpleBlockComponent();
	$leftCol->setId("colLeft");
	
	$corners = CornerImage::getAllImages();
	$corner = $corners[array_rand($corners)];
	$corner->setId("menutop");
	$leftCol->addComponent($corner);
	
	$menu = new Menu();
	$menu->addEntry(new Link("index.php", "Accueil"));
	$menu->addEntry(Link::newWindowLink("irc://irc.Fansub-IRC.eu/zero", "IRC"));
	$menu->addEntry(Link::newWindowLink("http://forum.zerofansub.net", "Forum"));
	$menu->addEntry(Link::newWindowLink("http://twitter.com/zero_fansub", "Twitter"));
	$radioLink = new Link("#", "Radio");
	$radioLink->setOnclick("window.open('radio','radio','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=280, height=380, left=200, top=200');return(false)");
	$menu->addEntry($radioLink);
	$menu->addEntry(new Link("index.php?page=contact", "Contact"));
	$menu->addEntry(new Link("index.php?page=about", "À propos..."));
	$menu->addEntry(new Link("index.php?page=bug", "Signaler un bug"));
	$leftCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu();
	$projectLink = new Link("index.php?page=series", "Projets");
	$projectLink->setStyle("font-size: 1.5em;");
	$menu->addEntry($projectLink);
	$menu->addEntry(new Link("index.php?page=team", "L'équipe"));
	$menu->addEntry(Link::newWindowLink("http://forum.zerofansub.net/p32750.htm", "Avancement"));
	$menu->addEntry(Link::newWindowLink("http://forum.zerofansub.net/f21-RECRUTEMENT-Entrer-dans-la-team-de-fansub.htm", "Recrutement"));
	$menu->addEntry(Link::newWindowLink("http://www.bt-anime.net/index.php?page=tracker&team=Z%e9ro", "Torrent"));
	$menu->addEntry(new Link("index.php?page=xdcc", "XDCC"));
	$leftCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu();
	$menu->addEntry(new Link("index.php?page=dossiers", "Dossiers"));
	$menu->addEntry(Link::newWindowLink("galerie/index.php?spgmGal=Zero_fansub/Images", "Images"));
	$menu->addEntry(new Link("index.php?page=havert", "Hentaï"));
	$leftCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu();
	/* Hidden because never updated:
	$menu->addEntry("Serveur/mois : 173,39 €");
	$menu->addEntry("Dons du mois : 20 €");
	*/
	$donateLink = Link::newWindowLink("https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=mba_06%40hotmail%2efr&item_name=Zero&no_shipping=0&no_note=1&tax=0&currency_code=EUR&lc=FR&bn=PP%2dDonationsBF&charset=UTF%2d8", "Faire un don");
	$donateLink->setStyle("font-size: 1.2em;");
	$menu->addEntry($donateLink);
	$menu->addEntry(Link::newWindowLink("http://forum.zerofansub.net/t552.htm#p32300", "En savoir +"));
	$leftCol->addComponent(new MenuComponent($menu));
	
	$leftCol->writeNow();
?>
