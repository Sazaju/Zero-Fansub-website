<?php
/*
	The member list display a list of members. Because of that it only take in charge TeamMember
	elements.
*/

class MemberList extends SimpleListComponent {
	public function __construct() {
		$this->setClass("teamList");
	}
	
	public function add($member) {
		if (!($member instanceof TeamMember)) {
			throw new Exception('The given element is not a member');
		}
		
		$list = new SimpleListComponent();
		$list->setClass("member");
		$this->addComponent($list);
		
		$image = $member->getImage();
		$list->add($image);
		
		$pseudo = $member->getPseudo();
		$list->add("<b>".$pseudo."</b>");
		
		$role = $member->getRole();
		if ($role !== null) {
			$list->add("<b>R&ocirc;le</b> ".$role);
		}
		
		$firstName = $member->getFirstName();
		if ($firstName !== null) {
			$list->add("<b>Pr&eacute;nom</b> ".$firstName);
		}
		
		$age = $member->getAge();
		if ($age !== null) {
			$list->add("<b>&Acirc;ge</b> ".$age);
		}
		
		$location = $member->getLocation();
		if ($location !== null) {
			$list->add("<b>Lieu</b> ".$location);
		}
		
		$mail = $member->getMail();
		if ($mail !== null) {
			$wrap = new SimpleTextComponent("<b>Contact</b> ");
			$wrap->addComponent(new MailLink($mail));
			$list->add($wrap);
		}
		
		$website = $member->getWebsite();
		if ($website !== null) {
			$wrap = new SimpleTextComponent("<b>Site Web</b> ");
			$wrap->addComponent($website);
			$list->add($wrap);
		}
	}
}
?>