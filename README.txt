I. DEFINITIONS

Tout d'abord mettons-nous d'accord sur les termes employ�s, il n'en sera que plus simple de se comprendre :

Les sorties :
	Fansub   = �pisode ou s�rie (vid�o) traduit(e)
	Scantrad = chapitre ou volume (livre) traduit
	Release  = �l�ment traduit (fansub ou scantrad)
	Preview  = ensemble d'images tir�e d'une release pour �tre affich� dans sa description

Le code :
	HTML = description de la s�mantique du site (menus, listes, titres, ...) et de son contenu
	CSS  = description de la structure du site (positions, ordres, ...) et de son rendu (couleurs, polices, tailles, ...)
	PHP  = logique du site (objets, fonctions, ...)
	DB   = base de donn�es (contenu du site)

Le site:
	local   = site install� sur le PC du d�veloppeur
	test    = site disponible sur un serveur de test
	serveur = site du serveur officiel (site "de production")

II.ARCHITECTURE DU SITE

II.1 Architecture globale

+ class..................... Classes PHP
|   + model................. Mod�le (structures de donn�es)
|   |   + database.......... Base de donn�es (bas� sur le mod�le)
|   |
|   + util.................. Fonctions utilitaires
|   + view.................. Vue (repr�sentations graphiques)
|
+ ddl....................... Releases de la team (disponible uniquement sur le serveur)
|
+ images.................... Images utilis�es pour le site
|   + autre................. 
|   + calques............... Images transparentes utilisables pour faire du traitement d'image
|   + cover................. 
|   + episodes.............. Preview des �pisodes
|   + forum................. 
|   + hautmenu.............. Images aleatoires utilis�es dans le coin en haut � gauche du site
|   + icones................ 
|   + interface............. 
|   + kanaii................ 
|   + news.................. Images utilis�es dans les news
|   + part.................. 
|   + partenaires........... 
|   + pub................... 
|   + recrut................ 
|   + scan.................. 
|   + series................ Images utilis�es pour d�crire les projets (liste + descriptions)
|   + sorties............... Images apparaissant en haut du site, montrant les derni�res sorties
|   + team.................. Avatars des membres de l'�quipe (page �quipe)
|   + titres................ 
|   + xdcc.................. 
|
+ interface................. Pages PHP d�crivant les diff�rentes parties de l'interface (ent�te et pied de page, menus, contenu de page)
|   + pages................. Contenu de page (accueil, projets, XDCC, etc.)
|
+ styles.................... Styles du site (CSS)
|   + default............... Style par d�faut
|   + (autres dosiers)...... Autres styles
|
+ tests..................... Tests automatis�s

II.1 Classes PHP

La hi�rarchie des classes PHP n'est pas encore compl�tement fix�e, cela dit elle est similaire � un sch�ma MVC (Model-View-Controler), avec quelques diff�rences cependant. Pour bien clarifier cette diff�rence, nous parlerons d'un sch�ma MVU (Model-View-Utilitary). Cette hi�rarchie s'organise comme suit :

