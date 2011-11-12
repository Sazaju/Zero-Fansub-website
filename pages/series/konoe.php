<h3>Konoe no Jikan</h3>


<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/series/konoe.jpg" border="0">
</div>
<h2>Informations générales</h2>

<p>
<b>Titre Original</b> Konoe no Jikan<br />
<b>Année de production</b> 2008<br />
<b>Actrice</b> Seto Hinata<br />
<b>Genre</b> Film porno<br />
<b>Synopsis</b> Parodie pornographique de Kodomo no Jikan.<br />
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>Épisodes</h2>

<?php
	function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}

	$releases = Release::getAllReleasesForProject('konoe');
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
<a href ="index.php?page=series/kodomo"><img src="images/series/kodomo.png" border="0" alt="Kodomo no Jikan"></a><br /><br /> 
<a href="index.php?page=series/kodomooav"><img src="images/series/kodomooav.png" border="0" alt="Kodomo no Jikan OAV"></a><br /><br /> 
<a href ="index.php?page=series/kodomofilm"><img src="images/series/kodomofilm.png" border="0" alt="Kodomo no Jikan Le Film"></a><br /><br /> 
<a href="index.php?page=series/kodomonatsu"><img src="images/series/kodomonatsu.png" border="0" alt="Kodomo no Natsu Jikan"></a><br /><br /> 
<a href="index.php?page=series/kodomoo"><img src="images/series/kodomo2.png" border="0" alt="Kodomo no Jikan ~ Ni Gakki"></a><br /><br /> 
</p>







