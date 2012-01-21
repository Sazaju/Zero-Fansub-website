<?php
/*
	A project is a set of data concerning a specific project (set of releases).
*/

class Project {
	private $id = '';
	private $name = '';
	private $genre = null;
	private $studio = null;
	private $externalSource = null;
	private $officialWebsite = null;
	private $originalName = null;
	private $airingYear = null;
	private $author = null;
	private $synopsis = null;
	private $isStarted = false;
	private $isRunning = false;
	private $isFinished = false;
	private $isAbandonned = false;
	private $license = null;
	private $isHentai = false;
	private $isDoujin = false;
	private $isHidden = false;
	private $discussionUrl = null;
	private $vosta = null;
	private $bonuses = array();
	
	public function __construct($id = null, $name = null) {
		$this->setID($id);
		$this->setName($name);
	}
	
	public function addBonus(ProjectBonus $bonus) {
		$this->bonuses[] = $bonus;
	}
	
	public function getBonuses() {
		return $this->bonuses;
	}
	
	public function setVosta($vosta) {
		$this->vosta = $vosta;
	}
	
	public function getVosta() {
		return $this->vosta;
	}
	
	public function setDiscussionUrl($url) {
		$this->discussionUrl = new Url($url);
	}
	
	public function getDiscussionUrl() {
		return $this->discussionUrl;
	}
	
	public function setGenre($genre) {
		$this->genre = $genre;
	}
	
	public function getGenre() {
		return $this->genre;
	}
	
	public function setStudio($studio) {
		$this->studio = $studio;
	}
	
	public function getStudio() {
		return $this->studio;
	}
	
	public function setExternalSource($source) {
		$this->externalSource = $source;
	}
	
	public function getExternalSource() {
		return $this->externalSource;
	}
	
	public function hasExternalSource() {
		return $this->externalSource != null;
	}
	
	public function setOfficialWebsite(Link $link) {
		$this->officialWebsite = $link;
	}
	
	public function getOfficialWebsite() {
		return $this->officialWebsite;
	}
	
	public function hasOfficialWebsite() {
		return $this->officialWebsite != null;
	}
	
