<?php
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

if (TEST_MODE_ACTIVATED) {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

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

spl_autoload_register(function($className) {
	$file = findFile($className.'.php', 'class');
	if ($file != null) {
		$chunks = explode("/", $file);
		if (TEST_MODE_ACTIVATED && in_array("old", $chunks)) {
			echo Debug::createWarningTag("Old script used: $file");
		}
		include $file;
	} else {
		// do nothing, because another loader can find it
	}
});

/**********************************\
         CRITICAL CONFIG
\**********************************/

$criticalDataFile = "databaseConfig.php";
$needConfig = true;
try {
	include_once($criticalDataFile);
	$needConfig = false;
} catch(ErrorException $ex) {
	// do nothing, the error is managed later
}
if ($needConfig) {
	require_once("configAlert.php");
	exit;
} else {
	// all green, just continue
}
unset($criticalDataFile); // security: we forget the source of critical information

// other critical configs (which need to be done as soon as possible)
date_default_timezone_set("Europe/Paris");

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
          OTHER CONSTANTS
\**********************************/

define('WEBSITE_VERSION', exec('git tag'));
define('MODE_H', 'modeH');
define('DISPLAY_H_AVERT', 'displayHavert');
define('STYLE', 'style');
define('CURRENT_TIME', 'currentTime');

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

$dirs = DirectoryManager::getContent("styles");
$styles = array();
foreach($dirs as $info) {
	$styles[] = $info['name'];
}
if (!isset($_SESSION[STYLE])) {
	$_SESSION[STYLE] = null;
} else {
	// keep it as is
}
$_SESSION[STYLE] = Check::getInputIn(isset($_GET[STYLE]) ? $_GET[STYLE] : $_SESSION[STYLE], $styles, "default");

if (TEST_MODE_ACTIVATED && Url::getCurrentUrl()->hasQueryVar('setdate')) {
	$_SESSION[CURRENT_TIME] = Url::getCurrentUrl()->getQueryVar('setdate');
} else {
	$_SESSION[CURRENT_TIME] = time();
}

/**********************************\
             DATABASE
\**********************************/

$url = Url::getCurrentUrl();
if (TEST_MODE_ACTIVATED && $url->hasQueryVar('clearDB')) {
	Database::getDefaultDatabase()->clear();
	// TODO move the default loading here
	$url->removeQueryVar('clearDB');
	header('Location: '.$url->toString());
	exit();
}

/**********************************\
            TEST FEATURES
\**********************************/

if (TEST_MODE_ACTIVATED) {
	$features = new SimpleBlockComponent();
	$features->setClass('testFeatures');
	$features->addComponent('Testing mode : ');
	
	$link = new Link(Url::getCurrentUrl(), 'clear DB');
	$link->getUrl()->setQueryVar('clearDB');
	$features->addComponent($link);
	
	$link = new Link(Url::getCurrentUrl(), 'PHP info');
	if (Url::getCurrentUrl()->hasQueryVar('phpinfo')) {
		$link->getUrl()->removeQueryVar('phpinfo');
		$link->setClass('reverse');
	} else {
		$link->getUrl()->setQueryVar('phpinfo');
	}
	$features->addComponent($link);
	
	$link = new Link(Url::getCurrentUrl(), 'Go in the future');
	if (Url::getCurrentUrl()->hasQueryVar('setdate')) {
		$link->getUrl()->removeQueryVar('setdate');
		$link->setClass('reverse');
	} else {
		$link->getUrl()->setQueryVar('setdate', PHP_INT_MAX);
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
	$features->addComponent(date("Y-m-d H:i:s", $_SESSION[CURRENT_TIME]));
	
	$features->addComponent('<br/>');
	
	$branches = array();
	exec('git branch', $branches);
	foreach($branches as $branch) {
		if (preg_match("#^\* .*$#", $branch)) {
			$features->addComponent(substr($branch, 2));
			break;
		}
	}
	
	$features->addComponent(' - ');
	$features->addComponent(htmlspecialchars(exec('git log -1 --pretty=format:"%h - %s"')));
	
	define('TESTING_FEATURE', $features->getCurrentHTML());
}

?>
