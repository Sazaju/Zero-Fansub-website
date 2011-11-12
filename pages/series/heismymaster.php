<h3>Ce sont mes Maids</h3>


<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/series/heismymaster.jpg" border="0">
</div>
<h2>Informations générales</h2>

<p>
<b>Titre Original</b> Kore ga Oresama no Maidtachi<br />
<b>Année de production</b> 2007<br />
<b>Auteur</b> Yukimihonpo<br />
<b>Genre</b> Doujin<br />
<b>Synopsis</b> Parodie hentaï He is my master. Yoshitaka est malade et les médicaments qu'Izumi va lui donner vont le remettre d'aplomb, ainsi que son penis ! Il va tout faire pour avoir Izumi mais va finalement se rattraper sur les deux autres.<br />
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>Chapitres</h2>

<?php
	function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}

	$releases = Release::getAllReleasesForProject('heismymaster');
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








