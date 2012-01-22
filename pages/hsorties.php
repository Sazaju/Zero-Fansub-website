<?php
	$page = PageContent::getInstance();
	$page->addComponent(new Title("Zéro fansub", 1));
	$page->addComponent(new Archives());

	$newsList = array();
	foreach(News::getAllReleasingNews() as $news) {
		// TODO remove the 'test' feature when the refinement will be completed
		if ($news->getTimestamp() !== null && $news->getTimestamp() <= time() || isset($_GET['test'])) {
			$hMode = $_SESSION[MODE_H];
			if (!$hMode && $news->displayInNormalMode() || $hMode && $news->displayInHentaiMode()) {
				$newsList[] = $news;
			}
		}
	}
	usort($newsList, array('News', 'timestampSorter'));
	foreach($newsList as $news) {
		$page->addComponent(new NewsComponent($news));
	}

	// rewrite the archive header as a footer
	$page->addComponent(new Archives());
	
	// TODO remove after all the news are integrated
	$page->setStyle("margin-left:0;");
	$page->writeNow();
	$page->clear();
?>
-------------------------
<h2>Fin de la série Sketchbook ~full color's~</h2>
<h4>30/06/09 par db0</h4>
<div class="p"><img src="images/news/sketchend.jpg"><br />
Nous avons temporairement repris de nos activités pour finir la série Sketchbook full color's. Sortie aujourd'hui de 5 épisodes d'un coup : 09, 10, 11, 12 et 13 :) Profitez bien de ctte magnifique série, et à dans deux jours à Japan Expo !
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t98.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=98" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Sketchbook ~ full color's ~ 08</h2>
<h4>15/05/09 par db0</h4>
<div class="p"><img src="images/news/sketch8.png" border="0"><br />V'là déjà la suite de Sketchbook full colors ! L'épisode 08 est disponible, et à peine 2 jours après l'épisode 07 ! Si c'est pas beau, ça ? Allez, détendez-vous un peu en regardant ce joli épisode. <a href="http://zerofansub.net/index.php?page=series/sketchbook" target="_blank">En téléchargement ici !</a><br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t72.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=72" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Sketchbook ~ full color's ~ 07</h2>
<h4>12/05/09 par db0</h4>
<img src="images/news/sketch7.jpg" style="float:right;" border="0">
<div class="p">On avance un peu dans Sketchbook aussi, épisode 07 aujourd'hui ! Apparition d'un nouveau personnage : une étudiante transferée. Cet épisode est plutôt drôle. <a href="http://zerofansub.net/index.php?page=series/sketchbook" target="_blank">Et téléchargeable ici !</a><br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t72.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=72" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Kodomo no Jikan ~ Ni Gakki OAV 02</h2>
<h4>10/05/09 par db0</h4>
<div class="p"><img src="images/news/knjng2.png" border="0"><br />La suite tant attendue des aventures de Rin, Kuro et Mimi ! Un épisode riche en émotion qui se déroule pendant la fête du sport où toutes les trois font de leur mieux pour que leur classe, la CM1-1, remporte la victoire ! Toujours en coproduction avec <a href="http://www.maboroshinofansub.fr/" target="_blank">Maboroshi</a>. Cet épisode a été traduit du Japonais par Sazaju car la vosta se faisait attendre, puis "améliorée" par Shana. C'est triste, hein ? Plus qu'un et c'est la fin... <a href="http://zerofansub.net/index.php?page=series/kodomoo">Ici, ici !</a>
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t69.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=69" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Sketchbook ~full color's~ 06 + 01v2 + 02v2 + 05v2</h2>
<h4>23/04/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/sketchh.jpg" border="0">
</div>
<div class="p">Une avalanche de Sketchbook ! Ou plutôt, une avalanche de fleurs ^^ Avec la sortie longtemps attendue de la suite de Sketchbook épisode 06 et de 3 v2 (tout ça pour améliorer la qualité de nos releases) Enjoy !
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t62.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=62" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Kodomo no Jikan ~ Ni Gakki OAV 01</h2>
<h4>13/04/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/knjoav1.png" border="0">
</div>
<div class="p">C'est maintenant que la saison 2 de Kodomo no Jikan commence vraiment ! Profitez bien de cette épisode ^^ Toujours en coproduction avec <a href="http://maboroshinofansub.fr" target="_blank">Maboroshi no fansub</a>, chez qui vous pourrez télecharger l'épisode en XDCC. Chez nous, c'est comme toujours en DDL. Nous vous rappelons que les torrents sont disponibles peu de temps après, et que tout nos épisodes sont disponibles en Streaming HD sur <a href="http://www.anime-ultime.net/part/Site-93" target="_blank">Anime-Ultime</a>.
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t58.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=58" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Kodomo no Jikan ~ Ni Gakki OAV Spécial</h2>
<h4>01/04/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/nigakki0.jpg" border="0">
</div>
<div class="p">Vous l'attendiez TOUS ! (Si, si, même toi) Il est arrivé ! Le premier OAV de la saison 2 de Kodomo no Jikan. Cet OAV est consacré à Kuro-chan et Shirai-sensei. Amateurs de notre petite goth-loli-neko, vous allez être servis ! Elle est encore plus kawaii que d'habitude ^^ La saison 2 se fait en coproduction avec <a href="http://maboroshinofansub.fr" target="_blank">Maboroshi</a> et avec l'aide du grand (ô grand) DC.
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t55.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=55" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Toradora! 24 + 25 - FIN</h2>
<h4>29/03/09 par db0</h4>
<div class="p"><a href="images/news/torafin.jpg" target="_blank"><img src="images/news/min_torafin.jpg" border="0"></a><br /><br />
C'est ainsi que se termine Toradora! ...<br />

