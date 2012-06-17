<?php
	$page = PageContentComponent::getInstance();
	
	$content = "[title]Contact[/title]


Un commentaire à faire ?
Une critique ?
Un lien mort ?
Une proposition ?
Un lien de streaming ?

Une seule adresse pour contacter la team :


[size=25px][mail]zero.fansub@gmail.com[/mail][/size]";
	
	$contact = new SimpleTextComponent(Format::convertTextToHTML($content));

	
	$page->addComponent($contact);
?>