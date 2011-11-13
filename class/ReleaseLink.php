<?php
/*
	A release link is a link to a specific release.
*/

class ReleaseLink extends IndexLink {
	private $projectId = null;
	private $releaseId = null;
	
	public function __construct($projectId, $releaseId, $content = null) {
		$this->setProjectId($projectId);
		$this->setReleaseId($releaseId);
		
		if ($content === null) {
			$release = Release::getRelease($projectId, $releaseId);
			$content = $release->getName();
			$content = $release->getProject()->getName().($content == null ? null : " - ".$content);
		}
		$this->setContent($content);
	}
	
	public function setUrl($url) {
		throw new Exception("You cannot change the URL directly, change the project/release ID.");
	}
	
	public function updateUrl() {
		parent::setUrl('page=series/'.$this->projectId.'&show='.$this->releaseId.'#'.$this->releaseId);
	}
	
	public function setProjectID($id) {
		$this->projectId = $id;
		$this->updateUrl();
	}
	
	public function getProjectID() {
		return $this->projectId;
	}
	
	public function setReleaseID($id) {
		$this->releaseId = $id;
		$this->updateUrl();
	}
	
	public function getReleaseID() {
		return $this->releaseId;
	}
}
?>
