I. DEFINITIONS

Tout d'abord mettons-nous d'accord sur les termes employés, il n'en sera que plus simple de discuter :

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

TODO décrire le processus de raffinage

II.2 Classes PHP

TODO décrire la logique des classes implémentées et leur hiérarchie

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