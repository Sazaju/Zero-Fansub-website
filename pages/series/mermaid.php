<h3>Mermaid Melody Pichi Pichi Pitch</h3>


<div style="float : right; display:block; margin-right: 20px;">
	<img src="images/series/mermaid.jpg" border="0">
</div>
<h2>Informations générales</h2>
<h4>Source : <a href="http://animeka.com/fansub/teams/zero.html" target="_blank">Animeka</a></h4>

<p>
<b>Titre Original</b> Mermaid Melody Pichi Pichi Pitch<br />
<b>Site officiel</b> <a href="http://p-hanamori.cool.ne.jp/" target="_blank">Lips</a><br />
<b>Année de production</b> 2003<br />
<b>Studio</b> <a href="http://www.tokyu-agc.co.jp/" target="_blank">Tokyo Agency</a><br />
<b>Genre</b> Comédie - Magical Girl - Ecchi<br />
<b>Auteur</b> Pink Hanamori<br />
<b>Synopsis</b> Luchia, une jeune sirène, a sauvé dans son enfance un garçon du même âge qu'elle qui était en train de se noyer et lui a mis au cou un médaillon. Quelques années plus tard, elle gagne la terre ferme dans l'espoir de retrouver celui qu'elle a toujours aimé. Le jeune collégien en question qui est devenu un surfer participant à des concours invite Luchia et sa copine Hanon pour la revoir lors de sa prochaine compétition, mais les Forces du Mal aquatiques vont venir semer le trouble... <br />
<b>Vosta</b> Lunar anime
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>Épisodes</h2>

<?php
	function sortReleases(Release $a, Release $b) {
		return strnatcmp($a->getID(), $b->getID());
	}

	$releases = Release::getAllReleasesForProject('mermaid');
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








<div class="p"><a href="http://zero.xooit.fr/t148-Ton-avis-sur-Mermaid-Melody-Pichi-Pichi-Pich-la-serie-en-general.htm" target="_blank"><img src="images/interface/avis.png" border="0"></a></div><br /><br/>


