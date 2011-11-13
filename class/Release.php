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
	
	public function getName() {
		return $this->name;
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
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep7");
			$release->setName("épisode 7");
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
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep8");
			$release->setName("épisode 8");
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
			$release->setSynopsis("Keita n'arrive pas à se concentrer car ses soeurs l'embrassent trop souvent. Il d&eacute;cide donc que les baisers sont interdits. Ako et Riko arriveront-elles à le faire changer d'avis ?");
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
			
			$release = new Release(Project::getProject('akinahshiyo'), 'ep1');
			$release->setName("OAV 01");
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
			$release->addStaff(TeamMember::getMember(22), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo 1[H264-AAC][C8DFA639].mp4");
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
			$release->addStaff(TeamMember::getMember(21), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo 2[H264-AAC][9C9F3B0D].mp4");
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
			$release->addStaff(TeamMember::getMember(21), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo 3[H264-AAC][9AD925EF].mp4");
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
			$release->addStaff(TeamMember::getMember(21), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo 4[H264-AAC][F49AEB5B].mp4");
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
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('verifFinale'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(22), Role::getRole('encod'));
			$descriptor = new ReleaseFileDescriptor("[FFS-Zero]Isshoni H Shiyo 5[H264-AAC][34432851].mp4");
			$descriptor->setVideoCodec($h264);
			$descriptor->setSoundCodec($aac);
			$descriptor->setContainerCodec($mp4);
			$release->addFileDescriptor($descriptor);
			$release->setReleasingTime(0);
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
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/01/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/01/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/01/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/01/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep2');
			$release->setName("02");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/02/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/02/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/02/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/02/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep3');
			$release->setName("03");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/03/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/03/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/03/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/03/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep4');
			$release->setName("04");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/04/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/04/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/04/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/04/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep5');
			$release->setName("05");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/05/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/05/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/05/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/05/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep6');
			$release->setName("06");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/06/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/06/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/06/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/06/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep7');
			$release->setName("07");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/07/main.jpg");
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep8');
			$release->setName("08");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/08/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/08/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/08/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/08/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep9');
			$release->setName("09");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/09/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/09/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/09/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/09/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep10');
			$release->setName("10");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/10/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/10/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/10/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/10/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep11');
			$release->setName("11");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/11/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/11/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/11/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/11/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep12');
			$release->setName("12");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/12/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/12/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/12/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/12/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep13');
			$release->setName("13");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/13/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/13/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/13/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/13/04.jpg" border="0" />
			*/
			$release->setReleasingTime(0);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject('kannagi'), 'ep14');
			$release->setName("14");
			$release->setPreviewUrl("http://www.nagisama-fc.com/anime/oa/image/14/01.jpg");
			/* TODO preview
<img src="http://www.nagisama-fc.com/anime/oa/image/14/01.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/14/03.jpg" border="0" />
<img src="http://www.nagisama-fc.com/anime/oa/image/14/04.jpg" border="0" />
			*/
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
		return null;
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
		$this->setFileName($name);
	}
	
	public function getFileName() {
		return $this->fileName;
	}
	
	public function setFileName($fileName) {
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
