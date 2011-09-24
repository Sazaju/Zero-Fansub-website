<?php
/*
	The member list display a list of members. Because of that it only take in charge TeamMember
	elements.
*/

class MemberList extends SimpleListComponent {
	public function __construct() {
		$this->setClass("teamList");
	}
	
	public function addComponent($member) {
		if (!($member instanceof TeamMember)) {
			throw new Exception('The given element is not a member');
		}
		
		$list = new SimpleListComponent();
		$list->setClass("member");
		parent::addComponent($list);
		
		$image = $member->getImage();
		$list->addComponent($image);
		
		$pseudo = $member->getPseudo();
		$list->addComponent("<b>".$pseudo."</b>");
		
		$role = $member->getRole();
		if ($role !== null) {
			$list->addComponent("<b>R&ocirc;le</b> ".$role);
		}
		
		$firstName = $member->getFirstName();
		if ($firstName !== null) {
			$list->addComponent("<b>Pr&eacute;nom</b> ".$firstName);
		}
		
		$age = $member->getAge();
		if ($age !== null) {
			$list->addComponent("<b>&Acirc;ge</b> ".$age);
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