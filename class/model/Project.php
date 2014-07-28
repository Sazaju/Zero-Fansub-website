<?php
/*
	A project is a set of data concerning a specific project (set of releases).
*/
// TODO add features to find identical/similar contents, in order to plan factoring
// TODO when project management is implemented, replace status constants by computation
class Project {
	const INTENDED = 'intended';
	const RUNNING = 'running';
	const PAUSED = 'paused';
	const FINISHED = 'finished';
	const ABANDONNED = 'abandonned';
	
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
	private $status = array();
	private $license = null;
	private $isHentai = false;
	private $isDoujin = false;
	private $isHidden = false;
	private $discussionUrl = null;
	private $vosta = null;
	private $bonuses = array();
	private $coproduction = null;
	private $comment = null;
	
	public function __construct($id = null, $name = null) {
		$this->setID($id);
		$this->setName($name);
	}
	
	public function setComment($comment) {
		$this->comment = $comment;
	}
	
	public function getComment() {
		return $this->comment;
	}
	
	public function setCoproduction($coprod) {
		$this->coproduction = $coprod;
	}
	
	public function getCoproduction() {
		return $this->coproduction;
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
	
	public function setStatus($status, $timestamp) {
		$this->status[] = array($timestamp, $status);
	}
	
	public function getStatus() {
		$timeRef = 0;
		$statusRef = null;
		foreach($this->status as $array) {
			$time = $array[0];
			$status = $array[1];
			if ($timeRef === 0 && $time === null) {// worst case: status with no date
				$statusRef = $status;
			} else if ($time > $timeRef && $time <= $_SESSION[CURRENT_TIME]) {// best case: full status
				$timeRef = $time;
				$statusRef = $status;
			} else {
				continue;
			}
		}
		return $statusRef;
	}
	
	public function isIntended() {
		return $this->getStatus() === Project::INTENDED;
	}
	
	public function isRunning() {
		return $this->getStatus() === Project::RUNNING;
	}
	
	public function isPaused() {
		return $this->getStatus() === Project::PAUSED;
	}
	
	public function isFinished() {
		return $this->getStatus() === Project::FINISHED;
	}
	
	public function isAbandonned() {
		return $this->getStatus() === Project::ABANDONNED;
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
			$project = new Project("haganai", "Boku ha Tomodachi ga Sukunai");
			$project->setOriginalName("Boku ha Tomodachi ga Sukunai");
			$project->setAiringYear(2011);
			$project->setStudio(Link::newWindowLink("http://www.haganai.net/", "Studio AIC"));
			$project->setGenre("Comédie - Ecchi");
			$project->setSynopsis("C'est bien connu, les otakus n'ont pas d'amis. Mais quand on n'en est pas un, ça ne veut pas dire pour autant qu'on en a. Si vous aussi vous avez du mal avec les autres, peut-être vous reconnaitrez-vous dans cette série. Sinon, vous pourrez toujours en profiter pleinement pour découvrir comment s'amuser quand on n'a pas d'amis... ou tout du moins quand on en est convaincus.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2053-Ton-avis-sur-Boku-wa-tomodachi-ga-sukunai.htm");
			$project->setStatus(Project::RUNNING, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("haganaioav", "Boku ha Tomodachi ga Sukunai OAV");
			$project->setOriginalName("Boku ha Tomodachi ga Sukunai OAV");
			$project->setAiringYear(2011);
			$project->setStudio(Link::newWindowLink("http://www.anime-int.com/", "Studio AIC"));
			$project->setGenre("Comédie - Ecchi");
			$project->setSynopsis("Quand on a une bonne bande d'amis, on partage de bons moments ensemble. On organise des pique-niques, chacun apporte son repas, et tout le monde s'amuse avec entrain. Enfin ça, c'est ce qu'on fait quand on a des amis. Mais quand on n'en a pas, que fait-on ? Eh bien, certains essayent de faire comme si... et là, ça peut tourner au génocide. Attention à la crise de foie.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2053-Ton-avis-sur-Boku-wa-tomodachi-ga-sukunai.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomo", "Kodomo no Jikan");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Kodomo no Jikan");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.kojika-anime.com/", "Kojika-anime.com"));
			$project->setAiringYear(2007);
			$project->setStudio(Link::newWindowLink("http://www.stbarcelona.com/", "Studio Barcelona"));
			$project->setGenre("Comédie - Ecchi");
			$project->setAuthor("Watashiya Kaworu");
			$project->setSynopsis("M. Aoki Daisuke sensei est un tout nouvel instituteur en primaire et débute sa carrière dans une classe d'enfants a priori calme, mais il découvrira que même à neuf ans on peut être bien précoce. Il fera la rencontre de Rin Kokonoe, Kuro Kagami et Mimi Usa, trois jeunes filles de sa classe qui sont prêtes à lui apporter bien des soucis, surtout pour la petite Kokonoe. Cette dernière fera tout pour que son sensei chéri tombe amoureux d'elle, comme par exemple des pièges parfois osés, et rendra sa vie de nouvel instituteur très difficile. 
Au fil du temps, Aoki sensei découvrira que tout n'est pas toujours rose dans la vie de ses élèves et fera de son mieux pour les aider à surmonter les problèmes, même s'il met parfois en jeu son poste d'éducateur. Reste à voir dans quelles galères il se mettra, surtout avec le trio Kokonoe, Kagami et Usa.");
			$project->setVosta('<a href="http://www.genjo-subs.net/" target="_blank">Genjo Subs</a> et <a href="http://loli-pop-subs.blogspot.com/" target="_blank">Loli-Pop-Subs</a>');
			$project->setDiscussionUrl("http://forum.zerofansub.net/t252-Ton-avis-sur-Kodomo-no-Jikan.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomooav", "Kodomo no Jikan OAV");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Kodomo no Jikan OVA");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.kojika-anime.com/", "Kojika-anime.com"));
			$project->setAiringYear(2007);
			$project->setStudio(Link::newWindowLink("http://www.stbarcelona.com/", "Studio Barcelona"));
			$project->setGenre("Comédie - Ecchi");
			$project->setAuthor("Watashiya Kaworu");
			$project->setSynopsis("Rin, Kuro et Mimi sont trois adorables petites filles de 10 ans qui découvrent le monde des adultes... C'est l'anniversaire d'Aoki, leur instituteur mais aussi l'amoureux secret de Rin. Celle-ci tente donc de le séduire en lui offrant un cadeau... original.");
			$project->setVosta('<a href="http://www.genjo-subs.net/" target="_blank">Genjo Subs</a>');
			$project->setComment("Si vous souhaitez regarder l'OAV mais aussi la série, il est conseillé de regarder l'OAV entre l'épisode 5 et 6.
Si vous voulez connaître rapidement la série, cet OAV résume bien et on peut le regarder sans voir la série. Mais c'est quand même mieux de regarder la série, évidemment ^^");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t251-Ton-avis-sur----Kodomo-no-Jikan-OAV.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomo2", "Kodomo no Jikan ~ Ni Gakki");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Kodomo no Jikan ~Second Season~");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.kojika-anime.com/", "Kojika-anime.com"));
			$project->setAiringYear(2009);
			$project->setStudio(Link::newWindowLink("http://www.stbarcelona.com/", "Studio Barcelona"));
			$project->setGenre("Comédie - Ecchi");
			$project->setAuthor("Watashiya Kaworu");
			$project->setVosta('<a href="http://loli-pop-subs.blogspot.com/" target="_blank">Loli-Pop-Subs</a>');
			$project->setDiscussionUrl("http://forum.zerofansub.net/t358-Ton-avis-sur-Kodomo-no-Jikan-Saison-2.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomonatsu", "Kodomo no Natsu Jikan");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Kodomo no Jikan - Kodomo no Natsu Jikan");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.kojika-anime.com/", "Kojika-anime.com"));
			$project->setAiringYear(2011);
			$project->setStudio(Link::newWindowLink("http://www.stbarcelona.com/", "Studio Barcelona"));
			$project->setGenre("Comédie - Ecchi");
			$project->setAuthor("Watashiya Kaworu");
			$project->setSynopsis("Rin, Kuro et Mimi sont de retour dans un OAV Spécial de Kodomo no Jikan : Kodomo no Natsu Jikan ! Elles sont toutes les trois absolument adorables dans leurs maillots de bain d'été, en vacances avec Aoki et Houin.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t252-Ton-avis-sur-Kodomo-no-Jikan.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("kodomofilm", "Kodomo no Jikan Le Film");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Kodomo no Jikan - Rin no Gakkyuu Nisshi");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.kojika-anime.com/", "Kojika-anime.com"));
			$project->setAiringYear(2007);
			$project->setStudio(Link::newWindowLink("http://www.stbarcelona.com/", "Studio Barcelona"));
			$project->setGenre("Comédie - Ecchi");
			$project->setAuthor("Watashiya Kaworu");
			$project->setSynopsis("Aoki Daisuke sensei est un tout nouvel instituteur en primaire et débute sa carrière dans une classe d'enfants à priori calme, mais il découvrira que même à 9 ans on peut être bien précoce. Il fera la rencontre de Rin Kokonoe, Kuro Kagami et Mimi Usa, trois jeunes filles de sa classe qui sont prêtes à lui apporter bien des soucis, surtout pour la petite Kokonoe. Cette dernière fera tout pour que son sensei chéri tombe amoureux d'elle, par de nombreux pièges parfois osés, et rendra sa vie de nouvel instituteur très difficile. 
Au fil du temps, Aoki sensei découvrira que tout n'est pas toujours rose dans la vie de ses élèves et fera de son mieux pour les aider à surmonter les problèmes, même s'il met parfois en jeu son poste d'éducateur. Reste à voir dans quelles galères il se mettra, surtout avec le trio Kokonoe, Kagami et Usa.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t252-Ton-avis-sur-Kodomo-no-Jikan.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("mitsudomoe", "Mitsudomoe");
			$project->setOriginalName("Mitsudomoe");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOfficialWebsite(Link::newWindowLink("http://www.mitsudomoe-anime.com/", "Mitsudomoe Anime"));
			$project->setAiringYear(2010);
			$project->setStudio("Bridge");
			$project->setAuthor("Sakurai Norio");
			$project->setGenre("Comédie Ecchi");
			$project->setSynopsis("Les triplées raconte l'histoire de trois filles de primaire un peu perverses qui harcèlent leur prof pas doué.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2051-Ton-avis-sur-Mitsudomoe.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("mitsudomoeoad", "Mitsudomoe OAD");
			$project->setOriginalName("Mitsudomoe OAD");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.mitsudomoe-anime.com/", "Mitsudomoe Anime"));
			$project->setAiringYear(2010);
			$project->setStudio("Bridge");
			$project->setAuthor("Sakurai Norio");
			$project->setGenre("Comédie Ecchi");
			$project->setSynopsis("14e épisode de la série Mitsudomoe.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2051-Ton-avis-sur-Mitsudomoe.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("mitsudomoe2", "Mitsudomoe Zouryouchuu!");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOfficialWebsite(Link::newWindowLink("http://www.mitsudomoe-anime.com/", "Mitsudomoe Anime"));
			$project->setAiringYear(2011);
			$project->setStudio("Bridge");
			$project->setAuthor("Sakurai Norio");
			$project->setGenre("Comédie Ecchi");
			//$project->setSynopsis("La suite des aventures des triplées, .");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2051-Ton-avis-sur-Mitsudomoe.htm");
			$project->setStatus(Project::RUNNING, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("eriko", "ERIKO");
			$project->setOriginalName("ERIKO");
			$project->setAiringYear(2007);
			$project->setAuthor("Gunma Kisaragi");
			$project->setGenre("Hentai");
			$project->setSynopsis("Parodie hentaï de Kimikiss pure rouge mettant en scène Futami Eriko, l'intello, continuant ses expèriences encore plus profondément avec Kazuki.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2052-Ton-avis-sur-ERIKO.htm");
			$project->setHentai(true);
			$project->setDoujin(true);
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("heismymaster", "Ce sont mes Maids");
			$project->setOriginalName("Kore ga Oresama no Maidtachi");
			$project->setAiringYear(2007);
			$project->setAuthor("Yukimihonpo");
			$project->setGenre("Hentai");
			$project->setSynopsis("Parodie hentaï He is my master. Yoshitaka est malade et les médicaments qu'Izumi va lui donner vont le remettre d'aplomb, ainsi que son penis ! Il va tout faire pour avoir Izumi mais va finalement se rattraper sur les deux autres.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2054-Ton-avis-sur-Ce-sont-mes-Maids.htm");
			$project->setHentai(true);
			$project->setDoujin(true);
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("denpa", "Denpa Onna to Seishun Otoko");
			$project->setOriginalName("Denpa Onna To Seishun Otoko");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOfficialWebsite(Link::newWindowLink("http://www.tbs.co.jp/anime/denpa/", "Denpa Onna To Seishun Otoko"));
			$project->setAiringYear(2011);
			$project->setStudio("Shaft");
			$project->setGenre("Fantastique");
			$project->setSynopsis("Niwa Makoto est un lycéen parti vivre chez sa tante car ses parents sont en voyage d'affaires. Il y rencontre une cousine du même âge, inconnue du reste de sa famille, Towa Erio. Cette cousine étrange porte constamment un futon autour du corps, ne se nourrit pratiquement que de pizzas et pense être un extraterrestre.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2046-Ton-avis-sur-Denpa-onna-to-seishun-otoko.htm");
			$project->setStatus(Project::FINISHED, strtotime('2013-08-15 19:12'));
			Project::$allProjects[] = $project;
			
			$project = new Project("sleeping", "Isshoni Sleeping - S'endormir avec Hinako");
			$project->setOriginalName("Isshoni Sleeping");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setAiringYear(2010);
			$project->setGenre("Ecchi");
			$project->setSynopsis("Hinako est de retour ! Après l'effort, le réconfort, et c'est avec elle que vous allez pouvoir vous reposer après les difficiles exercices de musculations du précédent épisode.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2055-Ton-avis-sur-Isshoni-Sleeping-S-endormir-avec-Hinako.htm");
			$project->setStatus(Project::FINISHED, null);
			$project->setLicense(License::getDefaultLicense());
			Project::$allProjects[] = $project;
			
			$project = new Project("bath", "Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko");
			$project->setOriginalName("Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setAiringYear(2011);
			$project->setOfficialWebsite(Link::newWindowLink("http://www.isshoni-training026.com/", "Isshoni Training 026"));
			$project->setStudio("Primaesta");
			$project->setGenre("Ecchi");
			$project->setSynopsis("Prendre un bain avec Hinako, &ccedil;a vous dit ? En plus, elle n'est pas seule : Hiyoko, sa copine loli, vient vous rejoindre.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2056-Ton-avis-sur-Isshoni-Training-Ofuro-Bathtime-with-Hinako-Hiyoko.htm#p50921");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("potemayooav", "Potemayo OAV");
			$project->setOriginalName("Potemayo Special");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOfficialWebsite(Link::newWindowLink("http://www.potemayo.com/", "Potemayo.com"));
			$project->setAiringYear(2008);
			$project->setStudio(Link::newWindowLink("http://www.jcstaff.co.jp/", "JC Staff"));
			$project->setGenre("Comédie");
			$project->setSynopsis("De petites aventures arrivent à Potemayo dans ces épisodes bonus de la série Potemayo.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2057-Ton-avis-sur-Potemayo.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("konoe", "Konoe no Jikan");
			$project->setOriginalName("Konoe no Jikan");
			$project->setAiringYear(2008);
			$project->setGenre("Porno");
			$project->setSynopsis("Parodie pornographique de Kodomo no Jikan.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2058-Ton-avis-sur-Konoe-no-Jikan.htm");
			$project->setHentai(true);
			$project->setStatus(Project::RUNNING, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("akinahshiyo", "Akina To Onsen De H Shiyo !");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Akina To Onsen De H Shiyo");
			$project->setAiringYear(2011);
			$project->setGenre("Hentai");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2059-Ton-avis-sur-Akina-To-Onsen-De-H-Shiyo.htm");
			$project->setHentai(true);
			$project->setStatus(Project::FINISHED, null);
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
			$project->setStatus(Project::INTENDED, null);
			$project->setHentai(true);
			$project->setHidden(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("training", "Isshoni Training - L'entraînement avec Hinako");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Isshoni Training");
			$project->setAiringYear(2009);
			$project->setGenre("Ecchi");
			$project->setSynopsis("Hinako est aspirée dans le monde des mangas alors qu'elle en regardait un à la télévision. C'est ainsi que commence sa vie en tant que personnage d'anime, tandis que le spectateur est sans cesse sollicité pour des exercices physiques de remise en forme, avec une caméra à la première personne.");
			$project->setVosta("Boobz");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t547-Ton-avis-sur-L-entrainement-avec-Hinako-Isshoni-Training.htm");
			$project->setStatus(Project::FINISHED, null);
			$project->setLicense(License::getDefaultLicense());
			Project::$allProjects[] = $project;
			
			$project = new Project("working", "Working!!");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Working!!");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.wagnaria.com/", "Wagnaria.com"));
			$project->setAiringYear(2010);
			$project->setStudio("A-1 Pictures Inc");
			$project->setGenre("Comédie");
			$project->setSynopsis("Takanashi Souta est un lycéen qui a une passion pour les petites choses mignonnes. Quand une fille, Taneshima Popura, l'aborde dans la rue et lui demande si il cherche un travail à mi-temps, il la trouve mignonne car elle ressemble à une collégienne, peut-être même une écolière. Mais il se rend compte quelle a un an de plus que lui. Passant par dessus ce détail, il accepte le travail à mi-temps car elle est toute petite et craquante à souhait. Il commence donc à travailler dans un restaurant familial, mais on peut dire que le personnel est unique ici !");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2045-Ton-avis-sur-Working.htm");
			$project->setStatus(Project::RUNNING, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("working2", "Working!! 2");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Working!! 2");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.wagnaria.com/", "Wagnaria.com"));
			$project->setAiringYear(2011);
			$project->setStudio("A-1 Pictures Inc");
			$project->setGenre("Comédie");
			$project->setSynopsis("Takanashi Souta est un lycéen qui a une passion pour les petites choses mignonnes. Quand une fille, Taneshima Popla, l'aborde dans la rue et lui demande si il cherche un travail à mi-temps, il la trouve mignonne car elle ressemble à une collégienne, peut-être même une écolière. Mais il se rend compte quelle a un an de plus que lui. Passant par dessus ce détail, il accepte le travail à mi-temps car elle est toute petite et craquante à souhait. Il commence donc à travailler dans un restaurant familial, mais on peut dire que le personnel est unique ici !");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2045-Ton-avis-sur-Working.htm");
			$project->setStatus(Project::INTENDED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("hshiyo", "Faisons l'amour ensemble !");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Issho ni H shiyo");
			$project->setAiringYear(2009);
			$project->setGenre("Hentai");
			$project->setSynopsis("Vous avez aimez L'entraînement avec Hinako ? Vous aimerez sûrement sa parodie Hentaï, \"faisons l'amour ensemble\" ! Aujourd'hui, c'est avec vous que notre jolie héroïne fait l'amour... Vous, et vous seul ! Profitez-en ;)");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2061-Ton-avis-sur-Faisons-l-amour-ensemble.htm");
			$project->setHentai(true);
			$project->setStatus(Project::RUNNING, null);
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
			$project->setDiscussionUrl("http://forum.zerofansub.net/t148-Ton-avis-sur-Mermaid-Melody-Pichi-Pichi-Pich-la-serie-en-general.htm");
			$project->setStatus(Project::ABANDONNED, null);
			$project->setLicense(License::getDefaultLicense());
			Project::$allProjects[] = $project;
			
			$project = new Project("nanami", "Nanami Madobe Windows 7 Publicité");
			$project->setOriginalName("Madobe Nanami Windows7 Comercial");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.windows7-mania.jp/", "Windows7 Mania"));
			$project->setAiringYear(2010);
			$project->setStudio("Microsoft");
			$project->setGenre("Publicité");
			$project->setSynopsis("Nanami Madobe te présente Windows 7 et te donne des conseils pour mieux l'utiliser. Elle te montre aussi comment monter ton propre ordinateur.");
			$project->setVosta(Link::newWindowLink("http://bssubs.net/", "BSS"));
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2062-Ton-avis-sur-Nanami-Madobe-Windows-7-Publicite.htm");
			$project->addBonus(new ProjectBonus("ThemePack", "Le thème de Nanami Madobe pour Windows 7 ! Pour l'installer, vous devez avoir Windows 7. Téléchargez le fichier puis double-cliquez dessus pour l'ouvrir. Le thème s'installera tout seul et Nanami vous dira \"Konichiwa ! Nanami desu.\".<br/>
<a href='ddl/[Zero]_Windows_7_Nanami_Madobe_ThemePack.themepack' target='_blank'>
<img src='http://zerofansub.net/images/news/theme_nanami.png' border='0' alt='Themepack Thème Windows 7 de Nanami Madobe à télécharger download gratuit' />
</a>"));
			$project->addBonus(new ProjectBonus("Pack d'images", Link::newWindowLink("http://zerofansub.net/galerie/index.php?spgmGal=Zero_fansub/Images/Nanami%20Madobe", new Image("http://zerofansub.net/images/news/galerie_nanami.png", "Galerie d'images Nanami Madobe"))));
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("potemayo", "Potemayo");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Potemayo");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.potemayo.com/", "Potemayo.com"));
			$project->setAiringYear(2007);
			$project->setStudio(Link::newWindowLink("http://www.jcstaff.co.jp/", "JC Staff"));
			$project->setGenre("Comédie");
			$project->setSynopsis("Sunao Moriyama, se préparant à partir à l'école, ouvre la porte de son frigo afin de déjeuner, or celui-ci tombe nez à nez avec une drôle de créature plus ou moins semblable à un \"bébé\".
Comme s'il n'avait rien vu de spécial, celui-ci ferme la porte sans porter plus d'attention à la créature, en ayant au préalable saisi son déjeuner, celui-ci portant le nom de \"Potemayo\", il surnommera la créature \"Potemayo\".
Et c'est dès lors à ce moment les gags et situations humoristiques apparaissent !");
			$project->setVosta("<a href=\"http://fansubs.anime-share.net/\" target=\"_blank\">Anime-Share fansub</a> et Anoymous");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2057-Ton-avis-sur-Potemayo.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("hyakkooav", "Hyakko OAV");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Hyakko Extra");
			$project->setOfficialWebsite(Link::newWindowLink("http://hyakko.jp/", "Hyakko.jp"));
			$project->setAiringYear(2009);
			$project->setStudio("Nippon Animation");
			$project->setGenre("Comédie");
			$project->setAuthor("Katoh Aruaki");
			$project->setSynopsis("Torako invite Toma dans un café manger des pâtisseries.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2049-Ton-avis-sur-Hyakko-OAD.htm");
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20Original%20Soundtrack.zip.torrent">[Nipponsei] Hyakko Original Soundtrack.zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20OP%20Single%20-%20Suppin%20Rock%20%5BOgawa%20Mana%5D.zip.torrent">[Nipponsei] Hyakko OP Single - Suppin Rock [Ogawa Mana].zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20ED%20Single%20-%20Namida%20Namida%20Namida%20%5BHirano%20Aya%5D.zip.torrent">[Nipponsei] Hyakko ED Single - Namida Namida Namida [Hirano Aya].zip</a>'));
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("mayoi", "Mayoi Neko Overrun!");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Mayoi Neko Overrun!");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.patisserie-straycats.com/", "Patisserie Stray Cats"));
			$project->setAiringYear(2010);
			$project->setStudio(Link::newWindowLink("http://www.anime-int.com/", "Studio AIC"));
			$project->setAuthor("Matsu Tomohiro");
			$project->setGenre("Comédie Ecchi");
			$project->setSynopsis("Takumi Tsuzuki vit avec sa grande sœur Otome bien qu'ils ne soient pas liés par le sang. Otome gère une vieille pâtisserie appelée Stray Cats, où y travaille également une amie d'enfance de Takumi, Fumino Serisawa. C'est alors qu'un jour, Nozomi Kiriya, une jeune fille mystérieuse imitant un chat, apparaît...");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2047-Ton-avis-sur-Mayoi-Neko-Overrun.htm");
			$project->setStatus(Project::RUNNING, null);
			$project->setStatus(Project::FINISHED, strtotime("1 January 2013 00:00"));
			Project::$allProjects[] = $project;
			
			$project = new Project("mayoisp", "Mayoi Neko Overrun! - Spéciaux");
			$project->setOriginalName("Mayoi Neko Overrun! Specials");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.patisserie-straycats.com/", "Patisserie Stray Cats"));
			$project->setAiringYear(2010);
			$project->setStudio(Link::newWindowLink("http://www.anime-int.com/", "Studio AIC"));
			$project->setAuthor("Matsu Tomohiro");
			$project->setGenre("Comédie Ecchi");
			$project->setSynopsis("Ces épisodes sont de petites scènes indépendantes de l'histoire. Pour ceux qui ont le nez fragile, préparez les mouchoirs : saignements de nez au programme.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2047-Ton-avis-sur-Mayoi-Neko-Overrun.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("tayutamapure", "Tayutama - Kiss on my Deity - Pure My Heart");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Tayutama -Kiss on my Deity- Pure My Heart");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.tayutama.com/", "Tayutama.com"));
			$project->setAiringYear(2009);
			$project->setStudio("Silver Link");
			$project->setGenre("Amour et Amitié");
			$project->setSynopsis("Les épisodes Bonus DVD de la série Tayutama -Kiss on my Deity-.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2063-Ton-avis-sur-Tayutama-Kiss-on-my-Deity.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("sketchbookdrama", "Sketchbook ~full colors~ Picture Drama");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Sketchbook - full color's Picture Drama");
			$project->setOfficialWebsite(Link::newWindowLink("http://ani.tv/sketch-full/", "Ani.tv"));
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
			$project->setDiscussionUrl("http://forum.zerofansub.net/t359-Ton-avis-sur-Sketchbook-full-color-s.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("hyakko", "Hyakko");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Hyakko");
			$project->setOfficialWebsite(Link::newWindowLink("http://hyakko.jp/", "Hyakko.jp"));
			$project->setAiringYear(2008);
			$project->setStudio("Nippon Animation");
			$project->setGenre("Comédie");
			$project->setSynopsis("L'école privée Kamizono est un établissement qui possède la particularité d'accueillir en son sein des élèves allant du primaire jusqu'au lycée. De ce fait, son immense structure donne du mal aux nouveaux arrivants pour s'y retrouver. Nonomura Ayumi, jeune étudiante au caractère réservé, arrive à se perdre dès le premier jour de la rentrée. Cherchant désespérément son chemin, elle finit par tomber sur une de ses camarades de classe, Iizuka Tatsuki, qui se trouve être, sans vouloir l'admettre, dans la même situation qu'elle. Après un long moment de marche, toutes les deux voient incrédules deux élèves sautant du deuxième étage d'un bâtiment. C'est ainsi qu'elles font la rencontre de Torako et Suzu, également perdues, mais ayant un moyen infaillible pour atteindre rapidement leur salle de classe : aller de l'avant quel que soit l'obstacle rencontré. Commence alors pour ce nouveau quatuor formé une année scolaire placée sous le signe de l'amitié et de l'humour.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2064-Ton-avis-sur-Hyakko.htm");
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20Original%20Soundtrack.zip.torrent">[Nipponsei] Hyakko Original Soundtrack.zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20OP%20Single%20-%20Suppin%20Rock%20%5BOgawa%20Mana%5D.zip.torrent">[Nipponsei] Hyakko OP Single - Suppin Rock [Ogawa Mana].zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hyakko%20ED%20Single%20-%20Namida%20Namida%20Namida%20%5BHirano%20Aya%5D.zip.torrent">[Nipponsei] Hyakko ED Single - Namida Namida Namida [Hirano Aya].zip</a>'));
			$project->setStatus(Project::FINISHED, null);
			$project->setLicense(new License("Wakanim"));
			Project::$allProjects[] = $project;
			
			$project = new Project("tayutama", "Tayutama - Kiss on my Deity -");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Tayutama -Kiss on my Deity-");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.tayutama.com/", "Tayutama.com"));
			$project->setAiringYear(2009);
			$project->setStudio("Silver Link");
			$project->setGenre("Amour et Amitié");
			$project->setSynopsis("L'histoire est centrée sur Yuuri Mito, un étudiant de l'Académie Sousei et le fils unique de l'homme qui dirige le temple Yachimata. À Yachimata, il y a une légende à propos d'une divinité appelée Tayutama-sama qui protégea la région, mais cette divinité et d'autres ainsi nommées \"Tayutai\" ont été oubliées avec le temps. Mito et ses amis découvrent une relique dans le sol de l'école avec de mystérieux motifs. Dès lors, à la cérémonie d'ouverture de la nouvelle année scolaire, une tout aussi mystérieuse fille appelée Mashiro apparaît devant Mito. Mashiro est d'une certaine manière liée à la relique et à la légende de Tayutama-sama.");
			$project->setVosta('<a href="http://fansubs.anime-share.net/" target="_blank">Anime-Share fansub</a> et Anoymous');
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2063-Ton-avis-sur-Tayutama-Kiss-on-my-Deity.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("sketchbook", "Sketchbook ~full colors~");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Sketchbook - full color's");
			$project->setOfficialWebsite(Link::newWindowLink("http://ani.tv/sketch-full/", "Ani.tv"));
			$project->setAiringYear(2007);
			$project->setStudio(Link::newWindowLink("http://www.hal-film.co.jp/", "Hal film maker"));
			$project->setGenre("Comédie");
			$project->setAuthor("Kobako Totan");
			$project->setSynopsis("Nous suivons la vie de Sora, une jeune adolescente très timide et qui, en raison de cela ne parle pas beaucoup. Donnant l'impression de vivre dans sa bulle, cette dernière a une passion pour le dessin. Ce penchant pour l'art l'entraîna à faire partie du club de dessin de son école où elle s'est fait plusieurs amies. Une des particularités de Sora est qu'elle ne quitte jamais son sketchbook afin de pouvoir retranscrire à n'importe quel moment sur papier un évènement qui l'émerveille. Malheureusement, elle rencontre toujours le même problème, celui de ne jamais pouvoir terminer les dessins qu'elle fait sur des scènes éphémères (chat qui se lèche, feu d'artifice...). Légèrement déprimée à cause de cela, elle retrouve cependant très vite le sourire grâce à des petites choses qui paraissent insignifiantes, nous faisant ainsi partager son univers à la fois poétique et touchant.");
			$project->setVosta('Spoonmoon');
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur la radio.<br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Sketchbook%20~full%20colors~%20sound%20sketch%20book.zip.torrent" target="_blank">[Nipponsei] Sketchbook ~full colors~ sound sketch book.zip	11-21 01:28	130.02 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Sketchbook%20~full%20color%27s~%20OP%20Single%20-%20Kaze%20Sagashi%20%5BKiyoura%20Natsumi%5D.zip.torrent" target="_blank">[Nipponsei] Sketchbook ~full color\'s~ OP Single - Kaze Sagashi [Kiyoura Natsumi].zip	10-24 01:52	43.88 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Sketchbook%20~full%20color%27s~%20ED%20Single%20-%20Sketchbook%20wo%20Motta%20Mama%20%5BMakino%20Yui%5D.zip.torrent" target="_blank">[Nipponsei] Sketchbook ~full color\'s~ ED Single - Sketchbook wo Motta Mama [Makino Yui].zip	10-24 01:52	47.75 MB</a>'));
			$project->setDiscussionUrl('http://forum.zerofansub.net/t359-Ton-avis-sur-Sketchbook-full-color-s.htm');
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("mariaholic", "Maria+Holic");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Maria+Holic");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.mariaholic.com/", "MariaHolic.com"));
			$project->setAiringYear(2009);
			$project->setStudio(Link::newWindowLink("http://www.genco.co.jp/", "Genco"));
			$project->setGenre("Comédie - Déjanté - Ecchi");
			$project->setAuthor("Endou Minari");
			$project->setSynopsis("Au milieu de l'année scolaire, Kanako est une adolescente qui décide de venir étudier dans un établissement pour filles : Ame no Kisaki. En faisant ceci, cette dernière espère avoir autant de chance en amour que ses parents qui s'y sont rencontrés (sa mère était une élève et son père un enseignant). Néanmoins, due à sa grande taille, Kanako n'a jamais pu imaginer entretenir une vraie relation avec un garçon et s'est finalement rendue compte qu'elle n'était attirée que par la gente féminine.
Alors qu'elle cherche son chemin, elle tombe sous le charme d'une étudiante accompagnée de sa servante et répondant au nom de Mariya. Après avoir fait connaissance, cette dernière lui indique le lieu où se situe le dortoir et lui donne rendez vous un peu plus tard dans la journée pour lui servir de guide à travers l'établissement. Cependant, le moment venu, Kanako découvre par hasard la vraie « nature » de Mariya qui, si celle-ci était découverte, suffirait à l'exclure de l'école. Afin que Kanako garde le secret, Mariya exploite vicieusement les penchants yuri que cette dernière tente de dissimuler et la force à rester près d'elle pour la surveiller. Ne pouvant faire face, Kanako lui obéit en devenant sa camarade de chambre et voit son espoir ardant de trouver son étoile promise s'amincir...");
			$project->setVosta('<a href="http://www.ggkthx.org/" target="_blank">GG</a>');
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Maria%20Holic%20Soundtrack%20no%20Kikikata%202.zip.torrent" target="_blank">[Nipponsei] Maria Holic Soundtrack no Kikikata 2.zip	03-12 00:55	110.03 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Maria%20Holic%20Soundtrack%20no%20Kikikata%201.zip.torrent" target="_blank">[Nipponsei] Maria Holic Soundtrack no Kikikata 1.zip	03-12 00:55	126.31 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Maria%20Holic%20OP%20Single%20-%20HANAJI%20%5BKobayashi%20Yuu%5D.zip.torrent" target="_blank">[Nipponsei] Maria Holic OP Single - HANAJI [Kobayashi Yuu].zip	02-10 20:38	39.02 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Maria%20Holic%20ED%20Single%20-%20Kimi%20ni%2C%20Mune%20Kyun.%20%5BVarious%5D.zip.torrent" target="_blank">[Nipponsei] Maria Holic ED Single - Kimi ni, Mune Kyun. [Various].zip</a>'));
			$project->addBonus(new ProjectBonus("Divers", '<img src="images/icones/bonus.png" alt="Bonus" /> <a href="ddl/%5bKanaii-Zero%5d_Maria+Holic_Ending_Creditless_+_Opening_%5bHQ%5d.zip">Les Ending et Opening Creditless</a><br />
<img src="images/icones/bonus.png" alt="Bonus" /> <a href="http://www.megaupload.com/?d=NB2ZP0E1">Les jaquettes et images bonus des DVD</a><br />
<img src="images/icones/bonus.png" alt="Bonus" /> <a href="http://www.megaupload.com/?d=6SV5980U">Les ED Quad (X264)</a><br />
<img src="images/icones/bonus.png" alt="Bonus" /> <a href="ddl/%5bKanaii-Zero%5d_HANAJI_Maria+Holic_OP_%5bX264_1280x720%5d.mp4">Clip de l\'Opening Hanaji</a>'));
			$project->addBonus(new FirefoxPersonaBonus(array(126094, 93715), $project->getName()." theme firefox"));
			$project->setDiscussionUrl('http://forum.zerofansub.net/t476-Ton-avis-sur-Maria-Holic.htm');
			$project->setStatus(Project::FINISHED, null);
			//$project->setLicense(new License("Docomo"));
			Project::$allProjects[] = $project;
			
			$project = new Project("kanamemobook", "Kanamemo");
			$project->setOriginalName("Kanamemo");
			$project->setGenre("Comédie - Déjanté - Ecchi");
			$project->setSynopsis("Kana vient tout juste de perdre sa grand-mère et seule famille, la laissant seule au monde. Après avoir fuit une horde de déménageurs à l'air sournois (du moins pour son petit esprit hermétique à toute réflexion), elle entreprend de chercher un travail, ce qu'elle réussit plus ou moins à trouver au sein d'une petite entreprise de livraison de journaux...");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2065-Ton-avis-sur-Kanamemo-Scans.htm");
			$project->setStatus(Project::RUNNING, null);
			$project->setDoujin(true);
			Project::$allProjects[] = $project;
			
			$project = new Project("kanamemo", "Kanamemo");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Kanamemo");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.starchild.co.jp/special/kanamemo/", "Starchild"));
			$project->setAiringYear(2009);
			$project->setStudio("Feel - Starchild Records");
			$project->setGenre("Comédie - Déjanté - Ecchi");
			$project->setAuthor("Iwami Shouko");
			$project->setSynopsis("Kana vient tout juste de perdre sa grand-mère et seule famille, la laissant seule au monde. Après avoir fuit une horde de déménageurs à l'air sournois (du moins pour son petit esprit hermétique à toute réflexion), elle entreprend de chercher un travail, ce qu'elle réussit plus ou moins à trouver au sein d'une petite entreprise de livraison de journaux...");
			$project->setVosta('Underwater');
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2048-Ton-avis-sur-Kanamemo.htm");
			$project->addBonus(new ProjectBonus("Jaquette(s) DVD", '<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
<a href="images/cover/[Zero]Kanamemo_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]Kanamemo_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>'));
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kanamemo%20Character%20Song%20%26%20Soundtrack%20Album%20-%20Kanamero.zip.torrent">[Nipponsei] Kanamemo Character Song &amp; Soundtrack Album - Kanamero.zip</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kanamemo%20ED%20Single%20-%20YAHHO%21%21%20%5BHorie%20Yui%5D.zip.torrent">[Nipponsei] Kanamemo ED Single - YAHHO!! [Horie Yui].zip</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kanamemo%20OP%20Single%20-%20Kimi%20he%20to%20Tsunagu%20Kokoro%20%5BVarious%5D.zip.torrent">[Nipponsei] Kanamemo OP Single - Kimi he to Tsunagu Kokoro [Various].zip</a>'));
			$project->addBonus(new ProjectBonus("Images & Wallpaper", ' <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=0#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image01.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image01.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=1#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image02.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image02.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=2#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image03.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image03.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=3#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image04.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image04.jpg" class="img-thumbnail" width="150" height="150"/></a>    
 <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=4#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image05.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image05.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=5#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image06.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image06.jpg" class="img-thumbnail" width="150" height="150"/></a>     
    <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=6#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image07.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image07.jpg" class="img-thumbnail" width="150" height="150"/></a>    
  <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=7#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image08.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image08.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=8#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image09.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image09.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=9#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image10.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image10.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=10#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image11.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image11.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=11#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image12.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image12.jpg" class="img-thumbnail" width="150" height="150"/></a>     
    <a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kanamemo&amp;spgmPic=12#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image13.jpg" alt="galerie/gal/Zero_fansub/Images/Kanamemo/_thb_[Zero]Kanamemo_Image13.jpg" class="img-thumbnail" width="150" height="150"/></a>'));
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("toradorasos", "Toradora! Spécial SOS");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Toradora! Special");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.starchild.co.jp/special/toradora/", "Toradora"));
			$project->setAiringYear(2009);
			$project->setStudio(Link::newWindowLink("http://www.genco.co.jp/", "Genco"));
			$project->setGenre("Comédie - Amour et Amitié");
			$project->setAuthor("Takemiya Yuyuko");
			$project->setSynopsis("Ami, Taiga et Ryuuji décident d'aller chez Jonny's pour y goûter les spaghettis Tarako, sur place ils retrouvent Minori, et la dégustation culinaire vire au duel...");
			$project->setCoproduction(Link::newWindowLink("http://japanslash.free.fr", new Image("http://japanslash.free.fr/images/bannieres/naishi.png", "Maboroshi no fansub")));
			$project->setDiscussionUrl("http://forum.zerofansub.net/t357-Ton-avis-sur-Toradora.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("toradora", "Toradora!");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Toradora!");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.starchild.co.jp/special/toradora/", "Toradora"));
			$project->setAiringYear(2008);
			$project->setStudio(Link::newWindowLink("http://www.genco.co.jp/", "Genco"));
			$project->setGenre("Comédie - Amour et Amitié");
			$project->setAuthor("Takemiya Yuyuko");
			$project->setSynopsis("En raison de son regard menaçant hérité de son père, Takasu Ryuuji est un adolescent craint car considéré comme un délinquant par les autres élèves de son lycée. Cette image étant à l'opposé de ce qu'il est réellement, ce dernier aimerait s'en séparer définitivement afin de ne plus souffrir des conséquences qui en découlent. Ryuuji ne perd pas espoir d'y arriver grâce notamment à son ami Kitamura qui, en plus d'avoir vu clair dans cette mésentente, lui a permis de rencontrer Kushieda Minori dont il est tombé amoureux. Alors qu'il pense à elle, il bouscule par mégarde Asaika Taiga, une élève de sa classe et amie de Minori dont le mauvais caractère n'a d'égal que sa force. Suite à un concours de circonstances, Ryuuji apprendra qu'Aisaka est sa nouvelle voisine et que cette dernière est amoureuse de Kitamura. Se développe alors entre les deux une relation ambiguë dans le but de se rapprocher des personnes respectives aimées.");
			$project->setVosta('<a href="http://www.ggkthx.org/" target="_blank">GG</a>');
			$project->setCoproduction(Link::newWindowLink("http://japanslash.free.fr", new Image("http://japanslash.free.fr/images/bannieres/naishi.png", "Maboroshi no fansub")));
			$project->setDiscussionUrl("http://forum.zerofansub.net/t357-Ton-avis-sur-Toradora.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("toradorabento", "Toradora! OAD");
			$project->setOriginalName("Toradora! Bentou no Gokui");
			$project->setAiringYear(2011);
			$project->setGenre("Comédie - Amour et Amitié");
			$project->setAuthor("Takemiya Yuyuko");
			$project->setSynopsis("Faire un bentô peut être compliqué. Ce doit être un repas équilibré, permettant de tenir tout l'après-midi. Ryuuji le sait bien, après tout il met un point d'honneur à ce que ses bentôs soient digne d'un étudiant en pleine croissance... Oui mais voilà, Yuusaku se trouve être secondé par sa grand-mère dans cette tâche. Grand-mère qui, au passage, semble maîtriser fort bien l'art du repas en boîte. Ryuuji tentera dès lors de faire valoir ses capacités de cuisinier... Par tous les moyens.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t357-Ton-avis-sur-Toradora.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("kujibiki", "Kujibiki Unbalance II");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Kujibiki Unbalance 2006");
			$project->setOfficialWebsite(Link::newWindowLink("http://kujian.info/index.html", "Kujian.info"));
			$project->setAiringYear(2006);
			$project->setStudio(Link::newWindowLink("http://www.genco.co.jp/", "Genco"));
			$project->setGenre("Comédie");
			$project->setAuthor("Kio Shimoku");
			$project->setSynopsis("C'est la rentrée pour Chihiro et Tokino. Un tirage au sort est organisé pour déterminer les rôles de chacun au sein de l'établissement. Chihiro, connu pour être malchanceux, semble avoir tiré le gros lot... ou pas.");
			$project->setVosta('Yu');
			$project->addBonus(new ProjectBonus("La Saison 1", "Ces deux \"saisons\" n'ont rien à voir l'une avec l'autre. Ce sont les mêmes personnages et la même histoire (pas tout à fait) mais raconté différemment. Pas besoin d'avoir vu la saison 1 pour voir la saison 2. Même si vous n'avez pas aimé la saison 1, vous aimerez peut-être la saison 2 et inversement ! Il faut donc les voir comme deuz séries complètement différentes.<br />
Les 3 épisodes de la saison 1 sont disponibles en Bonus sur le DVD de Genshiken. C'est Kaze qui a acquit la licence.<br />
<div class=\"center\"><a href=\"http://www.kaze.fr/boutique/fiche_produit.php?p=e56b06c51e1049195d7b26d043c478a0&typeproduit=1\" target=\"_blank\"><img src=\"http://www.kaze.fr/images/boutique/produits/images/genshiken_integrale_collector.jpg\" alt=\"DVD Genshiken Kaze\" /></a></div>"));
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Genshiken%20%26%20Kujibiki%20Unbalance%20Best%20Album%20-%20Songs%20for%20Young%20%26%20Silly%20Age.zip.torrent">[Nipponsei] Genshiken &amp; Kujibiki Unbalance Best Album - Songs for Young &amp; Silly Age.zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kujibiki%20Unbalance%20Kaichou%20Mini%20Album%20-%20Forget%20%5BKoshimizu%20Ami%5D.zip.torrent">[Nipponsei] Kujibiki Unbalance Kaichou Mini Album - Forget [Koshimizu Ami].zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kujibiki%20Unbalance%20Original%20Soundtrack.zip.torrent">[Nipponsei] Kujibiki Unbalance Original Soundtrack.zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kujibiki%20Unbalance%20ED%20Single%20-%20Harmonies%20%5BNonaka%20Ai%20%26%20Koshimizu%20Ami%5D.zip.torrent">[Nipponsei] Kujibiki Unbalance ED Single - Harmonies [Nonaka Ai &amp; Koshimizu Ami].zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kujibiki%20Unbalance%20OP%20Single%20-%20Ai%20%5BAtsumi%20Saori%5D.zip.torrent">[Nipponsei] Kujibiki Unbalance OP Single - Ai [Atsumi Saori].zip</a>'));
			$project->addBonus(new ProjectBonus("Jaquette(s) DVD", '<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
<a href="images/cover/[Zero]Kujibiki_Unbalance2_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]Kujibiki_Unbalance2_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>'));
			$project->addBonus(new ProjectBonus("Images & Wallpaper", ' <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=0#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image01.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image01.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=1#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image02.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image02.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=2#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image03.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image03.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=3#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image04.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image04.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=4#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image05.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image05.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=5#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image06.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image06.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=6#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image07.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image07.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=7#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image08.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image08.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=8#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image09.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image09.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=9#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image10.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image10.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=10#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image11.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image11.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=11#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image12.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image12.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=12#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image13.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image13.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=13#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image14.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image14.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kujibiki%20Unbalance&amp;spgmPic=14#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kujibiki%20Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image15.jpg" alt="gal/Zero_fansub/Images/Kujibiki Unbalance/_thb_[Zero]Kujibiki_Unbalance_Image15.jpg" class="img-thumbnail" width="150" height="150"/></a>'));
			$project->setDiscussionUrl("http://forum.zerofansub.net/t253-Ton-avis-sur-Kujibiki-Unbalance-2006.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("genshiken", "Genshiken II");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Genshiken 2");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.genshiken.info/", "Genshiken.info"));
			$project->setAiringYear(2007);
			$project->setStudio(Link::newWindowLink("http://www.genco.co.jp/", "Genco"));
			$project->setGenre("Comédie");
			$project->setAuthor("Kio Shimoku");
			$project->setSynopsis("L'ancien président du club Genshiken ayant eu son diplôme l'année dernière, Sasahara se voit nommer par les autres membres pour lui succéder. En ce début d'année, la venue de deux nouvelles personnes au sein du club s'accompagne d'une autre bonne surprise. En effet, nos fidèles otakus ont reçu pour la première fois l'autorisation de participer au Comi-Fes (convention de jap'anime). L'équipe en effervescence décide de créer un doujinshi qu'Ohno vendra en tenue de cosplay. Ogiue quant à elle montre qu'elle possède un talent assez étonnant pour le dessin. Grâce à cela, il ne reste au club plus qu'à prévoir les divers préparatifs matériels et financiers nécessaires pour le jour J. Toujours dans la bonne humeur et l'amusement, les membres de Genshiken semblent ainsi faire un nouveau pas dans l'univers des otakus.");
			$project->setVosta('<a href="http://dattebayo.com/" target="_blank">Dattebayo US</a>');
			$project->addBonus(new ProjectBonus("La Saison 1", '<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/autre/genshikendvd.jpg" border="0" width="100"/><img src="http://www.discountmanga.fr/images/927754.pid.jpg" border="0" width="100"/>
</div>
<b>Résumé</b> La rentrée des classes a enfin lieu et Sasahara, jeune étudiant timide, se décide à intégrer une association. Le choix se révèle particulièrement ardu pour notre héros et finalement, celui-ci va rejoindre le Genshiken ("Gendai Shikaku Bunka Kenkyuu Kai"), un club où se retrouve de jeunes otakus. Sasahara, qui ne peut encore admettre qu\'il en est un, va peu à peu découvrir le monde si particulier des otakus et trouver sa véritable place parmi ces jeunes passionnés de mangas et de jeux vidéos...<br />
La saison 1 de Genshiken est licenciée en France par <a href="http://www.kaze.fr/" target="_blank">Kaze</a>.<br />
<b>Commander la saison 1 en dvd !</b><br />
<ul>
<li><a href="http://www.discountmanga.fr/DVD+Anime/Genshiken+Integrale+Collector,p936135.html" target="_blank">Genshiken - Intégrale collector (Coffret Collector 4 DVD) <b>48.99</b></a></li>
<li><a href="http://www.discountmanga.fr/DVD+Anime/Genshiken+Coffret+VOVF+1+2,p927498.html" target="_blank">Genshiken VF Box.1 (Coffret Pack 2 DVD) épisodes 1 à 6 + 2 OAV Kujibiki Unbalance <b>41.99</b></a></li>
<li><a href="http://www.discountmanga.fr/DVD+Anime/Genshiken+Coffret+VOVF+2+2,p927754.html" target="_blank">Genshiken VF Box.2 (Coffret Pack 2 DVD) épisodes 7 à 12 + 1 OAV Kujibiki Unbalance <b>41.99</b></a></li>
</ul>
'));
			$project->addBonus(new ProjectBonus("Le manga", '<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/autre/genshikenmanga.jpg" border="0"/>
</div>
<b>Résumé</b> Kanji Sasahara rentre en première année à l\'université S. Grand fan de mangas et d\'animes, il recherche un club étudiant où il pourrait partager cette passion. Un seul semble lui convenir : le « club d\'étude de la culture visuelle moderne » aussi appelé Genshiken. Malgré sa timidité maladive, il tente d\'en apprendre plus sur les activités proposées par ce club. Il va à la rencontre des adhérents, d\'authentiques otakus, qui le piègent et lui font passer un test avant de l\'accueillir officiellement. Le jeune homme va alors découvrir un univers où prône la connaissance des mangas et des jeux vidéo, un véritable parcours initiatique à travers la sous-culture contemporaine nippone.<br />
<b>Commander les mangas !</b><br />
<ul>
<li><a href="http://www.discountmanga.fr/Mangas+VF/Genshiken,p927469.html" target="_blank">Tome 1 <b>6.55</b></a></li>
<li><a href="http://www.discountmanga.fr/Mangas+VF/Genshiken,p927470.html" target="_blank">Tome 2 <b>6.55</b></a></li>
<li><a href="http://www.discountmanga.fr/Mangas+VF/Genshiken,p927471.html" target="_blank">Tome 3 <b>6.55</b></a></li>
<li><a href="http://www.discountmanga.fr/Mangas+VF/Genshiken,p930295.html" target="_blank">Tome 4 <b>6.55</b></a></li>
<li><a href="http://www.discountmanga.fr/Mangas+VF/Genshiken,p933386.html" target="_blank">Tome 5 <b>6.55</b></a></li>
<li><a href="http://www.discountmanga.fr/Mangas+VF/Genshiken,p937336.html" target="_blank">Tome 6 <b>6.55</b></a></li>
<li><a href="http://www.discountmanga.fr/Mangas+VF/Genshiken,p939954.html" target="_blank">Tome 7 <b>6.55</b></a></li>
</ul>
'));
			$project->addBonus(new ProjectBonus("Divers", '<div class="p" style="text-align:left;">Pack de Bonus comprenant :<br />
<ul>
<li>Diverses images,</li>
<li>Des photos de cosplay,</li>
<li>Les screenshots des épisodes,</li>
<li>Les musiques de l\'opening et de l\'ending,</li>
<li>Une jaquette dvd pour décorer vos dvds gravé.</li>
</ul>
[ <a href="ddl/[Zero]Genshiken_2_Pack_Bonus.zip">Télécharger le pack !</a> ]</div>'));
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Genshiken%202%20Original%20Soundtrack.zip.torrent" target="_blank">[Nipponsei] Genshiken 2 Original Soundtrack.zip	02-09 02:21	143.30 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Genshiken%20%26%20Kujibiki%20Unbalance%20Best%20Album%20-%20Songs%20for%20Young%20%26%20Silly%20Age.zip.torrent" target="_blank">[Nipponsei] Genshiken & Kujibiki Unbalance Best Album - Songs for Young & Silly Age.zip	12-23 18:00	127.25 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Genshiken%202%20ED%20Single%20-%20Clubhouse%20Sandwich%20%5BYuumao%5D.zip.torrent" target="_blank">[Nipponsei] Genshiken 2 ED Single - Clubhouse Sandwich [Yuumao].zip	11-08 21:44	45.59 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Genshiken%202%20OP%20Single%20-%20disarm%20dreamer%20%5BMisato%20Aki%5D.zip.torrent" target="_blank">[Nipponsei] Genshiken 2 OP Single - disarm dreamer [Misato Aki].zip	10-24 01:51	47.29 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20OVA%20Genshiken%20OP%20Single%20-%20Seishun%20to%20Shite%20%5Bmanzo%5D.zip.torrent" target="_blank">[Nipponsei] OVA Genshiken OP Single - Seishun to Shite [manzo].zip	01-16 06:00	33.03 MB</a>'));
			$project->addBonus(new ProjectBonus("Images & Wallpaper", '<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=0#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image01.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image01.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=1#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image02.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image02.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=2#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image03.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image03.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="
galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=3#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image04.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image04.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=4#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image05.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image05.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=5#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image06.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image06.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=6#
spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image07.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image07.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=7#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image08.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image08.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=8#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image09.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image09.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=9#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/
_thb_[Zero]Genshiken_Image10.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image10.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Genshiken&amp;spgmPic=10#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image11.jpg" alt="galerie/gal/Zero_fansub/Images/Genshiken/_thb_[Zero]Genshiken_Image11.jpg" class="img-thumbnail" width="150" height="150"/></a>'));
			$project->setDiscussionUrl("http://forum.zerofansub.net/t254-Ton-avis-sur-Genshiken-II.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("canaan", "Canaan");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Canaan");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.canaan.jp/", "Canaan.jp"));
			$project->setAiringYear(2009);
			$project->setStudio("PA Works");
			$project->setGenre("Enigme et Policier");
			$project->setSynopsis("Deux journalistes, Mino-san et sa partenaire sont envoyés pour couvrir un évènement culturel dans la ville de Shanghai. En raison de certaines circonstances cette dernière se retrouve seule au milieu de cette manifestation festive. Elle sera alors brutalement mêlée à une situation critique au mauvais endroit, au mauvais moment mais c'est alors que surgit Canaan, une jeune mercenaire victime de guerre.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2066-Ton-avis-sur-Canaan.htm");
			$project->addBonus(new ProjectBonus("Jaquette(s) DVD", '<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
	<a href="images/cover/[Zero]Canaan_Cover01.jpg" target="_blank">
	<img src="images/cover/[Zero]Canaan_Cover01.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Canaan_Cover02.jpg" target="_blank">
	<img src="images/cover/[Zero]Canaan_Cover02.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Canaan_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]Canaan_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Canaan_Label.jpg" target="_blank">
	<img src="images/cover/[Zero]Canaan_Label.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>'));
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Canaan%20Inspired%20Album.zip.torrent">[Nipponsei] Canaan Inspired Album.zip</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Canaan%20Insert%20Song%20Single%20-%20China%20Kibun%20de%20High%20Tension%21%20%5BTakagaki%20Ayahi%5D.zip.torrent">[Nipponsei] Canaan Insert Song Single - China Kibun de High Tension! [Takagaki Ayahi].zip</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Canaan%20ED%20Single%20-%20My%20heaven%20%5BAnnabel%5D.zip.torrent">[Nipponsei] Canaan ED Single - My heaven [Annabel].zip</a>'));
			$project->addBonus(new FirefoxPersonaBonus(array(82036, 124946), $project->getName()." theme firefox"));
			$project->addBonus(new ProjectBonus("Wallpaper & Images", '<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=0#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image1.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image1.jpg" class="img-thumbnail" width="150" height="150"/></a><a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=1#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image10.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image10.jpg" class="img-thumbnail" width="150" height="150"/></a> <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=2#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image11.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image11.jpg" class="img-thumbnail" width="150" height="150"/></a><a target="_blank" href="galerie/
index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=3#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image12.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image12.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=4#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image13.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image13.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=5#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image14.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image14.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=6#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image15.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image15.jpg" class="img-thumbnail" width="150" height="150"/></a> 
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=7#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image16.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image16.jpg" class="img-thumbnail-selected" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=8#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image17.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image17.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=9#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image18.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image18.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=10#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image19.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image19.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=11#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image2.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image2.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=12#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image20.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image20.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=13#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image21.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image21.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=14#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image22.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image22.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=15#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image23.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image23.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=16#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image24.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image24.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=17#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image25.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image25.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=18#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image26.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image26.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=19#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image27.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image27.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=20#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image28.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image28.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=21#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image29.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image29.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=22#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image3.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image3.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=23#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image30.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image30.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=24#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image31.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image31.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=25#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image32.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image32.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=26#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image33.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image33.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=27#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image34.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image34.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=28#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image4.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image4.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=29#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image5.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image5.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=30#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image6.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image6.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=31#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image7.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image7.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=32#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image8.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image8.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Canaan&amp;spgmPic=33#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image9.jpg" alt="gal/Zero_fansub/Images/Canaan/_thb_[Zero]Canaan_Image9.jpg" class="img-thumbnail" width="150" height="150"/></a>'));
			$project->setStatus(Project::FINISHED, null);
			$project->setLicense(License::getDefaultLicense());
			Project::$allProjects[] = $project;
			
			$project = new Project("kissxsis", "KissXsis TV");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Kiss×sis (2010)");
			$project->setOfficialWebsite(Link::newWindowLink("http://kc.kodansha.co.jp/kiss_sis/", "kc.kodansha.co.jp/kiss_sis"));
			$project->setAiringYear(2010);
			$project->setStudio("Feel - Starchild Records");
			$project->setGenre("Comédie Ecchi");
			$project->setAuthor("Ditawa Bow");
			$project->setSynopsis("Keita a deux grandes demi-sœurs, Ako et Riko, mais puisqu'ils ne sont pas liés par le sang, elles l'aiment d'une façon assez lascive. Après une infortune à l'école, Ako et Riko lui avouent finalement leur amour. Keita n'aime pas la pensée d'être plus que frère et sœur, mais comme il essaye d'entrer à la même école que ses sœurs, il devient lentement attiré par elles.");
			$project->setVosta("Subdesu");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t384-Ton-avis-sur-Kiss-X-Sis.htm");
			$project->setStatus(Project::RUNNING, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("kissxsisoav", "KissXsis OAD");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Kiss×sis");
			$project->setOfficialWebsite(Link::newWindowLink("http://kc.kodansha.co.jp/kiss_sis/", "kc.kodansha.co.jp/kiss_sis"));
			$project->setAiringYear(2008);
			$project->setStudio("Feel");
			$project->setGenre("Ecchi");
			$project->setAuthor("Ditawa Bow");
			$project->setSynopsis("Ako et Riko sont deux sœurs jumelles. Toutes les deux sont amoureuses de leur demi-frère, Keita, avec qui elles n'ont aucun lien de sang.");
			$project->setVosta("Anonymous et AKFDP");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t384-Ton-avis-sur-Kiss-X-Sis.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("hitohira", "Hitohira");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Hitohira");
			$project->setOfficialWebsite(Link::newWindowLink("http://web.peex.jp/hitohira/", "Peex Hitohira"));
			$project->setAiringYear(2007);
			$project->setStudio(Link::newWindowLink("http://www.genco.co.jp/", "Genco"));
			$project->setGenre("Comédie - Amour et Amitié");
			$project->setAuthor("Kirihara Izumi");
			$project->setSynopsis("Asai Mugi est une fille très introvertie qui vient d'entrer dans le lycée des arts Kumakata pour suivre son amie Kayo. 
Sa timidité maladive, lorsque la situation la dépasse, lui fait perdre la voix ou la fait s'évanouir. 
Bien des péripéties vont la conduire à s'inscrire dans un club... de théâtre. Ichinose Nono, Nishida Risaki, Katsuigari Takashi et Nishida Kai sont les membres de la sociéte de recherche dramatique où vient de s'inscrire Mugi. 
Mais elle n'est pas au bout de ses peines, car les deux clubs de théâtre de l'école se mènent une guerre ouverte dans laquelle elle finira par se faire embarquer. 
Devenir actrice de théâtre en étant pleurnicharde et sans volonté... c'est impossible.");
			$project->setVosta('<a href="http://starlight-subs.com/" target="_blank">Starlight Subs</a>');
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hitohira%20Original%20Drama%20%26%20BGM%20Album%20Vol.2%20-%20Nono%20Hen.zip.torrent" target="_blank">[Nipponsei] Hitohira Original Drama & BGM Album Vol.2 - Nono Hen.zip	06-27 00:37	164.95 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hitohira%20Original%20Drama%20%26%20BGM%20Album%20Vol.1%20-%20Mugi%20Hen.zip.torrent" target="_blank">[Nipponsei] Hitohira Original Drama & BGM Album Vol.1 - Mugi Hen.zip	05-31 06:12	170.08 MB</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Hitohira%20OP%20ED%20Single%20-%20Yume%2C%20Hitohira%20%5BAsami%20Yuuko%20%26%20Mizuhashi%20Mai%5D.zip.torrent" target="_blank">[Nipponsei] Hitohira OP ED Single - Yume, Hitohira [Asami Yuuko & Mizuhashi Mai].zip	04-25 03:17	45.22 MB	</a>'));
			$project->addBonus(new ProjectBonus("Scantrad (Manga)", 'Ces mangas sont traduits par l\'équipe de Scantrad Française J-Garden. <a href="http://j-garden.kif.fr/hitohira-p20268" target="_blank"><img style="border: none;" src="http://idata.over-blog.com/0/59/73/61/Manga-zaki/Mz-V2/Menu/Partenaires/J-Garden.png" alt="J-Garden"/></a><br />
Si vous aimez leur travail, allez les remercier sur leur site !<br /><br />
<img src="http://img189.imageshack.us/img189/8461/couvhitohira.png" alt="Hitohira tome1" style="float:right;"/>
<a href="http://download44.mediafire.com/ytcveycxmazg/44znzmcjnor/%5BJ-Garden%5D+hitohira+vol.1+Pr%C3%A9lude.rar">Prélude</a><br />
<a href="http://www.mediafire.com/?wiuigjmiqnj">Chapitre 01</a><br />
<a href="http://www.mediafire.com/?k5mtzwizmme">Chapitre 02</a><br />'));
			$project->addBonus(new FirefoxPersonaBonus(array(219081), $project->getName()." theme firefox"));
			$project->addBonus(new ProjectBonus("Images & Wallpaper", '<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=0#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image01.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image01.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=1#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image02.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image02.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=2#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image03.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image03.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.
php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=3#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image04.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image04.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=4#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image05.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image05.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=5#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image06.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image06.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=6#spgmPicture" class=""><img src="
galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image07.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image07.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=7#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image08.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image08.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=8#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image09.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image09.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=9#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image10.jpg" alt="galerie/
gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image10.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=10#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image11.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image11.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=11#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image12.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image12.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=12#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image13.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image13.jpg" class="img-
thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=13#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image14.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image14.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=14#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image15.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image15.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=15#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image16.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image16.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_
fansub/Images/Hitohira&amp;spgmPic=16#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image17.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image17.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=17#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image18.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image18.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=18#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image19.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image19.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=19#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image20.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image20.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=20#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image21.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image21.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=21#
spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image22.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image22.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=22#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image23.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image23.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=23#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image24.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image24.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=24#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]
Hitohira_Image25.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image25.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=25#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image26.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image26.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=26#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image27.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image27.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=27#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image28.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image28.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=28#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image29.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image29.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=29#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image30.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image30.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=30#
spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image31.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image31.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=31#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image32.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image32.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=32#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image33.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image33.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=33#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]
Hitohira_Image34.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image34.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=34#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image35.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image35.jpg" class="img-thumbnail" width="150" height="150"/></a><a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=35#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image36.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image36.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Hitohira&amp;spgmPic=36#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image37.jpg" alt="galerie/gal/Zero_fansub/Images/Hitohira/_thb_[Zero]Hitohira_Image37.jpg" class="img-thumbnail" width="150" height="150"/></a>'));
			$project->setDiscussionUrl("http://forum.zerofansub.net/t145-Ton-avis-sur-Hitohira-la-serie-en-general.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("kannagi", "Kannagi");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("Kannagi: Crazy Shrine Maidens");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.nagisama-fc.com/anime/", "Nagisama-fc.com"));
			$project->setAiringYear(2008);
			$project->setStudio("Aniplex - Sony Music ent. Visual Works - A-1 Pictures Inc.");
			$project->setGenre("Fantastique - Comédie");
			$project->setSynopsis("Un jeune lycéen voit sa vie basculer le jour où la statue qu'il a sculpté se transforme en une ravissante jeune fille. Le bois de sa sculpture provenait en fait d'un arbre sacré habité par une déesse du nom de Nagi, celle-ci était là dans le but de veiller sur le quartier. Jin devra dorénavant héberger Nagi chez lui, mais la jeune fille n'a pas caractère facile.");
			$project->setComment("Le 14e épisode (spécial) est disponible [project=kannagioad]ici[/project].");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2067-Ton-avis-sur-Kannagi.htm");
			$project->setStatus(Project::FINISHED, null);
			//$project->setLicense(License::getDefaultLicense());
			Project::$allProjects[] = $project;
			
			$project = new Project("kannagioad", "Kannagi OAD");
			$project->setOriginalName("Kannagi: Crazy Shrine Maidens");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.nagisama-fc.com/anime/", "Nagisama-fc.com"));
			$project->setAiringYear(2008);
			$project->setStudio("Aniplex - Sony Music ent. Visual Works - A-1 Pictures Inc.");
			$project->setGenre("Fantastique - Comédie");
			$project->setSynopsis("C'est le 14ème épisode de la série Kannagi.");
			$project->setDiscussionUrl("http://forum.zerofansub.net/t2067-Ton-avis-sur-Kannagi.htm");
			$project->setStatus(Project::FINISHED, null);
			Project::$allProjects[] = $project;
			
			$project = new Project("kimikiss", "Kimikiss Pure Rouge");
			$project->setExternalSource(Link::newWindowLink("http://animeka.com/fansub/teams/zero.html", "Animeka"));
			$project->setOriginalName("KimiKiss Pure Rouge");
			$project->setOfficialWebsite(Link::newWindowLink("http://www.kimikiss-pure-rouge.jp/", "kimikiss-pure-rouge.jp"));
			$project->setAiringYear("2007-08");
			$project->setStudio(Link::newWindowLink("http://www.jcstaff.co.jp/", "JC Staff"));
			$project->setGenre("Amour et Amitié");
			$project->setSynopsis("Après avoir passé deux années en France, Mao jeune étudiante, décide de revenir seule dans sa ville natale au Japon pour finir ses études. Elle y retrouve ainsi ses deux amis d'enfance : Sanada Kouichi, chez lequel elle résidera et Aihara Kazuki. Le trio ainsi réunit compte bien partager ensemble d'aussi agréables moments qu'à l'époque. Le temps ayant passé, Mao va vite comprendre que les histoires de cœur sont devenus d'actualité pendant son absence. En effet, alors que Aihara semble avoir une relation ambiguë avec une élève considérée comme un génie, Sanada quant à lui, a l'air d'éprouver des sentiments pour Hoshino, une camarade de classe. Mao ne voulant pas être en reste décide alors d'intervenir afin de les aider à atteindre leur bonheur.");
			$project->setVosta('<a href="http://www.bssubs.net" target="_blank">BSS</a>');
			$project->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />

<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20Character%20CD8%20-%20Kuryuu%20Megumi%20%5BNakahara%20Mai%5D.zip.torrent">[Nipponsei] kimikiss pure rouge Character CD8 - Kuryuu Megumi [Nakahara Mai].zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20Character%20CD7%20-%20Kawada%20Tomoko%20%5BKawasumi%20Ayako%5D.zip.torrent">[Nipponsei] kimikiss pure rouge Character CD7 - Kawada Tomoko [Kawasumi Ayako].zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20Character%20CD6%20-%20Aihara%20Nana%20%5BNogawa%20Sakura%5D.zip.torrent">[Nipponsei] kimikiss pure rouge Character CD6 - Aihara Nana [Nogawa Sakura].zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20Character%20CD5%20-%20Shijou%20Mitsuki%20%5BNoto%20Mamiko%5D.zip.torrent">[Nipponsei] kimikiss pure rouge Character CD5 - Shijou Mitsuki [Noto Mamiko].zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20Character%20Song%20Album.zip.torrent">[Nipponsei] kimikiss pure rouge Character Song Album.zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20Character%20CD4%20-%20Satonaka%20Narumi%20%5BMizuhashi%20Kaori%5D.zip.torrent">[Nipponsei] kimikiss pure rouge Character CD4 - Satonaka Narumi [Mizuhashi Kaori].zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20Original%20Soundtrack.zip.torrent">[Nipponsei] kimikiss pure rouge Original Soundtrack.zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20Character%20CD3%20-%20Sakino%20Asuka%20%5BHirohashi%20Ryou%5D.zip.torrent">[Nipponsei] kimikiss pure rouge Character CD3 - Sakino Asuka [Hirohashi Ryou].zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20Character%20CD2%20-%20Hoshino%20Yumi%20%5BKoshimizu%20Ami%5D.zip.torrent">[Nipponsei] kimikiss pure rouge Character CD2 - Hoshino Yumi [Koshimizu Ami].zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20KimiKiss%20pure%20rouge%20ED2%20Single%20-%20Wasurenaide%20%5BSuara%5D.zip.torrent">[Nipponsei] KimiKiss pure rouge ED2 Single - Wasurenaide [Suara].zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20Character%20CD1%20-%20Mizusawa%20Mao%20%5BIkezawa%20Haruna%5D.zip.torrent">[Nipponsei] kimikiss pure rouge Character CD1 - Mizusawa Mao [Ikezawa Haruna].zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20ED%20Single%20-%20Negai%20Hoshi%20%5BSnow%5D.zip.torrent">[Nipponsei] kimikiss pure rouge ED Single - Negai Hoshi [Snow].zip</a>
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20kimikiss%20pure%20rouge%20OP%20Single%20-%20Aozora%20Loop%20%5Bmarble%5D.zip.torrent">[Nipponsei] kimikiss pure rouge OP Single - Aozora Loop [marble].zip</a>'));
			$project->addBonus(new ProjectBonus("Scantrad (Manga)", 'Ces mangas sont traduits par l\'équipe de Scantrad Française Fuyu No Yo <a href="http://www.fuyunoyo.com" target="_blank"><img style="border: none;" src="http://www.fuyunoyo.com/ban8831.jpg" alt="Fuyu no Yo"/></a> et Tengoku <a href="http://tengoku.team.free.fr/" target="_blank"><img style="border: none;" src="http://mahojapan.free.fr/img/partenaires/logo_Tengoku.gif" alt="Tengoku"/></a><br />
Si vous aimez leur travail, allez les remercier sur leurs sites !<br /><br />
<img src="http://www.fuyunoyo.com/samples/vignettes/kkiss01.jpg" alt="Kimikiss tome1" style="float:right;"/>
Mao 1st KISS : <a href="http://www.megaupload.com/?d=NSE7FM30"><b>Un vieil ami d\'enfance</b></a><br />
Mao 2nd KISS : <a href="http://www.megaupload.com/?d=EZ4Z1402"><b>Deuxième baiser</b></a><br />
Mao 3rd KISS : <a href="http://www.4shared.com/file/7iOxZPOC/Shinjou_KimiKiss_-_Various_Heroines_vol01_chap03.html"><b>Ma chambre, Mao-Neechan et moi</b></a><br />
Mao 4th KISS : <a href="http://www.4shared.com/file/gAycowuJ/Shinjou_KimiKiss_-_Various_Heroines_vol01_chap04.html"><b>Une intruse en pyjama</b></a><br />
Mao 5th KISS : <a href="http://www.4shared.com/file/AdXekjos/Shinjou_KimiKiss_-_Various_Heroines_vol01_chap05.html"><b>J\'ai mangé Kôichi</b></a><br />
Mao 6th KISS : <a href="http://www.4shared.com/file/FqdMTD2A/KtShinjou_KimiKiss_Various_Heroines-vol01_ch06.html"><b>Les tests de Mao sont enfin terminés</b></a><br />
Mao 7th KISS : <a href="http://www.4shared.com/file/_oBCu9Ju/KtShinjou_KimiKiss_Various_Heroines-vol01_ch07.html"><b>Leur fête de l\'école à eux deux</b></a><br />
Mao 8th KISS : <a href="http://www.4shared.com/file/KXP63myn/KtShinjou_KimiKiss_Various_Her.htmlKtShinjou_KimiKiss_Various_Heroines-vol01_ch08.html"><b>Promesse</b></a><br />
Extra KISS : <a href="http://www.4shared.com/file/DholXrXB/KtShinjou_KimiKiss_Various_Heroines-vol01_extra.html"><b>Sans compter</b></a><br />
<br />
<img src="http://www.fuyunoyo.com/samples/vignettes/kkiss02.jpg" alt="Kimikiss tome2" style="float:right;"/>
Asuka 1st KISS : <a href="http://www.4shared.com/file/mxtLJdq4/KtShinjou_KimiKiss_Various_Heroines-vol02_ch09.html"><b>Le goût de Sakino-San</b></a><br />
Asuka 2nd KISS : <a href="http://www.4shared.com/file/gRm6Lt64/KtShinjou_KimiKiss_Various_Heroines-vol02_ch10.html"><b>Le changement de direction d\'Asuka</b></a><br />
Asuka 3rd KISS : <a href="http://www.4shared.com/file/-V0G_-QV/ShinjouTT_KimiKiss_Various_Heroines-vol02_ch11.html"><b>Partager un parapluie</b></a><br />
Asuka 4th KISS : <a href="http://www.4shared.com/file/jTEqmPHs/ShinjouTT_KimiKiss_Various_Heroines-vol02_ch12.html"><b>Coach en amour&nbsp;!</b></a><br />
Asuka 5th KISS : <a href="http://www.4shared.com/file/8fUdIboy/ShinjouTT_KimiKiss_Various_Heroines-vol02_ch13.html"><b>À l\'aide, coach&nbsp;!</b></a><br />
Asuka 6th KISS : <a href="http://www.4shared.com/file/-u1hr6-J/ShinjouTT_KimiKiss_Various_Heroines-vol02_ch14.html"><b>Un baiser au goût de soda</b></a><br />
Asuka 7th KISS : <a href="http://www.4shared.com/file/mH_YCOPg/ShinjouTT_KimiKiss_Various_Heroines-vol02_ch15.html"><b>Peux-tu venir avec moi&nbsp;?</b></a><br />
Asuka 8th KISS : <a href="http://www.4shared.com/file/BK_agptX/ShinjouTT_KimiKiss_Various_Heroines-vol02_ch16.html"><b>Je t\'aime...</b></a><br />
Asuka 9th KISS : <a href="http://www.4shared.com/file/fBGZCeRg/ShinjouTT_KimiKiss_Various_Heroines-vol02_ch17.html"><b>À toi de tirer</b></a><br />
<br />
<img src="images/autre/kimi3.jpg" alt="Kimikiss tome3" style="float:right;"/>
Mizuki 1st KISS : <a href="http://www.mediafire.com/?lmmhnwu44mg"><b>Télécharger</b></a><br />
Mizuki 2nd KISS : <a href="http://www.mediafire.com/?ozyyzxn5gz0"><b>Télécharger</b></a><br />
Mizuki 3rd KISS : <a href="http://www.mediafire.com/?dl5ttzm1yku"><b>Télécharger</b></a><br />
Mizuki 4th KISS : <a href="http://www.mediafire.com/?m1adm1zaeem"><b>Télécharger</b></a><br />
Mizuki 5th KISS : <a href="http://www.mediafire.com/?xrlhgjjnmei"><b>Télécharger</b></a><br />
Mizuki 6th KISS : <a href="http://www.mediafire.com/download.php?e3jmnrrmnzt"><b>Télécharger</b></a><br />
Mizuki 7th KISS : <a href="http://www.mediafire.com/?wynxjyrma1m"><b>Télécharger</b></a><br />'));
			$project->addBonus(new FirefoxPersonaBonus(array(105649), $project->getName()." theme firefox"));
			$project->addBonus(new ProjectBonus("Images & Wallpaper", '<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=0#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image01.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image01.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=1#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image02.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image02.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=2#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image03.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image03.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=3#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image04.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image04.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=4#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image05.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image05.jpg" class="img-thumbnail" width="150" height="150"/></a><a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=5#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image06.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image06.jpg" class="img-thumbnail" width="150" height="150"/></a><a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=6#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image07.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image07.jpg" class="img-thumbnail" width="150" height="150"/></a><a target="_blank" href="galerie/index.
php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=7#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image08.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image08.jpg" class="img-thumbnail" width="150" height="150"/></a><a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=8#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image09.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image09.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=9#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image10.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image10.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=10#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image11.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image11.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=11#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image12.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image12.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=12#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image13.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image13.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=13#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image14.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image14.jpg" class="img-thumbnail" width="150" height="150"/></a>
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=14#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image15.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image15.jpg" class="img-thumbnail" width="150" height="150"/></a>
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=15#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image16.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image16.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=16#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image17.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image17.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=17#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image18.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image18.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=18#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image19.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image19.jpg" class="img-thumbnail" width="150" height="150"/></a>    
 <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=19#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image20.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image20.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=20#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image21.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image21.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=21#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image22.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image22.jpg" class="img-thumbnail" width="150" height="150"/></a>    
  <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=22#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image23.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image23.jpg" class="img-thumbnail" width="150" height="150"/></a>    
  <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=23#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image24.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image24.jpg" class="img-thumbnail" width="150" height="150"/></a>    
 <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=24#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image25.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image25.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=25#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image26.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image26.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=26#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image27.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image27.jpg" class="img-thumbnail" width="150" height="150"/></a>
	<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=27#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image28.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image28.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=28#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image29.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image29.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=29#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image30.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image30.jpg" class="img-thumbnail" width="150" height="150"/></a>    
 <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=30#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image31.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image31.jpg" class="img-thumbnail" width="150" height="150"/></a>    
  <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=31#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image32.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image32.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=32#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image33.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image33.jpg" class="img-thumbnail" width="150" height="150"/></a>    
  <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=33#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image34.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image34.jpg" class="img-thumbnail" width="150" height="150"/></a>    
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=34#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image35.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image35.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=35#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image36.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image36.jpg" class="img-thumbnail" width="150" height="150"/></a><a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=36#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image37.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image37.jpg" class="img-thumbnail" width="150" height="150"/></a>    
  <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=37#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image38.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image38.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=38#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image39.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image39.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=39#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image40.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image40.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=40#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image41.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image41.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=41#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image42.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image42.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=42#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image43.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image43.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=43#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image44.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image44.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=44#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image45.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image45.jpg" class="img-thumbnail" width="150" height="150"/></a><a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=45#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image46.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image46.jpg" class="img-thumbnail" width="150" height="150"/></a>    
  <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=46#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image47.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image47.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=47#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image48.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image48.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=48#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image49.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image49.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=49#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image50.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image50.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=50#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image51.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image51.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=51#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image52.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image52.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=52#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image53.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image53.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=53#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image54.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image54.jpg" class="img-thumbnail" width="150" height="150"/></a><a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=54#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image55.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image55.jpg" class="img-thumbnail" width="150" height="150"/></a>    
  <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=55#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image56.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image56.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=56#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image57.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image57.jpg" class="img-thumbnail" width="150" height="150"/></a>    
   <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kimikiss&amp;spgmPic=57#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image58.jpg" alt="galerie/gal/Zero_fansub/Images/Kimikiss/_thb_[Zero]Kimikiss_Image58.jpg" class="img-thumbnail" width="150" height="150"/></a>'));
			$project->setDiscussionUrl("http://forum.zerofansub.net/t120-Ton-avis-sur-Kimikiss-pue-rouge-la-serie-en-general.htm");
			$project->setStatus(Project::ABANDONNED, null);
			Project::$allProjects[] = $project;
		}
		
		foreach(Project::$allProjects as $project) {
			if (!$project->isHidden() && $project->getDiscussionUrl() == null) {
				throw new Exception($project->getID()." has no discussion");
			} else if ($project->getStatus() === null) {
				throw new Exception($project->getID()." has no status");
			} else {
				continue;
			}
		}
		
		return Project::$allProjects;
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
			Project::$allLinks[] = array(Project::getProject('toradora'), Project::getProject('toradorabento'));
			Project::$allLinks[] = array(Project::getProject('toradorasos'), Project::getProject('toradorabento'));
			Project::$allLinks[] = array(Project::getProject('tayutama'), Project::getProject('tayutamapure'));
			Project::$allLinks[] = array(Project::getProject('sketchbook'), Project::getProject('sketchbookdrama'));
			Project::$allLinks[] = array(Project::getProject('potemayo'), Project::getProject('potemayooav'));
			Project::$allLinks[] = array(Project::getProject('genshiken'), Project::getProject('kujibiki'));
			Project::$allLinks[] = array(Project::getProject('kanamemo'), Project::getProject('kanamemobook'));
			Project::$allLinks[] = array(Project::getProject('mayoi'), Project::getProject('mayoisp'));
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
			Project::$allLinks[] = array(Project::getProject('haganai'), Project::getProject('haganaioav'));
			Project::$allLinks[] = array(Project::getProject('kannagi'), Project::getProject('kannagioad'));
			Project::$allLinks[] = array(Project::getProject('mitsudomoe'), Project::getProject('mitsudomoeoad'));
			Project::$allLinks[] = array(Project::getProject('mitsudomoe'), Project::getProject('mitsudomoe2'));
			Project::$allLinks[] = array(Project::getProject('mitsudomoeoad'), Project::getProject('mitsudomoe2'));
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
	
	public static function nameSorter(Project $a, Project $b) {
		$na = $a->getName();
		$nb = $b->getName();
		return strcmp($na, $nb);
	}
}
?>
