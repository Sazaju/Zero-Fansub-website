<?php
/*
	This file is the root of the website. Here is the global code generating the
	complete page.
*/

require_once("php/constants.php");
require_once("php/class/htmlbuilder.php");
require_once("php/class/htmlcomponent/simpleblockcomponent.php");
require_once("php/class/htmlcomponent/simpletextcomponent.php");
require_once("php/class/htmlcomponent/paragraph.php");
require_once("php/class/htmlcomponent/menu.php");
require_once("php/class/htmlcomponent/news.php");
require_once("php/util/format.php");

$menu = new Menu();
$menu->setId('menu');
$menu->addEntry('entry 1', 'link 1');
$menu->addEntry('entry 2', 'link 2');
$menu->addEntry('entry 3', 'link 3');

$news = new News();
$imageNews = new Image();
$imageNews->setSource('images/news/test_news.jpg');
$imageNews->setAlternative('Random Test News Mitsudomoe');
$news->setImage($imageNews);
$news->setTitle('[ fansub ] Mitsudomoe épisode 01');
$news->setText('
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Donec vitae porttitor arcu. Proin non condimentum lorem.
                Aenean in ante a ligula pulvinar pellentesque in vel
                ipsum. Nullam metus sapien, faucibus sit amet tincidunt
                nec, ultrices ut tellus. Quisque varius pharetra felis,
                eget pretium quam mattis a. Mauris at turpis vel arcu
                molestie vulputate ac sit amet lorem. In hac habitasse
                platea dictumst. Quisque pharetra neque id eros
                elementum facilisis. Nullam augue nulla, laoreet ut
                vulputate ac, auctor id enim. Vivamus varius eleifend
                lectus, a dignissim ante blandit eget. Donec congue,
                quam non pharetra faucibus, nunc nisi feugiat augue,
                nec sollicitudin quam lorem eget augue. In fringilla,
                felis ac pharetra convallis, eros mi pulvinar velit, ac
                congue quam turpis et dolor. In pellentesque tincidunt
                purus, eget laoreet orci semper in. Sed pulvinar justo
                nunc, sit amet eleifend tellus. Donec non elit tellus.
              </p>
              <p>
                Integer in arcu massa, id venenatis mauris. Nulla non
                felis dui. Integer nec ipsum nisi, sed commodo purus.
                Pellentesque habitant morbi tristique senectus et netus
                et malesuada fames ac turpis egestas. Donec in blandit
                diam. Suspendisse vel arcu purus, nec rhoncus lorem.
                Etiam ac consectetur lorem. Aliquam fringilla, velit sit
                amet ornare tempor, turpis lacus tristique orci, ut
                porta justo diam id sem. Etiam imperdiet nibh nec nibh
                eleifend ut accumsan leo dapibus. Etiam sem leo, egestas
                sed consequat vel, euismod quis metus. Ut gravida
                placerat metus sed tincidunt. Integer lacinia viverra
                dolor, non porta tortor aliquam a. Donec sodales justo
                eget magna sollicitudin blandit. Ut molestie, augue in
                pretium condimentum, orci erat facilisis tortor, nec
                auctor enim felis sed tellus. Vestibulum blandit massa
                eget mi tincidunt a aliquet dolor convallis. Nullam et
                magna vitae est imperdiet mattis. Ut semper urna tortor.
              </p>
');

$builder = new HtmlBuilder();

/**********************************\
           HTML CONTENT
\**********************************/

$main = new SimpleBlockComponent();
$main->setId('main');
$main->addComponent($menu);
$page = new SimpleBlockComponent();
$page->setId('page');
$page->addComponent($news);
$main->addComponent($page);
$footer = new SimpleBlockComponent();
$footer->setId('footer');
$footerText = new SimpleTextComponent();
$footerText->addText('crédits blabla');
$footer->addComponent($footerText);
$main->addComponent($footer);
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
            OTHER DATA
\**********************************/

$builder->setTitle(TITLE);

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
