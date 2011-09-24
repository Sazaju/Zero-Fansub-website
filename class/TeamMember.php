<?php
/*
	A team member is a person participating in the team.
*/
class TeamMember {
	private $image;
	private $pseudo;
	private $role;
	private $age;
	private $location;
	private $mail;
	private $website;
	private $firstName;
	
	public function __construct() {
		$this->image = new Image();
	}
	
	public function setImage($imageName) {
		$this->image->setSource("images/team/".$imageName);
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
	
	public function setRole($role) {
		$this->role = $role;
	}
	
	public function getRole() {
		return $this->role;
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
	
	public function setWebsite($address, $name = null) {
		if ($address !== null) {
			$this->website = new Link($address, $name);
		}
		else {
			$this->website = null;
		}
	}
	
	public function getWebsite() {
		return $this->website;
	}
}
?>