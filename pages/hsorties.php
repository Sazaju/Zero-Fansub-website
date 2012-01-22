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
<h2>Kujibiki Unbalance Ã©pisode 09</h2>
<h4>18/08/2010 par db0</h4>
<div class="p">
<img src="images/news/kujian9news.jpg" alt="Kujibiki Unbalance Ã©pisode 09 - Yamada montre sa culotte Renko" /><br /><br />
Chihiro, Tokino, Koyuki, Yamada et Renko sont de retour pour la suite de leurs aventures pour devenir les membres du conseil des Ã©lÃ¨ves de Rikkyouin ! Retrouvez les dans cet Ã©pisode 09 oÃ¹ Yamada ne sera pas dans son Ã©tat normal...<br />
Comme d'habitude, l'Ã©pisode est tÃ©lÃ©chargeable sur la page de la sÃ©rie partie "Projets" en tÃ©lÃ©chargement direct uniquement et plus tard en torrent, XDCC, etc.<br />
<br />
<img src="images/news/news_dons_k-on.gif" alt="Merci pour le don a Herve ! K-On money money" /><br /><br />
Un grand <strong>merci</strong> Ã  HÃ©rvÃ© pour son don de 10 euros qui va nous aider Ã  payer nos serveurs !<br />
<br />
A bientot !<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t243.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=243" target="_blank">Ajouter un commentaire</a> ~<br />
~ <a href="http://twitter.com/home?status=Sortie de Kujibiki Unbalance episode 09 chez Zero ! http://zerofansub.net/" target="_blank" onclick="javascript:pageTracker._trackPageview ('/outbound/twitter.com');">Partager sur <img src="images/autre/logo_twitter.png" border="0" alt="twitter" /></a> ou <a name="fb_share" type="button" share_url="http://zerofansub.net/"></a>
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>~</span><br /><br /></div>
<p></p>

<h2>Sketchbook ~ full color's  ~ Picture Drama sÃ©rie complÃ¨te (01 Ã  06)</h2>
<h4>26/06/2010 par db0</h4>
<div class="p">
<img src="images/news/sketchdrama.png" alt="Sketchbook ~ full color's ~ Picture Drama" /><br />
Pour fÃªter les vacances qui arrivent, Sora et ses amies vous emmenent avec elles Ã  la mer !<br />
C'est une petite sÃ©rie de 6 Ã©pisodes de moins de 10 minutes chacun qui Ã©taient en Bonus sur les DVDs de Sketchbook ~ full color's ~. Ils ont Ã©tÃ© rÃ©alisÃ© Ã  partir du Drama CD de la sÃ©rie et l'animation est minime. Dans la mÃªme douceur que la sÃ©rie, ils sont parfait pour se reposer en pensant aux vacances qui arrivent.
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t234.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=234" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Kujibiki Unbalance 2 episode 08</h2>
<h4>03/04/2010 par db0</h4>
<div class="p">
<img src="images/news/newskuji8.png" /><br />
Comment attirer l'oeil des fans d'animes de chez Zero ?<br />
Avec une paire de seins, evidemment !<br />
Episode 8 de Kujibiki Unbalance 2 en exclusivite total gratuit pas cher promo solde !<br />
Un episode qui m'a beaucoup plu, tres tendre et qui revele des elements cles de l'histoire.<br />
En reponse au precedent sondage, il n'est ABSOLUMENT PAS NECESSAIRE D'AVOIR VU GENSHIKEN OU LA PREMIERE SAISON de Kujibiki Unbalance pour regarder celle-ci. Les histoires ont quelques liens mais sont completement independantes les unes des autres. C'est une serie a part.<br />
Bon episode a tous et a tres bientot !
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t220.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=220" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Potemayo [08] 15 + 16</h2>
<h4>01/03/2010 par db0</h4>
<div class="p">
<img src="images/news/pote8.jpg" /><br />
Anyaa~~<br />
Potemayo, épisode 8, youhou ! Et très bientôt, Kanamemo, Isshoni H shiyo et Isshoni sleeping ! Enjoy, Potemayo !
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t207.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=207" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Potemayo [07] 13 + 14</h2>
<h4>30/01/2010 par Tarf</h4>
<div class="p">
<img src="images/news/moepote1.jpg"><br />
Revenons à nos charmants allumés dans un PotemaYo que j'ai particulièrement aimé.<br />
<br />
Deux épisodes : La fin de l'été, et La nuit du Festival<br />
<br />
Encore, encore un épisode totalement déjanté, où on va devoir faire du nettoyage... et prier. Puis on va manger de la glace à base de lait avec un type fou, fou, fou ^^<br />
Hé, vous voulez savoir comment on fait cuir plus vite des ramens ?<br />
<br />
Moi ça m'éclate comment Potemayo sait dépenser son argent<br />
ENJOY IT !<br />
<img src="images/news/moepote2.jpg"><br />
db0 dit : Les screens ci-dessus n'ont rien à voir avec l'épisode :) Ce sont des extraits de Moetan, l'épisode 11. J'en profite donc pour faire une petite pub à notre partenaire <a href="http://kanaii.com" target="_blank">Kanaii</a> grâce à qui on peut regarder Moetan avec des sous-titres d'excellente qualité.
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t191.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=191" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin</h2>
<h4>19/01/2010 par db0</h4>
<div class="p">

<img src="images/news/newkodomo1.jpg" alt="Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin" /><br /><br />

Vous l'avez attendu longtemps, celui-là ! Il faut dire qu'il est quand même sorti en aout. Alors pourquoi le sortir si tard ? Surtout qu'il faut savoir qu'il était prêt en septembre. C'est simple : Pour toujours rester dans l'optique de la qualité de nos animes, nous attendions que les paroles officielles du nouvel ending sortent. Malheuresement, elle ne sont toujours pas sorties à l'heure actuelle. Nous pensons donc que les chances qu'elles sortent maintenant sont minimes et avons à contre-coeur décidé de sortir l'OAV maintenant et sans le karaoké. Cependant, sachez que s'il s'avère que les paroles finissent par sortir, même tardivement, nous sortirons une nouvelle version de celui-ci avec le karaoké !<br />
Merci à DC pour avoir encodé cet épisode et Maboroshi, avec nous en coproduction sur cette série.<br />
C'est avec ce dernier épisode que nous marquons la fin de Kodomo no Jikan ! C'est ma série préférée et je pense que c'est aussi la préférée de beaucoup de membres de chez Zéro et sa communauté.<br />
Nous avons passé du bon temps aux côtés de Rin et ses deux amies et nous éspérons que c'est aussi votre cas.<br /><br />

