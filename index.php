<?php
	require_once("php/constants.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title><?php echo TITLE; ?></title>
		<!--
			we give a "text/html" content to be compatible with most of the
			explorers, it should be "application/xhtml+xml". See this link :
			
			http://www.pompage.net/traduction/declarations
		-->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<h1><?php echo TITLE; ?></h1>
		<p>Here is a first file with some initial PHP code.</p>
	</body>
</html>