	public function setAuthor($author) {
		$this->author = $author;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function setAiringYear($year) {
		$this->airingYear = $year;
	}
	
	public function getAiringYear() {
		return $this->airingYear;
	}
	
	public function setOriginalName($name) {
		$this->originalName = $name;
	}
	
	public function getOriginalName() {
		return $this->originalName;
	}
	
	public function setSynopsis($synopsis) {
		$this->synopsis = $synopsis;
	}
	
	public function getSynopsis() {
		return $this->synopsis;
	}
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setRunning($boolean) {
		$this->isRunning = $boolean;
		if ($boolean) {
			$this->setStarted(true);
			$this->setAbandonned(false);
		}
	}
	
	public function isRunning() {
		return $this->isRunning;
	}
	
	public function setStarted($boolean) {
		$this->isStarted = $boolean;
	}
	
	public function isStarted() {
		return $this->isStarted;
	}
	
	public function setFinished($boolean) {
		$this->isFinished = $boolean;
		if ($boolean) {
			$this->setStarted(true);
			$this->setRunning(false);
		}
	}
	
	public function isFinished() {
		return $this->isFinished;
	}
	
	public function setAbandonned($boolean) {
		$this->isAbandonned = $boolean;
		if ($boolean) {
			$this->setRunning(false);
		}
	}
	
	public function isAbandonned() {
		return $this->isAbandonned;
	}
	
	public function setLicense(License $license) {
		$this->license = $license;
	}
	
	public function getLicense() {
		return $this->license;
	}
	
	public function isLicensed() {
		return $this->getLicense() != null;
	}
	
	public function setHentai($boolean) {
		$this->isHentai = $boolean;
	}
	
	public function isHentai() {
		return $this->isHentai;
	}
	
	public function setHidden($boolean) {
		$this->isHidden = $boolean;
	}
	
	public function isHidden() {
		return $this->isHidden;
	}
	
	public function setDoujin($boolean) {
		$this->isDoujin = $boolean;
	}
	
	public function isDoujin() {
		return $this->isDoujin;
	}
	
	private static $allProjects = null;
	public static function getAllProjects() {
		if (Project::$allProjects === null) {
			$project = new Project("canaan", "Canaan");
			$project->setFinished(true);
			$project->setLicense(License::getDefaultLicense());
			Project::$allProjects[] = $project;
			
			$project = new Project("genshiken", "Genshiken II");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("hitohira", "Hitohira");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kanamemo", "Kanamemo");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kanamemobook", "Kanamemo");
			$project->setStarted(true);
			$project->setRunning(true);
			$project->setDoujin(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kannagi", "Kannagi");
			$project->setFinished(true);
			$project->setLicense(License::getDefaultLicense());
			Project::$allProjects[] = $project;
			
			$project = new Project("kissxsis", "KissXsis TV");
			$project->setRunning(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kissxsisoav", "KissXsis OAD");
			$project->setRunning(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kimikiss", "Kimikiss Pure Rouge");
			$project->setAbandonned(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomo", "Kodomo no Jikan");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomooav", "Kodomo no Jikan OAV");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomo2", "Kodomo no Jikan ~ Ni Gakki");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomonatsu", "Kodomo no Natsu Jikan");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomofilm", "Kodomo no Jikan Le Film");
			$project->setFinished(true);
			Project::$allProjects[] = $project;

			$project = new Project("kujibiki", "Kujibiki Unbalance II");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("mariaholic", "Maria+Holic");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("mitsudomoe", "Mitsudomoe");
			$project->setOriginalName("Mitsudomoe");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOfficialWebsite(Link::newWindowLink("http://www.mitsudomoe-anime.com/", "Mitsudomoe Anime"));
			$project->setAiringYear(2010);
			$project->setStudio("Bridge");
			$project->setAuthor("Sakurai Norio");
			$project->setGenre("Comédie Ecchi");
			$project->setSynopsis("Les triplés raconte l'histoire de 3 filles de primaire un peu perverses qui harcèlent leur prof pas doué.");
			$project->setRunning(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("toradora", "Toradora!");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("toradorasos", "Toradora! Spécial SOS");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("eriko", "ERIKO");
			$project->setOriginalName("ERIKO");
			$project->setAiringYear(2007);
			$project->setAuthor("Gunma Kisaragi");
			$project->setGenre("Hentai");
			$project->setSynopsis("Parodie hentaï de Kimikiss pure rouge mettant en scène Futami Eriko, l'intello, continuant ses expèriences encore plus profondément avec Kazuki.");
			$project->setHentai(true);
			$project->setDoujin(true);
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("heismymaster", "Ce sont mes Maids");
			$project->setOriginalName("Kore ga Oresama no Maidtachi");
			$project->setAiringYear(2007);
			$project->setAuthor("Yukimihonpo");
			$project->setGenre("Hentai");
			$project->setSynopsis("Parodie hentaï He is my master. Yoshitaka est malade et les médicaments qu'Izumi va lui donner vont le remettre d'aplomb, ainsi que son penis ! Il va tout faire pour avoir Izumi mais va finalement se rattraper sur les deux autres.");
			$project->setHentai(true);
			$project->setDoujin(true);
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("denpa", "Denpa Onna to Seishun Otoko");
			$project->setOriginalName("Denpa Onna To Seishun Otoko");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOfficialWebsite(Link::newWindowLink("http://www.tbs.co.jp/anime/denpa/", "Denpa Onna To Seishun Otoko"));
			$project->setAiringYear(2011);
			$project->setStudio("Shaft");
			$project->setGenre("Fantastique");
			$project->setSynopsis("Niwa Makoto est un lycéen parti vivre chez sa tante car ses parents sont en voyage d'affaires. Il y rencontre une cousine du même âge, inconnue du reste de sa famille, Towa Erio. Cette cousine étrange porte constamment un futon autour du corps, ne se nourrit pratiquement que de pizzas et pense être un extraterrestre.");
			$project->setStarted(true);
			$project->setRunning(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("sleeping", "Isshoni Sleeping - S'endormir avec Hinako");
			$project->setOriginalName("Isshoni Sleeping");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setAiringYear(2010);
			$project->setGenre("Ecchi");
			$project->setSynopsis("Hinako est de retour ! Après l'effort, le réconfort, et c'est avec elle que vous allez pouvoir vous reposer après les difficiles exercices de musculations du précédent épisode.");
			$project->setFinished(true);
			$project->setLicense(License::getDefaultLicense());
			Project::$allProjects[] = $project;
			
			$project = new Project("bath", "Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko");
			$project->setOriginalName("Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setAiringYear(2011);
			$project->setStudio("Primaesta");
			$project->setGenre("Ecchi");
			$project->setSynopsis("Prendre un bain avec Hinako, &ccedil;a vous dit ? En plus, elle n'est pas seule : Hiyoko, sa copine loli, vient vous rejoindre.");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("potemayooav", "Potemayo OAV");
			$project->setOriginalName("Potemayo Special");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOfficialWebsite(Link::newWindowLink("http://www.potemayo.com/", "Potemayo.com"));
			$project->setAiringYear(2008);
			$project->setStudio(Link::newWindowLink("http://www.jcstaff.co.jp/", "JC Staff"));
			$project->setGenre("Comédie");
			$project->setSynopsis("De petites aventures arrivent à Potemayo dans ces épisodes bonus de la série Potemayo.");
			$project->addBonus(new ProjectBonus("Thèmes pour Firefox (Skin Persona)", Link::newWindowLink("http://www.getpersonas.com/en-US/persona/208619", new Image("http://getpersonas-cdn.mozilla.net/static/1/9/208619/preview.jpg?1273490832", "Potemayo theme skin persona mozilla firefox"))));
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("konoe", "Konoe no Jikan");
			$project->setOriginalName("Konoe no Jikan");
			$project->setAiringYear(2008);
			$project->setGenre("Porno");
			$project->setSynopsis("Parodie pornographique de Kodomo no Jikan.");
			$project->setHentai(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("akinahshiyo", "Akina To Onsen De H Shiyo !");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Akina To Onsen De H Shiyo");
			$project->setAiringYear(2011);
			$project->setGenre("Hentai");
			$project->setHentai(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("alignment", "Alignment You ! You ! The Animation");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Alignment You ! You ! The Animation");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.pinkpineapple.co.jp/web/alignment/", "Pinkpineapple.co.jp"));
			$project->setAiringYear(2008);
			$project->setStudio(Link::newWindowLink("http://www.pinkpineapple.co.jp/", "Pinkpineapple"));
			$project->setGenre("Hentai");
			$project->setSynopsis("Takahashi, jeune lycéenne, se masturbe furieusement dans la salle de cours devant l'homme qu'elle aime, Oohara. Mais personne ne remarque la lubrique jeune femme ! Et pour cause : elle est déjà morte...");
			$project->setVosta(Link::newWindowLink("http://www.killer-maid.net", "Killer maid"));
			$project->setHentai(true);
			$project->setHidden(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("training", "Isshoni Training - L'entra&icirc;nement avec Hinako");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Isshoni Training");
			$project->setAiringYear(2009);
			$project->setGenre("Ecchi");
			$project->setSynopsis("Hinako est aspirée dans le monde des mangas alors qu'elle en regardait un à la télévision. C'est ainsi que commence sa vie en tant que personnage d'anime, tandis que le spectateur est sans cesse sollicité pour des exercices physiques de remise en forme, avec une caméra à la première personne.");
			$project->setVosta("Boobz");
			$project->setFinished(true);
			$project->setLicense(License::getDefaultLicense());
			Project::$allProjects[] = $project;
			
			$project = new Project("working", "Working!!");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Working!!");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.wagnaria.com/", "Wagnaria.com"));
			$project->setAiringYear(2010);
			$project->setStudio("A-1 Pictures Inc");
			$project->setGenre("Comédie");
			$project->setSynopsis("Takanashi Souta est un lycéen qui a une passion pour les petites choses mignonnes. Quand une fille, Taneshima Popla, l'aborde dans la rue et lui demande si il cherche un travail à mi-temps, il la trouve mignonne car elle ressemble à une collégienne, peut-être même une écolière. Mais il se rend compte quelle a un an de plus que lui. Passant par dessus ce détail, il accepte le travail à mi-temps car elle est toute petite et craquante à souhait. Il commence donc à travailler dans un restaurant familial, mais on peut dire que le personnel est unique ici !");
			Project::$allProjects[] = $project;
			
			$project = new Project("working2", "Working!! 2");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Working!! 2");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.wagnaria.com/", "Wagnaria.com"));
			$project->setAiringYear(2011);
			$project->setStudio("A-1 Pictures Inc");
			$project->setGenre("Comédie");
			$project->setSynopsis("Takanashi Souta est un lycéen qui a une passion pour les petites choses mignonnes. Quand une fille, Taneshima Popla, l'aborde dans la rue et lui demande si il cherche un travail à mi-temps, il la trouve mignonne car elle ressemble à une collégienne, peut-être même une écolière. Mais il se rend compte quelle a un an de plus que lui. Passant par dessus ce détail, il accepte le travail à mi-temps car elle est toute petite et craquante à souhait. Il commence donc à travailler dans un restaurant familial, mais on peut dire que le personnel est unique ici !");
			Project::$allProjects[] = $project;
			
			$project = new Project("hshiyo", "Faisons l'amour ensemble !");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Issho ni H shiyo");
			$project->setAiringYear(2009);
			$project->setGenre("Hentai");
			$project->setSynopsis("Vous avez aimez L'entraînement avec Hinako ? Vous aimerez sûrement sa parodie Hentaï, \"faisons l'amour ensemble\" ! Aujourd'hui, c'est avec vous que notre jolie héroïne fait l'amour... Vous, et vous seul ! Profitez-en ;)");
			$project->setHentai(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("mermaid", "Mermaid Melody Pichi Pichi Pitch");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Mermaid Melody Pichi Pichi Pitch");
			$project->setOfficialWebsite(Link::newWindowLink("http://p-hanamori.cool.ne.jp/", "Lips"));
			$project->setAiringYear(2003);
			$project->setStudio(Link::newWindowLink("http://www.tokyu-agc.co.jp/", "Tokyo Agency"));
			$project->setGenre("Comédie - Magical Girl - Ecchi");
			$project->setAuthor("Pink Hanamori");
			$project->setSynopsis("Luchia, une jeune sirène, a sauvé dans son enfance un garçon du même âge qu'elle qui était en train de se noyer et lui a mis au cou un médaillon. Quelques années plus tard, elle gagne la terre ferme dans l'espoir de retrouver celui qu'elle a toujours aimé. Le jeune collégien en question qui est devenu un surfer participant à des concours invite Luchia et sa copine Hanon pour la revoir lors de sa prochaine compétition, mais les Forces du Mal aquatiques vont venir semer le trouble...");
			$project->setVosta("Lunar anime");
			$project->setDiscussionUrl("http://zero.xooit.fr/t148-Ton-avis-sur-Mermaid-Melody-Pichi-Pichi-Pich-la-serie-en-general.htm");
			$project->setAbandonned(true);
			$project->setLicense(License::getDefaultLicense());
			Project::$allProjects[] = $project;
			
			$project = new Project("nanami", "Nanami Madobe Windows 7 Publicit&eacute;");
			$project->setOriginalName("Madobe Nanami Windows7 Comercial");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.windows7-mania.jp/", "Windows7 Mania"));
			$project->setAiringYear(2010);
			$project->setStudio("Microsoft");
			$project->setGenre("Publicité");
			$project->setSynopsis("Nanami Madobe te présente Windows 7 et te donne des conseils pour mieux l'utiliser. Elle te montre aussi comment monter ton propre ordinateur.");
			$project->setVosta(Link::newWindowLink("http://bssubs.net/", "BSS"));
			$project->addBonus(new ProjectBonus("ThemePack", "Le thème de Nanami Madobe pour Windows 7 ! Pour l'installer, vous devez avoir Windows 7. Téléchargez le fichier puis double-cliquez dessus pour l'ouvrir. Le thème s'installera tout seul et Nanami vous dira \"Konichiwa ! Nanami desu.\".<br/>
<a href='ddl/[Zero]_Windows_7_Nanami_Madobe_ThemePack.themepack' target='_blank'>
<img src='http://zerofansub.net/images/news/theme_nanami.png' border='0' alt='Themepack Thème Windows 7 de Nanami Madobe à télécharger download gratuit' />
</a>"));
			$project->addBonus(new ProjectBonus("Pack d'images", Link::newWindowLink("http://zerofansub.net/galerie/index.php?spgmGal=Zero_fansub/Images/Nanami%20Madobe", new Image("http://zerofansub.net/images/news/galerie_nanami.png", "Galerie d'images Nanami Madobe"))));
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("potemayo", "Potemayo");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Potemayo");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.potemayo.com/", "Potemayo.com"));
			$project->setAiringYear(2007);
			$project->setStudio(Link::newWindowLink("http://www.jcstaff.co.jp/", "JC Staff"));
			$project->setGenre("Comédie");
			$project->setSynopsis("Sunao Moriyama, se préparant à partir à l'école, ouvre la porte de son frigo afin de déjeuner, hors celui-ci tombe nez à nez avec une drôle de créature plus ou moins semblable à un \"bébé\".
Comme s'il n'avait rien vu de spécial celui-ci ferme la porte sans porter plus d'attention à la créature en ayant au préalable saisi son déjeuné, celui-ci portant le nom de \"Potemayo\", il surnommera la créature \"Potemayo\".
Et c'est dès lors qu'à se moment, les gags et situations humoristiques apparaissent !");
			$project->setVosta("<a href=\"http://fansubs.anime-share.net/\" target=\"_blank\">Anime-Share fansub</a> et Anoymous");
			$project->addBonus(new ProjectBonus("Thèmes pour Firefox (Skin Persona)", Link::newWindowLink("http://www.getpersonas.com/en-US/persona/208619", new Image("http://getpersonas-cdn.mozilla.net/static/1/9/208619/preview.jpg?1273490832", "Potemayo theme skin persona mozilla firefox"))));
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("hyakkooav", "Hyakko OAV");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Hyakko Extra");
			$project->setOfficialWebsite(Link::newWindowLink("http://hyakko.jp/", "Hyakko.jp"));
			$project->setAiringYear(2009);
			$project->setStudio("Nippon Animation");
			$project->setGenre("Comédie");
			$project->setAuthor("Katoh Aruaki");
			$project->setSynopsis("Torako invite Toma dans un café manger des patisseries.");
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20Original%20Soundtrack.zip.torrent">[Nipponsei] Hyakko Original Soundtrack.zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20OP%20Single%20-%20Suppin%20Rock%20%5BOgawa%20Mana%5D.zip.torrent">[Nipponsei] Hyakko OP Single - Suppin Rock [Ogawa Mana].zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20ED%20Single%20-%20Namida%20Namida%20Namida%20%5BHirano%20Aya%5D.zip.torrent">[Nipponsei] Hyakko ED Single - Namida Namida Namida [Hirano Aya].zip</a>'));
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("mayoi", "Mayoi Neko Overrun!");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Mayoi Neko Overrun!");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.patisserie-straycats.com/", "Patisserie Stray Cats"));
			$project->setAiringYear(2010);
			$project->setStudio(Link::newWindowLink("http://www.anime-int.com/", "Studio AIC"));
			$project->setAuthor("Matsu Tomohiro");
			$project->setGenre("Comédie Ecchi");
			$project->setSynopsis("Takumi Tsuzuki vit avec sa grande “soeur” Otome bien qu’ils ne soient pas liés par le sang. Otome gère une vieille pâtisserie appelée Stray Cats où y travaille également une amie d’enfance de Takumi, Fumino Serisawa. C’est alors qu’un jour, Nozomi Kiriya, une jeune fille mystérieuse imitant un chat, apparaît…");
			$project->addBonus(new ProjectBonus("Thèmes pour Firefox (Skin)", '<a target="_blank" href="http://www.getpersonas.com/en-US/persona/209338"><img src="http://getpersonas-cdn.mozilla.net/static/3/8/209338/preview.jpg?1273561667" border="0" alt="Mayoi Neko Overrun! theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/210030"><img src="http://getpersonas-cdn.mozilla.net/static/3/0/210030/preview.jpg?1273648101" border="0" alt="Mayoi Neko Overrun! theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/233236"><img src="http://getpersonas-cdn.mozilla.net/static/3/6/233236/preview.jpg?1277047781" border="0" alt="Mayoi Neko Overrun! theme skin persona mozilla firefox" /></a>'));
			$project->setStarted(true);
			$project->setRunning(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("tayutamapure", "Tayutama - Kiss on my Deity - Pure My Heart");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Tayutama -Kiss on my Deity- Pure My Heart");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.tayutama.com/", "Tayutama.com"));
			$project->setAiringYear(2009);
			$project->setStudio("Silver Link");
			$project->setGenre("Amour et Amitié");
			$project->setSynopsis("Les épisodes Bonus DVD de la série Tayutama -Kiss on my Deity-.");
			$project->addBonus(new ProjectBonus("Jaquette(s) DVD", '<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
	<a href="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Label.jpg" target="_blank">
	<img src="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Label.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>'));
			$project->addBonus(new ProjectBonus("Thèmes pour Firefox (Skin)", '<a target="_blank" href="http://www.getpersonas.com/en-US/persona/236444"><img src="http://getpersonas-cdn.mozilla.net/static/4/4/236444/preview.jpg?1277397610" border="0" alt="Tayutama Kiss on my Deity theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/260878"><img src="http://getpersonas-cdn.mozilla.net/static/7/8/260878/preview.jpg?1279817830" border="0" alt="Tayutama Kiss on my Deity theme skin persona mozilla firefox" /></a>'));
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("sketchbookdrama", "Sketchbook ~full colors~ Picture Drama");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Sketchbook - full color's Picture Drama");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.sketch-full.net/", "Sketch-full.net"));
			$project->setAiringYear(2008);
			$project->setStudio(Link::newWindowLink("http://www.hal-film.co.jp/", "Hal film maker"));
			$project->setGenre("Comédie");
			$project->setAuthor("Kobako Totan");
			$project->setSynopsis("Sora et ses amies partent en vacances ensemble.");
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur la radio.<br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Sketchbook%20~full%20colors~%20sound%20sketch%20book.zip.torrent" target="_blank">[Nipponsei] Sketchbook ~full colors~ sound sketch book.zip	11-21 01:28	130.02 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Sketchbook%20~full%20color%27s~%20OP%20Single%20-%20Kaze%20Sagashi%20%5BKiyoura%20Natsumi%5D.zip.torrent" target="_blank">[Nipponsei] Sketchbook ~full color\'s~ OP Single - Kaze Sagashi [Kiyoura Natsumi].zip	10-24 01:52	43.88 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Sketchbook%20~full%20color%27s~%20ED%20Single%20-%20Sketchbook%20wo%20Motta%20Mama%20%5BMakino%20Yui%5D.zip.torrent" target="_blank">[Nipponsei] Sketchbook ~full color\'s~ ED Single - Sketchbook wo Motta Mama [Makino Yui].zip	10-24 01:52	47.75 MB</a>'));
			$project->setDiscussionUrl("http://zero.xooit.fr/t359-Ton-avis-sur-Sketchbook-full-color-s.htm");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("hyakko", "Hyakko");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Hyakko");
			$project->setOfficialWebsite(Link::newWindowLink("http://hyakko.jp/", "Hyakko.jp"));
			$project->setAiringYear(2008);
			$project->setStudio("Nippon Animation");
			$project->setGenre("Comédie");
			$project->setSynopsis("L’école privée Kamizono est un établissement qui possède la particularité d’accueillir en son sein des élèves allant du primaire jusqu’au lycée. De ce fait, son immense structure donne du mal aux nouveaux arrivants pour s’y retrouver. Nonomura Ayumi, jeune étudiante au caractère réservé, arrive à se perdre dés le premier jour de la rentrée. Cherchant désespérément son chemin, elle fini par tomber sur une de ses camarades de classe Lizuda Tatsuki qui se trouve être, sans vouloir l’admettre, dans la même situation qu’elle. Après un long moment de marche, toutes les deux voient incrédules deux élèves sautaient du deuxième étage d’un bâtiment. C’est ainsi qu’elles font la rencontre de Torako et Suzu, également perdues mais ayant un moyen infaillible pour atteindre rapidement leur salle de classe : aller de l’avant quelque soit l’obstacle rencontré. Commence alors pour ce nouveau quatuor formé, une année scolaire placée sous le signe de l’amitié et de l’humour.");
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20Original%20Soundtrack.zip.torrent">[Nipponsei] Hyakko Original Soundtrack.zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20OP%20Single%20-%20Suppin%20Rock%20%5BOgawa%20Mana%5D.zip.torrent">[Nipponsei] Hyakko OP Single - Suppin Rock [Ogawa Mana].zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20ED%20Single%20-%20Namida%20Namida%20Namida%20%5BHirano%20Aya%5D.zip.torrent">[Nipponsei] Hyakko ED Single - Namida Namida Namida [Hirano Aya].zip</a>'));
			$project->setFinished(true);
			$project->setLicense(new License("Wakanim"));
			Project::$allProjects[] = $project;
			
			$project = new Project("tayutama", "Tayutama - Kiss on my Deity -");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Tayutama -Kiss on my Deity-");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.tayutama.com/", "Tayutama.com"));
			$project->setAiringYear(2009);
			$project->setStudio("Silver Link");
			$project->setGenre("Amour et Amitié");
			$project->setSynopsis("L'histoire est centrée sur Yuuri Mito, un étudiant de l'Académie Sousei et le fils unique de l'homme qui dirige le temple Yachimata. À Yachimata, il y a une légende à propos d'une divinité appelée Tayutama-sama qui protégea la région, mais cette divinité et d'autres ainsi nommées \"Tayutai\" ont été oubliées avec le temps. Mito et ses amis découvrent une relique dans le sol de l'école, avec de mystérieux motifs. Dès lors, à la cérémonie d'ouverture de la nouvelle année scolaire, une tout aussi mystérieuse fille appelée Mashiro apparaît devant Mito. Mashiro est d'une certaine manière liée à la relique et à la légende de Tayutama-sama.");
			$project->setVosta('<a href="http://fansubs.anime-share.net/" target="_blank">Anime-Share fansub</a> et Anoymous');
			$project->addBonus(new ProjectBonus("Jaquette(s) DVD", '<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
	<a href="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Label.jpg" target="_blank">
	<img src="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Label.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>'));
			$project->addBonus(new ProjectBonus("Thèmes pour Firefox (Skin Persona)", '<a target="_blank" href="http://www.getpersonas.com/en-US/persona/236444"><img src="http://getpersonas-cdn.mozilla.net/static/4/4/236444/preview.jpg?1277397610" border="0" alt="Tayutama Kiss on my Deity theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/260878"><img src="http://getpersonas-cdn.mozilla.net/static/7/8/260878/preview.jpg?1279817830" border="0" alt="Tayutama Kiss on my Deity theme skin persona mozilla firefox" /></a>'));
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("sketchbook", "Sketchbook ~full colors~");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Sketchbook - full color's");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.sketch-full.net/", "Sketch-full.net"));
			$project->setAiringYear(2007);
			$project->setStudio(Link::newWindowLink("http://www.hal-film.co.jp/", "Hal film maker"));
			$project->setGenre("Comédie");
			$project->setAuthor("Kobako Totan");
			$project->setSynopsis("Nous suivons la vie de Sora, une jeune adolescente très timide et qui, en raison de cela ne parle pas beaucoup. Donnant l’impression de vivre dans sa bulle, cette dernière a une passion pour le dessin. Ce penchant pour l’art l’entraîna à faire partie du club de dessin de son école où elle s’est fait plusieurs amies. Une des particularités de Sora est qu’elle ne quitte jamais son sketchbook afin de pouvoir retranscrire à n’importe quel moment sur papier, un évènement qui l’émerveille. Malheureusement, elle rencontre toujours le même problème, celui de ne jamais pouvoir terminer les dessins qu’elle fait sur des scènes éphémères (chat qui se lèche, feu d’artifice…). Légèrement déprimée à cause de cela, elle retrouve cependant très vite le sourire grâce à des petites choses qui paraissent insignifiantes, nous faisant ainsi partager son univers à la fois poétique et touchant.");
			$project->setVosta('Spoonmoon');
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur la radio.<br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Sketchbook%20~full%20colors~%20sound%20sketch%20book.zip.torrent" target="_blank">[Nipponsei] Sketchbook ~full colors~ sound sketch book.zip	11-21 01:28	130.02 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Sketchbook%20~full%20color%27s~%20OP%20Single%20-%20Kaze%20Sagashi%20%5BKiyoura%20Natsumi%5D.zip.torrent" target="_blank">[Nipponsei] Sketchbook ~full color\'s~ OP Single - Kaze Sagashi [Kiyoura Natsumi].zip	10-24 01:52	43.88 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Sketchbook%20~full%20color%27s~%20ED%20Single%20-%20Sketchbook%20wo%20Motta%20Mama%20%5BMakino%20Yui%5D.zip.torrent" target="_blank">[Nipponsei] Sketchbook ~full color\'s~ ED Single - Sketchbook wo Motta Mama [Makino Yui].zip	10-24 01:52	47.75 MB</a>'));
			$project->setDiscussionUrl('http://zero.xooit.fr/t359-Ton-avis-sur-Sketchbook-full-color-s.htm');
			$project->setFinished(true);
			Project::$allProjects[] = $project;
		}
		
