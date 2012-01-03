<?php
	$page = PageContent::getInstance();
	$page->setTitle("XDCC");
	
	$message = new SimpleTextComponent();
	$message->setClass("xdcc");
	$page->addComponent($message);
	$message->addComponent("Pour t&eacute;l&eacute;charger un fichier, aller sur le chan IRC (");
	$ircLink = Link::newWindowLink("irc://irc.fansub-irc.eu/zero", "Lien du Channel");
	$message->addComponent($ircLink);
	$message->addLine(") et tapez la commande :");
	$message->addLine();
	$message->addLine("<code>/msg Lishiantus xdcc send <i>NUMERO</i></code>");
	$message->addLine();
	$message->addLine("ou <code><i>NUMERO</i></code> doit &ecirc;tre remplac&eacute; par le num&eacute;ro du paquet (voir liste ci-dessous).");
	$message->addLine();
	$message->addLine();
	$message->addLine("<iframe src='http://sazaju.dyndns-home.com/zero/lishiantus.txt' width='100%' height='600' frameborder='0'><p>Your browser does not support iframes.</p></iframe>");
?>
