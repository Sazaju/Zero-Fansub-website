<?php
/*
	A license identify and describe the official owner of a release or project. It means the
	release/project has been licensed and should not be fansubbed anymore. Especially, all the
	concerned releases should not be available for downloading.
*/
class License {
	private static $noDataLicense = null;
	public static function getDefaultLicense() {
		if (License::$noDataLicense === null) {
			License::$noDataLicense = new License(null);
		}
		return License::$noDataLicense;
	}
	
	private $name = null;
	
	public function __construct($name) {
		$this->setName($name);
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
}
?>