<img src="images/news/newkodomo2.jpg" alt="Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin" /><br /><br />

<img src="images/news/newkodomo3.jpg" alt="Kodomo no Jikan ~Ni Gakki~ OAV 03 - Fin" />
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t185.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=185" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Tayutama ~Kiss on my deity~ 12 - Fin</h2>
<h4>12/01/2010 par db0</h4>
<div class="p">
C'est aujourd'hui la fin de Tayutama. Le douzième et dernier épisode toujours en coproduction avec nos amis de chez Maboroshi. Nous éspérons que vous avez passé un bon moment avec nous pour cette merveilleuse série ! Et maintenant, it's scrolling time !<br /><br />
<img src="images/news/tayufin1.jpg" /><br />
<img src="images/news/tayufin2.jpg" /><br />
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t176.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=176" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Tayutama - Kiss on my Deity - 11</h2>
<h4>04/12/09 par TchO</h4>
<div class="p"><img src="images/news/mashinoel.jpg" /><br />
Tayu 11, la Bataille Décisive !!<br /><br />

Pour calmer la colère du dragon, la grande prêtresse Mashiro tente...<br />
Hé !!!!! Mais que se passe-t-il ????? C't'une surprise !!!<br /><br />

Pour la Bataille Décisive, on a droit à un cosplay de Dieu !!<br />
Si c'est comme ça que Mashiro espère gagner la partie !<br /><br />

Tenez bon ! La fin se précise, et elle est belle à regarder !<br /><br />

Coproduction Zero+Maboroshi !<br />
TchO_°
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t152.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=152" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Tayutama - Kiss on my Deity - 10</h2>
<h4>17/11/09 par TchO</h4>
<div class="p"><img src="images/news/tayu10.jpg" /><br />
L'Horoscope d'aujourd'hui :<br />
Humains : Ecrasé par l'émotion, sachez éviter les coups de marteau !<br /><br />

Portée par le rêve de la coexistence, Yumina-chan danse.<br /!!
Quant à Ameri, elle est la proie de ses mauvais rêves...<br /><br />

Même romantique, la passion peut être tellement furieuse !
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t149.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=149" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Hitohira 05 + 06</h2>
<h4>10/11/09 par db0</h4>
<div class="p"><img src="images/news/hito5.jpg" /><br />
Mugi-choco ! Tu nous as tellement manqué... Et tu reviens en maillot de bain, à la plage ! Yahou ! Mugi-Mugi-choco !!
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t142.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=142" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Tayutama - Kiss on my Deity - 09</h2>
<h4>05/11/09 par TchO</h4>
<div class="p"><img src="images/news/tayuu9.jpg" /><br />
Mashiro découvre que la moto est un souci pour aller aux sources d'eau chaudes.<br /><br />

Hé, on va tous faire un karaoké ?<br />
C'est le moment de s'amuser !<br />
Entre deux entraînements, une balade à la tour de Tokyo.<br />

Les sentiments de Mashiro n'échappent à personne, ni à Ameri, ni à...<br /><br />

Une Zero + Maboroshi coprod<br /><br />

TchO_°<br />
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t141.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=141" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Tayutama - Kiss on my Deity - 08</h2>
<h4>05/11/09 par TchO</h4>
<div class="p"><img src="images/news/tayuuu.jpg" /><br />
Tayutama !!!!!!<br />
Tayutama, c'est pour ce soir l'épisode 08, toujours coproduit avec la Maboroshi.<br />
Un épisode qui nous livre, dans une exceptionnelle interprétation, un remake de "j'assortis mon foulard avec ma jupe".<br />
Et puis, on allait pas louper la tronche de Yuuri pour une fois ^^<br />
(Ca veut dire quoi, au fait, Tayutama ?)<br />
Profitez-en bien, c'est toujours aussi délire !!<br />
db0 dit :<br />
J'en profite en coup de vent pour vous annoncer que la deuxième session de Konshinkai à Lyon arrive en fin du mois, et pour ça, un forum a fait son ouverture ainsi qu'un nouveau site et un chan irc. Venez nombreux ! <a href="http://konshinkai.c.la" target="_blank">+ d'infos, clique.</a>
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t140.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=140" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Tayutama - Kiss on my Deity - 06 + 07 + Kanamemo 02</h2>
<h4>05/11/09 par db0, praia et Tarf</h4>
<div class="p"><img src="images/news/tayuu.jpg" /><br />
Bonjour tout le monde !<br />
Je me suis dit que c'était toujours moi qui rédigait les news, et qu'il serait temps que ça change. Donc j'ai demandé à quelques membres de l'équipe de le faire. J'ai trouvé le résultat assez marrant, donc je vous donne leurs petites idées de news :<br /><br />
Praia dit :<br />
"On abandonne tout et on recommence : Tayutama 6 et 7 en copro avec la Maboroshi.<br />
Bon leech ! Version MP4 disponible uniquement.<br />
Kanamemo, c'est quoi ? C'est la série des petits pervers... non, vous voyez, suis pas fait pour faire des news, moi... ^_^
Dommage que Sunao ne soit pas là... Il nous aurait pondu une brique > <"
<br /><br />
Tarf dit :<br />
"Hein ? J'ai pas signé pour ça moi ! Et puis je suis juste un petit trad qui fait un peu de time à ses heures perdus, donc je fais le début de chaîne. C'est aux gens en bout de chaîne de faire ça non ? Va donc voir le joli post "staff" que tu as pondu sur toutes les séries, et choppe le dernier nom ^^.<br />

Bon, une petite news : "J'ai pu rencontrer samedi 31 octobre, à l'occasion du Konshinkai trois personnes parfois intéressantes. J'ai ainsi parlé IRL mon idole Ryokku, qui travail en tant qu'admin pour anime ultime, qui est à mon avis un des meilleurs sites français d'anime. Après une interview exclusive de ce monument vivant de l'animation, il m'a confié qu'il désespérait de la saison en cours d'anime, et qu'aucun ne trouvait grâce à ses yeux. N'ayant pas les mêmes goûts que lui, je ne suis pas d'accord, mais moi tout le monde s'en fout. Pour ceux que ça interesse, il est gentil, jeune et dynamique ! Avis aux jeunes filles, jetez vous dessus !"<br />

