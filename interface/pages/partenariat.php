<?php
	$page = PageContent::getInstance();
	
	$page->addComponent(new Title("Partenariat", 1));
	$link = new Link("http://forum.zerofansub.net/t552-Les-regles-d-Or-de-chez-Zero.htm#p17057", "Conditions, Offres (a lire avant toute demande !)");
	$link->openNewWindow(true);
	$page->addComponent(new Title($link, 2));
	$page->addComponent(new Title("Nos bannières", 2));
	
	$content = '';
	$dir = 'images/partenaires/ourbanner/';
	$logos = array(
		'zero_280x45.png',
		'zero_468x60.png',
		'zero_500x117.png',
		'zero_500x150.png',
		'zero_88x31.png',
		'zero.jpg',
		'zero_500x117x.jpg',
		'zero_500x117xx.jpg',
	);
	foreach($logos as $filename) {
		$path = $dir.$filename;
		$content .= '[img='.$path.']zero[/img]
[code]<a href="http://zerofansub.net"><img src="http://zerofansub.net/'.$path.'" alt="zero" border="0" /></a>[/code]

';
	}
	$content = Format::convertTextToHTML($content);
	$page->addComponent(new SimpleTextComponent($content));
?>