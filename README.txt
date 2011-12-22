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
+ episodes........... Pages des releases (vouées à disparaître)
|	+ chapitres...... Pages des scantrad (vouées à disparaître)
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
+ pages.............. Pages HTML (vouées à disparaître)
|	+ dossiers....... Pages des dossiers (vouées à disparaître)
|	+ series......... Pages des séries (vouées à disparaître)
|
+ sorties............ Contient un unique fichier PHP, affiche les dernières sorties (voué à disparaître)
|
+ styles............. Styles CSS disponibles
	+ default........ Style par défaut

II.1 Processus de raffinage

Le site s'organise globalement sous forme d'une hiérarchie. Pour le schématiser on peut donc utiliser un arbre :

                   index
                     |
    +----------+-----+---+---------+
    |          |         |         |
  news      projets    équipe     ...
               |
    +----------+---------+
    |          |         |
 projet1    projet2     ...
               |
   +-----------+---------+
   |           |         |
release1    release2    ...

Chaque noeud correspond à une page particulière (ou juste une partie). La racine du site est donc l'index, à partir de là on accède à toutes les autres parties du site. Par exemple la liste des projets, qui donne elle-même accès aux différents projets, eux-même donnant accès aux releases qui leurs sont propres. Les noeuds ne donnant accès à rien de particulier sont les feuilles de l'arbre. Parmis ces feuilles, on trouve bien entendu les releases, qui sont au plus bas niveau, mais aussi la liste des news et la page de l'équipe par exemple.

Ce qu'il faut savoir, c'est que modifier du code sur un noeud projet peut impliquer de devoir modifier du code au niveau release juste en dessous. Par exemple, si du jour au lendemain on décide que les releases doivent être affichées sous une forme différente au niveau projet, alors il faudra le répercuter sur toutes les releases. En revanche, si un projet s'attend à avoir un certain rendu au niveau de sa release 1, alors on peut modifier la release 1 en ayant pour seule contrainte de donner ce même rendu. Le projet compte donc sur ses releases pour afficher ce qu'il faut comme il faut, les releases par contre ne demandent rien au projet. Ce genre de "dépendance" peut se généraliser à l'ensemble du site, on peut voir ainsi qu'on a un arbre de dépendances, allant de haut en bas.

A la base, chaque noeud du site est géré par un code spécifique (un fichier HTML pour chacun). Cela implique que si une modification est faite à un niveau, elle doit être répercutée dans tous les ficheirs de ce même niveau. Si ça semble anodin pour les niveaux les plus hauts, les niveaux les plus bas en revanche deviennent ingérables. Il y a par exemple plusieurs dizaines de projets, et pour chaque projet en générale plus d'un dizaine de releases. Si on souhaite changer une simple couleur au niveau des releases, on a vite fait d'abandonner l'idée.

Ce qu'on souhaite faire est simple : on veut raffiner le site de manière à "factoriser" l'ensemble du code. Par exemple, même si on a beaucoup de releases, si on regarde bien le code HTML pour chacune on remarque que c'est globalement la même structure, seul le contenu change. L'idée est donc, plutôt que de gérer N releases avec N codes similaires, on préfère n'avoir qu'un seul code qui va donner N rendus adaptés, selon la release demandée. Pour cela, on remplace chaque code HTML par un code PHP qui sera le même pour tous. L'avantage du PHP est qu'on peut utiliser des variables et des fonctions, c'est ce qui nous permet de factoriser nos N codes HTML en un seul code PHP. Le code PHP va gérer la structure (qui est la même pour toutes les releases) et les données différentes pour chaque release seront stockées dans la DB. Le code PHP fera appel à la DB pour compléter ses propres données, de façon à fournir le même rendu final que le code HTML initial.

Ce principe de factorisation va être appliqué sur tout le site. L'idée est que, dès qu'un code ayant le même objectif apparaît 2 fois, on le factorise. De cette manière, le jour ou on souhaite changer quelque chose, on n'a qu'un seul endroit à changer pour que la modification s'applique partout. Cependant, si on fait le raffinage dans n'importe quel sens, on peut avoir des problèmes. Par exemple, si on raffine un projet mais ses releases n'ont pas été raffinés, si on a besoin de changer le rendu des releases (problème de dépendance) on doit le faire sur tous les fichiers non raffinés. Et selon la modification, on peut vouloir la faire sur tous les projets, et donc devoir modifier toutes les releases. On ne sort pas de notre problème. De plus, il ne faut pas oublier que le site est toujours disponible, on ne peut pas se permettre de le mettre hors service le temps de tout raffiner, puis de le remettre en service une fois que c'est fait. Raffiner un site est très long et peut être risqué, aussi il est important de le faire intelligemment pour appliquer les améliorations progressivement sur tout le site, sans le rendre hors d'usage.

