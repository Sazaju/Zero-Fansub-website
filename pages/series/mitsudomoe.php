<h3>Mitsudomoe</h3>


<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/series/mitsudomoe.jpg" border="0">
</div>
<h2>Informations générales</h2>
<h4>Source : <a href="http://animeka.com/fansub/teams/zero.html" target="_blank">Animeka</a></h4>

<p>
<b>Titre Original</b> Mitsudomoe<br />
<b>Site officiel</b> <a href="http://www.mitsudomoe-anime.com/" target="_blank">Mitsudomoe Anime</a><br />
<b>Année de production</b> 2010<br />
<b>Studio</b> Bridge<br />
<b>Auteur</b> Sakurai Norio<br />
<b>Genre</b> Comédie Ecchi<br />
<b>Synopsis</b> Les triplés raconte l'histoire de 3 filles de primaire un peu perverses qui harcèlent leur prof pas doué.<br />
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>Épisodes</h2>

<?php
	function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}

	$releases = Release::getAllReleasesForProject("mitsudomoe");
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








