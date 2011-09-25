<?php
	$page = PageContent::getInstance();
	$page->setTitle("La Team de fansub");
?>
<?php
	$page->addComponent(new Title("Administrateurs", 2));

	$list = new TeamMemberList();
	$page->addComponent($list);
	foreach(TeamMember::getAllMembers() as $member) {
		if ($member->isAdmin()) {
			$list->addComponent($member);
		}
	}
?>
<?php
	$page->addComponent(new Title("Membres", 2));

	$list = new TeamMemberList();
	$page->addComponent($list);
	foreach(TeamMember::getAllMembers() as $member) {
		if (!$member->isAdmin()) {
			$list->addComponent($member);
		}
	}
?>
<?php
	$page->addComponent(new Title("Seeders, Uploaders", 2));

	$list = new SimpleListComponent();
	$page->addComponent($list);
	$list->addComponent("Sazaju HITOKAGE");
	$list->addComponent("etienne2000");
	$list->addComponent("lwienlin");
	$list->addComponent("lepims");
	$list->addComponent("secouss");
	$list->addComponent("manu");
?>
