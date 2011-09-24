<?php
	$archives = new Archives();
	$archives->writeNow();
?>
<?php
	$newsMessage = new SimpleTextComponent();
	$newsMessage->addLine(new Image("images/news/hito1.jpg", "Hitohira"));
	$newsMessage->addLine();
	$newsMessage->addLine("Sortie de Hitohira, la s&eacute;rie compl&egrave;te, 12 &eacute;pisodes d'un coup !");
	$newsMessage->addLine();
	$newsMessage->addLine(new Image("images/news/hito2.jpg", "Hitohira"));
	$newsMessage->addLine();
	
	$news = new News();
	$news->setTitle("Hitohira - S&eacute;rie compl&egrave;te");
	$news->setDate("14/08/2011");
	$news->setAuthor("db0");
	$news->setCommentId(270);
	$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Hitohira serie complete chez Z%C3%A9ro fansub !");
	$news->setMessage($newsMessage);
	$news->writeNow();
?>
<?php
	$newsMessage = new SimpleTextComponent();
	$newsMessage->addLine(new Image("images/episodes/mitsudomoe3.jpg", "Mitsudomoe"));
	$newsMessage->addLine();
	$newsMessage->addLine("Sortie de l'&eacute;pisode 03 de Mitsudomoe.");
	$newsMessage->addLine();
	
	$news = new News();
	$news->setTitle("Mitsudomoe 03");
	$news->setDate("05/08/2011");
	$news->setAuthor("db0");
	$news->setCommentId(269);
	$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Mitsudomoe 03 chez Z%C3%A9ro fansub !");
	$news->setMessage($newsMessage);
	$news->writeNow();
?>
<?php
	$newsMessage = new SimpleTextComponent();
	$newsMessage->addLine(new Image("images/series/toradorasos.jpg", "Toradora SOS"));
	$newsMessage->addLine();
	$newsMessage->addLine("4 mini OAV d&eacute;lirants sur la bouffe, avec les personnages en taille r&eacute;duite.");
	$newsMessage->addLine("C'est de la superproduction ^_^");
	$newsMessage->addLine();
	
	$news = new News();
	$news->setTitle("Toradora! SOS - S&eacute;rie compl&egrave;te 4 OAV");
	$news->setDate("26/07/2011");
	$news->setAuthor("praia");
	$news->setCommentId(268);
	$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Toradora! SOS chez Zero fansub !");
	$news->setMessage($newsMessage);
	$news->writeNow();
?>
<?php
	$newsMessage = new SimpleTextComponent();
	$newsMessage->addLine(new Image("images/news/bath.jpg", "Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko"));
	$newsMessage->addLine();
	$newsMessage->addLine("Nous avons appris qu'Ankama va diffuser &agrave; partir de la rentr&eacute;e de septembre 2011 :");
	$newsMessage->addLine("Baccano, Kannagi et Tetsuwan Birdy Decode. Tous les liens on donc &eacute;t&eacute; retir&eacute;s.");
	$newsMessage->addLine("On vous invite &agrave; cesser la diffusion de nos liens et &agrave; aller regarder la s&eacute;rie sur leur site.");
	$newsMessage->addLine();
	$newsMessage->addLine("Sorties d'Isshoni Training Ofuro : Bathtime with Hinako & Hiyoko");
	$newsMessage->addLine();
	$newsMessage->addLine("3e volet des \"isshoni\", on apprend comment les Japonaises prennent leur bain, tr&egrave;s int&eacute;ressant...");
	$newsMessage->addLine("Avec en bonus, une petite s&eacute;ance de stretching...");
	$newsMessage->addLine();
	$newsMessage->addLine("Je ne sais pas s'il y aura une suite, mais si oui, je devine un peu le genre ^_^");
	$newsMessage->addLine();
	
	$news = new News();
	$news->setTitle("Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko");
	$news->setDate("23/07/2011");
	$news->setAuthor("praia");
	$news->setCommentId(267);
	$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Isshoni Training Ofuro chez Zero fansub !");
	$news->setMessage($newsMessage);
	$news->writeNow();
