<h3>Akina To Onsen De H Shiyo !</h3>


<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/series/akinahshiyo.jpg" border="0">
</div>
<h2>Informations générales</h2>
<h4>Source : <a href="http://animeka.com/fansub/teams/zero.html" target="_blank">Animeka</a></h4>

<p>
<b>Titre Original</b> Akina To Onsen De H Shiyo<br />
<b>Année de production</b> 2011<br />
<b>Genre</b> Hentaï<br />
<b>Synopsis</b> <br />
<b>Traduit du japonais par Sazaju</b>
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>Épisodes</h2>

<?php
	function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}

	$releases = Release::getAllReleasesForProject('akinahshiyo');
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
<a href="index.php?page=series/training"><img src="images/series/training.png" border="0" alt="L'entraînement avec Hinako"></a><br /><br /> 
<a href="index.php?page=series/sleeping"><img src="images/series/sleeping.png" border="0" alt="S'endormir avec Hinako (Isshoni Sleeping)"></a><br /><br /> 
<a href="index.php?page=series/hshiyo"><img src="images/series/hshiyo.png" border="0" alt="Isshoni H Shiyo"></a><br /><br /> 
</p>








<div class="p"><a href="http://zero.xooit.fr/posting.php?mode=reply&t=120" target="_blank"><img src="images/interface/avis.png" border="0"></a></div><br /><br/>







