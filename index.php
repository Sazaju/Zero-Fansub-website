<?php
/*
	This file is the root of the website. Here is the global code generating the
	complete page.
*/

require_once("baseImport.php");

/**********************************\
         RETRO COMPATIBILITY
\**********************************/
$url = Url::getCurrentUrl();
if ($url->hasQueryVar('page')) {
	$page = $url->getQueryVar('page');
	if (preg_match("#^series/#", $page)) {
		$url->setQueryVar('page', 'project');
		$parts = preg_split("#/#", $page);
		$url->setQueryVar('id', $parts[1]);
		// TODO indicates it is definitively relocated
		header('Location: '.$url->toString());
		exit();
	}
	if (preg_match("#^dossier/#", $page)) {
		$url->setQueryVar('page', 'dossier');
		$parts = preg_split("#/#", $page);
		$url->setQueryVar('id', $parts[1]);
		// TODO indicates it is definitively relocated
		header('Location: '.$url->toString());
		exit();
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Zéro ~fansub~ :: Le Site Officiel <?php echo WEBSITE_VERSION?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
		<meta http-equiv="Content-Language" content="fr" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta name="DC.Language" scheme="RFC3066" content="fr" />
		<?php
			$styleFile = "styles/".$_SESSION[STYLE]."/style".($_SESSION[MODE_H] ? "H" : "").".css";
		?>
		<link rel="stylesheet" href="<?php echo $styleFile; ?>" type="text/css" media="screen" title="Normal" />  
		<link rel="icon" type="image/gif" href="fav.gif" />
		<link rel="shortcut icon" href="fav.ico" />
		<script type="text/javascript">
			function show(nom_champ) {
				if(document.getElementById) {
					tabler = document.getElementById(nom_champ);
					if(tabler.style.display=="none") {
						tabler.style.display="";
					}
					else {
						tabler.style.display="none";
					}
				}
			}
		</script>
	</head>
	<body>
		<?php
			$preload = new SimpleBlockComponent();
			$preload->setID("preload");
			$preload->setClass("hidden");
			$dir = "styles/".$_SESSION[STYLE]."/images/";
			$descStack = DirectoryManager::getContent($dir, true);
			$files = array();
			while(!empty($descStack)) {
				$descriptor = array_pop($descStack);
				if ($descriptor['type'] === 'file') {
					$files[] = $dir.$descriptor['name'];
				} else if ($descriptor['type'] === 'directory') {
					foreach($descriptor['content'] as $sub) {
						$sub['name'] = $descriptor['name'].'/'.$sub['name'];
						array_push($descStack, $sub);
					}
				} else {
					// ignore others (not recognized)
				}
			}
			foreach($files as $file) {
				$preload->addComponent(new ImageComponent($file));
			}
			$preload->writeNow();
		?>
		<?php
			if (TEST_MODE_ACTIVATED) {
				echo TESTING_FEATURE;
			}
			if (Url::getCurrentUrl()->hasQueryVar('phpinfo')) {
				phpinfo();
				exit;
			}
		?>
		<div id="main">
			<?php require_once("interface/colLeft.php")?>
			<?php require_once("interface/colRight.php")?>
			<?php require_once("interface/header.php")?>
			<?php require_once("interface/page.php")?>
			<?php require_once("interface/footer.php")?>
		</div>
		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			try {
				var pageTracker = _gat._getTracker("UA-4691079-6");
				pageTracker._trackPageview();
			} catch(err) {}
		</script>
		<?php
			if (TEST_MODE_ACTIVATED) {
				echo TESTING_FEATURE;
			}
		?>
	</body>
</html>