Tayutama Kiss on my deity, épisode 6 et 7 enfin sortis en corproduction avec la Maboroshi no Fansub ! La suite des aventures plus ou moins osée de l'avatar fort mignon d'une déesse dans le monde réel. Vous y retrouverez l'amie d'enfance jalouse, la Tsundere et la naïve à forte poitrine. La version MP4 est disponible immédiatement sur le site, la version AVI étant abandonnée."<br /><br />
db0 dit :<br />
J'en profite en coup de vent pour vous annoncer que la deuxième session de Konshinkai à Lyon arrive en fin du mois, et pour ça, un forum a fait son ouverture ainsi qu'un nouveau site et un chan irc. Venez nombreux ! <a href="http://konshinkai.c.la" target="_blank">+ d'infos, clique.</a><br /><br />

<h2>Genshiken 12 ~ fin ! + 01v2 & 02v2</h2>
<h4>29/09/09 par db0</h4>
<div class="p"><img src="images/news/ogiue.jpg" /><br />
Et ainsi se termine Genshiken, le club d'étude de la culture visuelle moderne, avec un 12e épisode et quelques v2 pour perfectionner. Elle est pas trop mignonne, comme ça, Ogiue ?
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t133.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=133" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Maria+Holic 12 - Fin de la série</h2>
<h4>20/08/09 par db0</h4>
<img src="images/news/mariafin.png" style="float: right;" />
<div class="p">
Cette série était si drôle qu'elle est passée bien vite... Eh oui ! Déjà le dernier épisode de Maria+Holic ! Ce 12e épisode est complétement délirant, Kanako fait encore des siennes, et Mariya la suit de près. Avec la fin de cette série se termine aussi une coproduction avec Kanaii, nos partenaires et amis, qui s'est exellement bien passée et que nous accepterons avec plaisir de renouveler. Merci à eux et particulièrement à DC, le maître du projet aux superbes edits AE. Bon dernier épisode, et aussi bonne série à ceux qui attendaient la fin pour commencer la série compléte !
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t115.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=115" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Canaan 07 + Maria Holic 11 + Mermaid Melody 02</h2>
<h4>17/08/09 par db0</h4>
<img src="images/news/canaan7.png" style="float: right" />
<img src="images/news/maria11.png" style="float: left" />
<div class="p">
Une triple sortie ce soir !<br /><br />
Tout d'abord, l'habituel Canaan de la semaine avec l'épisode 07. Cet épisode était particulièrement difficile, avec tout ces politiciens, tout ça tout ça, donc nous a pris plus de temps que prévu mais nous y sommes arrivé !<br /><br />
Une deuxième sortie qui est en fait un épisode déjà encodé depuis longtemps mais que nous n'avions pas encore mis sur le site, l'épisode 2 version italienne de Mermaid Melody Pichi Pichi Pitch. Je pense ne décevoir personne, mais je rappelle que nous abandonnons les versions italiennes pour continuer les versions japonaises de chez Maboroshi (nous recrutons pour cela un traducteur ! SVP ! Help us !). Les liens de téléchargement des 13 épisodes par Maboroshi ne sont pas encore tous mis en place mais le seront dans le courant de la journée de demain.<br /><br />
Et enfin, la suite de Maria Holic que vous attendiez tous ! L'épisode 11 et... avant-dernier épisode. Profitez bien de ce concentré d'humour avant la fin de cette superbe série, toujours en coproduction avec nos chers amis de chez Kanaii. La version avi ne sera disponible que demain.
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t113.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=113" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Potemayo 06 (11 + 12)</h2>
<h4>04/08/09 par db0</h4>
<div class="p"><img src="images/news/pote.jpg" alt="" /><br />
Le sondage de la semaine dernière était un peu foireux parce ce qu'on pouvait pas voter en fait donc euh les commentaires seront pris en compte finalement. Merci pour vos réponses. Nous continueront of course à poster moultes actualités concernant autre chose que le fansub. Ce sont les vacances, donc nous en profitons bien, mais nous ne chômons pas quand même et vous proposons donc quelques petits épisodes à regarder entre 2 séries de bronzage ou de baignade ou que sais-je encore de randonnées, de visites au musée, pourquoi pas de job d'été, ect. M'enfin, bref, je m'étale inutilement (comment ça, comme d'habitude ?) et vous propose de vous rendre sur le site si vous n'y êtes pas déjà pis d'aller télécharger notre petit potemayo, mignon potemayo, potemayo, potemayo naaassuuu !! (ça veut rien dire, c'est normal, j'ai un peu bu)(bah quoi ? c'est les vacances ou pas ?). Je regretterai sûrement d'avoir écrit une news aussi foncedé demain mais bon vous inquiétez pas je l'étais pas quand je taffais sur cet épisode, hein. J'vous l'jure, m'sieur l'agent. J'suis sobre, moi, j'bois pas. Jamais, jamais. J'vais jamais en soirée ou quoi, non, non. Moi, je fais du fan-sub ! Du fan-sub ! Sinon, vous avez vu, l'image de sortie, au dessus ? Elle est pourrie, hein ? C'est parce que je sais pas me servir de Gimp et que j'ai internet qu'avec ubuntu parce que j'ai fait ça avec un téléphone portable, en fait. C'est ça, marrez-vous. M'enf, j'apprendrais à utiliser Gimp !! Bon, bon. Et l'image du mois, elle vous plaît ? Ouais, c'est des nichons, tout ça, là, ça vous plaît, ce genre de trucs. Moi, ça me plaît bien en tout cas. Je kiffe ma race, même, je dirais. Et moi, je fais du cosplay !! Si, si. Fin.
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t108.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=108" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>


