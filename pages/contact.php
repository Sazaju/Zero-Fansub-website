<?php
	$page = PageContent::getInstance();
	$page->addComponent(new Title("Contact", 1));
	
	$contact = new SimpleTextComponent();
	$contact->setClass("contact");
	$contact->addLine();
	$contact->addLine();
	$contact->addLine();
	$contact->addLine();
	$contact->addLine("Un commentaire à faire ?");
	$contact->addLine("Une critique ?");
	$contact->addLine("Un lien mort ?");
	$contact->addLine("Une proposition ?");
	$contact->addLine("Un lien de streaming ?");
	$contact->addLine();
	$contact->addLine("Une seule adresse pour contacter la team :");
	$contact->addLine();
	$contact->addLine();
	$link = new MailLink("zero.fansub@gmail.com");
	$link->setStyle("font-size: 25px;");
	$contact->addComponent($link);
	
	$page->addComponent($contact);
?>
