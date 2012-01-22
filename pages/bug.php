<?php
	$page = PageContent::getInstance();
	$page->addComponent(new Title("Signaler un bug", 1));
	
	$admin = TeamMember::getMemberByPseudo("sazaju HITOKAGE");
	
	$content = new SimpleTextComponent();
	$content->setClass("bug");
	$content->addLine();
	$content->addLine();
	$content->addLine();
	$content->addLine("Le site étant en plein raffinage, il est possible que vous tombiez sur des bogues (ou bug) au cours de votre navigation. Si tel est le cas, vous retomberez généralement sur cette page. Par conséquent, si vous vous trouvez ici sans trop savoir pourquoi, c'est probablement parce que vous venez de tomber sur un de ces bogues. Pour nous le signaler, plusieurs moyens sont à votre disposition :");
	$content->addLine();
	$content->addLine(Link::newWindowLink("https://github.com/Sazaju/Zero-Fansub-website/issues", "Enregistrer un bug sur GitHub"));
	$content->addLine();
	$content->addLine(new MailLink($admin->getMail(), "Envoyer un mail à l'administrateur Web"));
	$content->addLine();
	$content->addLine("La première solution est de loin la meilleure, car en plus d'avertir les administrateurs, le problème est enregistré et peut donc être suivi efficacement. Néanmoins, si vous ne savez pas comment utiliser ce système, la seconde option vous permet d'envoyer directement un mail aux admins. De préférence utilisez la première solution, n'utilisez la seconde que si vraiment vous avez des soucis avec la première.");
	$content->addLine();
	$content->addLine("Soyez sûrs de donner le maximum de détails, en particulier la page ou vous étiez juste avant le bogue, votre navigateur et sa version (ou au moins dire si vous l'avez mis à jour récemment), et les plugins ou programmes que vous auriez installé qui vous semble être une cause potentielle du problème (gestionnaire de scripts, antivirus, ...).");
	
	$page->addComponent($content);

?> 
