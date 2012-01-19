<h3>Denpa Onna To Seishun Otoko</h3>


<div style="float : right; display:block; margin-right: 20px;">
        <img src="images/series/denpa.jpg" border="0">
</div>
<h2>Informations g&eacute;n&eacute;rales</h2>
<h4>Source : <a href="http://animeka.com/fansub/teams/zero.html" target="_blank">Animeka</a></h4>

<p>
<b>Titre Original</b> Denpa Onna To Seishun Otoko<br />
<b>Site officiel</b> <a href="http://www.tbs.co.jp/anime/denpa/" target="_blank">Denpa Onna To Seishun Otoko</a><br />
<b>Ann&eacute;e de production</b> 2011<br />
<b>Studio</b> Shaft<br />
<b>Genre</b> Fantastique<br />
<b>Synopsis</b> Niwa Makoto est un lyc&eacute;en parti vivre chez sa tante car ses parents sont en voyage d&rsquo;affaires. Il y rencontre une cousine du m&ecirc;me &acirc;ge, inconnue du reste de sa famille, Towa Erio. Cette cousine &eacute;trange porte constamment un futon autour du corps, ne s\
e nourrit pratiquement que de pizzas et pense &ecirc;tre un extraterrestre.
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>&Eacute;pisodes</h2>


<?php
	function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}

	$releases = Release::getAllReleasesForProject('denpa');
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
