<?php
	$page = PageContentComponent::getInstance();
	$page->addComponent(new TitleComponent("La Team de fansub", 1));

	$members = TeamMember::getAllCurrentMembers();
	usort($members, array('TeamMember', 'nameSorter'));
	
	$page->addComponent(new TitleComponent("Administrateurs", 2));

	$list = new TeamMemberListComponent();
	$page->addComponent($list);
	foreach($members as $member) {
		if ($member->isAdmin()) {
			$list->addComponent($member);
		}
	}

	$page->addComponent(new TitleComponent("Membres", 2));

	$list = new TeamMemberListComponent();
	$page->addComponent($list);
	foreach($members as $member) {
		if (!$member->isAdmin()) {
			$list->addComponent($member);
		}
	}

	$page->addComponent(new TitleComponent("Seeders, Uploaders", 2));

	$uploaders = array();
	$uploaders[] = "Sazaju HITOKAGE";
	$uploaders[] = "etienne2000";
	$uploaders[] = "lwienlin";
	$uploaders[] = "lepims";
	natcasesort($uploaders);
	
	$list = new SimpleListComponent();
	$page->addComponent($list);
	foreach($uploaders as $uploader) {
		$list->addComponent($uploader);
	}
?>