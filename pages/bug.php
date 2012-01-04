<?php
	$page = PageContent::getInstance();
	$page->setTitle("Signaler un bug");
	
	$admin = TeamMember::getMemberByPseudo("sazaju HITOKAGE");
	
	$content = new SimpleTextComponent();
	$content->setClass("bug");
	$content->addLine("Le site étant en plein raffinage, il est possible que vous tombiez sur des bugs au cours de votre navigation. Si tel est le cas, n'hésitez pas à le signaler immédiatement ! Pour cela, plusieurs solutions sont possibles :");
	$content->addLine();
	$content->addLine(Link::newWindowLink("https://github.com/Sazaju/Zero-Fansub-website/issues", "Enregistrer un bug sur GitHub"));
	$content->addLine();
	$content->addLine(new MailLink($admin->getMail(), "Envoyer un mail à l'administrateur Web"));
	$content->addLine();
	$content->addLine("La première solution est de loin la meilleure, car en plus d'avertir les administrateurs, le problème est enregistré et peut donc être suivi efficacement. Cela dit, il est nécessaire de se connecter (si vous n'avez pas de compte GitHub vous pouvez toujours en créer un gratuitement). Néanmoins, comme il existe des réfractaires, une seconde option est d'envoyer directement un mail aux admins. De préférence utilisez la première solution, n'utilisez la seconde que si vraiment vous avez des soucis avec la première.");
	
	$page->addComponent($content);

?> 
