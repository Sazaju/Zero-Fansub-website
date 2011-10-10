<?php
/*
	A role identify the work a member is able to do.
*/
class Role {
	private $id = null;
	private $name = null;
	
	public function __construct($id = null, $name = null) {
		$this->setID($id);
		$this->setName($name);
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
	
	private static $allRoles = null;
	public static function getAllRoles() {
		if (Role::$allRoles === null) {
			Role::$allRoles = array();
			Role::$allRoles[] = new Role('admin', 'administration');
			Role::$allRoles[] = new Role('webadmin', 'administration web');
			Role::$allRoles[] = new Role('forumadmin', 'administration forum');
			Role::$allRoles[] = new Role('raw', 'RAW hunting');
			Role::$allRoles[] = new Role('tradEn', 'traduction En>Fr');
			Role::$allRoles[] = new Role('tradJp', 'traduction Jp>Fr');
			Role::$allRoles[] = new Role('adapt', 'adaptation');
			Role::$allRoles[] = new Role('time', 'time');
			Role::$allRoles[] = new Role('edit', 'édition');
			Role::$allRoles[] = new Role('kara', 'karaoke');
			Role::$allRoles[] = new Role('qc', 'QC');
			Role::$allRoles[] = new Role('verifFinale', 'v&eacute;rif finale');
			Role::$allRoles[] = new Role('encod', 'encodage');
			Role::$allRoles[] = new Role('sorties', 'sorties');
			Role::$allRoles[] = new Role('torrent', 'tracker BT');
			Role::$allRoles[] = new Role('xdcc', 'XDCC');
		}
		return Role::$allRoles;
	}
	
	public static function getRole($id) {
		foreach(Role::getAllRoles() as $role) {
			if ($role->getID() === $id) {
				return $role;
			}
		}
		throw new Exception($id." is not a known role ID.");
	}
}
?>