<h2>Tayutama ~ Kiss on my Deity ~ 06</h2>
<h4>21/07/09 par db0</h4>
<div class="p"><img src="images/news/newtayu.jpg" border="0" /><br />
On vous l'avait promis : on n'allait pas laisser tomber Maboroshi ! Et voilà, c'est chose faite : l'épisode 06 de Tayutama sort aujourd'hui. J'espère qu'il vous plaira.
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t105.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=105" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Genshiken 2 épisode 11</h2>
<h4>19/07/09 par db0</h4>
<img src="images/news/genshiken-11.jpg" style="float: right" border="0">
<div class="p">
C'est les vacances pour certains membres de chez Zéro donc on a le temps de s'occuper de vous... Du moins, des épisodes que vous attendez avec impatience. (Pour qu'on s'occupe de vous personnellement, appelez le 08XXXXXXXX 0.34€ la minute demandez Sonia) Bref, ce soir sort l'épisode 11 de la saison 2 de Genshiken, c'est-à-dire l'avant dernier de la série. Les deux copines américaines sont toujours là pour vous faire rire, mais partieront à la fin de l'épisode. Profitez bien, c'est bientôt la fin ^^
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t104.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=104" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Kujibiki Unbalance 2 07</h2>
<h4>18/07/09 par db0</h4>
<img src="images/news/kuji.jpg" style="float:right;" border="0">
<div class="p">
Kujibiki Unbalance est de retour avec l'épisode 7 qui sort aujourd'hui. Il est riche en émotion pour nos héros et particulièrement pour Tokino. Un nouveau personnage apparaît et on découvre des informations sur les personnages. Je vous laisse découvrir tout ça...
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t102.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=102" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Canaan 01 + Maria Holic 10</h2>
<h4>16/07/09 par db0</h4>
<div class="p"><img src="images/news/canaan.jpg" border="0"><br />
Une double sortie ce soir (peut-être pour rattraper vos attentes ?) dont l'épisode 10 tant attendu de Maria Holic avec comme toujours nos potes de chez Kanaii, et une nouvelle série : Canaan. C'est un nouveau projet assez original puisque c'est un genre d'anime qu'on ne fait habituellement chez Zéro. En fait, c'est Ryocu (le chef ultime !) qui s'est motivé à la traduire. J'espère qu'elle vous plaiera ! Bon download !<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t101.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=101" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Fin de la série Sketchbook ~full color's~</h2>
<h4>30/06/09 par db0</h4>
<div class="p"><img src="images/news/sketchend.jpg"><br />
Nous avons temporairement repris de nos activités pour finir la série Sketchbook full color's. Sortie aujourd'hui de 5 épisodes d'un coup : 09, 10, 11, 12 et 13 :) Profitez bien de ctte magnifique série, et à dans deux jours à Japan Expo !
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t98.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=98" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Maria Holic 09</h2>
<h4>05/06/09 par db0</h4>
<img src="images/news/maria9.jpg" style="float:right;" border="0">
<div class="p">La team était en "semi-pause", maintenant que notre épisode en coproduction est sorti (Maria Holic 09 avec Kanaii), la team est en pause totale et revient en juillet. Bon épisode en attendant.<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t78.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=78" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Genshiken 10</h2>
<h4>24/05/09 par db0</h4>
<img src="images/news/gen10.jpg" style="float:right;" border="0">
<div class="p">Notre petit Week-end d'otaku kanaii-zéro s'est très bien passé, dommage pour ceux qui n'y étaient pas ^^<br />Vous vous en foutez ? Anyaa ~~ Bon, bon, le v'là votre épisode 10 de Genshiken.<br />
Petite info importante : L'OAV de KissXsis est en cours. Après sa sortie, Zéro se met en "pause" temporaire puisque je passe mon bac.<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t76.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=76" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Genshiken 09</h2>
<h4>22/05/09 par db0</h4>
<img src="images/news/genshi9.jpg" style="float:right;" border="0">
<div class="p">Nyaron~ La suite de Genshiken 2 avec l'épisode 09. Bon download, bande d'otaku.<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t75.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=75" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Potemayo 05</h2>
<h4>21/05/09 par db0</h4>
<img src="images/news/pote5.jpg" style="float:right;" border="0">
<div class="p">Si c'est pas trop Kawaii, ça ? Bah oui, c'est Potemayo ! Comme vous le savez, notre partenaire, Kirei no Tsubasa, a déposé le bilan récemment. Histoire de ne pas laisser leurs projets tomber à l'eau, nous avons accepté de reprendre le projet Potemayo. Nous continuons là où ils se sont arrêté et sortons l'épisode 05. Les épisodes 01 à 04 sont aussi disponibles sur le site. Honi Honi ~<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t74.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=74" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
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

<h2>Genshiken2 08 + Sortie Kanaii</h2>
<h4>10/05/09 par db0</h4>
<div class="p"><img src="http://moe.mabul.org/up/moe/2009/05/10/img-122101gdcpq.png" border="0"><br />3 sorties en une journée, c'est un cas plutôt rare ! La suite de Genshiken2, c'est<a href="http://zerofansub.net/index.php?page=series/kodomoo">par là</a> avec l'épisode 08 qui sort aujourd'hui. Plus tar dans la soirée sortieront les versions LD de Kodomo oav2 et md, ld de Maria Holic 08.<br /><br />
Une petite sortie Kanaii-Zéro est organisée entre Otaku le 23 et 24 mai à Nice ! Les sudistes pourront ainsi se retrouver sur nos plages ensoleillées pour se sentir un peu en vacances. Et les nordistes, n'hésitez pas à descendre nous voir ! Si vous souhaitez être de la partie, n'hésitez pas ! Envoyez-moi un mail (zero.fansub@gmail.com) ou venez vous signaler sur le forum Kanaii : <a href="http://www.kanaii.com/e107_plugins/forum/forum_viewtopic.php?46591" target="_blank">Lien</a>. Venez nombreux !
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t70.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=70" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Kodomo no Jikan ~ Ni Gakki OAV 02</h2>
<h4>10/05/09 par db0</h4>
<div class="p"><img src="images/news/knjng2.png" border="0"><br />La suite tant attendue des aventures de Rin, Kuro et Mimi ! Un épisode riche en émotion qui se déroule pendant la fête du sport où toutes les trois font de leur mieux pour que leur classe, la CM1-1, remporte la victoire ! Toujours en coproduction avec <a href="http://www.maboroshinofansub.fr/" target="_blank">Maboroshi</a>. Cet épisode a été traduit du Japonais par Sazaju car la vosta se faisait attendre, puis "améliorée" par Shana. C'est triste, hein ? Plus qu'un et c'est la fin... <a href="http://zerofansub.net/index.php?page=series/kodomoo">Ici, ici !</a>
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t69.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=69" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Maria Holic 08 + Doujin</h2>
<h4>09/05/09 par db0</h4>
<img src="images/news/maria8.jpg" style="float:right;" border="0">
<div class="p">Maria Holic épisode 08 pour aujourd'hui, en coproduction avec Kanaii. Un épisode plutôt riche, et toujours aussi drôle. En bonus avec cet épisode, les images des anges "cosplayés" pendant l'épisode. <a href="http://zerofansub.net/index.php?page=series/mariaholic">C'est par là !</a>
<br /><br />PARTIE HENTAÏ :<br />Une mise à jour de la partie hentaï du site et la sortie d'un doujin de He is my master <a href="http://zerofansub.net/index.php?page=havert">Par là !</a><br /><br />
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t67.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=67" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Maria+Holic 07</h2>
<h4>24/04/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/maria7.jpg" border="0">
</div>
<div class="p">La suite de Maria+Holic, toujours en coproduction avec nos petits kanailloux. Disponible en DDL pour l'instant, et un peu plus tard en torrent et MU. J'en profite pour vous informer que nous risquons de ralentir le rythme puisque je suis en vacances, mais que dès la rentrée, tout reviendra dans l'ordre. 
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t63.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=63" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
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

