<?php
	$rightCol = new SimpleBlockComponent();
	$rightCol->setId("colRight");
	
	$logo = new SimpleBlockComponent(); // content set by the style
	$logo->setClass("logo");
	$rightCol->addComponent($logo);
	
	$partners = array_filter(Partner::getAllPartners(), function(Partner $partner) {return !$partner->isOver();});
	usort($partners, function($a, $b) { return strnatcasecmp($a->getName(), $b->getName()); });
	$partnerMenu = new Menu("Partenaires");
	$crushMenu = new Menu("Coups de cœur");
	foreach($partners as $partner) {
		$link = new PartnerLink($partner);
		$link->setUseImage(true);
		if ($partner->isOfficial()) {
			$partnerMenu->addEntry($link);
		} else {
			$crushMenu->addEntry($link);
		}
	}
	
	$becomePartnerLink = new Link("?page=partenariat", "Devenir partenaires");
	$becomePartnerLink->setClass('become-partner');
	$partnerMenu->addEntry($becomePartnerLink);
	
	$rightCol->addComponent(new MenuComponent($partnerMenu));
	$rightCol->addComponent(new MenuComponent($crushMenu));
	$rightCol->writeNow();
?>