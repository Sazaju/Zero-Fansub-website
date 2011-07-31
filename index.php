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
if (TEST_MODE_ACTIVATED) {
	define('TESTING_FEATURE', 'Testing mode : <a href="'.$_SERVER['PHP_SELF'].'?clearDB'.'">clear DB</a>');
}

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

/**********************************\
             DATABASE
\**********************************/

Database::createDefaultDatabase(TEST_MODE_ACTIVATED);
if (TEST_MODE_ACTIVATED && isset($_GET['clearDB'])) {
	Database::getDefaultDatabase()->clear();
	header('Location: '.$_SERVER['PHP_SELF']);
	exit();
}

/**********************************\
           PAGE BUILDING
\**********************************/

$pageId = Check::getInputIn(isset($_GET['page']) ? $_GET['page'] : null, array('project', 'projectList'), 'home');
$page = new SimpleBlockComponent();
$page->setId('page');

if ($pageId == 'home') {
	$page->addComponent(new News(3));
	$page->addComponent(new ShortNews(2));
	$page->addComponent(new ShortNews(1));
	$page->addComponent(new ShortNews(0));
}

else if ($pageId == 'project') {
	$projectId = Check::getNumericInput(isset($_GET['id']) ? $_GET['id'] : null);
	$page->addComponent(new Project($projectId));
}

else if ($pageId == 'projectList') {
	$page->addComponent(new PageTitle('Projets'));
	$page->addComponent(new ProjectList());
}

/**********************************\
        RIGHT PANEL BUILDING
\**********************************/

$rightPanel = new SimpleBlockComponent();
$rightPanel->setId('right_panel');

$logo = new Image(1);
$logo->load();
$logo->setId('logo');
$rightPanel->addComponent($logo);

$menu = new Menu();
$menu->setId('menu');
$menu->addEntry(new IndexLink('', 'Accueil'));
$menu->addEntry(new IndexLink('page=projectList', 'Projets'));
$rightPanel->addComponent($menu);

/**********************************\
         QUICKBAR BUILDING
\**********************************/

$row = Database::getDefaultDatabase()->getConnection()->query('select * from "property" where id = "quickbar"')->fetch();
$quickText = new SimpleTextComponent();
$quickText->setContent($row['value']);
$quick = new SimpleBlockComponent();
$quick->setId('quickbar');
$quick->addComponent($quickText);

/**********************************\
          FOOTER BUILDING
\**********************************/

$row = Database::getDefaultDatabase()->getConnection()->query('select * from "property" where id = "footer"')->fetch();
$footerText = new SimpleTextComponent();
$footerText->setContent($row['value']);
$footer = new SimpleBlockComponent();
$footer->setId('footer');
$footer->addComponent($footerText);

/**********************************\
          BODY MERGING
\**********************************/

$main = new SimpleBlockComponent();
$main->setId('main');
$main->addComponent($page);
$main->addComponent($rightPanel);
$main->addComponent(new Pin());
$main->addComponent($quick);
$main->addComponent($footer);

/**********************************\
        HTML PAGE CREATING
\**********************************/

$builder = new HtmlBuilder();
$row = Database::getDefaultDatabase()->getConnection()->query('select * from "property" where id = "title"')->fetch();
$builder->setTitle($row['value']);
$builder->addComponent($main);
if (TEST_MODE_ACTIVATED) {
	$warning = new SimpleTextComponent();
	$warning->setContent(TESTING_FEATURE);
	$warning->setStyle('float:left;width:100%;text-align:center;border:1px solid #FF0000;');
	$builder->addComponent($warning);
}

/**********************************\
            META DATA
\**********************************/

/*
	we give a "text/html" content to be compatible with most of the
	explorers, it should be "application/xhtml+xml". See this link :
	
	http://www.pompage.net/traduction/declarations
*/
$builder->addMeta(array(
		'http-equiv' => 'Content-Type',
		'content' => 'text/html; charset=UTF-8' // TODO iso-8859-1 ?
));
$builder->addMeta(array(
		'http-equiv' => 'Content-Language',
		'content' => 'fr'
));
$builder->addMeta(array(
		'http-equiv' => 'Content-Script-Type',
		'content' => 'text/javascript'
));
$builder->addMeta(array(
		'http-equiv' => 'Content-Style-Type',
		'content' => 'text/css'
));

$builder->addMeta(array(
		'name' => 'DC.Language',
		'scheme' => 'RFC3066',
		'content' => 'fr'
));
$builder->addMeta(array(
		'name' => 'author',
		'content' => 'The db0 company, http://db0.fr Contact db0company@gmail.com'
));
$builder->addMeta(array(
		'name' => 'copyright',
		'content' => 'The db0 company, Copyright 2010, Tout droits résérvés. Si du contenu vous appartient et que vous souhaitez qu\'il soit retiré du 	site, demandez-le par mail db0company@gmail.com'
));
$builder->addMeta(array(
		'name' => 'Keywords',
		'content' => '' // TODO
));
$builder->addMeta(array(
		'name' => 'description',
		'content' => '' // TODO
));

/**********************************\
            LINK DATA
\**********************************/

$builder->addLink(array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'href' => 'http://fonts.googleapis.com/css?family=Molengo'
));
$builder->addLink(array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'href' => 'http://fonts.googleapis.com/css?family=Droid Sans'
));
$builder->addLink(array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'href' => 'http://fonts.googleapis.com/css?family=Cantarell'
));
$builder->addLink(array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => 'screen',
		'title' => 'Normal',
		'href' => 'style.css'
));
$builder->addLink(array(
		'rel' => 'shortcut icon',
		'href' => 'fav.ico'
));

/**********************************\
         GENERATE & DISPLAY
\**********************************/

$builder->generateHtml();
$html = $builder->getHtml();

// TODO debugging
$html = Format::indentHtml($html);
// TODO /debugging

echo $html;
?>