<h2>Kujibiki Unbalance 2 06</h2>
<h4>14/04/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/kuji6.jpg" border="0">
</div>
<div class="p">Après une longue attente sans Kujibiki, la série continue avec l'épisode 06 (Zéro n'abbandonne jamais !). Merci à Zetsubo Sensei qui prend le relais pour la traduction.<br /><br />
Ce Week-End, Mangazur à Toulon. Une petite convention très sympa ^^ J'y serais, n'hésitez pas à me contacter (zero.fansub@gmail.com). Et venez nombreux pour cet événement.
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t59.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=59" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
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

<h2>Maria+Holic 06</h2>
<h4>05/04/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/maria6.jpg" border="0">
</div>
<div class="p">Maria+Holic, la suite plutôt attendue ! L'épisode 06, en coproduction avec la Kanaii. Et notre DC et ses edits. Un épisode particulierement important pour la série : On y apprend une information ca-pi-tale ! À ne pas manquer !<br /><br />Sinon, HS, je suis un peu déçue de voir que le nombre de visite diminue de façon exponentielle depuis la fin de Toradora!... Anya >.< 
<br /><br />EDIT : Sorties des deux autres versions.<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t56.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=56" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

<h2>Hitohira 04 + KnJ Ni Gakki OAV Spécial Version LD HD</h2>
<h4>02/04/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/hito4.jpg" border="0">
</div>
<div class="p">On est decidé, on va avancer nos projets ! L'un de nos plus vieux, Hitohira, revient ce soir avec son 4ème épisode.<br />Et les versions LD et HD tant attendues de l'OAV sorti hier sont aussi arrivées. Profitez-en, c'est gratuit, aujourd'hui ! Et tous les autres jours aussi.
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t55.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=55" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
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

<h2>Maria+Holic 05 et Genshiken2 07</h2>
<h4>20/03/09 par db0</h4>
	<div style="float : right; display:block; margin-right: 20px;">
<img src="images/news/mariagen.jpg" border="0">
</div>
<div class="p">
	<div style="float : left; display:block; margin-right: 20px;">
<img src="images/news/mariagen2.jpg" border="0">
</div><div>
Un problème de ftp est survenu hier soir, ce qui nous a poussé à reporter la sortie de Maria+Holic 05 à aujourd'hui. (Nous nous excusons auprès de <a href="http://kanaii.com" target="_blank">Kanaii</a> en coproduction sur cet anime). Genshiken2 07 devait sortir ce soir. Maria 05 est toujours aussi drôle et dans l'épisode 07 de Genshiken, vous trouverez 2 nouveaux karaokés (à vos micros !). Profitez bien de cette double sortie !<br /><br /><a href="http://zerofansub.net/index.php?page=series/mariaholic">Maria Holic</a> <a href="http://zerofansub.net/index.php?page=series/genshiken">Genshiken2</a><br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t49-Maria-Holic-05-et-Genshiken2-07.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=49" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div></div>
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

