<?php
	$page = PageContent::getInstance();
	
	$page->addComponent(new Title("Partenariat", 1));
	$link = new Link("http://forum.zerofansub.net/t552-Les-regles-d-Or-de-chez-Zero.htm#p17057", "Conditions, Offres (a lire avant toute demande !)");
	$link->openNewWindow(true);
	$page->addComponent(new Title($link, 2));
	$page->addComponent(new Title("Nos bannières", 2));
	
	$content = '[img=images/partenaires/ourbanner/zero_280x45.png]zero[/img]
[code]<a href="http://zerofansub.net"><img
src="http://zerofansub.net/images/partenaires/ourbanner/zero_280x45.png" alt="zero"
border="0"></a>[/code]

[img=images/partenaires/ourbanner/zero_468x60.png]zero[/img]
[code]<a href="http://zerofansub.net"><img
src="http://zerofansub.net/images/partenaires/ourbanner/zero_468x60.png" alt="zero"
border="0"></a>[/code]

[img=images/partenaires/ourbanner/zero_500x117.png]zero[/img]
[code]<a href="http://zerofansub.net"><img
src="http://zerofansub.net/images/partenaires/ourbanner/zero_500x117.png" alt="zero"
border="0"></a>[/code]

[img=images/partenaires/ourbanner/zero_500x150.png]zero[/img]
[code]<a href="http://zerofansub.net"><img
src="http://zerofansub.net/images/partenaires/ourbanner/zero_500x150.png" alt="zero"
border="0"></a>[/code]

[img=images/partenaires/ourbanner/zero_88x31.png]zero[/img]
[code]<a href="http://zerofansub.net"><img
src="http://zerofansub.net/images/partenaires/ourbanner/zero_88x31.png" alt="zero"
border="0"></a>[/code]

[img=images/partenaires/ourbanner/zero.jpg]zero[/img]
[code]<a href="http://zerofansub.net"><img
src="http://zerofansub.net/images/partenaires/ourbanner/zero.jpg" alt="zero"
border="0"></a>[/code]

[img=images/partenaires/ourbanner/zero_500x117x.jpg]zero[/img]
[code]<a href="http://zerofansub.net"><img
src="http://zerofansub.net/images/partenaires/ourbanner/zero_500x117x.jpg" alt="zero"
border="0"></a>[/code]

[img=images/partenaires/ourbanner/zero_500x117xx.jpg]zero[/img]
[code]<a href="http://zerofansub.net"><img
src="http://zerofansub.net/images/partenaires/ourbanner/zero_500x117xx.jpg" alt="zero"
border="0"></a>[/code]';
	$content = Format::convertTextToHTML($content);
	$page->addComponent(new SimpleTextComponent($content));
?>