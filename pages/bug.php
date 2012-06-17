<?php
	$page = PageContentComponent::getInstance();
	$page->addComponent(new TitleComponent("Signaler un bug", 1));
	
	$admin = TeamMember::getMemberByPseudo("sazaju HITOKAGE");
	
	$serverInfo = function($id) {
		return isset($_SERVER[$id]) ? $_SERVER[$id] : 'inconnue';
	};
	
	$text = "


Le site étant en plein raffinage, il est possible que vous tombiez sur des bogues (ou bug) au cours de votre navigation. Si tel est le cas, vous retomberez généralement sur cette page. Par conséquent, si vous vous trouvez ici sans trop savoir pourquoi, c'est probablement parce que vous venez de tomber sur un de ces bogues. Pour nous le signaler, plusieurs moyens sont à votre disposition :

[url=https://github.com/Sazaju/Zero-Fansub-website/issues]Enregistrer un bug sur GitHub[/url]

[mail=".$admin->getMail()."]Envoyer un mail à l'administrateur Web[/mail]

La première solution est de loin la meilleure, car en plus d'avertir les administrateurs, le problème est enregistré et peut donc être suivi efficacement. Néanmoins, si vous ne savez pas comment utiliser ce système, la seconde option vous permet d'envoyer directement un mail aux admins. De préférence utilisez la première solution, n'utilisez la seconde que si vraiment vous avez des soucis avec la première.

Soyez sûrs de donner le maximum de détails, en particulier l'adresse actuelle de la page, la page ou vous étiez juste avant le bogue, votre navigateur et sa version (ou au moins dire si vous l'avez mis à jour récemment), et les plugins ou programmes que vous auriez installé qui vous semble être une cause potentielle du problème (gestionnaire de scripts, antivirus, ...).

En voici quelques unes, vous pouvez les recopier et les compléter :
[left][list]
[item]adresse actuelle : [urlk=current|full][/urlk][/item]
[item]adresse précédente : [urlk=referer|full][/urlk][/item]
[item]infos navigateur : ".$serverInfo('HTTP_USER_AGENT')."[/item]
[/list][/left]";
	
	$content = new SimpleTextComponent();
	$content->setClass("bug");
	$content->setContent(Format::convertTextToHtml($text));
	
	$page->addComponent($content);

?> 