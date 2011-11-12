<h3>Alignment You ! You ! The Animation</h3>


<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/series/alignment.jpg" border="0">
</div>
<h2>Informations générales</h2>
<h4>Source : <a href="http://animeka.com/fansub/teams/zero.html" target="_blank">Animeka</a></h4>

<p>
<b>Titre Original</b> Alignment You ! You ! The Animation<br />
<b>Site officiel</b> <a href="http://www.pinkpineapple.co.jp/web/alignment/" target="_blank">Pinkpineapple.co.jp</a><br />
<b>Année de production</b> 2008<br />
<b>Studio</b> <a href="http://www.pinkpineapple.co.jp/" target="_blank">Pinkpineapple</a><br />
<b>Genre</b> Hentaï<br />
<b>Synopsis</b> Takahashi, jeune lycéenne, se masturbe furieusement dans la salle de cours devant l'homme qu'elle aime, Oohara. Mais personne ne remarque la lubrique jeune femme ! Et pour cause : elle est déjà morte... <br />
<b>Vosta</b> <a href="http://www.killer-maid.net" target="_blank">Killer maid</a>
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>Épisodes</h2>

<?php
	function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}

	$releases = Release::getAllReleasesForProject('alignment');
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










<div class="p"><a href="http://zero.xooit.fr/posting.php?mode=reply&t=120" target="_blank"><img src="images/interface/avis.png" border="0"></a></div><br /><br/>







