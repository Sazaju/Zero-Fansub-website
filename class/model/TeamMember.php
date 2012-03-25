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
	
	public function setHasGone($boolean) {
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
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(3);
			$member->setPseudo("Ryuuken");
			$member->setImage("ryuuken.jpeg");
			$member->addRole(Role::getRole("adapt"));
			$member->setHasGone(true);
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
			$member->setHasGone(true);
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
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(15);
			$member->setPseudo("Merry-Aime");
			$member->setImage("merry.gif");
			$member->addRole(Role::getRole("tradEn"));
			$member->setFirstName("Meriem");
			$member->setAge(17);
			$member->setLocation("Moselle");
			$member->setMail("merry_aime@hotmail.fr");
			$member->setWebsite("http://merry-aime.skyrock.com/", "SkyBlog");
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(16);
			$member->setPseudo("Adeo");
			$member->addRole(Role::getRole("tradEn"));
			$member->addRole(Role::getRole("check"));
			$member->addRole(Role::getRole("qc"));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(17);
			$member->setPseudo("Nixy'Z");
			$member->setFirstName("Maxime");
			$member->addRole(Role::getRole("qc"));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(18);
			$member->setPseudo("Bk");
			$member->addRole(Role::getRole("encod"));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(19);
			$member->setPseudo("Klick");
			$member->setFirstName("Christophe");
			$member->setLocation("Lilles");
			$member->addRole(Role::getRole("help"));
			$member->addRole(Role::getRole("kara"));
			$member->setHasGone(true);
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
			$member->setFirstName("Bruno");
			$member->setLocation("Nice");
			$member->setAge(19);
			$member->addRole(Role::getRole("encod"));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(24);
			$member->setPseudo("Kurosaki");
			$member->addRole(Role::getRole('tradEn'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(25);
			$member->setPseudo("Kaj");
			$member->setFirstName("Jack");
			$member->addRole(Role::getRole('qc'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(26);
			$member->setPseudo("Baka !");
			$member->addRole(Role::getRole('help'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(27);
			$member->setPseudo("Vegeta");
			$member->setImage("vegeta.jpg");
			$member->addRole(Role::getRole('check'));
			$member->setFirstName("Chloé");
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(28);
			$member->setPseudo("Zorro25");
			$member->setFirstName("Alexandre");
			$member->setLocation("Paris");
			$member->addRole(Role::getRole('tradEn'));
			$member->addRole(Role::getRole('check'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(30);
			$member->setPseudo("Ryocu");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(30);
			$member->setPseudo("Thrax");
			$member->addRole(Role::getRole('tradEn'));
			$member->addRole(Role::getRole('kara'));
			$member->setPonctualMember(true); // autre team
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(31);
			$member->setPseudo("Man-ban");
			$member->setImage("manban.jpg");
			$member->setFirstName("Manu");
			$member->setAge(17);
			$member->setLocation("Nice");
			$member->setMail("emmanuel_valat@hotmail.com");
			$member->setWebsite("http://man-ban.1fr1.net/", "Man-Ban's World");
			$member->addRole(Role::getRole('tradEn'));
			$member->addRole(Role::getRole('time'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(32);
			$member->setPseudo("Thibou");
			$member->setImage("thibou.jpg");
			$member->addRole(Role::getRole('check'));
			$member->setFirstName("Thibault");
			$member->setLocation("Libourne");
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(33);
			$member->setPseudo("Ryuku");
			$member->setFirstName("Jordan");
			$member->setLocation("Nice");
			$member->setMail("sk8ter_du_06@hotmail.fr");
			$member->addRole(Role::getRole('tradEn'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(34);
			$member->setPseudo("Ed3");
			$member->setImage("ed3.jpg");
			$member->setFirstName("Edouard");
			$member->setLocation("Caen");
			$member->addRole(Role::getRole('check'));
			$member->setHasGone(true);
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
			$member->setFirstName("Marvin");
			$member->setLocation("Paris");
			$member->setMail("suke@animekami.eu");
			$member->addRole(Role::getRole('encod'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(38);
			$member->setPseudo("B3rning");
			$member->addRole(Role::getRole('encod'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(39);
			$member->setPseudo("Khorx");
			$member->addRole(Role::getRole('time'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(40);
			$member->setPseudo("Pyra");
			$member->addRole(Role::getRole('qc'));
			$member->addRole(Role::getRole('adapt'));
			$member->addRole(Role::getRole('tradEn'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(41);
			$member->setPseudo("Akai_Ritsu");
			$member->addRole(Role::getRole('kara'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(42);
			$member->setPseudo("Benjee");
			$member->addRole(Role::getRole('tradEn'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(46);
			$member->setPseudo("Tcho");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(47);
			$member->setPseudo("Ryuseiken71");
			$member->setImage("ryuseiken.png");
			$member->addRole(Role::getRole('kara'));
			$member->setFirstName("Romain");
			$member->setAge(29);
			$member->setLocation("Chalon sur Saone");
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(48);
			$member->setPseudo("Kyon");
			$member->addRole(Role::getRole('encod'));
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
			$member->setImage("swrafael.png");
			$member->addRole(Role::getRole('time'));
			$member->addRole(Role::getRole('tradEn'));
			$member->setFirstName("Rafael Henrique");
			$member->setAge(20);
			$member->setLocation("Lausanne/Suisse");
			$member->setMail("silvel_angel@hotmail.com");
			$member->setHasGone(true);
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
			$member->setFirstName("Marko");
			$member->setLocation("Nice");
			$member->setMail("karta-siempre@live.fr");
			$member->addRole(Role::getRole('tradEn'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(63);
			$member->setPseudo("Jeanba");
			$member->setImage("jeanba.jpg");
			$member->addRole(Role::getRole('tradEn'));
			$member->setLocation("Avignon");
			$member->setMail("jeanbaba@live.fr");
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(64);
			$member->setPseudo("whatake");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(65);
			$member->setPseudo("Bzou6");
			$member->setFirstName("Rachel");
			$member->setLocation("Nice");
			$member->addRole(Role::getRole('tradEn'));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(66);
			$member->setPseudo("Kira");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(67);
			$member->setPseudo("Angel");
			$member->addRole(Role::getRole('tradEn'));
			$member->setFirstName("Ludo");
			$member->setAge(16);
			$member->setLocation("Hyères");
			$member->setMail("angel2948@hotmail.fr");
			$member->setHasGone(true);
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
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(74);
			$member->setPseudo("Hikari");
			$member->setImage("hikari.jpg");
			$member->setLocation("France");
			$member->setWebsite("http://www.shimei.fr/", "Shimei.fr");
			$member->setAge(17);
			$member->addRole(Role::getRole("kara"));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(75);
			$member->setPseudo("Aice5");
			$member->setFirstName("Jerry");
			$member->setImage("aice5.png");
			$member->setLocation("Carcassone");
			$member->addRole(Role::getRole("tradEn"));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(76);
			$member->setImage("smam.jpg");
			$member->setPseudo("ShowMeaManga");
			$member->setFirstName("Daniel");
			$member->addRole(Role::getRole("check"));
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(77);
			$member->setPseudo("AxelRT");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(78);
			$member->setPseudo("K");
			$member->addRole(Role::getRole("tradEn"));
			$member->setFirstName("Karim");
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(79);
			$member->setImage("vicenzo.png");
			$member->setPseudo("Vicenzo");
			$member->addRole(Role::getRole("clean"));
			$member->addRole(Role::getRole("edit"));
			$member->setFirstName("François");
			$member->setAge(23);
			$member->setLocation("Grasse");
			$member->setMail("woafanyoshi@hotmail.com");
			$member->setWebsite("http://enely-fanlation.fansub.ws/", "Enely-Fanlation");
			$member->setHasGone(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember(80);
			$member->setImage("sunako.jpg");
			$member->setPseudo("Sunako");
			$member->addRole(Role::getRole("tradEn"));
			TeamMember::$allMembers[] = $member;
		}
		return TeamMember::$allMembers;
	}
	
	public static function nameSorter(TeamMember $a, TeamMember $b) {
		return strcasecmp($a->getPseudo(), $b->getPseudo());
	}
	
	public static function getMember($id) {
		$id = intval($id);
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