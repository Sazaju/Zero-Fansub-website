<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/
class News {
	private $id = null;
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
	private $isDb0CompanyNews = null;
	
	private static function generateId() {
		// /!\ This works only if the news are added always in the same order !
		// The new ones must be placed at the end !
		static $lastId = 0;
		$lastId++;
		return $lastId;
	}
	
	public function __construct($title = null, $message = null) {
		$this->id = News::generateId();
		$this->setTitle($title);
		$this->setMessage($message);
	}
	
	public function getUrl() {
		$url = Url::getCurrentDirUrl();
		$url->setQueryVar('page', 'news2');
		$url->setQueryVar('id', $this->getId());
		return $url;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setDb0CompanyNews($boolean) {
		$this->isDb0CompanyNews = $boolean;
	}
	
	public function isDb0CompanyNews() {
		return $this->isDb0CompanyNews;
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
	public static function getAllNews(NewsSelector $selector = null) {
		if (News::$allNews === null) {
			$news = new News();
			$news->setTitle("Mayoi Neko Spéciaux");
			$news->setTimestamp(strtotime("26 January 2012 16:18"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setMessage("Histoire de décrisper ceux qui se disent qu'on meurt à petit feu (faut dire que la dernière sortie date de mi-novembre), voilà un petit truc à vous mettre sous la dent {^_^}. C'est tout chaud et c'est du produit bien de chez Zéro ! Les anémiques, prévoyez les poches de sang, on sait jamais.

[release=mayoisp|*][img=images/news/mayoisp.png]MNO Spéciaux[/img][/release]

Profitez bien des bonus, bande de cochons {^_°}.");
			$news->addReleasing(Project::getProject('mayoisp'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setCommentId(286);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
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
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("MegaUpload hors service");
			$news->setTimestamp(strtotime("23 January 2012 13:29"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(284);
			$news->setTeamNews(true);
			$news->setMessage("Pour ceux qui utilisent nos liens MegaUpload, ces derniers jours vous avez sûrement dû avoir du mal, voire vous êtes tombés sur une image comme celle-ci :

[img=images/news/fbi.jpg]Avertissement FBI[/img]

En effet MegaUpload est sous le joug d'une enquête gouvernementale (en Amérique), du coup la majorité de leurs liens (si ce n'est tous) sont hors service, et cela pour une durée indeterminée.

Pour télécharger nos épisodes il vous faudra donc vous retrancher sur le DDL, les torrents et autres solutions disponibles.");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("V3.3 du site !");
			$news->setTimestamp(strtotime("23 January 2012 01:48"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(283);
			$news->setTeamNews(true);
			$news->setMessage("Ces derniers jours, le raffinage du site a pas mal avancé, et on en est désormais à la version 3.3+ du site. '+' parce que la version 3.3 s'est faite Samedi et que depuis j'ai encore raffiné une quantité assez phénoménale de données (j'y ai passé tout mon weekend). Du coup la version 3.4 ne devrait pas trop tarder à voir le jour (mais je ne donne pas de date, vu que de toute façon je n'ai aucune raison de la respecter {^.^}~). En bref, le raffinage est quasiment terminé.

\\{^o^}/ Banzai !

Néanmoins vous me direz peut-être [i]elle est où la différence ?[/i]. Si vous vous posez la question, tant mieux pour moi, ça veut dire que j'ai bien fait mon boulot {^_^}. Le but du raffinage est en effet de réécrire le code, la mise en page du site n'est donc pas sensée changer de manière notable.

J'en profite tout de même pour vous faire un petit topo sur ce qu'il en est :

* [b]Toutes les pages projets[/b], incluant toutes les releases, ont été refaites. Autrement dit plusieurs centaines de fichiers on été factorisés (c'est ce dont je me réjouis le plus, parce que contenant des tonnes de données et hyper répétitifs, donc le plus chiant à faire). La version 3.2 (que peu ont dû voir passer {^_^}) sonnait le glas du raffinage des releases. Cette nouvelle version sonne celui du raffinage des projets.

* [b]Presque toutes les news[/b] ont été raffinées. Sur les 6 vues disponibles, il me reste les 3 dernières, en sachant que ce sont de très loin les plus petites et qu'il y a quelques doublons avec les précédentes.

* La plupart des autres pages du site ont été refaites. En mettant de côté les pages gérées à part, il reste les [b]dossiers et galleries d'images[/b] à faire.

* Le site profite désormais d'un peu plus [b]d'affichage dynamique[/b] (contenu changé à la volée). Certaines fonctionnalités peuvent donc être implémentées pour rendre le site un peu plus intelligent, mais encore rien d'extraordinaire vu que les données sont toujours écrites en dur (et non en base de données). En gros, on n'a pas encore de dynamisme sur les données (on ne peut pas modifier un titre par exemple), mais on en a sur leur présentation (afficher/cacher, changer les couleurs/dimensions, ...) avec possibilité de mémorisation (grâce aux sessions et cookies, bien que ces derniers ne soient pas encore utilisés). Le point suivant montre un exemple d'application.

* La section H se retrouve désormais [b]fusionnée[/b] à la section tout public, donc il n'y a plus de différence entre les deux. Le passage entre section H et tout public se fait un peu différemment par rapport à avant : désormais vous êtes soit en mode [i]tout public[/i], soit en mode [i]hentai[/i], [b]quelque soit la page[/b] (et non certaines pages tout public et d'autres hentai, comme ça se faisait avant). Cela permet une gestion bien plus souple et précise de l'accès aux contenus adultes. Le passage de l'un à l'autre se fait en premier lieu via le menu de gauche, avec le [b]lien [i]Hentai[/i][/b] pour passer en mode hentai, qui se retrouve remplacé par un [b]lien [i]Tout public[/i][/b] qui refait passer en mode tout public. Le passage se fait aussi lorsque c'est nécessaire (accès à un projet hentai sans être en mode hentai). Selon le mode, les projets affichés sont les projets correspondants (la liste habituelle ou les projets H). Il en est de même pour les news (pour celles déjà raffinées). Le passage 
au mode hentai se fait toujours via un avertissement, l'inverse en revanche est direct. Quand vous refusez de passer en mode hentai, vous retournez à la page précédente (à l'index pour les accès directs).

Il me semble que c'est à peu près tout... Ah oui, si vous avez des soucis sur certaines pages du site, c'est toujours moi qu'il faut venir engueuler {^_^}. Regardez du côté du lien [i]Signaler un bug[/i] dans le menu de gauche. Sur ce, bon leech.");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Un peu de repos");
			$news->setTimestamp(strtotime("18 January 2012 14:26"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(282);
			$news->setTeamNews(true);
			$news->setMessage("Une petite news pour les autres équipes de fansub et pour nos habitués : étant donné le nombre d'animes licenciés et le nombre d'animes restant non fansubbés, Zéro Fansub ne prévoit pas d'ajouter de nouveaux projets à sa liste pour cette saison.

On en profitera pour avancer correctement nos séries déjà en cours, dont certaines sont sur le feu depuis un moment déjà {'^_^}.");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Encore des bugs ?");
			$news->setTimestamp(strtotime("4 January 2012"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(281);
			$news->setTeamNews(true);
			$news->setMessage("Juste une petite news informative. Beaucoup savent déjà que s'il y a un bug, c'est de ma faute. Cela dit, mon mail il faut le trouver (et oui c'est dur d'aller voir dans la page équipe, c'est qu'il faut réfléchir et les leecheurs aiment pas ça). Pour vous simplifier la vie, si vous avez le moindre problème, un lien [i]Signaler un bug[/i] est désormais disponible dans le menu de gauche.

Non seulement je vous demande de me jeter des cailloux, mais en plus je vous dit où viser pour faire mal. C'est pas beau ça ? {^_^}
[img=images/news/working_punch.jpg]Frappez-moi ![/img]");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Bonne année !");
			$news->setTeamNews(false);
			$news->setTimestamp(strtotime("1 January 2012"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(280);
			$news->setMessage("Bonne année à tous ! En espérant que le raffinage du site avance vite pour enfin vous (et nous) fournir un site plus pratique {^_^}°.

[img=images/news/newYear2012.jpg]Bonne année 2012 ![/img]");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("ATTENTION : Raffinage massif !");
			$news->setTeamNews(true);
			$news->setTimestamp(strtotime("31 December 2011 02:44"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(279);
			$news->setMessage("Note importante : beaucoup de raffinage a été fait dernièrement. En particulier la structure des fichiers a été retouché, certains fichiers ont même été remplacés (probablement à cause de quelques problèmes CRC). Quelques-uns ont été vérifié, mais pas tous. Aussi, si vous téléchargez des fichiers qui semblent corrompus, faites-le-moi savoir au plus vite. C'est probablement de ma faute.

Vous pouvez laisser des commentaires, sinon je redonne mon mail : [mail]sazaju@gmail.com[/mail]");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img-auto=images/news/hshiyo6.png]J'ado~re les concombres ![/img-auto]
Et voilà un nouvel opus (ou deux nouveaux obus, au choix) de notre H favori. Enfin je dis favori mais comme c'est moi qui fais la news, je vais avant tout donner mon avis {^_^}.

Vous avez aimé le 4 (pas le précédent, celui d'avant, que j'avais détruit dans ma news) ? Si oui alors réjouissez-vous, celui-ci est du même acabit. Ceux qui sont du même avis que moi, en revanche, passez votre chemin. Pour faire court : on se fait une vache à lait à la campagne. Les grosses mamelles sont de la partie, même si ce ne sont pas elles qui donneront le 'lait' de l'épisode.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement pour le site");
			$news->setTimestamp(strtotime("24 December 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(276);
			$news->setTeamNews(true);
			$news->setMessage("Salut tout le monde ! {^_^}

Voilà un gros mois sans news, vous devez donc vous dire [i]enfin une sortie ![/i] pas vrai ? Ben désolé de casser l'ambiance, mais non pas pour tout de suite {'^_^}.

[img=images/news/angry.jpg]Quoi ?[/img]
[size=0.8]Non pas taper ! {'>_<}[/size]

Comme certains d'entre vous le savent, je suis en train de raffiner le site, et cela prends du temps. Si pas mal de choses ont été développées pour l'instant, encore reste-t-il à les appliquer au site, et c'est ça qui est long. C'est donc pour ça que je viens à vous {^_^}.

Je cherche quelqu'un qui s'y connaît un minimum en HTML/CSS/PHP. Inutile d'être un expert, je demande juste d'avoir déjà utilisé un peu ces langages, dire qu'on se comprenne si je parles de style, de balise et de parcourir des tableaux. Si vous avez déjà programmé en objet (PHP, Java, C++ ou autre) c'est un plus. Notez qu'il faut aussi savoir [i]retoucher[/i] des images. Ce que j'entends par là est simplement savoir redimensionner, couper, coller, rassembler des images en une seule, ... le b.a.-ba donc. Si des compétences plus avancées sont nécessaires, je peux vous les apprendre avec Gimp. De même si vous avez des questions sur le code, c'est tout à votre honneur {^_^}.

Je tiens quand même à poser une contrainte : je cherche quelqu'un de motivé, qui aime coder. Je ne veux pas dire par là que c'est difficile, mais je veux quelqu'un sur qui je puisse compter sur la longueur. Il ne faut pas être disponible tout le temps, mais je ne veux pas voir quelqu'un qui après une semaine me dise [i]j'ai plus le temps[/i]. Ce sont toutes des petites tâches qui peuvent se faire un peu n'importe quand, donc c'est très flexible, mais il faut les faire.

Si vous êtes intéressés, passez dans la section recrutement (lien dans le menu de gauche).

NB : vous voyez, j'ai même pas le temps de vous faire une news décente en cette veille de Noël, pour vous dire comme j'ai besoin de quelqu'un {;_;}.");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("Ah, j'ai des nouvelles pour vous. Vous allez rire {^_^}. Il se trouve que ça fait un moment qu'on a fini les Mitsudomoe 7 & 8... et j'ai oublié de les sortir ! C'est marrant, hein ? {^o^}

Non ? Vous trouvez pas ? {°.°}?

[img=images/news/aMort.png]À mort ![/img]

OK, OK, j'arrête {\">_<}. S'il vous reste des cailloux de la dernière fois, vous pouvez me les jeter. Allez, pour me faire pardonner je vous file un accès rapide : [release=mitsudomoe|ep7,ep8]Mitsudomoe 7 & 8[/release]

J'en profite pour vous rappeler que le site est en cours de raffinage, et comme j'en ai fait beaucoup dernièrement (le lien rapide en est un ajout) il est possible que certains bogues me soient passés sous le nez. Aussi n'hésitez pas à me crier dessus si vous en trouvez {'^_^}.

Et si vous voulez nous aider (ou vous essayer au fansub), on cherche des traducteurs Anglais-Francais (ou Japonais pour ceux qui savent {^_^}) !

Sur ceux, bon visionnage {^_^}.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Besoin de timeurs !");
			$news->setTimestamp(strtotime("11 October 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(273);
			$news->setTeamNews(true);
			$news->setMessage("Allez on enchaîne les news, la motivation est là... Mais elle va peut-être pas durer...

[color=red][size=2]On a besoin de votre aide ![/size][/color]

[img=images/news/urgent.gif]Au secours ![/img]

On embauche des timeurs ! On n'en a pas assez et du coup chacun essaye de faire pour avoir un time à peu près correcte... Mais ce n'est pas la même chose quand quelqu'un s'y met à plein temps. C'est quelque chose qui nous ralentis beaucoup car, même si ce n'est pas difficile, ça demande du temps pour faire quelque chose de bien (en tout cas pour suivre notre charte qualité {^_^}). On a les outils, les connaissances, il ne manque plus que les personnes motivées !

Si vous êtes interessés, les candidatures sont ouvertes (cliquez sur [b]Recrutement[/b] dans le menu à gauche) ! Si vous êtes soucieux du détail au point d'en faire chier vos amis, c'est un plus ! Oui on est des vrai SM à la Zéro {>.<}.");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan - Du neuf et du moins neuf");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("10 October 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("praia"));
			$news->setCommentId(272);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomooav', 'oav'));
			$news->addReleasing(Release::getRelease('kodomofilm', 'film'));
			$news->setMessage("[img=images/news/pedobear.jpg]Pedobear[/img]

Sortie de la v3 de Kodomo no Jikan OAD.

Et le film Kodomo no Jikan, qu'on n'a pas abandonné, non, non... Même si l'envie était là.
[size=0.8]Sazaju: Hein ? Quoi !? {'O_O}[/size]

Bon matage et à bientôt pour la suite de Mitsudomoe.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Nouvelles sorties, nouveaux projets, nouveaux bugs...");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("26 September 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(271);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep4'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep5'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep6'));
			$news->setMessage("Bon... par où commencer... Dur dur, surtout que le moins réjouissant c'est pour ma pomme {'^_^}. En plus j'ai pas d'image pour vous, vous allez morfler. Alors allons-y gaiement !

Tout d'abord, sachez que le site est actuellement en cours de raffinage. Autrement dit, une révision complète du code est en cours. Par conséquent, si vous voyez des petites modifications par rapport à avant, c'est normal, mais dans l'ensemble il ne devrait pas y avoir de changement notable sur le site. Quel intérêt que j'en parle vous me direz... Tout simplement parce qu'il est possible que certaines pages boguent (ou bug, comme vous voulez), et si jamais vous en trouvez une, le mieux c'est de me le faire savoir directement par mail : [mail]sazaju@gmail.com[/mail]. Le raffinage étant en cours, il est possible que des pages qui fonctionnent maintenant ne fonctionnent pas plus tard, aussi ne soyez pas surpris. Je fais mon possible pour que ça n'arrive pas, mais si j'en loupe merci de m'aider à les repérer {^_^}.

Voilà, les mauvaises nouvelles c'est fini ! Passons aux réjoussances : 3 nouveaux épisodes de Mitsudomoe sont terminés (4 à 6). Si vous ne les voyez pas sur la page de la série... c'est encore de ma faute (lapidez-moi si vous voulez {;_;}). Si au contraire vous les voyez, alors profitez-en, ruez-vous dessus, parce que depuis le temps qu'on n'a pas fait de news vous devez avoir faim, non ? {^_°}

Allez, mangez doucement, ça se déguste les animes (purée j'ai la dalle maintenant {'>.<}). Cela dit, si vous en voulez encore, on a un bon dessert tout droit sorti du restau : Working!! fait désormais partie de nos futurs projets ! Certains doivent se dire qu'il y ont déjà goûté ailleurs... Mais non ! Parce que vous aurez droit aux deux saisons {^o^}v. Tout le monde le sait (surtout dans le Sud de la France), quand on a bien mangé, une sieste s'impose. Vous pourrez donc rejoindre la fille aux ondes dans son futon : Denpa Onna to Seishun Otoko vient aussi allonger la liste de nos projets ! On dit même qu'un projet mystère se faufile entre les membres de l'équipe...

Pour terminer, un petit mot sur notre charte qualité. Nous avons décidé de ne plus sortir de releases issues d'une version TV, mais de ne faire que des Blu-Ray. Bien entendu, on fera toujours attention aux petites connexions : nos encodeurs travaillent d'arrache pied pour vous fournir la meilleure vidéo dans le plus petit fichier. J'espère donc que vous apprécierez la qualité de nos futurs épisodes {^_^} (et que vous n'aurez pas trop de pages boguées {'-.-}).");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Hitohira - Série complète");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("14 August 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(270);
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('hitohira'));
			$news->setMessage("[img=images/news/hito1.jpg]Hitohira[/img]

Sortie de Hitohira, la série complète, 12 épisodes d'un coup !

[img=images/news/hito2.jpg]Hitohira[/img]");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Mitsudomoe 03");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("05 August 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(269);
			$news->setTwitterTitle("Sortie de Mitsudomoe 03 chez Z%C3%A9ro fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep3'));
			$news->setMessage("[img=images/episodes/mitsudomoe3.jpg]Mitsudomoe[/img]

Sortie de l'épisode 03 de Mitsudomoe.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Toradora! SOS - Série complète 4 OAV");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("26 July 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("praia"));
			$news->setCommentId(268);
			$news->setTwitterTitle("Sortie de Toradora! SOS chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('toradorasos'));
			$news->setMessage("[img=images/series/toradorasos.jpg]Toradora SOS[/img]

4 mini OAV délirants sur la bouffe, avec les personnages en taille réduite.
C'est de la superproduction ^_^");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Recrutement traducteur");
			$news->setTimestamp(strtotime("04 July 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("praia"));
			$news->setCommentId(266);
			$news->setTeamNews(true);
			$news->setTwitterTitle("Zero recherche un traducteur");
			$news->setMessage("[img=images/news/m1.jpg]Mitsudomoe[/img]

Nous avons urgemment besoin d'un trad pour Mitsudomoe !!
S'il vous plaît, pitié xD
Notre edit s'impatiente et ne peux continuer la série, alors aidez-nous ^_^
C'est pas souvent qu'on demande du renfort, mais là, c'est devenu indispensable...
Nous avons perdu un trad récemment, il ne nous en reste plus qu'un... et comble de malheur,  il n'a pas accroché à la série, mais je le remercie pour avoir quand même traduit deux épisodes pour nous dépanner.
Des petits cours sont dispos ici : [ext=http://forum.zerofansub.net/f221-Cours-br.htm]Lien[/ext].

Pour postuler, faites une candidatures à l'école : [ext=http://ecole.zerofansub.net/?page=postuler]Lien[/ext].

[img=images/news/m2.jpg]Mitsudomoe[/img]");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Kannagi - Série complète");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("19 June 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(264);
			$news->setTwitterTitle("Sortie de Kannagi serie complete chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('kannagi'));
			$news->setMessage("[ext=http://zerofansub.net/galerie/gal/Zero_fansub/Images/Kannagi/%5BZero%5DKannagi_Image63.jpg][img=images/news/kannagi.jpg]Kannagi[/img][/ext]

Bonjour les amis !
La série Kannagi est terminée !
J'éspère qu'elle vous plaira.
N'hésitez pas à nous dire ce que vous en pensez dans les commentaires. C'est en apprenant de ses erreurs qu'on avance, après tout ;)

P.S.: Les karaokés sont nuls. Désolée !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Mitsudomoe 01 + 02");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("27 May 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(263);
			$news->setTwitterTitle("Sortie de Mitsudomoe 01 + 02 chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep1'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep2'));
			$news->setMessage("[img=images/news/mitsu0102.jpg]Mitsudomoe[/img]

Bonjour les amis !
Après des mois d'attente, les premiers épisodes de Mitsudomoe sont enfin disponibles !
Quelques petits changements dans notre façon de faire habituelle, on attend vos retours avec impatience ;)");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Tayutama ~ Kiss on my Deity ~ Pure my Heart ~ - Série complète 6 OAV");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("15 May 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(262);
			$news->setTwitterTitle("Sortie de Tayutama Kiss on my Deity Pure my Heart serie complete chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('tayutamapure'));
			$news->setMessage("[img=images/news/tayutamapure.jpg]Tayutama ~ Kiss on my Deity ~ Pure my Heart ~[/img]

On continue dans les séries complètes avec cette fois-ci la petite série de 6 OAV qui fait suite à la série Tayutama ~ Kiss on my Deity : les 'Pure my Heart'. Ils sont assez courts mais plutôt drôle alors amusez-vous bien !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Potemayo OAV - Série complète");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("11 May 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(261);
			$news->setTwitterTitle("Sortie de Potemayo serie complete chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('potemayooav'));
			$news->setMessage("[img=images/series/potemayooav.jpg]Potemayo[/img]

Petit bonjour !
Dans la suite de la série Potemayo, voici la petite série d'OAV. Au nombre de 6, ils sont disponibles en versions basses qialité uniquement puisqu'ils ne sont pas sortis dans un autre format. Désolée !
Amusez-vous bien !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;

			$news = new News();
			$news->setTitle("Potemayo - Série complète entiérement refaite");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("08 May 2011"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(261);
			$news->setTwitterTitle("Sortie de Potemayo serie complete chez Zero fansub !");
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('potemayo'));
			$news->setMessage("[img=images/series/potemayo.jpg]Potemayo[/img]

Bonjour le monde !

Tout comme pour Kujibiki Unbalance 2, nous avons entièrement refait la série Potemayo. Pour ceux qui suivaient la série, seule les versions avi en petit format étaient disponible puisque c'etait le format qu'utilisait Kirei no Tsubasa, l'équipe qui nous a légué le projet.

Du coup, la série complète a été réencodée et on en a profité pour ajouter quelques améliorations.

Rendez-vous page 'Projet' sur le site pour télécharger les 12 épisodes !

Et n'oubliez pas : si vous avez une remarque, une question ou quoi que ce soit à nous dire, utilisez le système de commentaires ! Nous vous répondrons avec plaisir.

Bons épisodes, à très bientôt pour les 6 OAV supplémentaires Potemayo... et un petit bonjour à toi aussi !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img-auto=images/news/kujiend.jpg]Kujibiki Unbalance 2[/img-auto]
La série Kujibiki Unbalance 2 a entiérement été refaite !
Les polices illisibles ont été changées, les panneaux stylisés ont été refait, la traduction a été revue, bref, une jolie série complète vous attend !

Pour télécharger les épisodes, c'est comme d'habitude :
- Page projet, liens DDL,
- Sur notre tracker Torrent (restez en seed !)
- Sur le XDCC de notre chan irc (profitez-en pour nous dire bonjour :D)

Petite info importante :
Cette série est compétement indépendante, n'a rien a voir avec la premiére saison de Kujibiki Unbalance ni avec la série Genshiken et il n'est pas nécessaire d'avoir vu celles-ci pour apprécier cette petite série.

Si vous avez aimé la série, si vous avez des remarques à nous faire ou autre, n'hésitez pas à nous en faire part ! (Commentaires, Forum, Mail, IRC, ...)

à trés bientôt pour Potemayo !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img=images/news/kodomonatsu1.jpg]Kodomo no Natsu Jikan[/img]
Rin, Kuro et Mimi sont de retour dans un OAV Spécial de Kodomo no Jikan : Kodomo no Natsu Jikan ! Elles sont toutes les trois absulument adorables dans leurs maillots de bains d'été, en vacances avec Aoki et Houin.

[img=images/news/kodomonatsu2.jpg]Kodomo no Natsu Jikan[/img]
[img=images/news/kodomonatsu3.jpg]Kodomo no Natsu Jikan[/img]
[img=images/news/kodomonatsu4.jpg]Kodomo no Natsu Jikan[/img]
[img=images/news/kodomonatsu5.jpg]Kodomo no Natsu Jikan[/img]");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img-auto=images/news/issho5.jpg]Issho ni H Shiyo 5[/img-auto]

Dans la suite de notre reprise tant attendue, on ne relâche pas le rythme ! Après la sortie d'un genre classique chez Zéro, on poursuit avec l'une de nos spécialités : [i]Faisons l'amour ensemble[/i] revient en force avec un nouvel épisode (de quoi combler les déçus du 4e opus) et un épisode bonus !

Tout d'abord, ce 5e épisode nous sort le grand jeu : la petite sur est dans la place ! Après plusieurs années sans nouvelles de son grand frère, voilà qu'elle a bien grandi et décide donc de taper l'incruste. Voilà une bonne occasion de faire le ménage (les filles sont douées pour ça {^.^}~). À la suite de quoi une bonne douche s'impose... Et si on la prenait ensemble comme au bon vieux temps, [i]oniichan[/i] ?

Pour ceux qui auraient encore des réserves (faut dire qu'on vous a donné le temps pour {^_^}), un épisode bonus aux sources chaudes vous attend ! Akina, cette jeune demoiselle du premier épisode, revient nous saluer avec son charme généreux et son côté ivre toujours aussi mignon. Vous en dégusterez bien un morceau après le bain, non ?

[img=images/series/akinahshiyo.jpg]Akina To Onsen De H Shiyo[/img]

db0 dit : Et pour finir, une nouvelle assez inattendue : La licence de L'entraînement avec Hinako chez Kaze. On vous tiendra au courant quand le DVD sortira.

[img=images/news/training.gif]Isshoni Training[/img]

En parlant de Kaze, j'ai reçu hier par la poste le Blu-ray de Canaan chez Kaze. Vous avez aimé la série ? Faites comme moi, achetez-le !

[img=images/news/canaanli.jpg]DVD canaan buy kaze[/img]");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img-auto=images/news/hshiyonew.png]Issho ni H Shiyo oav  4 fin de la serie interdit aux moins de 18 ans.[/img-auto]

Déception intense ! Après de jolis épisodes, c'est avec regret que je vous annonce la sortie de ce quatrième et dernier opus, qui retombe dans de banals stéréotypes H sans une once d'originalité ni de qualité graphique : gros seins surréalistes, personnages prévisibles à souhaits, et comble du comble un final à la \"je jouis mais faisons pour que ça n'en ait pas l'air\" ! Alors que les épisodes précédents nous offraient de somptueux ralentis et des mouvements de corps langoureux pour un plaisir savouré jusqu'à la dernière goutte, ce dernier épisode nous marquera (hélas) par sa simplicité grotesque et son manque de plaisir évident.

Mais réjouissez-vous ! La série étant finie, nous n'aurons plus l'occasion d'assister à une autre erreur mettant en doute la qualité de cette dernière : les plus pointilleux pourront sauvagement se dessécher sur les précédents épisodes sans jamais voir le dernier, alors que ceux qui auront pitié de notre travail pourront gaspiller leur bande passante à télécharger le torchon qui sert de final à cette série qui ne le mérite pourtant pas.

Merci à tous de nous avoir suivi sur cette série, et je vous souhaite tout le plaisir du monde à sauvegarder votre temps en revisionnant un des épisodes précédents plutôt que celui-ci {^_^}.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img=images/news/kissxsis3news.jpg]KissXsis kiss x sis DVD Blu-Ray Jaquette[/img]
On peut dire qu'il s'est fait attendre cet épisode...
Mais le voilà enfin, et c'est tout ce qui compte.
Vous devez vous demander ce qu'il advient de notre annonce de sortie une semaine/un épisode pour kissxsis.
Vous avez remarqué que c'est un echec. Pourquoi ? Les épisodes s'avèrent bien plus longs à réaliser que prévu si on souhaite continuer à vous fournir la meilleure qualité possible. De plus, j'étais dans ma période de fin d'année scolaire et j'ai dû mettre de côté nos chères soeurs jumelles pour être sûre de passer en année supérieure...!

Une nouvelle qui ne vous fera peut-être pas plaisir, mais qui j'éspère ne vous découragera pas de mater les soeurettes un peu plus tard : Nous avons l'intention d'attendre la sortie des Blu-Ray des autres épisodes avant de continuer KissXsis. La qualité des vidéos sera meilleure, il y aura moins de censure, plus de détails, bref, plus de plaisir !
Le premier Blu-Ray contenant les 3 premiers épisodes vient tout juste de sortir et nous sortirons bientôt des nouvelles versions de ces trois premiers. Croyez-moi, ça en vaut la peine. Vous ne me croyiez pas ? [url=http://www.sankakucomplex.com/2010/06/24/kissxsis-erotic-climax-dvd-ero-upgrades-highly-salacious/]Petit lien[/url].

Et pour ne pas parler que de KissXsis, sachez qu'une petite surprise que je vous ai personnellement concocté devrait bientôt sortir...
En ce qui concerne les autres projets, nous devrions nous concentrer sur Kujian en attendant les Blu-Ray de KissXsis et boucler certains vieux projets comme Sketchbook, Kodomo no Jikan (le film) ou Tayutama.

En ce qui concerne l'école du fansub, elle va très bien et le nombre d'élève augmente chaque jour, les exercices et les cours aussi ! Si vous êtes intéréssés, vous savez où nous trouver : sur le forum Zéro fansub.

Bonne chance à ceux qui sont en examens, et que ceux qui sont en vacances en profite bien. Moi, je suis en vacances :p");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[video=width:550|height:309]http://vimeo.com/moogaloop.swf?clip_id=12592506&server=vimeo.com&show_title=0&show_byline=0&show_portrait=0&color=ffffff&fullscreen=1[/video]");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/kissxsis2.jpg[/img]
Ako et Riko ne laisseront pas Keita rater ses examens ! Ako décident donc de donner des cours particulier à Keita.
Ils y resteront très sages et se contenteront d'apprendre sagement l'anglais, l'histoire et les maths. C'est tout.
Vous vous attendiez à autre chose, peut-être ?");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/newskissxsis1.jpg[/img]
Yo !
Ako et Riko sont ENFIN de retour, cette fois-ci dans une série complète.
Il y aura donc plus de scénario, mais toujours autant de ecchi.
C'est bien une suite des OAV, mais il n'est pas nécéssaire des les avoir vus pour suivre la série.
J'ai essayé de faire des jolis karaokés, alors chantez !! (Et envoyez les vidéos)
À très vite pour l'épisode 2.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img-auto]images/news/pcover1.gif[/img-auto]
			Salut toi, c'est Hinako !
			Tu m'as tellement manquer depuis notre entraînement, tout les deux...
			Tu te souviens ? Flexions, extensions ! Une, deux, une deux !
			Grâce à toi, j'ai perdu du poids, et toi aussi, non ?
			Tu sais, cette nuit, je dors toute seule, chez moi, et ça me rend triste...
			Quoi ? C'est vrai ? Tu veux bien dormir avec moi !?
			Oh merci ! Je savais que je pouvais compter sur toi.
			Alors, à tout à l'heure, quand tu auras télécharger l'épisode ;)");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/kiss2.png[/img]
Ah, elles nous font bien attendre, les deux jolies jumelles... Des mois pour sortir les OAV ! Mais au final, ça en vaut la peine, donc on ne peut pas leur en vouloir. C'est bientôt Noël, donc pour l'occasion, elles ont sortis des cosplays très mignons des \"soeurs de Noël\". Elles sont de plus en plus ecchi avec leur frère. Finira-t-il par craquer !? La première version sort ce soir, les autres versions de plus haute qualité sortieront dans la nuit et demain. J'éspère que cet OAV vous plaira ! Une série est annoncée en plus des OAV. Info ou Intox ? Dans tout les cas, Zéro sera de la partie, donc suivez aussi la série avec nous !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/canaanfin.png[/img]
Ainsi se termine Canaan.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[imgl]images/news/piscine.jpg[/imgl]
Tout d'abord, la sortie du [b]12e épisode de Canaan[/b]. On change complétement de décor par rapport aux précédents épisodes. Cet épisode est centré sur la relation entre Canaan et Alphard, ainsi que les pouvoirs de Canaan.

Ensuite, [b]db0 va a la piscine ![/b] (Elle a mis son joli maillot de bain, et tout, comme sur l'image) Elle sera donc [b]absente du 5 au 26 octobre inclus[/b]. En attendant, l'équipe Zéro va essayer de continuer à faire des sorties quand même, et c'est ryocu qui se chargera de faire les news.

Puis, deux nouveaux partenaires : [b]Gokuraku-no-fansub[/b] et [b]Tanjou-fansub[/b].

Enfin, une bonne nouvelle. Si certains n'étaient pas au courant, j'annonce : [b]Maboroshi no fansub a réouvert ses portes[/b]. L'incident de fermeture était dû à une mauvaise entente entre la personne qui hébergeait le site et le reste de l'équipe. J'ai repris les rênes ! C'est maintenant moi qui gère leur site. Du coup, il n'y a aucun risque de fermeture ou de mauvais entente :). Ils prennent un nouveau départ, et ont décidé de ne pas reprendre leurs anciens projets, sauf Hakushoku to Yousei dûe à la forte demande.

Pour finir, [b]Kobato[/b], dans la liste de nos projets depuis juin, ne se fera finalement pas. Kaze nous a devancé et a acheté la licence.");
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/canaan11.jpg[/img]
Chose promise, chose due. Et en plus, on a même le droit à un peu de ecchi dans cet épisode ! Avec la tenue sexy de Liang Qi, on peut pas dire le contraire... Et un peu de necrophilie aussi. Ouais, c'est tout de suite moins sexy. (Enfin, chacun son truc, hein) Sankaku Complex en a parlé. Cet épisode est un peu triste, comme le précedent, mais un peu plus violent aussi.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/canaan10.jpg[/img]
Vous en rêviez ? Les fans l'ont dessiné... Est-ce que c'est ce qui va se passer dans la suite de l'anime ? Ça semble bien parti... Regardez vite l'épisode 10 pour le savoir ! Et comme on a trop envie de savoir la suite à la fin de cet épisode, je vous promets qu'il ne tardera pas.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/canaancos.jpg[/img]
Je comptais sortir tout les épisodes en même temps, mais comme les autres prennent plus de temps que prévu, on va pas vous faire attendre plus longtemps et on vous propose dès maintenant l'épisode 09, prêt depuis longtemps. Comme vous pouvez le constater, l'équipe est très occupée en ce moment, donc entre deux irl, on taffe un peu fansub, mais ça reste pas grand chose.
Je profite de cette news pour vous poster quelques photos de mon cosplay Canaan. Si vous voulez en savoir plus sur ce cosplay et mes autres, rendez-vous sur mon site perso cosplay :
[url]http://db0.dbcosplay.fr[/url] (et abonnez-vous à la newsletter !)
[url=http://www.cosplay.com/photo/2268921/][img]http://images.cosplay.com/thumbs/22/2268921.jpg[/img][/url] [url=http://www.cosplay.com/photo/2268922/][img]http://images.cosplay.com/thumbs/22/2268922.jpg[/img][/url] [url=http://www.cosplay.com/photo/2268923/][img]http://images.cosplay.com/thumbs/22/2268923.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274553/][img]http://images.cosplay.com/thumbs/22/2274553.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274515/][img]http://images.cosplay.com/thumbs/22/2274515.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274516/][img]http://images.cosplay.com/thumbs/22/2274516.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274517/][img]http://images.cosplay.com/thumbs/22/2274517.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274518/][img]http://images.cosplay.com/thumbs/22/2274518.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274519/][img]http://images.cosplay.com/thumbs/22/2274519.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274520/][img]
http://images.cosplay.com/thumbs/22/2274520.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274521/][img]http://images.cosplay.com/thumbs/22/2274521.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274522/][img]http://images.cosplay.com/thumbs/22/2274522.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274523/][img]http://images.cosplay.com/thumbs/22/2274523.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274531/][img]http://images.cosplay.com/thumbs/22/2274531.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274532/][img]http://images.cosplay.com/thumbs/22/2274532.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274533/][img]http://images.cosplay.com/thumbs/22/2274533.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274536/][img]http://images.cosplay.com/thumbs/22/2274536.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274537/][img]http://images.cosplay.com/thumbs/22/2274537.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274538/][img]http://images.cosplay.com/thumbs/22/2274538.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274540/][img]http://images.cosplay.com/thumbs/22/2274540.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274541/][img]http://images.cosplay.com/thumbs/22/2274541.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274542/][img]http://images.cosplay.com/thumbs/22/2274542.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274543/][img]http://images.cosplay.com/thumbs/22/2274543.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274544/][img]http://images.cosplay.com/thumbs/22/2274544.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274554/][img]http://images.cosplay.com/thumbs/22/2274554.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274555/][img]http://images.cosplay.com/thumbs/22/2274555.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274556/][img]http://images.cosplay.com/thumbs/22/2274556.jpg[/img][/url] [url=http://www.cosplay.com/photo/2274557/][img]http://images.cosplay.com/thumbs/22/2274557.jpg[/img][/url] [url=http://www.cosplay.com/photo/
2274560/][img]http://images.cosplay.com/thumbs/22/2274560.jpg[/img][/url]");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[imgr]images/news/canaan8.png[/imgr]
Avec un peu de retard cette semaine, la suite de la trépidante histoire de Canaan, une fille pas comme les autres.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/can6.jpg[/img]
Comme à son habitude, le petit épisode de Canaan de la semaine fait sa sortie. Et comme prévu, nous n'avons aucune réponse pour le recrutement traducteur T___T pourtant j'aime bien, moi, Mermaid Melody. C'est mignon.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/can45.jpg[/img]
Des bunny girls, des blondasses, et tout ça qui se fait des câlins ! Si c'est pas mignon, tout ça ! Non, pas tant que ça, si on remet l'image dans le contexte. Je vous laisse découvrir tout ça dans la double sortie du jour. Double sortie, pourquoi ? Bah justement. J'ai bien envie de faire des news longues ses derniers temps, donc je vais vous expliquer ce que j'appelle \"le rythme Toradora!\".
Pour ceux qui nous ont connus à l'époque Toradora!, à l'\"apogée\" de la carrière de Zéro, vous vous souvenez sans doute du rythme spéctaculaire auquel les sorties s'enchaînaient. C'était de l'ordre de une sortie tout les deux jours, voir tout les jours ! Pour vous, qui attendez sagement derrière vos écrans, c'est tout bénéf'. Mais ce que vous ne savez pas, c'est que ça travaille, derrière la machine. Nous ne sommes pas une équipe de Speedsub, alors comment réaliser un tel exploit sans perdre de la qualité des épisodes ? Non, non, nous ne savons toujours pas ralentir le temps. Quel est notre secret ? Tout d'abord, sachez qu'il faut minimum 20 heures de boulot pour sortir un épisode chez Zéro (traduction-adaptation-correction-edition-time-vérification finale) encodage non compris. Et que généralement, nous répartissons ses heures sur des semaines. Pour suivre le rythme Toradora!, c'est simple : Etaler ses 20 heures minimum (je dis bien minimum parce qu'en fait c'est beaucoup plus long) sur une seule journée. 
C'est-à-dire sacrifier une journée + une nuit. Pour Toradora!, suivre ce rythme n'était pas trop dur puisque nous étions en coproduction, ce qui nous permettait de faire des pauses de temps en temps dans ces looongues journées de fansub. Mais nous avons décidé de reprendre ce rythme, pour montrer à nos amis leechers que nous n'avons pas vieilli ! C'est pourquoi nous avons choisi un anime qui nous tient à coeur, à Ryocu et moi-même : Canaan. Ici, nous ne sommes pas en coproduction, mais comme nous sommes en vacances, nous pouvons nous permettre de sacrifier deux journées par épisode de Canaan. Oui, deux jours, car il me faut bien faire des pauses, et comme je m'occupe de tout sauf de la vérification finale et que je suis humaine, je ne peux pas me permettre de taffer 24h d'affilée sans faiblir un chouilla.
Bref, je raconte pas tout ça pour me la péter, mais juste pour vous éxpliquer ce que représente un rythme acceléré pour une équipe de bon sub et pas de speedsub. Je raconte ça aussi parce que j'ai été déçu par des réactions de personnes qui se sont dit rapide = mauvais sub. Je vous prouve ici que nous travaillons dur pour vous !!
Et là, je finirai sur une question qui vous turlupine depuis tout à l'heure : Comment se fait-il que vous ne nous sortiez ses épisodes que maintenant ? La réponse est simple : J'avais pas internet dans le trou paumé où je suis pour mes vacances :p
Et histoire de craner un peu : Ryocu et moi passons de superbes vacances en bord de mer dans une grande maison avec piscine dont nous profitons entre deux Canaan.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("Sous la précipitation (train à prendre), j'ai envoyé le mauvais ass à lepims (notre encodeur) pour l'épisode 03 de Canaan, c'est-à-dire celui dont les fautes n'ont pas été corrigés, c'est-à-dire ma traduction telle quelle... Du coup, il a été réencoder, et la nouvelle version est téléchargeable à la place de l'ancienne. Toutes mes excuses !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[imgr]images/news/hitocry.png[/imgr]
Je lance cette bouteille à la mer en espérant que ce message parvienne aux oreilles dune âme charitable Nous recherchons désespérément une personne pour reprendre lune de nos séries, jai nommé Hitohira. Nous n'avons rien à offrir, à part notre gratitude. Nous ne nous attendons pas à avoir beaucoup de réponses, voire rien du tout... Si par bonheur, vous êtes intéressé, nhésitez pas à passer sur le forum, nous vous accueillerons sur un tapis rouge orné de fleurs xD
[pin]
[img]images/news/canaan-3.jpg[/img]
Encore du ecchi dans la série Canaan ! Mais pas que ça, bien sûr. L'épisode 3 est disponible, amusez-vous bien~");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/oppaicanaan.png[/img]
Bah alors ? Zéro nous fait Canaan ? Mais Zéro, c'est une team de l'ecchi, non ? Bah en voilà un peu d'ecchi, dans cette série de brutes ^^ Alors, heureux ? Oui, très heureux. Snif. Tout ça pour dire que y'a l'épisode 02 prêt à être maté. Et vous savez quoi, les p'tits loulous ? Dans l'épisode 01, on comprenait pas toujours ce qu'il se passait. Dans l'épisode 02, on comprends ce qui s'est passé dans l'épisode 1 ! Hein ? Ça se passe toujours comme ça dans les séries sérieuses...? Ah, naruhodo...");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[imgr]images/news/kissx1.jpg[/imgr]
On vous l'avait promis, le v'là ! On a mis un peu de temps parce qu'on l'a traduit à moitié du Japonais, et forcément, ça prend plus de temps. J'espère qu'il vous plaira autant que le premier, parce qu'il dépasse les limites de l'ecchi !
Demain : Epitanime ! J'veux tous vous y voir !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/hinako.jpg[/img]
L'été arrive à grand pas. C'est donc la saison des régimes ! Et qui dit régime, dit bonne alimentation mais aussi entraînement, musculation ! Mais comment arriver à faire bouger nos chers Otakus de leurs chaises...? Hinako a trouvé la solution ! Un entraînement composé de pompes, d'abdos et de flexions on ne peut plus ECCHI ECCHI ! Lancez-vous donc dans cette aventure un peu perverse et rejoignez Hinako dans sa séance de musculation. Et vous le faites, hein ? Hinako vous regarde ;)");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/noel.jpg[/img]
Toute l'équipe Zéro vous souhaite à tous un joyeux noël, un bon réveillon, une bonne dinde, de bons chocolats, de beaux cadeaux et tout ce qui va avec.
Nos cadeaux pour vous :
- Une galerie d'images de Noël (dans les bonus)
- L'OAV de Kiss x sis !
Dans la liste de nos projets depuis cet été, initialement prévu en septembre... Au final, il est sorti le 22 décembre, et nous vous l'avons traduit comme cadeau de Noël. C'est entre-autre grâce à cet OAV que nous avons fait la conaissance de la [partner]kanaii[/partner].");
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img=images/news/bath.jpg]Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko[/img]
  

  Nous avons appris qu'Ankama va diffuser à partir de la rentrée de septembre 2011 :
  Baccano, Kannagi et Tetsuwan Birdy Decode. Tous les liens on donc été retirés.
  On vous invite à cesser la diffusion de nos liens et à aller regarder la série sur leur site.
  
  Sorties d'Isshoni Training Ofuro : Bathtime with Hinako & Hiyoko
  
  3e volet des \"isshoni\", on apprend comment les Japonaises prennent leur bain, très intéressant...
  Avec en bonus, une petite séance de stretching...
  
  Je ne sais pas s'il y aura une suite, mais si oui, je devine un peu le genre ^_^");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img=images/news/kana131.jpg]Kanamemo[/img]

[img=images/news/kana132.jpg]Kanamemo[/img]


Eh oui, c'est déjà la fin de Kanamemo, j'espère que cette petite série fort sympathique vous aura plus autant qu'à nous.
C'est pour nous une bonne nouvelle, on diminue ainsi le nombre de nos projets en cours/futurs, on espère pouvoir faire de même avec d'autres séries prochainement...
[img=images/news/kana133.jpg]Kanamemo[/img]

On vous annonce déjà que Kujibiki Unbalance II et Potemayo seront entièrement refaits ! Pas mal de choses ont été revues, j'espère que vous apprécierez nos efforts.
Kodomo no Jikan OAV 4 ne devrait plus tarder...
Merci de nous avoir suivis et à bientôt pour d'autres épisodes ^_^

[img=images/news/kana134.jpg]Kanamemo[/img]

[img=images/news/kana135.jpg]Kanamemo[/img]");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img=images/news/kana12.jpg]Kanamemo[/img]


Bonjour !
Sortie de l'épisode 12 de Kanamemo ! Youhouh ! C'est la fête !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img=images/news/kana11.jpg]Kanamemo[/img]


Bonjour !
Sortie de l'épisode 11 de Kanamemo ! Youhouh ! C'est la fête !

Rappel, nos releases sont téléchargeable sur :
[left][list]
[item]Sur [url=http://zerofansub.net/]le site zerofansub.net[/url] en DDL (cliquez sur projet dans le menu à gauche)[/item]
[item]Sur [url=http://www.bt-anime.net/index.php?page=tracker&team=Z%e9ro]notre tracker torrent BT-Anime[/url] en torrent peer2peer (Notre équipe de seeder vous garantie du seed !)[/item]
[item]Sur [url=irc://irc.fansub-irc.eu/zero]notre chan IRC[/url] en XDCC ([url=?page=xdcc]liste des paquets[/url])[/item]
[item]Sur [url=http://www.anime-ultime.net/part/Site-93]Anime-Ultime[/url] en DDL (Mais en fait, c'est les mêmes fichiers que sur Zéro, c'est juste des liens symboliques ^^)[/item]
[/list][/left]");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[imgl=images/news/kana10.jpg]Kanamemo[/imgl]


Bonjour !
Sortie de l'episode 10 de Kanamemo ! Youhouh ! C'est la fete !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img=images/news/kanamemo7.jpg]Kanamemo[/img]


Voilà qui met un terme à cette longue période d'inactivité : Kanamemo 7, 8 et 9, enfin !
Tout comme l'épisode 5, l'épisode 7 était inutilement censuré, donc on s'est orientés vers les DVD. En version HD uniquement, la LD n'est plus très en vogue, faut dire ^^
D'autres projets reprennent du service, encore un peu de patience...
Je vous dis à bientôt pour d'autres épisodes ^_^");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img=images/news/kanac1.jpg]Kanamemo Chapitre 01[/img]

Sortie du chapitre 01 de Kanamemo qui ouvre le retour du scantrad chez Zéro !
Depuis pas mal de temps, nous l'avions laissé à l'abandon mais avec l'école du fansub, nous avons pu nous y remettre.
Sont prévus les scantrad de Kanamemo, Sketchbook et Maria+Holic. Quelques doujins devraient aussi arriver.
Pour toutes nos autres séries dont les versions manga existent, vous pouvez les trouver en téléchargement sur les pages des séries comme Hitohira, Kannagi, Kimikiss et KissXsis.

A bientot !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/newskana6.jpg[/img]
Hé !
Mais c'est qu'on arrive à la moitié de la série.
Le 6éme épisode de Kanamemo est disponible.");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[url=http://yotsuba.imouto.org/image/b943e76cbe684f3d4c4cf3b748d7d878/moe%2099353%20amano_saki%20fixed%20kanamemo%20kujiin_mika%20nakamachi_kana%20neko%20pantsu%20seifuku.jpg][img]images/news/newskana5.jpg[/img]
(Image en plus grand clique ici)[/url]
Coucou, nous revoilou !
La suite de Kanamemo avec deux épisodes : le 4 et le 5.
Dans les deux, on voit des filles dans l'eau... Toute nues, aux bains, et en maillot de bain à la \"piscine\" !
Les deux sont en version non-censurée.
Pour voir la différence entre les deux versions : [url=http://www.sankakucomplex.com/2009/11/10/kanamemo-dvd-loli-bathing-steamier-than-ever/]LIEN[/url].
En bonus, un petit AMV de l'épisode 05 (passé à la TV, nous le l'avons pas fait nous-même).
À bientôt !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/kana3.jpg[/img]
BANZAIII !! Kanamemo épisode 03, ouais, trop bien ! Je mets du temps à sortir les épisodes ces derniers temps, mais derrnière le rideau, ne vous inquiétez pas, ça bosse ! Oui, c'est encore de ma faute, avant la piscine, maintenant printf, je suis débordée... (Mais de quoi elle parle !? o__O) Bref. Bon épisode !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img]images/news/kana1.jpg[/img]
Bonsoir....

Kodomo no Jikan touche à sa fin (bouhouh T__T) et on nous a proposé un anime sur le forum : Kanamemo. On a tout de suite vu qu'il s'inscrivait directement dans la ligne directe de Kodomo no Jikan, ecchi ~ loli ! Rétissants au départ à commencer un nouvel anime sans finir nos précédents en cours, mais ayant plusieurs personnes de l'équipage n'ayant rien à faire, nous avons finalement accepté la proposition. Cet anime est trop mignon~choupi~kawaii, c'est la petite Kana qui perd sa grand-mère et ses parents et doit se debrouiller toute seule et trouver du travail. Y'a aussi un peu de yuri dedant, donc je pense que tout le monde y trouvera ce qu'il aime !");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Joyeux Noël !");
			$news->setTimestamp(strtotime("24 December 2011 21:05"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setCommentId(277);
			$news->setTeamNews(false);
			$news->setMessage("Allez pour me faire pardonner de ma dernière news, un petit goût de Noël dans cette mini-news (cliquez sur l'image).

[url=images/news/%5BZero Fansub%5DNoel 2011.zip][img=images/news/noel3.jpg]Joyeux Noël ![/img][/url]");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setMessage("[img=images/news/kujian9news.jpg]Kujibiki Unbalance épisode 09 - Yamada montre sa culotte Renko[/img]

Chihiro, Tokino, Koyuki, Yamada et Renko sont de retour pour la suite de leurs aventures pour devenir les membres du conseil des élèves de Rikkyouin ! Retrouvez les dans cet épisode 09 où Yamada ne sera pas dans son état normal...
Comme d'habitude, l'épisode est téléchargeable sur la page de la série partie \"Projets\" en téléchargement direct uniquement et plus tard en torrent, XDCC, etc.

[img=images/news/news_dons_k-on.gif]Merci pour le don a Herve ! K-On money money[/img]

Un grand [b]merci[/b] à Hérvé pour son don de 10 euros qui va nous aider à payer nos serveurs !

A bientot !

");
			$news->setTwitterTitle("Sortie de Kujibiki Unbalance episode 09 chez Zero ! http://zerofansub.net/");
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~ full color's  ~ Picture Drama série complète (01 à 06)");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("26 June 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img=images/news/sketchdrama.png]Sketchbook ~ full color's ~ Picture Drama[/img]
Pour fêter les vacances qui arrivent, Sora et ses amies vous emmenent avec elles à la mer !
C'est une petite série de 6 épisodes de moins de 10 minutes chacun qui étaient en Bonus sur les DVDs de Sketchbook ~ full color's ~. Ils ont été réalisé à partir du Drama CD de la série et l'animation est minime. Dans la même douceur que la série, ils sont parfait pour se reposer en pensant aux vacances qui arrivent.");
			$news->setCommentId(234);
			$news->setTeamNews(false);
			$news->addReleasing(Project::getProject('sketchbookdrama'));
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kujibiki Unbalance 2 episode 08");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("03 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/newskuji8.png[/img]
Comment attirer l'oeil des fans d'animes de chez Zero ?
Avec une paire de seins, evidemment !
Episode 8 de Kujibiki Unbalance 2 en exclusivite total gratuit pas cher promo solde !
Un episode qui m'a beaucoup plu, tres tendre et qui revele des elements cles de l'histoire.
En reponse au precedent sondage, il n'est ABSOLUMENT PAS NECESSAIRE D'AVOIR VU GENSHIKEN OU LA PREMIERE SAISON de Kujibiki Unbalance pour regarder celle-ci. Les histoires ont quelques liens mais sont completement independantes les unes des autres. C'est une serie a part.
Bon episode a tous et a tres bientot !");
			$news->setCommentId(220);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep8'));
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setDisplayInHentaiMode(false);
			$news->setTitle("Potemayo [08] 15 + 16");
			$news->setTimestamp(strtotime("01 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage('[img]images/news/pote8.jpg[/img]
Anyaa~~
Potemayo, épisode 8, youhou ! Et très bientôt, Kanamemo, Isshoni H shiyo et Isshoni sleeping ! Enjoy, Potemayo !');
			$news->setCommentId(207);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('potemayo', 'ep8'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Potemayo [07] 13 + 14");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTimestamp(strtotime("30 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Tarf"));
			$news->setMessage("[img]images/news/moepote1.jpg[/img]
Revenons à nos charmants allumés dans un PotemaYo que j'ai particulièrement aimé.

Deux épisodes : La fin de l'été, et La nuit du Festival

Encore, encore un épisode totalement déjanté, où on va devoir faire du nettoyage... et prier. Puis on va manger de la glace à base de lait avec un type fou, fou, fou ^^
Hé, vous voulez savoir comment on fait cuir plus vite des ramens ?

Moi ça m'éclate comment Potemayo sait dépenser son argent
ENJOY IT !
[img]images/news/moepote2.jpg[/img]
db0 dit : Les screens ci-dessus n'ont rien à voir avec l'épisode :) Ce sont des extraits de Moetan, l'épisode 11. J'en profite donc pour faire une petite pub à notre partenaire [partner]kanaii[/partner] grâce à qui on peut regarder Moetan avec des sous-titres d'excellente qualité.");
			$news->setCommentId(191);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('potemayo', 'ep7'));
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin");
			$news->setTimestamp(strtotime("19 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage('[img=images/news/newkodomo1.jpg]Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin[/img]

Vous l\'avez attendu longtemps, celui-là ! Il faut dire qu\'il est quand même sorti en aout. Alors pourquoi le sortir si tard ? Surtout qu\'il faut savoir qu\'il était prêt en septembre. C\'est simple : Pour toujours rester dans l\'optique de la qualité de nos animes, nous attendions que les paroles officielles du nouvel ending sortent. Malheuresement, elle ne sont toujours pas sorties à l\'heure actuelle. Nous pensons donc que les chances qu\'elles sortent maintenant sont minimes et avons à contre-coeur décidé de sortir l\'OAV maintenant et sans le karaoké. Cependant, sachez que s\'il s\'avère que les paroles finissent par sortir, même tardivement, nous sortirons une nouvelle version de celui-ci avec le karaoké !
Merci à DC pour avoir encodé cet épisode et Maboroshi, avec nous en coproduction sur cette série.
C\'est avec ce dernier épisode que nous marquons la fin de Kodomo no Jikan ! C\'est ma série préférée et je pense que c\'est aussi la préférée de beaucoup de membres de chez Zéro et sa communauté.
Nous avons passé du bon temps aux côtés de Rin et ses deux amies et nous éspérons que c\'est aussi votre cas.

[img=images/news/newkodomo2.jpg]Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin[/img]

[img=images/news/newkodomo3.jpg]Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin[/img]');
			$news->setCommentId(185);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo2', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama ~Kiss on my deity~ 12 - Fin");
			$news->setTimestamp(strtotime("12 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("C'est aujourd'hui la fin de Tayutama. Le douzième et dernier épisode toujours en coproduction avec nos amis de chez Maboroshi. Nous éspérons que vous avez passé un bon moment avec nous pour cette merveilleuse série ! Et maintenant, it's scrolling time !

[img]images/news/tayufin1.jpg[/img]
[img]images/news/tayufin2.jpg[/img]");
			$news->setCommentId(176);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('tayutama', 'ep12'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama - Kiss on my Deity - 11");
			$news->setTimestamp(strtotime("04 December 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("TchO"));
			$news->setMessage("[img]images/news/mashinoel.jpg[/img]
Tayu 11, la Bataille Décisive !!

Pour calmer la colère du dragon, la grande prêtresse Mashiro tente...
Hé !!!!! Mais que se passe-t-il ????? C't'une surprise !!!

Pour la Bataille Décisive, on a droit à un cosplay de Dieu !!
Si c'est comme ça que Mashiro espère gagner la partie !

Tenez bon ! La fin se précise, et elle est belle à regarder !

Coproduction Zero+Maboroshi !
TchO_°");
			$news->setCommentId(152);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('tayutama', 'ep11'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama - Kiss on my Deity - 10");
			$news->setTimestamp(strtotime("17 November 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("TchO"));
			$news->setMessage("[img]images/news/tayu10.jpg[/img]
L'Horoscope d'aujourd'hui :
Humains : Ecrasé par l'émotion, sachez éviter les coups de marteau !

Portée par le rêve de la coexistence, Yumina-chan danse.
Quant à Ameri, elle est la proie de ses mauvais rêves...

Même romantique, la passion peut être tellement furieuse !");
			$news->setCommentId(149);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('tayutama', 'ep10'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama - Kiss on my Deity - 09");
			$news->setTimestamp(strtotime("05 November 2009 01:00"));
			$news->setAuthor(TeamMember::getMemberByPseudo("TchO"));
			$news->setMessage("[img]images/news/tayuu9.jpg[/img]
Mashiro découvre que la moto est un souci pour aller aux sources d'eau chaudes.

Hé, on va tous faire un karaoké ?
C'est le moment de s'amuser !
Entre deux entraînements, une balade à la tour de Tokyo.
Les sentiments de Mashiro n'échappent à personne, ni à Ameri, ni à...

Une Zero + Maboroshi coprod

TchO_°");
			$news->setCommentId(141);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('tayutama', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama - Kiss on my Deity - 08");
			$news->setTimestamp(strtotime("05 November 2009 00:30"));
			$news->setAuthor(TeamMember::getMemberByPseudo("TchO"));
			$news->setMessage("[img]images/news/tayuuu.jpg[/img]
Tayutama !!!!!!
Tayutama, c'est pour ce soir l'épisode 08, toujours coproduit avec la Maboroshi.
Un épisode qui nous livre, dans une exceptionnelle interprétation, un remake de \"j'assortis mon foulard avec ma jupe\".
Et puis, on allait pas louper la tronche de Yuuri pour une fois ^^
(Ca veut dire quoi, au fait, Tayutama ?)
Profitez-en bien, c'est toujours aussi délire !!
db0 dit :
J'en profite en coup de vent pour vous annoncer que la deuxième session de Konshinkai à Lyon arrive en fin du mois, et pour ça, un forum a fait son ouverture ainsi qu'un nouveau site et un chan irc. Venez nombreux ! [url=http://konshinkai.c.la]+ d'infos, clique.[/url]");
			$news->setCommentId(140);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('tayutama', 'ep8'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama - Kiss on my Deity - 06 + 07 + Kanamemo 02");
			$news->setTimestamp(strtotime("05 November 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/tayuu.jpg[/img]
Bonjour tout le monde !
Je me suis dit que c'était toujours moi qui rédigait les news, et qu'il serait temps que ça change. Donc j'ai demandé à quelques membres de l'équipe de le faire. J'ai trouvé le résultat assez marrant, donc je vous donne leurs petites idées de news :

Praia dit :
\"On abandonne tout et on recommence : Tayutama 6 et 7 en copro avec la Maboroshi.
Bon leech ! Version MP4 disponible uniquement.
Kanamemo, c'est quoi ? C'est la série des petits pervers... non, vous voyez, suis pas fait pour faire des news, moi... ^_^
Dommage que Sunao ne soit pas là... Il nous aurait pondu une brique > <\"


Tarf dit :
\"Hein ? J'ai pas signé pour ça moi ! Et puis je suis juste un petit trad qui fait un peu de time à ses heures perdus, donc je fais le début de chaîne. C'est aux gens en bout de chaîne de faire ça non ? Va donc voir le joli post \"staff\" que tu as pondu sur toutes les séries, et choppe le dernier nom ^^.
Bon, une petite news : \"J'ai pu rencontrer samedi 31 octobre, à l'occasion du Konshinkai trois personnes parfois intéressantes. J'ai ainsi parlé IRL mon idole Ryokku, qui travail en tant qu'admin pour anime ultime, qui est à mon avis un des meilleurs sites français d'anime. Après une interview exclusive de ce monument vivant de l'animation, il m'a confié qu'il désespérait de la saison en cours d'anime, et qu'aucun ne trouvait grâce à ses yeux. N'ayant pas les mêmes goûts que lui, je ne suis pas d'accord, mais moi tout le monde s'en fout. Pour ceux que ça interesse, il est gentil, jeune et dynamique ! Avis aux jeunes filles, jetez vous dessus !\"
Tayutama Kiss on my deity, épisode 6 et 7 enfin sortis en corproduction avec la Maboroshi no Fansub ! La suite des aventures plus ou moins osée de l'avatar fort mignon d'une déesse dans le monde réel. Vous y retrouverez l'amie d'enfance jalouse, la Tsundere et la naïve à forte poitrine. La version MP4 est disponible immédiatement sur le site, la version AVI étant abandonnée.\"

db0 dit :
J'en profite en coup de vent pour vous annoncer que la deuxième session de Konshinkai à Lyon arrive en fin du mois, et pour ça, un forum a fait son ouverture ainsi qu'un nouveau site et un chan irc. Venez nombreux ! [url=http://konshinkai.c.la]+ d'infos, clique.[/url]");
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('tayutama', 'ep6'));
			$news->addReleasing(Release::getRelease('tayutama', 'ep7'));
			$news->addReleasing(Release::getRelease('kanamemo', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tayutama ~ Kiss on my Deity ~ 06");
			$news->setTimestamp(strtotime("21 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/newtayu.jpg[/img]
On vous l'avait promis : on n'allait pas laisser tomber Maboroshi ! Et voilà, c'est chose faite : l'épisode 06 de Tayutama sort aujourd'hui. J'espère qu'il vous plaira.");
			$news->setCommentId(105);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('tayutama', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Hitohira 05 + 06");
			$news->setTimestamp(strtotime("10 November 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/hito5.jpg[/img]
Mugi-choco ! Tu nous as tellement manqué... Et tu reviens en maillot de bain, à la plage ! Yahou ! Mugi-Mugi-choco !!");
			$news->setCommentId(142);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('hitohira', 'ep5'));
			$news->addReleasing(Release::getRelease('hitohira', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Hitohira 04 + KnJ Ni Gakki OAV Spécial Version LD HD");
			$news->setTimestamp(strtotime("02 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/hito4.jpg[/imgr]
On est decidé, on va avancer nos projets ! L'un de nos plus vieux, Hitohira, revient ce soir avec son 4ème épisode.
Et les versions LD et HD tant attendues de l'OAV sorti hier sont aussi arrivées. Profitez-en, c'est gratuit, aujourd'hui ! Et tous les autres jours aussi.");
			$news->setCommentId(55);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('hitohira', 'ep4'));
			$news->addReleasing(Release::getRelease('kodomo2', 'ep0'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("KnJ 03 LD V2, Petit point sur nos petites séries");
			$news->setTimestamp(strtotime("26 January 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/akirin.jpg[/img]
Petite v2 qu'on attendait depuis pas mal de temps : L'épisode 03 de Kodomo no Jikan LD qui avait quelques petits soucis d'encodage. [url=ddl/%5BZero%5DKodomo_no_Jikan%5B03v2%5D%5BXVID-MP3%5D%5BLD%5D%5B499E9C85%5D.avi]DDL[/url]
 
On en profite pour faire un petit point sur nos séries actuellement.
 - [b]Alignment you you[/b] En cours de traduction, mais on prend notre temps.
 - [b]Genshiken 2[/b] L'épisode 07 est en cours d'adapt-edit.
 - [b]Guardian Hearts[/b] En pause pour le moment.
 - [b]Hitohira[/b] En cours de traduction.
 - [b]Kimikiss pure rouge[/b] En pause pour le moment.
 - [b]Kodomo no Jikan[/b] L'épisode 10, 11, 12 sont prêt. La saison 2 arrive bientôt. Heuresement, avec la fin de la saison 1 qui s'approche...
 - [b]Kujibiki Unbalance[/b] Je vais m'y mettre...
 - [b]Kurokami[/b] En attente de Karamakeur.
 - [b]Maria Holic[/b] Très bientôt [img=http://img1.xooimage.com/files/w/i/wink-1627.gif]Wink[/img]
 - [b]Mermaid Melody[/b] Notre annonce a fonctionnée, LeChat, notre traducteur IT-FR prend la suite en charge.
 - [b]Sketchbook full color's[/b] Des V2 des épisodes 1 et 5 ainsi que l'épisode 6 sont en cours d'encodage par Ajira.
 - [b]Toradora![/b] Le 10 arrive !");
			$news->setCommentId(32);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kodomo', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Hitohira 03");
			$news->setTimestamp(strtotime("07 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/mugi.png[/img]
Oh !
À cause d'un problème de raws, la série Hitohira est restée en pause pendant trèèès longtemps. Mais grâce à Lyf, le raw-hunter, et bien sûr à Jeanba, notre nouveau traducteur, mais aussi à B3rning14, nouvel encodeur, la série peut continuer. Et c'est donc l'épisode 03 que nous sortons aujourd'hui !

La Genesis ayant accepté que leurs releases en co-pro avec la Kanaii soient diffusées en DDL chez nous, vous pouvez maintenant retrouver la saison 2 de Rosario+Vampire ainsi que 'Kimi ga Aruji de Shitsuji ga Ore de - They are my Noble Masters'. [ext=?page=kanaiiddl]Lien[/ext]
Bon DL !

Les dernières sorties de la [partner]kanaii[/partner] :
- Kanokon 11
- Kanokon 12");
			$news->setCommentId(18);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('hitohira', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Quelques mises à jour");
			$news->setTimestamp(strtotime("12 October 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/sorties/lasthitohira2.png[/img]

Cela faisait pas mal de temps que Zéro n'avait rien sorti !
Je pense vous faire plaisir en vous annonçant quelques nouvelles :
- 4 épisodes sont prêts et attendent juste d'être encodés.
- 2 Nouvelles séries sont à paraître :
-- Sketchbook ~full color's~ 
-- Toradora!
- Bientôt une v3 du site !

On profite de cette news pour mettre fin à certaines rumeurs :
- Non ! Nous ne faisons pas de Hentaï
- Non ! Nous n'avons pas tous 13 ans ! 
- Nous n'avons rien contre la Genesis. Au contraire, si ça pouvait s'arranger, je préfererais. Nous ne comprenons toujours pas le pourquoi du comment de cette histoire, mais soyez sûr que nous ne répondrons jamais à leurs éventuelles provocations, insultes ou agressions.
Merci à tous et Bon download !");
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('hitohira', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 12 ~ fin ! + 01v2 & 02v2");
			$news->setTimestamp(strtotime("29 September 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/ogiue.jpg[/img]
Et ainsi se termine Genshiken, le club d'étude de la culture visuelle moderne, avec un 12e épisode et quelques v2 pour perfectionner. Elle est pas trop mignonne, comme ça, Ogiue ?");
			$news->setCommentId(133);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('genshiken', 'ep12'));
			$news->addReleasing(Release::getRelease('genshiken', 'ep1'));
			$news->addReleasing(Release::getRelease('genshiken', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 2 épisode 11");
			$news->setTimestamp(strtotime("19 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/genshiken-11.jpg[/imgr]
C'est les vacances pour certains membres de chez Zéro donc on a le temps de s'occuper de vous... Du moins, des épisodes que vous attendez avec impatience. (Pour qu'on s'occupe de vous personnellement, appelez le 08XXXXXXXX 0.34 la minute demandez Sonia) Bref, ce soir sort l'épisode 11 de la saison 2 de Genshiken, c'est-à-dire l'avant dernier de la série. Les deux copines américaines sont toujours là pour vous faire rire, mais partieront à la fin de l'épisode. Profitez bien, c'est bientôt la fin ^^");
			$news->setCommentId(104);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('genshiken', 'ep11'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 10");
			$news->setTimestamp(strtotime("24 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/gen10.jpg[/imgr]
Notre petit Week-end d'otaku kanaii-zéro s'est très bien passé, dommage pour ceux qui n'y étaient pas ^^
Vous vous en foutez ? Anyaa ~~ Bon, bon, le v'là votre épisode 10 de Genshiken.
Petite info importante : L'OAV de KissXsis est en cours. Après sa sortie, Zéro se met en \"pause\" temporaire puisque je passe mon bac.");
			$news->setCommentId(76);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('genshiken', 'ep10'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 09");
			$news->setTimestamp(strtotime("22 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/genshi9.jpg[/imgr]
Nyaron~ La suite de Genshiken 2 avec l'épisode 09. Bon download, bande d'otaku.");
			$news->setCommentId(75);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('genshiken', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken2 08 + Sortie Kanaii");
			$news->setTimestamp(strtotime("10 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]http://moe.mabul.org/up/moe/2009/05/10/img-122101gdcpq.png[/img]
3 sorties en une journée, c'est un cas plutôt rare ! La suite de Genshiken2, c'est [project=genshiken]par là[/project] avec l'épisode 08 qui sort aujourd'hui. Plus tard dans la soirée sortieront les versions LD de Kodomo oav2 et md, ld de Maria Holic 08.

Une petite sortie Kanaii-Zéro est organisée entre Otaku le 23 et 24 mai à Nice ! Les sudistes pourront ainsi se retrouver sur nos plages ensoleillées pour se sentir un peu en vacances. Et les nordistes, n'hésitez pas à descendre nous voir ! Si vous souhaitez être de la partie, n'hésitez pas ! Envoyez-moi un mail (zero.fansub@gmail.com) ou venez vous signaler sur le forum Kanaii : [url=http://www.kanaii.com/e107_plugins/forum/forum_viewtopic.php?46591]Lien[/url]. Venez nombreux !");
			$news->setCommentId(70);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('genshiken', 'ep8'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria+Holic 05 et Genshiken2 07");
			$news->setTimestamp(strtotime("20 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/mariagen.jpg[/imgr]
[imgl]images/news/mariagen2.jpg[/imgl]
Un problème de ftp est survenu hier soir, ce qui nous a poussé à reporter la sortie de Maria+Holic 05 à aujourd'hui. (Nous nous excusons auprès de [partner]kanaii[/partner] en coproduction sur cet anime). Genshiken2 07 devait sortir ce soir. Maria 05 est toujours aussi drôle et dans l'épisode 07 de Genshiken, vous trouverez 2 nouveaux karaokés (à vos micros !). Profitez bien de cette double sortie !
[pin]
[project]mariaholic[/project] [project]genshiken[/project]");
			$news->setCommentId(49);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('genshiken', 'ep7'));
			$news->addReleasing(Release::getRelease('mariaholic', 'ep5'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 06");
			$news->setTimestamp(strtotime("13 January 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/gen6.jpg[/img] 
Otaku, otaku, nous revoilà ! Genshiken épisode 06 enfin dans les bacs, en ddl.
[project=genshiken]Pour télécharger les épisodes en DDL, cliquez ici ![/project]

[b]Les dernières sorties de la [partner]sky-fansub[/partner] :[/b]
Kurozuka 08
Mahou Shoujo Lyrical Nanoha Strikers 21

[b]Les dernières sorties de la [url=http://kyoutsu-subs.over-blog.com/]Kyoutsu[/url] :[/b]
Hyakko 06

[b]Les dernières sorties de la [partner]kanaii[/partner] :[/b]
Kamen no maid Guy 01v2
Rosario+Vampire Capu2 07v2");
			$news->setCommentId(31);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('genshiken', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 05, Toradora! 08, Sketchbook 05 et Recrutement QC");
			$news->setTimestamp(strtotime("10 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/recrut/qc.jpg[/img]
3 sorties en une, aujourd'hui ! Les épisodes 5 de Genshiken2, 8 de toradora! et 5 de Sketchbook sont disponibles dans la partie projets en DDL uniquement pour le moment. Les liens torrents, XDCC, Streaming viendront plus tard, ainsi que la version avi de genshiken et H264 de Toradora. Bon épisode !

Notre unique QC, praia, aimerait bien partager les QC de toutes nos séries avec un autre QC. Si vous êtes exellent en orthographe et que vous avez un oeil de lynx, nous vous solicitons ! Merci de vous présenter au poste de QC ^^ [url=?page=recrutement]Lien[/url]");
			$news->setCommentId(21);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('genshiken', 'ep5'));
			$news->addReleasing(Release::getRelease('toradora', 'ep8'));
			$news->addReleasing(Release::getRelease('sketchbook', 'ep5'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
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
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria+Holic 12 - Fin de la série");
			$news->setTimestamp(strtotime("20 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-right]images/news/mariafin.png[/img-right]
Cette série était si drôle qu'elle est passée bien vite... Eh oui ! Déjà le dernier épisode de Maria+Holic ! Ce 12e épisode est complétement délirant, Kanako fait encore des siennes, et Mariya la suit de près. Avec la fin de cette série se termine aussi une coproduction avec Kanaii, nos partenaires et amis, qui s'est exellement bien passée et que nous accepterons avec plaisir de renouveler. Merci à eux et particulièrement à DC, le maître du projet aux superbes edits AE. Bon dernier épisode, et aussi bonne série à ceux qui attendaient la fin pour commencer la série compléte !");
			$news->setCommentId(115);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep12'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 07 + Maria Holic 11 + Mermaid Melody 02");
			$news->setTimestamp(strtotime("17 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-right=images/news/canaan7.png][/img-right]
[img-left=images/news/maria11.png][/img-left]
Une triple sortie ce soir !

Tout d'abord, l'habituel Canaan de la semaine avec l'épisode 07. Cet épisode était particulièrement difficile, avec tout ces politiciens, tout ça tout ça, donc nous a pris plus de temps que prévu mais nous y sommes arrivé !

Une deuxième sortie qui est en fait un épisode déjà encodé depuis longtemps mais que nous n'avions pas encore mis sur le site, l'épisode 2 version italienne de Mermaid Melody Pichi Pichi Pitch. Je pense ne décevoir personne, mais je rappelle que nous abandonnons les versions italiennes pour continuer les versions japonaises de chez Maboroshi (nous recrutons pour cela un traducteur ! SVP ! Help us !). Les liens de téléchargement des 13 épisodes par Maboroshi ne sont pas encore tous mis en place mais le seront dans le courant de la journée de demain.

Et enfin, la suite de Maria Holic que vous attendiez tous ! L'épisode 11 et... avant-dernier épisode. Profitez bien de ce concentré d'humour avant la fin de cette superbe série, toujours en coproduction avec nos chers amis de chez Kanaii. La version avi ne sera disponible que demain.");
			$news->setCommentId(113);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep11'));
			$news->addReleasing(Release::getRelease('canaan', 'ep7'));
			$news->addReleasing(Release::getRelease('mermaid', 'ep54'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Canaan 01 + Maria Holic 10");
			$news->setTimestamp(strtotime("16 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img=images/news/canaan.jpg][/img]
Une double sortie ce soir (peut-être pour rattraper vos attentes ?) dont l'épisode 10 tant attendu de Maria Holic avec comme toujours nos potes de chez Kanaii, et une nouvelle série : Canaan. C'est un nouveau projet assez original puisque c'est un genre d'anime qu'on ne fait habituellement chez Zéro. En fait, c'est Ryocu (le chef ultime !) qui s'est motivé à la traduire. J'espère qu'elle vous plaiera ! Bon download !");
			$news->setCommentId(101);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep10'));
			$news->addReleasing(Release::getRelease('canaan', 'ep1'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria Holic 09");
			$news->setTimestamp(strtotime("05 June 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-right]images/news/maria9.jpg[/img-right]
La team était en \"semi-pause\", maintenant que notre épisode en coproduction est sorti (Maria Holic 09 avec Kanaii), la team est en pause totale et revient en juillet. Bon épisode en attendant.");
			$news->setCommentId(78);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria Holic 08 + Doujin");
			$news->setTimestamp(strtotime("09 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-right]images/news/maria8.jpg[/img-right]
Maria Holic épisode 08 pour aujourd'hui, en coproduction avec Kanaii. Un épisode plutôt riche, et toujours aussi drôle. En bonus avec cet épisode, les images des anges \"cosplayés\" pendant l'épisode. [project=mariaholic]C'est par là ![/project]


PARTIE HENTAÏ :
Une mise à jour de la partie hentaï du site et la sortie d'un doujin de He is my master [project=heismymaster]Par là ![/project]");
			$news->setCommentId(67);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep8'));
			$news->addReleasing(Project::getProject('heismymaster'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria+Holic 07");
			$news->setTimestamp(strtotime("24 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/maria7.jpg[/imgr]
La suite de Maria+Holic, toujours en coproduction avec nos petits kanailloux. Disponible en DDL pour l'instant, et un peu plus tard en torrent et MU. J'en profite pour vous informer que nous risquons de ralentir le rythme puisque je suis en vacances, mais que dès la rentrée, tout reviendra dans l'ordre.");
			$news->setCommentId(63);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep7'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria+Holic 06");
			$news->setTimestamp(strtotime("05 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/maria6.jpg[/imgr]
Maria+Holic, la suite plutôt attendue ! L'épisode 06, en coproduction avec la Kanaii. Et notre DC et ses edits. Un épisode particulierement important pour la série : On y apprend une information ca-pi-tale ! À ne pas manquer !

Sinon, HS, je suis un peu déçue de voir que le nombre de visite diminue de façon exponentielle depuis la fin de Toradora!... Anya >.< 


EDIT : Sorties des deux autres versions.");
			$news->setCommentId(56);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria Holic 03");
			$news->setTimestamp(strtotime("16 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			// TODO refine partner links when implemented
			$news->setMessage("Maria Holic 03, en copro avec [partner]kanaii[/partner]. [project=mariaholic]L'épisode en DDL, c'est par ici ![/project]");
			$news->setCommentId(39);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria Holic 02");
			$news->setTimestamp(strtotime("07 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/mariaholic2.jpg[/img]
En direct de Lyon, je vous sors le deuxième épisode de Maria+Holic en co-production avec [partner]kanaii[/partner].
Les mésaventures de Kanako continuent, ne les manquez pas !
[project=mariaholic]L'épisode en DDL, c'est par ici ![/project]

 PS : Maboroshi est de retour !!");
			$news->setCommentId(38);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Maria+Holic 01");
			$news->setTimestamp(strtotime("28 January 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/kanako.png[/img]
Nouvelle série que l'on avait pas annoncé officiellement pour le moment : Maria+Holic. Mais ce n'est pas tout : Nouvelle co-production aussi, non pas avec MNF, mais cette fois-ci avec l'un de nos [ext=?page=dakko]partenaires dakkô[/ext] a qui l'on offre du DDL et qui nous laisse poster sur leur site quelques news.... [partner=kanaii]Kanaii ![/partner]
Trèves de paroles inutiles : Voici donc l'épisode 01, disponible en DDL chez nous et torrent MU chez eux.
[url=ddl/%5bKanaii-Zero%5d_Maria+Holic_01_%5bX264_1280x720%5d.mkv]DDL[/url]");
			$news->setCommentId(33);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('mariaholic', 'ep1'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Potemayo 06 (11 + 12)");
			$news->setTimestamp(strtotime("04 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/pote.jpg[/img]
Le sondage de la semaine dernière était un peu foireux parce ce qu'on pouvait pas voter en fait donc euh les commentaires seront pris en compte finalement. Merci pour vos réponses. Nous continueront of course à poster moultes actualités concernant autre chose que le fansub. Ce sont les vacances, donc nous en profitons bien, mais nous ne chômons pas quand même et vous proposons donc quelques petits épisodes à regarder entre 2 séries de bronzage ou de baignade ou que sais-je encore de randonnées, de visites au musée, pourquoi pas de job d'été, ect. M'enfin, bref, je m'étale inutilement (comment ça, comme d'habitude ?) et vous propose de vous rendre sur le site si vous n'y êtes pas déjà pis d'aller télécharger notre petit potemayo, mignon potemayo, potemayo, potemayo naaassuuu !! (ça veut rien dire, c'est normal, j'ai un peu bu)(bah quoi ? c'est les vacances ou pas ?). Je regretterai sûrement d'avoir écrit une news aussi foncedé demain mais bon vous inquiétez pas je l'étais pas quand je taffais sur cet épisode, 
hein. J'vous l'jure, m'sieur l'agent. J'suis sobre, moi, j'bois pas. Jamais, jamais. J'vais jamais en soirée ou quoi, non, non. Moi, je fais du fan-sub ! Du fan-sub ! Sinon, vous avez vu, l'image de sortie, au dessus ? Elle est pourrie, hein ? C'est parce que je sais pas me servir de Gimp et que j'ai internet qu'avec ubuntu parce que j'ai fait ça avec un téléphone portable, en fait. C'est ça, marrez-vous. M'enf, j'apprendrais à utiliser Gimp !! Bon, bon. Et l'image du mois, elle vous plaît ? Ouais, c'est des nichons, tout ça, là, ça vous plaît, ce genre de trucs. Moi, ça me plaît bien en tout cas. Je kiffe ma race, même, je dirais. Et moi, je fais du cosplay !! Si, si. Fin.");
			$news->setCommentId(108);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('potemayo', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Potemayo 05");
			$news->setTimestamp(strtotime("21 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/pote5.jpg[/imgr]
Si c'est pas trop Kawaii, ça ? Bah oui, c'est Potemayo ! Comme vous le savez, notre partenaire, Kirei no Tsubasa, a déposé le bilan récemment. Histoire de ne pas laisser leurs projets tomber à l'eau, nous avons accepté de reprendre le projet Potemayo. Nous continuons là où ils se sont arrêté et sortons l'épisode 05. Les épisodes 01 à 04 sont aussi disponibles sur le site. Honi Honi ~");
			$news->setCommentId(74);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('potemayo', 'ep5'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kujibiki Unbalance 2 07");
			$news->setTimestamp(strtotime("18 July 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/kuji.jpg[/imgr]
Kujibiki Unbalance est de retour avec l'épisode 7 qui sort aujourd'hui. Il est riche en émotion pour nos héros et particulièrement pour Tokino. Un nouveau personnage apparaît et on découvre des informations sur les personnages. Je vous laisse découvrir tout ça...");
			$news->setCommentId(102);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep7'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kujibiki Unbalance 2 06");
			$news->setTimestamp(strtotime("14 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/kuji6.jpg[/imgr]
Après une longue attente sans Kujibiki, la série continue avec l'épisode 06 (Zéro n'abbandonne jamais !). Merci à Zetsubo Sensei qui prend le relais pour la traduction.

Ce Week-End, Mangazur à Toulon. Une petite convention très sympa ^^ J'y serais, n'hésitez pas à me contacter (zero.fansub@gmail.com). Et venez nombreux pour cet événement.");
			$news->setCommentId(59);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Joyeux Anniversaire ! Zéro a un an aujourd'hui. + Kujibiki Unbalance 05");
			$news->setTimestamp(strtotime("18 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/unan.png[/img]
Zéro fête aujourd'hui son anniversaire ! Cela fait maintenant un an que le site Zéro existe. Crée le 18 décembre 2007, il était au départ un site de DDL. Ce n'est que le 6 janvier que le site deviens une team de fansub ^^ Pour voir les premières versions, allez sur la page 'À propos...'. Merci à tous pour votre soutien, c'est grâce à vous que nous en sommes arrivés là !

Comme petit cadeau d'anniversaire, voici l'épisode 05 de Kujibiki Unbalance, en éspérant qu'il vous plaira.

[b]Les dernières sorties de la [partner]sky-fansub[/partner] :[/b]
Kurozuka 06 HD
Mahou Shoujo Lyrical Nanoha Strikers 18");
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep5'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kujian 4, Recrutement Encodeur, Dons pour le sida");
			$news->setTimestamp(strtotime("01 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/sida.png[/img]
Ciao !
Sortie de Kujibiki Unbalance, l'épisode 04 ! Je tiens à remercier DC, qui, par pitié peut-être ^^, nous a encodé cet épisode.

Oui ! Comme vous l'avez compris, nous recrutons de manière urgente un encodeur !
N'hésitez pas à vous proposer [img=http://img1.xooimage.com/files/s/m/smile-1624.gif]Smile[/img] > [url=index.php?page=recrutement]Lien[/url].

Aujourd'hui, 1er décembre, journée internationale du Sida. Nous vous rappelons que les dons et les clicks sur les pubs sont reversés à l'association medecin du monde. Nous avons besoin de vous !
[url=index.php?page=dons]En savoir plus sur le fonctionnement des dons sur le site[/url]
[url=#]En savoir plus sur l'action de l'association[/url]

Sinon, Man-Ban nous a fait une jolie fanfic que vous pouvez lire dans la partie Scantrad [img=http://img1.xooimage.com/files/s/m/smile-1624.gif]Smile[/img]
Merci à tous et à bientôt !
//[url=http://db0.fr/]db0[/url]");
			$news->setCommentId(16);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kujibiki', 'ep4'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Fin de la série Sketchbook ~full color's~");
			$news->setTimestamp(strtotime("30 June 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/sketchend.jpg[/img]
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
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~ full color's ~ 08");
			$news->setTimestamp(strtotime("15 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/sketch8.png[/img]
V'là déjà la suite de Sketchbook full colors ! L'épisode 08 est disponible, et à peine 2 jours après l'épisode 07 ! Si c'est pas beau, ça ? Allez, détendez-vous un peu en regardant ce joli épisode.
[project=sketchbook]En téléchargement ici ![/project]");
			$news->setCommentId(72);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('sketchbook', 'ep8'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~ full color's ~ 07");
			$news->setTimestamp(strtotime("12 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/sketch7.jpg[/imgr]
On avance un peu dans Sketchbook aussi, épisode 07 aujourd'hui ! Apparition d'un nouveau personnage : une étudiante transferée. Cet épisode est plutôt drôle. [project=sketchbook]Et téléchargeable ici ![/project]");
			$news->setCommentId(72);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('sketchbook', 'ep7'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~full color's~ 06 + 01v2 + 02v2 + 05v2");
			$news->setTimestamp(strtotime("23 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/sketchh.jpg[/imgr]
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
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~full color's 04~ ; Kanaii DDL et Sky-fansub");
			$news->setTimestamp(strtotime("05 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/moka.jpg[/img]
Bouonjòu !
L'épisode 04 de Sketchbook est sorti ! [project=sketchbook]Lien[/project] Les sorties se font attendre, étant donné qu'on a plus vraiment d'encodeur officiel ^^ Merci à Kyon qui nous a encodé c'lui-ci.
Beaucoup nous demandaient où il fallait télécharger nos releases. Probléme réglé, j'ai fait une page qui résume tout. [ext=index.php?page=dl]Lien[/ext]
J'offre aussi du DDL à notre partenaire : la team Kanaii. Allez télécharger leurs animes, ils sont très bons ! [ext=index.php?page=kanaiiddl]Lien[/ext]
Nous avons aussi un nouveau partenaire : La team Sky-fansub. [partner=sky-fansub]Lien[/partner]
//[url=http://db0.fr/]db0[/url]
PS : 'Bouonjòu' c'est du niçois [img=http://img1.xooimage.com/files/s/m/smile-1624.gif]Smile[/img]

Les dernières sorties de la [partner=maboroshi]Maboroshi[/partner] :
- Neo Angelique Abyss 2nd Age 07
- Akane Iro Ni Somaru Saka 07");
			$news->setCommentId(17);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('sketchbook', 'ep4'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sketchbook ~full color's 03~");
			$news->setTimestamp(strtotime("22 November 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Bonjour, bonjour !
Sortie de l'épisode 03 de Sketchbook full color's !
Et c'est tout. Je sais pas quoi dire d'autre. Bonne journée, mes amis. 
//[url=http://db0.fr/]db0[/url]");
			$news->setCommentId(13);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('sketchbook', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan ~ Ni Gakki OAV 02");
			$news->setTimestamp(strtotime("10 May 2009 01:00"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/knjng2.png[/img]
La suite tant attendue des aventures de Rin, Kuro et Mimi ! Un épisode riche en émotion qui se déroule pendant la fête du sport où toutes les trois font de leur mieux pour que leur classe, la CM1-1, remporte la victoire ! Toujours en coproduction avec [url=http://www.maboroshinofansub.fr/]Maboroshi[/url]. Cet épisode a été traduit du Japonais par Sazaju car la vosta se faisait attendre, puis \"améliorée\" par Shana. C'est triste, hein ? Plus qu'un et c'est la fin... [project=kodomo2]Ici, ici ![/project]");
			$news->setCommentId(69);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo2', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan ~ Ni Gakki OAV 01");
			$news->setTimestamp(strtotime("13 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/knjoav1.png[/imgr]
C'est maintenant que la saison 2 de Kodomo no Jikan commence vraiment ! Profitez bien de cette épisode ^^ Toujours en coproduction avec [url=http://maboroshinofansub.fr]Maboroshi no fansub[/url], chez qui vous pourrez télecharger l'épisode en XDCC. Chez nous, c'est comme toujours en DDL. Nous vous rappelons que les torrents sont disponibles peu de temps après, et que tout nos épisodes sont disponibles en Streaming HD sur [url=http://www.anime-ultime.net/part/Site-93]Anime-Ultime[/url].");
			$news->setCommentId(58);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo2', 'ep1'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan ~ Ni Gakki OAV Spécial");
			$news->setTimestamp(strtotime("01 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/nigakki0.jpg[/imgr]
Vous l'attendiez TOUS ! (Si, si, même toi) Il est arrivé ! Le premier OAV de la saison 2 de Kodomo no Jikan. Cet OAV est consacré à Kuro-chan et Shirai-sensei. Amateurs de notre petite goth-loli-neko, vous allez être servis ! Elle est encore plus kawaii que d'habitude ^^ La saison 2 se fait en coproduction avec [url=http://maboroshinofansub.fr]Maboroshi[/url] et avec l'aide du grand (ô grand) DC.");
			$news->setCommentId(55);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo2', 'ep0'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 24 + 25 - FIN");
			$news->setTimestamp(strtotime("29 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[url=images/news/torafin.jpg][img]images/news/min_torafin.jpg[/img][/url]

C'est ainsi que se termine Toradora! ...");
			$news->setCommentId(53);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep24'));
			$news->addReleasing(Release::getRelease('toradora', 'ep25'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 23");
			$news->setTimestamp(strtotime("27 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/tora23.png[/imgr]
La suite de Toradora! avec l'épisode 23. Toujours aussi émouvant, toujours aussi kawaii, toujours aussi Taiga-Ami-Minorin-Ryyuji-ect, toujours aussi dispo sur [url=http://toradora.fr]Toradora.fr![/url], toujours aussi en copro avec [partner=maboroshi]Maboroshi[/partner], toujours en DDL sur notre site [project=toradora]\"Lien\"[/project], Bref, toujours aussi génial ! Enjoy ^^

Discutons un peu (dans les commentaires) ^^
Que penses-tu des Maid ? Tu es fanatique, fétichiste, amateur ou indifférent ?");
			$news->setCommentId(52);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep23'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 22");
			$news->setTimestamp(strtotime("25 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/taiiga.jpg[/imgr]
Que d'émotion, que d'émotion ! La suite de Toradora!, l'épisode 22. Nous vous rappelons que vous pouvez aussi télécharger les épisodes et en savoir plus sur la série sur [url=http://toradora.fr/]Toradora.fr![/url]. Sinon, les épisodes sont toujours téléchargeables chez [partner=maboroshi]Maboroshi[/partner] en torrent et XDCC et chez nous [project=toradora]par ici en DDL.[/project] Enjoy ^^");
			$news->setCommentId(51);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep22'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 21");
			$news->setTimestamp(strtotime("23 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/ski.jpg[/img]

Toradora! encore et encore, et bientôt, la fin de la série. Cet épisode est encore une fois bourré d'émotion et de rebondissements... Et de luge, et de neige, et de skis ! [project=toradora]C'est par ici que ça se télécharge ![/project]

Profitions-en pour discutailler ! Alors, toi, lecteur de news de Zéro... Tu es parti en vacances, faire du ski ? Raconte-nous tout ça dans les commentaires ;)");
			$news->setCommentId(50);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep21'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 19");
			$news->setTimestamp(strtotime("16 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/taigahand.jpg[/img]
Après une semaine d'absence (je passais mon Bac Blanc >.< ), nous reprenons notre travail. Ou plutôt, notre partenaire [partner=maboroshi]Maboroshi[/partner] nous fait reprendre le travail ^^ Sortie de l'épisode 19 de toradora, avec notre petite Taiga toute kawaii autant sur l'image de cette news que dans l'épisode ! Comme d'hab, DDL sur le site, Torrent bientôt (Merci à Khorx), XDCC bientôt et déjà dispo chez [partner=maboroshi]Maboroshi[/partner]. [project=toradora]\"Ze veux l'épisodeuh !\"[/project].");
			$news->setCommentId(46);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep19'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 18");
			$news->setTimestamp(strtotime("05 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/noeltora.jpg[/imgr]
Serait-ce le rythme \"une sortie / un jour\" qui nous prend, à Zéro et [partner=maboroshi]Maboroshi[/partner] ? Peut-être, peut-être... En tout cas, voici la suite de Toradora!, l'épisode 18 ! [project=toradora]Je DL tisouite ![/project]");
			$news->setCommentId(43);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep18'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 16");
			$news->setTimestamp(strtotime("25 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/blond.jpg[/imgr]
Toradora!, pour changer, en copro avec [url=http://japanslash.free.fr/]Maboroshi no Fansub[/url]. Un épisode plein d'émotion, de tendresse et de violence à la fois. À ne pas manquer ! [project=toradora]L'épisode en DDL, c'est par ici ![/project]");
			$news->setCommentId(39);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep16'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 15 et Chibi JE Sud");
			$news->setTimestamp(strtotime("20 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/chibi.jpg[/img]
En pleine chibi Japan Expo Sud, Toradora! continue avec ce soir l'épisode 15 !
[project=toradora]L'épisode en DDL, c'est par ici ![/project]
Rejoignez nous pour cet évenement : 
Chibi Japan Expo à Marseille ! J'y serais, Kanaii y sera. Nous serions ravis de vous rencontrer, alors n'hésitez pas à me mailer (Zero.fansub@gmail.com).

Dernières sortie de nos partenaires :
Kyoutsu : Minami-ke Okawari 02 et Ikkitousen OAV 04
Kanaii : Kamen no Maid Guy 08
Sky-fansub : Kurozuka 09 et Mahou Shoujo Lyrical Nanoha Strikers 25");
			$news->setCommentId(41);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('toradora', 'ep15'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 12-13-14");
			$news->setTimestamp(strtotime("17 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/dentifrice.jpg[/img]
 db0 s'excuse pour sa news ultra-courte de la dernière fois pour Maria Holic 3 et en compensasion va raconter sa vie dans celle-ci (Non, pas ça !). C'est aujourd'hui et pour la première fois chez Zéro une triple sortie ! Les épisodes 12, 13 et 14 de Toradora! sont disponibles, toujours en copro avec [url=http://japanslash.free.fr/]Maboroshi[/url].
 [project=toradora]Les épisodes en DDL, c'est par ici ![/project]

 J'en profite aussi pour vous préciser que les 2 autres versions de Maria 03 sont sorties.
 Mais surtout, je vous sollicite pour une IRL :
 Chibi Japan Expo à Marseille ! J'y serais, Kanaii y sera. Nous serions ravis de vous rencontrer, alors n'hésitez pas à me mailer (Zero.fansub@gmail.com).");
			$news->setCommentId(40);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('toradora', 'ep12'));
			$news->addReleasing(Release::getRelease('toradora', 'ep13'));
			$news->addReleasing(Release::getRelease('toradora', 'ep14'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 11");
			$news->setTimestamp(strtotime("11 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]http://japanslash.free.fr/images/news/toradora11.jpg[/img] 
 La suite, la suite ! Toradora! épisode 11 sortie, en copro avec [url=http://japanslash.free.fr/]Maboroshi no Fansub[/url].


[project=toradora]L'épisode en DDL, c'est par ici ![/project]");
			$news->setCommentId(39);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep11'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 10");
			$news->setTimestamp(strtotime("10 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/ami.png[/img]
En direct de Nice, et pour ce 10 Février, l'épisode 10 de Toradora! en co-production avec [url=http://japanslash.free.fr/]Maboroshi no Fansub[/url], qui est de retour, comme vous l'avez vu ! (Avec Kannagi 01, Mermaid 11-12-13 et Kimi Ga 4). Pour Toradora!, nous allons rattraper notre retard !


[project=toradora]L'épisode en DDL, c'est par ici ![/project]");
			$news->setCommentId(39);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep10'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 09");
			$news->setTimestamp(strtotime("04 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/tora.jpg[/img]
L'épisode 09 de Toradora! est terminé ! Nous avons pris du retard car la MNF (en co-production) est actuellement en pause temporaire (Tohru n'a plus internet).
[project=toradora]Pour télécharger les épisodes en DDL, cliquez ici ![/project]

[b]Les dernières sorties de la [partner]sky-fansub[/partner] :[/b]
Kurozuka 07
Mahou Shoujo Lyrical Nanoha Strikers 20

[b]Les dernières sorties de la [partner]kyoutsu[/partner] :[/b]
Hyakko 05

[b]Les dernières sorties de la [partner]kanaii[/partner] :[/b]
Kamen no maid Guy 06
Rosario+Vampire Capu2 06");
			$news->setCommentId(31);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! 07");
			$news->setTimestamp(strtotime("24 November 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/toradora.png[/img]
Ohayo mina !
La suite de Toradora est arrivée ! Et toujours en co-production avec la Maboroshi  [img=http://img1.xooimage.com/files/s/m/smile-1624.gif]Smile[/img] 
Cet épisode se déroule à la piscine, et 'Y'a du pelotage dans l'air !' Je n'en dirais pas plus.
L'épisode est sorti en DDL en format avi, en XDCC. Comme toujours, il sortira un peu plus tard en H264, torrent, streaming, ect.
//[url=http://db0.fr/]db0[/url]");
			$news->setCommentId(14);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('toradora', 'ep7'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Nouveau XDCC, Radio, Scantrad et Toradora! 06");
			$news->setTimestamp(strtotime("20 November 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/img_shinobu.gif[/img]
Bonjour tout le monde !
J'ai aujourd'hui plusieurs bonnes nouvelles à vous annoncer :
La V3 avance bien, et je viens de mettre à jour les pages pour le scantrad, car comme vous le savez, nous commençons grâce à François et notre nouvelle recrue Merry-Aime notre premier projet scantrad : Kodomo no Jikan.
J'ai aussi installée la radio tant attendue et mis sur le site quelques OST.
Nous avons aussi, grâce à Ryocu, un nouveau XDCC. Vous aviez sans doute remarquer que nous ne pouvions pas mettre à jour le précédent. Celui-ci sera mis à jour à chaque nouvelle sortie.
Et enfin, notre dernière sortie : Toradora! 06. Toujours en co-production avec [url=http://japanslash.free.fr/]Maboroshi[/url].
Enjoy  [img=http://img1.xooimage.com/files/w/i/wink-1627.gif]Wink[/img]
//[url=http://db0.fr/]db0[/url]");
			$news->setCommentId(7);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('toradora', 'ep6'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan 12 FIN");
			$news->setTimestamp(strtotime("06 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/kodomo12fin.png[/img]
C'est ainsi, en ce 6 mars 2009, que nous fêtons à la fois l'anniversaire de la première release de Zéro (Kodomo no Jikan OAV) et l'achevement de notre première série de 12 épisodes. L'épisode 12 de Kodomo no Jikan sort aujourd'hui pour clore les aventures de nos 3 petites héroïnes : Rin, Mimi et Kuro. Il est dispo en DDL sur [url=http://kojikan.fr]le site Kojikan.fr[/url]. Un pack des 12 épisodes sera bientôt disponible en torrent.
[url=http://kojikan.fr/?page=saison1-dl_1]Télécharger en DDL ![/url]");
			$news->setCommentId(44);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo', 'ep12'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kojikan 10");
			$news->setTimestamp(strtotime("03 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/kodomo10.jpg[/img]
RIIINN est revenue ! Elle nous apporte son dixième épisode. Plus que 2 avant la fin, et la saison 2 par la suite. Une petite surprise arrive bientôt, sans doute pour le onzième épisode. En attendant, retrouvez vite notre petite délurée dans la suite de ses aventures et ses tentatives de séduction de Aoki-sensei...");
			$news->setCommentId(37);
			$news->setTeamNews(false);
			$news->addReleasing(Release::getRelease('kodomo', 'ep10'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kodomo no Jikan 09, Recrutement QC, trad it>fr");
			$news->setTimestamp(strtotime("13 December 2008"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/kodomo9.jpg[/img]
Rin, Kuro et Mimi reviennent enfin vous montrer la suite de leurs aventures ! Sortie aujourd'hui de l'épisode 09, merci à DC qui nous l'a encodé. Les 3 versions habituelles sont dispos en DDL.

Nous recrutons toujours un QC ! Proposez-vous !
Nous avons décider de reprendre le projet Mermaid Melody Pichi Pichi Pitch, mais pour cela nous avons besoin d'un traducteur italien > français. N'hésitez pas à postuler si vous êtes intéressés [img=http://img1.xooimage.com/files/s/m/smile-1624.gif]Smile[/img] Par avance, merci. [url=index.php?page=recrutement]Lien[/url]

[b]Les dernières sorties de la [partner]kanaii[/partner] :[/b]
Kanokon pack DVD 06 à 12
Rosario + Vampire S2 -05
[b]Les dernières sorties de la [partner]sky-fansub[/partner] :[/b]
Kurozuka 05 HD
Mahou Shoujo Lyrical Nanoha Strikers 17");
			$news->setCommentId(22);
			$news->setTeamNews(true);
			$news->addReleasing(Release::getRelease('kodomo', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Joyeuses fêtes !");
			$news->setTimestamp(strtotime("26 December 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setMessage("[img=images/news/noel0.jpg]merry christmas ore no imouto[/img]

Une autre année se termine, mais ne vous en faite pas, nous on continue ! Même si on semble être au point mort, ça s'active dans les coulisses. Ne perdez pas espoir, vos commentaires ne sont pas tombés aux oubliettes !

Toute l'équipe de Zéro Fansub vous souhaite de joyeuses fêtes de fin d'année et espère vous retrouver l'année prochaine pour de nouvelles séries ! N'hésitez pas à passer sur le forum pour nous soutenir !


[img=images/news/noel1.jpg]merry christmas ore no imouto[/img]

[img=images/news/noel2.jpg]merry christmas ika musume[/img]

PS : Le projet Canaan est licencié par Kaze. Le dvd de l'integrale est déjà disponible en pré-order !

[img=images/news/dvdcanaan.jpg]DVD canaan buy pre-order kaze[/img]");
			$news->setCommentId(250);
			$news->setTeamNews(true);
			$news->setTwitterTitle("Toute l'equipe Zero fansub vous souhaitent de joyeuses fetes !");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Newsletter");
			$news->setTimestamp(strtotime("30 June 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Pour ceux qui ne seraient pas au courant, 
il est possible de recevoir un mail à chaque fois q'une \"news\" (sorties ou autre) apparait sur le site.
Pour bénéficier de ce service et être les premier au courant, il suffit de vous inscrire sur le forum :
[url=http://forum.zerofansub.net/profile.php?mode=register&agreed=true]S'inscrire ![/url]

[left][list]
[item]Vous n'êtes pas obligés d'être un membre actif du forum pour la recevoir.[/item]
[item]Nous ne divulgons votre adresse e-mail à personne.[/item]
[item]À tout moment, vous pouvez arrêter votre abonnement (lien en bas des newsletter).[/item]
[item]Nous ne vous envoyons rien de plus que nos news : pas de spams, de pubs, etc.[/item]
[/list][/left]

Pour les habitués des flux RSS, vous pouvez aussi suivre nos news :
[url=http://zerofansub.feedxs.com/zero.rss]Flux RSS[/url]

[img=images/news/newsletters.jpg]Newsletter Zéro fansub[/img]");
			$news->setCommentId(235);
			$news->setTeamNews(true);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("L'école du fansub + Mayoi Neko Overrun!");
			$news->setTimestamp(strtotime("22 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img=images/news/ecolelogo.png][/img]

Suite au succès inattendu de la précédente news, nous avons décider d'ouvrir une séction spéciale dans Zéro fansub : L'école du fansub.

[left][b]Le Concept[/b]
Donner les moyens à des personnes motivées mais n'ayant aucune éxpérience en fansub d'entrer dans une équipe en les formant depuis la base.

[b]Comment ça marche ?[/b]
Parce que la pratique vaut mieux que la simple théorie, on vous demandera d'effectuer des exercices et activités concrètes qui seront tout de suite utilisés pour l'équipe. Il y aura des tâches à faire avec des dates de rendus (assez flexibles) et vous ne serez jamais seuls puisqu'une section \"salle des profs\" vous permet de poser toutes les questions que vous voulez aux membres de l'équipe.

[b]Quelles sont les qualités requises ?[/b]
- Être très motivé
- Être disponible
- Être patient
- Avoir envie de découvrir les coulisses du fansub
- Avoir la soif d'apprendre
- Être prêt à effectuer des taches pas très amusantes pour commencer
- N'avoir pas ou peu d'éxpérience en fansub

[b]Comment vais-je évoluer ?[/b]
À chaque exercice rendu, le prof de la matière vous donnera une note basée sur des critères précis avec des bonus et des malus ainsi qu'un commentaire. Vous saurez ainsi apprendre de vos erreurs pour progresser.

[b]Quelles sont les matières enseignées et par qui ?[/b]
Actuellement, nous enseignons dans notre école :
[list]
[item]Utilisation du logiciel Aegisub pour le timing, l'édition, ect - db0[/item]
[item]Apprentissage du langage ASS pour l'édition, le karaoké, ect - db0[/item]
[item]Programmation orientée web, XHTML/CSS/PHP - db0, Sazaju[/item]
[item]Programmation en tout genre - db0, Sazaju[/item]
[item]Cours de langue, Japonais écrit et oral - Sazaju[/item]
[item]Cours de langue, Anglais - TchO, praia[/item]
[item]Français écrit, grammaire orthographe - TchO, praia[/item]
[item]Scantraduction, photoshop & co - db0[/item]
[/list]
Par la suite seront enseignés l'encodage vidéo et l'utilisation du logiciel After Effect pour les effets vidéos.

[b]Comment y entrer ?[/b]
[/left]
Déjà 11 personnes qui ont postulée pour entrer à l'école du fansub, dont 7 qui y sont entrées.
Et vous ?
~ [url=http://forum.zerofansub.net/t981-Comment-entrer-dans-l-ecole-du-fansub.htm]Postuler[/url] ~

À l'occasion de l'ouverture de cette école pas comme les autres, nous commencons une série :
Mayoi Neko Overrun!
qui sera entièrement fansubbée par les élèves de l'école du fansub épaulés par leurs professeurs.

[img=images/news/newsmayoi.jpg][/img]");
			$news->setCommentId(226);
			$news->setTeamNews(true);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement novice");
			$news->setTimestamp(strtotime("19 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img=images/news/newsrecru.png][/img]
Bonjour tout le monde !
Actuellement, nous recherchons quelqu'un qui n'a aucune conaissance ni éxpérience en fansub pour rejoindre nos rangs.
Au départ, pour effectuer des tâches très simples qui nous permettrons d'aller plus vite dans nos sorties, et petit à petit d'apprendre les différents domaines du fansub à nos côtés.
Vous devez pour ça être très motivé, avoir envie de découvrir les coulisses du fansub, être présent et actif parmi nous, avoir la soif d'apprendre et être prêt à faire des tâches pas forcément très amusantes pour commencer.
Fiche à remplir :

[b]Rôle[/b] Novice
[b]Prénom[/b] REMPLIR
[b]Âge[/b] REMPLIR
[b]Lieu[/b] REMPLIR
[b]Motivation[/b] REMPLIR
[b]Expérience fansub[/b] REMPLIR
[b]Expérience hors fansub[/b] REMPLIR
[b]CDI ou CDD (durée) ? [/b] CDI
[b]Disponibilités[/b] REMPLIR
[b]Déjà membres d'autre équipe ?[/b] REMPLIR
[b]Si oui, lesquelles ?[/b] REMPLIR
[b]Connexion internet[/b] REMPLIR
[b]Systéme d'exploitation[/b] REMPLIR
[b]Autre chose à dire ?[/b] REMPLIR");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sondage : Vos séries préférées, les résultats");
			$news->setTimestamp(strtotime("31 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img=images/news/sondageres.png][/img]
Nous vous avons laissé 5 jours pour répondre au sondage et le nombre de participants nous a positivement étonné, étant donné que le nombre de visiteurs est en baisse comparé à l'an dernier.
Vous avez été 24 personnes à participer et à défendre votre série préférée.
Les votes ont été comptabilisés de la manière suivante : Une série en première place vaut 5 points, deuxième 4, troisème 3, quatrième 2 et cinquième 1. Si vous n'avez voté que pour une série, vous lui avez donné 5 points. J'ai vérifié rapidement les adresses IP et il n'y a pas eu d'abérances donc je considère que personne n'a triché.
Sans plus attendre, les résultats :
[project=image]kissxsis[/project]
KissXsis, OAV3 et série avec 51 points. La série bennéficiera donc du mode Toradora! dès sa sortie. Pour ceux qui ne conaissent pas le mode Toradora!, c'est le nom que la team donne aux séries dont les épisodes sortent moins d'une semaine après la vosta.
[project=image]kujibiki[/project]
En seconde place, Kujibiki Unbalance 2 avec 44 points. Pour être honnêtes, nous nous attendions à avoir Kanamemo en seconde place. Ceci nous montre que beaucoup de leechers foncent sur la première sortie d'une série, et si Kujibiki Unbalance avait été fait par une autre team plus rapide, elle n'aurait sûrement pas cette place-là. Déçus, mais nous nous doutions bien que la plupart des gens préférent la rapidité à la qualité.
[project=image]kimikiss[/project]
Kimikiss Pure Rouge, avec 28 points. Ici, c'est l'étonnement inverse. Une série pour laquelle nos épisodes sont tous à refaire dû à leurs médiocrité (des v2 dont prévus pour les épisodes 1 à 6) et terminée chez plusieurs autres teams. Nous sommes dans l'incompréhension, mais ça nous fait plaisir de voir qu'on attends cette série de nous :)
[project=image]kannagi[/project]
Kannagi remporte 27 points. Nous n'avons pas encore sortis d'épisodes pour cette série malgré qu'ils soient presque tous terminés car nous pensions que cette série n'aurait pas beaucoup de succès. Une quatrième place, c'est pas mal, il va falloir qu'on s'y mette.
[project=image]kanamemo[/project]
Kanamemo avec 23 points. Grosse décéption pour une série que nous mettions en priorité sur les autres avant ce sondage. Nous soupçonnons nos fans de préférer nos concurrents pour une série qui reflète pourtant l'état d'esprit de notre équipe.
[project=image]hitohira[/project]
Hitohira avec 17 points. Rien d'étonnant, nous savions que cette série n'avait pas beaucoup de succès.
[project=image]potemayo[/project]
Potemayo avec 9 points. Un tout petit peu déçu mais pas étonnés pour autant. La série est un peu niaise, mais moi je l'aime beaucoup ^^
[project=image]hshiyo[/project]
En bon dernier, Issho ni H shiyo avec 5 points (un seul vote). Et pourtant, les statistiques sont claires, ce sont les hentaïs qui nous rapportent le plus de visiteurs, les épisodes sont beaucoup plus téléchargés en ddl et ce sont les torrents hentaïs qui sont le plus seedés. Au niveau popularité, nous savons que ce sont de loins les hentaïs qui l'emportent, mais nous savons aussi que ce sont les fans de hentaïs qui sont le moins verbeux. Tant pis pour eux ! Nous prendrons en compte les résultats de ce sondage.

Encore merci à tous d'avoir voté ! À bientôt pour les sorties très prochaines de Kujian et Issho ni H shiyo !");
			$news->setCommentId(218);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Sondage : Quelles sont vos séries préférées ?");
			$news->setTimestamp(strtotime("26 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/newssondage.png[/img]
Vous commencez à nous connaître !
Du moins, si vous lisez nos news un peu longues.
Je résume.
L'état d'esprit Zéro est simple : Nous ne faisons pas du fansub pour nous, pour faire plaisir à nous-mêmes, mais pour promouvoir l'animation japonaise, permettre l'accessibilité aus francophones aux séries qu'ils ne peuvent pas trouver (en France), et nous respectons le fameux slogan \"Par des fans, pour des fans.\".
Oui, mes amis !
Ce que l'équipe Zéro fait, du simple sous-titrage à la recherche de qualité, c'est pour vous tous, et uniquement pour vous que nous le faisons.
C'est la raison pour laquelle j'ai décidé aujourd'hui d'effectuer un sondage pour répondre au mieux à vos attentes.
[b]Quelles sont vos séries préférées, parmi celles que nous sous-titrons ? Lesquelles attendez-vous avec le plus d'impatience ?[/b]
Pour y répondre, c'est très simple, il suffit de poster un commentaire avec soit une liste, soit un argumentaire, bref, ce que vous voulez pour défendre vos séries préférées.
À l'issue de ce sondage, nous vous annoncerons les résultats, et les séries les plus attendues seront mises en priorité dans notre travail pour toujours mieux vous satisfaire.
J'éspère que vous serez nombreux à nous donner votre avis !

[project=image]hitohira[/project]

[project=image]kanamemo[/project]

[project=image]kannagi[/project]

[project=image]kimikiss[/project]

[project=image]kissxsis[/project]

[project=image]kujibiki[/project]

[project=image]potemayo[/project]");
			$news->setCommentId(217);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Tracker torrent, le retour ! Recrutement Seeders");
			$news->setTimestamp(strtotime("09 February 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/seedep.png[/img]
Après une très longue pause, notre tracker torrent est de retour ! Tarf a repris les rênes et nos épisodes ne devraient pas tarder à être disponibles en torrent.
Oui, mais pour qu'il marche jusqu'au bout, il nous faut du monde qui soit là, prêt à sacrifier un peu de leur connexion pour partager avec Tarf nos épisodes.
Si vous êtes interessé pour devenir seeder de la team, cliquez sur le lien de postulat ci-dessous. Nous éspérons que vous serez nombreux à nous aider !


~ [url=http://forum.zerofansub.net/posting.php?mode=newtopic&f=21]Postuler en tant que seeder[/url] ~");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Konshinkai fansub, la réunion des amateurs de fansub français");
			$news->setTimestamp(strtotime("17 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Le rendez-vous est fixé pour la prochaine convention : Paris manga.
C'est donc le 6 Février.
On reste sur le même restaurant qu'à Konshinkai 1, un petit restaurant Jap' très sympathique et pas très cher près de Charle de Gaulle étoile. Toutes les infos pour s'y rendre sont sur le site partie \"Rendez-vous\".

Pour ceux qui ne conaissent pas encore Konshinkai, c'est une réunion de fansubbeurs et d'amateurs de fansub français (comme vous êtes sûrement puisque vous êtes chez Zéro fansub ;))

Dans un petit restaurant, nous discutons sans prise de tête et chacun expose ses points de vue dans une ambiance sympathique.

Nous en sommes aujourd'hui à la troisième édition et les membres de Zéro risquent fort d'y être, donc si vous voulez les rencontrer mais aussi discuter ensemble de nos passions communes, nous vous attendons avec impatience !

Venez nombreux, parlez en autours de vous !

[url=http://konshinkai.c.la]Le site officiel Konshinkai fansub, pour plus d'informations


[img=archives/konshinkai/images/interface/konshinkai3.png]Konshinkai fansub[/img][/url]");
			$news->setCommentId(183);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Joyeux Anniversaire ! Zéro a deux ans.");
			$news->setTimestamp(strtotime("18 December 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img=images/news/anniv1.jpg][/img]
Aujourd'hui est un grand jour pour Zéro et pour la db0 company ! Cela fait maintenant exactement deux ans que le groupe Zéro existe, donc j'en profite pour faire un petit résumé de ces deux années riches en evennements.
db0 créer le site \"Zéro\", qui vient de la dernière lettre de son pseudo le 18 décembre 2007. Au départ, c'est un énième site de liens MU et torrent pour télécharger des animes. db0 rencontre ensuite Genesis et se met au fansub. Elle créait ensuite avec et grâce à cette équipe une nouvelle équipe de fansub qui prend la place de l'ancien site Zéro mais garde le design. Les débuts de Zéro sont difficiles. La formation fansub de db0 s'est en grande partie faite par Klick et le reste de l'équipe Genesis. D'autres membres ont ensuite rejoint l'équipe, dont praia qui deviendra par la suite le co-administrateur de l'équipe. Ryocu rejoint ensuite l'équipe en nous hebergant le site et les épisode en DirectDownload. L'équipe s'agrandit petit à petit, devient amie avec Maboroshi, Kanaii, Animekami, Moe, Kyoutsu, Sky, ect. db0 et Ryocu reprennent ensemble la db0 company et tout ses nombreux sites, dont Anime-ultime et Stream-Anime. Ces sites nous coûtent actuellement dans les environs de 300 à 350 par mois, et nous 
avons toujours beaucoup de mal à les financer. Un quatrième \"gros\" site devait ouvrir cet été mais est sans cesse repoussé pour des raisons financières. Stream-Anime a malheuresement fermé ses portes recemment, emportant avec lui ses plus de 5000 vidéos en streaming haute qualité. Malgré ce triste bilan financier, Zéro et la db0 company se porte plutôt bien. Zéro a désormais une équipe soudée et motivée qui ne risque pas de s'arrêter de si tôt. Pour plus d'informations sur la db0 company, un historique complet et détaillé est disponible sur le forum.

Concernant les évennements à venir, un nouveau design de Zéro fansub et d'Anime-Ultime sont prévu. La db0 company devrait bientôt ouvrir un site et regrouper les communautés.

Pour finir, je tenais à remercier toutes les personnes qui nous soutiennent. Financierement bien sûr, mais aussi avec les commentaires qui nous vont droit au coeur et qui nous donnent envie d'avancer. Sachez que Zéro a un état d'esprit qui s'éloigne beaucoup de celui des autres équipes de fansub. Nous ne faisons pas du fansub parce qu'on prend notre pied en sous-titrant des animes (oh oui encore plus de time plan, j'aime ça !), mais parce que nous sommes avant tout fans de l'animation japonaise et c'est avant tout pour vous, les fans comme nous, que nous sous-titrons des animes. C'est la raison pour laquelle nous sommes toujours à l'écoute de nos fans adorés, que nous tenons énormément compte des commentaires sur le site qui nous guident sur ce que nous fansubbons en priorité. C'est grâce à vous et surtout pour vous que nous existons. Votre soutien nous fait vivre et nous donne envie d'aller plus loin. Merci.

Et Bon Anniversaire Zéro ! 

[img=images/news/anniv2.jpg][/img]");
			$news->setCommentId(155);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement Editeur ASS/AE");
			$news->setTimestamp(strtotime("10 December 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img=images/news/edit.jpg][/img]
J'ai toujours tenu depuis la création de l'équipe Zéro à m'occuper personnellement des edits des épisodes. On peut d'ailleurs voir l'évolution de mon niveau au fur et à mesure des épisodes :)  Cependant, aujourd'hui, Zéro connaît un réel ralentissement et j'en prend l'entière résponsabilité : ayant commencé mes études supérieures, j'ai bien moins de temps que ce que j'en avais à l'époque où j'étais lycéenne. J'ai donc décidé, avec certes quelques regrets, d'intégrer un nouveau membre dans l'équipe pour faire les edits à ma place.

Nous recrutons donc un [b]éditeur ASS ou After Effect[/b] si possible expérimenté, ayant un minimum de capacités et de motivation. Si vous êtes interessés, postez un topic dans la partie recrutement du forum avec la fiche de renseignement suivante :
[b]Rôle[/b] REMPLIR
[b]Prénom[/b] REMPLIR
[b]Âge[/b] REMPLIR
[b]Lieu[/b] REMPLIR
[b]Motivation[/b] REMPLIR
[b]Expérience fansub[/b] REMPLIR
[b]Expérience hors fansub[/b] REMPLIR
[b]CDI ou CDD (durée) ? [/b] REMPLIR
[b]Disponibilités[/b] REMPLIR
[b]Déjà membres d'autre équipe ?[/b] REMPLIR
[b]Si oui, lesquelles ?[/b] REMPLIR
[b]Connexion internet[/b] REMPLIR
[b]Systéme d'exploitation[/b] REMPLIR
[b]Autre chose à dire ?[/b] REMPLIR

Ainsi que le très important test de validation. Le test est le suivant :
Réaliser l'edit du titre de début le plus ressemblant possible au titre de la série, à la différence qu'il ne doit pas y avoir écrit le titre de la série mais \"Zéro fansub\" ou \"Zéro fansub présente\". Ass ou After Effect. Vous pouvez nous envoyer : soit un script, soit une vidéo encodée ET un script. Au choix :
- [url=ddl/RAW_Kanamemo/%5bZero-Raws%5d%20Kanamemo%20-%2001%20RAW%20(TVO%201280x720%20x264%20AAC%20Chap).mp4]Titre Kanamemo, à 01:03:60[/url] (mouvant obligatoire)
- [url=ddl/RAW_KissXsis/Kiss%d7sis_OAD_2_Raw_Travail_ED_non_bobb%e9.avi]Titre KissXsis, à 02:03:12[/url] (immobile ou mouvant)
J'éspère que vous serez nombreux à répondre à notre demande ! Merci à tous de suivre nos épisodes.");
			$news->setCommentId(154);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Konshinkai ~ fansub");
			$news->setTimestamp(strtotime("26 October 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img=images/news/afkonsh.png][/img]
Bonjour cher ami gentils amis leechers.

\"Encore une nouvelle équipe de fansub ?\", vous allez vous dire, avec le titre de la news. Eh bien non ! \"Konshinkai\" signifie en japonais \"Réunion amicale\", et c'est exactement le but de notre projet.

Notre but est de réunir toutes les équipes de fansub française à une petite soirée pour discuter amicalement de notre passion commune : le fansub. Nous invitons donc toutes les personnes travaillant dans le fansub, et pas seulement les chefs d'équipes, toutes les personnes ayant déjà travaillé dans le fansub et les plus grands fans de cette activité à se réunir autours d'une table dans un restaurant japonais pour se rencontrer, échanger, discuter et s'amuser, sans aucune prise de tête.

L'évennement se déroule à Paris, et comme nous savons bien que tout le monde n'est pas apte à se déplacer librement sur Paris, nous avons décidé de le faire pendant les conventions parisiennes sur la jap'anime, puisque c'est à ce moment là que nos chers otaku ont tendance à se déplacer, se dégageant difficilement de leur chaise adorée bien calée devant leurs ordinateurs (je caricature, hein).

Nous comptons renouveler l'évenemment pour plusieurs occasions, ésperant ainsi rencontrer un maximum de personnes ! Ne soyez pas timides, rejoignez-nous, venez nombreux !

[b]Prochaine rencontre : Samedi 30 octobre à 20h, pendant la Chibi Japan Expo. Venez nombreux ! Plus d'informations sur notre site : [url=http://konshinkai.c.la/]Konshinkai Site Officiel[/url][/b]
[separator]
L'équipe Konshinkai fansub, réunions amicales entre fansubbeurs français.

P.S. : Nous vous serions très reconaissant de faire part de cette évenement autours de vous, aux membres de votre équipes, aux autres équipes, à vos amis fansubbeurs et pourquoi pas faire une news sur votre site officiel.");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Paris Manga");
			$news->setTimestamp(strtotime("01 September 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/parismanga.jpg[/img]
Paris Manga est une petite convention se déroulant à Paris (logique) le 12 et 13 septembre à l'espace Champerret. Zéro y sera ! Donc n'hésitez pas à venir nous voir, on est gentil et on mord pas ^^ Et comme d'habitude, je participe aux concours cosplay. Venez m'encourager samedi à partir de 14h sur scéne en cosplay individuel et dimanche à partir de 14h en cosplay groupe avec un costume spécial Zéro fansub !

L'équipe de fansub n'est actuellement pas en mesure de vous proposer des sorties d'animes : L'encodeur Lepims est en vacances et dieu (db0) déménage.");
			$news->setCommentId(119);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement traducteur Mermaid Melody");
			$news->setTimestamp(strtotime("10 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/mermaid.jpg[/img]
Nous avons été très étonné du succés qu'a eu notre demande de recrutement pour l'anime Hitohira et nous avons aujourd'hui un nouveau traducteur pour cette série : whatake.
Aurons-nous autant de succés pour ce deuxième appel...? Je l'espère ! Mais avant cela, je vous vous expliquer la situation. Nous avons commencé la série Mermaid Melody Pichi Pichi Pitch en Vistfr et MnF l'a fait en Vostfr. Nous avons décidé d'abbandonner la série en Vistfr et de la continuer en Vostfr. 13 épisodes de cette série sont sortis. Vous pouvez télécharger l'épisode 01 ici : [url=http://www.megaupload.com/?d=ZZQNU3UZ]Episode 01[/url]
Nous recherchons quelqu'un de motivé qui aime les animes magical girl pour continuer cette série avec nous ! N'hésitez pas à postuler ! Merci de votre aide.");
			$news->setCommentId(111);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Infos Téléchargements");
			$news->setTimestamp(strtotime("09 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Depuis un incident de surcharge de téléchargements ayant fait planter toute la db0 company (anime-ultime, Zéro et tout les autres), nous avons décidé de limiter les téléchargements. Nous avons annoncé ça clairement, et pourtant, nous continuons à recevoir dans le topics des liens morts qui ne le sont pas. Donc aujourd'hui, j'insiste : Si vous êtes déjà en train de télécharger un épisode sur notre site, vous ne pourrez en telecharger un autre qu'après le premier téléchargement terminé ! Si le message suivant arrive :

\"Service Temporarily Unavailable
The server is temporarily unable to service your request due to maintenance downtime or capacity problems. Please try again later.\"

Ne vous affolez pas : Attendez la fin de votre premier téléchargement. Il peut arriver que ce message arrive alors que vous n'êtes pas en train de télécharger. Dans ce cas, attendez 30 secondes puis actualisez la page à nouveau, et ceci jusqu'à ce que votre téléchargement se lance. Merci à tous !");
			$news->setCommentId(110);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[IRL] Japan Expo 2009");
			$news->setTimestamp(strtotime("15 June 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-auto=images/news/japan10.jpg][/img-auto]
Vous y allez ? Ça tombe bien, nous aussi !
Pour s'y rencontrer, signalez-vous dans le topic dédié à cette convention sur le forum : [url]http://forum.zerofansub.net/t196-japan-expo-2009.htm[/url]
Il y aura comme toujours la petite bande de chez Kanaii en plus de celle de chez Zéro.
J'ai prévu plusieurs concours cosplay :
Cosplay Standart Jeudi 13h (Kodomo no Jikan)
WCS Pré-selection Samedi 13h concours 15h (Surprise)
Pen of Chaos Dimanche 13h (Dokuro-chan)
Venez m'y voir ^^ Si vous voulez :)

Rappel : La team est toujours en pause jusqu'à Juillet !");
			$news->setCommentId(96);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[IRL] Epitanime 2009");
			$news->setTimestamp(strtotime("06 June 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("C'était du 29 au 31 mai, et c'était un très grand evenement. Bien malheureux sont ceux qui l'ont ratés ! Et qui, surtout, on raté db-chan ! Oui, il faut le dire, le plus important à Epitanime, c'était elle :P Il fallait être là, car j'avais prévu pour tout les membres de la team Zéro mais aussi toutes les personnes qui viennent régulierement chez Zéro une petite surprise.
Ce week-end, j'ai donc croisé Sazaju (notre traducteur), Ryocu, Guguganmo et des tas de copains-cosplayeurs dont je ne vous citerait pas le nom puisque vous ne les connaîtrez sûrement pas.

J'ai participé au concours cosplay le samedi 30 mai à 12 heure. À vous de deviner quel personnage j'incarnait :
[img=images/news/cosplay01.jpg][/img]
Vous ne trouvez pas ? Oui, je sais, c'est très difficile. Pour voir qui c'était, lisez la suite.

[url=index.php?page=dossier&id=epitanime2009][img=images/interface/lirelasuite.png][ Lire la suite . . . ][/img][/url]");
			$news->setCommentId(79);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Epitanime 2009");
			$news->setTimestamp(strtotime("19 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-auto]http://www.epita.fr/img/design/logos/epitanime-logo.jpg[/img-auto]
Date à retenir : 29-30-31 mai 2009 ! Durant ses trois jours se dérouleront un évenement de taille : la 17éme édition de l'Epitanime ! Une des meilleures conventions et des plus vieilles. Plus pratique pour les parisiens puisqu'elle se déroule au Kremlin-Bicêtre (Porte d'Italie). Si vous avez la possibilité de vous y rendre, faites-le ! db-chan vous y attendra ^^");
			$news->setCommentId(525);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("forum.zerofansub.net");
			$news->setTimestamp(strtotime("18 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-right]images/news/favoris.png[/img-right]
Le forum change d'adresse : 
[size=22px][url]http://forum.zerofansub.net[/url][/size]
Faites comme Mario, mettez à jour vos favoris !");
			$news->setCommentId(588);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("The legend of Melba : Tonight Princess + Newsletter");
			$news->setTimestamp(strtotime("17 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[url=http://melbaland.free.fr/][img=http://img8.imageshack.us/img8/6162/bannirepapyo.jpg][/img][/url]
Papy Al, QC de la petite équipe, a sorti hier soir le premier épisode de sa saga mp3. [url=http://melbaland.free.fr/]Pour l'écouter, c'est par ici ![/url]

Vous ne le savez peut-être pas, mais Zéro envoie à chaque news une newsletter ! Pour la recevoir, il suffit de s'inscrire sur le forum. Il n'est pas demandé de participer ni quoi que ce soit.");
			$news->setCommentId(73);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[Zero] Merci !");
			$news->setTimestamp(strtotime("11 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img=images/news/merci.jpg][/img]
Toute l'équipe Zéro fansub et toute la db0 company (Anime-Ultime, Stream-Anime, Zéro, Kojikan, ect) tient à remercier chalereusement les personnes suivantes pour leurs réponses à notre appel à l'aide :
Hervé (14)
Nicolas (10)
Guillaume (5)
Fabrice (20)
Luc (10)
Julien (40)
Bkdenice (15)
Pascal (10)
Mathieu (25)
Ces sommes ne nous permettent certes pas de nous sortir de nos problèmes d'argent actuels, mais nous aident énormément à remonter peu à peu la pente ! Nous reprenons du courage et la force de continuer à tenir en forme les sites de la db0 company. Encore une fois, merci.
//Ryocu et db0");
			$news->setCommentId(71);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("C'est la crise !");
			$news->setTimestamp(strtotime("01 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("C'est la crise pour tout le monde, et même pour nous. Nous n'arrivons plus à payer nos serveurs... On ajoute des publicités et on vous sollicite pour des dons, mais rien ne s'améliore. Depuis le début de Zéro, et sur tout les sites de la db0 company, nous n'avons reçu que 14  de dons et 75  de publicités. Sachant qu'il nous a fallut environ 80  (en tout depuis que Zéro existe) pour l'association humanitaire que Zéro soutient et que nos serveurs de la db0 company coûte environ 250  /mois, le calcul n'est pas long, nous sommes dans le négatif. Et pauvres petits étudiants que nous sommes, à découvert tout les mois... C'est un appel à l'aide que je lance aujourd'hui, à ceux de Zéro, de la db0 company, à ceux qui aiment les animes que nous sous-titrons et qui respectent notre travail. Par avance, merci.");
			$news->setCommentId(66);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[Zero]");
			$news->setTimestamp(strtotime("10 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-right=images/news/3.1.png][/img-right]
Du changement sur le site ?

Je ne vois vraiment pas de quoi vous parlez !");
			$news->setCommentId(57);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! Licencié");
			$news->setTimestamp(strtotime("01 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-right=images/news/licence.jpg][/img-right]
Triste nouvelle que je vous apporte aujourd'hui ! La première licence d'une de nos série. Avec beaucoup de regrets, nous retirons donc tout les liens de téléchargement de la série Toradora!...");
			$news->setCommentId(54);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! Fin - L'impact !");
			$news->setTimestamp(strtotime("30 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-right=images/news/ryoc.jpg][/img-right]
Bonjour.
Je suis l'administrateur du site [url=http://www.anime-ultime.net/part/Site-93]Anime-ultime[/url], et l'admin sys de Zéro fansub ainsi que toute la [url=http://db0.fr]db0 company[/url]. Je tiens à remercier les personnes qui se sont crues malignes en employant des accélérateurs de téléchargement. Grâce à ces personnes, plusieurs sites ont été inaccessibles. En utilisant ce genre de logiciel, vous bloquez les accès aux visiteurs des sites web et vous entraînez un ralentissement général des téléchargements (au lieu des les accélerer, vous faites en sorte que les disques durs ne puissent plus tenir la cadence et font ralentir tout le monde). Par conséquent, vous ne pouvez désormais plus télécharger qu'un seul et unique fichier à la fois sur Zerofansub.net et je demande à toutes les personnes qui utilisent des accélerateurs de téléchargement d'arrêter de vous servir de ce genre de logiciel qui plombent les serveurs inutilement en plus d'avoir l'effet contraire à celui désiré.
Cette limite n'est pas très sévère, soyez compréhensifs. Profitez bien de la fin de Toradora!, même si pour cela, vous devez attendre un peu. Nos releases sont aussi disponibles en torrent.");
			$news->setCommentId(54);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement Karamaker et Gestion tracker BT");
			$news->setTimestamp(strtotime("24 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img-right=images/news/guilde.jpg][/img-right]
Zéro recrute !

[b]Gestion tracker BT[/b]
Ma connexion actuelle ne me permet pas de télécharger, seeder, gérer notre tracker BT. Nous sommes donc à la recherche de quelqu'un de motivé et disponible ayant une bonne connexion. Son rôle : Télécharger nos épisodes dès leurs sorties, créer le fichier .torrent, se mettre en seed dessus, l'uploader sur le tracker, surveiller les sans source. Nous avons aussi à notre disposition un TorrentFlux en cas de besoin.
Interessé ? Venez vous proposer sur le forum partie Recrutement avec un screen de votre programme de torrent.


[b]Karamaker[/b]
Nous recherchons un karamaker uniquement pour les effets (je m'occupe du kara-time) qui est de l'éxpérience et des idées (à bannir les karaokés par défaut.)
Interessé ? Venez vous proposer sur le forum partie Recrutement avec votre meilleur karaoké.


Venez nombreux ! Nous avons besoin de vous !");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Kouhai Scantrad, les chapitres de KissXsis");
			$news->setTimestamp(strtotime("26 August 2010 00:01"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setCommentId(247);
			$news->setTwitterTitle("Vous conaissez Kouhai Scantrad ? Ils proposent les chapitres de KissXsis ! http://kouhaiscantrad.wordpress.com/");
			$news->setMessage("[partner=image]kouhai[/partner]

Un nouveau partenaire a rejoint la grande famille des amis de Zero : Kouhai Scantrad.
Comme vous le savez, Zero aime vous proposer en plus de vos series preferees tout ce qui tourne autours de celles-ci : Wallpaper, OST, jaquettes DVD et pleins d'autres surprises, mais surtout les mangas d'ou sont tires les series.
C'est pourquoi nous avions fait un partennariat avec l'equipe Ecchi-no-chikara qui vous proposait les chapitres du manga original de KissXsis. Aujourd'hui, cette equipe a fermee, mais heuresement pour vous, fans des deux jumelles, l'equipe Kouhai Scantrad a decide de reprendre le flambeau !
Allez donc visiter leur site pour lire les chapitres et les remercier pour leur travail.");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Samazama no Koto recrute !");
			$news->setTimestamp(strtotime("26 August 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgl=images/news/samazama.jpg]Samazama no Koto recrute finger pointed loli[/imgl]

La fin de l'été arrive à grand pas, et qui dit rentrée dit manque de disponibilités ! C'est ce qui arrive à nos petits potes de chez Samazama no Koto : ils manquent d'effectifs.

C'est pourquoi ils font appel à [b]vous[/b]. Oui, vous, là, qui êtes en train de me lire !

Vous avez plus de 16 ans ? Vous aimez les mangas ecchi/hentais ? Vous avez envie de connaitre le monde qui se cachent derrière la réalisation de ces chapitres alléchants ?

N'attendez plus ! Tentez votre chance pour rejoindre cette talentueuse équipe de Scantrad !

[imgr=images/news/mercidons2.png]Merci Alain pour son don de 20 euros ! Touhou Projet money money[/imgr]
Vous devez être disponible et très motivé. Aucune compétence n'est requise. Les postes disponibles sont : traducteurs, éditeurs, checkeurs, webmasters, designers, xdcc-makers.


Un grand [b]merci[/b] à Alain pour son don de 20 euros qui va nous aider à payer nos serveurs !

A bientot !");
			$news->setCommentId(245);
			$news->setTwitterTitle("Samazama no Koto recrute trad, edit, check, etc http://samazamablog.wordpress.com/");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Licence de Rosario+Vampire");
			$news->setTimestamp(strtotime("04 May 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("La Mite en Pullover"));
			$news->setMessage("[img]images/news/licencerv.jpg[/img]
Black Box a acquis les droits des deux séries, aussi je vous demande de ne plus distribuer, sur n'importe quel réseau ou système de téléchargement que ce soit, nos fansubs. Si la série vous a plu, soutenez l'éditeur en achetant ses DVD (ou allumez un cierge pour d'éventuels Bluray).
J'en appelle à tous les sites partenaires de téléchargement, à tous les blogs sérieux et à ceux de kikoololz : stoppez tout, effacez vos liens, supprimez les épisodes de vos comptes.
Rien ne vous empêche de harceler Black Box pour avoir du boobies en haute définition !
Bon courage à Black Box !");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Nouveau partenaire : Samazama na Koto");
			$news->setTimestamp(strtotime("24 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[partner=samazama][img]images/news/sama1.jpg[/img][/partner]
Un nouveau petit pote partenaire viens s'ajouter aux petits potes de Zéro :
[partner=samazama]Samazama na Koto[/partner] est une équipe de Fanscan, Scantrad aux penchants Ecchi et Hentaï qui nous propose du contenu d'une certaine qualité que nous apprécions.
Allez donc lire quelques-uns de leurs chapitres et revenez nous en dire des nouvelles !
[partner=samazama][img]images/news/sama2.jpg[/img][/partner]");
			$news->setCommentId(227);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Nouveau partenaire : Mangas Arigatou");
			$news->setTimestamp(strtotime("24 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/newsarigatou2.jpg[/img]
Bonjour tout le monde !
Un nouveau partenaire se joint aujourd'hui à l'équipe Zéro :
Mangas Arigatou !
Un très bon état d'esprit, un petit grain de folie et que de sympathie... Que demander de plus ?
Justement, ils vont bien plus loin...
C'est à la fois une équipe de fansub et in distribuants !
Attention, pas n'importe quelle équipe de fansub : une équipe de dramas. Une grande première parmi les partenaires de chez Zéro, mais vous le savez, nous sommes ouverts à toute la jap'culture.
Et pas non plus un banal distribuant qui prend bêtement le premier épisode sortis sans se soucier de prendre différentes équipes... Non, non ! Mangas-Arigatou recherche la qualité et nous a choisi pour la plupart de nos animes (oh arrêtez je vais rougir...). Nos épisodes sont disponibles chez eux pour les séries suivantes :
Canaan
Genshiken 2
Issho ni Training
Kanamemo
KissXsis
Kodomo no  Jikan
Kodomo no Jikan Ni Gakki
Maria+Holic
Potemayo
Sketchbook Full Color's
Tayutama
Toradora
Allz visiter leur site au plus vite !!");
			$news->setCommentId(215);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[MnF] K-On! et Tayutama Kiss on my Deity");
			$news->setTimestamp(strtotime("08 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/tamakon.jpg[/imgr]
Chez Maboroshi, ça ne chôme pas, et on ne vous l'annonce que maintenant, mais mieux vaut tard que jamais. La petite équipe est actuellement sur 2 nouveaux projets : K-on!, où elle en est déjà à l'épisode 05 et Tayutama Kiss on my deity à l'épisode 04. N'attendez plus, et allez mater ces deux exellentes séries : [partner=maboroshi]Le site Maboroshi[/partner].");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[SkY] Lucky Star 03");
			$news->setTimestamp(strtotime("04 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/lucky3.jpg[/imgr]
On vous l'avait promis ! Sky-fansub, c'est du sérieux, et malgré la difficulté de la série, les revoilà déjà avec l'épisode 03... Si c'est pas beau, ça ? Allez, va le télécharger, mon petit otaku : [partner=sky-fansub]Le site Sky-fansub[/partner].");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Konoe no Jikan 02 + [SkY] Lucky Star 02");
			$news->setTimestamp(strtotime("15 April 2009 00:30"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/lucky2.jpg[/imgr]
Sky-Anime nous apporte comme promis les aventures déjantés de Konata et ses amies. L'épisode 02 est déjà disponible sur leur site.

Côté hentaï, l'épisode 02 de Konoe no Jikan (parodie X de Kodomo no jikan).");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(true);
			$news->addReleasing(Release::getRelease('konoe', 'ep2'));
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[SkY] Lucky Star !");
			$news->setTimestamp(strtotime("07 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[imgr]images/news/lucky.png[/imgr]
Notre très proche partenaire Sky-fansub commence une nouvelle série, et pas une petite série, attention... Lucky Star ! C'est sûr, c'est pas récent comme anime, mais malheuresement, niveau fansub, c'est pas au top (Aucune team n'est arrivé au bout de la série). La différence, c'est que cette team-là, mes amis, n'a rien à voir avec les autres ! En plus de nous faire de la qualité, elle est sérieuse et assidue. Que demandez de plus ? Profitez déjà du premier épisode ^o^

[partner=sky-fansub]Sky-fansub, c'est par là ![/partner]");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[KfS] Minami-ke Okawari");
			$news->setTimestamp(strtotime("13 January 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img=images/news/kyoutsu.jpg][/img]
Notre partenaire-dakkô Kyoutsu commence une nouvelle série... Minami-ke Okawari ! Vous pouvez dès maintenant télécharger l'épisode 01 en DDL :
[url=ddl/kyoutsu/%5bKfS%5d1280x720_Minami-Ke_Okawari_001_vostfr.mkv]DDL Minami-ke Okawari 01[/url]
Mais aussi en torrent, Megaupload sur leur site : [partner=kyoutsu]Lien[/partner].");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[MnF] Akane 08");
			$news->setTimestamp(strtotime("12 January 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[url=http://ranka.imouto.org/image/85ba4e0864c9ee58520eee540d4cebcb/moe%2053546%20bikini%20cleavage%20katagiri_yuuhi%20kiryu_tsukasa%20nagase_minato%20nekomimi%20no_bra%20open_shirt%20pantsu%20seifuku%20shiina_mitsuki%20shiraishi_nagomi%20swimsuits.jpg][img]http://japanslash.free.fr/images/news/akane8.jpg[/img][/url]
Maboroshi nous sort aujourd'hui l'épisode 08 de Akane !
Contrairement à ce qui a été dit, cet épisode n'a pas été réalisé en co-pro avec Zéro.
[partner=maboroshi]Pour télécharger l'épisode sur MU, cliquez ici ![/partner]");
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("db0 vs Flander's Company");
			$news->setTimestamp(strtotime("20 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[url=http://www.cosplay.com/photo/2277002/][img]http://images.cosplay.com/thumbs/22/2277002.jpg[/img] [/url][url=http://www.cosplay.com/photo/2277008/][img]http://images.cosplay.com/thumbs/22/2277008.jpg[/img][/url] [url=http://www.cosplay.com/photo/2277009/][img]http://images.cosplay.com/thumbs/22/2277009.jpg[/img][/url] [url=http://www.cosplay.com/photo/2277010/][img]http://images.cosplay.com/thumbs/22/2277010.jpg[/img][/url] [url=http://www.cosplay.com/photo/2277011/][img]http://images.cosplay.com/thumbs/22/2277011.jpg[/img][/url] [url=http://www.cosplay.com/photo/2277012/][img]http://images.cosplay.com/thumbs/22/2277012.jpg[/img][/url] [url=http://www.cosplay.com/photo/2277013/][img]http://images.cosplay.com/thumbs/22/2277013.jpg[/img][/url] [url=http://www.cosplay.com/photo/2277014/][img]http://images.cosplay.com/thumbs/22/2277014.jpg[/img][/url] [url=http://www.cosplay.com/photo/2277015/][img]http://images.cosplay.com/thumbs/22/2277015.jpg[/img][/url] [url=http://www.cosplay.com/
photo/2277016/][img]http://images.cosplay.com/thumbs/22/2277016.jpg[/img][/url] [url=http://www.cosplay.com/photo/2277017/][img]http://images.cosplay.com/thumbs/22/2277017.jpg[/img][/url] 

Eh non, vous ne rêvez pas, j'ai bel et bien affronté la Flander's Company !
La Flander's Company, qu'est-ce que c'est ? Ce n'est pas un rival de la db0 company, mais une société qui recrute des supers vilains pour que les supers hérios aient des défouloirs et surtout des raisons d'exister.
J'ai fait appel aux services de la Flander's pour que mes petits camarades, le blond-boulet et le brun-tenebreux, et moi, l'hystérique-raleuse au cheveux roses (...?) ayons un super vilain à combattre.

Vous l'aurez compris, j'incarne donc Sakura de la mondialement connue série Naruto dans cet épisode 3, saison 3 de la Flander's Company.
Je vous laisse juger de notre performence au combat :P

[video=width:480|height:272]http://www.dailymotion.com/swf/xbgkly&related=0[/video]");
			$news->setCommentId(186);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("C'est la crise !");
			$news->setTimestamp(strtotime("01 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("C'est la crise pour tout le monde, et même pour nous. Nous n'arrivons plus à payer nos serveurs... On ajoute des publicités et on vous sollicite pour des dons, mais rien ne s'améliore. Depuis le début de Zéro, et sur tout les sites de la db0 company, nous n'avons reçu que 14  de dons et 75  de publicités. Sachant qu'il nous a fallut environ 80  (en tout depuis que Zéro existe) pour l'association humanitaire que Zéro soutient et que nos serveurs de la db0 company coûte environ 250  /mois, le calcul n'est pas long, nous sommes dans le négatif. Et pauvres petits étudiants que nous sommes, à découvert tout les mois... C'est un appel à l'aide que je lance aujourd'hui, à ceux de Zéro, de la db0 company, à ceux qui aiment les animes que nous sous-titrons et qui respectent notre travail. Par avance, merci.");
			$news->setCommentId(66);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Stream-Anime.org");
			$news->setTimestamp(strtotime("15 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Pour les fans d'animes trop pressés ou qui préférent les VOSTA'z, Ryocu, hébergeur de Zéro fansub et fondateur d'[url=http://www.anime-ultime.net/part/Site-93]anime-ultime[/url], avec ma petite participation, a créer [url=http://www.stream-anime.org/]Stream-Anime.org[/url] ! Ce site propose toutes les dernières sorties d'animes en VOSTA en streaming de très haute qualité. Actuellement, vous pouvez visionner plus de 5000 vidéos, et c'est loin d'être fini. Bientôt, le site proposera les sous-titres dans toutes les langues.
[url=http://www.stream-anime.org/][img]images/news/stream.png[/img][/url]
Malheuresement, tout ceci n'est pas gratuit. Une petite aide par des dons, clicks sur les pubs ou allopass sur anime-ultime sont les bienvenus. Vos commentaires aussi, sur cette news, pour améliorer le site.");
			$news->setCommentId(45);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora.fr!");
			$news->setTimestamp(strtotime("26 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[url=http://toradora.fr][img=http://toradora.fr/images/partenaires/ban1.png]toradora.fr[/img][/url]
Après Kojikan.fr, ouvrez grand vos bras au nouveau site de la db0 company : Toradora.fr !");
			$news->setCommentId(42);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[Kojikan.fr] Ouverture du site Kodomo no Jikan France ! + épisode 11");
			$news->setTimestamp(strtotime("13 February 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[url=http://kojikan.fr/][img]http://zerofansub.net/images/news/kojikanfrance.png[/img][/url]
Pour la sortie de l'épisode 11 de Kodomo no Jikan, comme promis, la petite surprise ! Quoi de mieux qu'un vendredi 13 pour l'ouverture du site officiel français Kodomo no Jikan ?


[url=http://kojikan.fr/]Le site officiel Kodomo no Jikan France, c'est par ici ![/url]");
			$news->setCommentId(36);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(true);
			$news->addReleasing(Release::getRelease('kodomo', 'ep11'));
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("The db0 company");
			$news->setTimestamp(strtotime("28 January 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("Rien de bien important, pas de nouvelle sortie (désolée), juste un nouveau petit site à moi. [url=http://db0.fr/]db0.fr[/url] existe depuis longtemps, je viens juste de le remettre en forme, et maintenant c'est une version très simple qui présente simplement mes petits travaux. J'éspère qu'il vous plaira, n'hésitez pas à donner votre avis. [img=http://img1.xooimage.com/files/w/i/wink-1627.gif]Wink[/img]

[url=http://db0.fr/][img]db0/images/interface/logo.png[/img][/url]");
			$news->setCommentId(35);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(true);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Jaquettes DVD");
			$news->setTimestamp(strtotime("20 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/cover/%5BZero%5DKanamemo_Cover.png[/img]
Des bonus, encore des bonus !
Sur le site AnimeCoversFan, je suis allée chercher pour vous les covers et labels de nos séries.
Elles sont téléchargeables sur la page des séries partie Bonus.
- Canaan
- Kanamemo
- Kannagi
- KissXsis
- Kujibiki Unbalance 2
- Kodomo no Jikan
- Tayutama ~Kiss on my Deity~
- Toradora!
Faites-vous de jolis DVD ! Mais ne les gardez pas lorsque la série est licenciée et achetez les vrais DVDs.
[img]images/cover/%5BZero%5DKissXsis_Cover.png[/img]");
			$news->setCommentId(213);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Bonne année 2010 !");
			$news->setTimestamp(strtotime("01 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"));
			$news->setMessage("[img]images/news/sazanne.jpg[/img]
[img]images/news/finalanne.jpg[/img]
[spoiler][img=images/interface/lirelasuite.png]Lire la suite ...[/img]
[img=images/news/annee1.jpg]Bonne année 2010[/img]
[img=images/news/annee2.jpg]Bonne année 2010[/img]
[img=images/news/annee3.jpg]Bonne année 2010[/img]
[img=images/news/annee4.jpg]Bonne année 2010[/img]
[img=images/news/annee5.jpg]Bonne année 2010[/img]
[img=images/news/annee6.jpg]Bonne année 2010[/img]
[img=images/news/annee7.jpg]Bonne année 2010[/img]
[img=images/news/annee8.jpg]Bonne année 2010[/img]
[img=images/news/annee9.jpg]Bonne année 2010[/img]
[img=images/news/annee10.jpg]Bonne année 2010[/img]
[img=images/news/annee11.jpg]Bonne année 2010[/img]
[/spoiler]");
			$news->setCommentId(157);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Joyeux Noël ! Zéro vous offre pleins de cadeaux");
			$news->setTimestamp(strtotime("25 December 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/zeronoel09.jpg[/img]
C'est Noël ! Et au nom de toute l'équipe Zéro fansub et de la db0 company je vous souhaite à tous un joyeux noël, de bonnes fêtes et de passer de bos moments auprès de vos proches. Cette année, vous avez télécharger les animes ecchi-ecchi de chez Zéro, donc vous avez été très coquin et Papa Noël le sais, donc il a demandé à l'équipe Zéro de vous offrir ce petit cadeau :

[url=ddl/%5BZero%5DLa_selection_de_Noel_2009.zip][b]150 images ecchi de Noël ![/b][/url]

Téléchargez donc vite ce pack d'images de tout thèmes : ecchi, loli, kawaii, il y en a pour tout les goûts. Cependant, il y a aussi quelques images hentaï soft, je recommande donc aux moins de 14 ans de ne pas télécharger ces images.
En plus de ce cadeau, Zéro a aussi mis à jour le design du site et de nouveaux persos aparaissent au dessus du menu aléatoirement, mais aussi et surtout de nouvelles musiques dans la radio ! Allez vite les écouter, lien radio, menu de gauche sur le site. Merci pour vos chaleureux commentaires sur la news anniversaire... Encore une fois, un joyeux noël à tous !
[img]images/news/noelsaza.png[/img]");
			$news->setCommentId(156);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Genshiken 2 ~ Pack Bonus");
			$news->setTimestamp(strtotime("30 September 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/genshikenbonus.jpg[/img]
Et un petit pack de bonus, un ! Pour marquer la fin de la série, je vous ai concocté un joli mélange de bonus comprenant : Diverses images, des photos de cosplay, les screenshots des épisodes, les musiques de l'opening et de l'ending et une jaquette dvd pour décorer vos dvds gravés. Le pack est disponible sur la page de la série, comme d'habitude.");
			$news->setCommentId(134);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Bonus Maria Holic");
			$news->setTimestamp(strtotime("23 September 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/mariabonus.png[/img]
Déjà 23 longues journées sans que Zéro ne donne de nouvelles... Je suis tellement occupée en ce moment que je m'occupe plus de vous ! Dieu indigne que je suis. Pas de sorties pour aujourd'hui mais juste l'annonce des nombreux bonus sortis chez Kanaii et qu'il fallait sortir chez nous aussi de Maria+Holic.
Rendez-vous sur la page de la série Maria+Holic pour les découvrir !");
			$news->setCommentId(128);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Super Nihon Experimental Summer");
			$news->setTimestamp(strtotime("16 August 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[url=http://snes.ambi-japan.com][img]images/news/snes.jpg[/img][/url]");
			$news->setCommentId(100);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Dossier Genshiken");
			$news->setTimestamp(strtotime("24 June 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("Sunao"));
			$news->setMessage("[b]Bien le bonsoir la populace.[/b]


Afin de bien démarrer, il faut partir d'un postulat: j'en branle pas une.
Donc quand on s'est demandé s'il fallait diversifier les news du site, j'ai eu le malheur de proposer de faire quelque chose sur Genshiken. Malheureusement, je me suis mangé un «rédige-le» en plein dans les dents. Ouch.
Qu'à cela ne tienne, je relève le défi.

Let's rock, baby.


Comme vous vous en êtes sûrement déjà aperçu: il y a des jours qui comptent plus que d'autres: la sortie d'un nouveau Metal Gear, un concert de Dropkick Murphy's ou bien un diner aux chandelles avec Monica Belluci... Bref c'est évident et je le redis: il y a des jours qui comptent plus que d'autres.

Entre autres, il y a le 11 juin 2009.
Wesh wesh mon frère, c'est quoi le 11 juin 2009 ?
Pour certains c'est la perspective d'un examen, pour d'autres c'est la Saint Barnabé (yosh béber), mais pour tout le monde c'est la sortie du neuvième et dernier tome de GENSHIKEN. ( [url]http://www.kurokawa.fr/humour/fiche/1127/genshiken-t9[/url] )

[url=http://www.kurokawa.fr/humour/fiche/1127/genshiken-t9][img]http://img40.xooimage.com/files/f/7/7/tome-9-ec2933.jpg[/img][/url]

[url=index.php?page=dossier&id=genshiken9][img=images/interface/lirelasuite.png][ Lire la suite . . . ][/img][/url]");
			$news->setCommentId(97);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Loli Loli ~~ Premier Mai !");
			$news->setTimestamp(strtotime("01 May 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/lolisummer.jpg[/img]
À l'occasion du premier Mai, on s'offre du muguet, en rapport avec le printemps. Zéro vous fait donc cadeau d'une jolie Loli printemps !");
			$news->setCommentId(66);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("[IRL] Mang'azur 2009");
			$news->setTimestamp(strtotime("21 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$news->setMessage("[img]images/news/dokuro.jpg[/img]
db0 à gauche et Angel à droite.");
			$news->setCommentId(61);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Bonne année 2009");
			$news->setTimestamp(strtotime("01 January 2009"));
			$news->setMessage("[url=images/news/%5BZero%5Dnewyear.jpg][img]images/news/newyear_min.jpg[/img][/url]");
			$news->setCommentId(28);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("V3.4 du site !");
			$news->setTimestamp(strtotime("30 January 2012 00:40"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Après avoir bien bossé ce weekend, je reviens vous faire un petit topo sur l'avancement du raffinage {^_^}. Pour éviter de vous agresser les yeux je vous met les détails en spoiler {^_°}. Pour faire bref, les news sont toutes raffinées (c'est ce qui fait ce changement de version) et le BBCode est dispo.

[spoiler=Afficher les détails]
* [b]Toutes les news[/b] sont désormais raffinées. La gestion a été fusionnée (il y en avait une pour chaque [i]archive[/i]) de manière à ce que tout soit homogène. Au passage ces [i]archives[/i] sont désormais des [i]vues[/i]. Par défaut elles affichent les [b]10 dernières news[/b] pour éviter de surcharger la page (avant elles affichaient la liste complète, seule la page d'accueil étant réduite à 10). Elles sont capables de tout afficher, mais je n'ai pas mis de fonctionnalité pour le faire simplement (il faut rajouter l'élément [i]showAll[/i] à la main dans l'URL). Pour l'instant ça reste comme ça, j'espère implémenter un système de pagination, dire de pouvoir voyager dedans... parce que tout afficher c'est vraiment barbare {'^_^}.

* [b]L'utilisation du BBCode est désormais possible[/b]. Vous me direz ça sert à rien si on peut pas entrer de nouvelles données {'^_^}. Je suis d'accord, mais j'aimerais que certaines fonctionnalités soient déjà implémentées avant que cela ne devienne possible, dire de pas avoir tout à faire en même temps. De plus je me suis amusé à réécrire [u]toutes[/u] les news (164, à la base en HTML ou en objets PHP) en utilisant ce BBCode, de façon à le tester.

Pour ceux qui connaissent les fonctionnalités PHP pour le BBCode, sachez que j'ai tout recodé [b]à partir de zéro[/b]. Non pas que je voulais me faire chier pour rien, mais je voulais simplement avoir quelque chose de plus cohérent et souple. En particulier, les fonctionnalités BBCode de PHP n'étant pas disponibles de base (il faut installer le module) c'est un énorme point noir si un jour on se retrouve sur un serveur où on ne peut pas le mettre. Là on a notre propre parseur... et j'ai déjà plusieurs balises bien sympathiques {^_^}.

Par exemple, pour accéder directement à des projets ou des releases données. [code][release=mitsudomoe|*]lien[/release][/code] donne ce [release=mitsudomoe|*]lien[/release], affichant toutes les releases de Mitsudomoe. C'est ce que j'ai appelé un [i]lien rapide[/i] dans une news précédente, il a désormais son équivalent BBCode. On peut remplacer [code]*[/code] par une liste d'ID d'épisodes pour ne lister que ceux là.

De même ma balise [code]code[/code] (implémentée spécifiquement pour cette news, juste pour vanter les mérites de mon parseur) me permet d'afficher même le BBCode, sans avoir besoin de tricher sur le codage des caractères, ou mettre un caractère spécial pour éviter que ce soit interprété. Mon exemple avec les releases n'est rien d'autre que ce code :

[code][code][release=mitsudomoe|*]lien[/release][/code] donne ce [release=mitsudomoe|*]lien[/release][/code]

De même, un spoiler s'écrit d'habitude comme ça : [code][spoiler=titre]...[/spoiler][/code]. Ainsi, le titre s'affiche d'abord seul, puis il faut cliquer dessus pour ouvrir le spoiler. Cependant, je n'ai jamais vu de spoiler capable de prendre un [b]titre formatté en BBCode[/b], par exemple une image. Ma balise spoiler en revanche en est capable, c'est d'ailleurs le cas dans une vieille news.

[spoiler=Pour les curieux]
Si aucun titre n'est donné, le premier élément non vide dans le spoiler est pris comme titre (et n'est bien sûr plus affiché dans le spoiler). Ça évite les conflits lors du parsage du paramètre, qui peut alors rester générique.[/spoiler]

Une autre particularité est que, lorsqu'une balise BBCode génère son code HTML, le contenu [u]préformatté[/u] est donné (une représentation en arbre du contenu) et une simple fonction permet d'obtenir la version parsée (HTML) ou la version originale (BBCode). On peut donc librement travailler sur l'une des trois versions selon le besoin. C'est ce qui me donne le plus de souplesse.

Enfin bref, vous l'aurez compris, je me suis éclaté ce weekend. Et en plus j'ai pu vérifier les 5 karas de MNO, jap + fr, faire mes lessives et mes courses. C'est pas beau tout ça ? {^.^}~
[/spoiler]

NB : pour ceux qui ont vu que la section H était hors service, normalement ça a été corrigé.");
			$news->setCommentId(287);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Toradora! OAD");
			$news->setTimestamp(strtotime("30 January 2012 20:16"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("[project=toradorabento][imgl=images/news/toradorabento.png]Toradora! Bentô[/imgl][/project]
Certains l'ont demandé, le voilà tout droit sorti du four.

À consommer sans modération {^_^}.

[img=images/news/toradorabento2.png]Toradora! Bentô[/img]

Encore une news qui m'aura donné la dalle {'-_-}.
[pin]
Notez que l'épisode est aussi disponible en 1080p (certains l'ont demandé... et ben on l'a fait aussi). Cela dit on passe par une méthode pas encore passe partout (10 bits). Assurez-vous d'avoir des codecs à jour pour pouvoir le lire.");
			$news->setCommentId(288);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			$news->addReleasing(Project::getProject('toradorabento'));
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Issho ni H Shiyo 03");
			$news->setTimestamp(strtotime("03 April 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo('db0'));
			$news->setMessage("[img]images/news/newsisso3.png[/img]
Yeah !
La suite d'Issho ni H shiyo avec cette fois-ci une jolie neko-maid qui vient s'occuper de ranger votre appartement, vous faire la cuisine et pleins d'autres choses.
Toujours en coproduction avec FinalFan sub dont la p'tite bannière est venue rejoindre celles de nos partenaires.
Attention ! Moins de 18 ans s'abstenir.");
			$news->setCommentId(219);
			$news->setDisplayInNormalMode(false);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			$news->addReleasing(Release::getRelease('hshiyo', 'ep3'));
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Issho ni H shiyo OAV 02");
			$news->setTimestamp(strtotime("03 March 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo('db0'));
			$news->setMessage("[imgr]images/news/issho.png[/imgr]
La suite de notre nouvel hentaï dans la série des isshoni !

Aujourd'hui, vous êtes le senpai de la jolie Haruka et comme celle-ci vous offre des patisseries, vous la remerciez du mieux que vous pouvez... Vous savez bien comment.

Attention, cet épisode est résérvé aux personnes majeures de plus de 18 ans !

Cet épisode est en coproduction avec l'équipe Finalfan Sub.");
			$news->setCommentId(208);
			$news->setDisplayInNormalMode(false);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			$news->addReleasing(Release::getRelease('hshiyo', 'ep2'));
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Issho ni H shiyo OAV 01");
			$news->setTimestamp(strtotime("30 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo('db0'));
			$news->setMessage("[imgr]images/news/isho.jpg[/imgr]Encore un petit épisode de hentaï, mes chers petits pervers !
Vous vous conaissez, on ne fait pas les choses à moitié.
Quand on fait Kodomo, on fait Konoe.
Donc forcément, quand on fait Issho ni Training, on fait Issho ni H siyo !
C'est une sorte de parodie ou c'est vous, ce soir, qui allez faire l'amour avec Miyazawa.
Cet épisode est en co-production avec [partner=finalfan]Finalfan Sub[/partner].");
			$news->setCommentId(193);
			$news->setDisplayInNormalMode(false);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(true);
			$news->setDb0CompanyNews(false);
			$news->addReleasing(Release::getRelease('hshiyo', 'ep1'));
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Konoe no Jikan 03");
			$news->setTimestamp(strtotime("28 January 2010"));
			$news->setAuthor(TeamMember::getMemberByPseudo('db0'));
			$news->setMessage("[imgr]images/news/konoee3.jpg[/imgr]Après la fin de Kodomo, vous vous sentez seuls sans Rin ? La voilà de retour ! Non, ce n'est pas la saison 3 de Kodomo no Jikan mais bien la suite de Konoe no Jikan, la parodie porno. L'épisode est disponible dans la partie Hentaï du site. Mais attention, moins de 18 ans s'abstenir... Je vous surveille, ne trichez pas !");
			$news->setCommentId(189);
			$news->setDisplayInNormalMode(false);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			$news->addReleasing(Release::getRelease('konoe', 'ep3'));
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("He is my master - Ce sont mes Maids DOUJIN");
			$news->setTimestamp(strtotime("15 April 2009 01:00"));
			$news->setAuthor(TeamMember::getMemberByPseudo('db0'));
			$news->setMessage("[img]images/news/heismymaster.jpg[/img]
Un nouveau doujin de plus chez Zéro ! Aucun rapport cette fois avec nos séries, mais une série qu'on aime bien : He is my master. [project=heismymaster]Lien pour le doujin[/project]");
			$news->setCommentId(68);
			$news->setDisplayInNormalMode(false);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			$news->addReleasing(Release::getRelease('heismymaster', 'doujin'));
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Konoe no Jikan 02");
			$news->setTimestamp(strtotime("15 April 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo('db0'));
			$news->setMessage("[img]images/news/konoe2.jpg[/img]
Seto Hinata est de retour dans son rôle de Rin pour l'épisode 02 de Konoe no jikan ! Cette fois-ci, son prof va lui apprendre un cours plutôt interessant... [url=http://www.kojikan.fr/?page=hentai-konoe]Accéder à la page de téléchargement[/url].");
			$news->setCommentId(60);
			$news->setDisplayInNormalMode(false);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			$news->addReleasing(Release::getRelease('konoe', 'ep2'));
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Konoe no Jikan 01");
			$news->setTimestamp(strtotime("18 March 2009"));
			$news->setAuthor(TeamMember::getMemberByPseudo('db0'));
			$news->setMessage("[img]images/news/konoe.jpg[/img]
Il fut un temps où Zéro refusait catégoriquement de proposer du hentaï et autres perversités à nos chers amis leechers. Ce temps est révolu ! Zéro sort aujourd'hui son premier épisode \"hentaï\" qui n'en est pas vraiment un puisque c'est un film, avec de vrais gens dedant, et tout, et tout. Konoe no Jikan ! La parodie cinématographique de Kodomo no Jikan. Série en 4 épisodes, traduits généreusement par Sazaju, traumatisé après ça (R.I.P.). Profitez bien de cet épisode, et n'hésitez pas à nous faire part de votre avis pervers dans les commentaires ! [url=http://www.kojikan.fr/?page=konoe]Accéder à la page de téléchargement[/url].");
			$news->setCommentId(48);
			$news->setDisplayInNormalMode(false);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			$news->addReleasing(Release::getRelease('konoe', 'ep1'));
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("V3.5 du site");
			$news->setTimestamp(strtotime("06 February 2012 11:21"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Voilà encore quelques petites choses de faites (plus de 40 commits en un weekend quand même). Ce changement de version indique la fin du raffinage des pages.

[spoiler=Afficher le résumé][left][list]
[item]Ajout des sections scantrads (en cours, terminés, abandonnés, envisagés) + retrait automatique des sections vides dans la [url=?page=projects]liste des projets[/url].[/item]
[item]Affichage de quelques informations dans la [url=?page=bug]page de bug[/url], pour aider le suivi (si vous en voyez d'autres dîtes-le-moi).[/item]
[item]Complétion d'anciennes informations (certaines étaient isolées dans des fichiers non utilisés, elles sont maintenant avec toutes les autres). Cela inclut les news H et les anciens membres.[/item]
[item]Raffinage des [url=?page=dossiers]dossiers[/url], de la liste des partenaires et de la page pour devenir partenaire (menu de droite). En bref j'ai fini de raffiner les menus et les pages qu'ils pointent. Les news ont été revues pour servir de tests (certaines ont des liens vers des dossiers ou des partenaires).[/item]
[item]Raffinage d'anciennes pages non accessibles depuis les menus mais accessibles depuis d'anciennes news (kanaiiddl, recrutement, dakko, dons, dl).[/item]
[item]Suppression des pages non accessibles (plus de 20 {^_^}).[/item]
[item]Gestion d'URL améliorée : du XSS comme 'index.php/%22onmouseover=prompt(987201)%3E' ne devrait pas fonctionner (n'hésitez pas à en chercher d'autres si ça vous amuse {^_^}).[/item]
[item]Complétion des balises BBCode (relativement aux points précédents).[/item]
[/list][/left][/spoiler]

La prochaine étape devrait être la persistence des données je pense. Avec le passage en base de données, on pourra profiter d'un vrai dynamisme. Si ce n'est pas ça ça sera sûrement l'implémentation des comptes. On verra selon les besoins (ou les envies) du moment {^_^}.");
			$news->setCommentId(289);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("On met la pression ! + MNO 1-10");
			$news->setTimestamp(strtotime("25 March 2012 19:01"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Ça fait un moment qu'on a du mal à sortir des releases, pourquoi ? Mine de rien la réponse est assez simple (malgré le gros pavé qui vous attend).

[imgr=images/news/stripKobato.png]Dur, dur de changer de veste ![/imgr]En fait on a tellement peu de monde que certains doivent faire des choses [b]qu'ils ne sont pas censés faire[/b]. Et bien entendu, non seulement ça leur prend du temps supplémentaire, mais en plus c'est plus lent que quelqu'un qui ne fait que ça. En effet, il faut sans arrêt changer de veste, et donc se remettre dans le bain à chaque fois. C'est pas forcément motivant, vu qu'on n'en voit pas le bout.

On se doute bien que vous avez des trucs à faire, [b]mais nous aussi[/b]. Ce qu'on aimerait, c'est des gens qui aient l'esprit fansub, cet esprit partage qui nous anime nous (depuis un paquet d'années déjà). Hélas, depuis un certain temps, on n'en trouve quasiment plus. On n'a plus que des gens qui leechent et postent des '[i]Merci, continuez, @+[/i]'.

Et parmi ces gens-là, il y en a un paquet qui ont les qualités suffisantes pour faire du fansub, mais par timidité ou par honte non justifiée ils se retiennent en se disant qu'il y aura bien quelqu'un d'autre qui postulera... S'ils peuvent avoir raison (on en a de temps en temps qui postulent), ils ne voient hélas [b]que le court terme[/b]. Parmi ceux qui entrent beaucoup trop ne restent pas. Et pour les rares qui restent, on se retrouve vite avec des gens démotivés parce qu'on n'est pas assez, et donc tout le monde court de partout et se retrouve à faire des choses qu'il ne voulait pas.

[b]On n'a pas besoin de gens super compétents[/b], ces gens-là on les a déjà. La plupart d'entre nous ont appris sur le tas, et ça ne les empêche pas de faire du bon boulot. Mais si on n'est pas assez nombreux, la charge de travail est similaire à un boulot classique (sauf que personne n'est rémunéré). Alors ne vous étonnez pas après de ne plus voir grand-chose sortir. Beaucoup de teams très bonnes dans ce qu'elles faisaient ont fermé pour moins que ça. Nous, on tient parce qu'on est des entêtés qui ne veulent pas s'avouer à l'article de la mort. On a des gens très doués qui sont là pour vous aider à apprendre et vous perfectionner, mais si personne ne nous tend la main ces personnes sont débordées et ne peuvent pas aider les nouveaux arrivants.
[img=images/news/study.png]Allez, courage ![/img]
Plus on est nombreux, mieux c'est pour tout le monde : on ne dilue pas la qualité, on dilue la charge de travail. On a des gens très compétents qui passeront derrière vous de toute façon pour corriger ce qui ne va pas [b]et vous dire comment vous améliorer[/b]. Alors pourquoi se retenir ? Si vous aimez les animes et que vous avez déjà vu quelques dizaines de séries, vous savez déjà ce que c'est que le fansub. Le reste c'est de la découverte et de la mise en pratique, il suffit d'être curieux.

Pour ceux qui seront arrivés jusque-là, on a tout de même une grosse bonne nouvelle : Mayoi Neko Overrun 1 à 10 dans les bacs (et en Blu-Ray) ! Cela dit, on attendra d'avoir la série complète pour faire le torrent du pack, d'ici là le DDL est dispo. Notez le cadre en fin de news, qui liste les sorties liées à la news. Ça marche pour toutes les news de sorties, ça vient d'être implémenté {^_^}.

Pour ceux qui se demandent pourquoi on ne les sort que maintenant : c'est exactement ce que je vous disais plus haut. Les hauts gradés ont tellement de boulot qu'ils repoussent tout à plus tard, moi le premier. Aussi j'espère que vous téléchargerez ces épisodes avec l'envie d'aider.");
			$news->setCommentId(291);
			$news->addReleasing(Release::getRelease('mayoi', 'ep1'));
			$news->addReleasing(Release::getRelease('mayoi', 'ep2'));
			$news->addReleasing(Release::getRelease('mayoi', 'ep3'));
			$news->addReleasing(Release::getRelease('mayoi', 'ep4'));
			$news->addReleasing(Release::getRelease('mayoi', 'ep5'));
			$news->addReleasing(Release::getRelease('mayoi', 'ep6'));
			$news->addReleasing(Release::getRelease('mayoi', 'ep7'));
			$news->addReleasing(Release::getRelease('mayoi', 'ep8'));
			$news->addReleasing(Release::getRelease('mayoi', 'ep9'));
			$news->addReleasing(Release::getRelease('mayoi', 'ep10'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Denpa 01");
			$news->setTimestamp(strtotime("12 March 2012 14:47"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Petite sortie en vitesse. Il y en a un paquet d'autres qui sont en cours de préparation mais qui devraient arriver la semaine prochaine.");
			$news->setCommentId(290);
			$news->addReleasing(Release::getRelease('denpa', 'ep1'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Denpa 02 BD");
			$news->setTimestamp(strtotime("09 May 2012 22:51"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("[imgr=images/news/denpa2.png]On aime rouler les jeunes filles.[/imgr]
Allez, on continue, on lâche pas le rythme ! {^_^}

D'ici à ce que la suite de Mitsudomoe arrive, on reprend la fille aux ondes. Attention, il y a de la violence dans cet épisode ! Vous en avez d'ailleurs un aperçu ci-à droite :

Vous avez vu ça ? On y va à coups de pied ! C'est monstrueux ! {°o°}

Bon, à défaut d'être convaincant vous avez au moins un nouvel épisode à vous mettre sous la dent {-.-}~.");
			$news->setCommentId(297);
			$news->addReleasing(Release::getRelease('denpa', 'ep2'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Mitsudomoe 9 BD");
			$news->setTimestamp(strtotime("4 April 2012 19:41"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Ça se décoince petit à petit. On a eu quelques candidatures et ça allège un peu la charge de travail.

Ajouté à ça, Mitsudomoe 9 dans les bacs. En Blu-Ray comme d'habitude {^_^}.");
			$news->setCommentId(292);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep9'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Mitsudomoe 10 BD");
			$news->setTimestamp(strtotime("8 April 2012 18:38"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Allez, c'est pas fini ! On enchaîne avec l'épisode 10 de Mitsudomoe !

[img]images/news/mitsudomoe10.png[/img]");
			$news->setCommentId(294);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep10'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Mitsudomoe 11 BD");
			$news->setTimestamp(strtotime("18 April 2012 19:49"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Bon, on va pas se faire 2 mini-news d'affilée quand même. Donc voilà un peu de texte : Lorem ipsum... Nan je déconne {^.^}~. Un petit mot tout de même : pour la news d'il y a dix jours, à propos de l'embauche d'un graphiste, pas un seul commentaire n'a été posté (et bien entendu aucune candidature), alors que la suivante s'est vue avoir plus d'intérêt {;_;}.

Je rappelle qu'il n'y a [b][u]pas besoin[/u][/b] d'être super expérimenté, comme savoir faire des effets qui tuent ou autre. Je dirais même qu'à partir du moment où vous savez utiliser le pinceau, la gomme et le couper-coller dans paint (ou tout autre logiciel de traitement d'image), c'est suffisant ! On a juste besoin de quelqu'un qui aime faire ça parce qu'on a plein de petite tâches relatives au traitement d'image, et comme ça peut prendre une masse de temps assez importante, on cherche quelqu'un pour nous épauler. Si vous aimez jouer avec des images, c'est tout ce qu'on demande. C'est même tout ce que je demande, vu que c'est surtout moi qui en ai besoin {'^_^}. S'il y a besoin de faire la moindre chose avancée, je peux dire comment le faire.

Au passage, Mitsudomoe 11 est dans les bacs. Mais tout le monde s'en fout de ça, pas vrai ? Ce qui est important c'est que je cherche quelqu'un qui veut faire graphiste ! \{>o<}/

[img=images/news/mitsudomoe11.jpg]Qui veut maigrir ?[/img]");
			$news->setCommentId(295);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep11'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Mitsudomoe 12+13 BD");
			$news->setTimestamp(strtotime("01 May 2012 13:56"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("J'ai une mauvaise nouvelle à vous annoncer...
Mitsudomoe se termine aujourd'hui chez Zéro Fansub.

{°o°} Non ?

Et si. Les deux derniers épisodes de Mitsudomoe sont désormais disponibles.

[img=images/news/mitsudomoe12_13.jpg]Oh non ! Déjà fini ?[/img]

Et oui, Mitsudomoe c'est fini... Enfin pas tout à fait car, petits chanceux que vous êtes, l'OAD et la saison deux sont d'ores et déjà entamés chez nous ! {^o^}/

Attendez-les avec [s]im[/s]patience (ouais vous avez l'habitude maintenant {'^_^}).

Et merci de nous suivre !
(ça fait un moment qu'on l'a pas sortie celle-là {°.°}~)");
			$news->setCommentId(296);
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep12'));
			$news->addReleasing(Release::getRelease('mitsudomoe', 'ep13'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement exotique !");
			$news->setTimestamp(strtotime("8 April 2012 12:57"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("[imgr]images/news/kanamemo_p4.png[/imgr]On recrute ! Ouais mais vous me direz que ça fait un moment que vous êtes au courant. Mais le truc, c'est que toutes les candidatures qu'on reçoit (pour le peu qu'on a) sont pour des boulots tels que trad et timeurs... et c'est tout. Mais la Zéro, ce n'est pas qu'un blog de fansubbeurs : on maintient un site complet et on essaye de multiplier nos activités.

Bref, tout ça pour vous dire qu'on recherche aussi [b]un graphiste[/b], qui pourra nous aider à faire les sorties en faisant les preview, les images d'entête et de news, mais aussi nous aider à faire les éditions, proposer de nouveaux styles pour le site, et même faire [i]cleaner[/i] pour nos scantrads. Car oui, je vous le rappelle, on a un projet [b]scantrad[/b] (Kanamemo) qui est commencé ! On recherche donc aussi des gens motivés pour participer à ce projet, car là on n'a plus personne {'^_^}.

(je rappelle qu'il n'est pas nécessaire d'être super expérimenté)

Ayez de l'imagination, ne vous dîtes pas d'emblée \"[i]Ah, le fansub ils font ça, mais moi je vois pas où je pourrais aider donc pas la peine de postuler.[/i]\". Si vous voulez aider mais ne savez pas comment, candidatez en disant ce que vous aimez faire, ce que vous savez faire et ce que vous souhaitez améliorer, on vous dira si ça peut servir. Peut-être que vous passez à côté d'une activité pas bien mise en avant mais super intéressante !

Si vous vous sentez prêt à participer à l'aventure : cliquez sur le lien [i]Recrutement[/i] dans le menu de gauche !");
			$news->setCommentId(293);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement Timeur !");
			$news->setTimestamp(strtotime("17 May 2012 18:58"));
			$news->setAuthor(TeamMember::getMemberByPseudo('praia'));
			$news->setMessage("Nous recherchons un timeur sur la durée qui a du temps à gaspiller.

Intéressé ? Postulez sur notre forum via le lien [i]recrutement[/i] du site.

[img=images/news/boring.jpg]Rien à faire ? Venez timer chez Zéro Fansub ![/img]");
			$news->setCommentId(298);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Denpa 03 BD");
			$news->setTimestamp(strtotime("29 May 2012 22:00"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Ça y est ! Avec quelques moments difficiles, nous voilà avec ce troisième épisode de la fille aux ondes.

Attention, visite impromptue d'une jolie donzelle en quête de câlins !

Appréciez bien l'épisode et ne soyez pas trop jaloux. {^_°}

[img=images/news/denpa3.png]Viens faire un câlin ![/img]");
			$news->setCommentId(299);
			$news->addReleasing(Release::getRelease('denpa', 'ep3'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Mitsudomoe OAD + Denpa 4 & 5");
			$news->setTimestamp(strtotime("8 June 2012 22:12"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Bon, il semble que certains ont douté de la fraîcheur de nos articles sur la news précédente. On ne leur en voudra pas, après 39 ans il y a de quoi se poser des questions... {'-.-}

Du coup, voilà de quoi nous rattraper !
Pour ceux d'entre vous qui préfèrent la chair fraîche, nous vous proposons dès aujourd'hui une de nos spécialités, tout droit sortie de dessous la couette :

[img=images/news/denpa4-5.png]Un autre câlin ?[/img]

[spoiler=Bon, certains crieront sûrement à l'entourloupe...]
Et ils ont raison. {'^.^}~[/spoiler]
Donc pour montrer notre bonne volonté, ce sera 2 Denpa pour le prix d'un !
Si si mes amis, vous avez bien lus ! 2 Denpa !

Toujours pas satisfaits ? Ah, vous êtes durs en affaire {'>_<}.
Allez, voilà notre dernier mot : L'OAD de Mitsudomoe est offert !

Avant de partir à la chasse de jeunes filles fraîches et plantureuses, vous pourrez vous remettre en forme sur cet OAD. Attention tout de même, les appareils de sport ne sont pas à mettre entre les mains d'enfants inexpérimentés...

[img=images/news/mitsudomoeoad.png]Un peu de sport ?[/img]

Oui... Enfin bon... On fait ce qu'on peut. {'^_^}

Allez, bon matage et ne restez pas devant votre écran pendant tout le weekend. {^_°}");
			$news->setCommentId(301);
			$news->addReleasing(Release::getRelease('mitsudomoeoad', 'oad'));
			$news->addReleasing(Release::getRelease('denpa', 'ep4'));
			$news->addReleasing(Release::getRelease('denpa', 'ep5'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement adapt+time+édit !");
			$news->setTimestamp(strtotime("13 June 2012 00:00"));
			$news->setAuthor(TeamMember::getMemberByPseudo('praia'));
			$news->setMessage("Cherche des adapteurs (reformulent les phrases) ou timeurs : le stock est épuisé

Donc, on a besoin de vous.

On recherche aussi un éditeur pour épauler le nôtre, les projets s'entassent...

[b]Peut-être un nouveau projet pour cet été, on aimerait bien, quoi...
Cela fait déjà deux saisons qu'on ne prend rien...
mais faudrait déjà qu'on arrive à terminer ceux en cours,
donc toute aide est la bienvenue...[/b]

Si vous avez du temps, que vous voulez un peu contribuer au début,
histoire de voir si ça vous plaît, venez nous essayer...

Postez votre candidature sur le forum et vous découvrirez un monde de travail xD

Et le travail, c'est la santé...

N.B. : l'expérience n'est pas exigée ^_^

[img=images/news/recrutement.png]Qui veut nous rejoindre ?[/img]");
			$news->setCommentId(300);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Pas mal de petits changements");
			$news->setTimestamp(strtotime("25 June 2012 20:18"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Bon, ça fait longtemps qu'on n'a pas fait de news, donc j'en profite pour faire un petit topo sur ce qui a été  implémenté sur le site depuis la dernière news sur le sujet (datant du 6 Février). Je passerai sous silence ce qui attend au chaud sur les autres branches de développement (et qui n'est donc pas accessible ici) sinon je suis bon pour en écrire encore trois tonnes et perdre tout le monde {'^_^}. Les curieux sauront demander.

Tout d'abord, ceux qui regardent correctement ont dû remarquer que les news ont des boutons pour les partager via Twitter et Facebook. Ces boutons ont été [b]renouvelés[/b] (on utilise les dernières versions) et le +1 de Google a été ajouté. De plus, auparavant, ces boutons étaient liés au site, donc cliquer sur l'un d'entre eux était suffisant, mais pas super intéressant. Maintenant, ils sont liés aux news elles-mêmes, donc vous pouvez toutes les cliquer. Autrement dit : lâchez-vous et [b]faites-nous de la pub ![/b] Parce qu'on manque (encore et toujours) cruellement de main d'œuvre {'^_^}.

[img=images/news/follower.jpg]Oh ! On a des amis ![/img]

C'est la mise à jour la plus importante que je voulais décrire, mais les curieux pourront dérouler ce spoiler pour voir la liste des améliorations.
[spoiler=<Montrer la liste>]
[left][list]
[item]Les news de sorties listent (semi-automatiquement, c'est ça le plus important) les releases en fin de news.[/item]
[item]Les releases ont désormais la source indiquée (DVD, BD, ...).[/item]
[item]Intégration de la page de recrutement du forum sur le site (accessible depuis le lien en question dans le menu de gauche).[/item]
[item]Mise à jour de la radio.[/item]
[item]Les publicités qui s'affichaient sur certaines pages ont été retirées.[/item]
[item]Des pages obsolètes ont été retirées.[/item]
[item]Les liens MU (obsolètes) ont été retirés.[/item]
[item]Un style plus [i]propre[/i] (autant niveau codage que rendu), même si ce sont des modifications minimes.[/item]
[item]Quelques optimisations sur l'affichage ont également été faites.[/item]
[item]Certains liens morts ont été corrigés dans nos releases.[/item]
[item]Les liens vers les discussions en bas de projets ont été corrigés.[/item]
[item]La page de bug a une meilleure couverture (certains types d'erreurs n'étaient pas pris en compte avant).[/item]
[item]Plusieurs modifications pour avoir un code XHTML plus valide (mais on n'est pas encore nickel {'^_^}).[/item]
[item]Encodage UTF-8 pour tout le site (au lieu de ISO-8859-15 pour ceux que ça intéresse).[/item]
[item]Quelques tests automatisés ont été implémentés (c'est pas grand chose, mais c'est un premier pas qui ne sera pas le dernier).[/item]
[item]Multiples corrections de bugs et autres ...[/item]
[/list][/left]
[/spoiler]

Ceux qui voudront encore plus de détails se référeront au dépôt GitHub {^_^}.

Enfin, merci de signaler tout bug sur lequel vous tombez pour nous aider à améliorer le site.");
			$news->setCommentId(302);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement timeurs !");
			$news->setTimestamp(strtotime("12 August 2012 20:44"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Allez, vous avez l'habitude, alors on continue : une p'tite news de recrutement ! {^_^}

[imgl=images/news/recrutementTimeurs.png]Alors ? Ça vous tente ?[/imgl]Ce coup-ci, on cherche (encore et toujours) des timeurs. Pas besoin d'expérience, c'est pas compliqué. C'est juste long à faire, donc il nous faut du monde.

Donc si vous vous ennuyez pendant vos vacances, et que vous n'avez toujours rien à raconter pour la rentrée, c'est le moment d'en profiter ! Vous pourrez vous vanter de participer à la création de ces vidéos que vos amis téléchargent comme des cochons sur le net. Et le fin du fin, de le faire dans une team qui fait de la QUA-LI-TÉ ! {*o*}

A~h, ce doux sentiment de supériorité...

Pour ceux qui n'ont plus l'âge de se vanter à la récrée, un break ne vous ferait pas de mal. Ça tombe bien : avec nos séries rafraîchissantes, dépaysement garanti ! Et si, comme certains, vous en avez marre des supérieurs qui ne vous laissent pas le temps de travailler correctement, tout ça pour faire plaisir à des gens qui n'en ont rien à faire... Vous êtes les bienvenus ! Chez Zéro, on sait ce que ça veut dire de prendre le temps de bien faire. Et on aime ça ! {^_°}

Donc, pour ceux qui se rendent compte de ce qu'ils ratent, direction
[url=?page=recruit]la page de recrutement[/url] !");
			$news->setCommentId(303);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Recrutement karamakeur !");
			$news->setTimestamp(strtotime("10 September 2012 20:34"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Oyez, oyez ! Braves gens !

La team Zéro ouvre ses portes aux plus avenants d'entre vous qui voudraient rejoindre nos rangs !

En effet, un de nos éditeurs vient de nous quitter.
Mal lui en a pris de favoriser la vie IRL : il s'est retrouvé à ne plus avoir assez de temps pour s'amuser chez nous. {;o;}/

Mais ainsi soit-il !
Mes braves gens, votre heure de gloire est venue !

Nous cherchons donc un karamakeur (ou éditeur) qui serait tenté par l'aventure Zéro Fansub. Que tous les manants intéressés, fussent-ils expérimentés ou simple amateurs, se présentent [url=?page=recruit]à nos portes[/url] !

Mais attention : premier arrivé, premier servi {^_^}.
(bien qu'il devrait y avoir de la place pour tout le monde)

[img=images/news/party.png]Attention, ça va pexer ![/img]");
			$news->setCommentId(304);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Haganai OAV");
			$news->setTimestamp(strtotime("2 November 2012 17:10"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Petite sortie en vitesse : en attendant d'avoir la série, voilà déjà l'OAV de Boku ha Tomodachi ga Sukunai. À réserver aux estomacs surentraînés {^_°}.

[img=images/news/haganaioav.png]Attention aux aigreurs d'estomac...[/img]");
			$news->setCommentId(305);
			$news->addReleasing(Release::getRelease('haganaioav', 'oav'));
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(false);
			$news->setTeamNews(false);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$news = new News();
			$news->setTitle("Besoin de timeur !");
			$news->setTimestamp(strtotime("11 November 2012 09:22"));
			$news->setAuthor(TeamMember::getMemberByPseudo('Sazaju HITOKAGE'));
			$news->setMessage("Allez, on a fait l'effort de sortir un épisode, maintenant on a besoin de gens pour faire cet effort avec nous {^_^} !

On recrute donc encore et toujours des timeurs, c'est ce qui nous manque cruellement. A défaut d'en avoir, l'horloge de Zéro risque de rester figée pendant un moment... En espérant que ça ne devienne pas un compte à rebours avant la fin...

[img=images/news/time.jpg]Attention à ce que ça ne vire pas au rouge...[/img]

{;o;}/ Noooon !

Donc voilà, le recrutement c'est [url=?page=recruit]par ici[/url], merci de nous aider à tenir encore un peu, au moins le temps que certaines choses se débloquent.");
			$news->setCommentId(306);
			$news->setDisplayInNormalMode(true);
			$news->setDisplayInHentaiMode(true);
			$news->setTeamNews(true);
			$news->setPartnerNews(false);
			$news->setDb0CompanyNews(false);
			News::$allNews[] = $news;
			
			$ids = array();
			foreach(News::$allNews as $news) {
				$id = $news->getId();
				if (in_array($id, $ids)) {
					throw new Exception("$id is used more than once");
				} else {
					$ids[] = $id;
				}
			}
			
			// check no null property
			array_map(function(News $news) {
				$properties = array();
				$properties['isReleasing'] = $news->isReleasing();
				$properties['isTeamNews'] = $news->isTeamNews();
				$properties['isPartnerNews'] = $news->isPartnerNews();
				$properties['isDb0CompanyNews'] = $news->isDb0CompanyNews();
				try {
					array_map(function($name, $property) {
						if ($property === null) {
							throw new Exception($name);
						}
					}, array_keys($properties), $properties);
				} catch(Exception $e) {
					$property = $e->getMessage();
					throw new Exception($property."() is null for the news '".$news->getTitle()."'");
				}
			}, News::$allNews);
		}
		
		if ($selector != null) {
			return array_filter(News::$allNews, $selector->getCallback());
		} else {
			return News::$allNews;
		}
	}
	
	public static function getNews($id) {
		foreach(News::getAllNews() as $news) {
			if ($news->getId() == $id) {
				return $news;
			} else {
				continue;
			}
		}
		throw new Exception("$id is not a valid news ID");
	}
	
	public static function timestampSorter(News $a, News $b) {
		$ta = $a->getTimestamp();
		$tb = $b->getTimestamp();
		return $ta === $tb ? 0 : ($ta === null ? -1 : ($tb === null ? 1 : ($ta < $tb ? 1 : ($ta > $tb ? -1 : 0))));
	}
}
?>