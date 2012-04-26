<?php
/*
	A dossier is description of something, made by someone (so potentially subjective).
*/
class Dossier extends PersistentComponent {
	private $id = null;
	private $title = null;
	private $author = null;
	private $timestamp = null;
	private $content = null;
	private $commentID = null;
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function setCommentID($id) {
		$this->commentID = $id;
	}
	
	public function getCommentID() {
		return $this->commentID;
	}
	
	public function setContent($content) {
		$this->content = $content;
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
	}
	
	public function getTimestamp() {
		return $this->timestamp;
	}
	
	public function setAuthor($author) {
		$this->author = $author;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	private static $allDossiers = null;
	public static function getAllDossiers() {
		if (Dossier::$allDossiers === null) {
			$dossier = new Dossier();
			$dossier->setID('genshiken9');
			$dossier->setTitle("Genshiken - Sortie du tome 9");
			$dossier->setTimestamp(strtotime('11 June 2009'));
			$dossier->setAuthor(TeamMember::getMemberByPseudo("Sunao"));
			$dossier->setCommentID(97);
			$dossier->setContent("[b]Bien le bonsoir la populace.[/b]


Afin de bien démarrer, il faut partir d'un postulat: j'en branle pas une.
Donc quand on s'est demandé s'il fallait diversifier les news du site, j'ai eu le malheur de proposer de faire quelque chose sur Genshiken. Malheureusement, je me suis mangé un « rédige-le » en plein dans les dents . Ouch.
Qu'à cela ne tienne, je relève le défi.

Let's rock, baby.


Comme vous vous en êtes sûrement déjà aperçu: il y a des jours qui comptent plus que d'autres: la sortie d'un nouveau Metal Gear, un concert de Dropkick Murphy's ou bien un diner aux chandelles avec Monica Belluci... Bref c'est évident et je le redis: il y a des jours qui comptent plus que d'autres.

Entre autres, il y a le 11 juin 2009.
Wesh wesh mon frère, c'est quoi le 11 juin 2009 ? 
Pour certains c'est la perspective d'un examen, pour d'autres c'est la Saint Barnabé (yosh béber), mais pour tout le monde c'est la sortie du neuvième et dernier tome de GENSHIKEN. ( [url]http://www.kurokawa.fr/humour/fiche/1127/genshiken-t9[/url] )

[url=http://www.kurokawa.fr/humour/fiche/1127/genshiken-t9][img]http://img40.xooimage.com/files/f/7/7/tome-9-ec2933.jpg[/img][/url]


Wesh wesh genshiken ta mère, mec !

Nombreux sont ceux parmi vous qui, frappés par la grâce (p'tre même la grasse, qui sait ?), ont débarqué chez la Zero Fansub pour profiter de cette excellente adaptation en anime. (Et pour ceux qui ont débarqué ici pour mater Kodomo, on vous en veut pas, bande de pervers).

Pour fêter (et pleurer) la dernière parution Genshikeniène, et pour ceux qui auraient manqué le début, un petit retour vers le futur qui se trouve être le passé s'impose. McFly va faire chauffer la Dolorean !

[url=http://forum.zerofansub.net/image/48/2/4/4/776__retourverslefutur-ec2937.jpeg.htm][img]http://img48.xooimage.com/files/7/6/8/776__retourverslefutur-ec2938.jpeg[/img][/url]


[b]Genshiken, kezako ?[/b]

Faux départ. Encore une précision. Même si Genshiken n'a rien du manga à suspense, il reste que ce qui suit contiendra surement un certain nombre de spoilers. (ou pas, j'en sais rien, j'y vais direct à l'arrache sans brouillon. He ouais j'suis un ouf moi).

Genshiken c'est avant tout un manga en 9 tomes signé Kio Shimoku. (Celui qui a pensé à ça [url]http://www.youtube.com/watch?v=iQXKZHejSWs[/url]  est éliminé pour cause d'atteinte au bon goût ^^).

Si j'en crois ma sagesse infinie, qui est branchée directement sur Wikipedia, la publication de Genshiken a commencé dans le magazine Afternoon, en juin 2002, et a continué son petit bonhomme de chemin jusqu'en juin 2006.

La publication française est assurée avec un certain brio par Kurokawa ( [url]http://www.kurokawa.fr/[/url] ), qui nous gratifie d'explications de textes, et autres interview en fin de tome. On les remercie au passage pour cette licence, ainsi que pour leur très bon travail.


[url=http://forum.zerofansub.net/image/42/2/1/0/image-scan-tome-4...maso-rame-ec2947.jpg.htm][img]http://img42.xooimage.com/files/8/2/8/image-scan-tome-4...maso-rame-ec2948.jpg[/img][/url]


Une adaptation en anime a ensuite vue le jour. Dirigée par trois réalisateurs différent (un par saison), l'anime se compose deux 2 saisons de 12 épisodes, entrecoupée de 3 OAV. La série fut diffusée entre octobre 2004 et décember 2007.
La licence de la première saison a été acquise par Kaze ( [url]http://www.kaze.fr/[/url]  ) qui se paie le luxe de nous offrir une très bonne traduction, ainsi qu'une VF tout à fait honnête (c'est rare pourtant).


Mais concrètement, Genshiken c'est quoi ?

Dans les salons bleus de la classe supérieure (Noir Désir inside, si vous aviez trouvé vous gagnez une séance de strip-tease avec db0. Pour les détails, s'arranger directement avec elle, et si elle pose la question, vous ne m'avez jamais vu), rien de mieux que de sortir « Gendai Shikaku Bunka Kenkyukai » histoire de se la péter un peu. Alias « Club d'étude de la culture visuelle moderne ».(Notons au passage qu'il peut s'avérer relativement difficile de le placer entre deux tasses de thé).

Tout au long des ces 9 tomes, Genshiken nous propose de suivre la vie, ô combien déjantée, des divers membres de ce Club d'étude de la culture visuelle moderne. Ce club à pour but d'analyser les produits de la sub-culture japonaise: le manga, les animes, le jeu vidéo, le hentai, etc... (surtout le hentai... faut bien des priorités dans la vie).

Certes, analyse il y aura parfois.


[url=http://forum.zerofansub.net/image/20/5/b/c/image-tome-1-p99-ec2954.jpg.htm][img]http://img20.xooimage.com/files/7/6/4/image-tome-1-p99-ec2955.jpg[/img][/url]


Mais otakus gros branleurs et passablement obsédés, il y aura beaucoup plus souvent. (J'abandonne le Yoda parlé, ça me gonfle). Ces derniers n'auront pour but dans la vie que de commenter leur série phare: Kujibiki Unbalance, ainsi que de s'assurer de pouvoir obtenir les meilleurs doujins lors de leur festival préféré: le ComiFest.


[url=http://forum.zerofansub.net/image/40/9/9/f/image-pouvoir-se-ec295f.jpg.htm][img]http://img40.xooimage.com/files/b/8/a/image-pouvoir-se-ec2960.jpg[/img][/url]


Pour finir cette rapide présentation, on retiendra que le manga est divisé « officieusement » en deux partie: du tome 1 à 4; puis du tome 5 à 9. Cette division repose principalement sur l'arrivée de nouveaux personnages.

Enfin signalons que Genshiken a la particularité d'afficher une image complètement ridicule en 4ème de couverture, ce qui a pour effet d'amener mon vendeur à me jeter des coups d'oeil bizarres quand je vais acheter les tomes. J'ai un peu l'impression d'acheter du porno à chaque fois; genre: 
«- Vous voulez un sac, monsieur ?
- Oh ouiouioui ! »

Je vous l'accorde c'est un peu pitoyable.


[b]Genshiken, c'est qui ?[/b]

Hum fait chaud non ? Je vais ouvrir ma fenêtre... merde vous êtes toujours là ?! Bon je continue alors. Où en étais-je ?

Présentation des personnages, même s'il faut garder en tête que Genshiken n'a pas vraiment de personnages principal.
On va donc les envisager par ordre d'apparition.

[u]- Sasahara Kanji.[/u]

Sasahara est le personnage introductif de Genshiken: l'histoire débute avec son arrivée en fac. Il symbolise l'otaku borderline. Celui qui est déjà irrécupérable, mais à qui a encore trop honte pour l'assumer. Une telle fierté ne survivra pas plus loin que le premier tome après un régime sec au Genshiken. Accessoirement, Sasahara est un vrai mollusque qui s'efforce d'être gentil avec tout le monde.
Sasahara rejoint le Genshiken dans le tome 1 lors de son entrée à l'université. (Bien qu'il soit plutôt « piégé » ).


[url=http://forum.zerofansub.net/image/42/0/3/1/image-scan-sasahara-ec296c.jpg.htm][img]http://img42.xooimage.com/files/d/2/6/image-scan-sasahara-ec296d.jpg[/img][/url]


[u]- Kosaka Makoto.[/u]

Kosaka est le personnage le plus extrême de Genshiken en ce sens où il se situe aux deux extrémité de l'otakuïsme. D'un côté il n'est intéressé par rien d'autre que les mangas, animes et jeux vidéo (et n'écoute que des OST). Mais d'un autre côté, c'est le beau gosse androgyne du club, toujours bien habillé et qui tombe toutes les filles. (Il finira par « récupérer » Kasukabe). Kosaka est capable de vous alligner un 32 hits combo dans la gueule sur un jeu de baston, tout comme il est capable d'allier levrette et matage d'anime en même temps. Bref il est irrécupérable.
Il rejoint le Genshiken en même temps que Sasahara.


[url=http://forum.zerofansub.net/image/48/1/f/5/image-scan-kosaka-ec297d.jpg.htm][img]http://img48.xooimage.com/files/0/7/7/image-scan-kosaka-ec297e.jpg[/img][/url]


[u]- Kasukabe Saki.[/u]

Même si on vient d'admettre que Genshiken n'a pas tellement de personnage principal, à mes yeux Saki Kasukabe est le personnage central de la première partie du manga. Elle n'a strictement rien avoir avec le Genshiken. Elle représente le commun des mortels anti-otakus. Très intelligente mais quelque peu gamine et superficielle, elle reste coller aux basques de Kosaka et claque des sommes monstreuses en fringues. Elle ne manque jamais une occasion de faire remarquer aux membres du Genshiken à quel point ils sont perves. (Même si elle est quelque peu limitée sur ce coup, Kosaka étant surement le plus pervers de tous).


[url=http://forum.zerofansub.net/image/20/6/3/8/image-scan-kasukabe-ec29a1.jpg.htm][img]http://img20.xooimage.com/files/d/a/c/image-scan-kasukabe-ec29a2.jpg[/img][/url]


[u]- Madarame Harunobu.[/u]

Haaa Madarame... un modèle dans la vie. Madarame pense tout ce qu'on a un jour pensé, et dit tout ce qu'on a jamais osé dire. Il n'a pratiquement aucun amour propre et connaît une passion sous limite pour les doujins hentai lolicon. Véritable schizophrène, Madarame est le seule personne au  monde capable de s'enfuir d'un magasin de fringues en se disant qu'il va faire du level-up jusqu'à ce que ses skills soient suffisamment élevées pour réussir ses achats. Sans que cela n'ai été encore explicitement avoué, on sent bien que Madarame, malgré ses grands airs, a toutefois un faible pour Kasukabe.
Bien qu'il ne soit pas le président du Genshiken, il se conduit toujours comme tel. (Et il le deviendra très vite).


[url=http://forum.zerofansub.net/image/40/e/0/f/image-scan-madarame-ec29b0.jpg.htm][img]http://img40.xooimage.com/files/9/9/b/image-scan-madarame-ec29b1.jpg[/img][/url]


[u]- Kugayama Mitsunori[/u].

C'est le dessinateur initial du groupe. Introverti du fait de son bégaiement, c'est en quelque sorte l'âme damnée de Madarame.

[u]- Tanaka Soïchiro.[/u]

Docteur es cosplay et montage de figurines mecchas, Tanaka reste cependant le cas le moins désespéré du groupe. Certes il est obsédé par le cosplay, mais sait garder les pieds sur terre.


[url=http://forum.zerofansub.net/image/22/9/2/a/image-scan-kugi-et-tanaka-ec29c4.jpg.htm][img]http://img22.xooimage.com/files/5/7/d/image-scan-kugi-et-tanaka-ec29c5.jpg[/img][/url]


[u]- Ohno Kanako.[/u]

Arrivée au sein (c'est peu de le dire vu son tour de poitrine) du Genshiken en fin du tome 1, Ohno représente l'écho féminin de Tanaka avec qui elle finira fatalement. Complètement obsédée par le cosplay, le yaoï et avec des tendances gérontophiles (et ouais m'sieur, on a du vocabulaire chez Zero Fansub, nom d'un Bernard Pivot), Ohno rentre juste des USA où elle a gardé quelques contacts... délurés.


[url=http://forum.zerofansub.net/image/48/b/0/d/image-scan-ohno-ec29d6.jpg.htm][img]http://img48.xooimage.com/files/f/a/5/image-scan-ohno-ec29d7.jpg[/img][/url]


[u]- Le soeur de Sasahara.[/u]

En fait je connais pas son nom de mémoire et j'ai la flemme de chercher (sérieux c'est quoi ce dossier en mousse ?!). Ah si j'me souviens c'est Keiko Sasahara. (En fait je m'en suis absolument pas souvenu, je suis juste tombé dessus en cherchant une page à scanner). Contrairement à son frère, elle n'a rien d'une otaku (malgré un léger penchant yaoïste). Complètement immature et caractérielle, c'est surtout la rivale de Kasukabé à qui elle essaie désespérément de piquer Kosaka.


[url=http://forum.zerofansub.net/image/20/b/c/1/image-scan-soeur-ec29dc.jpg.htm][img]http://img20.xooimage.com/files/4/0/1/image-scan-soeur-ec29dd.jpg[/img][/url]


[u]- Kuchiki.[/u]

On ne connaît pas son prénom, quoiqu'il en soit après une première tentative d'intégration du Genshiken magistralement écartée par Kasukabe, Kuci pour les intimes parvient enfin à rentrer dans le club.
Kuchiki... c'est Kuchiki. En fait c'est un véritablement taré, pervers, dépourvu d'amour propre et de tout ce qui peut se rattacher au sens commun. Généralement à chaque fois qu'il ouvre la bouche, c'est pour dire une connerie encore plus énorme que la précédente. 


[url=http://forum.zerofansub.net/image/20/2/f/0/image-scan-kuchi-ec29f1.jpg.htm][img]http://img20.xooimage.com/files/c/a/a/image-scan-kuchi-ec29f2.jpg[/img][/url]


[u]- Ogiue Chica.[/u]

Dernière arrivante en date au Genshiken, son entrée au club marque le début de la deuxièmement partie du manga. Ogiue fait un sérieux déni d'otakuïsme même si elle reste secrètement fan de yaoï. C'est la 2nd dessinatrice qui aidera le club à publier son propre doujin hentai lors du ComiFest.


[url=http://forum.zerofansub.net/image/40/1/d/8/image-scan-origue-ec29f9.jpg.htm][img]http://img40.xooimage.com/files/6/6/4/image-scan-origue-ec29fa.jpg[/img][/url]


Ogiue entretien des rapports houleux avec Ohno, avec qui elle a parfois des débats d'une profondeur infinie.


[url=http://forum.zerofansub.net/image/44/d/f/3/image-scan-biiip-ec2a00.jpg.htm][img]http://img44.xooimage.com/files/c/d/b/image-scan-biiip-ec2a01.jpg[/img][/url]




[b]Genshiken, c'est comment ?[/b]

Genshiken c'est bien.
Véritable fenêtre sur un monde complexe et complexé, Genshiken offre un intérêt quasi-sociologique à l'étude de l'otaku dans son milieu naturel. Si la première partie du manga, centrée sur le personnage de Kasukabe, tente de présenter le monde des otakus; la seconde partie qui tourne plutôt autour de Origue, parle plutôt de l'acceptation de ces passions qui forment le quotidien de l'otaku.

Mais fi de toutes ces considérations scientifico-lourdingues. Genshiken, c'est avant tout très drôle.

Il y a des scènes cultes:

[url=http://forum.zerofansub.net/image/26/b/0/2/image-tome-7-sign-plz-ec2a0f.jpg.htm][img]http://img26.xooimage.com/files/9/d/e/image-tome-7-sign-plz-ec2a10.jpg[/img][/url]

Des grandes questions philosophiques:

[url=http://forum.zerofansub.net/image/40/6/4/f/image-tome-8-pff-ec2a64.jpg.htm][img]http://img40.xooimage.com/files/6/b/f/image-tome-8-pff-ec2a65.jpg[/img][/url]


Des dialogues remplis de poésie:

[url=http://forum.zerofansub.net/image/20/c/3/8/image-tome-8-grosse-ec2a2e.jpg.htm][img]http://img20.xooimage.com/files/3/7/7/image-tome-8-grosse-ec2a30.jpg[/img][/url]


De répliques qui tuent:

[url=http://forum.zerofansub.net/image/26/c/4/5/image-tome-7-besoin-ec2a35.jpg.htm][img]http://img26.xooimage.com/files/c/c/c/image-tome-7-besoin-ec2a36.jpg[/img][/url]


Des grands moments de solitude:

[url=http://forum.zerofansub.net/image/46/c/6/1/image-tome-3-accros-x2-ec2a42.jpg.htm][img]http://img46.xooimage.com/files/e/0/3/image-tome-3-accros-x2-ec2a43.jpg[/img][/url]

[url=http://forum.zerofansub.net/image/28/d/c/a/image-tome-3-accros-x2-suite-ec2a4a.jpg.htm][img]http://img28.xooimage.com/files/9/9/e/image-tome-3-accros-x2-suite-ec2a4b.jpg[/img][/url]


Et même des travelos:

[url=http://forum.zerofansub.net/image/46/e/2/6/image-tome-5-epilogue-ec2a51.jpg.htm][img]http://img46.xooimage.com/files/3/3/3/image-tome-5-epilogue-ec2a52.jpg[/img][/url]


Mais Genshiken, c'est aussi le [i]Lord Of War[/i] du manga (film de Andrew Niccol avec Nicolas Cage, excellent film, go watching y a pas que le manga dans la vie) , à savoir qu'il ne faut jamais partir en guerre, et surtout pas contre soit-même.



[b]Genshiken, c'est où ?[/b]


Bref, si l'anime est d'excellente qualité, je le trouve cependant relativement soft par rapport au potentiel du manga papier (le cousin du manga carton, dixit dbo).
C'est pourquoi je vous encourage grandement à vous procurer les tomes du manga si vous ne connaissez pour l'heure que l'anime.
Et afin que Kurokawa ne me colle pas un procès aux fesses pour avoir scanné leurs bouquins comme un porc, je me permets de leur faire de la pub gratuite (et parce que ça fait jolie en fin de dossier).


[u]Tome 1: L'arrivée des différents personnages au Genshiken.[/u]

[url=http://www.kurokawa.fr/humour/fiche/144/genshiken-t1][img]http://img42.xooimage.com/files/2/c/9/tome-1-ec2a7f.jpg[/img][/url]


[u]Tome 2: Etude de l'otaku dans son milieu naturel[/u].

[url=http://www.kurokawa.fr/humour/fiche/145/genshiken-t2][img]http://img26.xooimage.com/files/3/5/a/tome-2-ec2a90.jpg[/img][/url]


[u]Tome 3 : Première approche des jeux de cul.[/u]

[url=http://www.kurokawa.fr/humour/fiche/141/genshiken-t3][img]http://img22.xooimage.com/files/a/b/4/tome-3-ec2b0c.jpg[/img][/url]


[u]Tome 4: Arrivée d'Ogiue.[/u]

[url=http://www.kurokawa.fr/humour/fiche/142/genshiken-t4][img]http://img42.xooimage.com/files/3/7/0/tome-4-ec2ab4.jpg[/img][/url]


[u]Tome 5: Mon but dans la vie: exposer du hentai au ComiFest.[/u]

[url=http://www.kurokawa.fr/humour/fiche/143/genshiken-t5][img]http://img20.xooimage.com/files/0/c/c/tome-5-ec2abf.jpg[/img][/url]


[u]Tome 6: Nouveau tournant.[/u]

[url=http://www.kurokawa.fr/humour/fiche/259/genshiken-t6][img]http://img46.xooimage.com/files/9/6/6/tome-6-ec2ac7.jpg[/img][/url]


[u]Tome 7: Mon nouveau but dans la vie: exposer du yaoï au ComiFest.[/u]

[url=http://www.kurokawa.fr/humour/fiche/260/genshiken-t7][img]http://img26.xooimage.com/files/8/2/2/tome-7-ec2ad0.jpg[/img][/url]


[u]Tome 8: Peut-être encore un espoir.[/u]

[url=http://www.kurokawa.fr/humour/fiche/972/genshiken-t8][img]http://img26.xooimage.com/files/4/c/6/tome-3-ec2aa1.jpg[/img][/url]


Et bah voilà c'est fini.
Je vous dis à plus tard sur le prochain épisode de Genshiken, et je laisse à Mr. Kio Shimoku le mot final:

[url=http://forum.zerofansub.net/image/20/8/9/d/image-tome-3-ordi-ec2b12.jpg.htm][img]http://img20.xooimage.com/files/1/4/3/image-tome-3-ordi-ec2b13.jpg[/img][/url]");
			Dossier::$allDossiers[] = $dossier;
			
			$dossier = new Dossier();
			$dossier->setID('epitanime2009');
			$dossier->setTitle("[IRL] Epitanime 2009");
			$dossier->setTimestamp(strtotime('06 June 2009'));
			$dossier->setAuthor(TeamMember::getMemberByPseudo("db0"));
			$dossier->setCommentID(79);
			$dossier->setContent("C'était du 29 au 31 mai, et c'était un très grand evenement. Bien malheureux sont ceux qui l'ont ratés ! Et qui, surtout, on raté db-chan ! Oui, il faut le dire, le plus important à Epitanime, c'était elle :P Il fallait être là, car j'avais prévu pour tout les membres de la team Zéro mais aussi toutes les personnes qui viennent régulierement chez Zéro une petite surprise.
Ce week-end, j'ai donc croisé Sazaju (notre traducteur), Ryocu, Guguganmo et des tas de copains-cosplayeurs dont je ne vous citerait pas le nom puisque vous ne les connaîtrez sûrement pas.

J'ai participé au concours cosplay le samedi 30 mai à 12 heure. À vous de deviner quel personnage j'incarnait :
[img]images/news/cosplay01.jpg[/img]
Vous ne trouvez pas ? Oui, je sais, c'est très difficile. Pour voir qui c'était, descendez dans la page.



























[img]images/news/cosplay02.jpg[/img]

Mais oui vous aviez trouver, c'est évident : Kokonoe Rin de Kodomo no Jikan. Un costume que j'ai mis une semaine à réaliser, puisque normalement, je devais défiler avec le groupe DBZ. Comme c'était annulé, j'ai fait tout mon possible pour participer quand même au concours, et je trouve que le résultat n'est pas trop mal (fignolé avec des bouts de scotch :P) Comme pour tout mes costumes, il me va 10 fois trop grand, pusique je suis un peu nulle en couture et que j'ai toujours peur de faire trop petit >.< Du coup, Rin est un peu grosse, mais jolie quand même... J'espère :)

Sans plus tarder, la vidéo de ma préstation scénique (inventée 2 jours avant) :

[video=width:640|height:467]http://www.megavideo.com/v/6DBR1ZG06702ad1136cac0b16008388deea3e3cf[/video]

Maintenant que ce costume est prêt, on peut tourner une saison 2 de Konoe no Jikan ! (Parodie pornographique de Kodomo no Jikan disponible partie hentaï du site). Qui est partant ? Il faut un caméraman et un sensei ^^ Je plaisante, je plaisante, je ne suis même pas majeure.......... Eh ben si ! Depuis justement ce jour de grâce 30 mai 2009 je suis officiellement reconnue majeure par l'Etat français. La classe, hein ? J'ai enfin le droit d'aller sur mes propres sites :p Si c'est pas beau, ça. Et pour courronner le tout, grâce à Noëlle, une copine-cosplayeuse, j'ai eu droit à une jolie chanson, puisqu'elle a crié depuis le public au moment où je descendais de la scène : \"C'est son anniversaire !\" Et voilà ce que ça a donné :

[video=width:640|height:468]http://www.megavideo.com/v/42b58ac4a8a9dbff5f114c18f91931ff[/video]

Merci aussi à Noëlle puisque c'est elle qui a filmé les deux vidéos. Si vous avez regardé ces deux extraits vidéos, vous conaissez maintenant mon prénom. (Yahou....) Bon, pour finir sur ce costume, c'est la première fois que j'ai eu aussi peu de succés.... Kodomo no Jikan, c'est vraiment pas connu. D'autres photos sont disponible dans cette galerie : [url=http://www.cosplay.com/member/125690/]Lien[/url]

Le lendemain, j'ai porté le costume de Chichi enfant de Dragon Ball avec le groupe Dragon Ball, mais nous ne sommes pas passés sur scène.

[img]images/news/cosplay03.jpg[/img]

Cette convention était vraiment bien, désolée de n'avoir parlé que de moi dans cet article ! Si vous voulez un bilan général de la convention, il y en a plein (merci Google). Il y a eu d'excellent cosplay bien mieux que le mien : Mon copain-cosplayeur Madaj (de qui je suis la deuxième femme officieusement) nous a fait un magnifique EVA, ainsi qu'un exellent Gundam :

[img]images/news/cosplay04.jpg[/img]

Le genre de cosplay qui vous coupe l'envie d'en faire o_O ou qui vous pousse à en faire, ça depend des points de vue.

De cette convention j'ai rammené quand même des petits souvenirs, 4 figurines de Genshiken dont une qui m'a grâcieusement était offerte par le vendeur :

[img]images/news/cosplay05.jpg[/img]

C'était Epitanime ! J'espére que ça vous a plu ! À bientôt pour Japan Expo, et une autre surprise spécial Zéro-Kanaii.");
			Dossier::$allDossiers[] = $dossier;
		}
		
		return Dossier::$allDossiers;
	}
	
	public static function getDossier($id) {
		foreach(Dossier::getAllDossiers() as $dossier) {
			if ($dossier->getID() === $id) {
				return $dossier;
			}
		}
		throw new Exception($id." is not a known dossier ID.");
	}
}

class DossierTeamMemberPersistentFieldTranslator implements IPersistentFieldTranslator {
	public function getPersistentValue($value) {
		if ($value === null) {
			return null;
		} else {
			return $value->getID();
		}
	}
	
	public function setPersistentValue(PersistentField $field, $value) {
		if ($value === null) {
			$field->set(null);
		} else {
			$field->set(TeamMember::getMember(intval($value)));
		}
	}
	
	public function getPersistentTable(PersistentField $field) {
		return PersistentTable::defaultIntegerTable();
	}
}
?>