<br />
<span>~ <a href="http://commentaires.zerofansub.net/t53-Toradora-FIN.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=53" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Toradora! 23</h2>
<h4>27/03/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/tora23.png" border="0">
</div>
<div class="p">
La suite de Toradora! avec l'épisode 23. Toujours aussi émouvant, toujours aussi kawaii, toujours aussi Taiga-Ami-Minorin-Ryyuji-ect, toujours aussi dispo sur <a href="http://toradora.fr/" target="_blank">Toradora.fr!</a>, toujours aussi en copro avec <a href="http://japanslash.free.fr" target="_blank">Maboroshi</a>, toujours en DDL sur notre site <a href="http://zerofansub.net/index.php?page=series/toradora">"Lien"</a>, Bref, toujours aussi génial ! Enjoy ^^<br /><br />Discutons un peu (dans les commentaires) ^^<br />Que penses-tu des Maid ? Tu es fanatique, fétichiste, amateur ou indifférent ?<br /><br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t52-Toradora-23.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=52" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Toradora! 22</h2>
<h4>25/03/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/taiiga.jpg" border="0">
</div>
<div class="p">
Que d'émotion, que d'émotion ! La suite de Toradora!, l'épisode 22. Nous vous rappelons que vous pouvez aussi télécharger les épisodes et en savoir plus sur la série sur <a href="http://toradora.fr/" target="_blank">Toradora.fr!</a>. Sinon, les épisodes sont toujours téléchargeables chez <a href="http://japanslash.free.fr" target="_blank">Maboroshi</a> en torrent et XDCC et chez nous <a href="http://zerofansub.net/index.php?page=series/toradora">par ici en DDL.</a> Enjoy ^^<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t51-Toradora-22.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=51" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Toradora! 21</h2>
<h4>23/03/09 par db0</h4>
<div class="p">
<div><img src="images/news/ski.jpg" border="0"><br /><br />
Toradora! encore et encore, et bientôt, la fin de la série. Cet épisode est encore une fois bourré d'émotion et de rebondissements... Et de luge, et de neige, et de skis ! <a href="http://zerofansub.net/index.php?page=series/mariaholic">C'est par ici que ça se télécharge !</a><br /><br />Profitions-en pour discutailler ! Alors, toi, lecteur de news de Zéro... Tu es parti en vacances, faire du ski ? Raconte-nous tout ça dans les commentaires ;)<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t50-Toradora-21.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=50" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div></div>
<p></p>

