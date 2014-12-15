<?php
/*
	A team member is a person participating in the team.
*/
class TeamMember {
	const AVAILABLE = "présent";
	const INACTIVE = "inactif";
	const GONE = "retraité";
	
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
	private $availability = TeamMember::AVAILABLE;
	private $ponctualMember = false;
	
	private static function generateId() {
		// /!\ This works only if the members are added always in the same order !
		// The new ones must be placed at the end !
		static $lastId = 0;
		$lastId++;
		return $lastId;
	}
	
	public function __construct() {
		$this->image = new Image();
		$this->setID(TeamMember::generateId());
	}
	
	public function setIsAdmin($boolean) {
		$this->isAdmin = $boolean;
	}
	
	public function isAdmin() {
		return $this->isAdmin;
	}
	
	public function setAvailability($availability) {
		$this->availability = $availability;
	}
	
	public function getAvailability() {
		return $this->availability;
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
			
			$member = new TeamMember();
			$member->setPseudo("db0");
			$member->setIsAdmin(true);
			$member->addRole(Role::getRole("admin"));
			$member->setImage("db0.png");
			$member->setAge(19);
			$member->setLocation("Le Kremlin-Bicetre (94)");
			$member->setMail("db0company@gmail.com");
			$member->setWebsite("http://db0.fr/", "db0.fr");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Jembé");
			$member->setImage("jembe.png");
			$member->addRole(Role::getRole("adapt"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Ryuuken");
			$member->setImage("ryuuken.jpeg");
			$member->addRole(Role::getRole("adapt"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Nyaan~");
			$member->setImage("nyaan.png");
			$member->addRole(Role::getRole("time"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
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
			
			$member = new TeamMember();
			$member->setPseudo("lepims");
			$member->addRole(Role::getRole("encod"));
			$member->setFirstName("Lepims");
			$member->setAge(25);
			$member->setImage("lepims.gif");
			$member->setLocation("Clermont-Ferrand");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("DC");
			$member->setImage("dc.jpg");
			$member->addRole(Role::getRole("encod"));
			$member->setFirstName("Denis");
			//$member->setAge(24);
			$member->setLocation("Lyon");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("praia");
			$member->setImage("praia.jpg");
			$member->addRole(Role::getRole("ortho"));
			$member->addRole(Role::getRole("qc"));
			$member->addRole(Role::getRole("forumadmin"));
			$member->setIsAdmin(true);
			//$member->setFirstName("Piet");
			//$member->setAge(30);
			$member->setLocation("Belgique");
			//$member->setMail("raiapietro_dam22@hotmail.com");
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Personne");
			$member->setImage("personne.jpg");
			$member->addRole(Role::getRole("edit"));
			$member->addRole(Role::getRole("kara"));
			$member->setAge(23);
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Nyaa-Gentle");
			$member->setImage("nyaa-gentle.jpeg");
			$member->addRole(Role::getRole("time"));
			$member->setAvailability(TeamMember::AVAILABLE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("ZackDeMars");
			$member->setImage("zack.jpg");
			$member->addRole(Role::getRole("tradEn"));
			$member->setFirstName("Zack");
			$member->setAge(22);
			$member->setLocation("Marseille");
			$member->setAvailability(TeamMember::GONE);
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
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;

			$member = new TeamMember();
			$member->setPseudo("Litinae");
			$member->setImage("litinae.jpg");
			$member->addRole(Role::getRole("tradEn"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Merry-Aime");
			$member->setImage("merry.gif");
			$member->addRole(Role::getRole("tradEn"));
			$member->setFirstName("Meriem");
			$member->setAge(17);
			$member->setLocation("Moselle");
			$member->setMail("merry_aime@hotmail.fr");
			$member->setWebsite("http://merry-aime.skyrock.com/", "SkyBlog");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Adeo");
			$member->addRole(Role::getRole("tradEn"));
			$member->addRole(Role::getRole("check"));
			$member->addRole(Role::getRole("qc"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Nixy'Z");
			$member->setFirstName("Maxime");
			$member->addRole(Role::getRole("qc"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Bk");
			$member->addRole(Role::getRole("encod"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Klick");
			$member->setFirstName("Christophe");
			$member->setLocation("Lilles");
			$member->addRole(Role::getRole("help"));
			$member->addRole(Role::getRole("kara"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Galaf");
			$member->addRole(Role::getRole("kara"));
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("FinalFan");
			$member->addRole(Role::getRole("time"));
			$member->setPonctualMember(true); // team FinalFanSub
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Sky_Lekas");
			$member->addRole(Role::getRole("encod"));
			$member->setPonctualMember(true); // team FinalFanSub
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Bkdenice");
			$member->setFirstName("Bruno");
			$member->setLocation("Nice");
			$member->setAge(19);
			$member->addRole(Role::getRole("encod"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Kurosaki");
			$member->addRole(Role::getRole('tradEn'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Kaj");
			$member->setFirstName("Jack");
			$member->addRole(Role::getRole('qc'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Baka !");
			$member->addRole(Role::getRole('help'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Vegeta");
			$member->setImage("vegeta.jpg");
			$member->addRole(Role::getRole('check'));
			$member->setFirstName("Chloé");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Zorro25");
			$member->setFirstName("Alexandre");
			$member->setLocation("Paris");
			$member->addRole(Role::getRole('tradEn'));
			$member->addRole(Role::getRole('check'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Ryocu");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Thrax");
			$member->addRole(Role::getRole('tradEn'));
			$member->addRole(Role::getRole('kara'));
			$member->setPonctualMember(true); // autre team
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Man-ban");
			$member->setImage("manban.jpg");
			$member->setFirstName("Manu");
			$member->setAge(17);
			$member->setLocation("Nice");
			$member->setMail("emmanuel_valat@hotmail.com");
			$member->setWebsite("http://man-ban.1fr1.net/", "Man-Ban's World");
			$member->addRole(Role::getRole('tradEn'));
			$member->addRole(Role::getRole('time'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Thibou");
			$member->setImage("thibou.jpg");
			$member->addRole(Role::getRole('check'));
			$member->setFirstName("Thibault");
			$member->setLocation("Libourne");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Ryuku");
			$member->setFirstName("Jordan");
			$member->setLocation("Nice");
			$member->setMail("sk8ter_du_06@hotmail.fr");
			$member->addRole(Role::getRole('tradEn'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Ed3");
			$member->setImage("ed3.jpg");
			$member->setFirstName("Edouard");
			$member->setLocation("Caen");
			$member->addRole(Role::getRole('check'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Jet9009");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Shibo");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Suke");
			$member->setFirstName("Marvin");
			$member->setLocation("Paris");
			$member->setMail("suke@animekami.eu");
			$member->addRole(Role::getRole('encod'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("B3rning");
			$member->addRole(Role::getRole('encod'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Khorx");
			$member->addRole(Role::getRole('time'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Pyra");
			$member->addRole(Role::getRole('qc'));
			$member->addRole(Role::getRole('adapt'));
			$member->addRole(Role::getRole('tradEn'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Akai_Ritsu");
			$member->addRole(Role::getRole('kara'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Benjee");
			$member->addRole(Role::getRole('tradEn'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Tcho");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Ryuseiken71");
			$member->setImage("ryuseiken.png");
			$member->addRole(Role::getRole('kara'));
			$member->setFirstName("Romain");
			$member->setAge(29);
			$member->setLocation("Chalon sur Saone");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Kyon");
			$member->addRole(Role::getRole('encod'));
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Sunao");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Papy Al");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Zetsubo Sensei");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("SwRafael");
			$member->setImage("swrafael.png");
			$member->addRole(Role::getRole('time'));
			$member->addRole(Role::getRole('tradEn'));
			$member->setFirstName("Rafael Henrique");
			$member->setAge(20);
			$member->setLocation("Lausanne/Suisse");
			$member->setMail("silvel_angel@hotmail.com");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Basti3n");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Inuarth");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Constance");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Dunkelzahn");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("LeLapinBlanc");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("La Mite en Pullover");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Kuenchinu");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Tohru");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("youg40");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Karta");
			$member->setFirstName("Marko");
			$member->setLocation("Nice");
			$member->setMail("karta-siempre@live.fr");
			$member->addRole(Role::getRole('tradEn'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Jeanba");
			$member->setImage("jeanba.jpg");
			$member->addRole(Role::getRole('tradEn'));
			$member->setLocation("Avignon");
			$member->setMail("jeanbaba@live.fr");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("whatake");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Bzou6");
			$member->setFirstName("Rachel");
			$member->setLocation("Nice");
			$member->addRole(Role::getRole('tradEn'));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Kira");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Angel");
			$member->addRole(Role::getRole('tradEn'));
			$member->setFirstName("Ludo");
			$member->setAge(16);
			$member->setLocation("Hyères");
			$member->setMail("angel2948@hotmail.fr");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("captainricard");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Chakko33");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Kurama");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Shetan");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Aniki");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Tarf");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Hikari");
			$member->setImage("hikari.jpg");
			$member->setLocation("France");
			$member->setWebsite("http://www.shimei.fr/", "Shimei.fr");
			$member->setAge(17);
			$member->addRole(Role::getRole("kara"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("Aice5");
			$member->setFirstName("Jerry");
			$member->setImage("aice5.png");
			$member->setLocation("Carcassone");
			$member->addRole(Role::getRole("tradEn"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("smam.jpg");
			$member->setPseudo("ShowMeaManga");
			$member->setFirstName("Daniel");
			$member->addRole(Role::getRole("check"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("AxelRT");
			$member->setPonctualMember(true);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setPseudo("K");
			$member->addRole(Role::getRole("tradEn"));
			$member->setFirstName("Karim");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("vicenzo.png");
			$member->setPseudo("Vicenzo");
			$member->addRole(Role::getRole("clean"));
			$member->addRole(Role::getRole("edit"));
			$member->setFirstName("François");
			$member->setAge(23);
			$member->setLocation("Grasse");
			$member->setMail("woafanyoshi@hotmail.com");
			$member->setWebsite("http://enely-fanlation.fansub.ws/", "Enely-Fanlation");
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("sunako.jpg");
			$member->setPseudo("Sunako");
			$member->addRole(Role::getRole("tradEn"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("yota.jpg");
			$member->setPseudo("Yota");
			$member->addRole(Role::getRole("time"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("mijari.jpg");
			$member->setPseudo("Mijari");
			$member->addRole(Role::getRole("tradEn"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("kupoftea.jpg");
			$member->setPseudo("KupofTea");
			$member->addRole(Role::getRole("graphiste"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("brainstorm27.jpg");
			$member->setPseudo("brainstorm27");
			$member->addRole(Role::getRole("tradEn"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("Cavi.png");
			$member->setPseudo("Cavi");
			$member->addRole(Role::getRole("edit"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("Phantafun.png");
			$member->setPseudo("Phantafun");
			$member->addRole(Role::getRole("adapt"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("BigMoon.jpg");
			$member->setPseudo("BigMoon");
			$member->addRole(Role::getRole("time"));
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("sysmetrix.gif");
			$member->setPseudo("sysmetrix");
			$member->addRole(Role::getRole("adapt"));
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("azy.png");
			$member->setPseudo("Azy");
			$member->addRole(Role::getRole("tradEn"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("Greymantle.jpg");
			$member->setPseudo("Greymantle");
			$member->addRole(Role::getRole("adapt"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("ZaoG.gif");
			$member->setPseudo("ZaoG");
			$member->addRole(Role::getRole("tradEn"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("Uboa.png");
			$member->setPseudo("Uboa");
			$member->addRole(Role::getRole("tradEn"));
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("valderoth.jpeg");
			$member->setPseudo("valderoth");
			$member->addRole(Role::getRole("adapt"));
			$member->addRole(Role::getRole("edit"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("Yasashi.jpg");
			$member->setPseudo("Yasashii");
			$member->addRole(Role::getRole("tradEn"));
			$member->setAvailability(TeamMember::AVAILABLE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("Mystiky.png");
			$member->setPseudo("Mystiky!");
			$member->addRole(Role::getRole("encod"));
			$member->addRole(Role::getRole("edit"));
			$member->setAvailability(TeamMember::AVAILABLE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("Akuma.png");
			$member->setPseudo("Akuma");
			$member->addRole(Role::getRole("kara"));
			$member->addRole(Role::getRole("edit"));
			$member->setAvailability(TeamMember::GONE);
			TeamMember::$allMembers[] = $member;
			
			$member = new TeamMember();
			$member->setImage("ZCK.jpg");
			$member->setPseudo("ZCK");
			$member->addRole(Role::getRole("adapt"));
			$member->setAvailability(TeamMember::AVAILABLE);
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
			if ($member->getAvailability() != TeamMember::GONE && !$member->isPonctualMember()) {
				$members[] = $member;
			}
		}
		return $members;
	}
}
?>