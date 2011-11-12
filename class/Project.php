<?php
/*
	A project is a complete presentation of a specific projet of the team.
*/

class Project {
	private $id = '';
	private $name = '';
	private $isStarted = false;
	private $isRunning = false;
	private $isFinished = false;
	private $isAbandonned = false;
	private $isLicensed = false;
	private $isHentai = false;
	private $isDoujin = false;
	
	public function __construct($id = null, $name = null) {
		$this->setID($id);
		$this->setName($name);
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
	
	public function setIsRunning($boolean) {
		$this->isRunning = $boolean;
		if ($boolean) {
			$this->setIsStarted(true);
			$this->setIsAbandonned(false);
		}
	}
	
	public function isRunning() {
		return $this->isRunning;
	}
	
	public function setIsStarted($boolean) {
		$this->isStarted = $boolean;
	}
	
	public function isStarted() {
		return $this->isStarted;
	}
	
	public function setIsFinished($boolean) {
		$this->isFinished = $boolean;
		if ($boolean) {
			$this->setIsStarted(true);
			$this->setIsRunning(false);
		}
	}
	
	public function isFinished() {
		return $this->isFinished;
	}
	
	public function setIsAbandonned($boolean) {
		$this->isAbandonned = $boolean;
		if ($boolean) {
			$this->setIsRunning(false);
		}
	}
	
	public function isAbandonned() {
		return $this->isAbandonned;
	}
	
	public function setIsLicensed($boolean) {
		$this->isLicensed = $boolean;
	}
	
	public function isLicensed() {
		return $this->isLicensed;
	}
	
	public function setIsHentai($boolean) {
		$this->isHentai = $boolean;
	}
	
	public function isHentai() {
		return $this->isHentai;
	}
	
	public function setIsDoujin($boolean) {
		$this->isDoujin = $boolean;
	}
	
	public function isDoujin() {
		return $this->isDoujin;
	}
	
	private static $allProjects = null;
	public static function getAllProjects() {
		if (Project::$allProjects === null) {
			$project = new Project("canaan", "Canaan");
			$project->setIsFinished(true);
			$project->setIsLicensed(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("denpa", "Denpa Onna to Seishun Otoko");
			Project::$allProjects[] = $project;

			$project = new Project("genshiken", "Genshiken 2");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("hitohira", "Hitohira");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("hyakko", "Hyakko");
			$project->setIsFinished(true);
			$project->setIsLicensed(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("hyakkooav", "Hyakko OAV");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("training", "Isshoni Training - L'entra&icirc;nement avec Hinako");
			$project->setIsFinished(true);
			$project->setIsLicensed(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("bath", "Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("sleeping", "Isshoni Sleeping - S'endormir avec Hinako");
			$project->setIsFinished(true);
			$project->setIsLicensed(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kanamemo", "Kanamemo");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kannagi", "Kannagi");
			$project->setIsFinished(true);
			$project->setIsLicensed(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kissxsis", "KissXsis TV");
			$project->setIsRunning(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kissxsisoav", "KissXsis OAV");
			$project->setIsRunning(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kimikiss", "Kimikiss Pure Rouge");
			$project->setIsAbandonned(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomo", "Kodomo no Jikan");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomooav", "Kodomo no Jikan OAV");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomo2", "Kodomo no Jikan ~ Ni Gakki");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomonatsu", "Kodomo no Natsu Jikan");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomofilm", "Kodomo no Jikan Le Film");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;

			$project = new Project("kujibiki", "Kujibiki Unbalance 2");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("mariaholic", "Maria+Holic");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("mayoi", "Mayoi Neko Overrun!");
			Project::$allProjects[] = $project;

			$project = new Project("mermaid", "Mermaid Melody Pichi Pichi Pitch");
			$project->setIsAbandonned(true);
			$project->setIsLicensed(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("mitsudomoe", "Mitsudomoe");
			$project->setIsRunning(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("nanami", "Nanami Madobe Windows 7 Publicit&eacute;");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("potemayo", "Potemayo");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("potemayooav", "Potemayo OAV");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("sketchbook", "Sketchbook ~full colors~");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("sketchbookdrama", "Sketchbook ~full colors~ Picture Drama");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("tayutama", "Tayutama - Kiss on my Deity -");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("tayutamapure", "Tayutama - Kiss on my Deity - Pure My Heart");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("toradora", "Toradora!");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("toradorasos", "Toradora! Spécial SOS");
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("working", "Working!!");
			Project::$allProjects[] = $project;
			
			$project = new Project("working2", "Working!! 2");
			Project::$allProjects[] = $project;
			
			$project = new Project("akinahshiyo", "Akina To Onsen De H Shiyo !");
			$project->setIsHentai(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("hshiyo", "Faisons l'amour ensemble !");
			$project->setIsHentai(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("alignment", "Alignment You ! You ! The Animation");
			$project->setIsHentai(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("konoe", "Konoe no Jikan");
			$project->setIsHentai(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("eriko", "ERIKO");
			$project->setIsHentai(true);
			$project->setIsDoujin(true);
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("heismymaster", "Ce sont mes Maids");
			$project->setIsHentai(true);
			$project->setIsDoujin(true);
			$project->setIsFinished(true);
			Project::$allProjects[] = $project;
		}
		
		return Project::$allProjects;
	}
	
	public static function getNonHentaiProjects() {
		$projects = array();
		foreach(Project::getAllProjects() as $project) {
			if (!$project->isHentai()) {
				$projects[] = $project;
			}
		}
		return $projects;
	}
	
	public static function getHentaiProjects() {
		$projects = array();
		foreach(Project::getAllProjects() as $project) {
			if ($project->isHentai()) {
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
}
?>
