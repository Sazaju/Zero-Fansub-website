<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/
class News {
	private $title = null;
	private $timestamp = null;
	private $author = null;
	private $message = null;
	private $commentAccess = null;
	private $commentId = null;
	private $twitterTitle = null;
	private $releasesOut = array();
	private $licensesOut = array();
	private $displayInNormalMode = null;
	private $displayInHentaiMode = null;
	private $isTeamNews = null;
	private $isPartnerNews = null;
	
	public function __construct($title = null, $message = null) {
		$this->setTitle($title);
		$this->setMessage($message);
		$this->setTimestamp(time());
	}
	
	public function setPartnerNews($boolean) {
		$this->isPartnerNews = $boolean;
	}
	
	public function isPartnerNews() {
		return $this->isPartnerNews;
	}
	
	public function setTeamNews($boolean) {
		$this->isTeamNews = $boolean;
	}
	
	public function isTeamNews() {
		return $this->isTeamNews;
	}
	
	public function setDisplayInHentaiMode($boolean) {
		$this->displayInHentaiMode = $boolean;
	}
	
	public function displayInHentaiMode() {
		return $this->displayInHentaiMode;
	}
	
	public function setDisplayInNormalMode($boolean) {
		$this->displayInNormalMode = $boolean;
	}
	
	public function displayInNormalMode() {
		return $this->displayInNormalMode;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTimestamp($timestamp) {
		$this->timestamp = intval($timestamp);
	}
	
	public function getTimestamp() {
		return $this->timestamp;
	}
	
	public function setAuthor($author) {
		if ($author instanceof TeamMember) {
			$author = $author->getPseudo();
		}
		$this->author = $author;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function setMessage($message) {
		$this->message = $message;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	public function setCommentID($id) {
		$this->commentId = $id;
	}
	
	public function getCommentID() {
		return $this->commentId;
	}
	
	public function setTwitterTitle($title) {
		$this->twitterTitle = $title;
	}
	
	public function getTwitterTitle() {
		return $this->twitterTitle;
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
			$news->setTitle("Recrutement Boku Tomo");
			$news->setTimestamp(strtotime("25 January 2012 15:02"));
			$news->setAuthor(TeamMember::getMemberByPseudo("praia"));
			$news->setMessage("Le trad et l'adapt qui auraient dû s'occuper de Boku wa tomodachi ga Sukunai
ne sont plus disponibles, devant affronter les aléas de la vie...

On cherche donc avec une certaine urgence un trad, un adapt et un timeur pour cette série...

Oui, un timeur aussi, car celle qui devait s'en occuper n'a plus le temps.

expérience requise pour le time, non pas parce qu'on ne forme pas,
vu qu'on forme, mais parce que ça commence à être chiant de passer
plus de temps à former des gens qui ne timent pas grand-chose au final
que de timer soi-même lol");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setCommentId(285);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("MegaUpload hors service");
			$news->setTimestamp(strtotime("23 January 2012 13:29"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(284);
			$news->setTeamNews(true);
			$message = new SimpleTextComponent();
			$message->addLine("Pour ceux qui utilisent nos liens MegaUpload, ces derniers jours vous avez sûrement dû avoir du mal, voire vous êtes tombés sur une image comme celle-ci :");
			$message->addLine();
			$message->addLine(new Image("images/news/fbi.jpg", "Avertissement FBI"));
			$message->addLine();
			$message->addLine("En effet MegaUpload est sous le joug d'une enquête gouvernementale (en Amérique), du coup la majorité de leurs liens (si ce n'est tous) sont hors service, et cela pour une durée indeterminée.");
			$message->addLine();
			$message->addLine("Pour télécharger nos épisodes il vous faudra donc vous retrancher sur le DDL, les torrents et autres solutions disponibles.");
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("V3.3 du site !");
			$news->setTimestamp(strtotime("23 January 2012 01:48"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(283);
			$news->setTeamNews(true);
			$message = new SimpleTextComponent();
			$message->addLine("Ces derniers jours, le raffinage du site a pas mal avancé, et on en est désormais à la version 3.3+ du site. '+' parce que la version 3.3 s'est faite Samedi et que depuis j'ai encore raffiné une quantité assez phénoménale de données (j'y ai passé tout mon weekend). Du coup la version 3.4 ne devrait pas trop tarder à voir le jour (mais je ne donne pas de date, vu que de toute façon je n'ai aucune raison de la respecter {^.^}~). En bref, le raffinage est quasiment terminé.");
			$message->addLine();
			$message->addLine("\\{^o^}/ Banzai !");
			$message->addLine();
			$message->addLine("Néanmoins vous me direz peut-être <i>elle est où la différence ?</i>. Si vous vous posez la question, tant mieux pour moi, ça veut dire que j'ai bien fait mon boulot {^_^}. Le but du raffinage est en effet de réécrire le code, la mise en page du site n'est donc pas sensée changer de manière notable.");
			$message->addLine();
			$message->addLine("J'en profite tout de même pour vous faire un petit topo sur ce qu'il en est :");
			$message->addLine();
			$message->addLine("* <b>Toutes les pages projets</b>, incluant toutes les releases, ont été refaites. Autrement dit plusieurs centaines de fichiers on été factorisés (c'est ce dont je me réjouis le plus, parce que contenant des tonnes de données et hyper répétitifs, donc le plus chiant à faire). La version 3.2 (que peu ont dû voir passer {^_^}) sonnait le glas du raffinage des releases. Cette nouvelle version sonne celui du raffinage des projets.");
			$message->addLine();
			$message->addLine("* <b>Presque toutes les news</b> ont été raffinées. Sur les 6 vues disponibles, il me reste les 3 dernières, en sachant que ce sont de très loin les plus petites et qu'il y a quelques doublons avec les précédentes.");
			$message->addLine();
			$message->addLine("* La plupart des autres pages du site ont été refaites. En mettant de côté les pages gérées à part, il reste les <b>dossiers et galleries d'images</b> à faire.");
			$message->addLine();
			$message->addLine("* Le site profite désormais d'un peu plus <b>d'affichage dynamique</b> (contenu changé à la volée). Certaines fonctionnalités peuvent donc être implémentées pour rendre le site un peu plus intelligent, mais encore rien d'extraordinaire vu que les données sont toujours écrites en dur (et non en base de données). En gros, on n'a pas encore de dynamisme sur les données (on ne peut pas modifier un titre par exemple), mais on en a sur leur présentation (afficher/cacher, changer les couleurs/dimensions, ...) avec possibilité de mémorisation (grâce aux sessions et cookies, bien que ces derniers ne soient pas encore utilisés). Le point suivant montre un exemple d'application.");
			$message->addLine();
			$message->addLine("* La section H se retrouve désormais <b>fusionnée</b> à la section tout public, donc il n'y a plus de différence entre les deux. Le passage entre section H et tout public se fait un peu différemment par rapport à avant : désormais vous êtes soit en mode <i>tout public</i>, soit en mode <i>hentai</i>, <b>quelque soit la page</b> (et non certaines pages tout public et d'autres hentai, comme ça se faisait avant). Cela permet une gestion bien plus souple et précise de l'accès aux contenus adultes. Le passage de l'un à l'autre se fait en premier lieu via le menu de gauche, avec le <b>lien <i>Hentai</i></b> pour passer en mode hentai, qui se retrouve remplacé par un <b>lien <i>Tout public</i></b> qui refait passer en mode tout public. Le passage se fait aussi lorsque c'est nécessaire (accès à un projet hentai sans être en mode hentai). Selon le mode, les projets affichés sont les projets correspondants (la liste habituelle ou les projets H). Il en est de même pour les news (pour celles déjà raffinées). Le passage au mode hentai se fait toujours via un avertissement, l'inverse en revanche est direct. Quand vous refusez de passer en mode hentai, vous retournez à la page précédente (à l'index pour les accès directs).");
			$message->addLine();
			$message->addLine("Il me semble que c'est à peu près tout... Ah oui, si vous avez des soucis sur certaines pages du site, c'est toujours moi qu'il faut venir engueuler {^_^}. Regardez du côté du lien <i>Signaler un bug</i> dans le menu de gauche. Sur ce, bon leech.");
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Un peu de repos");
			$news->setTimestamp(strtotime("18 January 2012 14:26"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(282);
			$news->setTeamNews(true);
			$message = new SimpleTextComponent();
			$message->addLine("Une petite news pour les autres équipes de fansub et pour nos habitués : étant donné le nombre d'animes licenciés et le nombre d'animes restant non fansubbés, Zéro Fansub ne prévoit pas d'ajouter de nouveaux projets à sa liste pour cette saison.");
			$message->addLine();
			$message->addLine("On en profitera pour avancer correctement nos séries déjà en cours, dont certaines sont sur le feu depuis un moment déjà {'^_^}.");
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Encore des bugs ?");
			$news->setTimestamp(strtotime("4 January 2012"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(281);
			$news->setTeamNews(true);
			$message = new SimpleTextComponent();
			$message->addLine("Juste une petite news informative. Beaucoup savent déjà que s'il y a un bug, c'est de ma faute. Cela dit, mon mail il faut le trouver (et oui c'est dur d'aller voir dans la page équipe, c'est qu'il faut réfléchir et les leecheurs aiment pas ça). Pour vous simplifier la vie, si vous avez le moindre problème, un lien <i>Signaler un bug</i> est désormais disponible dans le menu de gauche.");
			$message->addLine();
			$message->addLine("Non seulement je vous demande de me jeter des cailloux, mais en plus je vous dit où viser pour faire mal. C'est pas beau ça ? {^_^}");
			$message->addLine(new Image("images/news/working_punch.jpg", "Frappez-moi !"));
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Bonne année !");
			$news->setTeamNews(false);
			$news->setTimestamp(strtotime("1 January 2012"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(280);
			$message = new SimpleTextComponent();
			$message->addLine("Bonne année à tous ! En espérant que le raffinage du site avance vite pour enfin vous (et nous) fournir un site plus pratique {^_^}°.");
			$message->addLine();
			$message->addLine(new Image("images/news/newYear2012.jpg", "Bonne année 2012 !"));
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("ATTENTION : Raffinage massif !");
			$news->setTeamNews(true);
			$news->setTimestamp(strtotime("31 December 2011 02:44"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(279);
			$message = new SimpleTextComponent();
			$message->addLine("Note importante : beaucoup de raffinage a été fait dernièrement. En particulier la structure des fichiers a été retouché, certains fichiers ont même été remplacés (probablement à cause de quelques problèmes CRC). Quelques-uns ont été vérifié, mais pas tous. Aussi, si vous téléchargez des fichiers qui semblent corrompus, faites-le-moi savoir au plus vite. C'est probablement de ma faute.");
			$message->addLine();
			$message->addLine("Vous pouvez laisser des commentaires, sinon je redonne mon mail : <a href='mailto:sazaju@gmail.com'>sazaju@gmail.com</a>");
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Issho ni H Shiyo 6");
			$news->setDisplayInHentaiMode(true);
			$news->setDisplayInNormalMode(false);
			$news->setTimestamp(strtotime("28 December 2011 19:17"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(278);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('hshiyo', 'ep6'));
			$message = new SimpleTextComponent();
			$message->addLine(new AutoFloatImage("images/news/hshiyo6.png", "J'ado~re les concombres !"));
			$message->addLine("Et voilà un nouvel opus (ou deux nouveaux obus, au choix) de notre H favori. Enfin je dis favori mais comme c'est moi qui fais la news, je vais avant tout donner mon avis {^_^}.");
			$message->addLine();
			$message->addLine("Vous avez aimé le 4 (pas le précédent, celui d'avant, que j'avais détruit dans ma news) ? Si oui alors réjouissez-vous, celui-ci est du même acabit. Ceux qui sont du même avis que moi, en revanche, passez votre chemin. Pour faire court : on se fait une vache à lait à la campagne. Les grosses mamelles sont de la partie, même si ce ne sont pas elles qui donneront le 'lait' de l'épisode.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement pour le site");
			$news->setTimestamp(strtotime("24 December 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(276);
			$news->setTeamNews(true);
			$message = new SimpleTextComponent();
			$message->addLine("Salut tout le monde ! {^_^}");
			$message->addLine();
			$message->addLine("Voilà un gros mois sans news, vous devez donc vous dire <i>enfin une sortie !</i> pas vrai ? Ben désolé de casser l'ambiance, mais non pas pour tout de suite {'^_^}.");
			$message->addLine();
			$message->addLine(new Image("images/news/angry.jpg", "Quoi ?"));
			$message->addLine("<small>Non pas taper ! {'>_<}</small>");
			$message->addLine();
			$message->addLine("Comme certains d'entre-vous le savent, je suis en train de raffiner le site, et cela prends du temps. Si pas mal de choses ont été développées pour l'instant, encore reste-t-il à les appliquer au site, et c'est ça qui est long. C'est donc pour ça que je viens à vous {^_^}.");
			$message->addLine();
			$message->addLine("Je cherche quelqu'un qui s'y connaît un minimum en HTML/CSS/PHP. Inutile d'être un expert, je demande juste d'avoir déjà utilisé un peu ces langages, dire qu'on se comprenne si je parles de style, de balise et de parcourir des tableaux. Si vous avez déjà programmé en objet (PHP, Java, C++ ou autre) c'est un plus. Notez qu'il faut aussi savoir <i>retoucher</i> des images. Ce que j'entends par là est simplement savoir redimensionner, couper, coller, rassembler des images en une seule, ... le b.a.-ba donc. Si des compétences plus avancées sont nécessaires, je peux vous les apprendre avec Gimp. De même si vous avez des questions sur le code, c'est tout à votre honneur {^_^}.");
			$message->addLine();
			$message->addLine("Je tiens quand même à poser une contrainte : je cherche quelqu'un de motivé, qui aime coder. Je ne veux pas dire par là que c'est difficile, mais je veux quelqu'un sur qui je puisse compter sur la longueur. Il ne faut pas être disponible tout le temps, mais je ne veux pas voir quelqu'un qui après une semaine me dise <i>j'ai plus le temps</i>. Ce sont toutes des petites tâches qui peuvent se faire un peu n'importe quand, donc c'est très flexible, mais il faut les faire.");
			$message->addLine();
			$message->addLine("Si vous êtes intéressés, passez dans la section recrutement (lien dans le menu de gauche).");
			$message->addLine();
			$message->addLine("NB : vous voyez, j'ai même pas le temps de vous faire une news décente en cette veille de Noël, pour vous dire comme j'ai besoin de quelqu'un {;_;}.");
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Mitsudomoe 7+8");
			$news->setDisplayInHentaiMode(false);
			$news->setDisplayInNormalMode(true);
			$news->setTimestamp(strtotime("14 November 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(275);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep7'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep8'));
			$message = new SimpleTextComponent();
			$message->addLine("Ah, j'ai des nouvelles pour vous. Vous allez rire {^_^}. Il se trouve que ça fait un moment qu'on a fini les Mitsudomoe 7 & 8... et j'ai oublié de les sortir ! C'est marrant, hein ? {^o^}");
			$message->addLine();
			$message->addLine("Non ? Vous trouvez pas ? {°.°}?");
			$message->addLine();
			$message->addLine(new Image("images/news/aMort.png", "À mort !"));
			$message->addLine();
			$message->addComponent("OK, OK, j'arrête {\">_<}. S'il vous reste des cailloux de la dernière fois, vous pouvez me les jeter. Allez, pour me faire pardonner je vous file un accès rapide : ");
			$message->addLine(new ReleaseLink('mitsudomoe', array('ep7', 'ep8'), "Mitsudomoe 7 & 8"));
			$message->addLine();
			$message->addLine("J'en profite pour vous rappeler que le site est en cours de raffinage, et comme j'en ai fait beaucoup dernièrement (le lien rapide en est un ajout) il est possible que certains bogues me soient passés sous le nez. Aussi n'hésitez pas à me crier dessus si vous en trouvez {'^_^}.");
			$message->addLine();
			$message->addLine("Et si vous voulez nous aider (ou vous essayer au fansub), on cherche des traducteurs Anglais-Francais (ou Japonais pour ceux qui savent {^_^}) !");
			$message->addLine();
			$message->addLine("Sur ceux, bon visionnage {^_^}.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Besoin de timeurs !");
			$news->setTimestamp(strtotime("11 October 2011"));
			$news->setAuthor(TeamMember::getMember(5));
			$news->setCommentId(273);
			$news->setTeamNews(true);
			$message = new SimpleTextComponent();
			$message->addLine("Allez on enchaîne les news, la motivation est là... Mais elle va peut-être pas durer...");
			$message->addLine();
			$message->addLine("<span style='color:red;font-size:2em;'>On a besoin de votre aide !</span>");
			$message->addLine();
			$message->addLine(new Image("images/news/urgent.gif", "Au secours !"));
			$message->addLine();
			$message->addLine("On embauche des timeurs ! On n'en a pas assez et du coup chacun essaye de faire pour avoir un time à peu près correcte... Mais ce n'est pas la même chose quand quelqu'un s'y met à plein temps. C'est quelque chose qui nous ralentis beaucoup car, même si ce n'est pas difficile, ça demande du temps pour faire quelque chose de bien (en tout cas pour suivre notre charte qualité {^_^}). On a les outils, les connaissances, il ne manque plus que les personnes motivées !");
			$message->addLine();
			$message->addLine("Si vous êtes interessés, les candidatures sont ouvertes (cliquez sur <b>Recrutement</b> dans le menu à gauche) ! Si vous êtes soucieux du détail au point d'en faire chier vos amis, c'est un plus ! Oui on est des vrai SM à la Zéro {>.<}.");
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan - Du neuf et du moins neuf");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("10 October 2011"));
			$news->setAuthor(TeamMember::getMember(8));
			$news->setCommentId(272);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomooav', 'oav'));
			$news->addReleasing(Release::getRelease('kodomofilm', 'film'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/news/pedobear.jpg", "Pedobear"));
			$message->addLine();
			$message->addLine("Sortie de la v3 de Kodomo no Jikan OAD.");
			$message->addLine();
			$message->addLine("Et le film Kodomo no Jikan, qu'on n'a pas abandonné, non, non... Même si l'envie était là.");
			$message->addLine("<small>Sazaju: Hein ? Quoi !? {'O_O}</small>");
			$message->addLine();
			$message->addLine("Bon matage et à bientôt pour la suite de Mitsudomoe.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Nouvelles sorties, nouveaux projets, nouveaux bugs...");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("26 September 2011"));
			$news->setAuthor(TeamMember::getMember(5));
			$news->setCommentId(271);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep4'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep5'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep6'));
			$message = new SimpleTextComponent();
			$message->addLine("Bon... par où commencer... Dur dur, surtout que le moins réjouissant c'est pour ma pomme {'^_^}. En plus j'ai pas d'image pour vous, vous allez morfler. Alors allons-y gaiement !");
			$message->addLine(); // TODO replace double lines by CSS
			$message->addLine("Tout d'abord, sachez que le site est actuellement en cours de raffinage. Autrement dit, une révision complète du code est en cours. Par conséquent, si vous voyez des petites modifications par rapport à avant, c'est normal, mais dans l'ensemble il ne devrait pas y avoir de changement notable sur le site. Quel intérêt que j'en parle vous me direz... Tout simplement parce qu'il est possible que certaines pages boguent (ou bug, comme vous voulez), et si jamais vous en trouvez une, le mieux c'est de me le faire savoir directement par mail : <a href='mailto:sazaju@gmail.com'>sazaju@gmail.com</a>. Le raffinage étant en cours, il est possible que des pages qui fonctionnent maintenant ne fonctionnent pas plus tard, aussi ne soyez pas surpris. Je fais mon possible pour que ça n'arrive pas, mais si j'en loupe merci de m'aider à les repérer {^_^}.");
			$message->addLine();
			$message->addLine("Voilà, les mauvaises nouvelles c'est fini ! Passons aux réjoussances : 3 nouveaux épisodes de Mitsudomoe sont terminés (4 à 6). Si vous ne les voyez pas sur la page de la série... c'est encore de ma faute (lapidez-moi si vous voulez {;_;}). Si au contraire vous les voyez, alors profitez-en, ruez-vous dessus, parce que depuis le temps qu'on n'a pas fait de news vous devez avoir faim, non ? {^_°}");
			$message->addLine();
			$message->addLine("Allez, mangez doucement, ça se déguste les animes (purée j'ai la dalle maintenant {'>.<}). Cela dit, si vous en voulez encore, on a un bon dessert tout droit sorti du restau : Working!! fait désormais partie de nos futurs projets ! Certains doivent se dire qu'il y ont déjà goûté ailleurs... Mais non ! Parce que vous aurez droit aux deux saisons {^o^}v. Tout le monde le sait (surtout dans le Sud de la France), quand on a bien mangé, une sieste s'impose. Vous pourrez donc rejoindre la fille aux ondes dans son futon : Denpa Onna to Seishun Otoko vient aussi allonger la liste de nos projets ! On dit même qu'un projet mystère se faufile entre les membres de l'équipe...");
			$message->addLine();
			$message->addLine("Pour terminer, un petit mot sur notre charte qualité. Nous avons décidé de ne plus sortir de releases issues d'une version TV, mais de ne faire que des Blu-Ray. Bien entendu, on fera toujours attention aux petites connexions : nos encodeurs travaillent d'arrache pied pour vous fournir la meilleure vidéo dans le plus petit fichier. J'espère donc que vous apprécierez la qualité de nos futurs épisodes {^_^} (et que vous n'aurez pas trop de pages boguées {'-.-}).");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Hitohira - Série complète");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("14 August 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(270);
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('hitohira'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/news/hito1.jpg", "Hitohira"));
			$message->addLine();
			$message->addLine("Sortie de Hitohira, la série complète, 12 épisodes d'un coup !");
			$message->addLine();
			$message->addLine(new Image("images/news/hito2.jpg", "Hitohira"));
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Mitsudomoe 03");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("05 August 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(269);
			$news->setTwitterTitle("Sortie de Mitsudomoe 03 chez Z%C3%A9ro fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep3'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/episodes/mitsudomoe3.jpg", "Mitsudomoe"));
			$message->addLine();
			$message->addLine("Sortie de l'épisode 03 de Mitsudomoe.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Toradora! SOS - Série complète 4 OAV");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("26 July 2011"));
			$news->setAuthor(TeamMember::getMember(8));
			$news->setCommentId(268);
			$news->setTwitterTitle("Sortie de Toradora! SOS chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('toradorasos'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/series/toradorasos.jpg", "Toradora SOS"));
			$message->addLine();
			$message->addLine("4 mini OAV délirants sur la bouffe, avec les personnages en taille réduite.");
			$message->addLine("C'est de la superproduction ^_^");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Recrutement traducteur");
			$news->setTimestamp(strtotime("04 July 2011"));
			$news->setAuthor(TeamMember::getMember(8));
			$news->setCommentId(266);
			$news->setTeamNews(true);
			$news->setTwitterTitle("Zero recherche un traducteur");
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/news/m1.jpg", "Mitsudomoe"));
			$message->addLine();
			$message->addLine("Nous avons urgemment besoin d'un trad pour Mitsudomoe !!");
			$message->addLine("S'il vous pla&icirc;t, pitié xD");
			$message->addLine("Notre edit s'impatiente et ne peux continuer la série, alors aidez-nous ^_^");
			$message->addLine("C'est pas souvent qu'on demande du renfort, mais là, c'est devenu indispensable...");
			$message->addLine("Nous avons perdu un trad récemment, il ne nous en reste plus qu'un... et comble de malheur,  il n'a pas accroché à la série, mais je le remercie pour avoir quand même traduit deux épisodes pour nous dépanner.");
			$message->addComponent("Des petits cours sont dispos ici : ");
			$link = new Link("http://forum.zerofansub.net/f221-Cours-br.htm", "Lien");
			$link->openNewWindow(true);
			$message->addComponent($link);
			$message->addLine(".");
			$message->addLine();
			$message->addComponent("Pour postuler, faites une candidatures à l'école : ");
			$link = new Link("http://ecole.zerofansub.net/?page=postuler", "Lien");
			$link->openNewWindow(true);
			$message->addComponent($link);
			$message->addLine(".");
			$message->addLine();
			$message->addLine(new Image("images/news/m2.jpg", "Mitsudomoe"));
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kannagi - Série complète");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("19 June 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(264);
			$news->setTwitterTitle("Sortie de Kannagi serie complete chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('kannagi'));
			$message = new SimpleTextComponent();
			$link = new Link("http://zerofansub.net/galerie/gal/Zero_fansub/Images/Kannagi/%5BZero%5DKannagi_Image63.jpg", new Image("images/news/kannagi.jpg", "Kannagi"));
			$link->openNewWindow(true);
			$message->addLine($link);
			$message->addLine();
			$message->addLine("Bonjour les amis !");
			$message->addLine("La série Kannagi est terminée !");
			$message->addLine("J'éspère qu'elle vous plaira.");
			$message->addLine("N'hésitez pas à nous dire ce que vous en pensez dans les commentaires. C'est en apprenant de ses erreurs qu'on avance, après tout ;)");
			$message->addLine();
			$message->addLine("P.S.: Les karaokés sont nuls. Désolée !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Mitsudomoe 01 + 02");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("27 May 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(263);
			$news->setTwitterTitle("Sortie de Mitsudomoe 01 + 02 chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep1'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep2'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/news/mitsu0102.jpg", "Mitsudomoe"));
			$message->addLine();
			$message->addLine("Bonjour les amis !");
			$message->addLine("Après des mois d'attente, les premiers épisodes de Mitsudomoe sont enfin disponibles !");
			$message->addLine("Quelques petits changements dans notre façon de faire habituelle, on attend vos retours avec impatience ;)");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Tayutama ~ Kiss on my Deity ~ Pure my Heart ~ - Série complète 6 OAV");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("15 May 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(262);
			$news->setTwitterTitle("Sortie de Tayutama Kiss on my Deity Pure my Heart serie complete chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('tayutamapure'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/news/tayutamapure.jpg", "Tayutama ~ Kiss on my Deity ~ Pure my Heart ~"));
			$message->addLine();
			$message->addLine("On continue dans les séries complètes avec cette fois-ci la petite série de 6 OAV qui fait suite à la série Tayutama ~ Kiss on my Deity : les 'Pure my Heart'. Ils sont assez courts mais plutôt drôle alors amusez-vous bien !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Potemayo OAV - Série complète");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("11 May 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(261);
			$news->setTwitterTitle("Sortie de Potemayo serie complete chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('potemayooav'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/series/potemayooav.jpg", "Potemayo"));
			$message->addLine();
			$message->addLine("Petit bonjour !");
			$message->addLine("Dans la suite de la série Potemayo, voici la petite série d'OAV. Au nombre de 6, ils sont disponibles en versions basses qialité uniquement puisqu'ils ne sont pas sortis dans un autre format. Désolée !");
			$message->addLine("Amusez-vous bien !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Potemayo - Série complète entiérement refaite");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("08 May 2011"));
			$news->setAuthor(TeamMember::getMember(1));
			$news->setCommentId(261);
			$news->setTwitterTitle("Sortie de Potemayo serie complete chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('potemayo'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/series/potemayo.jpg", "Potemayo"));
			$message->addLine();
			$message->addLine("Bonjour le monde !");
			$message->addLine();
			$message->addLine("Tout comme pour Kujibiki Unbalance 2, nous avons entièrement refait la série Potemayo. Pour ceux qui suivaient la série, seule les versions avi en petit format étaient disponible puisque c'etait le format qu'utilisait Kirei no Tsubasa, l'équipe qui nous a légué le projet.");
			$message->addLine();
			$message->addLine("Du coup, la série complète a été réenvodée et on en a profité pour ajouter quelques améliorations.");
			$message->addLine();
			$message->addLine("Rendez-vous page 'Projet' sur le site pour télécharger les 12 épisodes !");
			$message->addLine();
			$message->addLine("Et n'oubliez pas : si vous avez une remarque, une question ou quoi que ce soit à nous dire, utilisez le système de commentaires ! Nous vous répondrons avec plaisir.");
			$message->addLine();
			$message->addLine("Bons épisodes, à très bientôt pour les 6 OAV supplémentaires Potemayo... et un petit bonjour à toi aussi !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kujibiki Unbalance 2 - Série complète entiérement refaite");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("02 May 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(260);
			$news->setTwitterTitle("Sortie de Kujibiki Unbalance 2 serie complete chez Zero Fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('kujibiki'));
			$message = new SimpleTextComponent();
			$message->addLine(new AutoFloatImage("images/news/kujiend.jpg", "Kujibiki Unbalance 2"));
			$message->addLine("La série Kujibiki Unbalance 2 a entiérement été refaite !");
			$message->addLine("Les polices illisibles ont été changées, les panneaux stylisés ont été refait, la traduction a été revue, bref, une jolie série complète vous attend !");
			$message->addLine();
			$message->addLine("Pour télécharger les épisodes, c'est comme d'habitude :");
			$message->addLine("- Page projet, liens DDL,");
			$message->addLine("- Sur notre tracker Torrent (restez en seed !)");
			$message->addLine("- Sur le XDCC de notre chan irc (profitez-en pour nous dire bonjour :D)");
			$message->addLine();
			$message->addLine("Petite info importante :");
			$message->addLine("Cette série est compétement indépendante, n'a rien a voir avec la premiére saison de Kujibiki Unbalance ni avec la série Genshiken et il n'est pas nécessaire d'avoir vu celles-ci pour apprécier cette petite série.");
			$message->addLine();
			$message->addLine("Si vous avez aimé la série, si vous avez des remarques à nous faire ou autre, n'hésitez pas à nous en faire part ! (Commentaires, Forum, Mail, IRC, ...)");
			$message->addLine();
			$message->addLine("à trés bientôt pour Potemayo !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kodomo no Natsu Jikan");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("11 April 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(259);
			$news->setTwitterTitle("Sortie de Kodomo no Natsu Jikan chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomonatsu', 'oav'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/news/kodomonatsu1.jpg", "Kujibiki Unbalance 2"));
			$message->addLine("Rin, Kuro et Mimi sont de retour dans un OAV Spécial de Kodomo no Jikan : Kodomo no Natsu Jikan ! Elles sont toutes les trois absulument adorables dans leurs maillots de bains d'été, en vacances avec Aoki et Houin.");
			$message->addLine();
			$message->addLine(new Image("images/news/kodomonatsu2.jpg", "Kujibiki Unbalance 2"));
			$message->addLine(new Image("images/news/kodomonatsu3.jpg", "Kujibiki Unbalance 2"));
			$message->addLine(new Image("images/news/kodomonatsu4.jpg", "Kujibiki Unbalance 2"));
			$message->addLine(new Image("images/news/kodomonatsu5.jpg", "Kujibiki Unbalance 2"));
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Licence de L'entrainement avec Hinako + Sortie de Akina To Onsen et Faisons l'amour ensemble épisode 05");
			$news->setTimestamp(strtotime("08 March 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(252);
			$news->setTwitterTitle("Deux hentai : Akina To Onsen et Issho ni H shiyo chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('akinahshiyo', 'oav'));
			$news->addReleasing(Release::getRelease('hshiyo', 'ep5'));
			$news->addLicensing(Release::getRelease('training', 'oav'));
			$message = new SimpleTextComponent();
			$message->addLine(new AutoFloatImage("images/news/issho5.jpg", "Akina To Onsen De H Shiyo"));
			$message->addLine();
			$message->addLine("Dans la suite de notre reprise tant attendue, on ne relâche pas le rythme ! Après la sortie d'un genre classique chez Zéro, on poursuit avec l'une de nos spécialités : <i>Faisons l'amour ensemble</i> revient en force avec un nouvel épisode (de quoi combler les déçus du 4e opus) et un épisode bonus !");
			$message->addLine();
			$message->addLine("Tout d'abord, ce 5e épisode nous sort le grand jeu : la petite s&#339;ur est dans la place ! Après plusieurs années sans nouvelles de son grand frère, voilà qu'elle a bien grandi et décide donc de taper l'incruste. Voilà une bonne occasion de faire le ménage (les filles sont douées pour ça {^.^}~). À la suite de quoi une bonne douche s'impose... Et si on la prenait ensemble comme au bon vieux temps, <i>oniichan</i> ?");
			$message->addLine();
			$message->addLine("Pour ceux qui auraient encore des réserves (faut dire qu'on vous a donné le temps pour {^_^}), un épisode bonus aux sources chaudes vous attend ! Akina, cette jeune demoiselle du premier épisode, revient nous saluer avec son charme généreux et son côté ivre toujours aussi mignon. Vous en dégusterez bien un morceau après le bain, non ?");
			$message->addLine();
			$message->addLine(new Image("images/series/akinahshiyo.jpg", "Akina To Onsen De H Shiyo"));
			$message->addLine();
			$message->addLine("db0 dit : Et pour finir, une nouvelle assez inattendue : La licence de L'entraînement avec Hinako chez Kaze. On vous tiendra au courant quand le DVD sortira.");
			$message->addLine();
			$message->addLine(new Image("images/news/training.gif", "Isshoni Training"));
			$message->addLine();
			$message->addLine("En parlant de Kaze, j'ai reçu hier par la poste le Blu-ray de Canaan chez Kaze. Vous avez aimé la série ? Faites comme moi, achetez-le !");
			$message->addLine();
			$message->addLine(new Image("images/news/canaanli.jpg", "DVD canaan buy kaze"));
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Issho Ni H Shiyo OAV 04 - Fin !");
			$news->setDisplayInNormalMode(false);
			$news->setDisplayInHentaiMode(true);
			$news->setTimestamp(strtotime("13 July 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(237);
			$news->setTwitterTitle("Sortie de Issho Ni H Shiyo OAV 04 - Fin ! http://zerofansub.net/");
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('hshiyo', 'ep4'));
			$message = new SimpleTextComponent();
			$message->addLine(new AutoFloatImage("images/news/hshiyonew.png", "Issho ni H Shiyo oav  4 fin de la serie interdit aux moins de 18 ans."));
			$message->addLine();
			$message->addLine("Déception intense ! Après de jolis épisodes, c'est avec regret que je vous annonce la sortie de ce quatrième et dernier opus, qui retombe dans de banals stéréotypes H sans une once d'originalité ni de qualité graphique : gros seins surréalistes, personnages prévisibles à souhaits, et comble du comble un final à la \"je jouis mais faisons pour que ça n'en ait pas l'air\" ! Alors que les épisodes précédents nous offraient de somptueux ralentis et des mouvements de corps langoureux pour un plaisir savouré jusqu'à la dernière goutte, ce dernier épisode nous marquera (hélas) par sa simplicité grotesque et son manque de plaisir évident.");
			$message->addLine();
			$message->addLine("Mais réjouissez-vous ! La série étant finie, nous n'aurons plus l'occasion d'assister à une autre erreur mettant en doute la qualité de cette dernière : les plus pointilleux pourront sauvagement se dessécher sur les précédents épisodes sans jamais voir le dernier, alors que ceux qui auront pitié de notre travail pourront gaspiller leur bande passante à télécharger le torchon qui sert de final à cette série qui ne le mérite pourtant pas.");
			$message->addLine();
			$message->addLine("Merci à tous de nous avoir suivi sur cette série, et je vous souhaite tout le plaisir du monde à sauvegarder votre temps en revisionnant un des épisodes précédents plutôt que celui-ci {^_^}.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("KissXsis 03");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("24 June 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(233);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kissxsis', 'ep3'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/news/kissxsis3news.jpg", "KissXsis kiss x sis DVD Blu-Ray Jaquette"));
			$message->addLine("On peut dire qu'il s'est fait attendre cet épisode...");
			$message->addLine("Mais le voilà enfin, et c'est tout ce qui compte.");
			$message->addLine("Vous devez vous demander ce qu'il advient de notre annonce de sortie une semaine/un épisode pour kissxsis.");
			$message->addLine("Vous avez remarqué que c'est un echec. Pourquoi ? Les épisodes s'avèrent bien plus longs à réaliser que prévu si on souhaite continuer à vous fournir la meilleure qualité possible. De plus, j'étais dans ma période de fin d'année scolaire et j'ai dû mettre de côté nos chères soeurs jumelles pour être sûre de passer en année supérieure...!");
			$message->addLine();
			$message->addLine("Une nouvelle qui ne vous fera peut-être pas plaisir, mais qui j'éspère ne vous découragera pas de mater les soeurettes un peu plus tard : Nous avons l'intention d'attendre la sortie des Blu-Ray des autres épisodes avant de continuer KissXsis. La qualité des vidéos sera meilleure, il y aura moins de censure, plus de détails, bref, plus de plaisir !<br />
Le premier Blu-Ray contenant les 3 premiers épisodes vient tout juste de sortir et nous sortirons bientôt des nouvelles versions de ces trois premiers. Croyez-moi, ça en vaut la peine. Vous ne me croyiez pas ? <a href='http://www.sankakucomplex.com/2010/06/24/kissxsis-erotic-climax-dvd-ero-upgrades-highly-salacious/' target='_blank'>Petit lien</a>.");
			$message->addLine();
			$message->addLine("Et pour ne pas parler que de KissXsis, sachez qu'une petite surprise que je vous ai personnellement concocté devrait bientôt sortir...<br />
En ce qui concerne les autres projets, nous devrions nous concentrer sur Kujian en attendant les Blu-Ray de KissXsis et boucler certains vieux projets comme Sketchbook, Kodomo no Jikan (le film) ou Tayutama.");
			$message->addLine();
			$message->addLine("En ce qui concerne l'école du fansub, elle va très bien et le nombre d'élève augmente chaque jour, les exercices et les cours aussi ! Si vous êtes intéréssés, vous savez où nous trouver : sur le forum Zéro fansub.");
			$message->addLine();
			$message->addLine("Bonne chance à ceux qui sont en examens, et que ceux qui sont en vacances en profite bien. Moi, je suis en vacances :p");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Mitsudomoe, Bande-Annonce");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("15 June 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(231);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep0'));
			$message = new SimpleTextComponent();
			$message->addLine('<object width="550" height="309"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=12592506&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ffffff&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=12592506&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ffffff&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="550" height="309"></embed></object>');
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kiss X Sis TV 02");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("04 May 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(228);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kissxsis', 'ep2'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/news/kissxsis2.jpg"));
			$message->addLine("Ako et Riko ne laisseront pas Keita rater ses examens ! Ako décident donc de donner des cours particulier à Keita.");
			$message->addLine("Ils y resteront très sages et se contenteront d'apprendre sagement l'anglais, l'histoire et les maths. C'est tout.");
			$message->addLine("Vous vous attendiez à autre chose, peut-être ?");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kiss X Sis TV 01");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("17 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(225);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kissxsis', 'ep1'));
			$message = new SimpleTextComponent();
			$message->addLine(new Image("images/news/newskissxsis1.jpg"));
			$message->addLine("Yo !");
			$message->addLine("Ako et Riko sont ENFIN de retour, cette fois-ci dans une série complète.");
			$message->addLine("Il y aura donc plus de scénario, mais toujours autant de ecchi.");
			$message->addLine("C'est bien une suite des OAV, mais il n'est pas nécéssaire des les avoir vus pour suivre la série.");
			$message->addLine("J'ai essayé de faire des jolis karaokés, alors chantez !! (Et envoyez les vidéos)");
			$message->addLine("À très vite pour l'épisode 2.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("S'endormir avec Hinako (Issho ni Sleeping) OAV");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("08 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(209);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('sleeping', 'oav'));
			$message = new SimpleTextComponent();
			$message->addLine(new AutoFloatImage("images/news/pcover1.gif"));
			$message->addLine("Salut toi, c'est Hinako !<br />
Tu m'as tellement manquer depuis notre entraînement, tout les deux...<br />
Tu te souviens ? Flexions, extensions ! Une, deux, une deux !<br />
Grâce à toi, j'ai perdu du poids, et toi aussi, non ?<br />
Tu sais, cette nuit, je dors toute seule, chez moi, et ça me rend triste...<br />
Quoi ? C'est vrai ? Tu veux bien dormir avec moi !?<br />
Oh merci ! Je savais que je pouvais compter sur toi.<br />
Alors, à tout à l'heure, quand tu auras télécharger l'épisode ;)");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("KissXsis 02");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("06 December 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(153);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kissxsisoav', 'ep2'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src='images/news/kiss2.png' /><br />
Ah, elles nous font bien attendre, les deux jolies jumelles... Des mois pour sortir les OAV ! Mais au final, ça en vaut la peine, donc on ne peut pas leur en vouloir. C'est bientôt Noël, donc pour l'occasion, elles ont sortis des cosplays très mignons des \"soeurs de Noël\". Elles sont de plus en plus ecchi avec leur frère. Finira-t-il par craquer !? La première version sort ce soir, les autres versions de plus haute qualité sortieront dans la nuit et demain. J'éspère que cet OAV vous plaira ! Une série est annoncée en plus des OAV. Info ou Intox ? Dans tout les cas, Zéro sera de la partie, donc suivez aussi la série avec nous !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Canaan 13 ~ Fin !");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("06 October 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(138);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('canaan', 'ep13'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/canaanfin.png\" /><br />
Ainsi se termine Canaan.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 12 + Piscine + Partenariats + Maboroshi + Kobato");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("04 October 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(137);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('canaan', 'ep12'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src='images/news/piscine.jpg' style='float: left;' />
Tout d'abord, la sortie du <b>12e épisode de Canaan</b>. On change complétement de décor par rapport aux précédents épisodes. Cet épisode est centré sur la relation entre Canaan et Alphard, ainsi que les pouvoirs de Canaan.<br /><br />
Ensuite, <b>db0 va a la piscine !</b> (Elle a mis son joli maillot de bain, et tout, comme sur l'image) Elle sera donc <b>absente du 5 au 26 octobre inclus</b>. En attendant, l'équipe Zéro va essayer de continuer à faire des sorties quand même, et c'est ryocu qui se chargera de faire les news.<br /><br />
Puis, deux nouveaux partenaires : <b>Gokuraku-no-fansub</b> et <b>Tanjou-fansub</b>.<br /><br />
Enfin, une bonne nouvelle. Si certains n'étaient pas au courant, j'annonce : <b>Maboroshi no fansub a réouvert ses portes</b>. L'incident de fermeture était dû à une mauvaise entente entre la personne qui hébergeait le site et le reste de l'équipe. J'ai repris les rênes ! C'est maintenant moi qui gère leur site. Du coup, il n'y a aucun risque de fermeture ou de mauvais entente :). Ils prennent un nouveau départ, et ont décidé de ne pas reprendre leurs anciens projets, sauf Hakushoku to Yousei dûe à la forte demande.<br /><br />
Pour finir, <b>Kobato</b>, dans la liste de nos projets depuis juin, ne se fera finalement pas. Kaze nous a devancé et a acheté la licence.");
			$news->setMessage($message);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 11");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("30 September 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(136);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('canaan', 'ep11'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src='images/news/canaan11.jpg'/><br />
Chose promise, chose due. Et en plus, on a même le droit à un peu de ecchi dans cet épisode ! Avec la tenue sexy de Liang Qi, on peut pas dire le contraire... Et un peu de necrophilie aussi. Ouais, c'est tout de suite moins sexy. (Enfin, chacun son truc, hein) Sankaku Complex en a parlé. Cet épisode est un peu triste, comme le précedent, mais un peu plus violent aussi.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 10");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("30 September 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(135);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('canaan', 'ep10'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src='images/news/canaan10.jpg' /><br />
Vous en rêviez ? Les fans l'ont dessiné... Est-ce que c'est ce qui va se passer dans la suite de l'anime ? Ça semble bien parti... Regardez vite l'épisode 10 pour le savoir ! Et comme on a trop envie de savoir la suite à la fin de cet épisode, je vous promets qu'il ne tardera pas.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 09 + Canaan Cosplays");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("25 September 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(130);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('canaan', 'ep9'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src='images/news/canaancos.jpg' /><br />
Je comptais sortir tout les épisodes en même temps, mais comme les autres prennent plus de temps que prévu, on va pas vous faire attendre plus longtemps et on vous propose dès maintenant l'épisode 09, prêt depuis longtemps. Comme vous pouvez le constater, l'équipe est très occupée en ce moment, donc entre deux irl, on taffe un peu fansub, mais ça reste pas grand chose.<br />
Je profite de cette news pour vous poster quelques photos de mon cosplay Canaan. Si vous voulez en savoir plus sur ce cosplay et mes autres, rendez-vous sur mon site perso cosplay : <a href='http://db0.dbcosplay.fr' target='_blank'>http://db0.dbcosplay.fr</a> (et abonnez-vous à la newsletter !)<br />
<a href='http://www.cosplay.com/photo/2268921/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2268921.jpg'></a> <a href='http://www.cosplay.com/photo/2268922/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2268922.jpg'></a> <a href='http://www.cosplay.com/photo/2268923/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2268923.jpg'></a> <a href='http://www.cosplay.com/photo/2274553/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274553.jpg'></a> <a href='http://www.cosplay.com/photo/2274515/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274515.jpg'></a> <a href='http://www.cosplay.com/photo/2274516/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274516.jpg'></a> <a href='http://www.cosplay.com/photo/2274517/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274517.jpg'></a> <a href='http://www.cosplay.com/photo/2274518/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274518.jpg'></a> <a href='http://www.cosplay.com/photo/2274519/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274519.jpg'></a> <a href='http://www.cosplay.com/photo/2274520/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274520.jpg'></a> <a href='http://www.cosplay.com/photo/2274521/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274521.jpg'></a> <a href='http://www.cosplay.com/photo/2274522/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274522.jpg'></a> <a href='http://www.cosplay.com/photo/2274523/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274523.jpg'></a> <a href='http://www.cosplay.com/photo/2274531/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274531.jpg'></a> <a href='http://www.cosplay.com/photo/2274532/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274532.jpg'></a> <a href='http://www.cosplay.com/photo/2274533/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274533.jpg'></a> <a href='http://www.cosplay.com/photo/2274536/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274536.jpg'></a> <a href='http://www.cosplay.com/photo/2274537/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274537.jpg'></a> <a href='http://www.cosplay.com/photo/2274538/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274538.jpg'></a> <a href='http://www.cosplay.com/photo/2274540/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274540.jpg'></a> <a href='http://www.cosplay.com/photo/2274541/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274541.jpg'></a> <a href='http://www.cosplay.com/photo/2274542/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274542.jpg'></a> <a href='http://www.cosplay.com/photo/2274543/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274543.jpg'></a> <a href='http://www.cosplay.com/photo/2274544/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274544.jpg'></a> <a href='http://www.cosplay.com/photo/2274554/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274554.jpg'></a> <a href='http://www.cosplay.com/photo/2274555/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274555.jpg'></a> <a href='http://www.cosplay.com/photo/2274556/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274556.jpg'></a> <a href='http://www.cosplay.com/photo/2274557/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274557.jpg'></a> <a href='http://www.cosplay.com/photo/2274560/' target='_blank'><img src='http://images.cosplay.com/thumbs/22/2274560.jpg'></a>");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 08");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("26 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(116);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('canaan', 'ep8'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src='images/news/canaan8.png' style='float: right;' />
Avec un peu de retard cette semaine, la suite de la trépidante histoire de Canaan, une fille pas comme les autres.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 06");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("11 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(112);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('canaan', 'ep6'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src='images/news/can6.jpg'><br />
Comme à son habitude, le petit épisode de Canaan de la semaine fait sa sortie. Et comme prévu, nous n'avons aucune réponse pour le recrutement traducteur T___T pourtant j'aime bien, moi, Mermaid Melody. C'est mignon.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 04 + 05 + Rythme Toradora!");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("06 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(109);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('canaan', 'ep4'));
			$news->addReleasing(Release::getRelease('canaan', 'ep5'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src='images/news/can45.jpg' alt='' /><br />
Des bunny girls, des blondasses, et tout ça qui se fait des câlins ! Si c'est pas mignon, tout ça ! Non, pas tant que ça, si on remet l'image dans le contexte. Je vous laisse découvrir tout ça dans la double sortie du jour. Double sortie, pourquoi ? Bah justement. J'ai bien envie de faire des news longues ses derniers temps, donc je vais vous expliquer ce que j'appelle \"le rythme Toradora!\".<br />
Pour ceux qui nous ont connus à l'époque Toradora!, à l'\"apogée\" de la carrière de Zéro, vous vous souvenez sans doute du rythme spéctaculaire auquel les sorties s'enchaînaient. C'était de l'ordre de une sortie tout les deux jours, voir tout les jours ! Pour vous, qui attendez sagement derrière vos écrans, c'est tout bénéf'. Mais ce que vous ne savez pas, c'est que ça travaille, derrière la machine. Nous ne sommes pas une équipe de Speedsub, alors comment réaliser un tel exploit sans perdre de la qualité des épisodes ? Non, non, nous ne savons toujours pas ralentir le temps. Quel est notre secret ? Tout d'abord, sachez qu'il faut minimum 20 heures de boulot pour sortir un épisode chez Zéro (traduction-adaptation-correction-edition-time-vérification finale) encodage non compris. Et que généralement, nous répartissons ses heures sur des semaines. Pour suivre le rythme Toradora!, c'est simple : Etaler ses 20 heures minimum (je dis bien minimum parce qu'en fait c'est beaucoup plus long) sur une seule journée. C'est-à-dire sacrifier une journée + une nuit. Pour Toradora!, suivre ce rythme n'était pas trop dur puisque nous étions en coproduction, ce qui nous permettait de faire des pauses de temps en temps dans ces looongues journées de fansub. Mais nous avons décidé de reprendre ce rythme, pour montrer à nos amis leechers que nous n'avons pas vieilli ! C'est pourquoi nous avons choisi un anime qui nous tient à coeur, à Ryocu et moi-même : Canaan. Ici, nous ne sommes pas en coproduction, mais comme nous sommes en vacances, nous pouvons nous permettre de sacrifier deux journées par épisode de Canaan. Oui, deux jours, car il me faut bien faire des pauses, et comme je m'occupe de tout sauf de la vérification finale et que je suis humaine, je ne peux pas me permettre de taffer 24h d'affilée sans faiblir un chouilla.<br />
Bref, je raconte pas tout ça pour me la péter, mais juste pour vous éxpliquer ce que représente un rythme acceléré pour une équipe de bon sub et pas de speedsub. Je raconte ça aussi parce que j'ai été déçu par des réactions de personnes qui se sont dit rapide = mauvais sub. Je vous prouve ici que nous travaillons dur pour vous !!<br />
Et là, je finirai sur une question qui vous turlupine depuis tout à l'heure : Comment se fait-il que vous ne nous sortiez ses épisodes que maintenant ? La réponse est simple : J'avais pas internet dans le trou paumé où je suis pour mes vacances :p<br />
Et histoire de craner un peu : Ryocu et moi passons de superbes vacances en bord de mer dans une grande maison avec piscine dont nous profitons entre deux Canaan.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Erreur Canaan 03");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("24 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(106);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('canaan', 'ep3'));
			$message = new SimpleTextComponent();
			$message->addLine("Sous la précipitation (train à prendre), j'ai envoyé le mauvais ass à lepims (notre encodeur) pour l'épisode 03 de Canaan, c'est-à-dire celui dont les fautes n'ont pas été corrigés, c'est-à-dire ma traduction telle quelle... Du coup, il a été réencoder, et la nouvelle version est téléchargeable à la place de l'ancienne. Toutes mes excuses !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 03 + Recrutement trad Hitohira");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("22 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("praia"));
			$news->setCommentId(106);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('canaan', 'ep3'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/hitocry.png\" style=\"float: right;\" />
Je lance cette bouteille à la mer en espérant que ce message parvienne aux oreilles d’une âme charitable… Nous recherchons désespérément une personne pour reprendre l’une de nos séries, j’ai nommé Hitohira. Nous n'avons rien à offrir, à part notre gratitude. Nous ne nous attendons pas à avoir beaucoup de réponses, voire rien du tout... Si par bonheur, vous êtes intéressé, n’hésitez pas à passer sur le forum, nous vous accueillerons sur un tapis rouge orné de fleurs xD<br /><br /><br /><br /><br /><br />
<img src=\"images/news/canaan-3.jpg\" border=\"0\" /><br />
Encore du ecchi dans la série Canaan ! Mais pas que ça, bien sûr. L'épisode 3 est disponible, amusez-vous bien~");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 02");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("19 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(103);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('canaan', 'ep2'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/oppaicanaan.png\" border=\"0\"><br />
Bah alors ? Zéro nous fait Canaan ? Mais Zéro, c'est une team de l'ecchi, non ? Bah en voilà un peu d'ecchi, dans cette série de brutes ^^ Alors, heureux ? Oui, très heureux. Snif. Tout ça pour dire que y'a l'épisode 02 prêt à être maté. Et vous savez quoi, les p'tits loulous ? Dans l'épisode 01, on comprenait pas toujours ce qu'il se passait. Dans l'épisode 02, on comprends ce qui s'est passé dans l'épisode 1 ! Hein ? Ça se passe toujours comme ça dans les séries sérieuses...? Ah, naruhodo...");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("KissXsis 01");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("28 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(77);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kissxsis', 'ep1'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/kissx1.jpg\" style=\"float:right;\" border=\"0\">
On vous l'avait promis, le v'là ! On a mis un peu de temps parce qu'on l'a traduit à moitié du Japonais, et forcément, ça prend plus de temps. J'espère qu'il vous plaira autant que le premier, parce qu'il dépasse les limites de l'ecchi !<br />
Demain : Epitanime ! J'veux tous vous y voir !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("L'entraînement avec Hinako (Isshoni Training)");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("28 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(65);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('training', 'oav'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/hinako.jpg\" border=\"0\"><br />L'été arrive à grand pas. C'est donc la saison des régimes ! Et qui dit régime, dit bonne alimentation mais aussi entraînement, musculation ! Mais comment arriver à faire bouger nos chers Otakus de leurs chaises...? Hinako a trouvé la solution ! Un entraînement composé de pompes, d'abdos et de flexions on ne peut plus ECCHI ECCHI ! Lancez-vous donc dans cette aventure un peu perverse et rejoignez Hinako dans sa séance de musculation. Et vous le faites, hein ? Hinako vous regarde ;)");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Joyeux Noël ! - OAV Kiss X Sis");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("24 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(24);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kissxsisoav', 'ep2'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/noel.jpg\" border=\"0\" /><br>Toute l'équipe Zéro vous souhaite à tous un joyeux noël, un bon réveillon, une bonne dinde, de bons chocolats, de beaux cadeaux et tout ce qui va avec.<br>Nos cadeaux pour vous :<br>- Une galerie d'images de Noël (dans les bonus)<br>- L'OAV de Kiss x sis !<br>Dans la liste de nos projets depuis cet été, initialement prévu en septembre... Au final, il est sorti le 22 décembre, et nous vous l'avons traduit comme cadeau de Noël. C'est entre-autre grâce à cet OAV que nous avons fait la conaissance de la <a href=\"http://kanaii.com/\" target=\"_blank\" class=\"postlink\">Kanaii</a>.");
			$news->setMessage($message);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("23 July 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("praia"));
			$news->setCommentId(267);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('bath', 'oav'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/bath.jpg\" alt=\"Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko\" />
  <br /><br />
  Nous avons appris qu'Ankama va diffuser à partir de la rentrée de septembre 2011 :<br />
  Baccano, Kannagi et Tetsuwan Birdy Decode. Tous les liens on donc été retirés.<br />
  On vous invite à cesser la diffusion de nos liens et à aller regarder la série sur leur site.<br />
  <br />
  Sorties d'Isshoni Training Ofuro : Bathtime with Hinako & Hiyoko<br />
  <br />
  3e volet des \"isshoni\", on apprend comment les Japonaises prennent leur bain, très intéressant...<br />
  Avec en bonus, une petite séance de stretching...<br />
  <br />
  Je ne sais pas s'il y aura une suite, mais si oui, je devine un peu le genre ^_^");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kanamemo 13 - FIN");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("29 March 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(256);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kanamemo', 'ep13'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/kana131.jpg\" alt=\"Kanamemo\" /><br /><br />
<img src=\"images/news/kana132.jpg\" alt=\"Kanamemo\" />
<br /><br />
Eh oui, c'est déjà la fin de Kanamemo, j'espère que cette petite série fort sympathique vous aura plus autant qu'à nous.<br />
C'est pour nous une bonne nouvelle, on diminue ainsi le nombre de nos projets en cours/futurs, on espère pouvoir faire de même avec d'autres séries prochainement...<br />
<img src=\"images/news/kana133.jpg\" alt=\"Kanamemo\" /><br /><br />
On vous annonce déjà que Kujibiki Unbalance II et Potemayo seront entièrement refaits ! Pas mal de choses ont été revues, j'espère que vous apprécierez nos efforts.<br />
Kodomo no Jikan OAV 4 ne devrait plus tarder...<br />
Merci de nous avoir suivis et à bientôt pour d'autres épisodes ^_^<br /><br />
<img src=\"images/news/kana134.jpg\" alt=\"Kanamemo\" /><br /><br />
<img src=\"images/news/kana135.jpg\" alt=\"Kanamemo\" />");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kanamemo 12");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("20 March 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(255);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kanamemo', 'ep12'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/kana12.jpg\" alt=\"Kanamemo\" />
<br /><br />
Bonjour !<br />
Sortie de l'épisode 12 de Kanamemo ! Youhouh ! C'est la fête !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kanamemo 11");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("14 March 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(254);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kanamemo', 'ep11'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/kana11.jpg\" alt=\"Kanamemo\" />
<br /><br />
Bonjour !<br />
Sortie de l'épisode 11 de Kanamemo ! Youhouh ! C'est la fête !<br /><br />
Rappel, nos releases sont téléchargeable sur :<br />
<ul>
<li>Sur <a href=\"http://zerofansub.net/\">le site zerofansub.net</a> en DDL (cliquez sur projet dans le menu à gauche)</li>
<li>Sur <a href=\"http://www.bt-anime.net/index.php?page=tracker&team=Z%e9ro\">notre tracker torrent BT-Anime</a> en torrent peer2peer (Notre équipe de seeder vous garantie du seed !)</li>
<li>Sur <a href=\"irc://irc.fansub-irc.eu/zero\">notre chan IRC</a> en XDCC (<a href=\"http://zerofansub.net/index.php?page=xdcc\">liste des paquets</a>)</li>
<li>Sur <a href=\"http://www.anime-ultime.net/part/Site-93\">Anime-Ultime</a> en DDL (Mais en fait, c'est les mêmes fichiers que sur Zéro, c'est juste des liens symboliques ^^)</li>
</ul>");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kanamemo 10");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("10 March 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(253);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kanamemo', 'ep10'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/kana10.jpg\" style=\"float: left;\" alt=\"Kanamemo\" />
<br /><br />
Bonjour !<br />
Sortie de l'episode 10 de Kanamemo ! Youhouh ! C'est la fete !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kanamemo 7, 8 et 9");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("23 February 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("praia"));
			$news->setCommentId(251);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kanamemo', 'ep7'));
			$news->addReleasing(Release::getRelease('kanamemo', 'ep8'));
			$news->addReleasing(Release::getRelease('kanamemo', 'ep9'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/kanamemo7.jpg\" alt=\"Kanamemo\" />
<br /><br />
Voilà qui met un terme à cette longue période d'inactivité : Kanamemo 7, 8 et 9, enfin !<br />
Tout comme l'épisode 5, l'épisode 7 était inutilement censuré, donc on s'est orientés vers les DVD. En version HD uniquement, la LD n'est plus très en vogue, faut dire ^^<br />
D'autres projets reprennent du service, encore un peu de patience...<br />
Je vous dis à bientôt pour d'autres épisodes ^_^");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kanamemo Chapitre 01");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("02 August 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(241);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kanamemobook', 'ch1'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/kanac1.jpg\" alt=\"Kanamemo Chapitre 01\" /><br /><br />
Sortie du chapitre 01 de Kanamemo qui ouvre le retour du scantrad chez Zéro !<br />
Depuis pas mal de temps, nous l'avions laissé à l'abandon mais avec l'école du fansub, nous avons pu nous y remettre.<br />
Sont prévus les scantrad de Kanamemo, Sketchbook et Maria+Holic. Quelques doujins devraient aussi arriver.<br />
Pour toutes nos autres séries dont les versions manga existent, vous pouvez les trouver en téléchargement sur les pages des séries comme Hitohira, Kannagi, Kimikiss et KissXsis.
<br />
A bientot !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kanamemo 06");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("16 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(224);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kanamemo', 'ep6'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/newskana6.jpg\" /><br />
Hé !<br />
Mais c'est qu'on arrive à la moitié de la série.<br />
Le 6éme épisode de Kanamemo est disponible.");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kanamemo 4 + 5");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("19 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(212);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kanamemo', 'ep4'));
			$news->addReleasing(Release::getRelease('kanamemo', 'ep5'));
			$message = new SimpleTextComponent();
			$message->addLine("<a href=\"http://yotsuba.imouto.org/image/b943e76cbe684f3d4c4cf3b748d7d878/moe%2099353%20amano_saki%20fixed%20kanamemo%20kujiin_mika%20nakamachi_kana%20neko%20pantsu%20seifuku.jpg\" target=\"_blank\"><img src=\"images/news/newskana5.jpg\" /><br />
(Image en plus grand clique ici)</a><br />
Coucou, nous revoilou !<br />
La suite de Kanamemo avec deux épisodes : le 4 et le 5.<br />
Dans les deux, on voit des filles dans l'eau... Toute nues, aux bains, et en maillot de bain à la \"piscine\" !
<br />Les deux sont en version non-censurée.
<br />Pour voir la différence entre les deux versions : <a href =\"http://www.sankakucomplex.com/2009/11/10/kanamemo-dvd-loli-bathing-steamier-than-ever/\" target=\"_blank\">LIEN</a>.<br />
En bonus, un petit AMV de l'épisode 05 (passé à la TV, nous le l'avons pas fait nous-même).<br />
À bientôt !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kanamemo 03");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("26 November 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(150);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kanamemo', 'ep3'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/kana3.jpg\" /><br />
BANZAIII !! Kanamemo épisode 03, ouais, trop bien ! Je mets du temps à sortir les épisodes ces derniers temps, mais derrnière le rideau, ne vous inquiétez pas, ça bosse ! Oui, c'est encore de ma faute, avant la piscine, maintenant printf, je suis débordée... (Mais de quoi elle parle !? o__O) Bref. Bon épisode !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kanamemo 01");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("20 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(114);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kanamemo', 'ep1'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/kana1.jpg\" />
Bonsoir....<br /><br />
Kodomo no Jikan touche à sa fin (bouhouh T__T) et on nous a proposé un anime sur le forum : Kanamemo. On a tout de suite vu qu'il s'inscrivait directement dans la ligne directe de Kodomo no Jikan, ecchi ~ loli ! Rétissants au départ à commencer un nouvel anime sans finir nos précédents en cours, mais ayant plusieurs personnes de l'équipage n'ayant rien à faire, nous avons finalement accepté la proposition. Cet anime est trop mignon~choupi~kawaii, c'est la petite Kana qui perd sa grand-mère et ses parents et doit se debrouiller toute seule et trouver du travail. Y'a aussi un peu de yuri dedant, donc je pense que tout le monde y trouvera ce qu'il aime !");
			$news->setMessage($message);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Joyeux Noël !");
			$news->setTimestamp(strtotime("24 December 2011 21:05"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(277);
			$news->setTeamNews(false);
			$message = new SimpleTextComponent();
			$message->addLine("Allez pour me faire pardonner de ma dernière news, un petit goût de Noël dans cette mini-news (cliquez sur l'image).");
			$message->addLine();
			$message->addLine(new Link("images/news/[Zero Fansub]Noel 2011.zip", new Image("images/news/noel3.jpg", "Joyeux Noël !")));
			$news->setMessage($message);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kujibiki Unbalance épisode 09");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("18 August 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(243);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep9'));
			$message = new SimpleTextComponent();
			$message->addLine("<img src=\"images/news/kujian9news.jpg\" alt=\"Kujibiki Unbalance épisode 09 - Yamada montre sa culotte Renko\" /><br /><br />
Chihiro, Tokino, Koyuki, Yamada et Renko sont de retour pour la suite de leurs aventures pour devenir les membres du conseil des élèves de Rikkyouin ! Retrouvez les dans cet épisode 09 où Yamada ne sera pas dans son état normal...<br />
Comme d'habitude, l'épisode est téléchargeable sur la page de la série partie \"Projets\" en téléchargement direct uniquement et plus tard en torrent, XDCC, etc.<br />
<br />
<img src=\"images/news/news_dons_k-on.gif\" alt=\"Merci pour le don a Herve ! K-On money money\" /><br /><br />
Un grand <strong>merci</strong> à Hérvé pour son don de 10 euros qui va nous aider à payer nos serveurs !<br />
<br />
A bientot !<br /><br />");
			$news->setMessage($message);
			$news->setTwitterTitle("Sortie de Kujibiki Unbalance episode 09 chez Zero ! http://zerofansub.net/");
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~ full color's  ~ Picture Drama série complète (01 à 06)");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("26 June 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/sketchdrama.png\" alt=\"Sketchbook ~ full color's ~ Picture Drama\" /><br />
Pour fêter les vacances qui arrivent, Sora et ses amies vous emmenent avec elles à la mer !<br />
C'est une petite série de 6 épisodes de moins de 10 minutes chacun qui étaient en Bonus sur les DVDs de Sketchbook ~ full color's ~. Ils ont été réalisé à partir du Drama CD de la série et l'animation est minime. Dans la même douceur que la série, ils sont parfait pour se reposer en pensant aux vacances qui arrivent.");
			$news->setCommentId(234);
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('sketchbookdrama'));
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kujibiki Unbalance 2 episode 08");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("03 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/newskuji8.png\" /><br />
Comment attirer l'oeil des fans d'animes de chez Zero ?<br />
Avec une paire de seins, evidemment !<br />
Episode 8 de Kujibiki Unbalance 2 en exclusivite total gratuit pas cher promo solde !<br />
Un episode qui m'a beaucoup plu, tres tendre et qui revele des elements cles de l'histoire.<br />
En reponse au precedent sondage, il n'est ABSOLUMENT PAS NECESSAIRE D'AVOIR VU GENSHIKEN OU LA PREMIERE SAISON de Kujibiki Unbalance pour regarder celle-ci. Les histoires ont quelques liens mais sont completement independantes les unes des autres. C'est une serie a part.<br />
Bon episode a tous et a tres bientot !");
			$news->setCommentId(220);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep8'));
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setDisplayInHentaiMode(false);
			$news->setTitle("Potemayo [08] 15 + 16");
			$news->setTimestamp(strtotime("01 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage('<img src="images/news/pote8.jpg" /><br />
Anyaa~~<br />
Potemayo, épisode 8, youhou ! Et très bientôt, Kanamemo, Isshoni H shiyo et Isshoni sleeping ! Enjoy, Potemayo !');
			$news->setCommentId(207);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('potemayo', 'ep8'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Potemayo [07] 13 + 14");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("30 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Tarf"));
			$news->setMessage('<img src="images/news/moepote1.jpg"><br />
Revenons à nos charmants allumés dans un PotemaYo que j\'ai particulièrement aimé.<br />
<br />
Deux épisodes : La fin de l\'été, et La nuit du Festival<br />
<br />
Encore, encore un épisode totalement déjanté, où on va devoir faire du nettoyage... et prier. Puis on va manger de la glace à base de lait avec un type fou, fou, fou ^^<br />
Hé, vous voulez savoir comment on fait cuir plus vite des ramens ?<br />
<br />
Moi ça m\'éclate comment Potemayo sait dépenser son argent<br />
ENJOY IT !<br />
<img src="images/news/moepote2.jpg"><br />
db0 dit : Les screens ci-dessus n\'ont rien à voir avec l\'épisode :) Ce sont des extraits de Moetan, l\'épisode 11. J\'en profite donc pour faire une petite pub à notre partenaire <a href="http://kanaii.com" target="_blank">Kanaii</a> grâce à qui on peut regarder Moetan avec des sous-titres d\'excellente qualité.');
			$news->setCommentId(191);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('potemayo', 'ep7'));
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin");
			$news->setTimestamp(strtotime("19 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage('<img src="images/news/newkodomo1.jpg" alt="Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin" /><br /><br />
Vous l\'avez attendu longtemps, celui-là ! Il faut dire qu\'il est quand même sorti en aout. Alors pourquoi le sortir si tard ? Surtout qu\'il faut savoir qu\'il était prêt en septembre. C\'est simple : Pour toujours rester dans l\'optique de la qualité de nos animes, nous attendions que les paroles officielles du nouvel ending sortent. Malheuresement, elle ne sont toujours pas sorties à l\'heure actuelle. Nous pensons donc que les chances qu\'elles sortent maintenant sont minimes et avons à contre-coeur décidé de sortir l\'OAV maintenant et sans le karaoké. Cependant, sachez que s\'il s\'avère que les paroles finissent par sortir, même tardivement, nous sortirons une nouvelle version de celui-ci avec le karaoké !<br />
Merci à DC pour avoir encodé cet épisode et Maboroshi, avec nous en coproduction sur cette série.<br />
C\'est avec ce dernier épisode que nous marquons la fin de Kodomo no Jikan ! C\'est ma série préférée et je pense que c\'est aussi la préférée de beaucoup de membres de chez Zéro et sa communauté.<br />
Nous avons passé du bon temps aux côtés de Rin et ses deux amies et nous éspérons que c\'est aussi votre cas.<br /><br />
<img src="images/news/newkodomo2.jpg" alt="Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin" /><br /><br />
<img src="images/news/newkodomo3.jpg" alt="Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin" />');
			$news->setCommentId(185);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo2', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama ~Kiss on my deity~ 12 - Fin");
			$news->setTimestamp(strtotime("12 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("C'est aujourd'hui la fin de Tayutama. Le douzième et dernier épisode toujours en coproduction avec nos amis de chez Maboroshi. Nous éspérons que vous avez passé un bon moment avec nous pour cette merveilleuse série ! Et maintenant, it's scrolling time !<br /><br />
<img src=\"images/news/tayufin1.jpg\" /><br />
<img src=\"images/news/tayufin2.jpg\" />");
			$news->setCommentId(176);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('tayutama', 'ep12'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama - Kiss on my Deity - 11");
			$news->setTimestamp(strtotime("04 December 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("TchO"));
			$news->setMessage("<img src=\"images/news/mashinoel.jpg\" /><br />
Tayu 11, la Bataille Décisive !!<br /><br />
Pour calmer la colère du dragon, la grande prêtresse Mashiro tente...<br />
Hé !!!!! Mais que se passe-t-il ????? C't'une surprise !!!<br /><br />
Pour la Bataille Décisive, on a droit à un cosplay de Dieu !!<br />
Si c'est comme ça que Mashiro espère gagner la partie !<br /><br />
Tenez bon ! La fin se précise, et elle est belle à regarder !<br /><br />
Coproduction Zero+Maboroshi !<br />
TchO_°");
			$news->setCommentId(152);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('tayutama', 'ep11'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama - Kiss on my Deity - 10");
			$news->setTimestamp(strtotime("17 November 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("TchO"));
			$news->setMessage("<img src=\"images/news/tayu10.jpg\" /><br />
L'Horoscope d'aujourd'hui :<br />
Humains : Ecrasé par l'émotion, sachez éviter les coups de marteau !<br /><br />
Portée par le rêve de la coexistence, Yumina-chan danse.<br />
Quant à Ameri, elle est la proie de ses mauvais rêves...<br /><br />
Même romantique, la passion peut être tellement furieuse !");
			$news->setCommentId(149);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('tayutama', 'ep10'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama - Kiss on my Deity - 09");
			$news->setTimestamp(strtotime("05 November 2009 01:00"));
			$news->setAuthor(TeamMember::getMemberByPseudo("TchO"));
			$news->setMessage("<img src=\"images/news/tayuu9.jpg\" /><br />
Mashiro découvre que la moto est un souci pour aller aux sources d'eau chaudes.<br /><br />
Hé, on va tous faire un karaoké ?<br />
C'est le moment de s'amuser !<br />
Entre deux entraînements, une balade à la tour de Tokyo.<br />
Les sentiments de Mashiro n'échappent à personne, ni à Ameri, ni à...<br /><br />
Une Zero + Maboroshi coprod<br /><br />
TchO_°");
			$news->setCommentId(141);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('tayutama', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama - Kiss on my Deity - 08");
			$news->setTimestamp(strtotime("05 November 2009 00:30"));
			$news->setAuthor(TeamMember::getMemberByPseudo("TchO"));
			$news->setMessage("<img src=\"images/news/tayuuu.jpg\" /><br />
Tayutama !!!!!!<br />
Tayutama, c'est pour ce soir l'épisode 08, toujours coproduit avec la Maboroshi.<br />
Un épisode qui nous livre, dans une exceptionnelle interprétation, un remake de \"j'assortis mon foulard avec ma jupe\".<br />
Et puis, on allait pas louper la tronche de Yuuri pour une fois ^^<br />
(Ca veut dire quoi, au fait, Tayutama ?)<br />
Profitez-en bien, c'est toujours aussi délire !!<br />
db0 dit :<br />
J'en profite en coup de vent pour vous annoncer que la deuxième session de Konshinkai à Lyon arrive en fin du mois, et pour ça, un forum a fait son ouverture ainsi qu'un nouveau site et un chan irc. Venez nombreux ! <a href=\"http://konshinkai.c.la\" target=\"_blank\">+ d'infos, clique.</a>");
			$news->setCommentId(140);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('tayutama', 'ep8'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama - Kiss on my Deity - 06 + 07 + Kanamemo 02");
			$news->setTimestamp(strtotime("05 November 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/tayuu.jpg\" /><br />
Bonjour tout le monde !<br />
Je me suis dit que c'était toujours moi qui rédigait les news, et qu'il serait temps que ça change. Donc j'ai demandé à quelques membres de l'équipe de le faire. J'ai trouvé le résultat assez marrant, donc je vous donne leurs petites idées de news :<br /><br />
Praia dit :<br />
\"On abandonne tout et on recommence : Tayutama 6 et 7 en copro avec la Maboroshi.<br />
Bon leech ! Version MP4 disponible uniquement.<br />
Kanamemo, c'est quoi ? C'est la série des petits pervers... non, vous voyez, suis pas fait pour faire des news, moi... ^_^
Dommage que Sunao ne soit pas là... Il nous aurait pondu une brique > <\"
<br /><br />
Tarf dit :<br />
\"Hein ? J'ai pas signé pour ça moi ! Et puis je suis juste un petit trad qui fait un peu de time à ses heures perdus, donc je fais le début de chaîne. C'est aux gens en bout de chaîne de faire ça non ? Va donc voir le joli post \"staff\" que tu as pondu sur toutes les séries, et choppe le dernier nom ^^.<br />
Bon, une petite news : \"J'ai pu rencontrer samedi 31 octobre, à l'occasion du Konshinkai trois personnes parfois intéressantes. J'ai ainsi parlé IRL mon idole Ryokku, qui travail en tant qu'admin pour anime ultime, qui est à mon avis un des meilleurs sites français d'anime. Après une interview exclusive de ce monument vivant de l'animation, il m'a confié qu'il désespérait de la saison en cours d'anime, et qu'aucun ne trouvait grâce à ses yeux. N'ayant pas les mêmes goûts que lui, je ne suis pas d'accord, mais moi tout le monde s'en fout. Pour ceux que ça interesse, il est gentil, jeune et dynamique ! Avis aux jeunes filles, jetez vous dessus !\"<br />
Tayutama Kiss on my deity, épisode 6 et 7 enfin sortis en corproduction avec la Maboroshi no Fansub ! La suite des aventures plus ou moins osée de l'avatar fort mignon d'une déesse dans le monde réel. Vous y retrouverez l'amie d'enfance jalouse, la Tsundere et la naïve à forte poitrine. La version MP4 est disponible immédiatement sur le site, la version AVI étant abandonnée.\"<br /><br />
db0 dit :<br />
J'en profite en coup de vent pour vous annoncer que la deuxième session de Konshinkai à Lyon arrive en fin du mois, et pour ça, un forum a fait son ouverture ainsi qu'un nouveau site et un chan irc. Venez nombreux ! <a href=\"http://konshinkai.c.la\" target=\"_blank\">+ d'infos, clique.</a>");
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('tayutama', 'ep6'));
			$news->addReleasing(Release::getRelease('tayutama', 'ep7'));
			$news->addReleasing(Release::getRelease('kanamemo', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama ~ Kiss on my Deity ~ 06");
			$news->setTimestamp(strtotime("21 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/newtayu.jpg\" border=\"0\" /><br />
On vous l'avait promis : on n'allait pas laisser tomber Maboroshi ! Et voilà, c'est chose faite : l'épisode 06 de Tayutama sort aujourd'hui. J'espère qu'il vous plaira.");
			$news->setCommentId(105);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('tayutama', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Hitohira 05 + 06");
			$news->setTimestamp(strtotime("10 November 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/hito5.jpg\" /><br />
Mugi-choco ! Tu nous as tellement manqué... Et tu reviens en maillot de bain, à la plage ! Yahou ! Mugi-Mugi-choco !!");
			$news->setCommentId(142);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('hitohira', 'ep5'));
			$news->addReleasing(Release::getRelease('hitohira', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Hitohira 04 + KnJ Ni Gakki OAV Spécial Version LD HD");
			$news->setTimestamp(strtotime("02 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/hito4.jpg\" border=\"0\" style=\"float : right; display:block; margin-right: 20px;\">
On est decidé, on va avancer nos projets ! L'un de nos plus vieux, Hitohira, revient ce soir avec son 4ème épisode.<br />Et les versions LD et HD tant attendues de l'OAV sorti hier sont aussi arrivées. Profitez-en, c'est gratuit, aujourd'hui ! Et tous les autres jours aussi.");
			$news->setCommentId(55);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('hitohira', 'ep4'));
			$news->addReleasing(Release::getRelease('kodomo2', 'ep0'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("KnJ 03 LD V2, Petit point sur nos petites séries");
			$news->setTimestamp(strtotime("26 January 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/akirin.jpg\" border=\"0\" /> <br> Petite v2 qu'on attendait depuis pas mal de temps : L'épisode 03 de Kodomo no Jikan LD qui avait quelques petits soucis d'encodage. <a href=\"http://zerofansub.net/ddl/%5BZero%5DKodomo_no_Jikan%5B03v2%5D%5BXVID-MP3%5D%5BLD%5D%5B499E9C85%5D.avi\" target=\"_blank\" class=\"postlink\">DDL</a><br> <br>On en profite pour faire un petit point sur nos séries actuellement.<br> - <span style=\"font-weight: bold\">Alignment you you</span> En cours de traduction, mais on prend notre temps.<br> - <span style=\"font-weight: bold\">Genshiken 2</span> L'épisode 07 est en cours d'adapt-edit.<br> - <span style=\"font-weight: bold\">Guardian Hearts</span> En pause pour le moment.<br> - <span style=\"font-weight: bold\">Hitohira</span> En cours de traduction.<br> - <span style=\"font-weight: bold\">Kimikiss pure rouge</span> En pause pour le moment.<br> - <span style=\"font-weight: bold\">Kodomo no Jikan</span> L'épisode 10, 11, 12 sont prêt. La saison 2 arrive bientôt. Heuresement, avec la fin de la saison 1 qui s'approche...<br> - <span style=\"font-weight: bold\">Kujibiki Unbalance</span> Je vais m'y mettre...<br> - <span style=\"font-weight: bold\">Kurokami</span> En attente de Karamakeur.<br> - <span style=\"font-weight: bold\">Maria Holic</span> Très bientôt <img src=\"http://img1.xooimage.com/files/w/i/wink-1627.gif\" alt=\"Wink\" border=\"0\" class=\"xooit-smileimg\" /><br> - <span style=\"font-weight: bold\">Mermaid Melody</span> Notre annonce a fonctionnée, LeChat, notre traducteur IT-FR prend la suite en charge.<br> - <span style=\"font-weight: bold\">Sketchbook full color's</span> Des V2 des épisodes 1 et 5 ainsi que l'épisode 6 sont en cours d'encodage par Ajira.<br> - <span style=\"font-weight: bold\">Toradora!</span> Le 10 arrive !");
			$news->setCommentId(32);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kodomo', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Hitohira 03");
			$news->setTimestamp(strtotime("07 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/mugi.png\" border=\"0\" /><br>Oh !<br>À cause d'un problème de raws, la série Hitohira est restée en pause pendant trèèès longtemps. Mais grâce à Lyf, le raw-hunter, et bien sûr à Jeanba, notre nouveau traducteur, mais aussi à B3rning14, nouvel encodeur, la série peut continuer. Et c'est donc l'épisode 03 que nous sortons aujourd'hui !<br><br>La Genesis ayant accepté que leurs releases en co-pro avec la Kanaii soient diffusées en DDL chez nous, vous pouvez maintenant retrouver la saison 2 de Rosario+Vampire ainsi que 'Kimi ga Aruji de Shitsuji ga Ore de - They are my Noble Masters'. <a href=\"http://zerofansub.net/?page=kanaiiddl\" target=\"_blank\" class=\"postlink\">Lien</a><br>Bon DL !<br><br>Les dernières sorties de la <a href=\"http://www.kanaii.com/\" target=\"_blank\" class=\"postlink\">Kanaii</a> :<br>- Kanokon 11<br>- Kanokon 12");
			$news->setCommentId(18);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('hitohira', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Quelques mises à jour");
			$news->setTimestamp(strtotime("12 October 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/sorties/lasthitohira2.png\" border=\"0\" /><br><br>Cela faisait pas mal de temps que Zéro n'avait rien sorti !<br>Je pense vous faire plaisir en vous annonçant quelques nouvelles :<br>- 4 épisodes sont prêts et attendent juste d'être encodés.<br>- 2 Nouvelles séries sont à paraître :<br>-- Sketchbook ~full color's~ <br>-- Toradora!<br>- Bientôt une v3 du site !<br><br>On profite de cette news pour mettre fin à certaines rumeurs :<br>- Non ! Nous ne faisons pas de Hentaï<br>- Non ! Nous n'avons pas tous 13 ans ! <br>- Nous n'avons rien contre la Genesis. Au contraire, si ça pouvait s'arranger, je préfererais. Nous ne comprenons toujours pas le pourquoi du comment de cette histoire, mais soyez sûr que nous ne répondrons jamais à leurs éventuelles provocations, insultes ou agressions.<br>Merci à tous et Bon download !");
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('hitohira', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 12 ~ fin ! + 01v2 & 02v2");
			$news->setTimestamp(strtotime("29 September 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/ogiue.jpg\" /><br />
Et ainsi se termine Genshiken, le club d'étude de la culture visuelle moderne, avec un 12e épisode et quelques v2 pour perfectionner. Elle est pas trop mignonne, comme ça, Ogiue ?");
			$news->setCommentId(133);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('genshiken', 'ep12'));
			$news->addReleasing(Release::getRelease('genshiken', 'ep1'));
			$news->addReleasing(Release::getRelease('genshiken', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 2 épisode 11");
			$news->setTimestamp(strtotime("19 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/genshiken-11.jpg\" style=\"float: right\" border=\"0\">
C'est les vacances pour certains membres de chez Zéro donc on a le temps de s'occuper de vous... Du moins, des épisodes que vous attendez avec impatience. (Pour qu'on s'occupe de vous personnellement, appelez le 08XXXXXXXX 0.34€ la minute demandez Sonia) Bref, ce soir sort l'épisode 11 de la saison 2 de Genshiken, c'est-à-dire l'avant dernier de la série. Les deux copines américaines sont toujours là pour vous faire rire, mais partieront à la fin de l'épisode. Profitez bien, c'est bientôt la fin ^^");
			$news->setCommentId(104);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('genshiken', 'ep11'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 10");
			$news->setTimestamp(strtotime("24 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/gen10.jpg\" style=\"float:right;\" border=\"0\">
Notre petit Week-end d'otaku kanaii-zéro s'est très bien passé, dommage pour ceux qui n'y étaient pas ^^<br />Vous vous en foutez ? Anyaa ~~ Bon, bon, le v'là votre épisode 10 de Genshiken.<br />
Petite info importante : L'OAV de KissXsis est en cours. Après sa sortie, Zéro se met en \"pause\" temporaire puisque je passe mon bac.");
			$news->setCommentId(76);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('genshiken', 'ep10'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 09");
			$news->setTimestamp(strtotime("22 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/genshi9.jpg\" style=\"float:right;\" border=\"0\">
Nyaron~ La suite de Genshiken 2 avec l'épisode 09. Bon download, bande d'otaku.");
			$news->setCommentId(75);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('genshiken', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken2 08 + Sortie Kanaii");
			$news->setTimestamp(strtotime("10 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"http://moe.mabul.org/up/moe/2009/05/10/img-122101gdcpq.png\" border=\"0\"><br />3 sorties en une journée, c'est un cas plutôt rare ! La suite de Genshiken2, c'est <a href=\"index.php?page=series/genshiken\">par là</a> avec l'épisode 08 qui sort aujourd'hui. Plus tar dans la soirée sortieront les versions LD de Kodomo oav2 et md, ld de Maria Holic 08.<br /><br />
Une petite sortie Kanaii-Zéro est organisée entre Otaku le 23 et 24 mai à Nice ! Les sudistes pourront ainsi se retrouver sur nos plages ensoleillées pour se sentir un peu en vacances. Et les nordistes, n'hésitez pas à descendre nous voir ! Si vous souhaitez être de la partie, n'hésitez pas ! Envoyez-moi un mail (zero.fansub@gmail.com) ou venez vous signaler sur le forum Kanaii : <a href=\"http://www.kanaii.com/e107_plugins/forum/forum_viewtopic.php?46591\" target=\"_blank\">Lien</a>. Venez nombreux !");
			$news->setCommentId(70);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('genshiken', 'ep8'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria+Holic 05 et Genshiken2 07");
			$news->setTimestamp(strtotime("20 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/mariagen.jpg\" border=\"0\">
<img style=\"float : left; display:block; margin-right: 20px;\" src=\"images/news/mariagen2.jpg\" border=\"0\">
Un problème de ftp est survenu hier soir, ce qui nous a poussé à reporter la sortie de Maria+Holic 05 à aujourd'hui. (Nous nous excusons auprès de <a href=\"http://kanaii.com\" target=\"_blank\">Kanaii</a> en coproduction sur cet anime). Genshiken2 07 devait sortir ce soir. Maria 05 est toujours aussi drôle et dans l'épisode 07 de Genshiken, vous trouverez 2 nouveaux karaokés (à vos micros !). Profitez bien de cette double sortie !<br /><br /><a href=\"index.php?page=series/mariaholic\">Maria Holic</a> <a href=\"index.php?page=series/genshiken\">Genshiken2</a>");
			$news->setCommentId(49);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('genshiken', 'ep7'));
			$news->addReleasing(Release::getRelease('mariaholic', 'ep5'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 06");
			$news->setTimestamp(strtotime("13 January 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/gen6.jpg\" border=\"0\" /> <br> Otaku, otaku, nous revoilà ! Genshiken épisode 06 enfin dans les bacs, en ddl.<br> <a href=\"index.php?page=series/genshiken\" target=\"_blank\" class=\"postlink\">Pour télécharger les épisodes en DDL, cliquez ici !</a><br><br>  <span style=\"font-weight: bold\">Les dernières sorties de la <a href=\"http://www.sky-fansub.com/\" target=\"_blank\" class=\"postlink\">Sky-fansub</a> :</span><br> Kurozuka 08<br> Mahou Shoujo Lyrical Nanoha Strikers 21<br> <br> <span style=\"font-weight: bold\">Les dernières sorties de la <a href=\"http://kyoutsu-subs.over-blog.com/\" target=\"_blank\" class=\"postlink\">Kyoutsu</a> :</span><br> Hyakko 06<br> <br> <span style=\"font-weight: bold\">Les dernières sorties de la <a href=\"http://www.kanaii.com/\" target=\"_blank\" class=\"postlink\">Kanaii</a> :</span><br> Kamen no maid Guy 01v2<br> Rosario+Vampire Capu2 07v2");
			$news->setCommentId(31);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('genshiken', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 05, Toradora! 08, Sketchbook 05 et Recrutement QC");
			$news->setTimestamp(strtotime("10 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/recrut/qc.jpg\" border=\"0\" /><br>3 sorties en une, aujourd'hui ! Les épisodes 5 de Genshiken2, 8 de toradora! et 5 de Sketchbook sont disponibles dans la partie projets en DDL uniquement pour le moment. Les liens torrents, XDCC, Streaming viendront plus tard, ainsi que la version avi de genshiken et H264 de Toradora. Bon épisode !<br><br>Notre unique QC, praia, aimerait bien partager les QC de toutes nos séries avec un autre QC. Si vous êtes exellent en orthographe et que vous avez un oeil de lynx, nous vous solicitons ! Merci de vous présenter au poste de QC ^^ <a href=\"http://zerofansub.net/index.php?page=recrutement\" target=\"_blank\" class=\"postlink\">Lien</a>");
			$news->setCommentId(21);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('genshiken', 'ep5'));
			$news->addReleasing(Release::getRelease('toradora', 'ep8'));
			$news->addReleasing(Release::getRelease('sketchbook', 'ep5'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 04");
			$news->setTimestamp(strtotime("08 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Voilà enfin la suite de notre saga otaku préférée, j'ai nommé... GENSHIKEN ! L'épisode 04 est dispo en ddl seulement pour le moment.");
			$news->setCommentId(19);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('genshiken', 'ep4'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria+Holic 12 - Fin de la série");
			$news->setTimestamp(strtotime("20 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/mariafin.png\" style=\"float: right;\" />
Cette série était si drôle qu'elle est passée bien vite... Eh oui ! Déjà le dernier épisode de Maria+Holic ! Ce 12e épisode est complétement délirant, Kanako fait encore des siennes, et Mariya la suit de près. Avec la fin de cette série se termine aussi une coproduction avec Kanaii, nos partenaires et amis, qui s'est exellement bien passée et que nous accepterons avec plaisir de renouveler. Merci à eux et particulièrement à DC, le maître du projet aux superbes edits AE. Bon dernier épisode, et aussi bonne série à ceux qui attendaient la fin pour commencer la série compléte !");
			$news->setCommentId(115);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep12'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 07 + Maria Holic 11 + Mermaid Melody 02");
			$news->setTimestamp(strtotime("17 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/canaan7.png\" style=\"float: right\" />
<img src=\"images/news/maria11.png\" style=\"float: left\" />
Une triple sortie ce soir !<br /><br />
Tout d'abord, l'habituel Canaan de la semaine avec l'épisode 07. Cet épisode était particulièrement difficile, avec tout ces politiciens, tout ça tout ça, donc nous a pris plus de temps que prévu mais nous y sommes arrivé !<br /><br />
Une deuxième sortie qui est en fait un épisode déjà encodé depuis longtemps mais que nous n'avions pas encore mis sur le site, l'épisode 2 version italienne de Mermaid Melody Pichi Pichi Pitch. Je pense ne décevoir personne, mais je rappelle que nous abandonnons les versions italiennes pour continuer les versions japonaises de chez Maboroshi (nous recrutons pour cela un traducteur ! SVP ! Help us !). Les liens de téléchargement des 13 épisodes par Maboroshi ne sont pas encore tous mis en place mais le seront dans le courant de la journée de demain.<br /><br />
Et enfin, la suite de Maria Holic que vous attendiez tous ! L'épisode 11 et... avant-dernier épisode. Profitez bien de ce concentré d'humour avant la fin de cette superbe série, toujours en coproduction avec nos chers amis de chez Kanaii. La version avi ne sera disponible que demain.");
			$news->setCommentId(113);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep11'));
			$news->addReleasing(Release::getRelease('canaan', 'ep7'));
			$news->addReleasing(Release::getRelease('mermaid', 'ep54'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 01 + Maria Holic 10");
			$news->setTimestamp(strtotime("16 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/canaan.jpg\" border=\"0\"><br />
Une double sortie ce soir (peut-être pour rattraper vos attentes ?) dont l'épisode 10 tant attendu de Maria Holic avec comme toujours nos potes de chez Kanaii, et une nouvelle série : Canaan. C'est un nouveau projet assez original puisque c'est un genre d'anime qu'on ne fait habituellement chez Zéro. En fait, c'est Ryocu (le chef ultime !) qui s'est motivé à la traduire. J'espère qu'elle vous plaiera ! Bon download !");
			$news->setCommentId(101);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep10'));
			$news->addReleasing(Release::getRelease('canaan', 'ep1'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria Holic 09");
			$news->setTimestamp(strtotime("05 June 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/maria9.jpg\" style=\"float:right;\" border=\"0\">
La team était en \"semi-pause\", maintenant que notre épisode en coproduction est sorti (Maria Holic 09 avec Kanaii), la team est en pause totale et revient en juillet. Bon épisode en attendant.");
			$news->setCommentId(78);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria Holic 08 + Doujin");
			$news->setTimestamp(strtotime("09 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/maria8.jpg\" style=\"float:right;\" border=\"0\">
Maria Holic épisode 08 pour aujourd'hui, en coproduction avec Kanaii. Un épisode plutôt riche, et toujours aussi drôle. En bonus avec cet épisode, les images des anges \"cosplayés\" pendant l'épisode. <a href=\"index.php?page=series/mariaholic\">C'est par là !</a>
<br /><br />PARTIE HENTAÏ :<br />Une mise à jour de la partie hentaï du site et la sortie d'un doujin de He is my master <a href=\"index.php?page=project&id=heismymaster\">Par là !</a>");
			$news->setCommentId(67);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep8'));
			$news->addReleasing(Project::getProject('heismymaster'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria+Holic 07");
			$news->setTimestamp(strtotime("24 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/maria7.jpg\" border=\"0\">
La suite de Maria+Holic, toujours en coproduction avec nos petits kanailloux. Disponible en DDL pour l'instant, et un peu plus tard en torrent et MU. J'en profite pour vous informer que nous risquons de ralentir le rythme puisque je suis en vacances, mais que dès la rentrée, tout reviendra dans l'ordre.");
			$news->setCommentId(63);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep7'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria+Holic 06");
			$news->setTimestamp(strtotime("05 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/maria6.jpg\" border=\"0\">
Maria+Holic, la suite plutôt attendue ! L'épisode 06, en coproduction avec la Kanaii. Et notre DC et ses edits. Un épisode particulierement important pour la série : On y apprend une information ca-pi-tale ! À ne pas manquer !<br /><br />Sinon, HS, je suis un peu déçue de voir que le nombre de visite diminue de façon exponentielle depuis la fin de Toradora!... Anya >.< 
<br /><br />EDIT : Sorties des deux autres versions.");
			$news->setCommentId(56);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria Holic 03");
			$news->setTimestamp(strtotime("16 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Maria Holic 03, en copro avec <a href=\"http://kanaii.com/\" target=\"_blank\" class=\"postlink\">Kanaii</a>. <a href=\"index.php?page=series/mariaholic\" target=\"_blank\" class=\"postlink\">L'épisode en DDL, c'est par ici !</a>");
			$news->setCommentId(39);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria Holic 02");
			$news->setTimestamp(strtotime("07 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/mariaholic2.jpg\" border=\"0\" /> <br> En direct de Lyon, je vous sors le deuxième épisode de Maria+Holic en co-production avec <a href=\"http://kanaii.com/\" target=\"_blank\" class=\"postlink\">Kanaii</a>.<br>Les mésaventures de Kanako continuent, ne les manquez pas !<br> <a href=\"index.php?page=series/mariaholic\" target=\"_blank\" class=\"postlink\">L'épisode en DDL, c'est par ici !</a><br><br> PS : Maboroshi est de retour !!");
			$news->setCommentId(38);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria+Holic 01");
			$news->setTimestamp(strtotime("28 January 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/kanako.png\" border=\"0\" /> <br> Nouvelle série que l'on avait pas annoncé officiellement pour le moment : Maria+Holic. Mais ce n'est pas tout : Nouvelle co-production aussi, non pas avec MNF, mais cette fois-ci avec l'un de nos <a href=\"http://zerofansub.net/index.php?page=dakko\" target=\"_blank\" class=\"postlink\">partenaires dakkô</a> a qui l'on offre du DDL et qui nous laisse poster sur leur site quelques news.... <a href=\"http://www.kanaii.com/\" target=\"_blank\" class=\"postlink\">Kanaii !</a><br> Trèves de paroles inutiles : Voici donc l'épisode 01, disponible en DDL chez nous et torrent MU chez eux.<br> <a href=\"ddl/%5bKanaii-Zero%5d_Maria+Holic_01_%5bX264_1280x720%5d.mkv\" target=\"_blank\" class=\"postlink\">DDL</a>");
			$news->setCommentId(33);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep1'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Potemayo 06 (11 + 12)");
			$news->setTimestamp(strtotime("04 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/pote.jpg\" /><br />
Le sondage de la semaine dernière était un peu foireux parce ce qu'on pouvait pas voter en fait donc euh les commentaires seront pris en compte finalement. Merci pour vos réponses. Nous continueront of course à poster moultes actualités concernant autre chose que le fansub. Ce sont les vacances, donc nous en profitons bien, mais nous ne chômons pas quand même et vous proposons donc quelques petits épisodes à regarder entre 2 séries de bronzage ou de baignade ou que sais-je encore de randonnées, de visites au musée, pourquoi pas de job d'été, ect. M'enfin, bref, je m'étale inutilement (comment ça, comme d'habitude ?) et vous propose de vous rendre sur le site si vous n'y êtes pas déjà pis d'aller télécharger notre petit potemayo, mignon potemayo, potemayo, potemayo naaassuuu !! (ça veut rien dire, c'est normal, j'ai un peu bu)(bah quoi ? c'est les vacances ou pas ?). Je regretterai sûrement d'avoir écrit une news aussi foncedé demain mais bon vous inquiétez pas je l'étais pas quand je taffais sur cet épisode, hein. J'vous l'jure, m'sieur l'agent. J'suis sobre, moi, j'bois pas. Jamais, jamais. J'vais jamais en soirée ou quoi, non, non. Moi, je fais du fan-sub ! Du fan-sub ! Sinon, vous avez vu, l'image de sortie, au dessus ? Elle est pourrie, hein ? C'est parce que je sais pas me servir de Gimp et que j'ai internet qu'avec ubuntu parce que j'ai fait ça avec un téléphone portable, en fait. C'est ça, marrez-vous. M'enf, j'apprendrais à utiliser Gimp !! Bon, bon. Et l'image du mois, elle vous plaît ? Ouais, c'est des nichons, tout ça, là, ça vous plaît, ce genre de trucs. Moi, ça me plaît bien en tout cas. Je kiffe ma race, même, je dirais. Et moi, je fais du cosplay !! Si, si. Fin.");
			$news->setCommentId(108);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('potemayo', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Potemayo 05");
			$news->setTimestamp(strtotime("21 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/pote5.jpg\" style=\"float:right;\" border=\"0\">
Si c'est pas trop Kawaii, ça ? Bah oui, c'est Potemayo ! Comme vous le savez, notre partenaire, Kirei no Tsubasa, a déposé le bilan récemment. Histoire de ne pas laisser leurs projets tomber à l'eau, nous avons accepté de reprendre le projet Potemayo. Nous continuons là où ils se sont arrêté et sortons l'épisode 05. Les épisodes 01 à 04 sont aussi disponibles sur le site. Honi Honi ~");
			$news->setCommentId(74);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('potemayo', 'ep5'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kujibiki Unbalance 2 07");
			$news->setTimestamp(strtotime("18 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/kuji.jpg\" style=\"float:right;\" border=\"0\">
Kujibiki Unbalance est de retour avec l'épisode 7 qui sort aujourd'hui. Il est riche en émotion pour nos héros et particulièrement pour Tokino. Un nouveau personnage apparaît et on découvre des informations sur les personnages. Je vous laisse découvrir tout ça...");
			$news->setCommentId(102);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep7'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kujibiki Unbalance 2 06");
			$news->setTimestamp(strtotime("14 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/kuji6.jpg\" border=\"0\">
Après une longue attente sans Kujibiki, la série continue avec l'épisode 06 (Zéro n'abbandonne jamais !). Merci à Zetsubo Sensei qui prend le relais pour la traduction.<br /><br />
Ce Week-End, Mangazur à Toulon. Une petite convention très sympa ^^ J'y serais, n'hésitez pas à me contacter (zero.fansub@gmail.com). Et venez nombreux pour cet événement.");
			$news->setCommentId(59);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Joyeux Anniversaire ! Zéro a un an aujourd'hui. + Kujibiki Unbalance 05");
			$news->setTimestamp(strtotime("18 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/unan.png\" border=\"0\" /><br>Zéro fête aujourd'hui son anniversaire ! Cela fait maintenant un an que le site Zéro existe. Crée le 18 décembre 2007, il était au départ un site de DDL. Ce n'est que le 6 janvier que le site deviens une team de fansub ^^ Pour voir les premières versions, allez sur la page 'À propos...'. Merci à tous pour votre soutien, c'est grâce à vous que nous en sommes arrivés là !<br><br>Comme petit cadeau d'anniversaire, voici l'épisode 05 de Kujibiki Unbalance, en éspérant qu'il vous plaira.<br><br><span style=\"font-weight: bold\">Les dernières sorties de la <a href=\"http://www.sky-fansub.com/\" target=\"_blank\" class=\"postlink\">Sky-fansub</a> :</span><br>Kurozuka 06 HD<br>Mahou Shoujo Lyrical Nanoha Strikers 18");
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep5'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kujian 4, Recrutement Encodeur, Dons pour le sida");
			$news->setTimestamp(strtotime("01 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/sida.png\" border=\"0\" /><br>Ciao !<br>Sortie de Kujibiki Unbalance, l'épisode 04 ! Je tiens à remercier DC, qui, par pitié peut-être ^^, nous a encodé cet épisode.<br><br>Oui ! Comme vous l'avez compris, nous recrutons de manière urgente un encodeur !<br>N'hésitez pas à vous proposer <img src=\"http://img1.xooimage.com/files/s/m/smile-1624.gif\" alt=\"Smile\" border=\"0\" class=\"xooit-smileimg\" /> &gt; <a href=\"index.php?page=recrutement\" target=\"_blank\" class=\"postlink\">Lien</a>.<br><br>Aujourd'hui, 1er décembre, journée internationale du Sida. Nous vous rappelons que les dons et les clicks sur les pubs sont reversés à l'association medecin du monde. Nous avons besoin de vous !<br><a href=\"index.php?page=dons\" target=\"_blank\" class=\"postlink\">En savoir plus sur le fonctionnement des dons sur le site</a><br><a href=\"http://zerofansub.net/#\" target=\"_blank\" class=\"postlink\">En savoir plus sur l'action de l'association</a><br><br>Sinon, Man-Ban nous a fait une jolie fanfic que vous pouvez lire dans la partie Scantrad <img src=\"http://img1.xooimage.com/files/s/m/smile-1624.gif\" alt=\"Smile\" border=\"0\" class=\"xooit-smileimg\" /><br>Merci à tous et à bientôt !<br>//<a href=\"http://db0.fr/\" target=\"_blank\" class=\"postlink\">db0</a>");
			$news->setCommentId(16);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep4'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Fin de la série Sketchbook ~full color's~");
			$news->setTimestamp(strtotime("30 June 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/sketchend.jpg\"><br />
Nous avons temporairement repris de nos activités pour finir la série Sketchbook full color's. Sortie aujourd'hui de 5 épisodes d'un coup : 09, 10, 11, 12 et 13 :) Profitez bien de ctte magnifique série, et à dans deux jours à Japan Expo !");
			$news->setCommentId(98);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('sketchbook', 'ep9'));
			$news->addReleasing(Release::getRelease('sketchbook', 'ep10'));
			$news->addReleasing(Release::getRelease('sketchbook', 'ep11'));
			$news->addReleasing(Release::getRelease('sketchbook', 'ep12'));
			$news->addReleasing(Release::getRelease('sketchbook', 'ep13'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~ full color's ~ 08");
			$news->setTimestamp(strtotime("15 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/sketch8.png\" border=\"0\"><br />V'là déjà la suite de Sketchbook full colors ! L'épisode 08 est disponible, et à peine 2 jours après l'épisode 07 ! Si c'est pas beau, ça ? Allez, détendez-vous un peu en regardant ce joli épisode. <a href=\"index.php?page=series/sketchbook\" target=\"_blank\">En téléchargement ici !</a>");
			$news->setCommentId(72);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('sketchbook', 'ep8'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~ full color's ~ 07");
			$news->setTimestamp(strtotime("12 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/sketch7.jpg\" style=\"float:right;\" border=\"0\">
On avance un peu dans Sketchbook aussi, épisode 07 aujourd'hui ! Apparition d'un nouveau personnage : une étudiante transferée. Cet épisode est plutôt drôle. <a href=\"index.php?page=series/sketchbook\" target=\"_blank\">Et téléchargeable ici !</a>");
			$news->setCommentId(72);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('sketchbook', 'ep7'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~full color's~ 06 + 01v2 + 02v2 + 05v2");
			$news->setTimestamp(strtotime("23 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/sketchh.jpg\" border=\"0\">
Une avalanche de Sketchbook ! Ou plutôt, une avalanche de fleurs ^^ Avec la sortie longtemps attendue de la suite de Sketchbook épisode 06 et de 3 v2 (tout ça pour améliorer la qualité de nos releases) Enjoy !");
			$news->setCommentId(62);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('sketchbook', 'ep6'));
			$news->addReleasing(Release::getRelease('sketchbook', 'ep1'));
			$news->addReleasing(Release::getRelease('sketchbook', 'ep2'));
			$news->addReleasing(Release::getRelease('sketchbook', 'ep5'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~full color's 04~ ; Kanaii DDL et Sky-fansub");
			$news->setTimestamp(strtotime("05 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/moka.jpg\" border=\"0\" /><br>Bouonjòu !<br>L'épisode 04 de Sketchbook est sorti ! <a href=\"index.php?page=series/sketchbook\" target=\"_blank\" class=\"postlink\">Lien</a> Les sorties se font attendre, étant donné qu'on a plus vraiment d'encodeur officiel ^^ Merci à Kyon qui nous a encodé c'lui-ci.<br>Beaucoup nous demandaient où il fallait télécharger nos releases. Probléme réglé, j'ai fait une page qui résume tout. <a href=\"index.php?page=dl\" target=\"_blank\" class=\"postlink\">Lien</a><br>J'offre aussi du DDL à notre partenaire : la team Kanaii. Allez télécharger leurs animes, ils sont très bons ! <a href=\"index.php?page=kanaiiddl\" target=\"_blank\" class=\"postlink\">Lien</a><br>Nous avons aussi un nouveau partenaire : La team Sky-fansub. <a href=\"http://www.sky-fansub.com/\" target=\"_blank\" class=\"postlink\">Lien</a><br>//<a href=\"http://db0.fr/\" target=\"_blank\" class=\"postlink\">db0</a><br>PS : 'Bouonjòu' c'est du niçois <img src=\"http://img1.xooimage.com/files/s/m/smile-1624.gif\" alt=\"Smile\" border=\"0\" class=\"xooit-smileimg\" /><br><br>Les dernières sorties de la <a href=\"http://japanslash.free.fr/\" target=\"_blank\" class=\"postlink\">Maboroshi</a> :<br>- Neo Angelique Abyss 2nd Age 07<br>- Akane Iro Ni Somaru Saka 07");
			$news->setCommentId(17);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('sketchbook', 'ep4'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~full color's 03~");
			$news->setTimestamp(strtotime("22 November 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Bonjour, bonjour !<br>Sortie de l'épisode 03 de Sketchbook full color's !<br>Et c'est tout. Je sais pas quoi dire d'autre. Bonne journée, mes amis. <br>//<a href=\"http://db0.fr/\" target=\"_blank\" class=\"postlink\">db0</a>");
			$news->setCommentId(13);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('sketchbook', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan ~ Ni Gakki OAV 02");
			$news->setTimestamp(strtotime("10 May 2009 01:00"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/knjng2.png\" border=\"0\"><br />La suite tant attendue des aventures de Rin, Kuro et Mimi ! Un épisode riche en émotion qui se déroule pendant la fête du sport où toutes les trois font de leur mieux pour que leur classe, la CM1-1, remporte la victoire ! Toujours en coproduction avec <a href=\"http://www.maboroshinofansub.fr/\" target=\"_blank\">Maboroshi</a>. Cet épisode a été traduit du Japonais par Sazaju car la vosta se faisait attendre, puis \"améliorée\" par Shana. C'est triste, hein ? Plus qu'un et c'est la fin... <a href=\"index.php?page=series/kodomo2\">Ici, ici !</a>");
			$news->setCommentId(69);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo2', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan ~ Ni Gakki OAV 01");
			$news->setTimestamp(strtotime("13 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/knjoav1.png\" border=\"0\">
C'est maintenant que la saison 2 de Kodomo no Jikan commence vraiment ! Profitez bien de cette épisode ^^ Toujours en coproduction avec <a href=\"http://maboroshinofansub.fr\" target=\"_blank\">Maboroshi no fansub</a>, chez qui vous pourrez télecharger l'épisode en XDCC. Chez nous, c'est comme toujours en DDL. Nous vous rappelons que les torrents sont disponibles peu de temps après, et que tout nos épisodes sont disponibles en Streaming HD sur <a href=\"http://www.anime-ultime.net/part/Site-93\" target=\"_blank\">Anime-Ultime</a>.");
			$news->setCommentId(58);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo2', 'ep1'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan ~ Ni Gakki OAV Spécial");
			$news->setTimestamp(strtotime("01 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/nigakki0.jpg\" border=\"0\">
Vous l'attendiez TOUS ! (Si, si, même toi) Il est arrivé ! Le premier OAV de la saison 2 de Kodomo no Jikan. Cet OAV est consacré à Kuro-chan et Shirai-sensei. Amateurs de notre petite goth-loli-neko, vous allez être servis ! Elle est encore plus kawaii que d'habitude ^^ La saison 2 se fait en coproduction avec <a href=\"http://maboroshinofansub.fr\" target=\"_blank\">Maboroshi</a> et avec l'aide du grand (ô grand) DC.");
			$news->setCommentId(55);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo2', 'ep0'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 24 + 25 - FIN");
			$news->setTimestamp(strtotime("29 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<a href=\"images/news/torafin.jpg\" target=\"_blank\"><img src=\"images/news/min_torafin.jpg\" border=\"0\"></a><br /><br />
C'est ainsi que se termine Toradora! ...");
			$news->setCommentId(53);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep24'));
			$news->addReleasing(Release::getRelease('toradora', 'ep25'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 23");
			$news->setTimestamp(strtotime("27 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/tora23.png\" border=\"0\">
La suite de Toradora! avec l'épisode 23. Toujours aussi émouvant, toujours aussi kawaii, toujours aussi Taiga-Ami-Minorin-Ryyuji-ect, toujours aussi dispo sur <a href=\"http://toradora.fr/\" target=\"_blank\">Toradora.fr!</a>, toujours aussi en copro avec <a href=\"http://japanslash.free.fr\" target=\"_blank\">Maboroshi</a>, toujours en DDL sur notre site <a href=\"index.php?page=series/toradora\">\"Lien\"</a>, Bref, toujours aussi génial ! Enjoy ^^<br /><br />Discutons un peu (dans les commentaires) ^^<br />Que penses-tu des Maid ? Tu es fanatique, fétichiste, amateur ou indifférent ?");
			$news->setCommentId(52);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep23'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 22");
			$news->setTimestamp(strtotime("25 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/taiiga.jpg\" border=\"0\">
Que d'émotion, que d'émotion ! La suite de Toradora!, l'épisode 22. Nous vous rappelons que vous pouvez aussi télécharger les épisodes et en savoir plus sur la série sur <a href=\"http://toradora.fr/\" target=\"_blank\">Toradora.fr!</a>. Sinon, les épisodes sont toujours téléchargeables chez <a href=\"http://japanslash.free.fr\" target=\"_blank\">Maboroshi</a> en torrent et XDCC et chez nous <a href=\"index.php?page=series/toradora\">par ici en DDL.</a> Enjoy ^^");
			$news->setCommentId(51);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep22'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 21");
			$news->setTimestamp(strtotime("23 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/ski.jpg\" border=\"0\"><br /><br />
Toradora! encore et encore, et bientôt, la fin de la série. Cet épisode est encore une fois bourré d'émotion et de rebondissements... Et de luge, et de neige, et de skis ! <a href=\"index.php?page=series/toradora\">C'est par ici que ça se télécharge !</a><br /><br />Profitions-en pour discutailler ! Alors, toi, lecteur de news de Zéro... Tu es parti en vacances, faire du ski ? Raconte-nous tout ça dans les commentaires ;)");
			$news->setCommentId(50);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep21'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 19");
			$news->setTimestamp(strtotime("16 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/taigahand.jpg\" border=\"0\"><br />
Après une semaine d'absence (je passais mon Bac Blanc >.< ), nous reprenons notre travail. Ou plutôt, notre partenaire <a href=\"http://japanslash.free.fr\" target=\"_blank\">Maboroshi</a> nous fait reprendre le travail ^^ Sortie de l'épisode 19 de toradora, avec notre petite Taiga toute kawaii autant sur l'image de cette news que dans l'épisode ! Comme d'hab, DDL sur le site, Torrent bientôt (Merci à Khorx), XDCC bientôt et déjà dispo chez <a href=\"http://japanslash.free.fr\" target=\"_blank\">Maboroshi</a>. <a href=\"index.php?page=series/toradora\">\"Ze veux l'épisodeuh !\"</a>.");
			$news->setCommentId(46);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep19'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 18");
			$news->setTimestamp(strtotime("05 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/noeltora.jpg\" border=\"0\">
Serait-ce le rythme \"une sortie / un jour\" qui nous prend, à Zéro et <a href=\"http://japanslash.free.fr\" target=\"_blank\">Maboroshi</a> ? Peut-être, peut-être... En tout cas, voici la suite de Toradora!, l'épisode 18 ! <a href=\"index.php?page=series/toradora\">Je DL tisouite !</a>");
			$news->setCommentId(43);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep18'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 16");
			$news->setTimestamp(strtotime("25 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/blond.jpg\" border=\"0\">
Toradora!, pour changer, en copro avec <a href=\"http://japanslash.free.fr/\" target=\"_blank\" class=\"postlink\">Maboroshi no Fansub</a>. Un épisode plein d'émotion, de tendresse et de violence à la fois. À ne pas manquer ! <a href=\"index.php?page=series/toradora\" target=\"_blank\" class=\"postlink\">L'épisode en DDL, c'est par ici !</a>");
			$news->setCommentId(39);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep16'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 15 et Chibi JE Sud");
			$news->setTimestamp(strtotime("20 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/chibi.jpg\" border=\"0\" /><br> En pleine chibi Japan Expo Sud, Toradora! continue avec ce soir l'épisode 15 !<br> <a href=\"index.php?page=series/toradora\" target=\"_blank\" class=\"postlink\">L'épisode en DDL, c'est par ici !</a><br> Rejoignez nous pour cet évenement : <br> Chibi Japan Expo à Marseille ! J'y serais, Kanaii y sera. Nous serions ravis de vous rencontrer, alors n'hésitez pas à me mailer (Zero.fansub@gmail.com).<br><br> Dernières sortie de nos partenaires :<br> Kyoutsu : Minami-ke Okawari 02 et Ikkitousen OAV 04<br> Kanaii : Kamen no Maid Guy 08<br> Sky-fansub : Kurozuka 09 et Mahou Shoujo Lyrical Nanoha Strikers 25");
			$news->setCommentId(41);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('toradora', 'ep15'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 12-13-14");
			$news->setTimestamp(strtotime("17 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/dentifrice.jpg\" border=\"0\" /><br> db0 s'excuse pour sa news ultra-courte de la dernière fois pour Maria Holic 3 et en compensasion va raconter sa vie dans celle-ci (Non, pas ça !). C'est aujourd'hui et pour la première fois chez Zéro une triple sortie ! Les épisodes 12, 13 et 14 de Toradora! sont disponibles, toujours en copro avec <a href=\"http://japanslash.free.fr/\" target=\"_blank\" class=\"postlink\">Maboroshi</a>.<br> <a href=\"index.php?page=series/toradora\" target=\"_blank\" class=\"postlink\">Les épisodes en DDL, c'est par ici !</a><br><br> J'en profite aussi pour vous préciser que les 2 autres versions de Maria 03 sont sorties.<br> Mais surtout, je vous sollicite pour une IRL :<br> Chibi Japan Expo à Marseille ! J'y serais, Kanaii y sera. Nous serions ravis de vous rencontrer, alors n'hésitez pas à me mailer (Zero.fansub@gmail.com).");
			$news->setCommentId(40);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('toradora', 'ep12'));
			$news->addReleasing(Release::getRelease('toradora', 'ep13'));
			$news->addReleasing(Release::getRelease('toradora', 'ep14'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 11");
			$news->setTimestamp(strtotime("11 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"http://japanslash.free.fr/images/news/toradora11.jpg\" border=\"0\" /> <br> La suite, la suite ! Toradora! épisode 11 sortie, en copro avec <a href=\"http://japanslash.free.fr/\" target=\"_blank\" class=\"postlink\">Maboroshi no Fansub</a>.<br><br><br> <a href=\"index.php?page=series/toradora\" target=\"_blank\" class=\"postlink\">L'épisode en DDL, c'est par ici !</a>");
			$news->setCommentId(39);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep11'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 10");
			$news->setTimestamp(strtotime("10 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/ami.png\" border=\"0\" /> <br> En direct de Nice, et pour ce 10 Février, l'épisode 10 de Toradora! en co-production avec <a href=\"http://japanslash.free.fr/\" target=\"_blank\" class=\"postlink\">Maboroshi no Fansub</a>, qui est de retour, comme vous l'avez vu ! (Avec Kannagi 01, Mermaid 11-12-13 et Kimi Ga 4). Pour Toradora!, nous allons rattraper notre retard !<br><br><br> <a href=\"index.php?page=series/toradora\" target=\"_blank\" class=\"postlink\">L'épisode en DDL, c'est par ici !</a>");
			$news->setCommentId(39);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep10'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 09");
			$news->setTimestamp(strtotime("04 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/tora.jpg\" border=\"0\" /> <br> L'épisode 09 de Toradora! est terminé ! Nous avons pris du retard car la MNF (en co-production) est actuellement en pause temporaire (Tohru n'a plus internet).<br> <a href=\"index.php?page=series/toradora\" target=\"_blank\" class=\"postlink\">Pour télécharger les épisodes en DDL, cliquez ici !</a><br><br>  <span style=\"font-weight: bold\">Les dernières sorties de la <a href=\"http://www.sky-fansub.com/\" target=\"_blank\" class=\"postlink\">Sky-fansub</a> :</span><br> Kurozuka 07<br> Mahou Shoujo Lyrical Nanoha Strikers 20<br> <br> <span style=\"font-weight: bold\">Les dernières sorties de la <a href=\"http://kyoutsu-subs.over-blog.com/\" target=\"_blank\" class=\"postlink\">Kyoutsu</a> :</span><br> Hyakko 05<br> <br> <span style=\"font-weight: bold\">Les dernières sorties de la <a href=\"http://www.kanaii.com/\" target=\"_blank\" class=\"postlink\">Kanaii</a> :</span><br> Kamen no maid Guy 06<br> Rosario+Vampire Capu2 06");
			$news->setCommentId(31);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 07");
			$news->setTimestamp(strtotime("24 November 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/toradora.png\" border=\"0\" /><br>Ohayo mina !<br>La suite de Toradora est arrivée ! Et toujours en co-production avec la Maboroshi  <img src=\"http://img1.xooimage.com/files/s/m/smile-1624.gif\" alt=\"Smile\" border=\"0\" class=\"xooit-smileimg\" /> <br>Cet épisode se déroule à la piscine, et 'Y'a du pelotage dans l'air !' Je n'en dirais pas plus.<br>L'épisode est sorti en DDL en format avi, en XDCC. Comme toujours, il sortira un peu plus tard en H264, torrent, streaming, ect.<br>//<a href=\"http://db0.fr/\" target=\"_blank\" class=\"postlink\">db0</a>");
			$news->setCommentId(14);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep7'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Nouveau XDCC, Radio, Scantrad et Toradora! 06");
			$news->setTimestamp(strtotime("20 November 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/img_shinobu.gif\" border=\"0\" /><br>Bonjour tout le monde !<br>J'ai aujourd'hui plusieurs bonnes nouvelles à vous annoncer :<br>La V3 avance bien, et je viens de mettre à jour les pages pour le scantrad, car comme vous le savez, nous commençons grâce à François et notre nouvelle recrue Merry-Aime notre premier projet scantrad : Kodomo no Jikan.<br>J'ai aussi installée la radio tant attendue et mis sur le site quelques OST.<br>Nous avons aussi, grâce à Ryocu, un nouveau XDCC. Vous aviez sans doute remarquer que nous ne pouvions pas mettre à jour le précédent. Celui-ci sera mis à jour à chaque nouvelle sortie.<br>Et enfin, notre dernière sortie : Toradora! 06. Toujours en co-production avec<a href=\"http://japanslash.free.fr/\" target=\"_blank\" class=\"postlink\">Maboroshi</a>.<br>Enjoy  <img src=\"http://img1.xooimage.com/files/w/i/wink-1627.gif\" alt=\"Wink\" border=\"0\" class=\"xooit-smileimg\" /> <br>//<a href=\"http://db0.fr/\" target=\"_blank\" class=\"postlink\">db0</a>");
			$news->setCommentId(7);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('toradora', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan 12 FIN");
			$news->setTimestamp(strtotime("06 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/kodomo12fin.png\" border=\"0\"><br />
C'est ainsi, en ce 6 mars 2009, que nous fêtons à la fois l'anniversaire de la première release de Zéro (Kodomo no Jikan OAV) et l'achevement de notre première série de 12 épisodes. L'épisode 12 de Kodomo no Jikan sort aujourd'hui pour clore les aventures de nos 3 petites héroïnes : Rin, Mimi et Kuro. Il est dispo en DDL sur <a href=\"http://kojikan.fr\">le site Kojikan.fr</a>. Un pack des 12 épisodes sera bientôt disponible en torrent. <br /><a href=\"http://kojikan.fr/?page=saison1-dl_1\" target=\"_blank\">Télécharger en DDL !</a>");
			$news->setCommentId(44);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo', 'ep12'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kojikan 10");
			$news->setTimestamp(strtotime("03 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/kodomo10.jpg\" border=\"0\" /><br> RIIINN est revenue ! Elle nous apporte son dixième épisode. Plus que 2 avant la fin, et la saison 2 par la suite. Une petite surprise arrive bientôt, sans doute pour le onzième épisode. En attendant, retrouvez vite notre petite délurée dans la suite de ses aventures et ses tentatives de séduction de Aoki-sensei...");
			$news->setCommentId(37);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo', 'ep10'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan 09, Recrutement QC, trad it&gt;fr");
			$news->setTimestamp(strtotime("13 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/kodomo9.jpg\" border=\"0\" /><br>Rin, Kuro et Mimi reviennent enfin vous montrer la suite de leurs aventures ! Sortie aujourd'hui de l'épisode 09, merci à DC qui nous l'a encodé. Les 3 versions habituelles sont dispos en DDL.<br><br>Nous recrutons toujours un QC ! Proposez-vous !<br>Nous avons décider de reprendre le projet Mermaid Melody Pichi Pichi Pitch, mais pour cela nous avons besoin d'un traducteur italien &gt; français. N'hésitez pas à postuler si vous êtes intéressés <img src=\"http://img1.xooimage.com/files/s/m/smile-1624.gif\" alt=\"Smile\" border=\"0\" class=\"xooit-smileimg\" /> Par avance, merci. <a href=\"index.php?page=recrutement\" target=\"_blank\" class=\"postlink\">Lien</a><br><br><span style=\"font-weight: bold\">Les dernières sorties de la <a href=\"http://www.kanaii.com/\" target=\"_blank\" class=\"postlink\">Kanaii</a> :</span><br>Kanokon pack DVD 06 à 12<br>Rosario + Vampire S2 -05<br><span style=\"font-weight: bold\">Les dernières sorties de la <a href=\"http://www.sky-fansub.com/\" target=\"_blank\" class=\"postlink\">Sky-fansub</a> :</span><br>Kurozuka 05 HD<br>Mahou Shoujo Lyrical Nanoha Strikers 17");
			$news->setCommentId(22);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kodomo', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Joyeuses fêtes !");
			$news->setTimestamp(strtotime("26 December 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setMessage("<img src=\"images/news/noel0.jpg\" alt=\"merry christmas ore no imouto\" /><br /><br />
Une autre année se termine, mais ne vous en faite pas, nous on continue ! Même si on semble être au point mort, ça s'active dans les coulisses. Ne perdez pas espoir, vos commentaires ne sont pas tombés aux oubliettes !<br /><br />
Toute l'équipe de Zéro Fansub vous souhaite de joyeuses fêtes de fin d'année et espère vous retrouver l'année prochaine pour de nouvelles séries ! N'hésitez pas à passer sur le forum pour nous soutenir !<br /><br /><br />
<img src=\"images/news/noel1.jpg\" alt=\"merry christmas ore no imouto\" /><br /><br />
<img src=\"images/news/noel2.jpg\" alt=\"merry christmas ore no imouto\" /><br /><br />
PS : Le projet Canaan est licencié par Kaze. Le dvd de l'integrale est déjà disponible en pré-order !<br /><br />
<img src=\"images/news/dvdcanaan.jpg\" alt=\"DVD canaan buy pre-order kaze\" />");
			$news->setCommentId(250);
			$news->setTeamNews(true);
			$news->setTwitterTitle("Toute l'equipe Zero fansub vous souhaitent de joyeuses fetes !");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Newsletter");
			$news->setTimestamp(strtotime("30 June 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Pour ceux qui ne seraient pas au courant, 
il est possible de recevoir un mail à chaque fois q'une \"news\" (sorties ou autre) apparait sur le site.<br />
Pour bénéficier de ce service et être les premier au courant, il suffit de vous inscrire sur le forum :<br />
<a href=\"http://forum.zerofansub.net/profile.php?mode=register&agreed=true\" target=\"_blank\">S'inscrire !</a><br />
<br />
<div class=\"left\">
<ul>
<li>Vous n'êtes pas obligés d'être un membre actif du forum pour la recevoir.</li>
<li>Nous ne divulgons votre adresse e-mail à personne.</li>
<li>À tout moment, vous pouvez arrêter votre abonnement (lien en bas des newsletter).</li>
<li>Nous ne vous envoyons rien de plus que nos news : pas de spams, de pubs, etc.</li>
</ul>
</div>
<br />
Pour les habitués des flux RSS, vous pouvez aussi suivre nos news :<br />
<a href=\"http://zerofansub.feedxs.com/zero.rss\" target=\"_blank\">Flux RSS</a><br /><br />
<img src=\"images/news/newsletters.jpg\" alt=\"Newsletter Zéro fansub\" />");
			$news->setCommentId(235);
			$news->setTeamNews(true);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("L'école du fansub + Mayoi Neko Overrun!");
			$news->setTimestamp(strtotime("22 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/ecolelogo.png\" /><br /><br />
Suite au succès inattendu de la précédente news, nous avons décider d'ouvrir une séction spéciale dans Zéro fansub : L'école du fansub.<br /><br />
<div style=\"text-align: left\"><b>Le Concept</b><br />
Donner les moyens à des personnes motivées mais n'ayant aucune éxpérience en fansub d'entrer dans une équipe en les formant depuis la base.<br />
<br />
<b>Comment ça marche ?</b><br />
Parce que la pratique vaut mieux que la simple théorie, on vous demandera d'effectuer des exercices et activités concrètes qui seront tout de suite utilisés pour l'équipe. Il y aura des tâches à faire avec des dates de rendus (assez flexibles) et vous ne serez jamais seuls puisqu'une section \"salle des profs\" vous permet de poser toutes les questions que vous voulez aux membres de l'équipe.<br />
<br />
<b>Quelles sont les qualités requises ?</b><br />
- Être très motivé<br />
- Être disponible<br />
- Être patient<br />
- Avoir envie de découvrir les coulisses du fansub<br />
- Avoir la soif d'apprendre<br />
- Être prêt à effectuer des taches pas très amusantes pour commencer<br />
- N'avoir pas ou peu d'éxpérience en fansub<br />
<br />
<b>Comment vais-je évoluer ?</b><br />
À chaque exercice rendu, le prof de la matière vous donnera une note basée sur des critères précis avec des bonus et des malus ainsi qu'un commentaire. Vous saurez ainsi apprendre de vos erreurs pour progresser.<br />
<br />
<b>Quelles sont les matières enseignées et par qui ?</b><br />
Actuellement, nous enseignons dans notre école :<br />
<ul>
<li>Utilisation du logiciel Aegisub pour le timing, l'édition, ect - db0</li>
<li>Apprentissage du langage ASS pour l'édition, le karaoké, ect - db0</li>
<li>Programmation orientée web, XHTML/CSS/PHP - db0, Sazaju</li>
<li>Programmation en tout genre - db0, Sazaju</li>
<li>Cours de langue, Japonais écrit et oral - Sazaju</li>
<li>Cours de langue, Anglais - TchO, praia</li>
<li>Français écrit, grammaire orthographe - TchO, praia</li>
<li>Scantraduction, photoshop & co - db0</li>
</ul><br />
Par la suite seront enseignés l'encodage vidéo et l'utilisation du logiciel After Effect pour les effets vidéos.<br />
<br />
<b>Comment y entrer ?</b><br /></div>
Déjà 11 personnes qui ont postulée pour entrer à l'école du fansub, dont 7 qui y sont entrées.<br/>Et vous ?<br/>
<span>~ <a href=\"http://forum.zerofansub.net/t981-Comment-entrer-dans-l-ecole-du-fansub.htm\" target=\"_blank\">Postuler</a> ~</span><br /><br />

À l'occasion de l'ouverture de cette école pas comme les autres, nous commencons une série :<br />
Mayoi Neko Overrun!<br />
qui sera entièrement fansubbée par les élèves de l'école du fansub épaulés par leurs professeurs.<br /><br />
<img src=\"images/news/newsmayoi.jpg\" />");
			$news->setCommentId(226);
			$news->setTeamNews(true);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement novice");
			$news->setTimestamp(strtotime("19 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/newsrecru.png\" /><br />
Bonjour tout le monde !<br />
Actuellement, nous recherchons quelqu'un qui n'a aucune conaissance ni éxpérience en fansub pour rejoindre nos rangs.<br />
Au départ, pour effectuer des tâches très simples qui nous permettrons d'aller plus vite dans nos sorties, et petit à petit d'apprendre les différents domaines du fansub à nos côtés.<br />
Vous devez pour ça être très motivé, avoir envie de découvrir les coulisses du fansub, être présent et actif parmi nous, avoir la soif d'apprendre et être prêt à faire des tâches pas forcément très amusantes pour commencer.<br />
Fiche à remplir :<br /><br />
[b]Rôle[/b] Novice<br />
[b]Prénom[/b] REMPLIR<br />
[b]Âge[/b] REMPLIR<br />
[b]Lieu[/b] REMPLIR<br />
[b]Motivation[/b] REMPLIR<br />
[b]Expérience fansub[/b] REMPLIR<br />
[b]Expérience hors fansub[/b] REMPLIR<br />
[b]CDI ou CDD (durée) ? [/b] CDI<br />
[b]Disponibilités[/b] REMPLIR<br />
[b]Déjà membres d'autre équipe ?[/b] REMPLIR<br />
[b]Si oui, lesquelles ?[/b] REMPLIR<br />
[b]Connexion internet[/b] REMPLIR<br />
[b]Systéme d'exploitation[/b] REMPLIR<br />
[b]Autre chose à dire ?[/b] REMPLIR");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sondage : Vos séries préférées, les résultats");
			$news->setTimestamp(strtotime("31 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/sondageres.png\" /><br />
Nous vous avons laissé 5 jours pour répondre au sondage et le nombre de participants nous a positivement étonné, étant donné que le nombre de visiteurs est en baisse comparé à l'an dernier.<br />
Vous avez été 24 personnes à participer et à défendre votre série préférée.<br />
Les votes ont été comptabilisés de la manière suivante : Une série en première place vaut 5 points, deuxième 4, troisème 3, quatrième 2 et cinquième 1. Si vous n'avez voté que pour une série, vous lui avez donné 5 points. J'ai vérifié rapidement les adresses IP et il n'y a pas eu d'abérances donc je considère que personne n'a triché.<br />
Sans plus attendre, les résultats :
<a href=\"index.php?page=series/kissxsis\"><img src=\"images/series/kissxsis.png\" border=\"0\" alt=\"KissXsis\"></a><br />
KissXsis, OAV3 et série avec 51 points. La série bennéficiera donc du mode Toradora! dès sa sortie. Pour ceux qui ne conaissent pas le mode Toradora!, c'est le nom que la team donne aux séries dont les épisodes sortent moins d'une semaine après la vosta.<br />
<a href=\"index.php?page=series/kujibiki\"><img src=\"images/series/kujibiki.png\" border=\"0\" alt=\"Kujibiki Unbalance 2\"></a><br />
En seconde place, Kujibiki Unbalance 2 avec 44 points. Pour être honnêtes, nous nous attendions à avoir Kanamemo en seconde place. Ceci nous montre que beaucoup de leechers foncent sur la première sortie d'une série, et si Kujibiki Unbalance avait été fait par une autre team plus rapide, elle n'aurait sûrement pas cette place-là. Déçus, mais nous nous doutions bien que la plupart des gens préférent la rapidité à la qualité.<br />
<a href=\"index.php?page=series/kimikiss\"><img src=\"images/series/kimikiss.png\" border=\"0\" alt=\"Kimikiss pure rouge\"></a><br />
Kimikiss Pure Rouge, avec 28 points. Ici, c'est l'étonnement inverse. Une série pour laquelle nos épisodes sont tous à refaire dû à leurs médiocrité (des v2 dont prévus pour les épisodes 1 à 6) et terminée chez plusieurs autres teams. Nous sommes dans l'incompréhension, mais ça nous fait plaisir de voir qu'on attends cette série de nous :)<br />
<a href=\"index.php?page=series/kannagi\"><img src=\"images/series/kannagi.png\" border=\"0\" alt=\"Kannagi\"></a><br />
Kannagi remporte 27 points. Nous n'avons pas encore sortis d'épisodes pour cette série malgré qu'ils soient presque tous terminés car nous pensions que cette série n'aurait pas beaucoup de succès. Une quatrième place, c'est pas mal, il va falloir qu'on s'y mette.<br />
<a href=\"index.php?page=series/kanamemo\"><img src=\"images/series/kanamemo.png\" border=\"0\" alt=\"Kanamemo\"></a><br />
Kanamemo avec 23 points. Grosse décéption pour une série que nous mettions en priorité sur les autres avant ce sondage. Nous soupçonnons nos fans de préférer nos concurrents pour une série qui reflète pourtant l'état d'esprit de notre équipe.<br />
<a href=\"index.php?page=series/hitohira\"><img src=\"images/series/hitohira.png\" border=\"0\" alt=\"Hitohira\"></a><br />
Hitohira avec 17 points. Rien d'étonnant, nous savions que cette série n'avait pas beaucoup de succès.<br />
<a href=\"index.php?page=series/potemayo\"><img src=\"images/series/potemayo.png\" border=\"0\" alt=\"Potemayo\"></a><br />
Potemayo avec 9 points. Un tout petit peu déçu mais pas étonnés pour autant. La série est un peu niaise, mais moi je l'aime beaucoup ^^<br />
<a href=\"?page=havert\"><img src=\"images/series/hshiyo.png\" alt=\"Faisons l'amour ensemble, Issho ni H shiyo\" border=\"0\"></a><br />
En bon dernier, Issho ni H shiyo avec 5 points (un seul vote). Et pourtant, les statistiques sont claires, ce sont les hentaïs qui nous rapportent le plus de visiteurs, les épisodes sont beaucoup plus téléchargés en ddl et ce sont les torrents hentaïs qui sont le plus seedés. Au niveau popularité, nous savons que ce sont de loins les hentaïs qui l'emportent, mais nous savons aussi que ce sont les fans de hentaïs qui sont le moins verbeux. Tant pis pour eux ! Nous prendrons en compte les résultats de ce sondage.<br /><br />
Encore merci à tous d'avoir voté ! `A bientôt pour les sorties très prochaines de Kujian et Isshi ni H shiyo !");
			$news->setCommentId(218);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sondage : Quelles sont vos séries préférées ?");
			$news->setTimestamp(strtotime("26 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/newssondage.png\" /><br />
Vous commencez à nous connaître !<br />
Du moins, si vous lisez nos news un peu longues.<br />
Je résume.<br />
L'état d'esprit Zéro est simple : Nous ne faisons pas du fansub pour nous, pour faire plaisir à nous-mêmes, mais pour promouvoir l'animation japonaise, permettre l'accessibilité aus francophones aux séries qu'ils ne peuvent pas trouver (en France), et nous respectons le fameux slogan \"Par des fans, pour des fans.\".<br />
Oui, mes amis !<br />
Ce que l'équipe Zéro fait, du simple sous-titrage à la recherche de qualité, c'est pour vous tous, et uniquement pour vous que nous le faisons.<br />
C'est la raison pour laquelle j'ai décidé aujourd'hui d'effectuer un sondage pour répondre au mieux à vos attentes.<br />
<b>Quelles sont vos séries préférées, parmi celles que nous sous-titrons ? Lesquelles attendez-vous avec le plus d'impatience ?</b><br />
Pour y répondre, c'est très simple, il suffit de poster un commentaire avec soit une liste, soit un argumentaire, bref, ce que vous voulez pour défendre vos séries préférées.<br />
À l'issue de ce sondage, nous vous annoncerons les résultats, et les séries les plus attendues seront mises en priorité dans notre travail pour toujours mieux vous satisfaire.<br />
J'éspère que vous serez nombreux à nous donner votre avis !<br /><br />
<a href=\"index.php?page=series/hitohira\"><img src=\"images/series/hitohira.png\" border=\"0\" alt=\"Hitohira\"></a><br /><br />
<a href=\"index.php?page=series/kanamemo\"><img src=\"images/series/kanamemo.png\" border=\"0\" alt=\"Kanamemo\"></a><br /><br />
<a href=\"index.php?page=series/kannagi\"><img src=\"images/series/kannagi.png\" border=\"0\" alt=\"Kannagi\"></a><br /><br />
<a href=\"index.php?page=series/kimikiss\"><img src=\"images/series/kimikiss.png\" border=\"0\" alt=\"Kimikiss pure rouge\"></a><br /><br />
<a href=\"index.php?page=series/kissxsis\"><img src=\"images/series/kissxsis.png\" border=\"0\" alt=\"KissXsis\"></a><br /><br />
<a href=\"index.php?page=series/kujibiki\"><img src=\"images/series/kujibiki.png\" border=\"0\" alt=\"Kujibiki Unbalance 2\"></a><br /><br />
<a href=\"index.php?page=series/potemayo\"><img src=\"images/series/potemayo.png\" border=\"0\" alt=\"Potemayo\"></a><br /><br />");
			$news->setCommentId(217);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tracker torrent, le retour ! Recrutement Seeders");
			$news->setTimestamp(strtotime("09 February 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/seedep.png\" /><br />
.Après une très longue pause, notre tracker torrent est de retour ! Tarf a repris les rênes et nos épisodes ne devraient pas tarder à être disponibles en torrent.<br />
Oui, mais pour qu'il marche jusqu'au bout, il nous faut du monde qui soit là, prêt à sacrifier un peu de leur connexion pour partager avec Tarf nos épisodes.<br />
Si vous êtes interessé pour devenir seeder de la team, cliquez sur le lien de postulat ci-dessous. Nous éspérons que vous serez nombreux à nous aider !
<br /><br />
<span>~ <a href=\"http://forum.zerofansub.net/posting.php?mode=newtopic&f=21\" target=\"_blank\">Postuler en tant que seeder</a> ~</span>");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Konshinkai fansub, la réunion des amateurs de fansub français");
			$news->setTimestamp(strtotime("17 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Le rendez-vous est fixé pour la prochaine convention : Paris manga.<br />
C'est donc le 6 Février.<br />
On reste sur le même restaurant qu'à Konshinkai 1, un petit restaurant Jap' très sympathique et pas très cher près de Charle de Gaulle étoile. Toutes les infos pour s'y rendre sont sur le site partie \"Rendez-vous\".<br />
<br />
Pour ceux qui ne conaissent pas encore Konshinkai, c'est une réunion de fansubbeurs et d'amateurs de fansub français (comme vous êtes sûrement puisque vous êtes chez Zéro fansub ;))<br />
<br />
Dans un petit restaurant, nous discutons sans prise de tête et chacun expose ses points de vue dans une ambiance sympathique.<br />
<br />
Nous en sommes aujourd'hui à la troisième édition et les membres de Zéro risquent fort d'y être, donc si vous voulez les rencontrer mais aussi discuter ensemble de nos passions communes, nous vous attendons avec impatience !<br />
<br />
Venez nombreux, parlez en autours de vous !<br />
<br />
<a href=\"http://konshinkai.c.la\" target=\"_blank\">Le site officiel Konshinkai fansub, pour plus d'informations
<br /><br />
<img src=\"archives/konshinkai/images/interface/konshinkai3.png\" width=\"600\" alt=\"Konshinkai fansub\" /></a>");
			$news->setCommentId(183);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Joyeux Anniversaire ! Zéro a deux ans.");
			$news->setTimestamp(strtotime("18 December 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/anniv1.jpg\" /><br />
Aujourd'hui est un grand jour pour Zéro et pour la db0 company ! Cela fait maintenant exactement deux ans que le groupe Zéro existe, donc j'en profite pour faire un petit résumé de ces deux années riches en evennements.<br />
db0 créer le site \"Zéro\", qui vient de la dernière lettre de son pseudo le 18 décembre 2007. Au départ, c'est un énième site de liens MU et torrent pour télécharger des animes. db0 rencontre ensuite Genesis et se met au fansub. Elle créait ensuite avec et grâce à cette équipe une nouvelle équipe de fansub qui prend la place de l'ancien site Zéro mais garde le design. Les débuts de Zéro sont difficiles. La formation fansub de db0 s'est en grande partie faite par Klick et le reste de l'équipe Genesis. D'autres membres ont ensuite rejoint l'équipe, dont praia qui deviendra par la suite le co-administrateur de l'équipe. Ryocu rejoint ensuite l'équipe en nous hebergant le site et les épisode en DirectDownload. L'équipe s'agrandit petit à petit, devient amie avec Maboroshi, Kanaii, Animekami, Moe, Kyoutsu, Sky, ect. db0 et Ryocu reprennent ensemble la db0 company et tout ses nombreux sites, dont Anime-ultime et Stream-Anime. Ces sites nous coûtent actuellement dans les environs de 300 à 350€ par mois, et nous avons toujours beaucoup de mal à les financer. Un quatrième \"gros\" site devait ouvrir cet été mais est sans cesse repoussé pour des raisons financières. Stream-Anime a malheuresement fermé ses portes recemment, emportant avec lui ses plus de 5000 vidéos en streaming haute qualité. Malgré ce triste bilan financier, Zéro et la db0 company se porte plutôt bien. Zéro a désormais une équipe soudée et motivée qui ne risque pas de s'arrêter de si tôt. Pour plus d'informations sur la db0 company, un historique complet et détaillé est disponible sur le forum.<br /><br />
Concernant les évennements à venir, un nouveau design de Zéro fansub et d'Anime-Ultime sont prévu. La db0 company devrait bientôt ouvrir un site et regrouper les communautés.<br /><br />
Pour finir, je tenais à remercier toutes les personnes qui nous soutiennent. Financierement bien sûr, mais aussi avec les commentaires qui nous vont droit au coeur et qui nous donnent envie d'avancer. Sachez que Zéro a un état d'esprit qui s'éloigne beaucoup de celui des autres équipes de fansub. Nous ne faisons pas du fansub parce qu'on prend notre pied en sous-titrant des animes (oh oui encore plus de time plan, j'aime ça !), mais parce que nous sommes avant tout fans de l'animation japonaise et c'est avant tout pour vous, les fans comme nous, que nous sous-titrons des animes. C'est la raison pour laquelle nous sommes toujours à l'écoute de nos fans adorés, que nous tenons énormément compte des commentaires sur le site qui nous guident sur ce que nous fansubbons en priorité. C'est grâce à vous et surtout pour vous que nous existons. Votre soutien nous fait vivre et nous donne envie d'aller plus loin. Merci.<br /><br />
Et Bon Anniversaire Zéro ! <br /><br />
<img src=\"images/news/anniv2.jpg\" />");
			$news->setCommentId(155);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement Editeur ASS/AE");
			$news->setTimestamp(strtotime("10 December 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/edit.jpg\" /><br />
J'ai toujours tenu depuis la création de l'équipe Zéro à m'occuper personnellement des edits des épisodes. On peut d'ailleurs voir l'évolution de mon niveau au fur et à mesure des épisodes :)  Cependant, aujourd'hui, Zéro connaît un réel ralentissement et j'en prend l'entière résponsabilité : ayant commencé mes études supérieures, j'ai bien moins de temps que ce que j'en avais à l'époque où j'étais lycéenne. J'ai donc décidé, avec certes quelques regrets, d'intégrer un nouveau membre dans l'équipe pour faire les edits à ma place.<br /><br />
Nous recrutons donc un <b>éditeur ASS ou After Effect</b> si possible expérimenté, ayant un minimum de capacités et de motivation. Si vous êtes interessés, postez un topic dans la partie recrutement du forum avec la fiche de renseignement suivante :<br />
[b]Rôle[/b] REMPLIR<br />
[b]Prénom[/b] REMPLIR<br />
[b]Âge[/b] REMPLIR<br />
[b]Lieu[/b] REMPLIR<br />
[b]Motivation[/b] REMPLIR<br />
[b]Expérience fansub[/b] REMPLIR<br />
[b]Expérience hors fansub[/b] REMPLIR<br />
[b]CDI ou CDD (durée) ? [/b] REMPLIR<br />
[b]Disponibilités[/b] REMPLIR<br />
[b]Déjà membres d'autre équipe ?[/b] REMPLIR<br />
[b]Si oui, lesquelles ?[/b] REMPLIR<br />
[b]Connexion internet[/b] REMPLIR<br />
[b]Systéme d'exploitation[/b] REMPLIR<br />
[b]Autre chose à dire ?[/b] REMPLIR<br /><br />
Ainsi que le très important test de validation. Le test est le suivant :<br />
Réaliser l'edit du titre de début le plus ressemblant possible au titre de la série, à la différence qu'il ne doit pas y avoir écrit le titre de la série mais \"Zéro fansub\" ou \"Zéro fansub présente\". Ass ou After Effect. Vous pouvez nous envoyer : soit un script, soit une vidéo encodée ET un script. Au choix :<br />
- <a href=\"http://zerofansub.net/ddl/RAW_Kanamemo/%5bZero-Raws%5d%20Kanamemo%20-%2001%20RAW%20(TVO%201280x720%20x264%20AAC%20Chap).mp4\">Titre Kanamemo, à 01:03:60</a> (mouvant obligatoire)<br />
- <a href=\"http://zerofansub.net/ddl/RAW_KissXsis/Kiss%d7sis_OAD_2_Raw_Travail_ED_non_bobb%e9.avi\">Titre KissXsis, à 02:03:12</a> (immobile ou mouvant)<br />
J'éspère que vous serez nombreux à répondre à notre demande ! Merci à tous de suivre nos épisodes.");
			$news->setCommentId(154);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Konshinkai ~ fansub");
			$news->setTimestamp(strtotime("26 October 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/afkonsh.png\" /><br />
Bonjour cher ami gentils amis leechers.<br /><br />
\"Encore une nouvelle équipe de fansub ?\", vous allez vous dire, avec le titre de la news. Eh bien non ! \"Konshinkai\" signifie en japonais \"Réunion amicale\", et c'est exactement le but de notre projet.<br /><br />
Notre but est de réunir toutes les équipes de fansub française à une petite soirée pour discuter amicalement de notre passion commune : le fansub. Nous invitons donc toutes les personnes travaillant dans le fansub, et pas seulement les chefs d'équipes, toutes les personnes ayant déjà travaillé dans le fansub et les plus grands fans de cette activité à se réunir autours d'une table dans un restaurant japonais pour se rencontrer, échanger, discuter et s'amuser, sans aucune prise de tête.<br /><br />
L'évennement se déroule à Paris, et comme nous savons bien que tout le monde n'est pas apte à se déplacer librement sur Paris, nous avons décidé de le faire pendant les conventions parisiennes sur la jap'anime, puisque c'est à ce moment là que nos chers otaku ont tendance à se déplacer, se dégageant difficilement de leur chaise adorée bien calée devant leurs ordinateurs (je caricature, hein).<br /><br />
Nous comptons renouveler l'évenemment pour plusieurs occasions, ésperant ainsi rencontrer un maximum de personnes ! Ne soyez pas timides, rejoignez-nous, venez nombreux !<br /><br />
<b>Prochaine rencontre : Samedi 30 octobre à 20h, pendant la Chibi Japan Expo. Venez nombreux ! Plus d'informations sur notre site : <a href=\"http://konshinkai.c.la/\" targt=\"_blank\">Konshinkai Site Officiel</a></p></b><br /><br />
L'équipe Konshinkai fansub, réunions amicales entre fansubbeurs français.<br /><br />
P.S. : Nous vous serions très reconaissant de faire part de cette évenement autours de vous, aux membres de votre équipes, aux autres équipes, à vos amis fansubbeurs et pourquoi pas faire une news sur votre site officiel.");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Paris Manga");
			$news->setTimestamp(strtotime("01 September 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/parismanga.jpg\" /><br />
Paris Manga est une petite convention se déroulant à Paris (logique) le 12 et 13 septembre à l'espace Champerret. Zéro y sera ! Donc n'hésitez pas à venir nous voir, on est gentil et on mord pas ^^ Et comme d'habitude, je participe aux concours cosplay. Venez m'encourager samedi à partir de 14h sur scéne en cosplay individuel et dimanche à partir de 14h en cosplay groupe avec un costume spécial Zéro fansub !<br /><br />
L'équipe de fansub n'est actuellement pas en mesure de vous proposer des sorties d'animes : L'encodeur Lepims est en vacances et dieu (db0) déménage.");
			$news->setCommentId(119);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement traducteur Mermaid Melody");
			$news->setTimestamp(strtotime("10 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/mermaid.jpg\"><br />
Nous avons été très étonné du succés qu'a eu notre demande de recrutement pour l'anime Hitohira et nous avons aujourd'hui un nouveau traducteur pour cette série : whatake.<br />
Aurons-nous autant de succés pour ce deuxième appel...? Je l'espère ! Mais avant cela, je vous vous expliquer la situation. Nous avons commencé la série Mermaid Melody Pichi Pichi Pitch en Vistfr et MnF l'a fait en Vostfr. Nous avons décidé d'abbandonner la série en Vistfr et de la continuer en Vostfr. 13 épisodes de cette série sont sortis. Vous pouvez télécharger l'épisode 01 ici : <a href=\"http://www.megaupload.com/?d=ZZQNU3UZ\" target=\"_blank\">Episode 01</a><br />
Nous recherchons quelqu'un de motivé qui aime les animes magical girl pour continuer cette série avec nous ! N'hésitez pas à postuler ! Merci de votre aide.");
			$news->setCommentId(111);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Infos Téléchargements");
			$news->setTimestamp(strtotime("09 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Depuis un incident de surcharge de téléchargements ayant fait planter toute la db0 company (anime-ultime, Zéro et tout les autres), nous avons décidé de limiter les téléchargements. Nous avons annoncé ça clairement, et pourtant, nous continuons à recevoir dans le topics des liens morts qui ne le sont pas. Donc aujourd'hui, j'insiste : Si vous êtes déjà en train de télécharger un épisode sur notre site, vous ne pourrez en telecharger un autre qu'après le premier téléchargement terminé ! Si le message suivant arrive :<br /><br />
\"Service Temporarily Unavailable<br />
The server is temporarily unable to service your request due to maintenance downtime or capacity problems. Please try again later.\"<br /><br />
Ne vous affolez pas : Attendez la fin de votre premier téléchargement. Il peut arriver que ce message arrive alors que vous n'êtes pas en train de télécharger. Dans ce cas, attendez 30 secondes puis actualisez la page à nouveau, et ceci jusqu'à ce que votre téléchargement se lance. Merci à tous !");
			$news->setCommentId(110);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[IRL] Japan Expo 2009");
			$news->setTimestamp(strtotime("15 June 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/japan10.jpg\" style=\"float:right;\" border=\"0\">
Vous y allez ? Ça tombe bien, nous aussi !<br />
Pour s'y rencontrer, signalez-vous dans le topic dédié à cette convention sur le forum : <a href=\"http://forum.zerofansub.net/t196-japan-expo-2009.htm\" target=\"_blank\">http://forum.zerofansub.net/t196-japan-expo-2009.htm</a><br />
Il y aura comme toujours la petite bande de chez Kanaii en plus de celle de chez Zéro.<br />
J'ai prévu plusieurs concours cosplay :<br />
Cosplay Standart Jeudi 13h (Kodomo no Jikan)<br />
WCS Pré-selection Samedi 13h concours 15h (Surprise)<br />
Pen of Chaos Dimanche 13h (Dokuro-chan)<br />
Venez m'y voir ^^ Si vous voulez :)<br /><br />
Rappel : La team est toujours en pause jusqu'à Juillet !");
			$news->setCommentId(96);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[IRL] Epitanime 2009");
			$news->setTimestamp(strtotime("06 June 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("C'était du 29 au 31 mai, et c'était un très grand evenement. Bien malheureux sont ceux qui l'ont ratés ! Et qui, surtout, on raté db-chan ! Oui, il faut le dire, le plus important à Epitanime, c'était elle :P Il fallait être là, car j'avais prévu pour tout les membres de la team Zéro mais aussi toutes les personnes qui viennent régulierement chez Zéro une petite surprise.<br />
Ce week-end, j'ai donc croisé Sazaju (notre traducteur), Ryocu, Guguganmo et des tas de copains-cosplayeurs dont je ne vous citerait pas le nom puisque vous ne les connaîtrez sûrement pas.<br /><br />
J'ai participé au concours cosplay le samedi 30 mai à 12 heure. À vous de deviner quel personnage j'incarnait :<br />
<img src=\"images/news/cosplay01.jpg\" /><br />
Vous ne trouvez pas ? Oui, je sais, c'est très difficile. Pour voir qui c'était, lisez la suite.<br /><br />
<a href=\"index.php?page=dossier/epitanime2009\"><img src=\"images/interface/lirelasuite.png\" alt=\"[ Lire la suite . . . ]\" border=\"0\" /></a>");
			$news->setCommentId(79);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Epitanime 2009");
			$news->setTimestamp(strtotime("19 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"http://www.epita.fr/img/design/logos/epitanime-logo.jpg\" style=\"float:right;\" border=\"0\"><br />
Date à retenir : 29-30-31 mai 2009 ! Durant ses trois jours se dérouleront un évenement de taille : la 17éme édition de l'Epitanime ! Une des meilleures conventions et des plus vieilles. Plus pratique pour les parisiens puisqu'elle se déroule au Kremlin-Bicêtre (Porte d'Italie). Si vous avez la possibilité de vous y rendre, faites-le ! db-chan vous y attendra ^^");
			$news->setCommentId(525);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("forum.zerofansub.net");
			$news->setTimestamp(strtotime("18 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/favoris.png\" style=\"float:right;\" border=\"0\"><br />
Le forum change d'adresse : <br />
<a href=\"http://forum.zerofansub.net/\" target=\"_blank\"><span style=\"font-size: 22px;\">http://forum.zerofansub.net</span></a><br />
Faites comme Mario, mettez à jour vos favoris !");
			$news->setCommentId(588);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("The legend of Melba : Tonight Princess + Newsletter");
			$news->setTimestamp(strtotime("17 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<a href=\"http://melbaland.free.fr/\" target=\"_blank\"><img src=\"http://img8.imageshack.us/img8/6162/bannirepapyo.jpg\" border=\"0\"></a><br />
Papy Al, QC de la petite équipe, a sorti hier soir le premier épisode de sa saga mp3. <a href=\"http://melbaland.free.fr/\" target=\"_blank\">Pour l'écouter, c'est par ici !</a><br /><br />
Vous ne le savez peut-être pas, mais Zéro envoie à chaque news une newsletter ! Pour la recevoir, il suffit de s'inscrire sur le forum. Il n'est pas demandé de participer ni quoi que ce soit.");
			$news->setCommentId(73);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[Zero] Merci !");
			$news->setTimestamp(strtotime("11 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img src=\"images/news/merci.jpg\" border=\"0\"><br />Toute l'équipe Zéro fansub et toute la db0 company (Anime-Ultime, Stream-Anime, Zéro, Kojikan, ect) tient à remercier chalereusement les personnes suivantes pour leurs réponses à notre appel à l'aide :<br />
Hervé (14€)<br />
Nicolas (10€)<br />
Guillaume (5€)<br />
Fabrice (20€)<br />
Luc (10€)<br />
Julien (40€)<br />
Bkdenice (15€)<br />
Pascal (10€)<br />
Mathieu (25€)<br />
Ces sommes ne nous permettent certes pas de nous sortir de nos problèmes d'argent actuels, mais nous aident énormément à remonter peu à peu la pente ! Nous reprenons du courage et la force de continuer à tenir en forme les sites de la db0 company. Encore une fois, merci.<br />
//Ryocu et db0");
			$news->setCommentId(71);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("C'est la crise !");
			$news->setTimestamp(strtotime("01 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("C'est la crise pour tout le monde, et même pour nous. Nous n'arrivons plus à payer nos serveurs... On ajoute des publicités et on vous sollicite pour des dons, mais rien ne s'améliore. Depuis le début de Zéro, et sur tout les sites de la db0 company, nous n'avons reçu que 14 € de dons et 75 € de publicités. Sachant qu'il nous a fallut environ 80 € (en tout depuis que Zéro existe) pour l'association humanitaire que Zéro soutient et que nos serveurs de la db0 company coûte environ 250 € /mois, le calcul n'est pas long, nous sommes dans le négatif. Et pauvres petits étudiants que nous sommes, à découvert tout les mois... C'est un appel à l'aide que je lance aujourd'hui, à ceux de Zéro, de la db0 company, à ceux qui aiment les animes que nous sous-titrons et qui respectent notre travail. Par avance, merci.");
			$news->setCommentId(66);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[Zero]");
			$news->setTimestamp(strtotime("10 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/3.1.png\" border=\"0\">
Du changement sur le site ?<br /><br />
Je ne vois vraiment pas de quoi vous parlez !");
			$news->setCommentId(57);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! Licencié");
			$news->setTimestamp(strtotime("01 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/licence.jpg\" border=\"0\">
Triste nouvelle que je vous apporte aujourd'hui ! La première licence d'une de nos série. Avec beaucoup de regrets, nous retirons donc tout les liens de téléchargement de la série Toradora!...");
			$news->setCommentId(54);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! Fin - L'impact !");
			$news->setTimestamp(strtotime("30 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/ryoc.jpg\" border=\"0\">
Bonjour.<br />
Je suis l'administrateur du site <a href=\"http://www.anime-ultime.net/part/Site-93\" target=\"_blank\">Anime-ultime</a>, et l'admin sys de Zéro fansub ainsi que toute la <a href=\"http://db0.fr\" target=\"_blank\">db0 company</a>. Je tiens à remercier les personnes qui se sont crues malignes en employant des accélérateurs de téléchargement. Grâce à ces personnes, plusieurs sites ont été inaccessibles. En utilisant ce genre de logiciel, vous bloquez les accès aux visiteurs des sites web et vous entraînez un ralentissement général des téléchargements (au lieu des les accélerer, vous faites en sorte que les disques durs ne puissent plus tenir la cadence et font ralentir tout le monde). Par conséquent, vous ne pouvez désormais plus télécharger qu'un seul et unique fichier à la fois sur Zerofansub.net et je demande à toutes les personnes qui utilisent des accélerateurs de téléchargement d'arrêter de vous servir de ce genre de logiciel qui plombent les serveurs inutilement en plus d'avoir l'effet contraire à celui désiré.<br />
Cette limite n'est pas très sévère, soyez compréhensifs. Profitez bien de la fin de Toradora!, même si pour cela, vous devez attendre un peu. Nos releases sont aussi disponibles en torrent.");
			$news->setCommentId(54);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement Karamaker et Gestion tracker BT");
			$news->setTimestamp(strtotime("24 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("<img style=\"float : right; display:block; margin-right: 20px;\" src=\"images/news/guilde.jpg\" border=\"0\">
<p>
Zéro recrute !<br /><br />
<b>Gestion tracker BT</b><br />
Ma connexion actuelle ne me permet pas de télécharger, seeder, gérer notre tracker BT. Nous sommes donc à la recherche de quelqu'un de motivé et disponible ayant une bonne connexion. Son rôle : Télécharger nos épisodes dès leurs sorties, créer le fichier .torrent, se mettre en seed dessus, l'uploader sur le tracker, surveiller les sans source. Nous avons aussi à notre disposition un TorrentFlux en cas de besoin.<br />
Interessé ? Venez vous proposer sur le forum partie Recrutement avec un screen de votre programme de torrent.
<br /><br />
<b>Karamaker</b><br />
Nous recherchons un karamaker uniquement pour les effets (je m'occupe du kara-time) qui est de l'éxpérience et des idées (à bannir les karaokés par défaut.)<br />
Interessé ? Venez vous proposer sur le forum partie Recrutement avec votre meilleur karaoké.
<br /><br />
Venez nombreux ! Nous avons besoin de vous !
<br /><br />
</p>");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			News::$allNews[] = $news;
		}
		
		foreach(News::$allNews as $news) {
			if ($news->isPartnerNews() === null) {
				throw new Exception($news->getCommentId());
			}
		}
		
		return News::$allNews;
	}
	
	public static function timestampSorter(News $a, News $b) {
		$ta = $a->getTimestamp();
		$tb = $b->getTimestamp();
		return $ta === $tb ? 0 : ($ta === null ? -1 : ($tb === null ? 1 : ($ta < $tb ? 1 : ($ta > $tb ? -1 : 0))));
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
	
	public static function getAllTeamNews() {
		$array = array();
		foreach(News::getAllNews() as $news) {
			if ($news->isTeamNews()) {
				$array[] = $news;
			}
		}
		return $array;
	}
	
	public static function getAllPartnerNews() {
		$array = array();
		foreach(News::getAllNews() as $news) {
			if ($news->isPartnerNews()) {
				$array[] = $news;
			}
		}
		return $array;
	}
}
?>
