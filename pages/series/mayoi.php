<h3>Mayoi Neko Overrun!</h3>


<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/series/mayoi.jpg" border="0">
</div>
<h2>Informations générales</h2>
<h4>Source : <a href="http://animeka.com/fansub/teams/zero.html" target="_blank">Animeka</a></h4>

<p>
<b>Titre Original</b> Mayoi Neko Overrun!<br />
<b>Site officiel</b> <a href="http://www.patisserie-straycats.com/" target="_blank">Patisserie Stray Cats</a><br />
<b>Année de production</b> 2010<br />
<b>Studio</b>   <a href="http://www.anime-int.com/" target="_blank">Studio AIC</a><br />
<b>Auteur</b> Matsu Tomohiro<br />
<b>Genre</b> Comédie Ecchi<br />
<b>Synopsis</b> Takumi Tsuzuki vit avec sa grande “soeur” Otome bien qu’ils ne soient pas liés par le sang. Otome gère une vieille pâtisserie appelée Stray Cats où y travaille également une amie d’enfance de Takumi, Fumino Serisawa. C’est alors qu’un jour, Nozomi Kiriya, une jeune fille mystérieuse imitant un chat, apparaît…<br />
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>Épisodes</h2>

<?php
	function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}

	$releases = Release::getAllReleasesForProject('mayoi');
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

<h2>Bonus : Thèmes pour Firefox (Skin)</h2>
<p>
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/209338"><img src="http://getpersonas-cdn.mozilla.net/static/3/8/209338/preview.jpg?1273561667" border="0" alt="Mayoi Neko Overrun! theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/210030"><img src="http://getpersonas-cdn.mozilla.net/static/3/0/210030/preview.jpg?1273648101" border="0" alt="Mayoi Neko Overrun! theme skin persona mozilla firefox" /></a> 
<a target="_blank" href="http://www.getpersonas.com/en-US/persona/233236"><img src="http://getpersonas-cdn.mozilla.net/static/3/6/233236/preview.jpg?1277047781" border="0" alt="Mayoi Neko Overrun! theme skin persona mozilla firefox" /></a> 
</p>




