<?php
/*
	A project group is a group of projects. One project can be in several groups.
*/

class ProjectGroup {
	private $id = null;
	private $name = null;
	private $projects = array();
	private $bonuses = array();
	
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
	
	public function addProject($project) {
		if (is_string($project)) {
			$project = Project::getProject($project);
		}
		
		if ($project instanceof Project) {
			$this->projects[] = $project;
		}else {
			throw new Exception($project." is not a project");
		}
	}
	
	public function getProjects() {
		return $this->projects;
	}
	
	public function contains($project) {
		if (is_string($project)) {
			$project = Project::getProject($project);
		}
		
		foreach($this->projects as $p) {
			if ($p == $project) {
				return true;
			}
		}
		return false;
	}
	
	public function addBonus(ProjectBonus $bonus) {
		$this->bonuses[] = $bonus;
	}
	
	public function getBonuses() {
		return $this->bonuses;
	}
	
	private static $allGroups = null;
	public static function getAllGroups() {
		if (ProjectGroup::$allGroups === null) {
			
			$group = new ProjectGroup("kodomo", "Kodomo no Jikan");
			$group->addProject('kodomo');
			$group->addProject('kodomooav');
			$group->addProject('kodomo2');
			$group->addProject('kodomonatsu');
			$group->addProject('kodomofilm');
			$group->addBonus(new ProjectBonus("OST", '<div style="float : left; display:block; margin-left: 20px;">
	<img src="ost/[Zero] Kodomo no Jikan TV & OVA OP Single - Rettsu! Ohime-sama Dakko.jpg" border="0"/>
</div>
<p><b>Nom</b> [Zero] Kodomo no Jikan TV & OVA OP Single - Rettsu! Ohime-sama Dakko<br />
<b>Pistes audio</b><br />
01 - Rettsu! Ohime-sama Dakko<br />
02 - Otome Chikku Shoshinsha desu<br />
03 - Rettsu! Ohime-sama Dakko (off vocal)<br />
04 - Otome Chukku Shoshinsha desu (off vocal)<br />
<b>+ 4 images</b><br />
<b>Taille totale</b> 41 Mo.<br />
<br />
<b>Téléchargements</b><br />
<img src="images/icones/ddl.png"/>		[ <a href="ost/[Zero] Kodomo no Jikan TV & OVA OP Single - Rettsu! Ohime-sama Dakko.zip">Télécharger l\'archive .ZIP</a> ]<br />

<img src="images/icones/torrent.png"/> 		[ <a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%20TV%20%26%20OVA%20OP%20Single%20-%20Rettsu!%20Ohime-sama%20Dakko%20%5BVarious%5D.zip.torrent">Torrent (Nipponsei)</a> ]<br /></p>

<div style="float : right; display:block; margin-right: 20px;">
	<img src="ost/[Zero] Kodomo no Jikan TV & OVA ED Single - Hana Maru Sensation - Little Non.jpg" border="0"/>
</div>
<p><b>Nom</b> [Zero] Kodomo no Jikan TV & OVA ED Single - Hana Maru Sensation - Little Non<br />
<b>Pistes audio</b><br />
01 - Hana Maru Sensation<br />
02 - Aijou Education<br />
03 - Hana Maru Sensation (instrumental)<br />
04 - Aijou Education (instrumental)<br />
<b>+ 6 images</b><br />
<b>Taille totale</b> 38 Mo.<br />
<br />
<b>Téléchargements</b><br />
<img src="images/icones/ddl.png"/>		[ <a href="ost/[Zero] Kodomo no Jikan TV & OVA ED Single - Hana Maru Sensation - Little Non.zip">Télécharger l\'archive .ZIP</a> ]<br />

<img src="images/icones/torrent.png"/> 		[ <a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%20TV%20%26%20OVA%20ED%20Single%20-%20Hana%20Maru%20Sensation%20%5BLittle%20Non%5D.zip.torrent">Torrent (Nipponsei)</a> ]<br /></p>'));
			$group->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Phantom%20-Requiem%20for%20the%20Phantom-%20OP2%20Single%20-%20Senritsu%20no%20Kodomo%20Tachi%20%5BALI%20PROJECT%5D.zip.torrent">[Nipponsei] Phantom -Requiem for the Phantom- OP2 Single - Senritsu no Kodomo Tachi [ALI PROJECT].zip</a><br /> 
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%202%20Gakki%20ED%20Single%20-%201%2C%202%2C%203%20Day%20%5BLittle%20Non%5D.zip.torrent">[Nipponsei] Kodomo no Jikan 2 Gakki ED Single - 1, 2, 3 Day [Little Non].zip</a><br /> 
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%202%20Gakki%20OP%20Single%20-%20Guilty%20Future%20%5BKitamura%20Eri%5D.zip.torrent">[Nipponsei] Kodomo no Jikan 2 Gakki OP Single - Guilty Future [Kitamura Eri].zip</a><br /> 
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%20Original%20Soundtrack.zip.torrent">[Nipponsei] Kodomo no Jikan Original Soundtrack.zip</a><br /> 
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%20Drama%20CD%20-%20Drama%20no%20Jikan.zip.torrent">[Nipponsei] Kodomo no Jikan Drama CD - Drama no Jikan.zip</a><br /> 
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%20Character%20Song%20CD3%20-%20Usa%20Mimi%20%5BKadowaki%20Mai%5D.zip.torrent">[Nipponsei] Kodomo no Jikan Character Song CD3 - Usa Mimi [Kadowaki Mai].zip</a><br /> 
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%20Character%20Song%20CD2%20-%20Kuro%20Kagami%20%5BShindou%20Kei%5D.zip.torrent">[Nipponsei] Kodomo no Jikan Character Song CD2 - Kuro Kagami [Shindou Kei].zip</a><br /> 
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%20Character%20Song%20CD1%20-%20Kokonoe%20Rin%20%5BKitamura%20Eri%5D.zip.torrent">[Nipponsei] Kodomo no Jikan Character Song CD1 - Kokonoe Rin [Kitamura Eri].zip</a><br /> 
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%20TV%20%26%20OVA%20OP%20Single%20-%20Rettsu%21%20Ohime-sama%20Dakko%20%5BVarious%5D.zip.torrent">[Nipponsei] Kodomo no Jikan TV &amp; OVA OP Single - Rettsu! Ohime-sama Dakko [Various].zip</a><br /> 
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kodomo%20no%20Jikan%20TV%20%26%20OVA%20ED%20Single%20-%20Hana%20Maru%20Sensation%20%5BLittle%20Non%5D.zip.torrent">[Nipponsei] Kodomo no Jikan TV &amp; OVA ED Single - Hana Maru Sensation [Little Non].zip</a><br />'));
			$group->addBonus(new ProjectBonus("Jaquette(s) DVD", '<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
<a href="images/cover/[Zero]Kodomo_no_Jikan_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]Kodomo_no_Jikan_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>'));
			$group->addBonus(new FirefoxPersonaBonus(array(210669, 211529, 215378, 215385, 215383, 215388, 233572), "Kodomo no Jikan theme firefox"));
			$group->addBonus(new ProjectBonus("Images & Wallpaper", '<a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=0#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image01.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image01.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=1#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image02.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image02.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=2#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image03.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image03.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=3#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image04.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image04.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=4#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image05.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image05.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=5#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image06.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image06.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=6#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image07.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image07.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=7#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image08.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image08.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=8#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image09.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image09.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=9#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image10.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image10.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=10#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image11.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image11.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=11#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image12.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image12.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=12#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image13.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image13.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=13#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image14.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image14.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=14#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image15.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image15.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=15#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image16.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image16.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=16#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image17.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image17.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=17#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image18.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image18.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=18#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image19.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image19.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=19#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image20.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image20.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=20#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image21.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image21.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=21#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image22.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image22.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=22#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image23.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image23.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=23#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image24.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image24.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=24#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image25.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image25.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=25#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image26.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image26.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=26#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image27.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image27.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=27#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image28.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image28.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=28#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image29.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image29.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=29#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image30.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image30.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=30#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image31.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image31.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=31#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image32.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image32.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=32#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image33.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image33.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=33#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image34.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image34.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=34#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image35.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image35.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=35#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image36.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image36.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=36#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image37.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image37.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=37#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image38.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image38.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=38#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image39.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image39.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=39#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image40.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image40.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=40#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image41.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image41.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=41#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image42.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image42.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=42#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image43.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image43.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=43#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image44.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image44.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=44#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image45.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image45.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=45#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image46.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image46.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=46#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image47.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image47.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=47#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image48.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image48.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=48#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image49.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image49.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=49#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image50.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image50.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=50#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image51.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image51.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=51#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image52.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image52.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=52#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image53.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image53.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=53#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image54.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image54.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=54#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image55.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image55.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=55#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image56.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image56.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kodomo%20no%20Jikan&amp;spgmPic=56#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kodomo%20no%20Jikan/_thb_[Zero]Kodomo_no_Jikan_Image57.jpg" alt="gal/Zero_fansub/Images/Kodomo no Jikan/_thb_[Zero]Kodomo_no_Jikan_Image57.jpg" class="img-thumbnail" width="150" height="150"/></a>'));
			ProjectGroup::$allGroups[] = $group;
			
			$group = new ProjectGroup('toradora', "Toradora");
			$group->addProject('toradora');
			$group->addProject('toradorasos');
			$group->addProject('toradorabento');
			$group->addBonus(new ProjectBonus("OST", '<div style="float : right; display:block; margin-right: 20px;">
	<img src="ost/[Zero] Toradora! OP Single - Pre-Parade.jpg" border="0"/>
</div>
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<b>Nom</b> [Zero] Toradora! OP Single - Pre-Parade<br />
<b>Pistes audio</b><br />
01 - Pre-Parade<br />
02 - Ka Ra Ku Ri<br />
03 - Pre-Parade (off vocal ver.)<br />
04 - Ka Ra Ku Ri (off vocal ver.)<br />
<b>+ 4 images</b><br />
<b>Taille totale</b> 35 Mo.<br />
<br />
<b>Téléchargements</b><br />
<img src="images/icones/ddl.png"/>		[ <a href="ost/[Zero] Toradora! OP Single - Pre-Parade.zip">Télécharger l\'archive .ZIP</a> ]<br />

<img src="images/icones/torrent.png"/> 		[ <a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Toradora!%20OP%20Single%20-%20Pre-Parade%20%5BVarious%5D.zip.torrent">Torrent (Nipponsei)</a> ]<br />
	<img src="ost/[Zero] Toradora! ED Single - Vanilla Salt - Horie Yui.jpg" border="0"  style="float : left; display:block; margin-left: 20px;"/>
<b>Nom</b> [Zero] Toradora! ED Single - Vanilla Salt - Horie Yui<br />
<b>Pistes audio</b><br />
01 - Vanilla Salt<br />
02 - I my me<br />
03 - Vanilla Salt (off vocal ver.)<br />
04 - I my me (off vocal ver.)<br />
<b>+ 4 images</b><br />
<b>Taille totale</b> 42 Mo.<br />
<br />
<b>Téléchargements</b><br />
<img src="images/icones/ddl.png"/>		[ <a href="ost/[Zero] Toradora! ED Single - Vanilla Salt - Horie Yui.zip">Télécharger l\'archive .ZIP</a> ]<br />

<img src="images/icones/torrent.png"/> 		[ <a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Toradora!%20ED%20Single%20-%20Vanilla%20Salt%20%5BHorie%20Yui%5D.zip.torrent">Torrent (Nipponsei)</a> ]'));
			$group->addBonus(new ProjectBonus("Jaquette(s) DVD", '<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
	<a href="images/cover/[Zero]Toradora_Cover01.jpg" target="_blank">
	<img src="images/cover/[Zero]Toradora_Cover01.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Toradora_Cover02.jpg" target="_blank">
	<img src="images/cover/[Zero]Toradora_Cover02.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Toradora_Cover03.jpg" target="_blank">
	<img src="images/cover/[Zero]Toradora_Cover03.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Toradora_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]Toradora_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Toradora_Label.jpg" target="_blank">
	<img src="images/cover/[Zero]Toradora_Label.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>'));
			$group->addBonus(new FirefoxPersonaBonus(array(75812, 92100, 97183, 107104, 111779, 123049, 137800, 129800, 145485, 161326, 169796, 190100, 205389, 204714, 221228, 220075, 223130, 223131, 229455, 223134, 246423, 247218), "Toradora theme firefox"));
			ProjectGroup::$allGroups[] = $group;
			
			$group = new ProjectGroup('potemayo', "Potemayo");
			$group->addProject('potemayo');
			$group->addProject('potemayooav');
			$group->addBonus(new FirefoxPersonaBonus(array(208619), "Potemayo theme firefox"));
			ProjectGroup::$allGroups[] = $group;
			
			$group = new ProjectGroup('kannagi', "Kannagi");
			$group->addProject('kannagi');
			$group->addProject('kannagioad');
			$group->addBonus(new ProjectBonus("Jaquette(s) DVD", '<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
<a href="images/cover/[Zero]Kannagi_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]Kannagi_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>'));
			$group->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Sora%20wo%20Kakeru%20Shoujo%20Character%20Song%202%20-%20Kannagi%20Itsuki%20%5BEndou%20Aya%5D.zip.torrent">[Nipponsei] Sora wo Kakeru Shoujo Character Song 2 - Kannagi Itsuki [Endou Aya].zip</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kannagi%20ED%20Single%20-%20Musuhi%20no%20Toki%20%5BTomatsu%20Haruka%5D.zip.torrent">[Nipponsei] Kannagi ED Single - Musuhi no Toki [Tomatsu Haruka].zip</a><br />
<a href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kannagi%20OP%20Single%20-%20moto%20hade%20ni%20ne%21%20%5BHaruka%20Tomatsu%5D.zip.torrent">[Nipponsei] Kannagi OP Single - moto hade ni ne! [Haruka Tomatsu].zip</a>'));
			$group->addBonus(new ProjectBonus("Scantrad (Manga)", 'Ces mangas sont traduits par l\'équipe de Scantrad Française J-Garden. <a href="http://j-garden.kif.fr/hitohira-p20268" target="_blank"><img style="border: none;" src="http://idata.over-blog.com/0/59/73/61/Manga-zaki/Mz-V2/Menu/Partenaires/J-Garden.png" alt="J-Garden"/></a><br />
Si vous aimez leur travail, allez les remercier sur leur site !<br /><br />
<img src="http://img199.imageshack.us/img199/8337/kannagivolume1.png" alt="Kannagi tome1" style="float:right;"/>
 <a href="http://download391.mediafire.com/e4ba94j0c4gg/nznmzzitzej/Kannagi+ch1+VF.rar">Chapitre 01</a><br />
 <a href="http://download856.mediafire.com/cchy3lyobgag/zmz4jyzbmim/Kannagi+ch2+VF.rar">Chapitre 02</a><br />
 <a href="http://www.mediafire.com/?ndy1jr2qimi">Chapitre 03</a><br />
 <a href="http://www.mediafire.com/?zmyurdltfky">Chapitre 04</a><br />'));
			$group->addBonus(new ProjectBonus("Images & Wallpaper", '<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=0#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image01.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image01.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=1#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image02.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image02.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=2#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image03.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image03.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=3#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image04.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image04.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=4#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image05.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image05.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=5#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image06.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image06.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=6#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image07.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image07.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=7#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image08.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image08.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=8#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image09.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image09.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=9#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image10.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image10.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=10#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image11.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image11.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=11#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image12.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image12.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=12#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image13.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image13.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=13#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image14.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image14.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=14#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image15.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image15.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=15#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image16.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image16.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=16#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image17.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image17.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=17#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image18.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image18.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=18#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image19.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image19.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=19#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image20.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image20.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=20#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image21.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image21.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=21#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image22.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image22.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=22#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image23.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image23.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=23#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image24.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image24.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=24#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image25.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image25.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=25#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image26.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image26.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=26#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image27.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image27.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=27#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image28.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image28.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=28#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image29.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image29.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=29#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image30.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image30.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=30#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image31.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image31.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=31#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image32.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image32.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=32#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image33.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image33.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=33#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image34.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image34.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=34#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image35.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image35.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=35#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image36.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image36.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=36#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image37.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image37.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=37#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image38.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image38.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=38#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image39.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image39.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=39#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image40.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image40.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=40#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image41.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image41.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=41#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image42.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image42.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=42#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image43.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image43.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=43#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image44.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image44.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=44#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image45.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image45.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=45#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image46.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image46.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=46#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image47.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image47.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=47#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image48.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image48.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=48#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image49.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image49.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=49#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image50.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image50.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=50#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image51.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image51.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=51#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image52.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image52.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=52#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image53.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image53.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=53#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image54.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image54.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=54#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image55.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image55.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=55#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image56.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image56.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=56#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image57.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image57.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=57#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image58.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image58.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=58#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image59.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image59.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=59#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image60.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image60.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=60#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image61.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image61.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=61#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image62.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image62.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=62#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image63.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image63.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=63#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image64.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image64.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=64#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image65.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image65.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=65#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image66.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image66.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=66#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image67.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image67.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=67#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image68.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image68.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=68#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image69.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image69.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=69#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image70.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image70.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=70#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image71.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image71.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=71#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image72.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image72.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=72#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image73.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image73.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=73#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image74.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image74.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=74#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image75.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image75.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=75#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image76.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image76.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=76#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image77.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image77.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=77#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image78.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image78.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=78#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image79.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image79.jpg" class="img-thumbnail" width="150" height="150"/></a>
<a href="galerie/index.php?spgmGal=Zero_fansub/Images/Kannagi&amp;spgmPic=79#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image80.jpg" alt="galerie/gal/Zero_fansub/Images/Kannagi/_thb_[Zero]Kannagi_Image80.jpg" class="img-thumbnail" width="150" height="150"/></a>'));
			ProjectGroup::$allGroups[] = $group;
			
			$name = Project::getProject('mayoi')->getName();
			$group = new ProjectGroup('mayoi', $name);
			$group->addProject('mayoi');
			$group->addProject('mayoisp');
			$group->addBonus(new FirefoxPersonaBonus(array(209338, 210030, 233236), $name." theme firefox"));
			ProjectGroup::$allGroups[] = $group;
			
			$name = Project::getProject('tayutama')->getName();
			$group = new ProjectGroup('tayutama', $name);
			$group->addProject('tayutama');
			$group->addProject('tayutamapure');
			$group->addBonus(new ProjectBonus("Jaquette(s) DVD", '<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
	<a href="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Label.jpg" target="_blank">
	<img src="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Label.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>'));
			$group->addBonus(new FirefoxPersonaBonus(array(236444, 260878), $name." theme firefox"));
			ProjectGroup::$allGroups[] = $group;
			
			$name = Project::getProject('kissxsis')->getName();
			$group = new ProjectGroup('kissxsis', $name);
			$group->addProject('kissxsis');
			$group->addProject('kissxsisoav');
			$group->addBonus(new ProjectBonus("Scantrad (Manga)", 'Ces mangas ont d\'abord été traduits par l\'équipe de Scantrad Française <a href="http://www.ecchi-scan.com/" target="_blank">Ecchi-no-chikara <img src="images/partenaires/ecchi.png" /></a> et <a href="http://kouhaiscantrad.wordpress.com" target="_blank">Kouhai Scantrad <img src="images/partenaires/kouhai.jpg" target="_blank" /></a>. La traduction a ensuite été reprise par la <a href="http://hime-team.over-blog.com/">Hime Team</a>.
Si vous aimez leur travail, allez les remercier sur leur site !<br /><br />
Vous trouverez tous les chapitres sur <a href="http://hime-team.over-blog.com/kissxsis" target="_blank">la page de la Hime Team</a>.'));
			$group->addBonus(new ProjectBonus("OST", 'Ces OST vous sont proposées par Nipponsei.<br />
Les principales chansons de cette série sont disponibles en DDL <a href="radio/mp3" target="_blank">Lien</a> ou directement écoutable sur <a href="radio" target="_blank">la radio</a>.<br />

<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kiss%20X%20Sis%20Character%20Song%20%26%20Soundtrack.zip.torrent">[Nipponsei] Kiss X Sis Character Song &amp; Soundtrack.zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kiss%20X%20Sis%20Character%20Song%20Mini%20Album%20-%20Anata%20ni%20kiss.zip.torrent">[Nipponsei] Kiss X Sis Character Song Mini Album - Anata ni kiss.zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kiss%20X%20Sis%20ED%20Single%20-%20Our%20Steady%20Boy%20%5BOgura%20Yui%20%26%20Ishihara%20Kaori%5D.zip.torrent">[Nipponsei] Kiss X Sis ED Single - Our Steady Boy [Ogura Yui &amp; Ishihara Kaori].zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kiss%20X%20Sis%20OP%20Single%20-%20Balance%20KISS%20%5BTaketatsu%20Ayana%20%26%20Tatsumi%20Yuiko%5D.zip.torrent">[Nipponsei] Kiss X Sis OP Single - Balance KISS [Taketatsu Ayana &amp; Tatsumi Yuiko].zip</a><br />
<a class="download" href="http://tracker.minglong.org/torrents/%5BNipponsei%5D%20Kiss%20X%20Sis%20OAD%20OP%20Single%20-%20Futari%20no%20Honey%20Boy%20%5BTaketatsu%20Ayana%20%26%20Tatsumi%20Yuiko%5D.zip.torrent">[Nipponsei] Kiss X Sis OAD OP Single - Futari no Honey Boy [Taketatsu Ayana &amp; Tatsumi Yuiko].zip</a>'));
			$group->addBonus(new ProjectBonus("Jaquette(s) DVD", '<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
<a href="images/cover/[Zero]KissXsis_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]KissXsis_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>'));
			$group->addBonus(new FirefoxPersonaBonus(array(206137, 183962, 237172), $name." theme firefox"));
			$group->addBonus(new ProjectBonus("Images & Wallpaper", '    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=0#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image01.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image01.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=1#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image02.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image02.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=2#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image03.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image03.jpg" class="img-thumbnail" width="150" height="150"/></a> 
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=3#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image04.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image04.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=4#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image05.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image05.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=5#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image06.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image06.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=6#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image07.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image07.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=7#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image08.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image08.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=8#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image09.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image09.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=9#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image10.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image10.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=10#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image11.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image11.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=11#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image12.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image12.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=12#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image13.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image13.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=13#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image14.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image14.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=14#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image15.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image15.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=15#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image16.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image16.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=16#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image17.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image17.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=17#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image18.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image18.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=18#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image19.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image19.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=19#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image20.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image20.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=20#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image21.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image21.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=21#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image22.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image22.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=22#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image23.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image23.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=23#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image24.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image24.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=24#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image25.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image25.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=25#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image26.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image26.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=26#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image27.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image27.jpg" class="img-thumbnail" width="150" height="150"/></a>
    <a target="_blank" href="galerie/index.php?spgmGal=Zero_fansub/Images/Kiss%20X%20Sis&amp;spgmPic=27#spgmPicture" class=""><img src="galerie/gal/Zero_fansub/Images/Kiss%20X%20Sis/_thb_[Zero]Kiss_x_Sis_Image28.jpg" alt="galerie/gal/Zero_fansub/Images/Kiss X Sis/_thb_[Zero]Kiss_x_Sis_Image28.jpg" class="img-thumbnail" width="150" height="150"/></a>'));
			ProjectGroup::$allGroups[] = $group;
		}
		
		return ProjectGroup::$allGroups;
	}
	
	public static function getGroupsForProject($project) {
		$groups = array();
		foreach(ProjectGroup::getAllGroups() as $group) {
			if ($group->contains($project)) {
				$groups[] = $group;
			}
		}
		return $groups;
	}
}
?>