?>
<?php
	$newsMessage = new SimpleTextComponent();
	$newsMessage->addLine(new Image("images/news/m1.jpg", "Mitsudomoe"));
	$newsMessage->addLine();
	$newsMessage->addLine("Nous avons urgemment besoin d'un trad pour Mitsudomoe !!");
	$newsMessage->addLine("S'il vous pla&icirc;t, piti&eacute; xD");
	$newsMessage->addLine("Notre edit s'impatiente et ne peux continuer la s&eacute;rie, alors aidez-nous ^_^");
	$newsMessage->addLine("C'est pas souvent qu'on demande du renfort, mais l&agrave;, c'est devenu indispensable...");
	$newsMessage->addLine("Nous avons perdu un trad r&eacute;cemment, il ne nous en reste plus qu'un... et comble de malheur,  il n'a pas accroch&eacute; &agrave; la s&eacute;rie, mais je le remercie pour avoir quand m&ecirc;me traduit deux &eacute;pisodes pour nous d&eacute;panner.");
	$newsMessage->addComponent("Des petits cours sont dispos ici : ");
	$link = new Link("http://forum.zerofansub.net/f221-Cours-br.htm", "Lien");
	$link->openNewWindow(true);
	$newsMessage->addComponent($link);
	$newsMessage->addLine(".");
	$newsMessage->addLine();
	$newsMessage->addComponent("Pour postuler, faites une candidatures &agrave; l'&eacute;cole : ");
	$link = new Link("http://ecole.zerofansub.net/?page=postuler", "Lien");
	$link->openNewWindow(true);
	$newsMessage->addComponent($link);
	$newsMessage->addLine(".");
	$newsMessage->addLine();
	$newsMessage->addLine(new Image("images/news/m2.jpg", "Mitsudomoe"));
	$newsMessage->addLine();
	
	$news = new News();
	$news->setTitle("Recrutement traducteur");
	$news->setDate("04/07/2011");
	$news->setAuthor("praia");
	$news->setCommentId(266);
	$news->setTwitterUrl("http://twitter.com/home?status=Zero recherche un traducteur");
	$news->setMessage($newsMessage);
	$news->writeNow();
?>
<?php
	$newsMessage = new SimpleTextComponent();
	$link = new Link("http://zerofansub.net/galerie/gal/Zero_fansub/Images/Kannagi/%5BZero%5DKannagi_Image63.jpg", new Image("images/news/kannagi.jpg", "Kannagi"));
	$link->openNewWindow(true);
	$newsMessage->addLine($link);
	$newsMessage->addLine();
	$newsMessage->addLine("Bonjour les amis !");
	$newsMessage->addLine("La s&eacute;rie Kannagi est termin&eacute;e !");
	$newsMessage->addLine("J&#039;&eacute;sp&egrave;re qu&#039;elle vous plaira.");
	$newsMessage->addLine("N&#039;h&eacute;sitez pas &agrave; nous dire ce que vous en pensez dans les commentaires. C&#039;est en apprenant de ses erreurs qu&#039;on avance, apr&egrave;s tout ;)");
	$newsMessage->addLine();
	$newsMessage->addLine("P.S.: Les karaok&eacute;s sont nuls. D&eacute;sol&eacute;e !");
	$newsMessage->addLine();
	
	$news = new News();
	$news->setTitle("Kannagi - S&eacute;rie compl&egrave;te");
	$news->setDate("19/06/2011");
	$news->setAuthor("db0");
	$news->setCommentId(264);
	$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Kannagi serie complete chez Zero fansub !");
	$news->setMessage($newsMessage);
	$news->writeNow();
?>
<?php
	$newsMessage = new SimpleTextComponent();
	$newsMessage->addLine(new Image("images/news/mitsu0102.jpg", "Mitsudomoe"));
	$newsMessage->addLine();
	$newsMessage->addLine("Bonjour les amis !");
	$newsMessage->addLine("Apr&egrave;s des mois d'attente, les premiers &eacute;pisodes de Mitsudomoe sont enfin disponibles !");
	$newsMessage->addLine("Quelques petits changements dans notre fa&ccedil;on de faire habituelle, on attend vos retours avec impatience ;)");
	$newsMessage->addLine();
	
	$news = new News();
	$news->setTitle("Mitsudomoe 01 + 02");
	$news->setDate("27/05/2011");
	$news->setAuthor("db0");
	$news->setCommentId(263);
	$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Mitsudomoe 01 + 02 chez Zero fansub !");
	$news->setMessage($newsMessage);
	$news->writeNow();
