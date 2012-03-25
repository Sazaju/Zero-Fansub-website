<?php
/*
	A release source is the type of multimedia used to get the video/audio.
*/
class ReleaseSource {
	private $id = null;
	private $name = null;
	
	public function __construct($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function __toString() {
		return $this->getName();
	}
	
	public static $allSources = null;
	public static function getAllSources() {
		if (ReleaseSource::$allSources === null) {
			ReleaseSource::$allSources = array();
			ReleaseSource::$allSources[] = new ReleaseSource("DVD", "DVD");
			ReleaseSource::$allSources[] = new ReleaseSource("BD", "Blu-Ray");
		}
		return ReleaseSource::$allSources;
	}
	
	public static function getSource($id) {
		foreach(ReleaseSource::getAllSources() as $source) {
			if ($source->getID() === $id) {
				return $source;
			}
		}
		throw new Exception($id." is not a known source ID.");
	}
}
?>