Par conséquent, si on reprend l'arbre du site schématisé précédemment, le raffinage doit se faire depuis les feuilles de l'arbre jusqu'à la racine. Une fois que tous les enfants d'un noeud sont raffinés (toutes les releases d'un projet), on peut raffiner le noeud en question (le projet). L'index, qui est à la racine du site, est donc le dernier à pouvoir être raffiné entièrement. Cela permet d'éviter les problèmes de dépendance.

Il convient de noter que, une fois qu'un code HTML est raffiné en code PHP, ce code PHP est déplacé au niveau du noeud parent. Autrement dit, lorsqu'une release est raffinée, son code PHP résultant est géré au niveau du projet. Cela se comprend simplement : comme toutes les releases finissent par avoir le même code, ce code peut être placé à un seul endroit, le plus adapté étant le code du projet qui les concerne. L'idée peut paraître saugrenue, car cela veut dire qu'à la fin tout le code se retrouvera dans l'index, ce qui risque d'être énorme. Cela dit, la factorisation en code PHP se fait en utilisant un langage objet, et si celui-ci est bien fait il peut se réduire à quelques lignes (créer le bon objet avec les bonnes propriétés, puis appliquer la bonne fonction). Autrement dit, si le code HTML d'une release fait 20 lignes, on peut le réduire à un code PHP de 3 lignes par exemple, qui seront alors déplacées au niveau projet. Une fois toutes les releases raffinées, le projet peut contenir plusieurs dizaines de lignes, mais son propre raffinage peut le réduire par exemple à 5 lignes. Ces 5 lignes peuvent alors être déplacées au niveau de la liste des projets, et ainsi de suite.

II.2 Classes PHP

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

À noter que les interfaces ont leur noms préfixés par I (comme interface), par exemple IHtmlComponent pour un composant HTML, IDatabaseComponent pour un composant de la DB, etc. Cependant ces interfaces ne sont jamais implémentées directement, en effet plusieurs méthodes ont un logique commune quelque soit la classe. Par exemple les composants HTML peuvent tous avoir une des propriétés telles que id, class, style, etc. Aussi le processus de génération du code HTML est toujours le même (une balise englobant le contenu). Ce genre de méthodes communes est implémenté par des classes ayant le même nom que l'interface qu'il implémente, sauf que le préfixe est Default, par exemple DefaultHtmlComponent pour l'interface IHtmlComponent. Pour implémenter un nouveau composant HTML, mieux vaut étendre ces classes par défaut plutôt que de réimplémenter toute l'interface,on peut toujours surcharger certaines méthodes si besoin (mais cela peut traduire une erreur de conception). Normalement, tous les composants HTML de base sont implémentés de cette manière :
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
- CornerImage pour les images en haut à gauche du site, qui sont en mêem temps un lien vers le projet représenté par l'image
- IndexLink pour les liens vers des pages du site (accessible depuis l'index)
- MailLink pour des liens "mailto"
- NewWindowLink pour des liens ouvrant une nouvelle fenêtre (target="_blank")
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

II.3 Pages

TODO décrire les pages disponibles et leur utilisation dans le processus de raffinage

II.4 Episodes et chapitres

TODO décrire les releases disponibles et leur utilisation dans le processus de raffinage

II.5 Images

TODO décrire les images disponibles et leur utilisation dans le processus de raffinage

II.6 Styles

TODO décrire les styles disponibles et leur modèle (défaut)

II.7 Divers

Le dossier "ddl" est sensé contenir les releases de la team. En raison de sa taille, il n'est pas disponible sur le dépôt. De ce fait certaines informations relatives aux releases peuvent être non renseignées sur le site local et sur le site de test, cependant elles doivent apparaître sur le site serveur. Il est possible de rajouter des releases dans ce dossier, dès lors le site correspondant dispose des informations relatives aux releases disponibles.

Le fichier sorties/sortie.php définit la logique d'affichage des dernières sorties, dans le bandeau en haut du site. Ce code devrait finir par être fusionné à l'index, cela dit il reste là tant que le processus de raffinage du site n'arrive pas à l'index.