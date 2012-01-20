<?php
/*
	A project is a complete presentation of a specific projet of the team.
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
	private $skins = array();
	private $forumID = null;
	private $vosta = null;
	
	public function __construct($id = null, $name = null) {
		$this->setID($id);
		$this->setName($name);
	}
	
	public function setVosta($vosta) {
		$this->vosta = $vosta;
	}
	
	public function getVosta() {
		return $this->vosta;
	}
	
	public function setForumID($id) {
		$this->forumID = $id;
	}
	
	public function getForumID() {
		return $this->forumID;
	}
	
	public function addSkin($skin) {
		$this->skins[] = $skin;
	}
	
	public function getSkins() {
		return $this->skins;
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
			
			$project = new Project("hyakko", "Hyakko");
			$project->setFinished(true);
			$project->setLicense(new License("Wakanim"));
			Project::$allProjects[] = $project;
			
			$project = new Project("hyakkooav", "Hyakko OAV");
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
			
			$project = new Project("mayoi", "Mayoi Neko Overrun!");
			$project->setStarted(true);
			$project->setRunning(true);
			Project::$allProjects[] = $project;

			$project = new Project("mermaid", "Mermaid Melody Pichi Pichi Pitch");
			$project->setAbandonned(true);
			$project->setLicense(License::getDefaultLicense());
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
			
			$project = new Project("nanami", "Nanami Madobe Windows 7 Publicit&eacute;");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("potemayo", "Potemayo");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("sketchbook", "Sketchbook ~full colors~");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("sketchbookdrama", "Sketchbook ~full colors~ Picture Drama");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("tayutama", "Tayutama - Kiss on my Deity -");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("tayutamapure", "Tayutama - Kiss on my Deity - Pure My Heart");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("toradora", "Toradora!");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("toradorasos", "Toradora! Spécial SOS");
			$project->setFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("working2", "Working!! 2");
			Project::$allProjects[] = $project;
			
			$project = new Project("hshiyo", "Faisons l'amour ensemble !");
			$project->setHentai(true);
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
			$project->addSkin(Link::newWindowLink("http://www.getpersonas.com/en-US/persona/208619", new Image("http://getpersonas-cdn.mozilla.net/static/1/9/208619/preview.jpg?1273490832", "Potemayo theme skin persona mozilla firefox")));
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
?>
