<h3>Tayutama -Kiss on my Deity-</h3>


<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/series/tayutama.jpg" border="0">
</div>
<h2>Informations générales</h2>
<h4>Source : <a href="http://animeka.com/fansub/teams/zero.html" target="_blank">Animeka</a></h4>

<p>
<b>Titre Original</b> Tayutama -Kiss on my Deity-<br />
<b>Site officiel</b> <a href="http://www.tayutama.com/" target="_blank">Tayutama.com</a><br />
<b>Année de production</b> 2009<br />
<b>Studio</b> Silver Link<br />
<b>Genre</b> Amour et Amitié<br />
<b>Synopsis</b> L'histoire est centrée sur Yuuri Mito, un étudiant de l'Académie Sousei et le fils unique de l'homme qui dirige le temple Yachimata. À Yachimata, il y a une légende à propos d'une divinité appelée Tayutama-sama qui protégea la région, mais cette divinité et d'autres ainsi nommées "Tayutai" ont été oubliées avec le temps. Mito et ses amis découvrent une relique dans le sol de l'école, avec de mystérieux motifs. Dès lors, à la cérémonie d'ouverture de la nouvelle année scolaire, une tout aussi mystérieuse fille appelée Mashiro apparaît devant Mito. Mashiro est d'une certaine manière liée à la relique et à la légende de Tayutama-sama.<br />
<b>Vosta</b> <a href="http://fansubs.anime-share.net/" target="_blank">Anime-Share fansub</a> et Anoymous
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>Épisodes</h2>

<?php
	function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}

	$releases = Release::getAllReleasesForProject('tayutama');
	usort($releases, 'sortReleases');
	$list = new SimpleListComponent();
	$list->setClass("releaseList");
	foreach($releases as $release)
	{
		$list->addComponent(new ReleaseComponent($release));
	}
	$list->writeNow();
?>

<p></p>
<h2>Voir aussi</h2>
<p>
<a href="index.php?page=series/tayutamapure"><img src="images/series/tayutamapure.png" border="0" alt="Tayutama - Kiss on my Deity - Pure My Heart"></a><br /><br /> 
</p>

<h2>Bonus : Jaquette(s) DVD</h2>
<h4>Source : <a href="http://www.animecoversfan.com" target="_blank">AnimeCoversFan</a></h4>
<p>
	<a href="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Cover.jpg" target="_blank">
	<img src="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Cover.png" alt="Jaquette DVD" border="0" width="200" /></a> 
	<a href="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Label.jpg" target="_blank">
	<img src="images/cover/[Zero]Tayutama_Kiss_on_my_deity_Label.png" alt="Jaquette DVD" border="0" width="200" /></a> 
</p>

<h2>Bonus : Thèmes pour Firefox (Skin Persona)</h2>
<p>
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/236444"><img src="http://getpersonas-cdn.mozilla.net/static/4/4/236444/preview.jpg?1277397610" border="0" alt="Tayutama Kiss on my Deity theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/260878"><img src="http://getpersonas-cdn.mozilla.net/static/7/8/260878/preview.jpg?1279817830" border="0" alt="Tayutama Kiss on my Deity theme skin persona mozilla firefox" /></a> 
</p>

<p></p>