<h2>Toradora! 19</h2>
<h4>16/03/09 par db0</h4>
<div class="p"><img src="images/news/taigahand.jpg" border="0"><br />
Après une semaine d'absence (je passais mon Bac Blanc >.< ), nous reprenons notre travail. Ou plutôt, notre partenaire <a href="http://japanslash.free.fr" target="_blank">Maboroshi</a> nous fait reprendre le travail ^^ Sortie de l'épisode 19 de toradora, avec notre petite Taiga toute kawaii autant sur l'image de cette news que dans l'épisode ! Comme d'hab, DDL sur le site, Torrent bientôt (Merci à Khorx), XDCC bientôt et déjà dispo chez <a href="http://japanslash.free.fr" target="_blank">Maboroshi</a>. <a href="http://zerofansub.net/index.php?page=series/toradora">"Ze veux l'épisodeuh !"</a>.<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t46-Toradora-19.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=46" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Kodomo no Jikan 12 FIN</h2>
<h4>6/03/09 par db0</h4>
<div class="p"><img src="images/news/kodomo12fin.png" border="0"><br />
C'est ainsi, en ce 6 mars 2009, que nous fêtons à la fois l'anniversaire de la première release de Zéro (Kodomo no Jikan OAV) et l'achevement de notre première série de 12 épisodes. L'épisode 12 de Kodomo no Jikan sort aujourd'hui pour clore les aventures de nos 3 petites héroïnes : Rin, Mimi et Kuro. Il est dispo en DDL sur <a href="http://kojikan.fr">le site Kojikan.fr</a>. Un pack des 12 épisodes sera bientôt disponible en torrent. <br /><a href="http://kojikan.fr/?page=saison1-dl_1" target="_blank">Télécharger en DDL !</a><br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t44-Kodomo-no-Jikan-12-FIN.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=44" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Toradora! 18</h2>
<h4>5/03/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/noeltora.jpg" border="0">
</div>
<div class="p">
Serait-ce le rythme "une sortie / un jour" qui nous prend, à Zéro et <a href="http://japanslash.free.fr" target="_blank">Maboroshi</a> ? Peut-être, peut-être... En tout cas, voici la suite de Toradora!, l'épisode 18 ! <a href="http://zerofansub.net/index.php?page=series/toradora">Je DL tisouite !</a><br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t43-Toradora-17-Maria-Holic-04.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=43" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Toradora! 16</h2>
<h4>16 25/02/09 par db0 </h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/blond.jpg" border="0">
</div>
<div class="p">Toradora!, pour changer, en copro avec <a href="http://japanslash.free.fr/" target="_blank" class="postlink">Maboroshi no Fansub</a>. Un épisode plein d'émotion, de tendresse et de violence à la fois. À ne pas manquer ! <a href="http://zerofansub.net/index.php?page=series/toradora" target="_blank" class="postlink">L'épisode en DDL, c'est par ici !</a><br><br> ~ <a href="http://commentaires.zerofansub.net/t39-Toradora-10.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=39" target="_blank" class="postlink">Ajouter un commentaire</a> ~</div>
<p></p>
<p>
Toradora! 15 et Chibi JE Sud 20/02/09 par db0 <img src="http://zerofansub.net/images/news/chibi.jpg" border="0" /><br> En pleine chibi Japan Expo Sud, Toradora! continue avec ce soir l'épisode 15 !<br> <a href="http://zerofansub.net/index.php?page=series/toradora" target="_blank" class="postlink">L'épisode en DDL, c'est par ici !</a><br> Rejoignez nous pour cet évenement : <br> Chibi Japan Expo à Marseille ! J'y serais, Kanaii y sera. Nous serions ravis de vous rencontrer, alors n'hésitez pas à me mailer (Zero.fansub@gmail.com).<br><br> Dernières sortie de nos partenaires :<br> Kyoutsu : Minami-ke Okawari 02 et Ikkitousen OAV 04<br> Kanaii : Kamen no Maid Guy 08<br> Sky-fansub : Kurozuka 09 et Mahou Shoujo Lyrical Nanoha Strikers 25<br><br> ~ <a href="http://commentaires.zerofansub.net/t41-Toradora-15-et-Chibi-JE-Sud.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=41" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Toradora! 12-13-14 17/02/09 par db0 <img src="http://zerofansub.net/images/news/dentifrice.jpg" border="0" /><br> db0 s'excuse pour sa news ultra-courte de la dernière fois pour Maria Holic 3 et en compensasion va raconter sa vie dans celle-ci (Non, pas ça !). C'est aujourd'hui et pour la première fois chez Zéro une triple sortie ! Les épisodes 12, 13 et 14 de Toradora! sont disponibles, toujours en copro avec <a href="http://japanslash.free.fr/" target="_blank" class="postlink">Maboroshi</a>.<br> <a href="http://zerofansub.net/index.php?page=series/toradora" target="_blank" class="postlink">Les épisodes en DDL, c'est par ici !</a><br><br> J'en profite aussi pour vous préciser que les 2 autres versions de Maria 03 sont sorties.<br> Mais surtout, je vous sollicite pour une IRL :<br> Chibi Japan Expo à Marseille ! J'y serais, Kanaii y sera. Nous serions ravis de vous rencontrer, alors n'hésitez pas à me mailer (Zero.fansub@gmail.com).<br><br> ~ <a href="http://commentaires.zerofansub.net/t40-Toradora-12-13-14.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=40" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Toradora! 11 11/02/09 par db0 	<br> <img src="http://japanslash.free.fr/images/news/toradora11.jpg" border="0" /> <br> La suite, la suite ! Toradora! épisode 11 sortie, en copro avec <a href="http://japanslash.free.fr/" target="_blank" class="postlink">Maboroshi no Fansub</a>.<br><br><br> <a href="http://zerofansub.net/index.php?page=series/toradora" target="_blank" class="postlink">L'épisode en DDL, c'est par ici !</a><br><br> ~ <a href="http://commentaires.zerofansub.net/t39-Toradora-10.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=39" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Toradora! 10 10/02/09 par db0 	<br> <img src="http://zerofansub.net/images/news/ami.png" border="0" /> <br> En direct de Nice, et pour ce 10 Février, l'épisode 10 de Toradora! en co-production avec <a href="http://japanslash.free.fr/" target="_blank" class="postlink">Maboroshi no Fansub</a>, qui est de retour, comme vous l'avez vu ! (Avec Kannagi 01, Mermaid 11-12-13 et Kimi Ga 4). Pour Toradora!, nous allons rattraper notre retard !<br><br><br> <a href="http://zerofansub.net/index.php?page=series/toradora" target="_blank" class="postlink">L'épisode en DDL, c'est par ici !</a><br><br> ~ <a href="http://commentaires.zerofansub.net/t39-Toradora-10.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=39" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Kojikan 10 3/02/09 par db0 	 <img src="http://zerofansub.net/images/news/kodomo10.jpg" border="0" /><br> RIIINN est revenue ! Elle nous apporte son dixième épisode. Plus que 2 avant la fin, et la saison 2 par la suite. Une petite surprise arrive bientôt, sans doute pour le onzième épisode. En attendant, retrouvez vite notre petite délurée dans la suite de ses aventures et ses tentatives de séduction de Aoki-sensei...<br><br> ~ <a href="http://commentaires.zerofansub.net/t37-Kojikan-10.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=37" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Toradora! 09 4/12/08 par db0 <br> 	<img src="http://zerofansub.net/images/news/tora.jpg" border="0" /> <br> L'épisode 09 de Toradora! est terminé ! Nous avons pris du retard car la MNF (en co-production) est actuellement en pause temporaire (Tohru n'a plus internet).<br> <a href="http://zerofansub.net/index.php?page=series/toradora" target="_blank" class="postlink">Pour télécharger les épisodes en DDL, cliquez ici !</a><br><br>  <span style="font-weight: bold">Les dernières sorties de la <a href="http://www.sky-fansub.com/" target="_blank" class="postlink">Sky-fansub</a> :</span><br> Kurozuka 07<br> Mahou Shoujo Lyrical Nanoha Strikers 20<br> <br> <span style="font-weight: bold">Les dernières sorties de la <a href="http://kyoutsu-subs.over-blog.com/" target="_blank" class="postlink">Kyoutsu</a> :</span><br> Hyakko 05<br> <br> <span style="font-weight: bold">Les dernières sorties de la <a href="http://www.kanaii.com/" target="_blank" class="postlink">Kanaii</a> :</span><br> Kamen no maid Guy 06<br> Rosario+Vampire Capu2 06<br> <br><br>    ~ <a href="http://commentaires.zerofansub.net/t31-Toradora-09.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=31" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Kodomo no Jikan 09, Recrutement QC, trad it&gt;fr13/12/08 par db0<br><img src="http://zerofansub.net/images/news/kodomo9.jpg" border="0" /><br>Rin, Kuro et Mimi reviennent enfin vous montrer la suite de leurs aventures ! Sortie aujourd'hui de l'épisode 09, merci à DC qui nous l'a encodé. Les 3 versions habituelles sont dispos en DDL.<br><br>Nous recrutons toujours un QC ! Proposez-vous !<br>Nous avons décider de reprendre le projet Mermaid Melody Pichi Pichi Pitch, mais pour cela nous avons besoin d'un traducteur italien &gt; français. N'hésitez pas à postuler si vous êtes intéressés <img src="http://img1.xooimage.com/files/s/m/smile-1624.gif" alt="Smile" border="0" class="xooit-smileimg" /> Par avance, merci. <a href="http://zerofansub.net/index.php?page=recrutement" target="_blank" class="postlink">Lien</a><br><br><span style="font-weight: bold">Les dernières sorties de la <a href="http://www.kanaii.com/" target="_blank" class="postlink">Kanaii</a> :</span><br>Kanokon pack DVD 06 à 12<br>Rosario + Vampire S2 -05<br><span style="font-weight: bold">Les dernières sorties de la <a href="http://www.sky-fansub.com/" target="_blank" class="postlink">Sky-fansub</a> :</span><br>Kurozuka 05 HD<br>Mahou Shoujo Lyrical Nanoha Strikers 17<br><br>~ <a href="http://commentaires.zerofansub.net/t22-Kodomo-no-Jikan-09-Recrutement-QC-trad-it-fr.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=22" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Sketchbook ~full color's 04~ ; Kanaii DDL et Sky-fansub05/12/08 par db0<br><img src="http://zerofansub.net/images/news/moka.jpg" border="0" /><br>Bouonjòu !<br>L'épisode 04 de Sketchbook est sorti ! <a href="http://zerofansub.net/index.php?page=series/sketchbook" target="_blank" class="postlink">Lien</a> Les sorties se font attendre, étant donné qu'on a plus vraiment d'encodeur officiel ^^ Merci à Kyon qui nous a encodé c'lui-ci.<br>Beaucoup nous demandaient où il fallait télécharger nos releases. Probléme réglé, j'ai fait une page qui résume tout. <a href="http://zerofansub.net/index.php?page=dl" target="_blank" class="postlink">Lien</a><br>J'offre aussi du DDL à notre partenaire : la team Kanaii. Allez télécharger leurs animes, ils sont très bons ! <a href="http://zerofansub.net/index.php?page=kanaiiddl" target="_blank" class="postlink">Lien</a><br>Nous avons aussi un nouveau partenaire : La team Sky-fansub. <a href="http://www.sky-fansub.com/" target="_blank" class="postlink">Lien</a><br>//<a href="http://db0.fr/" target="_blank" class="postlink">db0</a><br>PS : &quot;Bouonjòu&quot; c'est du niçois <img src="http://img1.xooimage.com/files/s/m/smile-1624.gif" alt="Smile" border="0" class="xooit-smileimg" /><br><br>Les dernières sorties de la <a href="http://japanslash.free.fr/" target="_blank" class="postlink">Maboroshi</a> :<br>- Neo Angelique Abyss 2nd Age 07<br>- Akane Iro Ni Somaru Saka 07<br><br><br>~ <a href="http://commentaires.zerofansub.net/t17-Sketchbook-full-color-s-04-Kanaii-DDL-et-Sky-fansub.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=17" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p><img src="http://zerofansub.net/images/news/toradora.png" border="0" /><br><span style="font-weight: bold">Toradora! 07</span><br>24/11/08 par db0<br><br><br>Ohayo mina !<br>La suite de Toradora est arrivée ! Et toujours en co-production avec la Maboroshi  <img src="http://img1.xooimage.com/files/s/m/smile-1624.gif" alt="Smile" border="0" class="xooit-smileimg" /> <br>Cet épisode se déroule à la piscine, et &quot;Y'a du pelotage dans l'air !&quot; Je n'en dirais pas plus.<br>L'épisode est sorti en DDL en format avi, en XDCC. Comme toujours, il sortira un peu plus tard en H264, torrent, streaming, ect.<br>//<a href="http://db0.fr/" target="_blank" class="postlink">db0</a><br><br>~ <a href="http://commentaires.zerofansub.net/t14-Toradora-06.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=14" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p><span style="font-weight: bold">Sketchbook ~full color's 03~</span><br>22/11/08 par db0<br><br>Bonjour, bonjour !<br>Sortie de l'épisode 03 de Sketchbook full color's !<br>Et c'est tout. Je sais pas quoi dire d'autre. Bonne journée, mes amis. <br>//<a href="http://db0.fr/" target="_blank" class="postlink">db0</a><br><br>~ <a href="http://commentaires.zerofansub.net/t13-Sketchbook-full-color-s-03.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=13" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p><img src="http://zerofansub.net/images/news/img_shinobu.gif" border="0" /><br><span style="font-weight: bold">Nouveau XDCC, Radio, Scantrad et Toradora! 06</span><br>20/11/08 par db0<br><br>Bonjour tout le monde !<br>J'ai aujourd'hui plusieurs bonnes nouvelles à vous annoncer :<br>La V3 avance bien, et je viens de mettre à jour les pages pour le scantrad, car comme vous le savez, nous commençons grâce à François et notre nouvelle recrue Merry-Aime notre premier projet scantrad : Kodomo no Jikan.<br>J'ai aussi installée la radio tant attendue et mis sur le site quelques OST.<br>Nous avons aussi, grâce à Ryocu, un nouveau XDCC. Vous aviez sans doute remarquer que nous ne pouvions pas mettre à jour le précédent. Celui-ci sera mis à jour à chaque nouvelle sortie.<br>Et enfin, notre dernière sortie : Toradora! 06. Toujours en co-production avec<a href="http://japanslash.free.fr/" target="_blank" class="postlink">Maboroshi</a>.<br>Enjoy  <img src="http://img1.xooimage.com/files/w/i/wink-1627.gif" alt="Wink" border="0" class="xooit-smileimg" /> <br>//<a href="http://db0.fr/" target="_blank" class="postlink">db0</a><br><br>~ <a href="http://commentaires.zerofansub.net/t7-Nouveau-XDCC-Radio-Scantrad-et-Toradora-06.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=7" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>
-------------------------
<h2>[Zero] BlogBang</h2>
<h4>00/00/00 par db0</h4>
<div class="p"><script src="http://www.blogbang.com/demo/js/blogbang_ad.php?id=6ee3436cd7"
type="text/javascript"></script>
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t64.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=64" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

