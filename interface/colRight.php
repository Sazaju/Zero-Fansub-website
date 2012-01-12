<?php
	$rightCol = new SimpleBlockComponent();
	$rightCol->setId("colRight");
	
	$logo = new Image("images/interface/logo.png", "Zéro Fansub");
	$logo->setClass("logo");
	$rightCol->addComponent($logo);
	
	$menu = new Menu("db0 company");
	$menu->addEntry(Link::newWindowLink("http://www.anime-ultime.net/part/Site-93", new Image("images/partenaires/anime-ultime.jpg", "Anime-ultime")));
	$rightCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu("Fansub potes");
	$menu->addEntry(Link::newWindowLink("http://finalfan51.free.fr/ffs/", new Image("images/partenaires/finalfan.png", "FinalFan sub")));
	$menu->addEntry(Link::newWindowLink("http://www.mangas-arigatou.fr/", new Image("images/partenaires/mangas_arigatou.png", "Mangas Arigatou")));
	$menu->addEntry(Link::newWindowLink("http://www.kanaii.com", new Image("images/partenaires/kanaii.png", "Kanaii")));
	$menu->addEntry(Link::newWindowLink("http://kouhaiscantrad.wordpress.com", new Image("images/partenaires/kouhai.jpg", "Kouhai Scantrad")));
	$menu->addEntry(Link::newWindowLink("http://samazamablog.wordpress.com/", new Image("images/partenaires/samazama.gif", "Samazama na Koto")));
	$menu->addEntry(Link::newWindowLink("http://www.sky-fansub.com/", new Image("images/partenaires/sky.png", "Sky-fansub")));
	$rightCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu("Liens");
	$menu->addEntry(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", new Image("images/partenaires/animeka.jpg", "Animeka")));
	$rightCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu(new Link("index.php?page=partenariat", "Devenir partenaires"));
	$rightCol->addComponent(new MenuComponent($menu));
	
	$rightCol->writeNow();
?>
