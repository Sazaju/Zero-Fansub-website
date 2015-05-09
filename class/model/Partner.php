<?php
class Partner {
	private $id = null;
	private $name = null;
	private $websiteUrl = null;
	private $bannerUrl = null;
	private $isFansubPartner = false;
	private $isDb0Company = false;
	private $isOver = false;
	private $isOfficial = false;
	
	public function setOfficial($boolean) {
		$this->isOfficial = $boolean;
	}
	
	public function isOfficial() {
		return $this->isOfficial;
	}
	
	public function setOver($boolean) {
		$this->isOver = $boolean;
	}
	
	public function isOver() {
		return $this->isOver;
	}
	
	public function setDb0Company($boolean) {
		$this->isDb0Company = $boolean;
	}
	
	public function isDb0Company() {
		return $this->isDb0Company;
	}
	
	public function setFansubPartner($boolean) {
		$this->isFansubPartner = $boolean;
	}
	
	public function isFansubPartner() {
		return $this->isFansubPartner;
	}
	
	public function setBannerUrl($url) {
		$this->bannerUrl = new Url($url);
	}
	
	public function getBannerUrl() {
		return $this->bannerUrl;
	}
	
	public function setWebsiteUrl($url) {
		$this->websiteUrl = new Url($url);
	}
	
	public function getWebsiteUrl() {
		return $this->websiteUrl;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
	}
	
	private static $allPartners = null;
	public static function getAllPartners() {
		if (Partner::$allPartners === null) {
			Partner::$allPartners = array();
			
			$partner = new Partner();
			$partner->setID('finalfan');
			$partner->setName("FinalFan sub");
			$partner->setWebsiteUrl('http://finalfan51.free.fr/ffs/');
			$partner->setBannerUrl('images/partenaires/finalfan.png');
			$partner->setFansubPartner(true);
			$partner->setDb0Company(false);
			$partner->setOfficial(true);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('mangas-arigatou');
			$partner->setName("Mangas Arigatou");
			$partner->setWebsiteUrl('http://www.mangas-arigatou.fr/');
			$partner->setBannerUrl('images/partenaires/mangas_arigatou.png');
			$partner->setFansubPartner(true);
			$partner->setDb0Company(false);
			$partner->setOfficial(true);
			$partner->setOver(true);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('kanaii');
			$partner->setName("Kanaii");
			$partner->setWebsiteUrl('http://www.kanaii.com');
			$partner->setBannerUrl('images/partenaires/kanaii.png');
			$partner->setFansubPartner(true);
			$partner->setDb0Company(false);
			$partner->setOfficial(true);
			$partner->setOver(true);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('kouhai');
			$partner->setName("Kouhai Scantrad");
			$partner->setWebsiteUrl('http://kouhaiscantrad.wordpress.com');
			$partner->setBannerUrl('images/partenaires/kouhai.jpg');
			$partner->setFansubPartner(true);
			$partner->setDb0Company(false);
			$partner->setOfficial(true);
			$partner->setOver(true);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('samazama');
			$partner->setName("Samazama na Koto");
			$partner->setWebsiteUrl('http://www.samazama.fr');
			$partner->setBannerUrl('images/partenaires/samazama.gif');
			$partner->setFansubPartner(true);
			$partner->setDb0Company(false);
			$partner->setOfficial(true);
			$partner->setOver(true);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('sky-fansub');
			$partner->setName("Sky-fansub");
			$partner->setWebsiteUrl('http://www.sky-fansub.com/');
			$partner->setBannerUrl('images/partenaires/sky.png');
			$partner->setFansubPartner(true);
			$partner->setDb0Company(false);
			$partner->setOfficial(true);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('anime-ultime');
			$partner->setName("Anime-ultime");
			$partner->setWebsiteUrl('http://www.anime-ultime.net/part/Site-93');
			$partner->setBannerUrl('images/partenaires/anime-ultime.jpg');
			$partner->setFansubPartner(false);
			$partner->setDb0Company(true);
			$partner->setOfficial(true);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('animeka');
			$partner->setName("Animeka");
			$partner->setWebsiteUrl('http://animeka.com/fansub/teams/zero.html');
			$partner->setBannerUrl('images/partenaires/animeka.jpg');
			$partner->setFansubPartner(false);
			$partner->setDb0Company(false);
			$partner->setOfficial(false);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('maboroshi');
			$partner->setName("Maboroshi");
			$partner->setWebsiteUrl('http://japanslash.free.fr');
			$partner->setFansubPartner(true);
			$partner->setDb0Company(false);
			$partner->setOfficial(true);
			$partner->setOver(true);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('kyoutsu');
			$partner->setName("Kyoutsu");
			$partner->setWebsiteUrl('http://kyoutsu-subs.over-blog.com');
			$partner->setFansubPartner(true);
			$partner->setDb0Company(false);
			$partner->setOfficial(true);
			$partner->setOver(true);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('db0company');
			$partner->setName("db0 Company");
			$partner->setWebsiteUrl('http://db0.fr');
			$partner->setFansubPartner(false);
			$partner->setDb0Company(true);
			$partner->setOfficial(true);
			$partner->setOver(true);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('adala-news');
			$partner->setName("Adala News");
			$partner->setWebsiteUrl('http://adala-news.fr/');
			$partner->setBannerUrl('images/partenaires/adala-news.jpg');
			$partner->setOfficial(false);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('icotaku');
			$partner->setName("Icotaku");
			$partner->setWebsiteUrl('http://www.icotaku.com/');
			$partner->setBannerUrl('images/partenaires/icotaku.gif');
			$partner->setOfficial(false);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('anidb');
			$partner->setName("AniDB");
			$partner->setWebsiteUrl('http://anidb.net');
			$partner->setBannerUrl('images/partenaires/anidb.png');
			$partner->setOfficial(false);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('otaku-attitude');
			$partner->setName("Otaku-Attitude");
			$partner->setWebsiteUrl('http://www.otaku-attitude.net/');
			$partner->setBannerUrl('images/partenaires/otaku-attitude.png');
			$partner->setOfficial(false);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('myanimelist');
			$partner->setName("MyAnimeList");
			$partner->setWebsiteUrl('http://myanimelist.net/');
			$partner->setBannerUrl('images/partenaires/myanimelist.png');
			$partner->setOfficial(false);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('sky-animes');
			$partner->setName("Sky-Animes");
			$partner->setWebsiteUrl('http://www.sky-animes.com');
			$partner->setBannerUrl('images/partenaires/sky-animes.gif');
			$partner->setOfficial(false);
			Partner::$allPartners[] = $partner;
			
			$partner = new Partner();
			$partner->setID('chibi-shiba');
			$partner->setName("Chibi Shiba fansub");
			$partner->setWebsiteUrl('http://www.chibi-shiba.fr/');
			$partner->setBannerUrl('images/partenaires/chibi-shiba.png');
			$partner->setOfficial(true);
			$partner->setOver(true);
			Partner::$allPartners[] = $partner;
		}
		return Partner::$allPartners;
	}
	
	public static function getPartner($id) {
		foreach(Partner::getAllPartners() as $partner) {
			if ($partner->getID() === $id) {
				return $partner;
			}
		}
		throw new Exception($id." is not a known partner ID");
	}
}
?>