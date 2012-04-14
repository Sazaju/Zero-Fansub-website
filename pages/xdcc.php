<?php
	$page = PageContentComponent::getInstance();
	$page->addComponent(new TitleComponent("XDCC", 1));
	
	$message = new SimpleTextComponent();
	$message->setClass("xdcc");
	$page->addComponent($message);
	$message->addComponent("Pour télécharger un fichier, aller sur le chan IRC (");
	$ircLink = LinkComponent::newWindowLink("irc://irc.fansub-irc.eu/zero", "Lien du Channel");
	$message->addComponent($ircLink);
	$message->addLine(") et tapez la commande :");
	$message->addLine();
	$message->addLine("<code>/msg [Zero]Rin xdcc send <i>NUMERO</i></code>");
	$message->addLine();
	$message->addLine("ou <code><i>NUMERO</i></code> doit être remplacé par le numéro du paquet (voir liste ci-dessous).");
	$message->addLine();
	$message->addLine();
	$message->addLine("<iframe src='iroffer/[Zero]Rin.txt' width='100%' height='600' frameborder='0'><p>Your browser does not support iframes.</p></iframe>");
?>