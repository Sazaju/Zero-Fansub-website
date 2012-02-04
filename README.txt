I. DEFINITIONS

Tout d'abord mettons-nous d'accord sur les termes employés, il n'en sera que plus simple de se comprendre :

Les sorties :
	Scantrad = chapitre ou volume traduit
	Fansub   = épisode ou série traduit(e)
	Release  = élément traduit (fansub ou scantrad)
	Preview  = images tirées d'une release pour être affichées dans sa description

Le code :
	HTML = description de la structure du site (menus, listes, titres, ...) et de son contenu
	CSS  = description du rendu du site (couleurs, polices, tailles, ...)
	PHP  = logique du site (objets, fonctions, ...)
	DB   = base de données (contenu du site)

Le site:
	local   = site installé sur le PC du développeur
	test    = site disponible sur un serveur de test
	serveur = site du serveur officiel (site "de production")

II.ARCHITECTURE DU SITE

II.1 Architecture globale

+ class.............. Classes PHP
|	+ database....... Classes relatives à la DB
|	+ util........... Classes utilitaires
|
+ ddl................ Releases de la team (disponible uniquement sur le serveur)
|
+ images............. Images utilisées pour le site
|	+ autre.......... 
|	+ calques........ Images transparentes utilisables pour faire du traitement d'image
|	+ cover.......... 
|	+ episodes....... Preview des épisodes
|	+ forum.......... 
|	+ hautmenu....... Images aleatoires utilisées dans le coin en haut à gauche du site
|	+ icones......... 
|	+ interface...... 
|	+ kanaii......... 
|	+ news........... Images utilisées dans les news
|	+ part........... 
|	+ partenaires.... 
|	+ pub............ 
|	+ recrut......... 
|	+ scan........... 
|	+ series......... Images utilisées pour décrire les projets (liste + descriptions)
|	+ sorties........ Images apparaissant en haut du site, montrant les dernières sorties
|	+ team........... Avatars des membres de l'équipe (page équipe)
|	+ titres......... 
|	+ xdcc........... 
|
+ interface.......... Pages PHP décrivant les différentes parties de l'interface (entête et pied de page, menus, contenu de page)
|
+ pages.............. Pages HTML (vouées à disparaître)
|
+ styles............. Styles CSS disponibles
	+ default........ Style par défaut
		+ images..... Images utilisées par le style

II.1 Classes PHP

