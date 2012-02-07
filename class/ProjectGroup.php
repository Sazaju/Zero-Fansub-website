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
			$group->addBonus(new ProjectBonus("Thèmes pour Firefox (Skin Persona)", '<a target="_blank" href="http://www.getpersonas.com/en-US/persona/210669"><img src="http://getpersonas-cdn.mozilla.net/static/6/9/210669/preview.jpg?1277535561" border="0" alt="Kodomo no Jikan theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/211529"><img src="http://getpersonas-cdn.mozilla.net/static/2/9/211529/preview.jpg?1277534969" border="0" alt="Kodomo no Jikan theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/215378"><img src="http://getpersonas-cdn.mozilla.net/static/7/8/215378/preview.jpg?1277535488" border="0" alt="Kodomo no Jikan theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/215385"><img src="http://getpersonas-cdn.mozilla.net/static/8/5/215385/preview.jpg?1277535394" border="0" alt="Kodomo no Jikan theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/215383"><img src="http://getpersonas-cdn.mozilla.net/static/8/3/215383/preview.jpg?1277535469" border="0" alt="Kodomo no Jikan theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/215388"><img src="http://getpersonas-cdn.mozilla.net/static/8/8/215388/preview.jpg?1277535551" border="0" alt="Kodomo no Jikan theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/233572"><img src="http://getpersonas-cdn.mozilla.net/static/7/2/233572/preview.jpg?1277535407" border="0" alt="Kodomo no Jikan theme skin persona mozilla firefox" /></a>'));
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
			$group->addBonus(new ProjectBonus("Thèmes pour Firefox (Skin)", '<a target="_blank" href="http://www.getpersonas.com/en-US/persona/75812"><img src="http://getpersonas-cdn.mozilla.net/static/1/2/75812/preview.jpg?1261355186" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/92100"><img src="http://getpersonas-cdn.mozilla.net/static/0/0/92100/preview.jpg?1264947658" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/97183"><img src="http://getpersonas-cdn.mozilla.net/static/8/3/97183/preview.jpg?1265514870" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/107104"><img src="http://getpersonas-cdn.mozilla.net/static/0/4/107104/preview.jpg?1266634442" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/111779"><img src="http://getpersonas-cdn.mozilla.net/static/7/9/111779/preview.jpg?1267020347" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/123049"><img src="http://getpersonas-cdn.mozilla.net/static/4/9/123049/preview.jpg?1268381765" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/137800"><img src="http://getpersonas-cdn.mozilla.net/static/0/0/137800/preview.jpg?1268916096" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/129800"><img src="http://getpersonas-cdn.mozilla.net/static/0/0/129800/preview.jpg?1268570882" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/145485"><img src="http://getpersonas-cdn.mozilla.net/static/8/5/145485/preview.jpg?1270054918" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/161326"><img src="http://getpersonas-cdn.mozilla.net/static/2/6/161326/preview.jpg?1270042852" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/169796"><img src="http://getpersonas-cdn.mozilla.net/static/9/6/169796/preview.jpg?1270408779" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/190100"><img src="http://getpersonas-cdn.mozilla.net/static/0/0/190100/preview.jpg?1271618180" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/205389"><img src="http://getpersonas-cdn.mozilla.net/static/8/9/205389/preview.jpg?1273098873" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/204714"><img src="http://getpersonas-cdn.mozilla.net/static/1/4/204714/preview.jpg?1273099951" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/221228"><img src="http://getpersonas-cdn.mozilla.net/static/2/8/221228/preview.jpg?1278446057" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/220075"><img src="http://getpersonas-cdn.mozilla.net/static/7/5/220075/preview.jpg?1278446084" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/223130"><img src="http://getpersonas-cdn.mozilla.net/static/3/0/223130/preview.jpg?1275476469" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/223131"><img src="http://getpersonas-cdn.mozilla.net/static/3/1/223131/preview.jpg?1275476559" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/229455"><img src="http://getpersonas-cdn.mozilla.net/static/5/5/229455/preview.jpg?1276434404" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/223134"><img src="http://getpersonas-cdn.mozilla.net/static/3/4/223134/preview.jpg?1275477090" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/246423"><img src="http://getpersonas-cdn.mozilla.net/static/2/3/246423/preview.jpg?1278221246" border="0" alt="Toradora theme firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/247218"><img src="http://getpersonas-cdn.mozilla.net/static/1/8/247218/preview.jpg?1278329550" border="0" alt="Toradora theme firefox" /></a>'));
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