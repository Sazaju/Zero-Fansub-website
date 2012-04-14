<?php
	$content = "[title]Les 4 fantastiques[/title][img]images/news/les_4_fantastiques_.jpg[/img]";
	PageContentComponent::getInstance()->addComponent(Format::convertTextToHTML($content));
?>