La hiérarchie des classes PHP n'est pas encore complètement fixée, cela dit elle vise à s'approcher d'un schéma MVC (Modèle-Vue-Controleur). Ce schéma s'organise comme suit :
- le modèle définit les données disponibles, qui est grosso modo le contenu de la DB, ce niveau est géré par les classes implémentant IDatabaseComponent (ligne d'une table) ou IDatabaseContainer (ensemble de lignes)
- la vue correspond au rendu final de ces données (affichage sur le site), ce niveau est géré par les classes implémentant l'interface IHtmlComponent (génère la structure HTML)
- le controleur est la logique du site, c'est lui qui gère la lecture et l'écriture des données au niveau modèle, selon les besoins du niveau vue, ce niveau est géré par des classes qui n'implémentent pas d'interface commune (chaque objet définit sa propre logique)

Pour faire simple, le modèle définit les informations disponibles, le controleur utilise et traite ces informations, puis la vue les formate pour l'affichage final sur le site. Le schéma suivant résume la situation par rapport aux différentes classes PHP :

   VUE     |       IHtmlComponent
    |      |             |
CONTROLEUR |    classes spécialisées
    |      |             |
  MODÈLE   |  IDatabaseComponent/Container

À noter que les interfaces ont leur noms préfixés par I (comme interface), par exemple IHtmlComponent pour un composant HTML, IDatabaseComponent pour un composant de la DB, etc. Cependant ces interfaces ne sont jamais implémentées directement, en effet plusieurs méthodes ont une logique commune quelque soit la classe héritant une de ces interfaces, et méritent donc d'être implémentées à un niveau supérieur. Par exemple les composants HTML peuvent tous avoir une des propriétés telles que id, class, style, etc. Aussi le processus de génération du code HTML est toujours le même (une balise englobant le contenu). Ce genre de méthodes communes est implémenté par des classes ayant le même nom que l'interface qu'il implémente, sauf que le préfixe est Default, par exemple DefaultHtmlComponent pour l'interface IHtmlComponent. Pour implémenter un nouveau composant HTML, mieux vaut étendre ces classes par défaut plutôt que de réimplémenter toute l'interface, on peut toujours surcharger certaines méthodes si besoin (mais cela peut traduire une erreur de conception). Normalement, tous les composants HTML de base sont implémentés de cette manière :
- Image pour la balise img
- Link pour la balise a
- SimpleBlockComponent pour la balise div
- SimpleListComponent pour les balises ol/ul
- SimpleParagraphComponent pour la balise p
- SimpleTextComponent pour la balise span
- Table, TableRow et TableCell pour les balises table, tr et td
- Title pour les balises h1, h2, etc.

Il est alors possible d'étendre ces classes pour avoir des gestions spécialisées. On a par exemple :
- Anchor pour les ancres (<a name="#..."></a>)
- CornerImage pour les images en haut à gauche du site, qui sont en même temps un lien vers le projet représenté par l'image
- MailLink pour des liens "mailto"
- ProjectLink pour des liens vers des projets complets
- ReleaseLink pour des liens vers des releases spécifiques
- ReleaseComponent pour l'affichage d'une release
- Pin pour aider au positionnement de certains composants
- ...

Certaines classes ne font pas partie de ce modèle MVC, tout simplement parce qu'elles peuvent être utilisées un peu partout. Ce sont les classes utilitaires du dossier "class/util". Elles offrent par exemple des fonctionnalités pouvant :
- appliquer des formatages spéciaux,
- vérifier des données,
- déboguer,
- ...

II.2 Pages

Le dossier "pages" contient un peu tout et n'importe quoi. Cela dit il est important d'avoir en tête certains points :
- home.php correspond à la page d'accueil, affichant les news
- team.php correspond à la page "L'équipe"
- about.php correspond à la apge "À propos"
- contact.php correspond à la page "Contact"
- xdcc.php correspond à la page "XDCC"
- series.php correspond à la liste des projets
- hhentai.php correspond à la liste des projets + news hentai, à terme il devrait être redistribué sur la page des news et la liste des projets normaux (avec un filtre pour les hentai)
- havert.php correspond à l'avertissement pour l'accès à la page hentai

Des tas d'autres fichiers sont présents, principalement des pages obsolètes. Une fois le site complètement raffiné, un nettoyage complet de ce dossier devrait être opéré.

II.3 Images

Ce dossier est un peu fourre-tout, mais il est important de retenir ceci :
- autre contient quelques images qu'il faudra penser à ranger ailleurs (comme des bonus liés à des releases)
- calques contient les PNG HD transparent à utiliser pour faire les bannières et autres compositions d'images
- episodes contient les previews des releases
- hautmenu contient les images affichées en haut à gauche du site, elles font toutes 150x250 pixels
- icones contient des icones telles que ceux utilisés dans les descriptions des releases (torrent, lien MU, lien free, ...)
- interface contient les images utilisées pour l'interface, cependant il est voué à disparaître vu que les images de l'interface doivent être transférées dans le dossier du style associé (c'est déjà le cas pour certaines images du style par défaut)
- news contient les images utilisées dans les news
- partenaires contient les bannières des partenaires (et les notres)
- series contient les bannières des projets + les images utilisées dans la description de chaque projet (pas les previews des releases)
- sorties contient lesimages de l'entête du site (les derniers épisodes sortis)
- team contient les avatars des membres de la team (utilisées notamment dans la page décrivant l'équipe)

II.4 Styles

Pour l'instant un seul style est disponible, celui par défaut (default). Ce style est le modèle à considérer pour tout nouveau style. En particulier, tout style devrait se composer de cette façon :

+ images........ Ensemble des images utilisées par le style
+ style.css..... Style tout public
+ styleH.css.... Style Hentai

II.5 Conventions de programmation

Le code PHP est écrit en anglais. C'est un langage plus adapté à la programmation (ou plutôt le langage de programmation est adapté à cette langue) et donc mieux vaut rester homogène. Un des avantages est que l'anglais offre pas mal de petits mots très récurrents (set au lieu de assigner, get au lieu de récupérer, ...) ce qui réduit les noms de manière assez importante. De plus, le français utilisant des accents incompatibles avec PHP, mieux vaut éviter.

Certains commentaires sont aussi en anglais mais ce n'est pas obligatoire (plutôt une habitude pour certains), aussi ce n'est pas grave si d'autres commentaires sont en français (les autres langues sont cependant à proscrire). Il convient de noter qu'un commentaire n'est pas là pour dire ce que fait le code, le code en lui-même doit être suffisamment parlant. Par exemple :

// on cherche la release X dans la liste des releases
$r = null;
foreach($releases as $release) {
	if ($release->getId() == $id) {
		$r = $release;
		break;
	}
}

Le commentaire est ici inutile, car le code est assez explicite pour voir qu'on parcoure (boucle foreach) des releases (tableau $releases) et que lorsqu'un ID spécifique est atteint ($release->getId() == $id) on garde en mémoire la release correspondante ($r = $release) et on arrête la recherche (break). Si on estime que le code est trop compliqué pour qu'en le lisant on comprenne ce qu'il fait, alors mieux vaut revoir le code pour le simplifier (le réécrire ou factoriser certaines parties dans des fonctions aux noms explicites) de façon à avoir un code clair. Les commentaires ne sont utiles que pour :
- les entêtes (décrire le rôle et l'utilisation d'une classe ou de longues fonctions)
- les subtilités (par exemple on sait dans quel ordre est trié un tableau, donc on le parcours dans un ordre particulier plutôt que de manière habituelle)
- les notifications telles que des TODO (future tâche), FIXME (bogue à corriger), etc.

II.6 Divers

Le dossier "ddl" est sensé contenir les releases de la team. En raison de sa taille, il n'est pas disponible sur le dépôt. De ce fait certaines informations relatives aux releases peuvent être non renseignées sur le site local et sur le site de test, cependant elles doivent apparaître sur le site serveur. Il est possible de rajouter des releases dans ce dossier, dès lors le site correspondant dispose des informations relatives aux releases disponibles.