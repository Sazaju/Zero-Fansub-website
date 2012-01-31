<?php
/*
	A team member is a person participating in the team.
*/
class TeamMember {
	private $id = null;
	private $image = null;
	private $pseudo = null;
	private $roles = array();
	private $age = null;
	private $location = null;
	private $mail = null;
	private $website = null;
	private $firstName = null;
	private $isAdmin = false;
	private $hasGone = false;
	private $ponctualMember = false;
	
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
	
	public function setGone($boolean) {
		$this->hasGone = $boolean;
	}
	
	public function hasGone() {
		return $this->hasGone;
	}
	
	public function setImage($imageName) {
		$this->image->setUrl("images/team/".$imageName);
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
	
	public function setPonctualMember($boolean) {
		$this->ponctualMember = $boolean;
	}
	
	public function isPonctualMember() {
		return $this->ponctualMember;
	}
	
	public function setWebsite($url, $name = null) {
		if (is_string($url)) {
			$url = new Url($url);
		}
		if ($url !== null) {
			$this->website = new Link($url, $name);
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
			$member->addRole(Role::getRole("admin"));
			$member->setImage("db0.png");
			$member->setAge(19);
			$member->setLocation("Le Kremlin-Bicetre (94)");
			$member->setMail("db0company@gmail.com");
			$member->setWebsite("http://db0.fr/", "db0.fr");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(2);
			$member->setPseudo("Jembé");
			$member->setImage("jembe.png");
			$member->addRole(Role::getRole("adapt"));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(3);
			$member->setPseudo("Ryuuken");
			$member->setImage("ryuuken.jpeg");
			$member->addRole(Role::getRole("adapt"));
			$member->setGone(true);
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
			$member->addRole(Role::getRole("webadmin"));
			$member->setIsAdmin(true);
			$member->setImage("sazaju.png");
			$member->setMail("sazaju@gmail.com");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(6);
			$member->setPseudo("lepims");
			$member->addRole(Role::getRole("encod"));
			$member->setFirstName("Lepims");
			$member->setAge(25);
			$member->setImage("lepims.gif");
			$member->setLocation("Clermont-Ferrand");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(7);
			$member->setPseudo("DC");
			$member->setImage("dc.jpg");
			$member->addRole(Role::getRole("encod"));
			$member->setFirstName("Denis");
			$member->setAge(24);
			$member->setLocation("Lyon");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(8);
			$member->setPseudo("praia");
			$member->setImage("praia.jpg");
			$member->addRole(Role::getRole("verifFinale"));
			$member->addRole(Role::getRole("qc"));
			$member->addRole(Role::getRole("forumadmin"));
			$member->setIsAdmin(true);
			$member->setFirstName("Piet");
			$member->setAge(30);
			$member->setLocation("Belgique");
			$member->setMail("raiapietro_dam22@hotmail.com");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(9);
			$member->setPseudo("Personne");
			$member->setImage("personne.jpg");
			$member->addRole(Role::getRole("edit"));
			$member->addRole(Role::getRole("kara"));
			$member->setAge(23);
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
			$member->setAge(22);
			$member->setLocation("Marseille");
			$member->setGone(true);
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
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(15);
			$member->setPseudo("Merry-Aime");
			$member->addRole(Role::getRole("tradEn"));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(16);
			$member->setPseudo("Lyf");
			$member->addRole(Role::getRole("check"));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(17);
			$member->setPseudo("Nixy'Z");
			$member->addRole(Role::getRole("qc"));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(18);
			$member->setPseudo("Bk");
			$member->addRole(Role::getRole("encod"));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(19);
			$member->setPseudo("Klick");
			$member->addRole(Role::getRole("help"));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(20);
			$member->setPseudo("Galaf");
			$member->addRole(Role::getRole("kara"));
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(21);
			$member->setPseudo("FinalFan");
			$member->addRole(Role::getRole("time"));
			$member->setPonctualMember(true); // team FinalFanSub
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(22);
			$member->setPseudo("Sky_Lekas");
			$member->addRole(Role::getRole("encod"));
			$member->setPonctualMember(true); // team FinalFanSub
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(23);
			$member->setPseudo("Bkdenice");
			$member->setPonctualMember(true); // autre team
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(24);
			$member->setPseudo("Kurosaki");
			$member->addRole(Role::getRole('tradEn'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(25);
			$member->setPseudo("Kaj");
			$member->addRole(Role::getRole('qc'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(26);
			$member->setPseudo("Baka !");
			$member->addRole(Role::getRole('help'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(27);
			$member->setPseudo("Vegeta");
			$member->addRole(Role::getRole('check'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(28);
			$member->setPseudo("Zorro25");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(29);
			$member->setPseudo("Adeo");
			$member->addRole(Role::getRole('check'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(30);
			$member->setPseudo("Ryocu");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(30);
			$member->setPseudo("Thrax");
			$member->setPonctualMember(true); // autre team
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(31);
			$member->setPseudo("Man-ban");
			$member->addRole(Role::getRole('tradEn'));
			$member->addRole(Role::getRole('time'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(32);
			$member->setPseudo("Thibou");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(33);
			$member->setPseudo("Ryuku");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(34);
			$member->setPseudo("Ed3");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(35);
			$member->setPseudo("Jet9009");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(36);
			$member->setPseudo("Shibo");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(37);
			$member->setPseudo("Suke");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(38);
			$member->setPseudo("B3rning");
			$member->addRole(Role::getRole('encod'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(39);
			$member->setPseudo("Khorx");
			$member->addRole(Role::getRole('time'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(40);
			$member->setPseudo("Pyra");
			$member->addRole(Role::getRole('qc'));
			$member->addRole(Role::getRole('adapt'));
			$member->addRole(Role::getRole('tradEn'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(41);
			$member->setPseudo("Akai_Ritsu");
			$member->addRole(Role::getRole('kara'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(42);
			$member->setPseudo("Benjee");
			$member->addRole(Role::getRole('tradEn'));
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(46);
			$member->setPseudo("Tcho");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(47);
			$member->setPseudo("Ryuseiken71");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(48);
			$member->setPseudo("Kyon");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(49);
			$member->setPseudo("Sunao");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(50);
			$member->setPseudo("Papy Al");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(51);
			$member->setPseudo("Zetsubo Sensei");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(52);
			$member->setPseudo("SwRafael");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(53);
			$member->setPseudo("Basti3n");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(54);
			$member->setPseudo("Inuarth");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(55);
			$member->setPseudo("Constance");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(56);
			$member->setPseudo("Dunkelzahn");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(57);
			$member->setPseudo("LeLapinBlanc");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(58);
			$member->setPseudo("La Mite en Pullover");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(59);
			$member->setPseudo("Kuenchinu");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(60);
			$member->setPseudo("Tohru");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(61);
			$member->setPseudo("youg40");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(62);
			$member->setPseudo("Karta");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(63);
			$member->setPseudo("Jeanba");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(64);
			$member->setPseudo("whatake");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(65);
			$member->setPseudo("Bzou6");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(66);
			$member->setPseudo("Kira");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(67);
			$member->setPseudo("Angel");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(68);
			$member->setPseudo("captainricard");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(69);
			$member->setPseudo("Chakko33");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(70);
			$member->setPseudo("Kurama");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(71);
			$member->setPseudo("Shetan");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(72);
			$member->setPseudo("Aniki");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(73);
			$member->setPseudo("Tarf");
			$member->setGone(true);
			TeamMember::$allMembers[] = $member;
		}
		return TeamMember::$allMembers;
	}
	
	public static function nameSorter(TeamMember $a, TeamMember $b) {
		return strcasecmp($a->getPseudo(), $b->getPseudo());
	}
	
	public static function getMember($id) {
		foreach(TeamMember::getAllMembers() as $member) {
			if ($member->getID() === $id) {
				return $member;
			}
		}
		throw new Exception($id." is not a known member ID.");
	}
	
	public static function getMemberByPseudo($pseudo) {
		foreach(TeamMember::getAllMembers() as $member) {
			if (strcasecmp($member->getPseudo(), $pseudo) == 0) {
				return $member;
			}
		}
		throw new Exception($pseudo." is not a known member pseudonym.");
	}
	
	public static function getAllCurrentMembers() {
		$members = array();
		foreach(TeamMember::getAllMembers() as $member) {
			if (!$member->hasGone() && !$member->isPonctualMember()) {
				$members[] = $member;
			}
		}
		return $members;
	}
}
?>