<p>Maria Holic 03 16/02/09 par db0 Maria Holic 03, en copro avec <a href="http://kanaii.com/" target="_blank" class="postlink">Kanaii</a>. <a href="http://zerofansub.net/index.php?page=series/mariaholic" target="_blank" class="postlink">L'épisode en DDL, c'est par ici !</a><br><br> ~ <a href="http://commentaires.zerofansub.net/t39-Toradora-10.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=39" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Toradora! 11 11/02/09 par db0 	<br> <img src="http://japanslash.free.fr/images/news/toradora11.jpg" border="0" /> <br> La suite, la suite ! Toradora! épisode 11 sortie, en copro avec <a href="http://japanslash.free.fr/" target="_blank" class="postlink">Maboroshi no Fansub</a>.<br><br><br> <a href="http://zerofansub.net/index.php?page=series/toradora" target="_blank" class="postlink">L'épisode en DDL, c'est par ici !</a><br><br> ~ <a href="http://commentaires.zerofansub.net/t39-Toradora-10.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=39" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Toradora! 10 10/02/09 par db0 	<br> <img src="http://zerofansub.net/images/news/ami.png" border="0" /> <br> En direct de Nice, et pour ce 10 Février, l'épisode 10 de Toradora! en co-production avec <a href="http://japanslash.free.fr/" target="_blank" class="postlink">Maboroshi no Fansub</a>, qui est de retour, comme vous l'avez vu ! (Avec Kannagi 01, Mermaid 11-12-13 et Kimi Ga 4). Pour Toradora!, nous allons rattraper notre retard !<br><br><br> <a href="http://zerofansub.net/index.php?page=series/toradora" target="_blank" class="postlink">L'épisode en DDL, c'est par ici !</a><br><br> ~ <a href="http://commentaires.zerofansub.net/t39-Toradora-10.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=39" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Maria Holic 02 7/02/09 par db0 	<br> <img src="http://zerofansub.net/images/news/mariaholic2.jpg" border="0" /> <br> En direct de Lyon, je vous sors le deuxième épisode de Maria+Holic en co-production avec <a href="http://kanaii.com/" target="_blank" class="postlink">Kanaii</a>.<br>Les mésaventures de Kanako continuent, ne les manquez pas !<br> <a href="http://zerofansub.net/index.php?page=series/mariaholic" target="_blank" class="postlink">L'épisode en DDL, c'est par ici !</a><br><br> PS : Maboroshi est de retour !!<br><br> ~ <a href="http://commentaires.zerofansub.net/t38-Maria-Holic-02.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=38" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Kojikan 10 3/02/09 par db0 	 <img src="http://zerofansub.net/images/news/kodomo10.jpg" border="0" /><br> RIIINN est revenue ! Elle nous apporte son dixième épisode. Plus que 2 avant la fin, et la saison 2 par la suite. Une petite surprise arrive bientôt, sans doute pour le onzième épisode. En attendant, retrouvez vite notre petite délurée dans la suite de ses aventures et ses tentatives de séduction de Aoki-sensei...<br><br> ~ <a href="http://commentaires.zerofansub.net/t37-Kojikan-10.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=37" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Maria+Holic 01 28/01/09 par db0 <br> 	<img src="http://zerofansub.net/images/news/kanako.png" border="0" /> <br> Nouvelle série que l'on avait pas annoncé officiellement pour le moment : Maria+Holic. Mais ce n'est pas tout : Nouvelle co-production aussi, non pas avec MNF, mais cette fois-ci avec l'un de nos <a href="http://zerofansub.net/index.php?page=dakko" target="_blank" class="postlink">partenaires dakkô</a> a qui l'on offre du DDL et qui nous laisse poster sur leur site quelques news.... <a href="http://www.kanaii.com/" target="_blank" class="postlink">Kanaii !</a><br> Trèves de paroles inutiles : Voici donc l'épisode 01, disponible en DDL chez nous et torrent MU chez eux.<br> <a href="http://zerofansub.net/ddl/%5bKanaii-Zero%5d_Maria+Holic_01_%5bX264_1280x720%5d.mkv" target="_blank" class="postlink">DDL</a><br><br><br> ~ <a href="http://commentaires.zerofansub.net/t33-Maria-Holic-01.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=33" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>KnJ 03 LD V2, Petit point sur nos petites séries. 26/01/09 par db0 <br> 	<img src="http://zerofansub.net/images/news/akirin.jpg" border="0" /> <br> Petite v2 qu'on attendait depuis pas mal de temps : L'épisode 03 de Kodomo no Jikan LD qui avait quelques petits soucis d'encodage. <a href="http://zerofansub.net/ddl/%5BZero%5DKodomo_no_Jikan%5B03v2%5D%5BXVID-MP3%5D%5BLD%5D%5B499E9C85%5D.avi" target="_blank" class="postlink">DDL</a><br> <br>On en profite pour faire un petit point sur nos séries actuellement.<br> - <span style="font-weight: bold">Alignment you you</span> En cours de traduction, mais on prend notre temps.<br> - <span style="font-weight: bold">Genshiken 2</span> L'épisode 07 est en cours d'adapt-edit.<br> - <span style="font-weight: bold">Guardian Hearts</span> En pause pour le moment.<br> - <span style="font-weight: bold">Hitohira</span> En cours de traduction.<br> - <span style="font-weight: bold">Kimikiss pure rouge</span> En pause pour le moment.<br> - <span style="font-weight: bold">Kodomo no Jikan</span> L'épisode 10, 11, 12 sont prêt. La saison 2 arrive bientôt. Heuresement, avec la fin de la saison 1 qui s'approche...<br> - <span style="font-weight: bold">Kujibiki Unbalance</span> Je vais m'y mettre...<br> - <span style="font-weight: bold">Kurokami</span> En attente de Karamakeur.<br> - <span style="font-weight: bold">Maria Holic</span> Très bientôt <img src="http://img1.xooimage.com/files/w/i/wink-1627.gif" alt="Wink" border="0" class="xooit-smileimg" /><br> - <span style="font-weight: bold">Mermaid Melody</span> Notre annonce a fonctionnée, LeChat, notre traducteur IT-FR prend la suite en charge.<br> - <span style="font-weight: bold">Sketchbook full color's</span> Des V2 des épisodes 1 et 5 ainsi que l'épisode 6 sont en cours d'encodage par Ajira.<br> - <span style="font-weight: bold">Toradora!</span> Le 10 arrive !<br><br> ~ <a href="http://commentaires.zerofansub.net/t32-KnJ-03-LD-V2-Petit-point-sur-nos-petites-series.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=32" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Genshiken 06 13/01/09 par db0 <br> 	<img src="http://zerofansub.net/images/news/gen6.jpg" border="0" /> <br> Otaku, otaku, nous revoilà ! Genshiken épisode 06 enfin dans les bacs, en ddl.<br> <a href="http://zerofansub.net/index.php?page=series/genshiken" target="_blank" class="postlink">Pour télécharger les épisodes en DDL, cliquez ici !</a><br><br>  <span style="font-weight: bold">Les dernières sorties de la <a href="http://www.sky-fansub.com/" target="_blank" class="postlink">Sky-fansub</a> :</span><br> Kurozuka 08<br> Mahou Shoujo Lyrical Nanoha Strikers 21<br> <br> <span style="font-weight: bold">Les dernières sorties de la <a href="http://kyoutsu-subs.over-blog.com/" target="_blank" class="postlink">Kyoutsu</a> :</span><br> Hyakko 06<br> <br> <span style="font-weight: bold">Les dernières sorties de la <a href="http://www.kanaii.com/" target="_blank" class="postlink">Kanaii</a> :</span><br> Kamen no maid Guy 01v2<br> Rosario+Vampire Capu2 07v2<br> <br><br>    ~ <a href="http://commentaires.zerofansub.net/t31-Toradora-09.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=31" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Toradora! 09 4/12/08 par db0 <br> 	<img src="http://zerofansub.net/images/news/tora.jpg" border="0" /> <br> L'épisode 09 de Toradora! est terminé ! Nous avons pris du retard car la MNF (en co-production) est actuellement en pause temporaire (Tohru n'a plus internet).<br> <a href="http://zerofansub.net/index.php?page=series/toradora" target="_blank" class="postlink">Pour télécharger les épisodes en DDL, cliquez ici !</a><br><br>  <span style="font-weight: bold">Les dernières sorties de la <a href="http://www.sky-fansub.com/" target="_blank" class="postlink">Sky-fansub</a> :</span><br> Kurozuka 07<br> Mahou Shoujo Lyrical Nanoha Strikers 20<br> <br> <span style="font-weight: bold">Les dernières sorties de la <a href="http://kyoutsu-subs.over-blog.com/" target="_blank" class="postlink">Kyoutsu</a> :</span><br> Hyakko 05<br> <br> <span style="font-weight: bold">Les dernières sorties de la <a href="http://www.kanaii.com/" target="_blank" class="postlink">Kanaii</a> :</span><br> Kamen no maid Guy 06<br> Rosario+Vampire Capu2 06<br> <br><br>    ~ <a href="http://commentaires.zerofansub.net/t31-Toradora-09.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=31" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>>Joyeux Anniversaire ! Zéro a un an aujourd'hui. + Kujibiki Unbalance 0518/12/08 par db0<br><img src="http://zerofansub.net/images/news/unan.png" border="0" /><br>Zéro fête aujourd'hui son anniversaire ! Cela fait maintenant un an que le site Zéro existe. Crée le 18 décembre 2007, il était au départ un site de DDL. Ce n'est que le 6 janvier que le site deviens une team de fansub ^^ Pour voir les premières versions, allez sur la page &quot;À propos...&quot;. Merci à tous pour votre soutien, c'est grâce à vous que nous en sommes arrivés là !<br><br>Comme petit cadeau d'anniversaire, voici l'épisode 05 de Kujibiki Unbalance, en éspérant qu'il vous plaira.<br><br><span style="font-weight: bold">Les dernières sorties de la <a href="http://www.sky-fansub.com/" target="_blank" class="postlink">Sky-fansub</a> :</span><br>Kurozuka 06 HD<br>Mahou Shoujo Lyrical Nanoha Strikers 18</p>

