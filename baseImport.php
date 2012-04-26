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

function __autoload($className) {
	$file = findFile($className.'.php', 'class');
	if ($file != null) {
		$chunks = explode("/", $file);
		if (TEST_MODE_ACTIVATED && in_array("old", $chunks)) {
			echo Debug::createWarningTag("Old script used: $file");
		}
		include $file;
	} else {
		throw new Exception($className." not found");
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
            TEST FEATURES
\**********************************/

if (TEST_MODE_ACTIVATED) {
	$features = new SimpleBlockComponent();
	$features->setClass('testFeatures');
	$features->addComponent('Testing mode : ');
	
	$link = new LinkComponent(Url::getCurrentUrl(), 'clear DB');
	if (DB_USE) {
		$link->getUrl()->setQueryVar('clearDB');
	} else {
		$link->getUrl()->setUrl('#');
		$link->setClass('deactivated');
	}
	$features->addComponent($link);
	
	$link = new LinkComponent(Url::getCurrentUrl(), 'PHP info');
	if (Url::getCurrentUrl()->hasQueryVar('phpinfo')) {
		$link->getUrl()->removeQueryVar('phpinfo');
		$link->setClass('reverse');
	} else {
		$link->getUrl()->setQueryVar('phpinfo');
	}
	$features->addComponent($link);
	
	$link = new LinkComponent(Url::getCurrentUrl(), 'deactivate testing mode');
	if (Url::getCurrentUrl()->hasQueryVar('noTest')) {
		$link->getUrl()->removeQueryVar('noTest');
		$link->setClass('reverse');
	} else {
		$link->getUrl()->setQueryVar('noTest');
	}
	$features->addComponent($link);
	
	$features->addComponent('<br/>');
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
?>
