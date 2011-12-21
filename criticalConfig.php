<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Configuration initiale</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="Content-Language" content="fr" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta name="DC.Language" scheme="RFC3066" content="fr" />
		<link rel="stylesheet" href="styles/default/style.css" type="text/css" media="screen" title="Normal" />  
		<link rel="icon" type="image/gif" href="fav.gif" />
		<link rel="shortcut icon" href="fav.ico" />
		<style type="text/css">
			pre.code {
				border: 1px black solid;
				padding: 5px;
			}
			p {
				text-align: justify;
			}
		</style>
	</head>
	<body>
		<div id="main">
			<div id="page">
				<h1>Initialisation des données critiques</h1>
				<?php
					$criticalDataFile = "criticalData.php";
					if (is_file($criticalDataFile)) {
						echo "<p>Le fichier <b>".$criticalDataFile."</b> existe déjà, vous pouvez <a href='index.php'>retourner à l'index</a>.</p>";
					}
					else {
						echo "<p>Le fichier <b>".$criticalDataFile."</b> n'existe pas, il vous faut donc le créer. Pour se faire, ajoutez un fichier portant ce nom à la racine du site (au même endroit que l'index) et remplissez-le selon ce modèle :";
						echo "<pre class='code'>&lt;?php
/*
	This file contains critical data and should never be written
	in git repository (should be in the .ignore file).
*/
define('DB_USE', false);
define('DB_NAME', 'zero-fansub');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'zero');
define('DB_PASS', 'pass');
?></pre></p>";
						echo "<p>Les informations présentes dans ce fichier correspondent aux données de connexions à la base de données. Les noms en majuscules (comme DB_NAME) sont les noms des constantes utilisées dans le code pour appeler ces données. Les valeurs associées (par exemple 'zero-fansub') correspondent aux informations à personnaliser. Ce modèle est un exemple, libre à vous d'utiliser les même valeurs ou de les changer (notamment le mot de passe), les noms des constantes en revanche ne peuvent pas être changées. Evitez cependant d'utiliser les mêmes valeurs que celles du serveur (si vous les connaissez). Si vous êtes un développeur qui utilise sa propre base de données pour faire ses tests, vous pouvez réutiliser ce modèle tel quel ou changer les données selon vos préférences.</p>";
						echo "<p>Notez que, comme l'indique le commentaire, ce fichier ne doit jamais être versionné. Plus généralement il ne doit jamais être partagé, et cela pour une simple raison de sécurité. En effet, si le fichier original devait être disponible, n'importe qui ayant accès au dépôt (autrement dit tout le monde, vu que ce code source est disponible de manière public) aurait accès aux données sensibles du site (nom de la base de donnée, identifiants de connexion, etc.).</p>";
						echo "<p>Pour toute question, contactez l'administrateur par mail: <a href='mailto:sazaju@gmail.com'>sazaju@gmail.com</a>.</p>";
					}
				?>
			</div>
		</div>
	</body>
</html>
