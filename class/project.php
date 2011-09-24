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
	
	private static $projects = null;
	public static function getAllProjects() {
		if (Project::$projects === null) {
			$project = new Project("canaan", "Canaan");
			$project->setIsFinished(true);
			$project->setIsLicensed(true);
			Project::$projects[] = $project;
			
			$project = new Project("denpa", "Denpa Onna to Seishun Otoko");
			Project::$projects[] = $project;

			$project = new Project("genshiken", "Genshiken 2");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("hitohira", "Hitohira");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("hyakko", "Hyakko");
			$project->setIsFinished(true);
			$project->setIsLicensed(true);
			Project::$projects[] = $project;
			
			$project = new Project("hyakkooav", "Hyakko OAV");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("bath", "Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("sleeping", "S'endormir avec Hinako (Isshoni Sleeping)");
			$project->setIsFinished(true);
			$project->setIsLicensed(true);
			Project::$projects[] = $project;
			
			$project = new Project("training", "L'entra&icirc;nement avec Hinako (Isshoni Training)");
			$project->setIsFinished(true);
			$project->setIsLicensed(true);
			Project::$projects[] = $project;
			
			$project = new Project("kanamemo", "Kanamemo");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("kannagi", "Kannagi");
			$project->setIsFinished(true);
			$project->setIsLicensed(true);
			Project::$projects[] = $project;
			
			$project = new Project("kissxsis", "KissXsis TV");
			$project->setIsRunning(true);
			Project::$projects[] = $project;
			
			$project = new Project("kissxsisoav", "KissXsis OAV");
			$project->setIsRunning(true);
			Project::$projects[] = $project;
			
			$project = new Project("kimikiss", "Kimikiss pure rouge");
			$project->setIsAbandonned(true);
			Project::$projects[] = $project;
			
			$project = new Project("kodomo", "Kodomo no Jikan");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("kodomooav", "Kodomo no Jikan OAV");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("kodomo2", "Kodomo no Jikan ~ Ni Gakki");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("kodomonatsu", "Kodomo no Natsu Jikan");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("kodomofilm", "Kodomo no Jikan Le Film");
			Project::$projects[] = $project;

			$project = new Project("kujibiki", "Kujibiki Unbalance 2");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("mariaholic", "Maria+Holic");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("mayoi", "Mayoi Neko Overrun!");
			Project::$projects[] = $project;

			$project = new Project("mermaid", "Mermaid melody Pichi Pichi Pitch");
			$project->setIsAbandonned(true);
			$project->setIsLicensed(true);
			Project::$projects[] = $project;
			
			$project = new Project("mitsudomoe", "Mitsudomoe");
			$project->setIsRunning(true);
			Project::$projects[] = $project;
			
			$project = new Project("nanami", "Nanami Madobe Windows 7 Publicit&eacute;");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("potemayo", "Potemayo");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("potemayooav", "Potemayo OAV");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("sketchbook", "Sketchbook ~full colors~");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("sketchbookdrama", "Sketchbook ~full colors~ Picture Drama");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("tayutama", "Tayutama - Kiss on my Deity -");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("tayutamapure", "Tayutama - Kiss on my Deity - Pure My Heart");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("toradora", "Toradora!");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("toradorasos", "Toradora! Spécial SOS");
			$project->setIsFinished(true);
			Project::$projects[] = $project;
			
			$project = new Project("working", "Working!!");
			Project::$projects[] = $project;
			
			$project = new Project("working2", "Working!! 2");
			Project::$projects[] = $project;
		}
		
		return Project::$projects;
	}
}
?>
