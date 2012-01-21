<?php
/*
	The archives block is the pack of links at the top and at the bottom of the home page.
*/
class Archives extends SimpleBlockComponent {
	public function __construct() {
		$space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$url = new Url("index.php");
		$archivesLinks = new SimpleBlockComponent();
		$url->setQueryVar('page', 'home');
		$archivesLinks->addComponent(new Link(new Url($url), "Derni&egrave;res news"));
		$archivesLinks->addComponent($space);
		$url->setQueryVar('page', 'hsorties');
		$archivesLinks->addComponent(new Link(new Url($url), "Sorties"));
		$archivesLinks->addComponent($space);
		$url->setQueryVar('page', 'hteam');
		$archivesLinks->addComponent(new Link(new Url($url), "Infos team"));
		$archivesLinks->addComponent($space);
		$url->setQueryVar('page', 'hpartenaires');
		$archivesLinks->addComponent(new Link(new Url($url), "Partenaires"));
		$archivesLinks->addComponent($space);
		$url->setQueryVar('page', 'hdb0c');
		$archivesLinks->addComponent(new Link(new Url($url), "db0 company"));
		$archivesLinks->addComponent($space);
		$url->setQueryVar('page', 'hbonus');
		$archivesLinks->addComponent(new Link(new Url($url), "Bonus"));
		$archivesLinks->addComponent($space);
		$url->setQueryVar('page', 'havert');
		
		$this->setClass("archives");
		$this->addComponent("<h2>Archives</h2>");
		$this->addComponent($archivesLinks);
	}
}
?>
