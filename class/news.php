<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/

class News extends SimpleBlockComponent {
	private $title = null;
	private $date = null;
	private $author = null;
	private $message = null;
	private $commentUrl = null;
	private $commentAddUrl = null;
	private $twitterUrl = null;
	
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
		
		$footer = new SimpleTextComponent();
		$footer->setClass("footer");
		$footer->addLine();
		$footer->addComponent("~ ");
		$this->commentUrl = new NewWindowLink(null, "Commentaires");
		$footer->addComponent($this->commentUrl);
		$footer->addComponent(" - ");
		$this->commentAddUrl = new NewWindowLink(null, "Ajouter un commentaire");
		$footer->addComponent($this->commentAddUrl);
		$footer->addComponent(" ~");
		$footer->addLine();
		$footer->addComponent("~ ");
		$this->twitterUrl = new NewWindowLink(null, "Partager sur <img src='images/autre/logo_twitter.png' border='0' alt='twitter' />");
		$this->twitterUrl->setOnClick("javascript:pageTracker._trackPageview ('/outbound/twitter.com');");
		$footer->addComponent($this->twitterUrl);
		$footer->addComponent(" ou ");
		$footer->addComponent("<a name='fb_share' type='button' share_url='http://zerofansub.net'></a>");
		$footer->addComponent("<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>");
		$footer->addComponent(" ~");
		$footer->addLine();
		$this->addComponent($footer);
	}
	
	public function setTitle($title) {
		$this->title->setContent($title);
	}
	
	public function getTitle() {
		return $this->title->getContent();
	}
	
	public function setDate($date) {
		$this->date->setContent($date);
	}
	
	public function getDate() {
		return $this->date->getContent();
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
	
	public function setCommentID($id) {
		if ($id !== null) {
			$this->setCommentUrl("http://commentaires.zerofansub.net/t$id.htm");
			$this->setCommentAddUrl("http://commentaires.zerofansub.net/posting.php?mode=reply&t=$id");
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
	
	private static $allNews = null;
	public static function getAllNews() {
		if (News::$allNews === null) {
			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine("Bon... par où commencer... Dur dur, surtout que le moins réjouissant c'est pour ma pomme {'^_^}. En plus j'ai pas d'image pour vous, vous allez morfler. Alors allons-y gaiement !");
			$newsMessage->addLine();
			$newsMessage->addLine("Tout d'abord, sachez que le site est actuellement en cours de raffinage. Autrement dit, une révision complète du code est en cours. Par conséquent, si vous voyez des petites modifications par rapport à avant, c'est normal, mais dans l'ensemble il ne devrait pas y avoir de changement notable sur le site. Quel intérêt que j'en parle vous me direz... Tout simplement parce qu'il est possible que certaines pages boguent (ou bug, comme vous voulez), et si jamais vous en trouvez une, le mieux c'est de me le faire savoir directement par mail : <a href='mailto:sazaju@gmail.com'>sazaju@gmail.com</a>. Le raffinage étant en cours, il est possible que des pages qui fonctionnent maintenant ne fonctionnent pas plus tard, aussi ne soyez pas surpris. Je fais mon possible pour que ça n'arrive pas, mais si j'en loupe merci de m'aider à les repérer {^_^}.");
			$newsMessage->addLine();
			$newsMessage->addLine("Voilà, les mauvaises nouvelles c'est fini ! Passons aux réjoussances : 3 nouveaux épisodes de Mitsudomoe sont terminés (4 à 6). Si vous ne les voyez pas sur la page de la série... c'est encore de ma faute (lapidez-moi si vous voulez {;_;}). Si au contraire vous les voyez, alors profitez-en, ruez-vous dessus, parce que depuis le temps qu'on n'a pas fait de news vous devez avoir faim, non ? {^_°}");
			$newsMessage->addLine();
			$newsMessage->addLine("Allez, mangez doucement, ça se déguste les animes (purée j'ai la dalle maintenant {'>.<}). Cela dit, si vous en voulez encore, on a un bon dessert tout droit sorti du restau : Working!! fait désormais partie de nos futurs projets ! Certains doivent se dire qu'il y ont déjà goûté ailleurs... Mais non ! Parce que vous aurez droit aux deux saisons {^o^}v. Tout le monde le sait (surtout dans le Sud de la France), quand on a bien mangé, une sieste s'impose. Vous pourrez donc rejoindre la fille aux ondes dans son futon : Denpa Onna to Seishun Otoko vient aussi allonger la liste de nos projets ! On dit même qu'un projet mystère se faufile entre les membres de l'équipe...");
			$newsMessage->addLine();
			$newsMessage->addLine("Pour terminer, un petit mot sur notre charte qualité. Nous avons décidé de ne plus sortir de releases issues d'une version TV, mais de ne faire que des Blu-Ray. Bien entendu, on fera toujours attention aux petites connexions : nos encodeurs travaillent d'arrache pied pour vous fournir la meilleure vidéo dans le plus petit fichier. J'espère donc que vous apprécierez la qualité de nos futurs épisodes {^_^} (et que vous n'aurez pas trop de pages boguées {'-.-}).");
			
			$news = new News();
			$news->setTitle("Nouvelles sorties, nouveaux projets, nouveaux bugs...");
			$news->setDate("26/09/2011");
			$news->setAuthor(TeamMember::getMember(5));
			$news->setCommentId(null); //TODO
			$news->setTwitterUrl(null); // TODO
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/hito1.jpg", "Hitohira"));
			$newsMessage->addLine();
			$newsMessage->addLine("Sortie de Hitohira, la s&eacute;rie compl&egrave;te, 12 &eacute;pisodes d'un coup !");
			$newsMessage->addLine();
			$newsMessage->addLine(new Image("images/news/hito2.jpg", "Hitohira"));
			
			$news = new News();
			$news->setTitle("Hitohira - S&eacute;rie compl&egrave;te");
			$news->setDate("14/08/2011");
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(270);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Hitohira serie complete chez Z%C3%A9ro fansub !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/episodes/mitsudomoe3.jpg", "Mitsudomoe"));
			$newsMessage->addLine();
			$newsMessage->addLine("Sortie de l'&eacute;pisode 03 de Mitsudomoe.");
			
			$news = new News();
			$news->setTitle("Mitsudomoe 03");
			$news->setDate("05/08/2011");
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(269);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Mitsudomoe 03 chez Z%C3%A9ro fansub !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/series/toradorasos.jpg", "Toradora SOS"));
			$newsMessage->addLine();
			$newsMessage->addLine("4 mini OAV d&eacute;lirants sur la bouffe, avec les personnages en taille r&eacute;duite.");
			$newsMessage->addLine("C'est de la superproduction ^_^");
			
			$news = new News();
			$news->setTitle("Toradora! SOS - S&eacute;rie compl&egrave;te 4 OAV");
			$news->setDate("26/07/2011");
			$news->setAuthor(TeamMember::getMember(8));
			$news->setCommentId(268);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Toradora! SOS chez Zero fansub !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

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
			
			$news = new News();
			$news->setTitle("Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko");
			$news->setDate("23/07/2011");
			$news->setAuthor(TeamMember::getMember(8));
			$news->setCommentId(267);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Isshoni Training Ofuro chez Zero fansub !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

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
			
			$news = new News();
			$news->setTitle("Recrutement traducteur");
			$news->setDate("04/07/2011");
			$news->setAuthor(TeamMember::getMember(8));
			$news->setCommentId(266);
			$news->setTwitterUrl("http://twitter.com/home?status=Zero recherche un traducteur");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

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
			
			$news = new News();
			$news->setTitle("Kannagi - S&eacute;rie compl&egrave;te");
			$news->setDate("19/06/2011");
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(264);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Kannagi serie complete chez Zero fansub !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/mitsu0102.jpg", "Mitsudomoe"));
			$newsMessage->addLine();
			$newsMessage->addLine("Bonjour les amis !");
			$newsMessage->addLine("Apr&egrave;s des mois d'attente, les premiers &eacute;pisodes de Mitsudomoe sont enfin disponibles !");
			$newsMessage->addLine("Quelques petits changements dans notre fa&ccedil;on de faire habituelle, on attend vos retours avec impatience ;)");
			
			$news = new News();
			$news->setTitle("Mitsudomoe 01 + 02");
			$news->setDate("27/05/2011");
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(263);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Mitsudomoe 01 + 02 chez Zero fansub !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/news/tayutamapure.jpg", "Tayutama ~ Kiss on my Deity ~ Pure my Heart ~"));
			$newsMessage->addLine();
			$newsMessage->addLine("On continue dans les s&eacute;ries compl&egrave;tes avec cette fois-ci la petite s&eacute;rie de 6 OAV qui fait suite &agrave; la s&eacute;rie Tayutama ~ Kiss on my Deity : les 'Pure my Heart'. Ils sont assez courts mais plut&ocirc;t dr&ocirc;le alors amusez-vous bien !");
			
			$news = new News();
			$news->setTitle("Tayutama ~ Kiss on my Deity ~ Pure my Heart ~ - S&eacute;rie compl&egrave;te 6 OAV");
			$news->setDate("15/05/2011");
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(262);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Tayutama Kiss on my Deity Pure my Heart serie complete chez Zero fansub !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

			$newsMessage = new SimpleTextComponent();
			$newsMessage->addLine(new Image("images/series/potemayooav.jpg", "Potemayo"));
			$newsMessage->addLine();
			$newsMessage->addLine("Petit bonjour !");
			$newsMessage->addLine("Dans la suite de la s&eacute;rie Potemayo, voici la petite s&eacute;rie d'OAV. Au nombre de 6, ils sont disponibles en versions basses qialit&eacute; uniquement puisqu'ils ne sont pas sortis dans un autre format. D&eacute;sol&eacute;e !");
			$newsMessage->addLine("Amusez-vous bien !");
			
			$news = new News();
			$news->setTitle("Potemayo OAV - S&eacute;rie compl&egrave;te");
			$news->setDate("11/05/2011");
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(261);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Potemayo serie complete chez Zero fansub !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;

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
			
			$news = new News();
			$news->setTitle("Potemayo - S&eacute;rie compl&egrave;te enti&eacute;rement refaite");
			$news->setDate("08/05/2011");
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(261);
			$news->setTwitterUrl("http://twitter.com/home?status=Sortie de Potemayo serie complete chez Zero fansub !");
			$news->setMessage($newsMessage);
			News::$allNews[] = $news;
	}
		
		return News::$allNews;
	}
}
?>
