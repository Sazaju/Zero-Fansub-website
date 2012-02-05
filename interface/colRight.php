<?php
	$rightCol = new SimpleBlockComponent();
	$rightCol->setId("colRight");
	
	$logo = new Image("images/interface/logo.png", "Zéro Fansub");
	$logo->setClass("logo");
	$rightCol->addComponent($logo);
	
	$menu = new Menu("db0 company");
	foreach(Partner::getAllPartners() as $partner) {
		if ($partner->isDb0Company()) {
			$menu->addEntry(new PartnerLink($partner));
		}
	}
	$rightCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu("Fansub potes");
	foreach(Partner::getAllPartners() as $partner) {
		if ($partner->isFansubPartner()) {
			$menu->addEntry(new PartnerLink($partner));
		}
	}
	$rightCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu("Liens");
	foreach(Partner::getAllPartners() as $partner) {
		if (!$partner->isFansubPartner() && !$partner->isDb0Company()) {
			$menu->addEntry(new PartnerLink($partner));
		}
	}
	$rightCol->addComponent(new MenuComponent($menu));
	
	$menu = new Menu(new Link("?page=partenariat", "Devenir partenaires"));
	$rightCol->addComponent(new MenuComponent($menu));
	
	$rightCol->writeNow();
?>