?>
<?php
	$newsMessage = new SimpleTextComponent();
	$newsMessage->addLine(new Image("images/news/tayutamapure.jpg", "Tayutama ~ Kiss on my Deity ~ Pure my Heart ~"));
	$newsMessage->addLine();
	$newsMessage->addLine("On continue dans les s&eacute;ries compl&egrave;tes avec cette fois-ci la petite s&eacute;rie de 6 OAV qui fait suite &agrave; la s&eacute;rie Tayutama ~ Kiss on my Deity : les 'Pure my Heart'. Ils sont assez courts mais plut&ocirc;t dr&ocirc;le alors amusez-vous bien !");
	$newsMessage->addLine();
	
	$news = new News();
	$news->setTitle("Tayutama ~ Kiss on my Deity ~ Pure my Heart ~ - S&eacute;rie compl&egrave;te 6 OAV");
	$news->setDate("15/05/2011");
	$news->setAuthor("db0");
	$news->setCommentId(262);
	$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Tayutama Kiss on my Deity Pure my Heart serie complete chez Zero fansub !");
	$news->setMessage($newsMessage);
	$news->writeNow();
?>
<?php
	$newsMessage = new SimpleTextComponent();
	$newsMessage->addLine(new Image("images/series/potemayooav.jpg", "Potemayo"));
	$newsMessage->addLine();
	$newsMessage->addLine("Petit bonjour !");
	$newsMessage->addLine("Dans la suite de la s&eacute;rie Potemayo, voici la petite s&eacute;rie d'OAV. Au nombre de 6, ils sont disponibles en versions basses qialit&eacute; uniquement puisqu'ils ne sont pas sortis dans un autre format. D&eacute;sol&eacute;e !");
	$newsMessage->addLine("Amusez-vous bien !");
	$newsMessage->addLine();
	
	$news = new News();
	$news->setTitle("Potemayo OAV - S&eacute;rie compl&egrave;te");
	$news->setDate("11/05/2011");
	$news->setAuthor("db0");
	$news->setCommentId(261);
	$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Potemayo serie complete chez Zero fansub !");
	$news->setMessage($newsMessage);
	$news->writeNow();
?>
<?php
	$newsMessage = new SimpleTextComponent();
	$newsMessage->addLine(new Image("images/series/potemayo.jpg", "Potemayo"));
	$newsMessage->addLine();
	$newsMessage->addLine("Bonjour le monde !");
	$newsMessage->addLine();
	$newsMessage->addLine("Tout comme pour Kujibiki Unbalance 2, nous avons enti&egrave;rement refait la s&eacute;rie Potemayo. Pour ceux qui suivaient la s&eacute;rie, seule les versions avi en petit format &eacute;taient disponible puisque c&#039;etait le format qu&#039;utilisait Kirei no Tsubasa, l&#039;&eacute;quipe qui nous a l&eacute;gu&eacute; le projet.");
	$newsMessage->addLine();
	$newsMessage->addLine("Du coup, la s&eacute;rie compl&egrave;te a &eacute;t&eacute; r&eacute;envod&eacute;e et on en a profit&eacute; pour ajouter quelques am&eacute;liorations.");
	$newsMessage->addLine();
	$newsMessage->addLine("Rendez-vous page 'Projet' sur le site pour t&eacute;l&eacute;charger les 12 &eacute;pisodes !");
	$newsMessage->addLine();
	$newsMessage->addLine("Et n&#039;oubliez pas : si vous avez une remarque, une question ou quoi que ce soit &agrave; nous dire, utilisez le syst&egrave;me de commentaires ! Nous vous r&eacute;pondrons avec plaisir.");
	$newsMessage->addLine();
	$newsMessage->addLine("Bons &eacute;pisodes, &agrave; tr&egrave;s bient&ocirc;t pour les 6 OAV suppl&eacute;mentaires Potemayo... et un petit bonjour &agrave; toi aussi !");
	$newsMessage->addLine();
	
	$news = new News();
	$news->setTitle("Potemayo - S&eacute;rie compl&egrave;te enti&eacute;rement refaite");
	$news->setDate("08/05/2011");
	$news->setAuthor("db0");
	$news->setCommentId(261);
	$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Potemayo serie complete chez Zero fansub !");
	$news->setMessage($newsMessage);
	$news->writeNow();
?>
<?php
	// rewrite the archive header as a footer
	$archives->writeNow();
?>