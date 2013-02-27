<?php
	$members = TeamMember::getAllCurrentMembers();
	usort($members, array('TeamMember', 'nameSorter'));
	
	$admins = array();
	$confirmed = array();
	$vacant = array();
	foreach($members as $member) {
		if ($member->isAdmin()) {
			$admins[] = $member;
		} else if($member->getAvailability() == TeamMember::AVAILABLE) {
			$confirmed[] = $member;
		} else {
			$vacant[] = $member;
		}
	}
	
	$uploaders = array();
	$uploaders[] = "Sazaju HITOKAGE";
	$uploaders[] = "etienne2000";
	$uploaders[] = "lwienlin";
	$uploaders[] = "lepims";
	natcasesort($uploaders);
	
	/******************************\
	             DISPLAY
	\******************************/
	
	$page = PageContent::getInstance();
	$page->addComponent(new Title("La Team de fansub", 1));
	
	$displayer = function($title, $members, $list) use ($page) {
		if (empty($members)) {
			// do not display the list
		} else {
			$page->addComponent(new Title($title, 2));
			$page->addComponent($list);
			foreach($members as $member) {
				$list->addComponent($member);
			}
		}
	};
	
	$displayer("Administrateurs", $admins, new TeamMemberList());
	$displayer("Membres disponibles", $confirmed, new TeamMemberList());
	$displayer("Membres indisponibles", $vacant, new TeamMemberList());
	$displayer("Seeders, Uploaders", $uploaders, new SimpleListComponent());
?>