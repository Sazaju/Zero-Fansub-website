<?php
/*
	This file is the root of the website. Here is the global code generating the
	complete page.
*/

define('TEST_MODE_ACTIVATED', 
		in_array($_SERVER["SERVER_NAME"], array('127.0.0.1', 'localhost', 'to-do-list.me', 'sazaju.dyndns-home.com'), true));
if (TEST_MODE_ACTIVATED) {
	define('TESTING_FEATURE', 'TESTING : <a href="'.$_SERVER['PHP_SELF'].'?clearDB'.'">clear DB</a>');
}

/**********************************\
              IMPORTS
\**********************************/

require_once("php/class/htmlbuilder.php");
require_once("php/class/image.php");
require_once("php/class/news.php");
require_once("php/class/database/database.php");
require_once("php/class/xhtml/simpleblockcomponent.php");
require_once("php/class/xhtml/simpletextcomponent.php");
require_once("php/class/xhtml/menu.php");
require_once("php/util/format.php");
require_once("php/util/check.php");

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
		echo TESTING_FEATURE."<br/>An error as occured : ".$exception;
		phpinfo();
	}
}

set_error_handler("error_handler");
set_exception_handler('exception_handler');

/**********************************\
             DATABASE
\**********************************/

$database = new Database(TEST_MODE_ACTIVATED);
if (TEST_MODE_ACTIVATED && isset($_GET['clearDB'])) {
	$database->clearDatabase();
	$database->initializeDatabase();
}

/**********************************\
           PAGE BUILDING
\**********************************/

$pageId = checkInput(isset($_GET['page']) ? $_GET['page'] : null, array('projects'), 'home');
$page = new SimpleBlockComponent();
$page->setId('page');

if ($pageId == 'home') {
	$news0 = new News($database, 0);
	$news0->load();
	$html = $news0->getHtmlComponent();
	$html->setClass('news');
	$page->addComponent($html);

	$news1 = new News($database, 0);
	$news1->load();
	$html = $news1->getHtmlComponent();
	$html->setClass('short_news');
	$html->setText(truncateText(strip_tags($html->getText()), 150));
	$page->addComponent($html);

	$news2 = new News($database, 0);
	$news2->load();
	$html = $news2->getHtmlComponent();
	$html->setClass('short_news');
	$html->setText(truncateText(strip_tags($html->getText()), 150));
	$page->addComponent($html);

	$news3 = new News($database, 0);
	$news3->load();
	$html = $news3->getHtmlComponent();
	$html->setClass('short_news');
	$html->setText(truncateText(strip_tags($html->getText()), 150));
	$page->addComponent($html);
}

else if ($pageId == 'projects') {
	$project = new SimpleTextComponent();
	$project->setContent('Projet XXX');
	$page->addComponent($project);
}

/**********************************\
        RIGHT PANEL BUILDING
\**********************************/

$rightPanel = new SimpleBlockComponent();
$rightPanel->setId('right_panel');

$logo = new Image($database, 1);
$logo->load();
$html = $logo->getHtmlComponent();
$html->setId('logo');
$rightPanel->addComponent($html);

$menu = new Menu();
$menu->setId('menu');
$menu->addEntry('Accueil', $_SERVER['PHP_SELF']);
$menu->addEntry('Projets', $_SERVER['PHP_SELF'].'?'.'page=projects');
$rightPanel->addComponent($menu);

/**********************************\
         QUICKBAR BUILDING
\**********************************/

$row = $database->getConnection()->query('select * from "property" where id = "quickbar"')->fetch();
$quickText = new SimpleTextComponent();
$quickText->setContent($row['value']);
$quick = new SimpleBlockComponent();
$quick->setId('quickbar');
$quick->addComponent($quickText);

/**********************************\
          FOOTER BUILDING
\**********************************/

$row = $database->getConnection()->query('select * from "property" where id = "footer"')->fetch();
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
$row = $database->getConnection()->query('select * from "property" where id = "title"')->fetch();
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
$html = formatHtml($html);
// TODO /debugging

echo $html;
?>
