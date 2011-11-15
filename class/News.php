<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/
// TODO separate in a News (data) + NewsComponent (HTML)
class News extends SimpleBlockComponent {
	private $title = null;
	private $date = null;
	private $timestamp = null;
	private $author = null;
	private $message = null;
	private $commentAccess = null;
	private $twitterUrl = null;
	private $releasesOut = array();
	private $licensesOut = array();
	
	public function __construct() {
		$this->setClass("news");
		
		$this->title = new Title(null, 2);
		$this->title->setClass("title");
		$this->addComponent($this->title);
		
		$subtitle = new Title(null, 4);
		$subtitle->setClass("subtitle");
		$this->date = new SimpleTextComponent();
		$subtitle->addComponent($this->date);
		$subtitle->addComponent(" par ");
		$this->author = new SimpleTextComponent();
		$subtitle->addComponent($this->author);
		$this->addComponent($subtitle);
		
		$this->message = new SimpleTextComponent();
		$this->message->setClass("message");
		$this->addComponent($this->message);
		
		$this->addComponent(new Pin());
		
		$this->commentAccess = new SimpleTextComponent();
		$this->commentAccess->setClass("comment");
		$this->addComponent($this->commentAccess);

		$this->addComponent("~ ");
		$this->twitterUrl = new NewWindowLink(null, "Partager sur <img src='images/autre/logo_twitter.png' border='0' alt='twitter' />");
		$this->twitterUrl->setOnClick("javascript:pageTracker._trackPageview ('/outbound/twitter.com');");
		$this->addComponent($this->twitterUrl);
		$this->addComponent(" ou ");
		$this->addComponent("<a name='fb_share' type='button' share_url='http://zerofansub.net'></a>");
		$this->addComponent("<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>");
		$this->addComponent(" ~");
	}
	
	public function setTitle($title) {
		$this->title->setContent($title);
		$this->setTwitterUrl("http://twitter.com/home?status=[Zero] ".$title);
	}
	
	public function getTitle() {
		return $this->title->getContent();
	}
	
