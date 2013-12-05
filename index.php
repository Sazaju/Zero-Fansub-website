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
if (!$url->hasQueryVar('page') || $url->getQueryVar('page') == 'news') {
		if ($url->hasQueryVar('view')) {
		$view = $url->getQueryVar('view');
		$url->removeQueryVar('view');
		
		$select = '';
		switch($view) {
			case 'all': $selected = '';break;
			case 'releases': $selected = 'r';break;
			case 'team': $selected = 't';break;
			case 'partners': $selected = 'p';break;
			case 'db0company': $selected = 'c';break;
			case 'unclassable': $selected = 'm';break;
			default: $selected = '';// all by default
		}
		
		$url->setQueryVar('select', $selected);
		header("HTTP/1.1 301 Moved Permanently", false, 301);
		header('Location: '.$url->toString());
		exit();
	} else {
		// no retro-compatibility action is needed
	}
} else if ($url->hasQueryVar('page')) {
	$page = $url->getQueryVar('page');
	if (preg_match("#^series/#", $page)) {
		$url->setQueryVar('page', 'project');
		$parts = preg_split("#/#", $page);
		$url->setQueryVar('id', $parts[1]);
		header("HTTP/1.1 301 Moved Permanently", false, 301);
		header('Location: '.$url->toString());
		exit();
	} else if (preg_match("#^dossier/#", $page)) {
		$url->setQueryVar('page', 'dossier');
		$parts = preg_split("#/#", $page);
		$url->setQueryVar('id', $parts[1]);
		header("HTTP/1.1 301 Moved Permanently", false, 301);
		header('Location: '.$url->toString());
		exit();
	} else if ($page == 'home') {
		$url->setQueryVar('page', 'news');
		header("HTTP/1.1 301 Moved Permanently", false, 301);
		header('Location: '.$url->toString());
		exit();
	} else {
		// no retro-compatibility action is needed
	}
}

/**********************************\
    CONTEXT-DEPENDENT FUNCTIONS
  (remove when refining allow it)
\**********************************/

function getCurrentPage() {
	$url = new Url();
	
	$page = 'news';
	if ($url->hasQueryVar('page')) {
		$page = $url->getQueryVar('page');
	}
	
	if ($url->hasQueryVar(DISPLAY_H_AVERT)) {
		$page = "havert";
	}
	
	return $page;
}

function buildRssUrlIfAvailable() {
	if (getCurrentPage() == 'news') {
		$url = Url::getCurrentUrl();
		new NewsSelector();//force class loading for constants
		$selected = $url->hasQueryVar('select') ? $url->getQueryVar('select') : NEWSSELECTOR_ALL;
		$rssUrl = new Url('rss.php');
		$rssUrl->setQueryVar('select', empty($selected) ? null : $selected, true);
		$rssUrl->setQueryVar('h', null, !$_SESSION[MODE_H]);
		return $rssUrl;
	} else {
		return null;
	}
}

/**********************************\
         PAGE RENDERING
\**********************************/
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Zéro ~fansub~ :: Le Site Officiel <?php echo WEBSITE_VERSION?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="fr" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta name="DC.Language" scheme="RFC3066" content="fr" />
		<?php
			$date = getdate($_SESSION[CURRENT_TIME]);
			$month = $date['mon'];
			$day = $date['mday'];
			
			$variant = "";
			$variant .= $_SESSION[MODE_H] ? "H" : "";
			$variant .= ($month == 12) ? "Xmas" : "";
			$styleFile = "styles/".$_SESSION[STYLE]."/style".$variant.".css";
		?>
		<style type="text/css">
			/* HTML 4 compatibility */
			article, aside, figcaption, figure, footer, header, hgroup, nav, section {
				display: block;
			}
		</style>
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="<?php echo $styleFile; ?>" type="text/css" media="screen" title="Normal" />  
		<link rel="icon" type="image/gif" href="favicon.gif" />
		<link rel="shortcut icon" href="favicon.ico" />
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
		<?php
			$rssUrl = buildRssUrlIfAvailable();
			if (!empty($rssUrl)) {
				echo '<link rel="alternate" type="application/rss+xml" href="'.$rssUrl.'" title="Votre titre">';
			}
		?>
	</head>
	<body>
		<section id="pre-main">
			<!--FACEBOOK-->
			<div id="fb-root"></div>
			<script>
				(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
			<!--/FACEBOOK-->
			<!--GOOGLE-->
			<script type="text/javascript">
				window.___gcfg = {lang: 'fr'};
				
				(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				})();
			</script>
			<!--/GOOGLE-->
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
					$preload->addComponent(new Image($file));
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
		</section>
		<section id="main">
			<?php require_once("interface/colLeft.php")?>
			<?php require_once("interface/colRight.php")?>
			<?php require_once("interface/header.php")?>
			<?php require_once("interface/page.php")?>
			<?php require_once("interface/footer.php")?>
		</section>
		<section id="post-main">
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
		</section>
	</body>
</html>
