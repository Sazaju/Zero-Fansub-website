<?php
/*
	This file is the root of the website. Here is the global code generating the
	complete page.
*/

define('TEST_MODE_ACTIVATED', in_array($_SERVER["SERVER_NAME"], array(
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
		echo "An error as occured, ".(
			$sent ? "administrators has been noticed by mail"
				  : "contact the administrators : ".$administrators
			).".";
	}
	else {
		echo "An error as occured : ".$exception."<br/><br/>".TESTING_FEATURE;
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
		include $file;
	}
}

$criticalDataFile = "criticalData.php";
if (!is_file($criticalDataFile)) {
	header("Location: criticalConfig.php");
	exit;
}
require_once($criticalDataFile);
unset($criticalDataFile);

/**********************************\
             DATABASE
\**********************************/

if (DB_USE) {
	Database::createDefaultDatabase(TEST_MODE_ACTIVATED);
	if (TEST_MODE_ACTIVATED && isset($_GET['clearDB'])) {
		Database::getDefaultDatabase()->clear();
		$url = Url::getCurrentScriptUrl();
		header('Location: '.$url->getUrl());
		exit();
	}
}

/**********************************\
            GIT UPDATE
\**********************************/

if (TEST_MODE_ACTIVATED && isset($_GET['gitPull'])) {
	exec("git pull");
	$url = Url::getCurrentScriptUrl();
	header('Location: '.$url->getUrl());
	exit();
}

/**********************************\
            TEST FEATURES
\**********************************/

if (TEST_MODE_ACTIVATED) {
	$clearDB = 'clear DB';
	$clearDB = DB_USE ? '<a href="'.$_SERVER['PHP_SELF'].'?clearDB'.'">'.$clearDB.'</a>' : '<s>'.$clearDB.'</s>';
	
	$gitPull = '<a href="'.$_SERVER['PHP_SELF'].'?gitPull'.'">git pull</a>';
	
	$commitInfo = exec('git log -1 --pretty=format:"%h - %s"');
	define('TESTING_FEATURE', 'Testing mode : '.$clearDB." - ".$gitPull."<br/>".$commitInfo);
}

/**********************************\
          OTHER CONSTANTS
\**********************************/

define('WEBSITE_VERSION', exec('git tag'));
define('MODE_H', 'modeH');
define('DISPLAY_H_AVERT', 'displayHavert');

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
		<link rel="stylesheet" href="styles/default/style.css" type="text/css" media="screen" title="Normal" />  
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
			$images = Image::getPreloadedImages();
			foreach($images as $image) {
				$image->setClass("hidden");
				$image->writeNow();
			}
		?>
		<?php
			if (isset($_GET['phpinfo'])) {
				phpinfo();
				exit;
			}
			if (TEST_MODE_ACTIVATED) {
				echo "<div class='testFeatures'>".TESTING_FEATURE."</div>";
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
				echo "<div class='testFeatures'>".TESTING_FEATURE."</div>";
			}
		?>
	</body>
</html>