- le mod�le (M) d�finit les donn�es disponibles, c'est � dire les objets qui seront manipul�s (membre, dossier, projet, �pisode, ...). La convention de nommage des classes est simplement le nom des donn�es (TeamMember, Dossier, Project, Release, ...), normalement en anglais. Ces classes regroupent tous les accesseurs/modifieurs (setters/getters) n�cessaires � le lecture et l'�criture des donn�es. Certaines fonctions de calculs simples peuvent �tre impl�ment�es (ex: calcul de l'�ge � partir de la date de naissance) mais rien de complexe ou consommateur en ressources, l'objectif principal est de donner acc�s aux donn�es, et non de les g�n�rer. La couche utilitaire (d�crite ci-dessous) peut prendre en charge les gros calculs.

- la vue (V) correspond au rendu final des donn�es (affichage sur le site). La convention de nommage est le nom de l'objet rendu suivi de "Renderer" (cette convention n'est pas encore appliqu�e, au profit de "Component" ou rien du tout, mais devra l'�tre dans le futur). Les classes de la vue impl�mentent l'interface IHtmlComponent (qui devra donc s'appeler IHtmlRenderer dans le futur).

- les classes utilitaires (U) sont les �l�ments qui ne rentrent pas dans les sections pr�c�dentes (gros calculs, donn�es ind�pendantes du site, ...). La convention de nommage n'est pas fix�e, elle est donc libre (tant qu'elle ne reprend pas des noms de classes d�j� existants, ce qui inclu les autres sections).

Pour faire simple, le mod�le d�finit les informations disponibles, la vue les formate pour l'affichage final sur le site, les utilitaires permettent de les g�n�rer de diverses manni�res (quand elles ne sont pas fournies � la main).

� noter que les interfaces ont leur noms pr�fix�s par "I" (comme interface), par exemple IHtmlComponent pour l'interface d'un composant HTML, IDatabaseComponent pour l'interface d'un composant de la DB, etc. Si certaines m�thodes ont une impl�mentation connue d�s le d�part (communes � toutes les classes filles envisageables), une classe par d�faut, du m�me nom mais avec le pr�fixe "Default" (DefaultHtmlComponent, DefaultDatabaseComponent), peut �tre impl�ment�e. Il convient de regarder si une classe par d�faut existe avant d'impl�menter une interface. On peut toujours surcharger certaines m�thodes si besoin (mais cela peut traduire une erreur de conception).

Normalement, tous les composants HTML de base sont impl�ment�s de cette mani�re. Ils impl�mentent l'interface IHtmlComponent en �tendant la classe par d�faut DefaultHtmlComponent :
- Image pour la balise img
- Link pour la balise a
- SimpleBlockComponent pour la balise div
- SimpleListComponent pour les balises ol/ul
- SimpleParagraphComponent pour la balise p
- SimpleTextComponent pour la balise span
- Table, TableRow et TableCell pour les balises table, tr et td
- Title pour les balises h1, h2, etc.

Il est alors possible d'�tendre ces classes pour avoir des gestions sp�cialis�es. On a par exemple :
- Anchor pour les ancres (<a name="#..."></a>)
- CornerImage pour les images en haut � gauche du site, qui sont en m�me temps un lien vers le projet repr�sent� par l'image
- MailLink pour des liens "mailto"
- ProjectLink pour des liens vers des projets complets
- ReleaseLink pour des liens vers des releases sp�cifiques
- ReleaseComponent pour l'affichage d'une release
- Pin pour aider au positionnement de certains composants
- ...

Dans les classes utilitaires, on peut trouver des fonctionnalit�s pouvant :
- appliquer des formatages sp�ciaux,
- v�rifier des donn�es,
- d�boguer,
- ...

II.2 Pages

Le dossier "interface/pages" contient les diff�rentes pages du site, � savoir :
- about.php correspond � la page "� propos"
- bug.php correspond � la page "Signaler un bug", affich�e automatiquement en cas de bug
- contact.php correspond � la page "Contact"
- dossier.php correspond � l'affichage d'un dossier particulier
- dossiers.php correspond � la liste des dossiers
- havert.php correspond � l'avertissement pour l'acc�s � la partie hentai
- news.php correspond � la page affichant les news, qui est aussi la page d'accueil
- news2.php correspond � la page affichant une news sp�cifique (notamment pour les liens RSS)
- partenariat.php correspond � la page "Devenir partenaires"
- project.php correspond � l'affichage d'un projet particulier
- projects.php correspond � la liste des projets
- recruit.php correspond � la page "Recrutement"
- team.php correspond � la page "L'�quipe"
- xdcc.php correspond � la page "XDCC"

D'autres fichiers sont pr�sents, principalement des pages obsol�tes. Un futur nettoyage devrait supprimer ces pages.

II.3 Images

Ce dossier est un peu fourre-tout, mais il est important de retenir ceci :
- autre contient quelques images qu'il faudra penser � ranger ailleurs (comme des bonus li�s � des releases)
- calques contient les PNG HD transparent � utiliser pour faire les banni�res et autres compositions d'images
- episodes contient les previews des releases
- hautmenu contient les images affich�es en haut � gauche du site, elles font toutes 150x250 pixels
- icones contient des icones telles que ceux utilis�s dans les descriptions des releases (torrent, lien MU, lien free, ...)
- interface contient les images utilis�es pour l'interface, cependant il est vou� � dispara�tre vu que les images de l'interface doivent �tre transf�r�es dans le dossier du style associ� (c'est d�j� le cas pour certaines images du style par d�faut)
- news contient les images utilis�es dans les news
- partenaires contient les banni�res des partenaires (et les notres)
- series contient les banni�res des projets + les images utilis�es dans la description de chaque projet (pas les previews des releases)
- sorties contient lesimages de l'ent�te du site (les derniers �pisodes sortis)
- team contient les avatars des membres de la team (utilis�es notamment dans la page d�crivant l'�quipe)

Il est pr�vu d'avoir, dans le futur, un dossier "resources" dans lequel seront mis tous les fichiers dont le site ne d�pend pas (images de news, images de dossiers, releases, ...). Autrement dit, � part les images de l'interface (d�j� partiellement d�plac�es), toutes les images devraient se retrouv�es dans ce dossier "resources".

II.4 Styles

Pour l'instant un seul style est disponible, celui par d�faut (default). Ce style est le mod�le � consid�rer pour tout nouveau style. En particulier, tout style devrait se composer de cette fa�on :

+ images............ Ensemble des images utilis�es par le style
+ style.css......... Style tout public
+ styleH.css........ Style Hentai
+ styleXMas.css..... Style tout public pour No�l
+ styleHXMas.css.... Style Hentai pour No�l

Il peut y avoir d'autres fichiers (CSS d�coup�s, sous-r�pertoires pour les images, ...) mais toutes les images utilis�es par le style (et uniquement �a) doivent �tre dans le dossier image, et les deux fichiers de styles doivent avoir ces noms et �tre plac�s � la racine du r�pertoire.

II.5 Conventions de programmation

Le code PHP est �crit en anglais. C'est un langage plus adapt� � la programmation (ou plut�t le langage de programmation est adapt� � cette langue) et donc mieux vaut rester homog�ne. Un des avantages est que l'anglais offre pas mal de petits mots tr�s r�currents (set au lieu de assigner, get au lieu de r�cup�rer, ...) ce qui r�duit les noms de mani�re assez importante. De plus, le fran�ais utilisant des accents incompatibles avec PHP, mieux vaut �viter.

Certains commentaires sont aussi en anglais mais ce n'est pas obligatoire (plut�t une habitude pour certains), aussi ce n'est pas grave si d'autres commentaires sont en fran�ais (les autres langues sont cependant � proscrire). Il convient de noter qu'un commentaire n'est pas l� pour dire ce que fait le code, le code en lui-m�me doit �tre suffisamment parlant. Par exemple :

// on cherche la release X dans la liste des releases
$r = null;
foreach($releases as $release) {
	if ($release->getId() == $id) {
		$r = $release;
		break;
	}
}

Le commentaire est ici inutile, car le code est assez explicite pour voir qu'on parcoure (boucle foreach) des releases (tableau $releases) et que lorsqu'un ID sp�cifique est atteint ($release->getId() == $id) on garde en m�moire la release correspondante ($r = $release) et on arr�te la recherche (break). Si on estime que le code est trop compliqu� pour qu'en le lisant on comprenne ce qu'il fait, alors mieux vaut revoir le code pour le simplifier (le r��crire ou factoriser certaines parties dans des fonctions aux noms explicites) de fa�on � avoir un code clair. Les commentaires ne sont utiles que pour :
- les ent�tes (d�crire le r�le et l'utilisation d'une classe ou de longues fonctions)
- les subtilit�s (par exemple on sait dans quel ordre est tri� un tableau, donc on le parcours dans un ordre particulier plut�t que de mani�re habituelle)
- les notifications telles que des TODO (future t�che), FIXME (bogue � corriger), etc.

II.6 Divers

Le dossier "ddl" est cens� contenir les releases de la team. En raison de sa taille, il n'est pas disponible sur le d�p�t. De ce fait certaines informations relatives aux releases peuvent �tre non renseign�es sur le site local et sur le site de test, cependant elles doivent appara�tre sur le site serveur. Il est possible de rajouter des releases dans ce dossier, d�s lors le site correspondant dispose des informations relatives aux releases disponibles. Dans le futur, il est pr�vu de placer les releases dans un r�pertoire "resources" (comme beaucoup d'autres fichiers).
