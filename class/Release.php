<?php
/*
	A release is a file (or a group of coupled files) which has been created by the team.
*/
class Release {
	private $project = null;
	private $id = null;
	private $name = null;
	private $previewUrl = null;
	private $fileName = null;
	private $videoCodec = null;
	private $soundCodec = null;
	private $containerCodec = null;
	private $torrentId = null;
	private $synopsis = null;
	private $originalName = null;
	private $localizedName = null;
	private $isReleased = false;
	private $staff = array();
	
	public function __construct(Project $project, $id = null) {
		$this->setProject($project);
		$this->setID($id);
	}
	
	public function getProject() {
		return $this->project;
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
	
	public function getTorrentID() {
		return $this->torrentId;
	}
	
	public function setTorrentID($torrentId) {
		$this->torrentId = $torrentId;
	}
	
	public function getSynopsis() {
		return $this->synopsis;
	}
	
	public function setSynopsis($synopsis) {
		$this->synopsis = $synopsis;
	}
	
	public function getOriginalName() {
		return $this->originalName;
	}
	
	public function setOriginalName($originalName) {
		$this->originalName = $originalName;
	}
	
	public function getLocalizedName() {
		return $this->localizedName;
	}
	
	public function setLocalizedName($localizedName) {
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
		return $this->isReleased;
	}
	
	public function setIsReleased($boolean) {
		$this->isReleased = $boolean;
	}
	
	public static $allReleases = null;
	public static function getAllReleases() {
		if (Release::$allReleases === null) {
			Release::$allReleases = array();
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep0");
			$release->setName("preview");
			$release->setPreviewUrl("images/episodes/mitsudomoepreview.jpg");
			$release->setFileName("[Zero]Mitsudomoe_Preview[Xvid-MP3][5ED85545].avi");
			$release->setVideoCodec(Codec::getCodec("xvid"));
			$release->setSoundCodec(Codec::getCodec("mp3"));
			$release->setContainerCodec(Codec::getCodec("avi"));
			$release->setTorrentID(26);
			$release->setSynopsis("Bande-Annonce de la série Mitsudomoe qui débutera en juillet 2010.");
			$release->setOriginalName("Trailer");
			$release->setLocalizedName("Bande-Annonce");
			$release->addStaff(TeamMember::getMember(5), Role::getRole('tradJp'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('adapt'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('time'));
			$release->addStaff(TeamMember::getMember(1), Role::getRole('edit'));
			$release->addStaff(TeamMember::getMember(8), Role::getRole('qc'));
			$release->addStaff(TeamMember::getMember(6), Role::getRole('encod'));
			$release->setIsReleased(true);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep13");
			$release->setName("épisode 13");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep2");
			$release->setName("épisode 2");
			$release->setPreviewUrl("images/episodes/mitsudomoe2.jpg");
			$release->setFileName("[Zero]Mitsudomoe_02[H264-AAC][D324A25E].mp4");
			$release->setVideoCodec(Codec::getCodec("h264"));
			$release->setSoundCodec(Codec::getCodec("aac"));
			$release->setContainerCodec(Codec::getCodec("mp4"));
			$release->setIsReleased(true);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep1");
			$release->setName("épisode 1");
			$release->setPreviewUrl("images/episodes/mitsudomoe1.jpg");
			$release->setFileName("[Zero]Mitsudomoe_01[H264-AAC][A551786E].mp4");
			$release->setVideoCodec(Codec::getCodec("h264"));
			$release->setSoundCodec(Codec::getCodec("aac"));
			$release->setContainerCodec(Codec::getCodec("mp4"));
			$release->setIsReleased(true);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep3");
			$release->setName("épisode 3");
			$release->setPreviewUrl("images/episodes/mitsudomoe3.jpg");
			$release->setFileName("[Zero]Mitsudomoe_03[H264-AAC][8C7C6BC3].mp4");
			$release->setVideoCodec(Codec::getCodec("h264"));
			$release->setSoundCodec(Codec::getCodec("aac"));
			$release->setContainerCodec(Codec::getCodec("mp4"));
			$release->setIsReleased(true);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep4");
			$release->setName("épisode 4");
			$release->setPreviewUrl("images/episodes/mitsudomoe4.jpg");
			$release->setFileName("[Zero]Mitsudomoe_04[H264-AAC][A9514039].mp4");
			$release->setVideoCodec(Codec::getCodec("h264"));
			$release->setSoundCodec(Codec::getCodec("aac"));
			$release->setContainerCodec(Codec::getCodec("mp4"));
			$release->setIsReleased(true);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep5");
			$release->setName("épisode 5");
			$release->setPreviewUrl("images/episodes/mitsudomoe5.jpg");
			$release->setFileName("[Zero]Mitsudomoe_05[H264-AAC][199319E2].mp4");
			$release->setVideoCodec(Codec::getCodec("h264"));
			$release->setSoundCodec(Codec::getCodec("aac"));
			$release->setContainerCodec(Codec::getCodec("mp4"));
			$release->setIsReleased(true);
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep7");
			$release->setName("épisode 7");
			Release::$allReleases[] = $release;
			
			$release = new Release(Project::getProject("mitsudomoe"), "ep6");
			$release->setName("épisode 6");
			$release->setPreviewUrl("images/episodes/mitsudomoe6.jpg");
			$release->setFileName("[Zero]Mitsudomoe_06[H264-AAC][43B2986A].mp4");
			$release->setVideoCodec(Codec::getCodec("h264"));
			$release->setSoundCodec(Codec::getCodec("aac"));
			$release->setContainerCodec(Codec::getCodec("mp4"));
			$release->setIsReleased(true);
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
?>