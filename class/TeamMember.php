<?php
/*
	A team member is a person participating in the team.
*/
class TeamMember {
	private $id = null;
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
	
	public function __construct($id = null) {
		$this->image = new Image();
		$this->setID($id);
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
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
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
			
			$member = new TeamMember(1);
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
			
			$member = new TeamMember(2);
			$member->setPseudo("Jembé");
			$member->setImage("jembe.png");
			$member->addRole(Role::getRole("adapt"));
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(3);
			$member->setPseudo("Ryuuken");
			$member->setImage("ryuuken.jpeg");
			$member->addRole(Role::getRole("adapt"));
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(4);
			$member->setPseudo("Nyaan~");
			$member->setImage("nyaan.png");
			$member->addRole(Role::getRole("time"));
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(5);
			$member->setPseudo("Sazaju HITOKAGE");
			$member->addRole(Role::getRole("tradJp"));
			$member->addRole(Role::getRole("adapt"));
			$member->addRole(Role::getRole("torrent"));
			$member->addRole(Role::getRole("xdcc"));
			$member->setImage("sazaju.png");
			$member->setMail("sazaju@gmail.com");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(6);
			$member->setPseudo("lepims");
			$member->addRole(Role::getRole("encod"));
			$member->setFirstName("Lepims");
			$member->setAge("25 ans");
			$member->setImage("lepims.png");
			$member->setLocation("Clermont-Ferrand");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(7);
			$member->setPseudo("DC");
			$member->setImage("dc.jpg");
			$member->addRole(Role::getRole("encod"));
			$member->setFirstName("Denis");
			$member->setAge("24 ans");
			$member->setLocation("Lyon");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(8);
			$member->setPseudo("praia");
			$member->setImage("praia.jpg");
			$member->addRole(Role::getRole("qc"));
			$member->setFirstName("Piet");
			$member->setAge("30 ans");
			$member->setLocation("Belgique");
			$member->setMail("raiapietro_dam22@hotmail.com");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(9);
			$member->setPseudo("Personne");
			$member->setImage("personne.jpg");
			$member->addRole(Role::getRole("edit"));
			$member->addRole(Role::getRole("kara"));
			$member->setAge("23 ans");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(10);
			$member->setPseudo("Nyaa-Gentle");
			$member->setImage("nyaa-gentle.jpeg");
			$member->addRole(Role::getRole("time"));
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(11);
			$member->setPseudo("ZackDeMars");
			$member->setImage("zack.jpg");
			$member->addRole(Role::getRole("tradEn"));
			$member->setFirstName("Zack");
			$member->setAge("22 ans");
			$member->setLocation("Marseille");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(12);
			$member->setPseudo("Shana-chan");
			$member->setImage("shana.png");
			$member->addRole(Role::getRole("tradEn"));
			$member->setFirstName("Guillaume");
			TeamMember::$allMembers[] = $member;

			$member = new TeamMember(13);
			$member->setPseudo("Onee-chan");
			$member->setImage("onee-chan.jpg");
			$member->addRole(Role::getRole("tradEn"));
			TeamMember::$allMembers[] = $member;

			$member = new TeamMember(14);
			$member->setPseudo("Litinae");
			$member->setImage("litinae.jpg");
			$member->addRole(Role::getRole("tradEn"));
			TeamMember::$allMembers[] = $member;
			
			function sortMembers(TeamMember $a, TeamMember $b) {
				return strcasecmp($a->getPseudo(), $b->getPseudo());
			}
			usort(TeamMember::$allMembers, 'sortMembers');
		}
		return TeamMember::$allMembers;
	}
	
	public static function getMember($id) {
		foreach(TeamMember::getAllMembers() as $member) {
			if ($member->getID() === $id) {
				return $member;
			}
		}
		throw new Exception($id." is not a known member ID.");
	}
}
?>
