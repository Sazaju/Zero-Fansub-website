<?php
	$page = PageContent::getInstance();
	$page->setTitle("La Team de fansub");
	$page->addComponent(new Title("Administrateur(s)", 2));
?>
<?php
	$list = new MemberList();
	$page->addComponent($list);
	
	$member = new TeamMember();
	$member->setPseudo("db0");
	$member->setRole("Verif finale, sorties.");
	$member->setImage("db0.png");
	$member->setAge("19 ans");
	$member->setLocation("Le Kremlin-Bicetre (94)");
	$member->setMail("db0company@gmail.com");
	$member->setWebsite("http://db0.fr/", "db0.fr");
	$list->add($member);
	
	$member = new TeamMember();
	$member->setPseudo("Ryocu");
	$member->setRole("Rien.");
	$member->setImage("ryocu.png");
	$member->setWebsite("http://anime-ultime.net/", "Anime-Ultime");
	$list->add($member);
?>
<?php
	$page->addComponent(new Title("Membres", 2));
?>
<?php
	$list = new MemberList();
	$page->addComponent($list);
	
	$member = new TeamMember();
	$member->setPseudo("Sazaju HITOKAGE");
	$member->setRole("Adapt Jap, Tracker BT, XDCC.");
	$member->setImage("sazaju.png");
	$member->setMail("sazaju@gmail.com");
	$list->add($member);

	$member = new TeamMember();
	$member->setPseudo("lepims");
	$member->setRole("Encodeur");
	$member->setFirstName("Lepims");
	$member->setAge("25 ans");
	$member->setImage("lepims.png");
	$member->setLocation("Clermont-Ferrand");
	$list->add($member);
	
	$member = new TeamMember();
	$member->setImage("");// TODO http://img8.xooimage.com/files/1/f/5/superman-micro--bfcab6.jpg
	$member->setPseudo("DC");
	$member->setRole("Encodeur");
	$member->setFirstName("Denis");
	$member->setAge("24 ans");
	$member->setLocation("Lyon");
	$list->add($member);
	
	$member = new TeamMember();
	$member->setImage("");// TODO http://img6.xooimage.com/files/a/1/a/komori-kiri-139d03f.jpg
	$member->setPseudo("praia");
	$member->setRole("QC.");
	$member->setFirstName("Piet");
	$member->setAge("30 ans");
	$member->setLocation("Belgique");
	$member->setMail("raiapietro_dam22@hotmail.com");
	$list->add($member);
	
	$member = new TeamMember();
	$member->setImage("personne.jpg");
	$member->setPseudo("Personne");
	$member->setRole("Edit Kara.");
	$member->setAge("23 ans");
	$list->add($member);
	
	$member = new TeamMember();
	$member->setImage(""); // TODO http://img7.xooimage.com/files/a/2/2/a22f797271adf8a2...a2577a9-24ccb16.jpeg
	$member->setPseudo("Nyaa-Gentle");
	$member->setRole("Time");
	$list->add($member);
?>
<?php
	$page->addComponent(new Title("Traducteurs", 2));
?>
<?php
	$list = new MemberList();
	$page->addComponent($list);
	
	$member = new TeamMember();
	$member->setImage("zack.jpg");
	$member->setPseudo("ZackDeMars");
	$member->setRole("Traducteur En>Fr");
	$member->setFirstName("Zack");
	$member->setAge("22 ans");
	$member->setLocation("Marseille");
	$member->setMail("Tsuki-Usagi@hotmail.fr");
	$list->add($member);
	
	$member = new TeamMember();
	$member->setImage("shana.png");
	$member->setPseudo("Shana-chan");
	$member->setRole("Traducteur En>Fr");
	$member->setFirstName("Guillaume");
	$list->add($member);

	$member = new TeamMember();
	$member->setImage("onee-chan.jpg");
	$member->setPseudo("Onee-chan");
	$member->setRole("Traducteur En>Fr");
	$list->add($member);

	$member = new TeamMember();
	$member->setImage("litinae.jpg");
	$member->setPseudo("Litinae");
	$member->setRole("Traducteur En>Fr");
	$list->add($member);
?>
<?php
	$page->addComponent(new Title("Seeders, Uploaders", 2));
?>
<?php
	$list = new SimpleListComponent();
	$page->addComponent($list);
	$list->add("sazaju");
	$list->add("etienne2000");
	$list->add("lwienlin");
	$list->add("lepims");
	$list->add("secouss");
	$list->add("manu");
?>