<p>Kodomo no Jikan 09, Recrutement QC, trad it&gt;fr13/12/08 par db0<br><img src="http://zerofansub.net/images/news/kodomo9.jpg" border="0" /><br>Rin, Kuro et Mimi reviennent enfin vous montrer la suite de leurs aventures ! Sortie aujourd'hui de l'épisode 09, merci à DC qui nous l'a encodé. Les 3 versions habituelles sont dispos en DDL.<br><br>Nous recrutons toujours un QC ! Proposez-vous !<br>Nous avons décider de reprendre le projet Mermaid Melody Pichi Pichi Pitch, mais pour cela nous avons besoin d'un traducteur italien &gt; français. N'hésitez pas à postuler si vous êtes intéressés <img src="http://img1.xooimage.com/files/s/m/smile-1624.gif" alt="Smile" border="0" class="xooit-smileimg" /> Par avance, merci. <a href="http://zerofansub.net/index.php?page=recrutement" target="_blank" class="postlink">Lien</a><br><br><span style="font-weight: bold">Les dernières sorties de la <a href="http://www.kanaii.com/" target="_blank" class="postlink">Kanaii</a> :</span><br>Kanokon pack DVD 06 à 12<br>Rosario + Vampire S2 -05<br><span style="font-weight: bold">Les dernières sorties de la <a href="http://www.sky-fansub.com/" target="_blank" class="postlink">Sky-fansub</a> :</span><br>Kurozuka 05 HD<br>Mahou Shoujo Lyrical Nanoha Strikers 17<br><br>~ <a href="http://commentaires.zerofansub.net/t22-Kodomo-no-Jikan-09-Recrutement-QC-trad-it-fr.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=22" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Genshiken 05, Toradora! 08, Sketchbook 05 et Recrutement QC10/12/08 par db0<br><img src="http://zerofansub.net/images/recrut/qc.jpg" border="0" /><br>3 sorties en une, aujourd'hui ! Les épisodes 5 de Genshiken2, 8 de toradora! et 5 de Sketchbook sont disponibles dans la partie projets en DDL uniquement pour le moment. Les liens torrents, XDCC, Streaming viendront plus tard, ainsi que la version avi de genshiken et H264 de Toradora. Bon épisode !<br><br>Notre unique QC, praia, aimerait bien partager les QC de toutes nos séries avec un autre QC. Si vous êtes exellent en orthographe et que vous avez un oeil de lynx, nous vous solicitons ! Merci de vous présenter au poste de QC ^^ <a href="http://zerofansub.net/index.php?page=recrutement" target="_blank" class="postlink">Lien</a><br><br>~ <a href="http://commentaires.zerofansub.net/t21-Genshiken-05-Toradora-08-Sketchbook-05-et-Recrutement-QC.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=21" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Genshiken 0408/12/08 par db0<br>Voilà enfin la suite de notre saga otaku préférée, j'ai nommé... GENSHIKEN ! L'épisode 04 est dispo en ddl seulement pour le moment.<br><br>~ <a href="http://commentaires.zerofansub.net/t19-Genshiken-04.htm#p39" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=19" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Hitohira 0307/12/08 par db0<br><img src="http://zerofansub.net/images/news/mugi.png" border="0" /><br>Oh !<br>À cause d'un problème de raws, la série Hitohira est restée en pause pendant trèèès longtemps. Mais grâce à Lyf, le raw-hunter, et bien sûr à Jeanba, notre nouveau traducteur, mais aussi à B3rning14, nouvel encodeur, la série peut continuer. Et c'est donc l'épisode 03 que nous sortons aujourd'hui !<br><br>La Genesis ayant accepté que leurs releases en co-pro avec la Kanaii soient diffusées en DDL chez nous, vous pouvez maintenant retrouver la saison 2 de Rosario+Vampire ainsi que &quot;Kimi ga Aruji de Shitsuji ga Ore de - They are my Noble Masters&quot;. <a href="http://zerofansub.net/?page=kanaiiddl" target="_blank" class="postlink">Lien</a><br>Bon DL !<br><br>Les dernières sorties de la <a href="http://www.kanaii.com/" target="_blank" class="postlink">Kanaii</a> :<br>- Kanokon 11<br>- Kanokon 12<br><br><br>~ <a href="http://commentaires.zerofansub.net/t18-Hitohira-03.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=18" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Sketchbook ~full color's 04~ ; Kanaii DDL et Sky-fansub05/12/08 par db0<br><img src="http://zerofansub.net/images/news/moka.jpg" border="0" /><br>Bouonjòu !<br>L'épisode 04 de Sketchbook est sorti ! <a href="http://zerofansub.net/index.php?page=series/sketchbook" target="_blank" class="postlink">Lien</a> Les sorties se font attendre, étant donné qu'on a plus vraiment d'encodeur officiel ^^ Merci à Kyon qui nous a encodé c'lui-ci.<br>Beaucoup nous demandaient où il fallait télécharger nos releases. Probléme réglé, j'ai fait une page qui résume tout. <a href="http://zerofansub.net/index.php?page=dl" target="_blank" class="postlink">Lien</a><br>J'offre aussi du DDL à notre partenaire : la team Kanaii. Allez télécharger leurs animes, ils sont très bons ! <a href="http://zerofansub.net/index.php?page=kanaiiddl" target="_blank" class="postlink">Lien</a><br>Nous avons aussi un nouveau partenaire : La team Sky-fansub. <a href="http://www.sky-fansub.com/" target="_blank" class="postlink">Lien</a><br>//<a href="http://db0.fr/" target="_blank" class="postlink">db0</a><br>PS : &quot;Bouonjòu&quot; c'est du niçois <img src="http://img1.xooimage.com/files/s/m/smile-1624.gif" alt="Smile" border="0" class="xooit-smileimg" /><br><br>Les dernières sorties de la <a href="http://japanslash.free.fr/" target="_blank" class="postlink">Maboroshi</a> :<br>- Neo Angelique Abyss 2nd Age 07<br>- Akane Iro Ni Somaru Saka 07<br><br><br>~ <a href="http://commentaires.zerofansub.net/t17-Sketchbook-full-color-s-04-Kanaii-DDL-et-Sky-fansub.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=17" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p>Kujian 4, Recrutement Encodeur, Dons pour le sida1/12/08 par db0<br><img src="http://zerofansub.net/images/news/sida.png" border="0" /><br>Ciao !<br>Sortie de Kujibiki Unbalance, l'épisode 04 ! Je tiens à remercier DC, qui, par pitié peut-être ^^, nous a encodé cet épisode.<br><br>Oui ! Comme vous l'avez compris, nous recrutons de manière urgente un encodeur !<br>N'hésitez pas à vous proposer <img src="http://img1.xooimage.com/files/s/m/smile-1624.gif" alt="Smile" border="0" class="xooit-smileimg" /> &gt; <a href="http://zerofansub.net/index.php?page=recrutement" target="_blank" class="postlink">Lien</a>.<br><br>Aujourd'hui, 1er décembre, journée internationale du Sida. Nous vous rappelons que les dons et les clicks sur les pubs sont reversés à l'association medecin du monde. Nous avons besoin de vous !<br><a href="http://zerofansub.net/index.php?page=dons" target="_blank" class="postlink">En savoir plus sur le fonctionnement des dons sur le site</a><br><a href="http://zerofansub.net/#" target="_blank" class="postlink">En savoir plus sur l'action de l'association</a><br><br>Sinon, Man-Ban nous a fait une jolie fanfic que vous pouvez lire dans la partie Scantrad <img src="http://img1.xooimage.com/files/s/m/smile-1624.gif" alt="Smile" border="0" class="xooit-smileimg" /><br>Merci à tous et à bientôt !<br>//<a href="http://db0.fr/" target="_blank" class="postlink">db0</a><br><br>~ <a href="http://commentaires.zerofansub.net/t16-Kujian-4-Recrutement-Encodeur-Dons-pour-le-sida.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=16" target="_blank" class="postlink">Ajouter un commentaire</a> ~ </p>

