<?php
/*
	A release is a file (or a group of coupled files) which has been created by the team.
*/
class Release {
	private $project = null;
	private $id = null;
	private $name = null;
	private $previewUrl = null;
	private $headerImage = null;
	private $files = array();
	private $bonuses = array();
	private $licenseSafeBonuses = array();
	private $streamings = array();
	private $synopsis = null;
	private $comment = null;
	private $originalName = null;
	private $localizedName = null;
	private $releasingTime = null;
	private $license = null;
	private $staff = array();
	private $torrentUrl = "http://www.bt-anime.net/index.php?page=tracker&team=Z%e9ro";
	
	public function __construct(Project $project, $id = null) {
		$this->setProject($project);
		$this->setID($id);
	}
	
	public function getProject() {
		return $this->project;
	}
	
	public function setLicense(License $license) {
		$this->license = $license;
	}
	
	public function getLicense() {
		$license = $this->license;
		if ($license == null && $this->getProject()->isLicensed()) {
			 $license = $this->getProject()->getLicense();
		}
		return $license;
	}
	
	public function isLicensed() {
		return $this->getLicense() != null;
	}
	
	public function setProject(Project $project) {
		$this->project = $project;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getTorrentUrl() {
		return $this->torrentUrl;
	}
	
	public function setTorrentUrl($url) {
		$this->torrentUrl = $url;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getCompleteName() {
		if ($this->getProject() != null && $this->getName() != null) {
			return $this->getProject()->getName()." - ".$this->getName();
		}
		else if ($this->getName() != null) {
			return $this->getName();
		}
		else if ($this->getProject() != null) {
			return $this->getProject()->getName();
		}
		else {
			return "?";
		}
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getPreviewUrl() {
		return $this->previewUrl;
	}
	
	public function setPreviewUrl($previewUrl) {
		$this->previewUrl = $previewUrl;
	}
	
	public function getHeaderImage() {
		return $this->headerImage;
	}
	
	public function setHeaderImage($headerImage) {
		$this->headerImage = $headerImage;
	}
	
	public function getSynopsis() {
		return $this->synopsis;
	}
	
	public function setSynopsis($synopsis) {
		$this->synopsis = $synopsis;
	}
	
	public function getComment() {
		return $this->comment;
	}
	
	public function setComment($comment) {
		$this->comment = $comment;
	}
	
	public function getOriginalTitle() {
		return $this->originalName;
	}
	
	public function setOriginalTitle($originalName) {
		$this->originalName = $originalName;
	}
	
	public function getLocalizedTitle() {
		return $this->localizedName;
	}
	
	public function setLocalizedTitle($localizedName) {
		$this->localizedName = $localizedName;
	}
	
	public function addStaff(TeamMember $member, Role $role = null) {
		$assignment = $this->getAssignmentFor($member->getID());
		if ($assignment === null) {
			$assignment = new Assignment($member);
			$this->staff[] = $assignment;
		}
		
		if ($role !== null) {
			$assignment->assign($role);
		}
	}
	
	public function getStaffMembers() {
		$list = array();
		foreach($this->staff as $assignment) {
			$list[] = $assignment->getTeamMember();
		}
		return $list;
	}
	
	public function getAssignmentFor($memberId) {
		foreach($this->staff as $assignment) {
			if ($assignment->getTeamMember()->getID() === $memberId) {
				return $assignment;
			}
		}
		return null;
	}
	
	public function hasMemberInStaff($memberId) {
		return getAssignmentFor($memberId) !== null;
	}
	
	public function isReleased() {
		return $this->releasingTime !== null;
	}
	
	public function getReleasingTime() {
		return $this->releasingTime;
	}
	
	public function setReleasingTime($timestamp) {
		$this->releasingTime = $timestamp;
	}
	
	public function getFileDescriptors() {
		return $this->files;
	}
	
	public function addFileDescriptor(ReleaseFileDescriptor $descriptor) {
		$this->files[] = $descriptor;
	}
	
	public function getBonuses() {
		return $this->bonuses;
	}
	
	public function getLicenseSafeBonuses() {
		return $this->licenseSafeBonuses;
	}
	
	public function addBonus(Link $link, $licenseSafe = false) {
		$this->bonuses[] = $link;
		if ($licenseSafe) {
			$this->licenseSafeBonuses[] = $link;
		}
	}
	
	public function getStreamings() {
		return $this->streamings;
	}
	
	public function addStreaming(Link $link) {
		$this->streamings[] = $link;
	}
	
	public static $allReleases = null;
	public static function getAllReleases() {
		if (Release::$allReleases === null) {
			Release::$allReleases = array();
			
			$xvid = Codec::getCodec("xvid");
			$mp3 = Codec::getCodec("mp3");
			$avi = Codec::getCodec("avi");
			$h264 = Codec::getCodec("h264");
			$aac = Codec::getCodec("aac");
			$ac3 = Codec::getCodec("ac3");
			$mp4 = Codec::getCodec("mp4");
			$mkv = Codec::getCodec("mkv");
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep0");
			$release->setName("preview");
			$release->setPreviewUrl("images/episodes/mitsudomoepreview.jpg");
			$release->setSynopsis("Bande-Annonce de la série Mitsudomoe qui débutera en juillet 2010.");
			$release->setOriginalTitle("Trailer");
			$release->setLocalizedTitle("Bande-Annonce");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(6), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Mitsudomoe_Preview[Xvid-MP3][5ED85545].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep13");
			$release->setName("épisode 13");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep2");
			$release->setName("épisode 2");
			$release->setPreviewUrl("images/episodes/mitsudomoe2.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Mitsudomoe_02[H264-AAC][D324A25E].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep1");
			$release->setName("épisode 1");
			$release->setPreviewUrl("images/episodes/mitsudomoe1.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Mitsudomoe_01[H264-AAC][A551786E].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep3");
			$release->setName("épisode 3");
			$release->setPreviewUrl("images/episodes/mitsudomoe3.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Mitsudomoe_03[H264-AAC][8C7C6BC3].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep4");
			$release->setName("épisode 4");
			$release->setPreviewUrl("images/episodes/mitsudomoe4.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Mitsudomoe_04[H264-AAC][A9514039].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep5");
			$release->setName("épisode 5");
			$release->setPreviewUrl("images/episodes/mitsudomoe5.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Mitsudomoe_05[H264-AAC][199319E2].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep6");
			$release->setName("épisode 6");
			$release->setPreviewUrl("images/episodes/mitsudomoe6.jpg");
			$release->setHeaderImage("images/sorties/mitsudomoe6.png");
			$descriptor = new ReleaseFileDescriptor("[Zero]Mitsudomoe_06[H264-AAC][43B2986A].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(strtotime("10 October 2011"));
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep7");
			$release->setName("épisode 7");
			$release->setPreviewUrl("images/episodes/mitsudomoe7.jpg");
			$release->setHeaderImage("images/sorties/mitsudomoe7.png");
			$descriptor = new ReleaseFileDescriptor("[Zero]Mitsudomoe_07[H264-AAC][ABFFF382].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(strtotime("14 November 2011 21:00:00"));
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep8");
			$release->setName("épisode 8");
			$release->setPreviewUrl("images/episodes/mitsudomoe8.jpg");
			$release->setHeaderImage("images/sorties/mitsudomoe8.png");
			$descriptor = new ReleaseFileDescriptor("[Zero]Mitsudomoe_08[H264-AAC][276A1B90].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(strtotime("14 November 2011 21:00:01"));
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep9");
			$release->setName("épisode 9");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep11");
			$release->setName("épisode 11");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep12");
			$release->setName("épisode 12");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep10");
			$release->setName("épisode 10");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep1');
			$release->setName("épisode 1");
			$release->setPreviewUrl("images/episodes/kissxsistv1.jpg");
			$release->setLocalizedTitle("Merveilleuses journées");
			$release->setOriginalTitle("Wandafuru Deisu");
			$release->setSynopsis("Keita vit avec Ako et Riko, ses deux soeurs jumelles par alliance. Toutes deux sont amoureuses de lui et se battent pour le séduire. Il souhaite rejoindre le même lycée qu'elles.");
			$release->addStaff(TeamMember::getMember(12), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_01[XVID-MP3][0FA22F79].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_01[H264-AAC][12FDBD2A].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->addBonus(new NewWindowLink("ddl/[Zero]Kiss_X_Sis_01[Screenshots].zip", "Screenshots"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep2');
			$release->setName("épisode 2");
			$release->setPreviewUrl("images/episodes/kissxsistv2.jpg");
			$release->setLocalizedTitle("Un Cours Particulier à Deux");
			$release->setOriginalTitle("Futarikiri no Ressun");
			$release->setSynopsis("Keita a des difficultés scolaires en ce moment, et il lui sera difficile de rejoindre le lycée de ses soeurs. Qu'à cela ne tienne, Ako décide de lui donner des cours particulier, sous le regard jaloux de Riko.");
			$release->addStaff(TeamMember::getMember(12), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_02[XVID-MP3][99FB09D9].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_02[H264-AAC][9FFC6A66].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->addBonus(new NewWindowLink("ddl/[Zero]Kiss_X_Sis_02[Screenshots].zip", "Screenshots"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep3');
			$release->setName("épisode 3");
			$release->setPreviewUrl("images/episodes/kissxsistv3.jpg");
			$release->setLocalizedTitle("Douces sucreries !");
			$release->setOriginalTitle("Miwaku no Suitsu!");
			$release->setSynopsis("Keita n'arrive pas à se concentrer car ses soeurs l'embrassent trop souvent. Il décide donc que les baisers sont interdits. Ako et Riko arriveront-elles à le faire changer d'avis ?");
			$release->addStaff(TeamMember::getMember(12), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_03[XVID-MP3][0DC775AC].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_03[H264-AAC][A445B0AE].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->addBonus(new NewWindowLink("ddl/[Zero]Kiss_x_Sis_03[Screenshots].zip", "Screenshots"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep4');
			$release->setName("épisode 4");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep5');
			$release->setName("épisode 5");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep6');
			$release->setName("épisode 6");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep7');
			$release->setName("épisode 7");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep8');
			$release->setName("épisode 8");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep9');
			$release->setName("épisode 9");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep10');
			$release->setName("épisode 10");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep11');
			$release->setName("épisode 11");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsis'), 'ep12');
			$release->setName("épisode 12");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsisoav'), 'ep3');
			$release->setName("épisode 3");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsisoav'), 'ep4');
			$release->setName("épisode 4");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsisoav'), 'ep5');
			$release->setName("épisode 5");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsisoav'), 'ep6');
			$release->setName("épisode 6");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsisoav'), 'ep7');
			$release->setName("épisode 7");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsisoav'), 'ep0');
			$release->setName("épisode 0");
			$release->setPreviewUrl("images/episodes/kissxsis0.jpg");
			$release->setLocalizedTitle("OAV");
			$release->setOriginalTitle("OVA");
			$release->setSynopsis("Ako et Riko sont deux soeurs jumelles. Toutes les deux sont amoureuses de leur frère par alliance, Keita, avec qui elles n'ont aucun lien de sang.");
			$release->addStaff(TeamMember::getMember(15), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_OAV_00[XVID-MP3][CD84D296].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setCRC("CD84D296");
			$descriptor->setMegauploadUrl("http://www.megaupload.com/fr/?d=PKF691CR");
			$descriptor->setFreeUrl("http://dl.free.fr/getfile.pl?file=/OHHHUMcI");
			$descriptor->setRapidShareUrl("http://rapidshare.com/files/177206747/_5BZero_5DKiss_x_Sis_OAV_00_5BXVID-MP3_5D_5BCD84D296_5D.avi");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_OAV_00[X264-AAC][6762C202].mkv");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setCRC("6762C202");
			$descriptor->setMegauploadUrl("http://www.megaupload.com/fr/?d=IIV81XJJ");
			$descriptor->setFreeUrl("http://dl.free.fr/getfile.pl?file=/AQTqmFGb");
			$descriptor->setRapidShareUrl("http://rapidshare.com/files/177206714/_5BZero_5DKiss_x_Sis_OAV_00_5BX264-AAC_5D_5B6762C202_5D.mkv");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.anime-ultime.net/info-0-1/14643", "Haute Définition"));
			$release->addStreaming(new NewWindowLink("http://www.wat.tv/video/kiss-sis-oav-01-1bjbe_1bjbg_.html", "WAT"));
			$release->addBonus(new NewWindowLink("http://www.yanmaga.kodansha.co.jp/ym/rensai/bessatu/kissxsis/001/001.html", "Le Manga papier (en VO)"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsisoav'), 'ep1');
			$release->setName("épisode 1");
			$release->setPreviewUrl("images/episodes/kissxsis1.jpg");
			$release->setLocalizedTitle("OAV");
			$release->setOriginalTitle("OVA");
			$release->addStaff(TeamMember::getMember(1), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_OAV_01[LD][XVID-MP3][69CC1DD2].avi");
			$descriptor->setID("LD");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_OAV_01[MD][X264-AAC][DF582D5A].mp4");
			$descriptor->setID("MD");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_OAV_01[HD][X264-AAC][E1992856].mp4");
			$descriptor->setID("HD");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kissxsisoav'), 'ep2');
			$release->setName("épisode 2");
			$release->setPreviewUrl("images/episodes/kissxsis2.jpg");
			$release->setLocalizedTitle("OAD");
			$release->setOriginalTitle("OAD");
			$release->addStaff(TeamMember::getMember(7), Role::getRole('raw'));
			$release->addStaff(TeamMember::getMember(11), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_OAV_02[LD][XVID-MP3][69CC1DD2].avi");
			$descriptor->setID("LD");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_OAV_02[MD][X264-AAC][C7583C25].mp4");
			$descriptor->setID("MD");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kiss_x_Sis_OAV_02[HD][X264-AAC][E1992856].mp4");
			$descriptor->setID("HD");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->addBonus(new NewWindowLink("ddl/[Zero]Kiss_x_Sis_OAV_02[Screenshot].zip", "Pack de Screenshots"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kodomooav'), 'oav');
			$release->setName(null);
			$release->setPreviewUrl("images/episodes/kodomooav.jpg");
			$release->setHeaderImage("images/sorties/kodomooavv3.png");
			$release->setLocalizedTitle("Ce que tu m'as offert...");
			$release->setOriginalTitle("Yasumi Jikan '~Anata ga Watashi ni Kureta Mono~'");
			$release->setSynopsis("Rin, Kuro et Mimi sont trois adorables petites filles de 10 ans qui découvrent le monde des adultes... C'est l'anniversaire de Aoki, leur professeur mais aussi l'amoureux secret de Rin. Celle-ci tentent donc de le séduire en lui offrant un cadeau...original ^^");
			$release->addStaff(TeamMember::getMember(1), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(6), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kodomo_OAV_V3[H264-AAC][083E4AFB].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setCRC("083E4AFB");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(strtotime("12 October 2011"));
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kodomofilm'), 'film');
			$release->setName(null);
			$release->setPreviewUrl("images/episodes/kodomofilm.png");
			$release->setHeaderImage("images/sorties/kodomofilm.png");
			$release->addStaff(TeamMember::getMember(12), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(2), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(9), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('raw'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('encod'));
			$release->addStaff(TeamMember::getMember(20), Role::getRole('kara'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kodomo_no_Jikan_FILM[H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(strtotime("12 October 2011"));
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('akinahshiyo'), 'oav');
			$release->setName(null);
			$release->setPreviewUrl("images/episodes/akina1.jpg");
			$release->setHeaderImage("images/sorties/lastakinaonsen.png");
			$release->setLocalizedTitle("Faisons l'amour au Onsen avec Akina");
			$release->setSynopsis("Akina, de la série \"Faisons l'amour ensemble\", est de retour dans sa propre série ! Elle a gagné une loterie et pars avec vous au Onsen. Vous lui demandez d'aller dans un bain privé ou vous en profitez pour lui laver les seins. Excité, vous lui présentez votre sexe qu'elle prend avec plaisir dans sa bouche. La soirée continue et elle boit beaucoup. Vous faites une partie de Ping-pong. Le gagnant pourra faire ce qu'il voudra au perdant. Esperons que vous gagniez !");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(21), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(22), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Akina to Onsen de H Shiyo[H264-AAC][71B501FF].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('alignment'), 'ep1');
			$release->setName("OAV 01");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('alignment'), 'ep2');
			$release->setName("OAV 02");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hshiyo'), 'ep1');
			$release->setName("OAV 01");
			$release->setPreviewUrl("images/episodes/isho1.jpg");
			$release->setSynopsis("Miyazawa a remporté la victoire et avec ses copines, elles ont bu toute la nuit. Elle est toute pompette et va donc chez son ami d'enfance pour lui demander de dormir chez lui. Il accepte, et les effets de l'alcool rendent Miyazawa toute chaude, elle lui fait des sous-entendus et finis par le sucer profondement. Il viens ensuite enfoncer sa grosse bite dans sa petite chatte de vierge en chaleur.");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMember(21), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(21), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sky_Lekas"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo[H264-AAC]/[FFS-Zero]Isshoni H Shiyo 1[H264-AAC][C8DFA639].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setComment("Version censurée");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hshiyo'), 'ep2');
			$release->setName("OAV 02");
			$release->setPreviewUrl("images/episodes/issho2.jpg");
			$release->setHeaderImage("images/sorties/lastissho2.png");
			$release->setLocalizedTitle("Chapitre de Haruka Takai");
			$release->setSynopsis("Haruka-chan rend visite à son senpai et lui offre des patisserie. Son senpai la remercie en lui faisant des choses très cochonnes. Elle apprécie, et c'est normal, c'est senpai après tout.");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(21), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sky_Lekas"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo[H264-AAC]/[FFS-Zero]Isshoni H Shiyo 2[H264-AAC][9C9F3B0D].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hshiyo'), 'ep3');
			$release->setName("OAV 03");
			$release->setPreviewUrl("images/episodes/issho3.jpg");
			$release->setHeaderImage("images/sorties/lastissho3.png");
			$release->setLocalizedTitle("Chapitre de Tsuji Suzuran");
			$release->setSynopsis("L'association \"Monde de maids\" fait une offre spéciale : une maid gratuite pendant une semaine ! Et c'est dans votre appartement que la jolie Suzuran vient faire le ménage. Petite maid cosplayeuse un peu maladroite, son ménage ne vous conviendra pas, alors elle vous fera une jolie gâterie pour se faire pardonner. Ca ne vous suffit toujours pas, alors elle va plus loin, bien plus loin...");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(21), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sky_Lekas"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo[H264-AAC]/[FFS-Zero]Isshoni H Shiyo 3[H264-AAC][9AD925EF].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hshiyo'), 'ep4');
			$release->setName("OAV 04");
			$release->setPreviewUrl("images/episodes/hshiyo4.jpg");
			$release->setHeaderImage("images/sorties/lasthshiyo4.png");
			$release->setLocalizedTitle("Chapitre de Hamada Yui & Fukunaga Aoi");
			$release->setSynopsis("Vous êtes le petit frère de Yui, jeune femme moderne à forte poitrine qui ne vous laisse pas indifférent. Ce soir-là, Yui a invité Aoi, une collègue. Toute les deux rient beaucoup et ça vous empêche de faire vos devoirs. Vous allez donc vous plaindre, mais Yui ne sera pas d'accord et demandera un massage. Aoi demande ensuite un massage des seins que vous vous empressez de malaxer entre vos mains. Tout trois excités, vous entamez une jolie partie de jambe-en-l'air avec ces deux jolies demoiselles.");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(21), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sky_Lekas"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo[H264-AAC]/[FFS-Zero]Isshoni H Shiyo 4[H264-AAC][F49AEB5B].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hshiyo'), 'ep5');
			$release->setName("OAV 05");
			$release->setPreviewUrl("images/episodes/hshiyo5.jpg");
			$release->setHeaderImage("images/sorties/lastshiyo5.png");
			$release->setLocalizedTitle("Chapitre de Yuki Futaba");
			$release->setSynopsis("Votre petite soeur vient vous rendre visite. Comme au bon vieux temps, vous prenez le bain ensemble. Vous en profitez alors pour lui laver les seins et l'entre-jambe. Elle découvre alors qu'elle prend beaucoup de plaisir quand vos doigts sont en elle. En retour, elle nettoiera votre sexe avec sa bouche. Tout deux trés excités aprés ce bain, vous finissez dans un lit.");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(21), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sky_Lekas"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo[H264-AAC]/[FFS-Zero]Isshoni H Shiyo 5[H264-AAC][34432851].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hshiyo'), 'ep6');
			$release->setName("OAV 06");
			$release->setPreviewUrl("images/episodes/hshiyo6.jpg");
			$release->setHeaderImage("images/sorties/hshiyo6.png");
			$release->setLocalizedTitle("Chapitre de Hina Natsukawa");
			$release->setSynopsis("Hina est votre cousine. Vous la retrouvez à la campagne alors que sa grand-mère ne se sent pas bien... mais passons les détails. Elle vous voit vous la couler douce alors qu'il faut aider à préparer le repas. Hina vous emmenera donc ramasser quelques légumes aux champs, même si vous serez plutôt focalisé sur les fruits bien mûrs de la jeune fille. À la suite de quoi un petit tour dans la rivière vous permettra de retirer toute la boue... et autres substances collantes.
			
			Ah, les joies de la campagne.");
			$release->addStaff(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sazaju HITOKAGE"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sky_Lekas"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo 6[H264-AAC][F57162FA].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(strtotime("28 December 2011 19:17"));
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('konoe'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/konoe1.jpg");
			$release->setSynopsis("Rin suce langouresement Aoki-sensei quand un autre prof les surprend. Les deux profs décident alors de faire profiter à toute la classe de la délicieuse bouche de Rin-chan qui ne se lasse pas de sucer, avaler, cracher puis avaler encore.");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Konoe_no_Jikan[1][XVID-AC3][22519CA0].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($ac3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setCRC("BB638B4D");
			$descriptor->setComment("Version censurée");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('konoe'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/konoe2.jpg");
			$release->setSynopsis("C'est un cours spécial aujourd'hui : Rin va apprendre à se masturber. Elle commence doucement avec un pinceau puis fourre ses doigts et fini avec un vibro.");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Konoe_no_Jikan[2][XVID-AC3][3717B508].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($ac3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setCRC("3717B508");
			$descriptor->setComment("Version censurée");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('konoe'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/konoe3.jpg");
			$release->setSynopsis("Rin-chan adore qu'on touche sa chatte. Mais à quel point ? Va-t-elle résister encore longtemps aux gros doigts de son sensei qui s'enfoncent dans sa petite chatte trempée ?");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(7), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Konoe_no_Jikan[3][XVID-AC3][2F2C689C].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($ac3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setComment("Version censurée");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('konoe'), 'ep4');
			$release->setName("04");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('eriko'), 'doujin');
			$release->setName(null);
			$release->setPreviewUrl("images/episodes/eriko.jpg");
			$release->addStaff(TeamMember::getMember(1), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(19), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMember(23), Role::getRole('verifFinale'));
			$descriptor = new ReleaseFileDescriptor("[Zero]_Eriko_Doujin_Gunma-Kisaragi_FR_[HQ]_[zerofansub.net].zip");
			$descriptor->setPageNumber(26);
			$descriptor->setMediaFireUrl("http://www.mediafire.com/?3dmc1td0d9u");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://zerofansub.net/hentai/visio/index.php?spgmGal=The%20doujin%20factory/Eriko%20HQ", "Lecture en ligne HD"));
			$release->addStreaming(new NewWindowLink("http://zerofansub.net/hentai/visio/index.php?spgmGal=The%20doujin%20factory/Eriko%20MQ", "Lecture en ligne LD"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('heismymaster'), 'doujin');
			$release->setName(null);
			$release->setLocalizedTitle("Ce sont mes maids");
			$release->setOriginalTitle("Kore ga Oresama no Maidtachi");
			$release->setPreviewUrl("images/episodes/heismymaster.jpg");
			$release->addStaff(TeamMember::getMember(1), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('verifFinale'));
			$descriptor = new ReleaseFileDescriptor("[Zero]_He_is_my_master_Ce_sont_mes_maids_doujin_FR_[zerofansub.net].zip");
			$descriptor->setPageNumber(17);
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://zerofansub.net/hentai/visio/index.php?spgmGal=The%20doujin%20factory/He%20is%20my%20Master%20-%20Ce%20sont%20mes%20Maids", "Lecture en ligne"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep1');
			$release->setName("01");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep2');
			$release->setName("02");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep3');
			$release->setName("03");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep4');
			$release->setName("04");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep5');
			$release->setName("05");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep6');
			$release->setName("06");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep7');
			$release->setName("07");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep8');
			$release->setName("08");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep9');
			$release->setName("09");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep10');
			$release->setName("10");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep11');
			$release->setName("11");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mayoi'), 'ep12');
			$release->setName("12");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep1');
			$release->setName("01");
			$release->setLocalizedTitle("Les retrouvailles");
			$release->setOriginalTitle("Meet again");
			$release->setPreviewUrl("images/episodes/kimikiss1.jpg");
			$release->setSynopsis("Mao reviens au Japon aprés avoir passé 2 ans en France. Elle retrouve ses amis d'enfance Kouichi et Kazuki. Tous ont grandit et ont maintenant leurs problémes d'ados respectifs, et leurs histoires d'amour...");
			$release->addStaff(TeamMember::getMember(24), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(17), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(25), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(19), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMember(26), Role::getRole('help'));
			$release->addStaff(TeamMember::getMember(23), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 01 [XviD] [BBFD08A1].avi");
			$descriptor->setCRC("BBFD08A1");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 01 [H264] [99AB2169].mp4");
			$descriptor->setCRC("99AB2169");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/fr/?d=78Y70CFW");
			$descriptor->setFreeUrl("http://dl.free.fr/getfile.pl?file=/tCuDr9Dv");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep2');
			$release->setName("02");
			$release->setLocalizedTitle("Une beauté fraîche");
			$release->setOriginalTitle("Cool Beauty");
			$release->setPreviewUrl("images/episodes/kimikiss2.jpg");
			$release->setSynopsis("Kazuki tente de retrouver la mystérieuse Futami pendant que Mao essaye d'approcher Kai tout en surveillant Kouichi...");
			$release->addStaff(TeamMember::getMember(24), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMember(27), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(17), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(19), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMember(20), Role::getRole('help'));
			$release->addStaff(TeamMember::getMember(23), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 02 [XviD] [56E75A2D].avi");
			$descriptor->setCRC("56E75A2D");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 02 [h264] [0F28AE34].mp4");
			$descriptor->setCRC("0F28AE34");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/fr/?d=U8ZFXH46");
			$descriptor->setFreeUrl("http://dl.free.fr/getfile.pl?file=/g3Ci9lFO/[Zero]_Kimikiss_Pure_Rouge_02_[h264]_[0F28AE34].mp4");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=8ZP386FU", "Megavideo"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep3');
			$release->setName("03");
			$release->setLocalizedTitle("Marque-page");
			$release->setOriginalTitle("Bookmark");
			$release->setPreviewUrl("images/episodes/kimikiss3.jpg");
			$release->setSynopsis("Nana organise une petite fête de bienvenue pour Mao. Au programme, un karaoké. Et surtout une excuse, pour Kouichi et Kazuki, pour inviter les filles de leurs rêves...");
			$release->addStaff(TeamMember::getMemberByPseudo("Kurosaki"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Zorro25"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Vegeta"), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMemberByPseudo("Lyf"), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMemberByPseudo("Adeo"), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryocu"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Klick"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Thrax"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Bkdenice"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 03 [XviD] [E15269A5].avi");
			$descriptor->setCRC("E15269A5");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 03 [V2][H264] [DED6B5E4].mp4");
			$descriptor->setCRC("CD8AD570");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/fr/?d=SO0HKZ1F");
			$descriptor->setFreeUrl("http://dl.free.fr/getfile.pl?file=/ZVV1J4IZ");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=JVMK6AOM", "Megavideo"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep4');
			$release->setName("04");
			$release->setLocalizedTitle("Intervention");
			$release->setOriginalTitle("Step in");
			$release->setPreviewUrl("images/episodes/kimikiss4.jpg");
			$release->setSynopsis("Kazuki reprend l'entraîment de foot de Sakino. Mao fait une baisse de tension et rencontre Futami à l'infirmerie...");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Thibou"), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Nixy'Z"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Klick"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Galaf"), Role::getRole('help'));
			$release->addStaff(TeamMember::getMemberByPseudo("Bkdenice"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 04 [XviD] [463CB76C].avi");
			$descriptor->setCRC("463CB76C");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 04 [h264] [F39E1C30].mp4");
			$descriptor->setCRC("F39E1C30");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/fr/?d=SWYZQJ88");
			$descriptor->setFreeUrl("http://dl.free.fr/getfile.pl?file=/whQlC2jm/[Zero]_Kimikiss_Pure_Rouge_04_[h264]_[F39E1C30].mp4");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=9ATP6YT3", "Megavideo"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep5');
			$release->setName("05");
			$release->setLocalizedTitle("Bondir");
			$release->setOriginalTitle("Jumping");
			$release->setPreviewUrl("images/episodes/kimikiss5.jpg");
			$release->setSynopsis("Mao a rdv avec Kai. Kazuki et elle se remémore des souvenirs d'enfance. Kouichi se rapproche de Yuumi.");
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuku"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ed3"), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryocu"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Klick"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Jet9009"), Role::getRole('help'));
			$release->addStaff(TeamMember::getMemberByPseudo("Bkdenice"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 05 [XviD] [005DED0D].avi");
			$descriptor->setCRC("005DED0D");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 05 [H264] [FD65BB51].mp4");
			$descriptor->setCRC("FD65BB51");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/it/?d=SS3HZPZO");
			$descriptor->setFreeUrl("http://dl.free.fr/getfile.pl?file=/4QQnhnMx/[Zero]_Kimikiss_Pure_Rouge_05_[H264]_[FD65BB51].mp4");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=U22V4KP5", "Megavideo"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep6');
			$release->setName("06");
			$release->setLocalizedTitle("Chaque mélancolie");
			$release->setOriginalTitle("each melancholy");
			$release->setPreviewUrl("images/episodes/kimikiss6.jpg");
			$release->setSynopsis("Mao et Sakino voient leurs résultats scolaires baissés, tout le monde se cotise pour les aider à travailler.");
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuku"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Shibo"), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Klick"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Suke"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 06 [XviD] [13A0079F].avi");
			$descriptor->setCRC("13A0079F");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero] Kimikiss Pure Rouge 06 [H264] [8680B64F].mp4");
			$descriptor->setCRC("8680B64F");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/it/?d=SE5XN3GY");
			$descriptor->setFreeUrl("http://dl.free.fr/getfile.pl?file=/QDIZL6un");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=4YB9PO67", "Megavideo"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep7');
			$release->setName("07");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep8');
			$release->setName("08");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep9');
			$release->setName("09");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep10');
			$release->setName("10");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep11');
			$release->setName("11");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep12');
			$release->setName("12");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep13');
			$release->setName("13");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep14');
			$release->setName("14");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep15');
			$release->setName("15");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep16');
			$release->setName("16");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep17');
			$release->setName("17");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep18');
			$release->setName("18");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep19');
			$release->setName("19");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep20');
			$release->setName("20");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep21');
			$release->setName("21");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep22');
			$release->setName("22");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep23');
			$release->setName("23");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kimikiss'), 'ep24');
			$release->setName("24");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep1');
			$release->setName("01");
			$release->setLocalizedTitle("Les larmes d'une perle");
			$release->setOriginalTitle("Shinju no Namida");
			$release->setPreviewUrl("images/episodes/mermaid1.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 01 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep2');
			$release->setName("02");
			$release->setLocalizedTitle("Sentiments dont je ne peux parler");
			$release->setOriginalTitle("Ienai Kokoro");
			$release->setPreviewUrl("images/episodes/mermaid2.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 02 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep3');
			$release->setName("03");
			$release->setLocalizedTitle("Sentiments noyés");
			$release->setOriginalTitle("Yureru Omoi");
			$release->setPreviewUrl("images/episodes/mermaid3.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 03 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep4');
			$release->setName("04");
			$release->setLocalizedTitle("La princesse solitaire");
			$release->setOriginalTitle("Kodoku na Ojo");
			$release->setPreviewUrl("images/episodes/mermaid4.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 04 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep5');
			$release->setName("05");
			$release->setLocalizedTitle("Baiser glacé");
			$release->setOriginalTitle("Tsumetai Kisu");
			$release->setPreviewUrl("images/episodes/mermaid5.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 05 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep6');
			$release->setName("06");
			$release->setLocalizedTitle("La lumière de l'amour");
			$release->setOriginalTitle("Ai no Toka");
			$release->setPreviewUrl("images/episodes/mermaid6.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 06 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep7');
			$release->setName("07");
			$release->setLocalizedTitle("La jalousie d'une sirène");
			$release->setOriginalTitle("Mameido no Jerashi");
			$release->setPreviewUrl("images/episodes/mermaid7.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 07 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep8');
			$release->setName("08");
			$release->setLocalizedTitle(null);
			$release->setOriginalTitle("Kootia Kimochi");
			$release->setPreviewUrl("images/episodes/mermaid8.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 08 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep9');
			$release->setName("09");
			$release->setLocalizedTitle("Mélodie volée");
			$release->setOriginalTitle("Nusumareta Merodi");
			$release->setPreviewUrl("images/episodes/mermaid9.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 09 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep10');
			$release->setName("10");
			$release->setLocalizedTitle("Images du passé");
			$release->setOriginalTitle("Kako no Omokage");
			$release->setPreviewUrl("images/episodes/mermaid10.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 10 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep11');
			$release->setName("11");
			$release->setLocalizedTitle("La pluie des voeux");
			$release->setOriginalTitle("Negai no Yubiwa");
			$release->setPreviewUrl("images/episodes/mermaid11.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 11 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep12');
			$release->setName("12");
			$release->setLocalizedTitle("Coeur cisaillé");
			$release->setOriginalTitle("Sure Chigau Kokoro");
			$release->setPreviewUrl("images/episodes/mermaid12.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 12 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep13');
			$release->setName("13");
			$release->setLocalizedTitle("Le rituel des sirénes");
			$release->setOriginalTitle("Mameido no Gishiki");
			$release->setPreviewUrl("images/episodes/mermaid13.jpg");
			$release->setComment("Episode entiérement réalisé par l'ancienne équipe Maboroshi no fansub");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi No Fansub] Mermaid Melody Pichi Pichi Pitch 13 vostf.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep53');
			$release->setName("01 (Italien)");
			$release->setLocalizedTitle("Perle de Sirène");
			$release->setOriginalTitle("Una sirena fra noi");
			$release->setPreviewUrl("images/episodes/mermaid1.jpg");
			$release->setSynopsis("Lucia est une sirène. Durant son enfance, elle a sauvé un humain en lui donnant sa perle. Elle est amoureuse de lui et recherche sa perle.");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Thrax"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Bk"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]_Mermaid_Melody_Pichi_Pichi_Pitch _01_[XviD]_[D4AF3D69].avi");
			$descriptor->setCRC("D4AF3D69");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setComment("Version Italienne sous-titrée français.");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=TBHLLBN5", "Megavideo"));
			$release->addStreaming(new NewWindowLink("http://www.anime-ultime.net/info-0-1/13975-Mermaid_Melody_Pichi_Pichi_Pitch_Version_Italienne_01", "Haute Définition"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mermaid'), 'ep54');
			$release->setName("02 (Italien)");
			$release->setLocalizedTitle("Un secret à ne pas réveler");
			$release->setOriginalTitle("Segreti da non rivelare");
			$release->setPreviewUrl("images/episodes/mermaid2.jpg");
			$release->setHeaderImage("images/sorties/lastmermaid2.png");
			$release->setSynopsis("Lucia découvre que Hanon est aussi une siréne. Elle découvre aussi ce qu'il arrivera si elle tombe amoureuse d'un humain.");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryocu"), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Thrax"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Bkdenice"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("B3rning"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]_Mermaid_Melody_Pichi_Pichi_Pitch _02_[H264]_[3913101370].mp4");
			$descriptor->setCRC("3913101370");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setComment("Version Italienne sous-titrée français.");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep1');
			$release->setName("01");
			$release->setLocalizedTitle("Shangai pourpre");
			$release->setPreviewUrl("images/episodes/canaan1.jpg");
			$release->setHeaderImage("images/sorties/canaan1.png");
			$release->addStaff(TeamMember::getMemberByPseudo("Ryocu"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/canaan2.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan2.png");
			$release->setLocalizedTitle("Un jeu cruel");
			$release->addStaff(TeamMember::getMemberByPseudo("Ryocu"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->addBonus(new NewWindowLink("images/news/%5bZero%5dCanaan_02_Photo_negatif_1.jpg", "1"), true);
			$release->addBonus(new NewWindowLink("images/news/%5bZero%5dCanaan_02_Photo_negatif_2.jpg", "2"), true);
			$release->addBonus(new NewWindowLink("images/news/%5bZero%5dCanaan_02_Photo_negatif_3.jpg", "3"), true);
			$release->addBonus(new NewWindowLink("images/news/%5bZero%5dCanaan_02_Photo_negatif_4.jpg", "4"), true);
			$release->addBonus(new NewWindowLink("images/news/%5bZero%5dCanaan_02_Photo_negatif_5.jpg", "5"), true);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/canaan3.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan3.png");
			$release->setLocalizedTitle("Rien d'important");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/canaan4.jpg");
			$release->setLocalizedTitle("Obscuritée Grandissante");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/canaan5.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan5.png");
			$release->setLocalizedTitle("Amies");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/canaan6.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan6.png");
			$release->setLocalizedTitle("Love and Piece");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep7');
			$release->setName("07");
			$release->setPreviewUrl("images/episodes/canaan7.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan7.png");
			$release->setLocalizedTitle("Pierre tombale");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryocu"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep8');
			$release->setName("08");
			$release->setPreviewUrl("images/episodes/canaan8.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan8.png");
			$release->setLocalizedTitle("Requête");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep9');
			$release->setName("09");
			$release->setPreviewUrl("images/episodes/canaan9.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan9.png");
			$release->setLocalizedTitle("Fleurs du passé");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep10');
			$release->setName("10");
			$release->setPreviewUrl("images/episodes/canaan10.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan10.png");
			$release->setLocalizedTitle("Fleurs du passé");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep11');
			$release->setName("11");
			$release->setPreviewUrl("images/episodes/canaan11.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan11.png");
			$release->setLocalizedTitle("Pensées");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep12');
			$release->setName("12");
			$release->setPreviewUrl("images/episodes/canaan12.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan12.png");
			$release->setLocalizedTitle("Train Saisonnier");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->addBonus(new NewWindowLink("ddl/[Zero]Canaan_12[Screenshots].zip", "Pack de Screenshots"), true);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('canaan'), 'ep13');
			$release->setName("13");
			$release->setPreviewUrl("images/episodes/canaan13.jpg");
			$release->setHeaderImage("images/sorties/lastcanaan13.png");
			$release->setLocalizedTitle("Terre d'espoir");
			$release->addStaff(TeamMember::getMemberByPseudo("Pyra"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/hyakko1.jpg");
			$release->setHeaderImage("images/sorties/hyakko.jpg");
			$release->setLocalizedTitle("Rencontre avec un tigre");
			$release->setOriginalTitle("Aimamieru Torako");
			$release->setSynopsis("Ayumu est à la recherche de sa salle de classe. Elle rencontre sur son chemin Tatsuki. en cherchant toutes les deux, elle voient Torako et Suzume sautant du deuxième étage d'une fenêtre. Après avoir rejoint le groupe, elles se dirige vers la salle de classe.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_01[H264-AAC][186B44E7].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/hyakko2.jpg");
			$release->setLocalizedTitle("Qui ne risque rien n'a rien");
			$release->setOriginalTitle("Koketsu ni Irazunba Koji o EZU");
			$release->setSynopsis("Ayumu, Tatsuki, Torako et Suzume sont à la recherche d'un club. Elles essayent plusieurs clubs de sport ensemble.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_02[H264-AAC][D5479335].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/hyakko3.jpg");
			$release->setLocalizedTitle("Un tigre à l'entrée, un tigre à l'arrière");
			$release->setOriginalTitle("Zenmon pas mo Tora Tora Komon / Hariko pas Tora");
			$release->setSynopsis("Torako et Suzume rencontrent Nene sur leur chemin. Elle leur annonce que Torako est chargée de la discipline ! Elle doit donc dès le lendemain vérifier les uniformes des élèves. Dans la deuxième partie de l'épisode, Torako et Suzume découvrent un robot grotesque fait par Chie, membre du club de robotique. Plus tard, Torako et ses amis sont invitées à la salle du club robotique et Chie leur annonce qu'elle veut devenir ingénieure en robotique.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_03[H264-AAC][33D9EAEC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/hyakko4.jpg");
			$release->setLocalizedTitle("Le tigre se remplit la panse");
			$release->setOriginalTitle("Torashoku Bashoku Gyuin / Tora wa Torazure");
			$release->setSynopsis("Torako et ses amis vont à la cafétéria de l'école ensemble. Sur le chemin, Torako explique à Ayumu le «Combo» : le moyen d'obtenir une portion supplémentaire de repas. Dans la deuxième partie de l'épisode, Torako et ses amis sont en classe d'art où les élèves apprennent à se dessiner les uns les autres.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_04[H264-AAC][84D4054B].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/hyakko5.jpg");
			$release->setLocalizedTitle("Relation étrange / Combats un tigre et tu verras");
			$release->setOriginalTitle("Aien Koen / Hito ni wa soute miyo Tora à wa Tatakatte miyo");
			$release->setSynopsis("Un nouveau personnage : Yanagi. Tout comme Koma, elle fait des profits de la vente de photographies des élèves. Lorsque Shishimaru regarde la photographie de Ayumu par hasard, il est instantanément épris de la photographie. Sur son chemin, il la Ayumu et confesse son amour pour elle. Dans la deuxième partie de l'épisode, Torako et Ushio sèchent les cours et passent leur temps ensemble dans le centre-ville.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_05[H264-AAC][8D75C502].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/hyakko6.jpg");
			$release->setLocalizedTitle("Encerclée par des tigres");
			$release->setOriginalTitle("Sangen mukou Ryogawa ni Tora");
			$release->setSynopsis("Torako, Suzume, et Ayumu vont chez Tatsuki sans la prévenir.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_06[H264-AAC][975D17BE].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep7');
			$release->setName("07");
			$release->setPreviewUrl("images/episodes/hyakko7.jpg");
			$release->setLocalizedTitle("Finallement, le tigre et le renard se rencontrent / Le renard provoque la colère du tigre");
			$release->setOriginalTitle("Koko de Atta ga Hyakunenme / Tora no o Ikari Kitsune Kau");
			$release->setSynopsis("Koma et Yanagi se cachent dans les buissons pour prendre des photos d'élèves en secret. Kitsuna décide de les aider et tire la jupe d'Ayumi pour Koma et Yanagi la prenne en photo. Dans la deuxième partie de l'épisode, Torako se plaint à ses amis de tous les mauvais souvenirs qu'elle avait avec son frère dans le passé. Kitsune décide de faire une blague à Torako en mettant des épices dans ses ramens.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_07[H264-AAC][73F88F50].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep8');
			$release->setName("08");
			$release->setPreviewUrl("images/episodes/hyakko8.jpg");
			$release->setLocalizedTitle("Une flèche atteint le tigre / J'ai bousculé un tigre, mais c'était en fait un chat");
			$release->setOriginalTitle("Tora ni Tatsu Ya / Tora o Egai te Neko ni Ruisuru");
			$release->setSynopsis("Inori est en détresse de ne pas pouvoir se faire des amis car elle a du mal à parler à haute voix et son visage couvert par ses cheveux longs effraie les autres étudiants. Torako décide alors de l'aider en demandant à ses amis de la recoiffer.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_08[H264-AAC][E7333F69].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep9');
			$release->setName("09");
			$release->setPreviewUrl("images/episodes/hyakko9.jpg");
			$release->setLocalizedTitle("La compassion ne profite qu'aux autres / J'ai bousculé un tigre, mais c'était en fait un chat");
			$release->setOriginalTitle("zu na Suzume, yo Ataeraren Saraba Nasake");
			$release->setSynopsis("Minato a perdu sa pièce pour acheter une canette. Elle se met à pleurer, et Torako Ayumi arrivent. Torako lui achète une canette de boisson pour qu'elle cesse de pleurer. Depuis, Minato veut absolument lui rendre la pareille en l'aidant tout le temps.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_09[H264-AAC][8136764D].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep10');
			$release->setName("10");
			$release->setPreviewUrl("images/episodes/hyakko10.jpg");
			$release->setLocalizedTitle("Un tigre avec des ailes");
			$release->setOriginalTitle("Tora ni Tsubasa");
			$release->setSynopsis("Toma passe son temps sur le dessus du bâtiment scolaire. Torako s'approche d'elle et essaie de lui parler. Toma la rejette. Plus tard, Toma rencontre les amies de Torako à l'école et elle décide avec certitude que chacune d'entre elle a quelque chose d'étrange, d'une manière ou d'une autre.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_10[H264-AAC][3518F5F2].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep11');
			$release->setName("11");
			$release->setPreviewUrl("images/episodes/hyakko11.jpg");
			$release->setLocalizedTitle("Dans la gueule du tigre");
			$release->setOriginalTitle("Koko o Nogareru");
			$release->setSynopsis("Une prof est absente car elle doit s'occuper de son fils. À la place du cours d'anglais, ils vont faire du sport.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_11[H264-AAC][323C3503].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep12');
			$release->setName("12");
			$release->setPreviewUrl("images/episodes/hyakko12.jpg");
			$release->setLocalizedTitle("La princesse, le prince et Torako / Le démon tigre");
			$release->setOriginalTitle("Ichi Hime Ni Taro San Torako / Torako Yue Onigokoro Mayou NI");
			$release->setSynopsis("Torako est allée dormir chez une amie. Sa grande soeur lui en veut de ne pas l'avoir prévenue.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_12[H264-AAC][49831503].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('hyakko'), 'ep13');
			$release->setName("13");
			$release->setPreviewUrl("images/episodes/hyakko13.jpg");
			$release->setLocalizedTitle("Les quatres forment un tigre");
			$release->setOriginalTitle("Yonin Tora o Nasu");
			$release->setSynopsis("Torako et Suzume se sont enfuie de chez elles. C'est le dernier jour de l'école.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Hyakko_13[H264-AAC][8C963DCF].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('training'), 'oav');
			$release->setName(null);
			$release->setPreviewUrl("images/episodes/training.jpg");
			$release->setHeaderImage("images/sorties/lasttraining.png");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sleeping'), 'oav');
			$release->setName(null);
			$release->setPreviewUrl("images/episodes/sleeping.jpg");
			$release->setHeaderImage("images/sorties/lastsleeping.png");
			$release->addStaff(TeamMember::getMemberByPseudo("Benjee"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/kannagi1.jpg");
			$release->setHeaderImage("images/sorties/lastkannagi.png");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/01/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/01/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/01/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/kannagi2.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/02/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/02/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/02/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/kannagi3.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/03/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/03/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/03/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/kannagi4.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/04/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/04/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/04/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/kannagi5.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/05/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/05/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/05/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/kannagi6.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/06/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/06/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/06/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep7');
			$release->setName("07");
			$release->setPreviewUrl("images/episodes/kannagi7.jpg");
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep8');
			$release->setName("08");
			$release->setPreviewUrl("images/episodes/kannagi8.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/08/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/08/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/08/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep9');
			$release->setName("09");
			$release->setPreviewUrl("images/episodes/kannagi9.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/09/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/09/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/09/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep10');
			$release->setName("10");
			$release->setPreviewUrl("images/episodes/kannagi10.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/10/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/10/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/10/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep11');
			$release->setName("11");
			$release->setPreviewUrl("images/episodes/kannagi11.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/11/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/11/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/11/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep12');
			$release->setName("12");
			$release->setPreviewUrl("images/episodes/kannagi12.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/12/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/12/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/12/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep13');
			$release->setName("13");
			$release->setPreviewUrl("images/episodes/kannagi13.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/13/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/13/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/13/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep14');
			$release->setName("14");
			$release->setPreviewUrl("images/episodes/kannagi14.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/14/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/14/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/14/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('bath'), 'oav');
			$release->setName(null);
			$release->setPreviewUrl("images/episodes/bath.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Isshoni_Training_Ofuro_Bathtime_with_Hinako_and_Hiyoko[X264-AAC][5ACD3D35].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('bath'), 'oav');
			$release->setName(null);
			$release->setPreviewUrl("images/episodes/bath.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Isshoni_Training_Ofuro_Bathtime_with_Hinako_and_Hiyoko[X264-AAC][5ACD3D35].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kodomonatsu'), 'oav');
			$release->setName(null);
			$release->setPreviewUrl("images/episodes/kodomonatsu0.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kodomo_no_Natsu_Jikan[848x480][3B4038AF].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/kanamemo1.jpg");
			$release->setLocalizedTitle("Ma première fois, seule...");
			$release->addStaff(TeamMember::getMemberByPseudo("Shana-chan"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo_01[XviD-MP3][C2C181EB].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_01[H264-AAC][4DDB4C51].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/kanamemo2.jpg");
			$release->setLocalizedTitle("Ma première livraison");
			$release->addStaff(TeamMember::getMemberByPseudo("Shana-chan"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo_02[XviD-MP3][2CF2A10E].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_02[H264-AAC][74AAC3AD].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/kanamemo3.jpg");
			$release->setLocalizedTitle("Mon premier sourire");
			$release->addStaff(TeamMember::getMemberByPseudo("Shana-chan"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo_03[XviD-MP3][17D16848].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_03[H264-AAC][5E4DD57A].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/kanamemo4.jpg");
			$release->setLocalizedTitle("Ma première fois à la piscine");
			$release->addStaff(TeamMember::getMemberByPseudo("Shana-chan"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo_04[XviD-MP3][F20EEC46].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_04[H264-AAC][B001FA6D].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/kanamemo5.jpg");
			$release->setLocalizedTitle("Ma première fois aux bains avec tout le monde");
			$release->addStaff(TeamMember::getMemberByPseudo("Shana-chan"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo_05[XviD-MP3][AA9ADEF2].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_05[H264-AAC][8FA55E90].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->addBonus(new NewWindowLink('ddl/[Zero]Kanamemo_05_AMV.mp4', 'AMV'));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/kanamemo6.jpg");
			$release->setLocalizedTitle("Ma première histoire de fantômes");
			$release->addStaff(TeamMember::getMemberByPseudo("Shana-chan"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Akai_Ritsu"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo_06[XviD-MP3][94EB1395].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_06[H264-AAC][4EC2362E].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep7');
			$release->setName("07");
			$release->setPreviewUrl("images/episodes/kanamemo7.jpg");
			$release->setLocalizedTitle("Mon premier accueil");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_07[H264-AAC][3B7C6CCC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep8');
			$release->setName("08");
			$release->setPreviewUrl("images/episodes/kanamemo8.jpg");
			$release->setLocalizedTitle("La première fois que je parle du passé");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_08[H264-AAC][480EE696].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep9');
			$release->setName("09");
			$release->setPreviewUrl("images/episodes/kanamemo9.jpg");
			$release->setLocalizedTitle("Mon premier régime ?");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_09[H264-AAC][B2434A96].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep10');
			$release->setName("10");
			$release->setPreviewUrl("images/episodes/kanamemo10.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_10[H264-AAC][3497F0E7].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep11');
			$release->setName("11");
			$release->setPreviewUrl("images/episodes/kanamemo11.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_11[H264-AAC][7ED476A9].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep12');
			$release->setName("12");
			$release->setPreviewUrl("images/episodes/kanamemo12.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_12[H264-AAC][ACAE4B0F].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemo'), 'ep13');
			$release->setName("13");
			$release->setPreviewUrl("images/episodes/kanamemo13.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo[H264-AAC]/[Zero]Kanamemo_13[H264-AAC][A510AC9D].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemobook'), 'ch1');
			$release->setName("chapitre 01");
			$release->setPreviewUrl("images/episodes/kanamemochap1.png");
			$release->addStaff(TeamMember::getMemberByPseudo('db0'), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo('db0'), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo('praia'), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo('Jembé'), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo('Tcho'), Role::getRole('qc'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo_Chapitre01_MQ.zip");
			$descriptor->setID("MQ");
			$descriptor->setPageNumber(18);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Kanamemo_Chapitre01.zip");
			$descriptor->setID("HQ");
			$descriptor->setPageNumber(18);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemobook'), 'ch2');
			$release->setName("chapitre 02");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemobook'), 'ch3');
			$release->setName("chapitre 03");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemobook'), 'ch4');
			$release->setName("chapitre 04");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemobook'), 'ch5');
			$release->setName("chapitre 05");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemobook'), 'ch6');
			$release->setName("chapitre 06");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemobook'), 'ch7');
			$release->setName("chapitre 07");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemobook'), 'ch8');
			$release->setName("chapitre 08");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemobook'), 'ch9');
			$release->setName("chapitre 09");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kanamemobook'), 'ch10');
			$release->setName("chapitre 10");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('toradorasos'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/toradorasos1-1.jpg");
			// TODO add images/episodes/toradorasos1-2.jpg
			$descriptor = new ReleaseFileDescriptor("[Zero]Toradora_SOS[H264-AAC]/[Zero]Toradora_SOS_01[H264-AAC][1484BBAB].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('toradorasos'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/toradorasos2-1.jpg");
			// TODO add images/episodes/toradorasos2-2.jpg
			$descriptor = new ReleaseFileDescriptor("[Zero]Toradora_SOS[H264-AAC]/[Zero]Toradora_SOS_02[H264-AAC][0261E281].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('toradorasos'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/toradorasos3-1.jpg");
			// TODO add images/episodes/toradorasos3-2.jpg
			$descriptor = new ReleaseFileDescriptor("[Zero]Toradora_SOS[H264-AAC]/[Zero]Toradora_SOS_03[H264-AAC][5BB08F75].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('toradorasos'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/toradorasos4-1.jpg");
			// TODO add images/episodes/toradorasos4-2.jpg
			$descriptor = new ReleaseFileDescriptor("[Zero]Toradora_SOS[H264-AAC]/[Zero]Toradora_SOS_04[H264-AAC][0F2BF1C6].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/genshiken1.jpg");
			$release->setLocalizedTitle("Les projets du nouveau président");
			$release->setOriginalTitle("Shin-Kaicho no Kokorozashi");
			$release->setSynopsis("Le Genshiken reviens avec Sasahara comme nouveau président ! Ils comptent participer au Comic Festival en tant qu'exposant et donc faire un fanzine.");
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Suke"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[01v2][H264-AAC][057403CF].mp4");
			$descriptor->setCRC("D84D9A0E");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[01v2][XviD-MP3][EE8EBD37].avi");
			$descriptor->setCRC("2D060162");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=ZRIUVGVE", "Megavideo"));
			$release->addStreaming(new NewWindowLink("http://www.anime-ultime.net/info-0-1/14094-Genshiken_II_01", "Haute Définition"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/genshiken2.jpg");
			$release->setLocalizedTitle("Les rencontres sont désastreuses");
			$release->setOriginalTitle("Kaigi wa Momeru");
			$release->setSynopsis("Plus beaucoup de temps avant la date limite fixée à l'imprimerie pour la publication du fanzine ! Une dispute entre les membres du Genshiken  ! Réussiront-ils à sortir le fanzine ?");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Suke"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[02v2][H264-AAC][9EA036CF].mp4");
			$descriptor->setCRC("4568C0E8");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[02v2][XviD-MP3][16F44D61].avi");
			$descriptor->setCRC("AFD9C767");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=G106COBC", "Megavideo"));
			$release->addStreaming(new NewWindowLink("http://www.anime-ultime.net/info-0-1/14216-Genshiken_II_02", "Haute Définition"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/genshiken3.jpg");
			$release->setLocalizedTitle("Une chaude journée d'été");
			$release->setOriginalTitle("Atsui Natsu no Ichinichi");
			$release->setSynopsis("Le fanzine est enfin terminé, et arrive le Jour J du Comic Festival.");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Kyon"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[03][x264-AAC][15C18BEA](2).mp4");
			$descriptor->setCRC("15C18BEA");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[03][XVID-MP3][2419EAB9].avi");
			$descriptor->setCRC("2419EAB9");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=Z9JNELNX", "Megavideo"));
			$release->addStreaming(new NewWindowLink("http://www.anime-ultime.net/info-0-1/14570-Genshiken_II_03", "Haute Définition"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/genshiken4.jpg");
			$release->setLocalizedTitle("Vous sortez ensemble ?");
			$release->setOriginalTitle("Atsui Natsu no Ichinichi");
			$release->setSynopsis("Tanaka et Ohno sont très proche, et toute la bande à l'impréssion qu'ils sortent ensemble. Comment savoir si c'est bien le cas...?");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[04][H264-AAC][24BE6A54].mp4");
			$descriptor->setCRC("24BE6A54");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[04][XviD-MP3][1FE48820].avi");
			$descriptor->setCRC("1FE48820");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=H0RLF81M", "Megavideo"));
			$release->addStreaming(new NewWindowLink("http://www.anime-ultime.net/info-0-1/14637-Genshiken_II_04", "Haute Définition"));
			$release->addBonus(new NewWindowLink("images/news/menma1024_768.jpg", "Menma 1024x768"));
			$release->addBonus(new NewWindowLink("images/news/menma1280_1024.jpg", "Menma 1280x1024"));
			$release->addBonus(new NewWindowLink("images/news/menma1920_1080.jpg", "Menma 1920x1080"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/genshiken5.jpg");
			$release->setLocalizedTitle("Madarame devient Uke");
			$release->setOriginalTitle("Madarame So-Uke");
			$release->setSynopsis("Ogiue surprend Madarame et Sasahara dans une drôle de situation. Son imagination débordante de fan de yaoi va lui faire inventer de drôles de scénario...");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[05][H264-AAC][0DF64C0C].mp4");
			$descriptor->setCRC("1FE48820");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[05][XviD-MP3][A7055373].avi");
			$descriptor->setCRC("A7055373");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=AE3J97OO", "Megavideo"));
			$release->addStreaming(new NewWindowLink("http://www.anime-ultime.net/info-0-1/14638-Genshiken_II_05", "Haute Définition"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/genshiken6.jpg");
			$release->setLocalizedTitle("Un problème de Hobby");
			$release->setOriginalTitle("Shumi no Mondai");
			$release->setSynopsis("Ogiue refuse d'admettre qu'elle souhaite aller au Comic Festival. Elle va donc se déguiser pour passer inaperçu et aller s'acheter ses fanzines yaoi préférés.");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Papy Al"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Zetsubo Sensei"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[06][H264-AAC][224F38D7].mp4");
			$descriptor->setCRC("224F38D7");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[06][XviD-MP3][49858ACF].avi");
			$descriptor->setCRC("49858ACF");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep7');
			$release->setName("07");
			$release->setPreviewUrl("images/episodes/genshiken7.jpg");
			$release->setLocalizedTitle("Syndrôme de récéption d'un diplôme");
			$release->setOriginalTitle("Sotsugyo Shokogun");
			$release->setSynopsis("3 membres du Genshiken reçoivent leurs diplômes aujourd'hui. Ils vont donc entrer dans la vie du travail.");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Papy Al"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[07][H264-AAC][E02D4D87](2).mp4");
			$descriptor->setCRC("E02D4D87");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=EYVBQ4IJ");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[07][XviD-MP3][136F5857].avi");
			$descriptor->setCRC("136F5857");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=EJOA5HII");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?d=EYVBQ4IJ", "Megavideo"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep8');
			$release->setName("08");
			$release->setPreviewUrl("images/episodes/genshiken8.jpg");
			$release->setLocalizedTitle("Club de Cosplay");
			$release->setOriginalTitle("Kosuken");
			$release->setSynopsis("Ohno vient d'être élue présidente du Genshiken. Ogiue a été acceptée pour le comi-fes. Pour fêter ça, pourquoi pas faire un peu de cosplay ?");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Papy Al"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[08][H264-AAC][98885A46].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[08][XviD-MP3][F8EC5319].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep9');
			$release->setName("09");
			$release->setPreviewUrl("images/episodes/genshiken9.jpg");
			$release->setLocalizedTitle("Il pleut toujours quand on cherche un emploi");
			$release->setOriginalTitle("Shukatsu wa Itsumo Ame");
			$release->setSynopsis("Sasahara continue désespèrement à chercher un emploi dans une boîte d'édition et passe plusieurs entretiens.");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Papy Al"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[09][H264-AAC][A8A94D6A].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[09][XviD-MP3][17068A5D].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep10');
			$release->setName("10");
			$release->setPreviewUrl("images/episodes/genshiken10.jpg");
			$release->setLocalizedTitle("Otaku des USA");
			$release->setOriginalTitle("Otaku Furomu USA");
			$release->setSynopsis("Des amies de Kanako venant des état-unis sont venues lui rendre visite. Evidemment, elles ne parlent pas japonais.");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Papy Al"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[10][H264-AAC][7209E37F].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[10][XviD-MP3][62AFA4EB].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep11');
			$release->setName("11");
			$release->setPreviewUrl("images/episodes/genshiken11.jpg");
			$release->setLocalizedTitle("Real Hardcore");
			$release->setOriginalTitle("Riaru Hadokoa");
			$release->setSynopsis("Ogiue va présenter son doujin au comic festival, accompagnée comme prévu de Sasahara. Ohno et Angela cosplayent, et essaie de laisser Sasahara et Ogiue en tête à tête, mais ce n'est pas facile, car Suzy semble bien décidée à les taquiner.");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[11][H264-AAC][7B488E84].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[11][XviD-MP3][CA8D3795].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('genshiken'), 'ep12');
			$release->setName("12");
			$release->setPreviewUrl("images/episodes/genshiken12.jpg");
			$release->setLocalizedTitle("Mensonges à venir");
			$release->setOriginalTitle("Sono Saki ni Aru Mono..");
			$release->setSynopsis("Sasahara continue désespérement à chercher du travail... Il a tant de mal qu'il finit par laisser tomber ses recherches, mais le reste du Genshiken ne compte pas le laisser faire.");
			$release->addStaff(TeamMember::getMemberByPseudo("Man-ban"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Sunao"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tcho"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tcho"), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Pyra"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[H264-AAC]/[Zero]Genshiken_2[12][H264-AAC][85CC1EC3].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Zero]Genshiken_2[12][XviD-MP3][899822B0].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/sketchbook1.jpg");
			$release->setLocalizedTitle("La fille au carnet de croquis");
			$release->setOriginalTitle("Suketchibukku no Shojo");
			$release->setSynopsis("Sora est timide mais elle adore dessiner.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Suke"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[01v2][1280x720][x264-AAC][3CEF704D].mp4");
			$descriptor->setCRC("3CEF704D");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=Q251QKZR", "Megavideo v1"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/sketchbook2.jpg");
			$release->setLocalizedTitle("Le même paysage");
			$release->setOriginalTitle("Itsumo no Fukei");
			$release->setSynopsis("Sora décide de changer des habitudes quotidiennes.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("SwRafael"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Kyon"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[02v2][1280x720][x264-AAC][C2715892].mp4");
			$descriptor->setCRC("1EC198AC");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=6LA5YJEH", "Megavideo v1"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/sketchbook3.jpg");
			$release->setLocalizedTitle("Les inquiétudes d'Ao");
			$release->setOriginalTitle("Ao no Shinpai");
			$release->setSynopsis("C'est le festival du printemps. Tout le monde en yukata !");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("SwRafael"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Kyon"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[03][1280x720][x264-AAC][E0FC6D84].mp4");
			$descriptor->setCRC("E0FC6D84");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=RKCX08AO");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.megavideo.com/?v=B7Z2GFPR", "Megavideo"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/sketchbook4.jpg");
			$release->setLocalizedTitle("Une sortie de groupe à trois");
			$release->setOriginalTitle("Sannin Dake no Suketchi Taikai");
			$release->setSynopsis("Une sortie scolaire est prévue, mais il pleut. Auront-ils le courage d'y aller quand même ?");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("SwRafael"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Kyon"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[04][1280x720][x264-AAC][B7CEBC3A].mp4");
			$descriptor->setCRC("B7CEBC3A");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=FLF5ITSS");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/sketchbook5.jpg");
			$release->setLocalizedTitle("La journée des chats");
			$release->setOriginalTitle("Neko Neko no Hi");
			$release->setSynopsis("Aujourd'hui, les chats se mettent à parler et Mike rencontre un nouveau... chat ? du nom de Kuma.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("SwRafael"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Kyon"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[05v2][1280x720][x264-AAC][BD6877D7].mp4");
			$descriptor->setCRC("BD6877D7");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/sketchbook6.jpg");
			$release->setLocalizedTitle("Souvenirs d'été");
			$release->setOriginalTitle("Natsu no Omoide");
			$release->setSynopsis("La classe part en voyage scolaire.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[06][1280x720][x264-AAC][A1747518].mp4");
			$descriptor->setCRC("A1747518");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep7');
			$release->setName("07");
			$release->setPreviewUrl("images/episodes/sketchbook7.jpg");
			$release->setLocalizedTitle("Une Journée de Septembre...");
			$release->setOriginalTitle("Kugatsu no Hi ni...");
			$release->setSynopsis("Kate est une étudiante transferée. Elle parle anglais et se débrouille un peu en Japonais, mais pour les kanjis, elle a plus de mal.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[07][1280x720][x264-AAC][586104DE].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep8');
			$release->setName("08");
			$release->setPreviewUrl("images/episodes/sketchbook8.jpg");
			$release->setLocalizedTitle("La jeune fille et le lecteur de CD");
			$release->setOriginalTitle("Rajikase to Shojo no Nihondate");
			$release->setSynopsis("La blonde a cassé son lecteur de CD et cherche desespérement quelqu'un pour le lui réparer ? Sora n'est pas de la partie, puisque le dimanche est pour elle un jour de repos. Elle rencontre d'ailleurs la petite fille du premier épisode qui prend des photos.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[08][1280x720][x264-AAC][DF8A2411].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep9');
			$release->setName("09");
			$release->setPreviewUrl("images/episodes/sketchbook9.jpg");
			$release->setLocalizedTitle("Pour l'amour de quelque chose");
			$release->setOriginalTitle("Nanika no Tame ni");
			$release->setSynopsis("Les examens approchent, c'est la période des révisions.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[09][1280x720][x264-AAC][E65AD8E4].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep10');
			$release->setName("10");
			$release->setPreviewUrl("images/episodes/sketchbook10.jpg");
			$release->setLocalizedTitle("Avant de te rencontrer");
			$release->setOriginalTitle("Deai no Saki");
			$release->setSynopsis("Une nouvelle sortie scolaire où nos héros y rencontrent un petit chien. La petite rouquine de la dernière fois vient rendre visite au club d'art.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[10][1280x720][x264-AAC][9B420C4E].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep11');
			$release->setName("11");
			$release->setPreviewUrl("images/episodes/sketchbook11.jpg");
			$release->setLocalizedTitle("Une journée enrhumée, 3e journée des chats");
			$release->setOriginalTitle("Kaze no Hi to Nekoneko part3");
			$release->setSynopsis("Sora est malade et s'ennuie toute seule chez elle. Elle nourrit les chats, mais ceux-ci se méfient.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[11][1280x720][x264-AAC][D1D99CA3].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep12');
			$release->setName("12");
			$release->setPreviewUrl("images/episodes/sketchbook12.jpg");
			$release->setLocalizedTitle("La Journée du carnet de croquis");
			$release->setOriginalTitle("Suketchibukku no Hi");
			$release->setSynopsis("Les héroïnes vont faire un tour en ville et au magasin d'art.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[12][1280x720][x264-AAC][DCB72C6B].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbook'), 'ep13');
			$release->setName("13");
			$release->setPreviewUrl("images/episodes/sketchbook13.jpg");
			$release->setLocalizedTitle("Seule dans l'atelier d'Art");
			$release->setOriginalTitle("Hitoribocchi no Bijutsubu");
			$release->setSynopsis("Tout d'abord, la fête des cerisiers. Puis Sora se rend dans l'atelier d'Art. Il n'y a personne. Elle en profite pour faire un superbe dessin.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Ryuseiken71"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS[01-13][1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS[13][1280x720][x264-AAC][A7CBEAF7].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbookdrama'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/sketchbookdrama1.jpg");
			$release->setLocalizedTitle("Viens, mon compagnon de voyage, mon carnet de croquis");
			$release->setSynopsis("Aso, Sora, Azuki, Kuga et Kurihara prennent le train pour se rendre dans une auberge. Sora en profite pour dessiner le paysage, mais elle semble éprouver quelques difficultés...");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Basti3n"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS_Picture_Drama[1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS_Picture_Drama[01][1280x720][x264-AAC][CBED00F5].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbookdrama'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/sketchbookdrama2.jpg");
			$release->setLocalizedTitle("Yo ! Maillot de bain, crabes et carnet de croquis");
			$release->setSynopsis("Aso, Sora, Azuki, Kuga et Kurihara attendent le bus pour la correspondance, mais elles le ratent de peu. Elles en profitent alors pour se rendre à la plage... Mais une surprise les attend.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Basti3n"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS_Picture_Drama[1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS_Picture_Drama[02][1280x720][x264-AAC][AE7F5B09].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbookdrama'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/sketchbookdrama3.jpg");
			$release->setLocalizedTitle("Bien ! Préparons le dîner ensemble à l'auberge.");
			$release->setSynopsis("Aso, Sora, Azuki, Kuga et Kurihara arrivent enfin à l'auberge. Mais il se fait tard. N'ayant toujours pas dîné, une surprise les attend...");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Basti3n"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS_Picture_Drama[1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS_Picture_Drama[03][1280x720][x264-AAC][1B6A47BB].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbookdrama'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/sketchbookdrama4.jpg");
			$release->setLocalizedTitle("Ah ! Tout le monde se réunit, un bain merveilleux.");
			$release->setSynopsis("Aso, Sora, Azuki, Kuga et Kurihara prennent leur bain à l'auberge. Aso semble vouloir se mesurer aux autres filles, mais Kuga lui tient tête.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Basti3n"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS_Picture_Drama[1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS_Picture_Drama[04][1280x720][x264-AAC][92D50766].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbookdrama'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/sketchbookdrama5.jpg");
			$release->setLocalizedTitle("Chuchotements. La nuit, les jeunes filles sont épuisées...");
			$release->setSynopsis("Sora, Azuki, Kuga et Kurihara sont sur le point de se coucher, mais c'était sans compter sur l'intervention d'Aso. La nuit ne fait que commencer...");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Basti3n"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS_Picture_Drama[1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS_Picture_Drama[05][1280x720][x264-AAC][B53E79D3].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('sketchbookdrama'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/sketchbookdrama6.jpg");
			$release->setLocalizedTitle("Ah... Dessin sur la plage.");
			$release->setSynopsis("Sora se lève tôt et en profite pour regarder le lever du soleil sur la plage. Les filles ne tardent pas à la rejoindre.");
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Basti3n"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Zero]Sketchbook_full_colorS_Picture_Drama[1280x720][x264-AAC]/[Zero]Sketchbook_full_colorS_Picture_Drama[06][1280x720][x264-AAC][15ADAD50].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/mariaholic1.jpg");
			$release->setLocalizedTitle("Baiser taquin");
			$release->setOriginalTitle("Tawamure no Seppun");
			$release->setSynopsis("Kanako entre à l'établissement d'Ame no Kisaki, en deuxième année de lycée. Elle espère y trouver son âme soeur et tombe sur Mariya, une jeune fille rayonnante de beauté. Son voeu serait-il déjà exaucé ?");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_01_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=QR10ODP0");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_01_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=4PVMJAPB");
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.anime-ultime.net/info-0-1/14895-MariaHolic_01", "Haute Définition"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/mariaholic2.jpg");
			$release->setLocalizedTitle("Douce souffrance");
			$release->setOriginalTitle("Kanbi na Uzuki");
			$release->setSynopsis("C'est le premier jour des cours, et donc débute la cérémonie d'entrée des nouvelles lycéennes. C'est Mariya qui a été choisit pour représenter les premières années.");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_02_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=Y78MDJ8N");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_02_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=C245NGHP");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_02_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=0GLF3ON4");
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->addStreaming(new NewWindowLink("http://www.anime-ultime.net/info-0-1/14895-MariaHolic_01", "Haute Définition"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/mariaholic3.jpg");
			$release->setLocalizedTitle("Masochisme Naissant");
			$release->setOriginalTitle("Higyaku no Wakame");
			$release->setSynopsis("Les péripéties de Kanako continuent. A nouveau la cible des fans de Ryuuken-sama, elle égare le très précieux rosaire de Mariya.");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_03_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=KQF8UBGT");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_03_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=XXCGO809");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_03_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=KCOLYG5L");
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/mariaholic4.jpg");
			$release->setLocalizedTitle("Le prix du plaisir");
			$release->setSynopsis("Le mystére de l'alaria continue. Ryuuken veut protéger à tout prix Kanako et devient son garde du corp. C'est évidemment l'effet inverse qui se produit...");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_04_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=OEYTSHJE");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_04_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=QBDEF5YO");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_04_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=GHRBCQ5H");
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/mariaholic5.jpg");
			$release->setLocalizedTitle("Parfum défendu /  Secrets de Jeune fille");
			$release->setSynopsis("Kanako va tout faire pour devenir amie avec Kiri-san. Aidée de ses deux amies, elle va monter toutes sortes de situations. Malheuresement, Kiri-san a du mal à comprendre le message...");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_05v2_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=E5EBJCI8");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_05v2_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=IVQ2WV3G");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_05_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=62FCUY58");
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/mariaholic6.jpg");
			$release->setLocalizedTitle("L'infirmerie de la perversion");
			$release->setSynopsis("Visite médicale pour toutes les filles du lycée. Kanako en est responsable et aura donc le droit de voir toutes les filles en soutien-gorge et de mesurer leurs poitrines ! Petit problème : Comment Mariya va-t'il faire ?");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_06_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=1CYBVNBY");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_06_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=9J0FGTPT");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_06_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=0PSTT5I0");
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep7');
			$release->setName("07");
			$release->setPreviewUrl("images/episodes/mariaholic7.jpg");
			$release->setLocalizedTitle("Le soutien-gorge noir suspect");
			$release->setSynopsis("Le grand mystère du soutien-gorge noir volé va enfin être résolu, après moultes péripéties ! On apprend en même temps que la jeune fille du tir à l'arc ne va pas très bien...");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_07_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=CRQF6K62");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_07_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=KJWCBFE4");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_07_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=CRQF6K62");
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep8');
			$release->setName("08");
			$release->setPreviewUrl("images/episodes/mariaholic8.jpg");
			$release->setLocalizedTitle("La vierge souillée partie 1");
			$release->setSynopsis("C'est bientôt le festival de la Sainte Vierge, et c'est à Kanako de s'en occuper. Problème : Elle n'y connaît rien. Solution : Demander l'aide de la présidente du conseil des élèves !");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_08_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_08_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=B8REP10I");
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_08_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setMegauploadUrl("http://www.megaupload.com/?d=SABWDYSR");
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->addBonus(new NewWindowLink("images/autre/moe%2065490%20angel%20cap%20maria_holic%20miyamae_kanako%20wings.png", "1"));
			$release->addBonus(new NewWindowLink("images/autre/moe%2065491%20angel%20cap%20inamori_yuzuru%20kimono%20maria_holic.png", "2"));
			$release->addBonus(new NewWindowLink("images/autre/moe%2065492%20angel%20cap%20kiri_nanami%20maria_holic%20megane%20wings.png", "3"));
			$release->addBonus(new NewWindowLink("images/autre/moe%2065493%20angel%20cap%20maria_holic%20momoi_sachi%20wings.png", "4"));
			$release->addBonus(new NewWindowLink("images/autre/moe%2065508%20angel%20cap%20maria_holic%20tagme.png", "5"));
			$release->addBonus(new NewWindowLink("images/autre/moe%2065509%20angel%20cap%20maria_holic.png", "6"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep9');
			$release->setName("09");
			$release->setPreviewUrl("images/episodes/mariaholic9.jpg");
			$release->setLocalizedTitle("La vierge souillée partie 1");
			$release->setSynopsis("C'est bientôt le festival de la Sainte Vierge, et c'est à Kanako de s'en occuper. Problème : Elle n'y connaît rien. Solution : Demander l'aide de la présidente du conseil des élèves !");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_09_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_09_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_09_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep10');
			$release->setName("10");
			$release->setPreviewUrl("images/episodes/mariaholic10.jpg");
			$release->setLocalizedTitle("La vierge souillée partie 1");
			$release->setSynopsis("Nos héroïnes ont râté l'examen et doivent donc passer le rattrapage. C'est pas gagné pour Kanako, qui visiblement n'a pas beaucoup suivi pendant l'année.");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_10_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_10_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_10_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep11');
			$release->setName("11");
			$release->setPreviewUrl("images/episodes/mariaholic11.jpg");
			$release->setSynopsis("Kanae Touichirou, professeur à Ame no Kisaki, est amoureux de Mariya mais fait passer son amour après son devoir de professeur, entre autre de se soucier des problèmes de \"santé fragile\" de Kanako, au grand déséspoir de celle-ci.");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_11_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_11_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_11_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('mariaholic'), 'ep12');
			$release->setName("12");
			$release->setPreviewUrl("images/episodes/mariaholic12.jpg");
			$release->setSynopsis("Enfin ! La piscine vient d'ouvrir ! Quel bonheur pour Kanako qui attendait ce moment avec impatience... Tant de jolies filles en maillots de bains... Résistera-t-elle ?");
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("Inuarth"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("La Mite en Pullover"), Role::getRole('check'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Constance"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Dunkelzahn"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("FinalFan"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("LeLapinBlanc"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("DC"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_12_[FIN]_[XVID_704x400].avi");
			$descriptor->setID("704x400");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Kanaii-Zero]_Maria+Holic_12_[FIN]_[X264_848x480].mkv");
			$descriptor->setID("848x480");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("Maria + Holic [01-12][X264_1280x720]/[Kanaii-Zero]_Maria+Holic_12_[FIN]_[X264_1280x720].mkv");
			$descriptor->setID("1280x720");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mkv);
			$descriptor->setTorrentUrl("http://mononoke-bt.org/browse.php?cat=1367#ptarget");
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayooav'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/potemayooav1.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_Special_[XVID_704x400]/[Zero]Potemayo_Special_01_[XVID_704x400][0509915C].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayooav'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/potemayooav2.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_Special_[XVID_704x400]/[Zero]Potemayo_Special_02_[XVID_704x400][9165F220].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayooav'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/potemayooav3.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_Special_[XVID_704x400]/[Zero]Potemayo_Special_03_[XVID_704x400][F59FE939].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayooav'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/potemayooav4.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_Special_[XVID_704x400]/[Zero]Potemayo_Special_04_[XVID_704x400][973E804F].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayooav'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/potemayooav5.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_Special_[XVID_704x400]/[Zero]Potemayo_Special_05_[XVID_704x400][B119F595].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayooav'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/potemayooav6.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_Special_[XVID_704x400]/[Zero]Potemayo_Special_06_[XVID_704x400][2827BF0B].avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep1');
			$release->setName("[01] 01 + 02");
			$release->setPreviewUrl("images/episodes/potemayo1.jpg");
			$release->setLocalizedTitle("01 : Potemayo / 02 : Invasion ! Créatures mystérieuses !!");
			$release->setSynopsis("Moriyama trouve une drôle de bestiole dans son frigo et la surnome alors Potemayo. Il l'enmene en classe, ou la créature attise la curioisité de tout le monde. Et puis d'autres créatures arrivent.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_01_[H264-AAC][5F560FCF].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep2');
			$release->setName("[02] 03 + 04");
			$release->setPreviewUrl("images/episodes/potemayo2.jpg");
			$release->setLocalizedTitle("03 : Aimant cet enfant / 04 : Dimanche");
			$release->setSynopsis("Moriyama trouve une drôle de bestiole dans son frigo et la surnome alors Potemayo. Il l'enmene en classe, ou la créature attise la curioisité de tout le monde. Et puis d'autres créatures arrivent.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_02_[H264-AAC][50DA4D18].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep3');
			$release->setName("[03] 05 + 06");
			$release->setPreviewUrl("images/episodes/potemayo3.jpg");
			$release->setLocalizedTitle("05 : Le miracle de la veille de noël / 06 : C'est soudainement le nouvel an");
			$release->setSynopsis("Moriyama trouve une drôle de bestiole dans son frigo et la surnome alors Potemayo. Il l'enmene en classe, ou la créature attise la curioisité de tout le monde. Et puis d'autres créatures arrivent.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_03_[H264-AAC][936F924F].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep4');
			$release->setName("[04] 07 + 08");
			$release->setPreviewUrl("images/episodes/potemayo4.jpg");
			$release->setLocalizedTitle("07 : En parlant de février, c'est la veille du printemps / 08 : Un matin atchoum");
			$release->setSynopsis("Moriyama trouve une drôle de bestiole dans son frigo et la surnome alors Potemayo. Il l'enmene en classe, ou la créature attise la curioisité de tout le monde. Et puis d'autres créatures arrivent.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_04_[H264-AAC][69FD511B].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep5');
			$release->setName("[05] 09 + 10");
			$release->setPreviewUrl("images/episodes/potemayo5.jpg");
			$release->setLocalizedTitle("09 : Un grand nombre de souvenirs profonds / 10 : Changements de printemps.");
			$release->setSynopsis("Guchiko découvre la maison de sa chère amie. La maid de cette dernière est sous le charme et veut l'adopter. Un nouvel élève arrive.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_05_[H264-AAC][5230A764].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep6');
			$release->setName("[06] 11 + 12");
			$release->setPreviewUrl("images/episodes/potemayo6.jpg");
			$release->setLocalizedTitle("11 : une vie merveilleuse / 12 : en parlant de l'été, c'est une piscine.");
			$release->setSynopsis("Tout le monde part pour la maison de vacances de Nene.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_06_[H264-AAC][9201895B].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep7');
			$release->setName("[07] 13 + 14");
			$release->setPreviewUrl("images/episodes/potemayo7.jpg");
			$release->setLocalizedTitle("13 : La fin de l'été / 14 : La nuit du festival.");
			$release->setSynopsis("C'est les vacances, Mikan raconte à sa grand-mère comment elle a rencontré Moriyama pendant que celui-ci va prier sur la tombe de sa mère. Ensuite, c'est le festival ! Et Potemayo va devoir gérer son argent pour la première fois. Que va-t-elle acheter ?");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_07_[H264-AAC][9C46F9AB].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep8');
			$release->setName("[08] 15 + 16");
			$release->setPreviewUrl("images/episodes/potemayo8.jpg");
			$release->setLocalizedTitle("15 : Les courses / 16 : L'hiver est arrivé");
			$release->setSynopsis("Il reste un peu d'argent à Potemayo qui va apprebndre à faire les courses toute seule. Guchiko a volé des chataîgnes. Il neige ! Potemayo n'a jamais vu ça. Elle ne sait pas que c'est froid.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_08_[H264-AAC][8840F56E].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep9');
			$release->setName("[09] 17 + 18");
			$release->setPreviewUrl("images/episodes/potemayo9.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_09_[H264-AAC][8DABC90D].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep10');
			$release->setName("[10] 19 + 20");
			$release->setPreviewUrl("images/episodes/potemayo10.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_10_[H264-AAC][135EA954].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep11');
			$release->setName("[11] 21 + 22");
			$release->setPreviewUrl("images/episodes/potemayo11.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_11_[H264-AAC][C363017C].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('potemayo'), 'ep12');
			$release->setName("[12] 23 + 24");
			$release->setPreviewUrl("images/episodes/potemayo12.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Potemayo_[H264-AAC]/[Zero]Potemayo_12_[H264-AAC][34A6C33D].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/kujibiki1.jpg");
			$release->setLocalizedTitle("Tous le monde a des surprises à l'école. 7 points.?");
			$release->setOriginalTitle("Minna, gakko de odoroku. Nana-ten ?");
			$release->setSynopsis("C'est la rentrée pour Chihiro et Tokino. Un tirage au sort est organisé pour determiner les rôles de chacun au sein de l'établissement. Chihiro, connu pour être malchanceux, senble avoir tiré le gros lot... ou pas.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[01v2][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/kujibiki2.jpg");
			$release->setLocalizedTitle("Ce n'est pas bien de ne pas tenir ses promesses. 2 points.?");
			$release->setOriginalTitle("Yakusoku o mamorenai to dame da. Ni-ten ?");
			$release->setSynopsis("L'apprentissage pour devenir le prochain conseil va être devoilé par le conseil actuel...");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[02v2][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/kujibiki3.jpg");
			$release->setLocalizedTitle("Relations douloureuses entre frère et soeur. 6 points.");
			$release->setOriginalTitle("Kyodai ga taihen da. Roku-ten ?");
			$release->setSynopsis("Un panda s'est échapé du zoo et nos héros ont pour mission de le retrouver.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[03v2][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/kujibiki4.jpg");
			$release->setLocalizedTitle("Un dimanche de jeux. 5 points.");
			$release->setOriginalTitle("Nichiyobi ni asobo ka. Go-ten");
			$release->setSynopsis("C'est dimanche, enfin un jour de repos pour les futurs membres du conseil ! Et pourtant, Tokino veut retourner à l'école...");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[04v2][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/kujibiki5.jpg");
			$release->setLocalizedTitle("Les amis pourraient changer. 1 point.");
			$release->setOriginalTitle("Tomodachi ga wakaru ka mo shirenai. It-ten");
			$release->setSynopsis("Vacances scolaires arrivent ! Le conseil va-t-il passer les vacances ensemble ? Renko semble avoir autre chose à faire...");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[05v2][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/kujibiki6.jpg");
			$release->setLocalizedTitle("Je le garderai secret pour toujours. 8 points.");
			$release->setOriginalTitle("Zettai, naisho ni shite oko. Hachi-ten");
			$release->setSynopsis("Le journal de Rikkyouin a de moins en moins de succés. La nouvelle mission du futur conseil des élèves est de trouver un scoop pour faire remonter les ventes du fameux journal.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[06v2][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->addBonus(new NewWindowLink("radio/mp3/Love!%20Yes!%20No%20~%20Hateshinai%20Ai%20de.mp3", "LOVE! YES! NO ~ Hateshinai Ai de.mp3"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep7');
			$release->setName("07");
			$release->setPreviewUrl("images/episodes/kujibiki7.jpg");
			$release->setLocalizedTitle("Bien écouter la bonne personne. 4 points.");
			$release->setOriginalTitle("Erai hito no hanashi o kiku. Yon-ten");
			$release->setSynopsis("Des éspions se cachent partout à Rikkyouin. À titre d'entraînement, nos héros vont devoir en demasqué un. Ils seront aidés par Tachibana, une \"amie\" de Tokino.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[07v2][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep8');
			$release->setName("08");
			$release->setPreviewUrl("images/episodes/kujibiki8.jpg");
			$release->setLocalizedTitle("J'ai oublie le passe. 7 points.");
			$release->setOriginalTitle("Mukashi no koto o wasurete iru. Nana-ten");
			$release->setSynopsis("C'est l'anniversaire de Ric-chan. Chihiro et Tsukino decident de venir le lui souhaiter, mais difficile pour eux de convaincre le vigile de les laisser rentrer dans une fete si prestigieuse.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[08v2][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep9');
			$release->setName("09");
			$release->setPreviewUrl("images/episodes/kujibiki9.jpg");
			$release->setLocalizedTitle("Les feux d'artifice sont jolis. 5 points.");
			$release->setOriginalTitle("Hanabi ga kirei ni mieta. Go-ten");
			$release->setSynopsis("Le grand feu d'artifice annuel de Rikkyouin est sur le point de commencer ! C'est la fête pour tout le monde ! Sauf pour nos amis du futur conseil des élèves qui ont perdu la trace de Renko et doivent être prêts à 19 heure pour receptionner les invités VIP.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[09v2][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->addBonus(new NewWindowLink("ddl/%5bZero%5dKujibiki_Unbalance%5b09%5d%5bScreenshots%5d.zip", "Pack de Screenshots"));
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep10');
			$release->setName("10");
			$release->setPreviewUrl("images/episodes/kujibiki10.jpg");
			$release->setLocalizedTitle("Nous le cherchions mais il n'était pas là. 3 points.");
			$release->setOriginalTitle("Sagashite mo, soko ni wa nai. San-ten");
			$release->setSynopsis("Koyuki se fait kidnapper !");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[10][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep11');
			$release->setName("11");
			$release->setPreviewUrl("images/episodes/kujibiki11.jpg");
			$release->setLocalizedTitle("Trébucher dans le noir. 0 point.");
			$release->setOriginalTitle("Kurai tokoro de tsumazuku. Zero-ten");
			$release->setSynopsis("Chihiro commence à douter de lui.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[11][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kujibiki'), 'ep12');
			$release->setName("12");
			$release->setPreviewUrl("images/episodes/kujibiki12.jpg");
			$release->setLocalizedTitle("Que nos rêves deviennent réalité. 9 points.");
			$release->setOriginalTitle("Yume o kanaete miyo. Kyu-ten");
			$release->setSynopsis("Tokino perd sa chance à cause de Chihiro.");
			$descriptor = new ReleaseFileDescriptor("[Zero]Kujibiki_Unbalance_2[HD][H264-AAC]/[Zero]Kujibiki_Unbalance[12][HD][H264-AAC].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/tayutama1.png");
			$release->setLocalizedTitle("Tayutai");
			$release->setOriginalTitle("Tayutai");
			$release->setComment("<b>Staff Maboroshi</b> <a href='http://www.maboroshinofansub.fr/' target='_blank'><img src='images/partenaires/mnf.png' alt='Maboroshinofansub' border='0'></a>");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_01.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_01.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/tayutama2.png");
			$release->setLocalizedTitle("Chez Mashiro");
			$release->setComment("<b>Staff Maboroshi</b> <a href='http://www.maboroshinofansub.fr/' target='_blank'><img src='images/partenaires/mnf.png' alt='Maboroshinofansub' border='0'></a>");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_02.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_02.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/tayutama3.png");
			$release->setLocalizedTitle("Mashiro toute seule");
			$release->setComment("<b>Staff Maboroshi</b> <a href='http://www.maboroshinofansub.fr/' target='_blank'><img src='images/partenaires/mnf.png' alt='Maboroshinofansub' border='0'></a>");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_03.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_03.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/tayutama4.png");
			$release->setLocalizedTitle("Une jeune fille en détresse");
			$release->setComment("<b>Staff Maboroshi</b> <a href='http://www.maboroshinofansub.fr/' target='_blank'><img src='images/partenaires/mnf.png' alt='Maboroshinofansub' border='0'></a>");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_04.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_04.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/tayutama5.png");
			$release->setLocalizedTitle("La pluie qui passe");
			$release->setComment("<b>Staff Maboroshi</b> <a href='http://www.maboroshinofansub.fr/' target='_blank'><img src='images/partenaires/mnf.png' alt='Maboroshinofansub' border='0'></a>");
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_05.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_05.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/tayutama6.png");
			$release->setLocalizedTitle("Couple intime");
			$release->addStaff(TeamMember::getMemberByPseudo("Kuenchinu"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tohru"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Pyra"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_06.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_06.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep7');
			$release->setName("07");
			$release->setPreviewUrl("images/episodes/tayutama7.png");
			$release->setLocalizedTitle("Couple intime");
			$release->addStaff(TeamMember::getMemberByPseudo("Kuenchinu"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tohru"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Pyra"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_07.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_07.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep8');
			$release->setName("08");
			$release->setPreviewUrl("images/episodes/tayutama8.png");
			$release->setLocalizedTitle("Les yeux pleins d'envie");
			$release->addStaff(TeamMember::getMemberByPseudo("Kuenchinu"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tohru"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Pyra"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_08.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_08.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep9');
			$release->setName("09");
			$release->setPreviewUrl("images/episodes/tayutama9.png");
			$release->setLocalizedTitle("Les yeux pleins d'envie");
			$release->addStaff(TeamMember::getMemberByPseudo("Kuenchinu"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Khorx"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tohru"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("db0"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Pyra"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_09.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_09.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep10');
			$release->setName("10");
			$release->setPreviewUrl("images/episodes/tayutama10.png");
			$release->setLocalizedTitle("La paix interdite");
			$release->addStaff(TeamMember::getMemberByPseudo("youg40"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tohru"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tohru"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Pyra"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_10.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_10.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep11');
			$release->setName("11");
			$release->setPreviewUrl("images/episodes/tayutama11.png");
			$release->setLocalizedTitle("Bataille finale");
			$release->addStaff(TeamMember::getMemberByPseudo("youg40"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tohru"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tohru"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Pyra"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_11.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_11.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutama'), 'ep12');
			$release->setName("12");
			$release->setPreviewUrl("images/episodes/tayutama12.png");
			$release->setLocalizedTitle("Yuuri");
			$release->addStaff(TeamMember::getMemberByPseudo("youg40"), Role::getRole('tradEn'));
			$release->addStaff(TeamMember::getMemberByPseudo("Praia"), Role::getRole('time'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tohru"), Role::getRole('kara'));
			$release->addStaff(TeamMember::getMemberByPseudo("Tohru"), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMemberByPseudo("Pyra"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("praia"), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMemberByPseudo("Lepims"), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_12.avi");
			$descriptor->setVideoCodec($xvid);
			$descriptor->setSoundCodec($mp3);
			$descriptor->setContainerCodec($avi);
			$release->addFileDescriptor($descriptor);
			$descriptor = new ReleaseFileDescriptor("[Maboroshi-Zero]Tayutama_Kiss_on_my_deity/[Maboroshi-Zero]Tayutama_Kiss_on_my_deity_12.mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutamapure'), 'ep1');
			$release->setName("01");
			$release->setPreviewUrl("images/episodes/tayutamapure1.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Tayutama_Special_01[H264-AAC][E9A75CE2].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutamapure'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("images/episodes/tayutamapure2.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Tayutama_Special_02[H264-AAC][0FCEFF3E].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutamapure'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("images/episodes/tayutamapure3.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Tayutama_Special_03[H264-AAC][5D184DF7].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutamapure'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("images/episodes/tayutamapure4.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Tayutama_Special_04[H264-AAC][AD60C070].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutamapure'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("images/episodes/tayutamapure5.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Tayutama_Special_05[H264-AAC][5BFA8315].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('tayutamapure'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("images/episodes/tayutamapure6.jpg");
			$descriptor = new ReleaseFileDescriptor("[Zero]Tayutama_Special_06[H264-AAC][948823A3].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
		}
		return Release::$allReleases;
	}
	
	public static function getAllReleasesForProject($id) {
		$list = array();
		foreach(Release::getAllReleases() as $release) {
			if ($release->getProject()->getID() === $id) {
				$list[] = $release;
			}
		}
		return $list;
	}
	
	public static function getRelease($projectId, $releaseId) {
		foreach(Release::getAllReleasesForProject($projectId) as $release) {
			if ($release->getID() === $releaseId) {
				return $release;
			}
		}
		$project = Project::getProject($projectId);
		throw new Exception($releaseId." is not a known release ID for ".$project->getName().".");
	}
}

class Assignment {
	private $member = null;
	private $roles = array();
	
	public function __construct(TeamMember $member) {
		$this->member = $member;
	}
	
	public function getTeamMember() {
		return $this->member;
	}
	
	public function getRoles() {
		return $this->roles;
	}
	
	public function assign(Role $role) {
		foreach($this->roles as $assigned) {
			if ($assigned->getID() === $role->getID()) {
				return;
			}
		}
		$this->roles[] = $role;
	}
}

class ReleaseFileDescriptor {
	private $id = null;
	private $fileName = null;
	private $videoCodec = null;
	private $soundCodec = null;
	private $containerCodec = null;
	private $crc = null;
	private $megauploadUrl = null;
	private $freeUrl = null;
	private $rapidShareUrl = null;
	private $mediaFireUrl = null;
	private $torrentUrl = null;
	private $comment = null;
	private $pageNumber = null;
	
	public function __construct($name = null) {
		$this->setFilePath($name);
	}
	
	public function getFilePath() {
		return $this->fileName;
	}
	
	public function setFilePath($fileName) {
		$this->fileName = $fileName;
	}
	
	public function getVideoCodec() {
		return $this->videoCodec;
	}
	
	public function setVideoCodec(VideoCodec $videoCodec) {
		$this->videoCodec = $videoCodec;
	}
	
	public function getSoundCodec() {
		return $this->soundCodec;
	}
	
	public function setSoundCodec(SoundCodec $soundCodec) {
		$this->soundCodec = $soundCodec;
	}
	
	public function getContainerCodec() {
		return $this->containerCodec;
	}
	
	public function setContainerCodec(ContainerCodec $containerCodec) {
		$this->containerCodec = $containerCodec;
	}
	
	public function getCRC() {
		return $this->crc;
	}
	
	public function setCRC($crc) {
		$this->crc = $crc;
	}
	
	public function getMegauploadUrl() {
		return $this->megauploadUrl;
	}
	
	public function setMegauploadUrl($url) {
		$this->megauploadUrl = $url;
	}
	
	public function getFreeUrl() {
		return $this->freeUrl;
	}
	
	public function setFreeUrl($url) {
		$this->freeUrl = $url;
	}
	
	public function getRapidShareUrl() {
		return $this->rapidShareUrl;
	}
	
	public function setRapidShareUrl($url) {
		$this->rapidShareUrl = $url;
	}
	
	public function getMediaFireUrl() {
		return $this->mediaFireUrl;
	}
	
	public function setMediaFireUrl($url) {
		$this->mediaFireUrl = $url;
	}
	
	public function getTorrentUrl() {
		return $this->torrentUrl;
	}
	
	public function setTorrentUrl($url) {
		$this->torrentUrl = $url;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getComment() {
		return $this->comment;
	}
	
	public function setComment($comment) {
		$this->comment = $comment;
	}
	
	public function getPageNumber() {
		return $this->pageNumber;
	}
	
	public function setPageNumber($pageNumber) {
		$this->pageNumber = $pageNumber;
	}
}
?>
