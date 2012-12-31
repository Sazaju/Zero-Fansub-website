I. DEFINITIONS

Tout d'abord mettons-nous d'accord sur les termes employés, il n'en sera que plus simple de se comprendre :

Les sorties :
	Fansub   = épisode ou série (vidéo) traduit(e)
	Scantrad = chapitre ou volume (livre) traduit
	Release  = élément traduit (fansub ou scantrad)
	Preview  = ensemble d'images tirée d'une release pour être affiché dans sa description

Le code :
	HTML = description de la sémantique du site (menus, listes, titres, ...) et de son contenu
	CSS  = description de la structure du site (positions, ordres, ...) et de son rendu (couleurs, polices, tailles, ...)
	PHP  = logique du site (objets, fonctions, ...)
	DB   = base de données (contenu du site)

Le site:
	local   = site installé sur le PC du développeur
	test    = site disponible sur un serveur de test
	serveur = site du serveur officiel (site "de production")

II.ARCHITECTURE DU SITE

II.1 Architecture globale

+ class..................... Classes PHP
|   + model................. Modèle (structures de données)
|   |   + database.......... Base de données (basé sur le modèle)
|   |
|   + util.................. Fonctions utilitaires
|   + view.................. Vue (représentations graphiques)
|
+ ddl....................... Releases de la team (disponible uniquement sur le serveur)
|
+ images.................... Images utilisées pour le site
|   + autre................. 
|   + calques............... Images transparentes utilisables pour faire du traitement d'image
|   + cover................. 
|   + episodes.............. Preview des épisodes
|   + forum................. 
|   + hautmenu.............. Images aleatoires utilisées dans le coin en haut à gauche du site
|   + icones................ 
|   + interface............. 
|   + kanaii................ 
|   + news.................. Images utilisées dans les news
|   + part.................. 
|   + partenaires........... 
|   + pub................... 
|   + recrut................ 
|   + scan.................. 
|   + series................ Images utilisées pour décrire les projets (liste + descriptions)
|   + sorties............... Images apparaissant en haut du site, montrant les dernières sorties
|   + team.................. Avatars des membres de l'équipe (page équipe)
|   + titres................ 
|   + xdcc.................. 
|
+ interface................. Pages PHP décrivant les différentes parties de l'interface (entête et pied de page, menus, contenu de page)
|   + pages................. Contenu de page (accueil, projets, XDCC, etc.)
|
+ styles.................... Styles du site (CSS)
|   + default............... Style par défaut
|   + (autres dosiers)...... Autres styles
|
+ tests..................... Tests automatisés

II.1 Classes PHP

La hiérarchie des classes PHP n'est pas encore complètement fixée, cela dit elle est similaire à un schéma MVC (Model-View-Controler), avec quelques différences cependant. Pour bien clarifier cette différence, nous parlerons d'un schéma MVU (Model-View-Utilitary). Cette hiérarchie s'organise comme suit :

