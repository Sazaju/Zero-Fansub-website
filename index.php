<?php
/*
	This file is the root of the website. Here is the global code generating the
	complete page.
*/

define("TEST_MODE_ACTIVATED", 
		in_array($_SERVER["SERVER_NAME"], array('127.0.0.1', 'localhost'), true));

/**********************************\
              IMPORTS
\**********************************/

require_once("php/class/htmlbuilder.php");
require_once("php/class/database.php");
require_once("php/class/htmlcomponent/simpleblockcomponent.php");
require_once("php/class/htmlcomponent/simpletextcomponent.php");
require_once("php/class/htmlcomponent/menu.php");
require_once("php/class/htmlcomponent/news.php");
require_once("php/util/format.php");

/**********************************\
       CRITICAL CONFIGURATION
\**********************************/

function exception_handler($exception) {
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

if (!TEST_MODE_ACTIVATED) {
	set_exception_handler('exception_handler');
	set_error_handler('exception_handler');
}

/**********************************\
             DATABASE
\**********************************/

$database = new Database(TEST_MODE_ACTIVATED);
$database->clearDatabase();
$database->initializeDatabase();

/**********************************\
           PAGE BUILDING
\**********************************/

$menu = new Menu();
$menu->setId('sub_menu');
$menu->addEntry('entry 1', 'link 1');
$menu->addEntry('entry 2', 'link 2');
$menu->addEntry('entry 3', 'link 3');
$temp = new SimpleBlockComponent();
$temp->setId('menu');
$temp->addComponent($menu);
$menu = $temp;

$page = new SimpleBlockComponent();
$page->setId('page');
$result = $database->getConnection()->query('select * from "news"');
foreach  ($result as $row) {
	$news = new News();
	$row2 = $database->getConnection()->query('select * from "image" where id = '.$row['image_id'])->fetch();
	$imageNews = new Image();
	$imageNews->setSource($row2['url']);
	$imageNews->setAlternative($row2['title']);
	$news->setImage($imageNews);
	$news->setTitle($row['title']);
	$news->setText($row['text']);
}
$page->addComponent($news);

$row = $database->getConnection()->query('select * from "property" where id = "footer"')->fetch();
$footerText = new SimpleTextComponent();
$footerText->setContent($row['value']);
$footer = new SimpleBlockComponent();
$footer->setId('footer');
$footer->addComponent($footerText);

$main = new SimpleBlockComponent();
$main->setId('main');
$main->addComponent($menu);
$main->addComponent($page);
$main->addComponent($footer);

$builder = new HtmlBuilder();
$row = $database->getConnection()->query('select * from "property" where id = "title"')->fetch();
$builder->setTitle($row['value']);
if (TEST_MODE_ACTIVATED) {
	$warning = new SimpleTextComponent();
	$warning->setContent('TESTING');
	$warning->setStyle('display:block;text-align:center;border:1px solid #FF0000;');
	$builder->addComponent($warning);
}
$builder->addComponent($main);

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