	public function getDate() {
		return $this->date->getContent();
	}
	
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
		$this->date->setContent(strftime("%d/%m/%Y", $timestamp));
	}
	
	public function getTimestamp() {
		return $this->timestamp;
	}
	
	public function setAuthor($author) {
		if ($author instanceof TeamMember) {
			$author = $author->getPseudo();
		}
		$this->author->setContent($author);
	}
	
	public function getAuthor() {
		return $this->author->getContent();
	}
	
	public function setMessage($message) {
		$this->message->clear();
		$this->message->addComponent($message);
	}
	
	public function getMessage() {
		$components = $this->message->getComponents();
		return $components[0];
	}
	
	private $commentClass = null;
	public function setCommentID($id) {
		if ($this->commentClass === null) {
			$this->commentClass = $this->commentAccess->getClass();
		}
		
		if ($id !== null) {
			$this->commentAccess->setClass($this->commentClass);
			$this->commentAccess->addComponent("~ ");
			$this->commentAccess->addComponent(new NewWindowLink("http://commentaires.zerofansub.net/t$id.htm", "Commentaires"));
			$this->commentAccess->addComponent(" - ");
			$this->commentAccess->addComponent(new NewWindowLink("http://commentaires.zerofansub.net/posting.php?mode=reply&t=$id", "Ajouter un commentaire"));
			$this->commentAccess->addComponent(" ~");
		}
		else {
			
			$this->commentAccess->setClass("hidden");
		}
	}
	
	public function setCommentUrl($url) {
		$this->commentUrl->setUrl($url);
	}
	
	public function getCommentUrl() {
		return $this->commentUrl->getUrl();
	}
	
	public function setCommentAddUrl($url) {
		$this->commentAddUrl->setUrl($url);
	}
	
	public function getCommentAddUrl() {
		return $this->commentAddUrl->getUrl();
	}
	
	public function setTwitterUrl($url) {
		$this->twitterUrl->setUrl($url);
	}
	
	public function getTwitterUrl() {
		return $this->twitterUrl->getUrl();
	}
	
	public function addReleasing($target) {
		// /!\ can be a release or a project (if a complete project is released)
		if ($target != null) {
			$this->releasesOut[] = $target;
		}
	}
	
	public function getReleasing() {
		return $this->releasesOut;
	}
	
	public function isReleasing() {
		return count($this->releasesOut) > 0;
	}
	
	public function addLicensing($target) {
		// /!\ can be a release or a project (if a complete project is licensed)
		if ($target != null) {
			$this->licensesOut[] = $target;
		}
	}
	
	public function getLicensing() {
		return $this->licensesOut;
	}
	
	public function isLicensing() {
		return count($this->licensesOut) > 0;
	}
	
	private static $allNews = null;
	public static function getAllNews() {
		if (News::$allNews === null) {
			$news = new News();
			$news->setTitle("Mitsudomoe 7+8");
			$news->setTimestamp(strtotime("14 November 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(275);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep7'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep8'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine("Ah, j'ai des nouvelles pour vous. Vous allez rire {^_^}. Il se trouve que ça fait un moment qu'on a fini les Mitsudomoe 7 & 8... et j'ai oublié de les sortir ! C'est marrant, hein ? {^o^}");
			$newsMessage->addLine();
			$newsMessage->addLine("Non ? Vous trouvez pas ? {°.°}?");
			$newsMessage->addLine();
			$newsMessage->addLine(new Image("images/news/aMort.png", "À mort !"));
			$newsMessage->addLine();
			$newsMessage->addComponent("OK, OK, j'arrête {\">_<}. S'il vous reste des cailloux de la dernière fois, vous pouvez me les jeter. Allez, pour me faire pardonner je vous file un accès rapide : ");
			$newsMessage->addLine(new ReleaseLink('mitsudomoe', array('ep7', 'ep8'), "Mitsudomoe 7 & 8"));
			$newsMessage->addLine();
			$newsMessage->addLine("J'en profite pour vous rappeler que le site est en cours de raffinage, et comme j'en ai fait beaucoup dernièrement (le lien rapide en est un ajout) il est possible que certains bogues me soient passés sous le nez. Aussi n'hésitez pas à me crier dessus si vous en trouvez {'^_^}.");
			$newsMessage->addLine();
			$newsMessage->addLine("Et si vous voulez nous aider (ou vous essayer au fansub), on cherche des traducteurs Anglais-Francais (ou Japonais pour ceux qui savent {^_^}) !");
			$newsMessage->addLine();
			$newsMessage->addLine("Sur ceux, bon visionnage {^_^}.");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Besoin de timeurs !");
			$news->setTimestamp(strtotime("11 October 2011"));
			$news->setAuthor(TeamMember::getMember(5));
			$news->setCommentId(273);
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine("Allez on enchaîne les news, la motivation est là... Mais elle va peut-être pas durer...");
			$newsMessage->addLine();
			$newsMessage->addLine("<span style='color:red;font-size:2em;'>On a besoin de votre aide !</span>");
			$newsMessage->addLine();
			$newsMessage->addLine(new Image("images/news/urgent.gif", "Au secours !"));
			$newsMessage->addLine();
			$newsMessage->addLine("On embauche des timeurs ! On n'en a pas assez et du coup chacun essaye de faire pour avoir un time à peu près correcte... Mais ce n'est pas la même chose quand quelqu'un s'y met à plein temps. C'est quelque chose qui nous ralentis beaucoup car, même si ce n'est pas difficile, ça demande du temps pour faire quelque chose de bien (en tout cas pour suivre notre charte qualité {^_^}). On a les outils, les connaissances, il ne manque plus que les personnes motivées !");
			$newsMessage->addLine();
			$newsMessage->addLine("Si vous êtes interessés, les candidatures sont ouvertes (cliquez sur <b>Recrutement</b> dans le menu à gauche) ! Si vous êtes soucieux du détail au point d'en faire chier vos amis, c'est un plus ! Oui on est des vrai SM à la Zéro {>.<}.");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan - Du neuf et du moins neuf");
			$news->setTimestamp(strtotime("10 October 2011"));
			$news->setAuthor(TeamMember::getMember(8));
			$news->setCommentId(272);
			$news->addReleasing(Project::getProject('kodomooav'));
			$news->addReleasing(Project::getProject('kodomofilm'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/pedobear.jpg", "Pedobear"));
			$newsMessage->addLine();
			$newsMessage->addLine("Sortie de la v3 de Kodomo no Jikan OAD.");
			$newsMessage->addLine();
			$newsMessage->addLine("Et le film Kodomo no Jikan, qu'on n'a pas abandonné, non, non... Même si l'envie était là.");
			$newsMessage->addLine("<small>Sazaju: Hein ? Quoi !? {'O_O}</small>");
			$newsMessage->addLine();
			$newsMessage->addLine("Bon matage et à bientôt pour la suite de Mitsudomoe.");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Nouvelles sorties, nouveaux projets, nouveaux bugs...");
			$news->setTimestamp(strtotime("26 September 2011"));
			$news->setAuthor(TeamMember::getMember(5));
			$news->setCommentId(271);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep4'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep5'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep6'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine("Bon... par où commencer... Dur dur, surtout que le moins réjouissant c'est pour ma pomme {'^_^}. En plus j'ai pas d'image pour vous, vous allez morfler. Alors allons-y gaiement !");
			$newsMessage->addLine(); // TODO replace double lines by CSS
			$newsMessage->addLine("Tout d'abord, sachez que le site est actuellement en cours de raffinage. Autrement dit, une révision complète du code est en cours. Par conséquent, si vous voyez des petites modifications par rapport à avant, c'est normal, mais dans l'ensemble il ne devrait pas y avoir de changement notable sur le site. Quel intérêt que j'en parle vous me direz... Tout simplement parce qu'il est possible que certaines pages boguent (ou bug, comme vous voulez), et si jamais vous en trouvez une, le mieux c'est de me le faire savoir directement par mail : <a href='mailto:sazaju@gmail.com'>sazaju@gmail.com</a>. Le raffinage étant en cours, il est possible que des pages qui fonctionnent maintenant ne fonctionnent pas plus tard, aussi ne soyez pas surpris. Je fais mon possible pour que ça n'arrive pas, mais si j'en loupe merci de m'aider à les repérer {^_^}.");
			$newsMessage->addLine();
			$newsMessage->addLine("Voilà, les mauvaises nouvelles c'est fini ! Passons aux réjoussances : 3 nouveaux épisodes de Mitsudomoe sont terminés (4 à 6). Si vous ne les voyez pas sur la page de la série... c'est encore de ma faute (lapidez-moi si vous voulez {;_;}). Si au contraire vous les voyez, alors profitez-en, ruez-vous dessus, parce que depuis le temps qu'on n'a pas fait de news vous devez avoir faim, non ? {^_°}");
			$newsMessage->addLine();
			$newsMessage->addLine("Allez, mangez doucement, ça se déguste les animes (purée j'ai la dalle maintenant {'>.<}). Cela dit, si vous en voulez encore, on a un bon dessert tout droit sorti du restau : Working!! fait désormais partie de nos futurs projets ! Certains doivent se dire qu'il y ont déjà goûté ailleurs... Mais non ! Parce que vous aurez droit aux deux saisons {^o^}v. Tout le monde le sait (surtout dans le Sud de la France), quand on a bien mangé, une sieste s'impose. Vous pourrez donc rejoindre la fille aux ondes dans son futon : Denpa Onna to Seishun Otoko vient aussi allonger la liste de nos projets ! On dit même qu'un projet mystère se faufile entre les membres de l'équipe...");
			$newsMessage->addLine();
			$newsMessage->addLine("Pour terminer, un petit mot sur notre charte qualité. Nous avons décidé de ne plus sortir de releases issues d'une version TV, mais de ne faire que des Blu-Ray. Bien entendu, on fera toujours attention aux petites connexions : nos encodeurs travaillent d'arrache pied pour vous fournir la meilleure vidéo dans le plus petit fichier. J'espère donc que vous apprécierez la qualité de nos futurs épisodes {^_^} (et que vous n'aurez pas trop de pages boguées {'-.-}).");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Hitohira - Série complète");
			$news->setTimestamp(strtotime("14 August 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(270);
			$news->addReleasing(Project::getProject('hitohira'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/hito1.jpg", "Hitohira"));
			$newsMessage->addLine();
			$newsMessage->addLine("Sortie de Hitohira, la série complète, 12 épisodes d'un coup !");
			$newsMessage->addLine();
			$newsMessage->addLine(new Image("images/news/hito2.jpg", "Hitohira"));
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Mitsudomoe 03");
			$news->setTimestamp(strtotime("05 August 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(269);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Mitsudomoe 03 chez Z%C3%A9ro fansub !");
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep3'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/episodes/mitsudomoe3.jpg", "Mitsudomoe"));
			$newsMessage->addLine();
			$newsMessage->addLine("Sortie de l'épisode 03 de Mitsudomoe.");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Toradora! SOS - Série complète 4 OAV");
			$news->setTimestamp(strtotime("26 July 2011"));
			$news->setAuthor(TeamMember::getMember(8));
			$news->setCommentId(268);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Toradora! SOS chez Zero fansub !");
			$news->addReleasing(Project::getProject('toradorasos'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/series/toradorasos.jpg", "Toradora SOS"));
			$newsMessage->addLine();
			$newsMessage->addLine("4 mini OAV délirants sur la bouffe, avec les personnages en taille réduite.");
			$newsMessage->addLine("C'est de la superproduction ^_^");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko");
			$news->setTimestamp(strtotime("23 July 2011"));
			$news->setAuthor(TeamMember::getMember(8));
			$news->setCommentId(267);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Isshoni Training Ofuro chez Zero fansub !");
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/bath.jpg", "Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko"));
			$newsMessage->addLine();
			$newsMessage->addLine("Nous avons appris qu'Ankama va diffuser &agrave; partir de la rentrée de septembre 2011 :");
			$newsMessage->addLine("Baccano, Kannagi et Tetsuwan Birdy Decode. Tous les liens on donc été retirés.");
			$newsMessage->addLine("On vous invite &agrave; cesser la diffusion de nos liens et &agrave; aller regarder la série sur leur site.");
			$newsMessage->addLine();
			$newsMessage->addLine("Sorties d'Isshoni Training Ofuro : Bathtime with Hinako & Hiyoko");
			$newsMessage->addLine();
			$newsMessage->addLine("3e volet des \"isshoni\", on apprend comment les Japonaises prennent leur bain, très intéressant...");
			$newsMessage->addLine("Avec en bonus, une petite séance de stretching...");
			$newsMessage->addLine();
			$newsMessage->addLine("Je ne sais pas s'il y aura une suite, mais si oui, je devine un peu le genre ^_^");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Recrutement traducteur");
			$news->setTimestamp(strtotime("04 July 2011"));
			$news->setAuthor(TeamMember::getMember(8));
			$news->setCommentId(266);
			$news->setTwitterUrl("http://twitter.com/home?status=Zero recherche un traducteur");
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/m1.jpg", "Mitsudomoe"));
			$newsMessage->addLine();
			$newsMessage->addLine("Nous avons urgemment besoin d'un trad pour Mitsudomoe !!");
			$newsMessage->addLine("S'il vous pla&icirc;t, pitié xD");
			$newsMessage->addLine("Notre edit s'impatiente et ne peux continuer la série, alors aidez-nous ^_^");
			$newsMessage->addLine("C'est pas souvent qu'on demande du renfort, mais l&agrave;, c'est devenu indispensable...");
			$newsMessage->addLine("Nous avons perdu un trad récemment, il ne nous en reste plus qu'un... et comble de malheur,  il n'a pas accroché &agrave; la série, mais je le remercie pour avoir quand m&ecirc;me traduit deux épisodes pour nous dépanner.");
			$newsMessage->addComponent("Des petits cours sont dispos ici : ");
			$link = new Link("http://forum.zerofansub.net/f221-Cours-br.htm", "Lien");
			$link->openNewWindow(true);
			$newsMessage->addComponent($link);
			$newsMessage->addLine(".");
			$newsMessage->addLine();
			$newsMessage->addComponent("Pour postuler, faites une candidatures &agrave; l'école : ");
			$link = new Link("http://ecole.zerofansub.net/?page=postuler", "Lien");
			$link->openNewWindow(true);
			$newsMessage->addComponent($link);
			$newsMessage->addLine(".");
			$newsMessage->addLine();
			$newsMessage->addLine(new Image("images/news/m2.jpg", "Mitsudomoe"));
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kannagi - Série complète");
			$news->setTimestamp(strtotime("19 June 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(264);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Kannagi serie complete chez Zero fansub !");
			$news->addReleasing(Project::getProject('kannagi'));
			$newsMessage = new SimpleTextComponent();
			$link = new Link("http://zerofansub.net/galerie/gal/Zero_fansub/Images/Kannagi/%5BZero%5DKannagi_Image63.jpg", new Image("images/news/kannagi.jpg", "Kannagi"));
			$link->openNewWindow(true);
			$newsMessage->addLine($link);
			$newsMessage->addLine();
			$newsMessage->addLine("Bonjour les amis !");
			$newsMessage->addLine("La série Kannagi est terminée !");
			$newsMessage->addLine("J&#039;éspère qu&#039;elle vous plaira.");
			$newsMessage->addLine("N&#039;hésitez pas &agrave; nous dire ce que vous en pensez dans les commentaires. C&#039;est en apprenant de ses erreurs qu&#039;on avance, après tout ;)");
			$newsMessage->addLine();
			$newsMessage->addLine("P.S.: Les karaokés sont nuls. Désolée !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Mitsudomoe 01 + 02");
			$news->setTimestamp(strtotime("27 May 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(263);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Mitsudomoe 01 + 02 chez Zero fansub !");
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep1'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep2'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/mitsu0102.jpg", "Mitsudomoe"));
			$newsMessage->addLine();
			$newsMessage->addLine("Bonjour les amis !");
			$newsMessage->addLine("Après des mois d'attente, les premiers épisodes de Mitsudomoe sont enfin disponibles !");
			$newsMessage->addLine("Quelques petits changements dans notre fa&ccedil;on de faire habituelle, on attend vos retours avec impatience ;)");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Tayutama ~ Kiss on my Deity ~ Pure my Heart ~ - Série complète 6 OAV");
			$news->setTimestamp(strtotime("15 May 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(262);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Tayutama Kiss on my Deity Pure my Heart serie complete chez Zero fansub !");
			$news->addReleasing(Project::getProject('tayutamapure'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/tayutamapure.jpg", "Tayutama ~ Kiss on my Deity ~ Pure my Heart ~"));
			$newsMessage->addLine();
			$newsMessage->addLine("On continue dans les séries complètes avec cette fois-ci la petite série de 6 OAV qui fait suite &agrave; la série Tayutama ~ Kiss on my Deity : les 'Pure my Heart'. Ils sont assez courts mais plut&ocirc;t dr&ocirc;le alors amusez-vous bien !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Potemayo OAV - Série complète");
			$news->setTimestamp(strtotime("11 May 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(261);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Potemayo serie complete chez Zero fansub !");
			$news->addReleasing(Project::getProject('potemayooav'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/series/potemayooav.jpg", "Potemayo"));
			$newsMessage->addLine();
			$newsMessage->addLine("Petit bonjour !");
			$newsMessage->addLine("Dans la suite de la série Potemayo, voici la petite série d'OAV. Au nombre de 6, ils sont disponibles en versions basses qialité uniquement puisqu'ils ne sont pas sortis dans un autre format. Désolée !");
			$newsMessage->addLine("Amusez-vous bien !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Potemayo - Série complète entiérement refaite");
			$news->setTimestamp(strtotime("08 May 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(261);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Potemayo serie complete chez Zero fansub !");
			$news->addReleasing(Project::getProject('potemayo'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/series/potemayo.jpg", "Potemayo"));
			$newsMessage->addLine();
			$newsMessage->addLine("Bonjour le monde !");
			$newsMessage->addLine();
			$newsMessage->addLine("Tout comme pour Kujibiki Unbalance 2, nous avons entièrement refait la série Potemayo. Pour ceux qui suivaient la série, seule les versions avi en petit format étaient disponible puisque c&#039;etait le format qu&#039;utilisait Kirei no Tsubasa, l&#039;équipe qui nous a légué le projet.");
			$newsMessage->addLine();
			$newsMessage->addLine("Du coup, la série complète a été réenvodée et on en a profité pour ajouter quelques améliorations.");
			$newsMessage->addLine();
			$newsMessage->addLine("Rendez-vous page 'Projet' sur le site pour télécharger les 12 épisodes !");
			$newsMessage->addLine();
			$newsMessage->addLine("Et n&#039;oubliez pas : si vous avez une remarque, une question ou quoi que ce soit &agrave; nous dire, utilisez le système de commentaires ! Nous vous répondrons avec plaisir.");
			$newsMessage->addLine();
			$newsMessage->addLine("Bons épisodes, &agrave; très bient&ocirc;t pour les 6 OAV supplémentaires Potemayo... et un petit bonjour &agrave; toi aussi !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kujibiki Unbalance 2 - Série complète entiérement refaite");
			$news->setTimestamp(strtotime("02 May 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(260);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Kujibiki Unbalance 2 serie complete chez Zero Fansub !");
			$news->addReleasing(Project::getProject('kujibiki'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new AutoFloatImage("images/news/kujiend.jpg", "Kujibiki Unbalance 2"));
			$newsMessage->addLine("La s&eacute;rie Kujibiki Unbalance 2 a enti&eacute;rement &eacute;t&eacute; refaite !");
			$newsMessage->addLine("Les polices illisibles ont &eacute;t&eacute; chang&eacute;es, les panneaux stylis&eacute;s ont &eacute;t&eacute; refait, la traduction a &eacute;t&eacute; revue, bref, une jolie s&eacute;rie compl&egrave;te vous attend !");
			$newsMessage->addLine();
			$newsMessage->addLine("Pour t&eacute;l&eacute;charger les &eacute;pisodes, c'est comme d'habitude :");
			$newsMessage->addLine("- Page projet, liens DDL,");
			$newsMessage->addLine("- Sur notre tracker Torrent (restez en seed !)");
			$newsMessage->addLine("- Sur le XDCC de notre chan irc (profitez-en pour nous dire bonjour :D)");
			$newsMessage->addLine();
			$newsMessage->addLine("Petite info importante :");
			$newsMessage->addLine("Cette s&eacute;rie est comp&eacute;tement ind&eacute;pendante, n'a rien a voir avec la premi&eacute;re saison de Kujibiki Unbalance ni avec la s&eacute;rie Genshiken et il n'est pas n&eacute;cessaire d'avoir vu celles-ci pour appr&eacute;cier cette petite s&eacute;rie.");
			$newsMessage->addLine();
			$newsMessage->addLine("Si vous avez aim&eacute; la s&eacute;rie, si vous avez des remarques &agrave; nous faire ou autre, n'h&eacute;sitez pas &agrave; nous en faire part ! (Commentaires, Forum, Mail, IRC, ...)");
			$newsMessage->addLine();
			$newsMessage->addLine("&Agrave; tr&eacute;s bient&ocirc;t pour Potemayo !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kodomo no Natsu Jikan");
			$news->setTimestamp(strtotime("11 April 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(259);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Kodomo no Natsu Jikan chez Zero fansub !");
			$news->addReleasing(Project::getProject('kodomonatsu'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/kodomonatsu1.jpg", "Kujibiki Unbalance 2"));
			$newsMessage->addLine("Rin, Kuro et Mimi sont de retour dans un OAV Sp&eacute;cial de Kodomo no Jikan : Kodomo no Natsu Jikan ! Elles sont toutes les trois absulument adorables dans leurs maillots de bains d'&eacute;t&eacute;, en vacances avec Aoki et Houin.");
			$newsMessage->addLine();
			$newsMessage->addLine(new Image("images/news/kodomonatsu2.jpg", "Kujibiki Unbalance 2"));
			$newsMessage->addLine(new Image("images/news/kodomonatsu3.jpg", "Kujibiki Unbalance 2"));
			$newsMessage->addLine(new Image("images/news/kodomonatsu4.jpg", "Kujibiki Unbalance 2"));
			$newsMessage->addLine(new Image("images/news/kodomonatsu5.jpg", "Kujibiki Unbalance 2"));
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Licence de L&#039;entrainement avec Hinako + Sortie de Akina To Onsen et Faisons l'amour ensemble &eacute;pisode 05");
			$news->setTimestamp(strtotime("08 March 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(252);
			$news->setTwitterUrl("http://twitter.com/home?status=Deux hentai : Akina To Onsen et Issho ni H shiyo chez Zero fansub !");
			$news->addReleasing(Project::getProject('akinahshiyo'));
			$news->addReleasing(Release::getRelease('hshiyo', 'ep5'));
			$news->addLicensing(Project::getProject('training'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new AutoFloatImage("images/news/issho5.jpg", "Akina To Onsen De H Shiyo"));
			$newsMessage->addLine();
			$newsMessage->addLine("Dans la suite de notre reprise tant attendue, on ne rel&#226;che pas le rythme ! Apr&#232;s la sortie d'un genre classique chez Z&#233;ro, on poursuit avec l'une de nos sp&#233;cialit&#233;s : <i>Faisons l'amour ensemble</i> revient en force avec un nouvel &#233;pisode (de quoi combler les d&#233;&#231;us du 4e opus) et un &#233;pisode bonus !");
			$newsMessage->addLine();
			$newsMessage->addLine("Tout d'abord, ce 5e &#233;pisode nous sort le grand jeu : la petite s&#339;ur est dans la place ! Apr&#232;s plusieurs ann&#233;es sans nouvelles de son grand fr&#232;re, voil&#224; qu'elle a bien grandi et d&#233;cide donc de taper l'incruste. Voil&#224; une bonne occasion de faire le m&#233;nage (les filles sont dou&#233;es pour &#231;a {^.^}~). &#192; la suite de quoi une bonne douche s'impose... Et si on la prenait ensemble comme au bon vieux temps, <i>oniichan</i> ?");
			$newsMessage->addLine();
			$newsMessage->addLine("Pour ceux qui auraient encore des r&#233;serves (faut dire qu'on vous a donn&#233; le temps pour {^_^}), un &#233;pisode bonus aux sources chaudes vous attend ! Akina, cette jeune demoiselle du premier &#233;pisode, revient nous saluer avec son charme g&#233;n&#233;reux et son c&#244;t&#233; ivre toujours aussi mignon. Vous en d&#233;gusterez bien un morceau apr&#232;s le bain, non ?");
			$newsMessage->addLine();
			$newsMessage->addLine(new Image("images/series/akinahshiyo.jpg", "Akina To Onsen De H Shiyo"));
			$newsMessage->addLine();
			$newsMessage->addLine("db0 dit : Et pour finir, une nouvelle assez inattendue : La licence de L'entra&#238;nement avec Hinako chez Kaze. On vous tiendra au courant quand le DVD sortira.");
			$newsMessage->addLine();
			$newsMessage->addLine(new Image("images/news/training.gif", "Isshoni Training"));
			$newsMessage->addLine();
			$newsMessage->addLine("En parlant de Kaze, j'ai re&#231;u hier par la poste le Blu-ray de Canaan chez Kaze. Vous avez aim&#233; la s&#233;rie ? Faites comme moi, achetez-le !");
			$newsMessage->addLine();
			$newsMessage->addLine(new Image("images/news/canaanli.jpg", "DVD canaan buy kaze"));
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Issho Ni H Shiyo OAV 04 - Fin !");
			$news->setTimestamp(strtotime("13 July 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(237);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Issho Ni H Shiyo OAV 04 - Fin ! http://zerofansub.net/");
			$news->addReleasing(Release::getRelease('hshiyo', 'ep4'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new AutoFloatImage("images/news/hshiyonew.png", "Issho ni H Shiyo oav  4 fin de la serie interdit aux moins de 18 ans."));
			$newsMessage->addLine();
			$newsMessage->addLine("DÃ©ception intense ! AprÃ¨s de jolis Ã©pisodes, c'est avec regret que je vous annonce la sortie de ce quatriÃ¨me et dernier opus, qui retombe dans de banals stÃ©rÃ©otypes H sans une once d'originalitÃ© ni de qualitÃ© graphique : gros seins surrÃ©alistes, personnages prÃ©visibles Ã  souhaits, et comble du comble un final Ã  la \"je jouis mais faisons pour que Ã§a n'en ait pas l'air\" ! Alors que les Ã©pisodes prÃ©cÃ©dents nous offraient de somptueux ralentis et des mouvements de corps langoureux pour un plaisir savourÃ© jusqu'Ã  la derniÃ¨re goutte, ce dernier Ã©pisode nous marquera (hÃ©las) par sa simplicitÃ© grotesque et son manque de plaisir Ã©vident.");
			$newsMessage->addLine();
			$newsMessage->addLine("Mais rÃ©jouissez-vous ! La sÃ©rie Ã©tant finie, nous n'aurons plus l'occasion d'assister Ã  une autre erreur mettant en doute la qualitÃ© de cette derniÃ¨re : les plus pointilleux pourront sauvagement se dessÃ©cher sur les prÃ©cÃ©dents Ã©pisodes sans jamais voir le dernier, alors que ceux qui auront pitiÃ© de notre travail pourront gaspiller leur bande passante Ã  tÃ©lÃ©charger le torchon qui sert de final Ã  cette sÃ©rie qui ne le mÃ©rite pourtant pas.");
			$newsMessage->addLine();
			$newsMessage->addLine("Merci Ã  tous de nous avoir suivi sur cette sÃ©rie, et je vous souhaite tout le plaisir du monde Ã  sauvegarder votre temps en revisionnant un des Ã©pisodes prÃ©cÃ©dents plutÃ´t que celui-ci {^_^}.");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("KissXsis 03");
			$news->setTimestamp(strtotime("24 June 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(233);
			$news->addReleasing(Release::getRelease('kissxsis', 'ep3'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/kissxsis3news.jpg", "KissXsis kiss x sis DVD Blu-Ray Jaquette"));
			$newsMessage->addLine("On peut dire qu'il s'est fait attendre cet Ã©pisode...");
			$newsMessage->addLine("Mais le voilÃ  enfin, et c'est tout ce qui compte.");
			$newsMessage->addLine("Vous devez vous demander ce qu'il advient de notre annonce de sortie une semaine/un Ã©pisode pour kissxsis.");
			$newsMessage->addLine("Vous avez remarquÃ© que c'est un echec. Pourquoi ? Les Ã©pisodes s'avÃ¨rent bien plus longs Ã  rÃ©aliser que prÃ©vu si on souhaite continuer Ã  vous fournir la meilleure qualitÃ© possible. De plus, j'Ã©tais dans ma pÃ©riode de fin d'annÃ©e scolaire et j'ai dÃ» mettre de cÃ´tÃ© nos chÃ¨res soeurs jumelles pour Ãªtre sÃ»re de passer en annÃ©e supÃ©rieure...!");
			$newsMessage->addLine();
			$newsMessage->addLine("Une nouvelle qui ne vous fera peut-Ãªtre pas plaisir, mais qui j'Ã©spÃ¨re ne vous dÃ©couragera pas de mater les soeurettes un peu plus tard : Nous avons l'intention d'attendre la sortie des Blu-Ray des autres Ã©pisodes avant de continuer KissXsis. La qualitÃ© des vidÃ©os sera meilleure, il y aura moins de censure, plus de dÃ©tails, bref, plus de plaisir !<br />
Le premier Blu-Ray contenant les 3 premiers Ã©pisodes vient tout juste de sortir et nous sortirons bientÃ´t des nouvelles versions de ces trois premiers. Croyez-moi, Ã§a en vaut la peine. Vous ne me croyiez pas ? <a href='http://www.sankakucomplex.com/2010/06/24/kissxsis-erotic-climax-dvd-ero-upgrades-highly-salacious/' target='_blank'>Petit lien</a>.");
			$newsMessage->addLine();
			$newsMessage->addLine("Et pour ne pas parler que de KissXsis, sachez qu'une petite surprise que je vous ai personnellement concoctÃ© devrait bientÃ´t sortir...<br />
En ce qui concerne les autres projets, nous devrions nous concentrer sur Kujian en attendant les Blu-Ray de KissXsis et boucler certains vieux projets comme Sketchbook, Kodomo no Jikan (le film) ou Tayutama.");
			$newsMessage->addLine();
			$newsMessage->addLine("En ce qui concerne l'Ã©cole du fansub, elle va trÃ¨s bien et le nombre d'Ã©lÃ¨ve augmente chaque jour, les exercices et les cours aussi ! Si vous Ãªtes intÃ©rÃ©ssÃ©s, vous savez oÃ¹ nous trouver : sur le forum ZÃ©ro fansub.");
			$newsMessage->addLine();
			$newsMessage->addLine("Bonne chance Ã  ceux qui sont en examens, et que ceux qui sont en vacances en profite bien. Moi, je suis en vacances :p");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Mitsudomoe, Bande-Annonce");
			$news->setTimestamp(strtotime("15 June 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(231);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep0'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine('<object width="550" height="309"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=12592506&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ffffff&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=12592506&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ffffff&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="550" height="309"></embed></object>');
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kiss X Sis TV 02");
			$news->setTimestamp(strtotime("04 May 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(228);
			$news->addReleasing(Release::getRelease('kissxsis', 'ep2'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/kissxsis2.jpg"));
			$newsMessage->addLine("Ako et Riko ne laisseront pas Keita rater ses examens ! Ako décident donc de donner des cours particulier à Keita.");
			$newsMessage->addLine("Ils y resteront très sages et se contenteront d'apprendre sagement l'anglais, l'histoire et les maths. C'est tout.");
			$newsMessage->addLine("Vous vous attendiez à autre chose, peut-être ?");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kiss X Sis TV 01");
			$news->setTimestamp(strtotime("17 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(225);
			$news->addReleasing(Release::getRelease('kissxsis', 'ep1'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/newskissxsis1.jpg"));
			$newsMessage->addLine("Yo !");
			$newsMessage->addLine("Ako et Riko sont ENFIN de retour, cette fois-ci dans une série complète.");
			$newsMessage->addLine("Il y aura donc plus de scénario, mais toujours autant de ecchi.");
			$newsMessage->addLine("C'est bien une suite des OAV, mais il n'est pas nécéssaire des les avoir vus pour suivre la série.");
			$newsMessage->addLine("J'ai essayé de faire des jolis karaokés, alors chantez !! (Et envoyez les vidéos)");
			$newsMessage->addLine("À très vite pour l'épisode 2.");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("S'endormir avec Hinako (Issho ni Sleeping) OAV");
			$news->setTimestamp(strtotime("08 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(209);
			$news->addReleasing(Project::getProject('sleeping'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new AutoFloatImage("images/news/pcover1.gif"));
			$newsMessage->addLine("Salut toi, c'est Hinako !<br />
Tu m'as tellement manquer depuis notre entraînement, tout les deux...<br />
Tu te souviens ? Flexions, extensions ! Une, deux, une deux !<br />
Grâce à toi, j'ai perdu du poids, et toi aussi, non ?<br />
Tu sais, cette nuit, je dors toute seule, chez moi, et ça me rend triste...<br />
Quoi ? C'est vrai ? Tu veux bien dormir avec moi !?<br />
Oh merci ! Je savais que je pouvais compter sur toi.<br />
Alors, à tout à l'heure, quand tu auras télécharger l'épisode ;)");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("KissXsis 02");
			$news->setTimestamp(strtotime("06 December 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(153);
			$news->addReleasing(Release::getRelease('kissxsisoav', 'ep2'));
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine("<img src='images/news/kiss2.png' /><br />
Ah, elles nous font bien attendre, les deux jolies jumelles... Des mois pour sortir les OAV ! Mais au final, ça en vaut la peine, donc on ne peut pas leur en vouloir. C'est bientôt Noël, donc pour l'occasion, elles ont sortis des cosplays très mignons des \"soeurs de Noël\". Elles sont de plus en plus ecchi avec leur frère. Finira-t-il par craquer !? La première version sort ce soir, les autres versions de plus haute qualité sortieront dans la nuit et demain. J'éspère que cet OAV vous plaira ! Une série est annoncée en plus des OAV. Info ou Intox ? Dans tout les cas, Zéro sera de la partie, donc suivez aussi la série avec nous !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;
	}
		
		return News::$allNews;
	}
	
	public static function getAllReleasingNews() {
		$array = array();
		foreach(News::getAllNews() as $news) {
			if ($news->isReleasing()) {
				$array[] = $news;
			}
		}
		return $array;
	}
}
?>
