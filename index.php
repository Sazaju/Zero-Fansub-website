<?php
/*
	This file is the root of the website. Here is the global code generating the
	complete page.
*/

define('TEST_MODE_ACTIVATED', !isset($_GET['noTest']) && in_array($_SERVER["SERVER_NAME"], array(
				'127.0.0.1',
				'localhost',
				'to-do-list.me',
				'sazaju.dyndns-home.com'
		), true));

/**********************************\
           ERROR MANAGING
\**********************************/

function error_handler($code, $message, $file, $line)
{
    if (0 == error_reporting())
    {
        return;
    }
    throw new ErrorException($message, 0, $code, $file, $line);
}

function exception_handler($exception) {
	if (!TEST_MODE_ACTIVATED) {
		// TODO
		$administrators = "sazaju@gmail.com";
		$subject = "ERROR";
		$message = "aze";//$exception->getMessage();
		$header = "From: noreply@zerofansub.net\r\n";
		$sent = false;//mail($administrators, $subject, $message, $header);
		echo "Une erreur est survenue, ".(
			$sent ? "les administrateurs en ont été notifiés"
				  : "contactez les administrateurs : ".$administrators
			).".";
	}
	else {
		echo "Une erreur est survenue : ".$exception;
		if (defined('TESTING_FEATURE')) {
			echo "<br/><br/>".TESTING_FEATURE;
		}
		phpinfo();
	}
}

set_error_handler("error_handler");
set_exception_handler('exception_handler');

/**********************************\
              IMPORTS
\**********************************/

function findFile($fileName, $dir) {
	$expected = strtolower($dir.'/'.$fileName);
	foreach(glob($dir . '/*') as $file) {
		if (strtolower($file) == $expected) {
			return $file;
		}
		else if (is_dir($file)) {
			$file = findFile($fileName, $file);
			if ($file != null) {
				return $file;
			}
		}
	}
	return null;
}

function __autoload($className) {
	$file = findFile($className.'.php', 'class');
	if ($file != null) {
		$chunks = explode("/", $file);
		if (TEST_MODE_ACTIVATED && in_array("old", $chunks)) {
			echo Debug::createWarningTag("Old script used: $file");
		}
		include $file;
	}
}

/**********************************\
         CRITICAL CONFIG
\**********************************/

$criticalDataFile = "criticalData.php";
$needConfig = true;
if (is_file($criticalDataFile)) {
	require_once($criticalDataFile);
	if (defined('DB_USE') && defined('DB_TYPE') && defined('DB_NAME') && defined('DB_HOST') && defined('DB_USER') && defined('DB_PASS')) {
		$needConfig = false;
	}
}
if ($needConfig) {
	require_once("criticalConfig.php");
	exit;
} else {
	// all green, just continue
}
unset($criticalDataFile); // security: we forget the source of critical information

/**********************************\
         STRANGE URL CHECK
\**********************************/

$url = Url::getCurrentUrl();
if ($url->isStrangeUrl()) {
	$currentAddress = $url->toFullString();
	$url->cleanStrangeParts();
	$cleanAddress = $url->toFullString();
	if (TEST_MODE_ACTIVATED) {
		throw new Exception (Format::convertTextToHtml("Strange url ([url]".$currentAddress."[/url]), maybe expected this one : [url]".$cleanAddress."[/url]? In not testing mode, redirection will be done."));
	} else if ($url->isStrangeUrl()) {
		header('Location: '.$_SERVER['SCRIPT_NAME']);
		exit();
	} else {
		header('Location: '.$cleanAddress);
		exit();
	}
}

/**********************************\
             DATABASE
\**********************************/

if (DB_USE) {
	$url = Url::getCurrentUrl();
	if (TEST_MODE_ACTIVATED && $url->hasQueryVar('clearDB')) {
		Database::getDefaultDatabase()->clear();
		// TODO move the default loading here
		$url->removeQueryVar('clearDB');
		header('Location: '.$url->toString());
		exit();
	}
	
	$db = Database::getDefaultDatabase();
	if (!$db->isRegisteredUser('anonymous')) {
		$db->addUser('anonymous', null);
	}
}

/**********************************\
            TEST FEATURES
\**********************************/

if (TEST_MODE_ACTIVATED) {
	$features = new SimpleBlockComponent();
	$features->setClass('testFeatures');
	$features->addComponent('Testing mode : ');
	
	$link = new Link(Url::getCurrentUrl(), 'clear DB');
	if (DB_USE) {
		$link->getUrl()->setQueryVar('clearDB');
	} else {
		$link->getUrl()->setUrl('#');
		$link->setClass('deactivated');
	}
	$features->addComponent($link);
	
	$link = new Link(Url::getCurrentUrl(), 'PHP info');
	if (Url::getCurrentUrl()->hasQueryVar('phpinfo')) {
		$link->getUrl()->removeQueryVar('phpinfo');
		$link->setClass('reverse');
	} else {
		$link->getUrl()->setQueryVar('phpinfo');
	}
	$features->addComponent($link);
	
	$link = new Link(Url::getCurrentUrl(), 'deactivate testing mode');
	if (Url::getCurrentUrl()->hasQueryVar('noTest')) {
		$link->getUrl()->removeQueryVar('noTest');
		$link->setClass('reverse');
	} else {
		$link->getUrl()->setQueryVar('noTest');
	}
	$features->addComponent($link);
	
	$features->addComponent('<br/>');
	$features->addComponent(substr(exec('git branch --merged'), 2));
	$features->addComponent(' - ');
	$features->addComponent(exec('git log -1 --pretty=format:"%h - %s"'));
	
	define('TESTING_FEATURE', $features->getCurrentHTML());
}

/**********************************\
          OTHER CONSTANTS
\**********************************/

define('WEBSITE_VERSION', exec('git tag'));
define('MODE_H', 'modeH');
define('DISPLAY_H_AVERT', 'displayHavert');
define('STYLE', 'style');

/**********************************\
         SESSION MANAGEMENT
\**********************************/

session_start();

if (isset($_GET[MODE_H])) {
	$_SESSION[MODE_H] = $_GET[MODE_H];
	$url = Url::getCurrentUrl();
	$url->removeQueryVar(MODE_H);
	header('Location: '.$url->toString());
	exit();
} else if (!isset($_SESSION[MODE_H])) {
	$_SESSION[MODE_H] = false;
} else {
	// let the state as is
}

$_SESSION[STYLE] = "default";

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
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
		<script type="text/javascript" language="Javascript">
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
