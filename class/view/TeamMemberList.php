<?php
/*
	The team member list display a list of members. Because of that it only take in charge TeamMember
	elements.
*/

class TeamMemberList extends SimpleListComponent {
	public function __construct() {
		$this->setClass("teamList");
	}
	
	public function addComponent($member) {
		if (!($member instanceof TeamMember)) {
			throw new Exception('The given element is not a member.');
		}
		
		$list = new SimpleListComponent();
		$list->setClass("member");
		parent::addComponent($list);
		
		$image = $member->getImage();
		if ($image->getUrl() != null) {
			$list->addComponent($image);
		}
		
		$pseudo = $member->getPseudo();
		$list->addComponent("<b>".$pseudo."</b>");
		
		$roles = $member->getRoles();
		$description = "<b>Rôle</b> ";
		if (!empty($roles)) {
			$isFirst = true;
			foreach($roles as $role) {
				if ($isFirst) {
					$description .= ucfirst($role->getName());
					$isFirst = false;
				}
				else {
					$description .= ', '.$role->getName();
				}
			}
		}
		else {
			$description .= "Rien";
		}
		$list->addComponent($description.".");
		
		$firstName = $member->getFirstName();
		if ($firstName !== null) {
			$list->addComponent("<b>Prénom</b> ".$firstName);
		}
		
		$age = $member->getAge();
		if ($age !== null) {
			if (is_numeric($age)) {
				if ($age > 1000) {
					$age = time() - $age;
					$age /= 60*60*24*365.25;
					$age = floor($age);
				}
				$age = $age." ans";
			}
			$list->addComponent("<b>Âge</b> ".$age);
		}
		
		$location = $member->getLocation();
		if ($location !== null) {
			$list->addComponent("<b>Lieu</b> ".$location);
		}
		
		$mail = $member->getMail();
		if ($mail !== null) {
			$wrap = new SimpleTextComponent("<b>Contact</b> ");
			$wrap->addComponent(new MailLink($mail));
			$list->addComponent($wrap);
		}
		
		$website = $member->getWebsite();
		if ($website !== null) {
			$wrap = new SimpleTextComponent("<b>Site Web</b> ");
			$wrap->addComponent($website);
			$list->addComponent($wrap);
		}
	}
}
?>