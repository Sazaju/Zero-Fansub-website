<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Configuration initiale</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="fr" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta name="DC.Language" scheme="RFC3066" content="fr" />
		<link rel="stylesheet" href="styles/default/style.css" type="text/css" media="screen" title="Normal" />  
		<link rel="icon" type="image/gif" href="fav.gif" />
		<link rel="shortcut icon" href="fav.ico" />
		<style type="text/css">
			/* HTML 4 compatibility */
			article, aside, figcaption, figure, footer, header, hgroup, nav, section {
				display: block;
			}
		</style>
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<style type="text/css">
			code {
				display: block;
				text-align: left;
				border: 1px black solid;
				padding: 5px;
			}
			p {
				text-align: justify;
			}
		</style>
	</head>
	<body>
		<section id="main">
			<article id="page">
				<h1>Initialisation des données critiques</h1>
				<p>
					Le fichier <b><?php echo $criticalDataFile; ?></b> n'existe pas ou ses données ne sont pas correctes. Il vous faut donc le créer ou le corriger. Pour se faire, ouvrez un fichier portant ce nom à la racine du site (au même endroit que l'index) et remplissez-le selon ce modèle :
				</p>
				<code>&lt;?php
/*
	This file contains critical data and should never be written
	in the repository of a version management system (ensure it
	is ignored).
*/
define('DB_USE', false);
define('DB_TYPE', 'mysql');
define('DB_NAME', 'zero-fansub');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'zero');
define('DB_PASS', 'pass');
?&gt;</code>
				
				<p>Les informations présentes dans ce fichier correspondent aux données de connexions à la base de données. Les termes en majuscules (comme DB_NAME) sont les <b>noms</b> des constantes utilisées dans le code pour appeler ces données. Les <b>valeurs</b> associées (par exemple 'zero-fansub') correspondent aux informations à personnaliser. Ce modèle est un exemple, libre à vous d'utiliser les même <b>valeurs</b> ou de les changer (notamment le mot de passe), les <b>noms</b> des constantes en revanche ne peuvent pas être changées. Si vous êtes un développeur qui utilise sa propre base de données pour faire ses tests, vous pouvez réutiliser ce modèle tel quel ou changer les données selon vos préférences (mais évitez d'utiliser les mêmes valeurs que celles du serveur officiel si vous les connaissez).</p>
				
				<p>Notez que, comme l'indique le commentaire, ce fichier ne doit jamais être versionné. Plus généralement il ne doit jamais être partagé, et cela pour une simple raison de sécurité. En effet, si le fichier original devait être disponible, n'importe qui ayant accès au dépôt (autrement dit tout le monde, vu que ce code source est disponible de manière public) aurait accès aux données sensibles du site (nom de la base de donnée, identifiants de connexion, etc.).</p>
				
				<p>Pour toute question, contactez l'administrateur par mail: <a href='mailto:sazaju@gmail.com'>sazaju@gmail.com</a>.</p>
			</div>
		</div>
	</body>
</html>
