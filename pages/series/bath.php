<h3>Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko</h3>

<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/series/bath.jpg" border="0">
</div>
<h2>Informations générales</h2>
<h4>Source : <a href="http://animeka.com/fansub/teams/zero.html" target="_blank">Animeka</a></h4>
<p><b>Titre Original</b> Isshoni Training Ofuro - Bathtime with Hinako & Hiyoko<br />
<b>Année de production</b> 2011<br />
<b>Studio</b> Primaesta<br />
<b>Genre</b> Ecchi<br />
<b>Synopsis</b> Prendre un bain avec Hinako, &ccedil;a vous dit ? En plus, elle n'est pas seule : Hiyoko, sa copine loli, vient vous rejoindre.<br />
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>Épisodes</h2>

<?php
	function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}

	$releases = Release::getAllReleasesForProject('bath');
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
<a href="index.php?page=series/sleeping"><img src="images/series/sleeping.png" border="0" alt="S'endormir avec Hinako (Isshoni Sleeping)"></a><br /><br /> 
<a href="?page=havert"><img src="images/series/hshiyo.png" border="0"  alt="Faisons l'amour ensemble, Issho ni H shiyo"></a><br /><br /> 
<a href="?page=havert"><img src="images/series/akinahshiyo.png" border="0"  alt="Akina To Onsen De H shiyo"></a><br /><br /> 
</p>
