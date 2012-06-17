<?php
	$rightCol = new SimpleBlockComponent();
	$rightCol->setId("colRight");
	
	$logo = new Image("images/interface/logo.png", "Zéro Fansub");
	$logo->setClass("logo");
	$rightCol->addComponent($logo);
	
	$partners = Partner::getAllPartners();
	$partners = array_filter($partners, function(Partner $partner) {return !$partner->isOver();});
	
	$menu = new Menu("db0 company");
	foreach($partners as $partner) {
		if ($partner->isDb0Company()) {
			$link = new PartnerLink($partner);
			$link->setUseImage(true);
			$menu->addEntry($link);
		}
	}
	$rightCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu("Fansub potes");
	foreach($partners as $partner) {
		if ($partner->isFansubPartner()) {
			$link = new PartnerLink($partner);
			$link->setUseImage(true);
			$menu->addEntry($link);
		}
	}
	$rightCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu("Liens");
	foreach($partners as $partner) {
		if (!$partner->isFansubPartner() && !$partner->isDb0Company()) {
			$link = new PartnerLink($partner);
			$link->setUseImage(true);
			$menu->addEntry($link);
		}
	}
	$rightCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu(new Link("?page=partenariat", "Devenir partenaires"));
	$rightCol->addComponent(new MenuComponent($menu));
	
	$rightCol->writeNow();
?>