- le modèle (M) définit les données disponibles, c'est à dire les objets qui seront manipulés (membre, dossier, projet, épisode, ...). La convention de nommage des classes est simplement le nom des données (TeamMember, Dossier, Project, Release, ...), normalement en anglais. Ces classes regroupent tous les accesseurs/modifieurs (setters/getters) nécessaires à le lecture et l'écriture des données. Certaines fonctions de calculs simples peuvent être implémentées (ex: calcul de l'âge à partir de la date de naissance) mais rien de complexe ou consommateur en ressources, l'objectif principal est de donner accès aux données, et non de les générer. La couche utilitaire (décrite ci-dessous) peut prendre en charge les gros calculs.

- la vue (V) correspond au rendu final des données (affichage sur le site). La convention de nommage est le nom de l'objet rendu suivi de "Renderer" (cette convention n'est pas encore appliquée, au profit de "Component" ou rien du tout, mais devra l'être dans le futur). Les classes de la vue implémentent l'interface IHtmlComponent (qui devra donc s'appeler IHtmlRenderer dans le futur).

- les classes utilitaires (U) sont les éléments qui ne rentrent pas dans les sections précédentes (gros calculs, données indépendantes du site, ...). La convention de nommage n'est pas fixée, elle est donc libre (tant qu'elle ne reprend pas des noms de classes déjà existants, ce qui inclu les autres sections).

Pour faire simple, le modèle définit les informations disponibles, la vue les formate pour l'affichage final sur le site, les utilitaires permettent de les générer de diverses mannières (quand elles ne sont pas fournies à la main).

À noter que les interfaces ont leur noms préfixés par "I" (comme interface), par exemple IHtmlComponent pour l'interface d'un composant HTML, IDatabaseComponent pour l'interface d'un composant de la DB, etc. Si certaines méthodes ont une implémentation connue dès le départ (communes à toutes les classes filles envisageables), une classe par défaut, du même nom mais avec le préfixe "Default" (DefaultHtmlComponent, DefaultDatabaseComponent), peut être implémentée. Il convient de regarder si une classe par défaut existe avant d'implémenter une interface. On peut toujours surcharger certaines méthodes si besoin (mais cela peut traduire une erreur de conception).

Normalement, tous les composants HTML de base sont implémentés de cette manière. Ils implémentent l'interface IHtmlComponent en étendant la classe par défaut DefaultHtmlComponent :
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

Dans les classes utilitaires, on peut trouver des fonctionnalités pouvant :
- appliquer des formatages spéciaux,
- vérifier des données,
- déboguer,
- ...

II.2 Pages

Le dossier "interface/pages" contient les différentes pages du site, à savoir :
- about.php correspond à la page "À propos"
- bug.php correspond à la page "Signaler un bug", affichée automatiquement en cas de bug
- contact.php correspond à la page "Contact"
- dossier.php correspond à l'affichage d'un dossier particulier
- dossiers.php correspond à la liste des dossiers
- havert.php correspond à l'avertissement pour l'accès à la partie hentai
- news.php correspond à la page affichant les news, qui est aussi la page d'accueil
- news2.php correspond à la page affichant une news spécifique (notamment pour les liens RSS)
- partenariat.php correspond à la page "Devenir partenaires"
- project.php correspond à l'affichage d'un projet particulier
- projects.php correspond à la liste des projets
- recruit.php correspond à la page "Recrutement"
- team.php correspond à la page "L'équipe"
- xdcc.php correspond à la page "XDCC"

D'autres fichiers sont présents, principalement des pages obsolètes. Un futur nettoyage devrait supprimer ces pages.

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

Il est prévu d'avoir, dans le futur, un dossier "resources" dans lequel seront mis tous les fichiers dont le site ne dépend pas (images de news, images de dossiers, releases, ...). Autrement dit, à part les images de l'interface (déjà partiellement déplacées), toutes les images devraient se retrouvées dans ce dossier "resources".

II.4 Styles

Pour l'instant un seul style est disponible, celui par défaut (default). Ce style est le modèle à considérer pour tout nouveau style. En particulier, tout style devrait se composer de cette façon :

+ images............ Ensemble des images utilisées par le style
+ style.css......... Style tout public
+ styleH.css........ Style Hentai
+ styleXMas.css..... Style tout public pour Noël
+ styleHXMas.css.... Style Hentai pour Noël

Il peut y avoir d'autres fichiers (CSS découpés, sous-répertoires pour les images, ...) mais toutes les images utilisées par le style (et uniquement ça) doivent être dans le dossier image, et les deux fichiers de styles doivent avoir ces noms et être placés à la racine du répertoire.

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

Le dossier "ddl" est censé contenir les releases de la team. En raison de sa taille, il n'est pas disponible sur le dépôt. De ce fait certaines informations relatives aux releases peuvent être non renseignées sur le site local et sur le site de test, cependant elles doivent apparaître sur le site serveur. Il est possible de rajouter des releases dans ce dossier, dès lors le site correspondant dispose des informations relatives aux releases disponibles. Dans le futur, il est prévu de placer les releases dans un répertoire "resources" (comme beaucoup d'autres fichiers).
