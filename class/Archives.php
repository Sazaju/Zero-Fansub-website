<?php
/*
	The archives block is the pack of links at the top and at the bottom of the home page.
*/
class Archives extends SimpleBlockComponent {
	public function __construct() {
		$space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$archivesLinks = new SimpleBlockComponent();
		$archivesLinks->addComponent(new IndexLink("page=home", "Derni&egrave;res news"));
		$archivesLinks->addComponent($space);
		$archivesLinks->addComponent(new IndexLink("page=hsorties", "Sorties"));
		$archivesLinks->addComponent($space);
		$archivesLinks->addComponent(new IndexLink("page=hteam", "Infos team"));
		$archivesLinks->addComponent($space);
		$archivesLinks->addComponent(new IndexLink("page=hpartenaires", "Partenaires"));
		$archivesLinks->addComponent($space);
		$archivesLinks->addComponent(new IndexLink("page=hdb0c", "db0 company"));
		$archivesLinks->addComponent($space);
		$archivesLinks->addComponent(new IndexLink("page=hbonus", "Bonus"));
		$archivesLinks->addComponent($space);
		$link = new IndexLink("page=havert", "Henta&icirc;");
		$link->setStyle("color: #FF3399;");
		$link->setID("plus");
		$archivesLinks->addComponent($link);
		
		$this->setClass("archives");
		$this->addComponent("<h2>Archives</h2>");
		$this->addComponent($archivesLinks);
	}
}
?>