<p><img src="http://zerofansub.net/images/news/toradora.png" border="0" /><br><span style="font-weight: bold">Toradora! 07</span><br>24/11/08 par db0<br><br><br>Ohayo mina !<br>La suite de Toradora est arrivée ! Et toujours en co-production avec la Maboroshi  <img src="http://img1.xooimage.com/files/s/m/smile-1624.gif" alt="Smile" border="0" class="xooit-smileimg" /> <br>Cet épisode se déroule à la piscine, et &quot;Y'a du pelotage dans l'air !&quot; Je n'en dirais pas plus.<br>L'épisode est sorti en DDL en format avi, en XDCC. Comme toujours, il sortira un peu plus tard en H264, torrent, streaming, ect.<br>//<a href="http://db0.fr/" target="_blank" class="postlink">db0</a><br><br>~ <a href="http://commentaires.zerofansub.net/t14-Toradora-06.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=14" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p><span style="font-weight: bold">Sketchbook ~full color's 03~</span><br>22/11/08 par db0<br><br>Bonjour, bonjour !<br>Sortie de l'épisode 03 de Sketchbook full color's !<br>Et c'est tout. Je sais pas quoi dire d'autre. Bonne journée, mes amis. <br>//<a href="http://db0.fr/" target="_blank" class="postlink">db0</a><br><br>~ <a href="http://commentaires.zerofansub.net/t13-Sketchbook-full-color-s-03.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=13" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p><img src="http://zerofansub.net/images/news/img_shinobu.gif" border="0" /><br><span style="font-weight: bold">Nouveau XDCC, Radio, Scantrad et Toradora! 06</span><br>20/11/08 par db0<br><br>Bonjour tout le monde !<br>J'ai aujourd'hui plusieurs bonnes nouvelles à vous annoncer :<br>La V3 avance bien, et je viens de mettre à jour les pages pour le scantrad, car comme vous le savez, nous commençons grâce à François et notre nouvelle recrue Merry-Aime notre premier projet scantrad : Kodomo no Jikan.<br>J'ai aussi installée la radio tant attendue et mis sur le site quelques OST.<br>Nous avons aussi, grâce à Ryocu, un nouveau XDCC. Vous aviez sans doute remarquer que nous ne pouvions pas mettre à jour le précédent. Celui-ci sera mis à jour à chaque nouvelle sortie.<br>Et enfin, notre dernière sortie : Toradora! 06. Toujours en co-production avec<a href="http://japanslash.free.fr/" target="_blank" class="postlink">Maboroshi</a>.<br>Enjoy  <img src="http://img1.xooimage.com/files/w/i/wink-1627.gif" alt="Wink" border="0" class="xooit-smileimg" /> <br>//<a href="http://db0.fr/" target="_blank" class="postlink">db0</a><br><br>~ <a href="http://commentaires.zerofansub.net/t7-Nouveau-XDCC-Radio-Scantrad-et-Toradora-06.htm" target="_blank" class="postlink">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&amp;t=7" target="_blank" class="postlink">Ajouter un commentaire</a> ~</p>

<p><span style="font-weight: bold">Quelques mises à jour</span><br><br>12/10/08 par db0<br><br><img src="http://zerofansub.net/images/sorties/lasthitohira2.png" border="0" /><br><br>Cela faisait pas mal de temps que Zéro n'avait rien sorti !<br>Je pense vous faire plaisir en vous annonçant quelques nouvelles :<br>- 4 épisodes sont prêts et attendent juste d'être encodés.<br>- 2 Nouvelles séries sont à paraître :<br>-- Sketchbook ~full color's~ <br>-- Toradora!<br>- Bientôt une v3 du site !<br><br>On profite de cette news pour mettre fin à certaines rumeurs :<br>- Non ! Nous ne faisons pas de Hentaï<br>- Non ! Nous n'avons pas tous 13 ans ! <br>- Nous n'avons rien contre la Genesis. Au contraire, si ça pouvait s'arranger, je préfererais. Nous ne comprenons toujours pas le pourquoi du comment de cette histoire, mais soyez sûr que nous ne répondrons jamais à leurs éventuelles provocations, insultes ou agressions.<br>Merci à tous et Bon download !</p>
-------------------------
<h2>[Zero] BlogBang</h2>
<h4>00/00/00 par db0</h4>
<div class="p"><script src="http://www.blogbang.com/demo/js/blogbang_ad.php?id=6ee3436cd7"
type="text/javascript"></script>
<br /><br />
<span>~ <a href="http://commentaires.zerofansub.net/t64.htm" target="_blank">Commentaires</a> - <a href="http://commentaires.zerofansub.net/posting.php?mode=reply&t=64" target="_blank">Ajouter un commentaire</a> ~</span><br /><br /></div>
<p></p>