		return Project::$allProjects;
	}
	
	public static function getNonHentaiProjects($getHiddenProjects = false) {
		$projects = array();
		foreach(Project::getAllProjects() as $project) {
			if (!$project->isHentai() && (!$project->isHidden() || $getHiddenProjects)) {
				$projects[] = $project;
			}
		}
		return $projects;
	}
	
	public static function getHentaiProjects($getHiddenProjects = false) {
		$projects = array();
		foreach(Project::getAllProjects() as $project) {
			if ($project->isHentai() && (!$project->isHidden() || $getHiddenProjects)) {
				$projects[] = $project;
			}
		}
		return $projects;
	}
	
	public static function getProject($id) {
		foreach(Project::getAllProjects() as $project) {
			if ($project->getID() === $id) {
				return $project;
			}
		}
		throw new Exception($id." is not a known project ID.");
	}
	
	private static $allLinks = null;
	public static function getAllProjectLinks() {
		if (Project::$allLinks === null) {
			Project::$allLinks = array();
			
			Project::$allLinks[] = array(Project::getProject('eriko'), Project::getProject('kimikiss'));
			Project::$allLinks[] = array(Project::getProject('working'), Project::getProject('working2'));
			Project::$allLinks[] = array(Project::getProject('kissxsis'), Project::getProject('kissxsisoav'));
			Project::$allLinks[] = array(Project::getProject('hyakko'), Project::getProject('hyakkooav'));
			Project::$allLinks[] = array(Project::getProject('toradora'), Project::getProject('toradorasos'));
			Project::$allLinks[] = array(Project::getProject('tayutama'), Project::getProject('tayutamapure'));
			Project::$allLinks[] = array(Project::getProject('sketchbook'), Project::getProject('sketchbookdrama'));
			Project::$allLinks[] = array(Project::getProject('potemayo'), Project::getProject('potemayooav'));
			Project::$allLinks[] = array(Project::getProject('genshiken'), Project::getProject('kujibiki'));
			Project::$allLinks[] = array(Project::getProject('bath'), Project::getProject('training'));
			Project::$allLinks[] = array(Project::getProject('bath'), Project::getProject('sleeping'));
			Project::$allLinks[] = array(Project::getProject('bath'), Project::getProject('akinahshiyo'));
			Project::$allLinks[] = array(Project::getProject('bath'), Project::getProject('hshiyo'));
			Project::$allLinks[] = array(Project::getProject('sleeping'), Project::getProject('training'));
			Project::$allLinks[] = array(Project::getProject('sleeping'), Project::getProject('hshiyo'));
			Project::$allLinks[] = array(Project::getProject('sleeping'), Project::getProject('akinahshiyo'));
			Project::$allLinks[] = array(Project::getProject('akinahshiyo'), Project::getProject('training'));
			Project::$allLinks[] = array(Project::getProject('akinahshiyo'), Project::getProject('hshiyo'));
			Project::$allLinks[] = array(Project::getProject('hshiyo'), Project::getProject('training'));
			Project::$allLinks[] = array(Project::getProject('konoe'), Project::getProject('kodomo'));
			Project::$allLinks[] = array(Project::getProject('konoe'), Project::getProject('kodomooav'));
			Project::$allLinks[] = array(Project::getProject('konoe'), Project::getProject('kodomofilm'));
			Project::$allLinks[] = array(Project::getProject('konoe'), Project::getProject('kodomonatsu'));
			Project::$allLinks[] = array(Project::getProject('konoe'), Project::getProject('kodomo2'));
			Project::$allLinks[] = array(Project::getProject('kodomofilm'), Project::getProject('kodomo'));
			Project::$allLinks[] = array(Project::getProject('kodomofilm'), Project::getProject('kodomooav'));
			Project::$allLinks[] = array(Project::getProject('kodomofilm'), Project::getProject('kodomonatsu'));
			Project::$allLinks[] = array(Project::getProject('kodomofilm'), Project::getProject('kodomo2'));
			Project::$allLinks[] = array(Project::getProject('kodomonatsu'), Project::getProject('kodomo'));
			Project::$allLinks[] = array(Project::getProject('kodomonatsu'), Project::getProject('kodomooav'));
			Project::$allLinks[] = array(Project::getProject('kodomonatsu'), Project::getProject('kodomo2'));
			Project::$allLinks[] = array(Project::getProject('kodomo2'), Project::getProject('kodomo'));
			Project::$allLinks[] = array(Project::getProject('kodomo2'), Project::getProject('kodomooav'));
			Project::$allLinks[] = array(Project::getProject('kodomooav'), Project::getProject('kodomo'));
		}
		
		return Project::$allLinks;
	}
	
	public static function getProjectsLinkedTo(Project $project) {
		$list = array();
		foreach(Project::getAllProjectLinks() as $link) {
			if ($link[0] == $project) {
				$list[] = $link[1];
			}
			else if ($link[1] == $project) {
				$list[] = $link[0];
			}
			else {
				// nothing to do
			}
		}
		
		return $list;
	}
}

class ProjectBonus {
	private $title = null;
	private $content = null;
	
	public function __construct($title, $content) {
		$this->title = $title;
		$this->content = $content;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getContent() {
		return $this->content;
	}
}
?>
