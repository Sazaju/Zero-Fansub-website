<?php
	$content = "[title]Les 4 fantastiques[/title][img]images/news/les_4_fantastiques_.jpg[/img]";
	PageContent::getInstance()->addComponent(Format::convertTextToHTML($content));
?>