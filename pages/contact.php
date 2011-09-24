<?php
	$title = new Title("Contact", 3);
	$title->writeNow();
	
	$contact = new SimpleTextComponent();
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
	
	$contact2 = new SimpleBlockComponent();
	$contact2->setClass("p");
	$contact2->addComponent($contact);
	$contact2->writeNow();
?>
