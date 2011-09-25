<?php
/*
	A team member is a person participating in the team.
*/
class TeamMember {
	private $image = null;
	private $pseudo = null;
	private $roles = array();
	// TODO replace age by birthDate and calculate age
	private $age = null;
	private $location = null;
	private $mail = null;
	private $website = null;
	private $firstName = null;
	private $isAdmin = false;
	
	public function __construct() {
		$this->image = new Image();
	}
	
	public function setIsAdmin($boolean) {
		$this->isAdmin = $boolean;
	}
	
	public function isAdmin() {
		return $this->isAdmin;
	}
	
	public function setImage($imageName) {
		$this->image->setSource("images/team/".$imageName);
	}
	
	public function getImage() {
		return $this->image;
	}
	
	public function setPseudo($pseudo) {
		$this->pseudo = $pseudo;
		$this->image->setTitle($pseudo);
		$this->image->setAlternative($pseudo);
	}
	
	public function getPseudo() {
		return $this->pseudo;
	}
	
	public function addRole($role) {
		$this->roles[] = $role;
	}
	
	public function getRoles() {
		return $this->roles;
	}
	
	public function hasRole($role) {
		if ($role instanceof Role) {
			$role = $role->getID();
		}
		foreach($this->getRoles() as $currentRole) {
			if ($currentRole->getID() === $role) {
				return true;
			}
		}
		return false;
	}
	
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}
	
	public function getFirstName() {
		return $this->firstName;
	}
	
	public function setAge($age) {
		$this->age = $age;
	}
	
	public function getAge() {
		return $this->age;
	}
	
	public function setLocation($location) {
		$this->location = $location;
	}
	
	public function getLocation() {
		return $this->location;
	}
	
	public function setMail($mail) {
		$this->mail = $mail;
	}
	
	public function getMail() {
		return $this->mail;
	}
	
	public function setWebsite($address, $name = null) {
		if ($address !== null) {
			$this->website = new Link($address, $name);
		}
		else {
			$this->website = null;
		}
	}
	
	public function getWebsite() {
		return $this->website;
	}
	
	private static $allMembers = null;
	public static function getAllMembers() {
		if (TeamMember::$allMembers === null) {
			TeamMember::$allMembers = array();
			
			$member = new TeamMember();
			$member->setPseudo("db0");
			$member->setIsAdmin(true);
			$member->addRole(Role::getRole("verifFinale"));
			$member->addRole(Role::getRole("sorties"));
			$member->setImage("db0.png");
			$member->setAge("19 ans");
			$member->setLocation("Le Kremlin-Bicetre (94)");
			$member->setMail("db0company@gmail.com");
			$member->setWebsite("http://db0.fr/", "db0.fr");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Ryocu");
			$member->setIsAdmin(true);
			$member->setImage("ryocu.png");
			$member->setWebsite("http://anime-ultime.net/", "Anime-Ultime");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Sazaju HITOKAGE");
			$member->addRole(Role::getRole("tradJp"));
			$member->addRole(Role::getRole("adapt"));
			$member->addRole(Role::getRole("torrent"));
			$member->addRole(Role::getRole("xdcc"));
			$member->setImage("sazaju.png");
			$member->setMail("sazaju@gmail.com");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("lepims");
			$member->addRole(Role::getRole("encod"));
			$member->setFirstName("Lepims");
			$member->setAge("25 ans");
			$member->setImage("lepims.png");
			$member->setLocation("Clermont-Ferrand");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("DC");
			$member->setImage("");// TODO http://img8.xooimage.com/files/1/f/5/superman-micro--bfcab6.jpg
			$member->addRole(Role::getRole("encod"));
			$member->setFirstName("Denis");
			$member->setAge("24 ans");
			$member->setLocation("Lyon");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("praia");
			$member->setImage("");// TODO http://img6.xooimage.com/files/a/1/a/komori-kiri-139d03f.jpg
			$member->addRole(Role::getRole("qc"));
			$member->setFirstName("Piet");
			$member->setAge("30 ans");
			$member->setLocation("Belgique");
			$member->setMail("raiapietro_dam22@hotmail.com");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Personne");
			$member->setImage("personne.jpg");
			$member->addRole(Role::getRole("edit"));
			$member->addRole(Role::getRole("kara"));
			$member->setAge("23 ans");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Nyaa-Gentle");
			$member->setImage(""); // TODO http://img7.xooimage.com/files/a/2/2/a22f797271adf8a2...a2577a9-24ccb16.jpeg
			$member->addRole(Role::getRole("time"));
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("ZackDeMars");
			$member->setImage("zack.jpg");
			$member->addRole(Role::getRole("tradEn"));
			$member->setFirstName("Zack");
			$member->setAge("22 ans");
			$member->setLocation("Marseille");
			$member->setMail("Tsuki-Usagi@hotmail.fr");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Shana-chan");
			$member->setImage("shana.png");
			$member->addRole(Role::getRole("tradEn"));
			$member->setFirstName("Guillaume");
			TeamMember::$allMembers[] = $member;

			$member = new TeamMember();
			$member->setPseudo("Onee-chan");
			$member->setImage("onee-chan.jpg");
			$member->addRole(Role::getRole("tradEn"));
			TeamMember::$allMembers[] = $member;

			$member = new TeamMember();
			$member->setPseudo("Litinae");
			$member->setImage("litinae.jpg");
			$member->addRole(Role::getRole("tradEn"));
			TeamMember::$allMembers[] = $member;
		}
		return TeamMember::$allMembers;
	}
}
?>