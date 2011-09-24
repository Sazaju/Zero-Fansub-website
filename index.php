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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
  <title>Zéro ~fansub~ :: Le Site Officiel v3.1</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="Content-Language" content="fr" />
  <meta http-equiv="Content-Script-Type" content="text/javascript" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta name="DC.Language" scheme="RFC3066" content="fr" />
  <link rel="stylesheet" href="style.css" type="text/css" media="screen" title="Normal" />  
  <link rel="icon" type="image/gif" href="fav.gif" />
  <link rel="shortcut icon" href="fav.ico" />
  <script type="text/javascript" language="Javascript">
    function show(nom_champ)
    {
    if(document.getElementById)
    {
    tabler = document.getElementById(nom_champ);
    if(tabler.style.display=="none")
    {
    tabler.style.display="";
    }
    else
    {
    tabler.style.display="none";
    }
    }
    }
  </script>
  <SCRIPT LANGUAGE="JavaScript">
    var nbimage= 200;
    var width;
    var height;
    var url;
    var alte;
    function banniere()
    {
    numimage= Math.round(Math.random()*(nbimage-1)+1);
    if (numimage <= 10)
{
gotosite = "";
url = "images/hautmenu/konata.png";
alte = "Konata";
}
if (numimage > 10 && numimage <= 20)
{
gotosite = "index.php?page=series/kimikiss";
url = "images/hautmenu/futami.png";
alte = "Futami";
}
if (numimage > 20 && numimage <= 30)
{
gotosite = "index.php?page=series/hitohira";
url = "images/hautmenu/mugi.png";
alte = "Mugi";
}
if (numimage > 30 && numimage <= 40)
{
gotosite = "index.php?page=series/kodomooav";
url = "images/hautmenu/rin.png";
alte = "Rin";
}
if (numimage > 40 && numimage <= 50)
{
gotosite = "index.php?page=series/toradora";
url = "images/hautmenu/taiga.png";
alte = "Taiga";
}
if (numimage > 50 && numimage <= 60)
{
gotosite = "index.php?page=series/genshiken";
url = "images/hautmenu/ohno.png";
alte = "Ohno";
}
if (numimage > 60 && numimage <= 70)
{
gotosite = "index.php?page=series/sketchbook";
url = "images/hautmenu/sora.png";
alte = "Sora";
}
if (numimage > 70 && numimage <= 80)
{
gotosite = "index.php?page=series/kujibiki";
url = "images/hautmenu/kujian.png";
alte = "Tokino-présidente";
}
if (numimage > 80 && numimage <= 90)
{
gotosite = "index.php?page=series/mermaid";
url = "images/hautmenu/lucia.png";
alte = "Lucia";
}
if (numimage > 90 && numimage <= 100)
{
gotosite = "index.php?page=series/kodomoo";
url = "images/hautmenu/rin2.png";
alte = "Rin";
}
if (numimage > 100 && numimage <= 110)
{
gotosite = "index.php?page=series/kissxsis";
url = "images/hautmenu/ako.png";
alte = "Kiss X Sis";
}
if (numimage > 110 && numimage <= 120)
{
gotosite = "index.php?page=series/kodomoo";
url = "images/hautmenu/rin.png";
alte = "Rin";
}
if (numimage > 120 && numimage <= 130)
{
gotosite = "index.php?page=series/kodomo";
url = "images/hautmenu/rin.png";
alte = "Rin";
}
if (numimage > 130 && numimage <= 140)
{
gotosite = "";
url = "images/hautmenu/pika.png";
alte = "Pikachu";
}
if (numimage > 140 && numimage <= 150)
{
gotosite = "index.php?page=series/canaan";
url = "images/hautmenu/canaan.png";
alte = "Canaan";
}
if (numimage > 150 && numimage <= 160)
{
gotosite = "index.php?page=series/training";
url = "images/hautmenu/isshoni.png";
alte = "L'entrainement avec Hinako";
}
if (numimage > 160 && numimage <= 170)
{
gotosite = "index.php?page=series/kanamemo";
url = "images/hautmenu/kanamemo.png";
alte = "Kanamemo";
}
if (numimage > 170 && numimage <= 180)
{
gotosite = "index.php?page=series/kannagi";
url = "images/hautmenu/kannagi.png";
alte = "Kannagi";
}
if (numimage > 180 && numimage <= 190)
{
gotosite = "index.php?page=series/potemayo";
url = "images/hautmenu/potemayo.png";
alte = "Potemayo";
}
if (numimage > 190 && numimage <= 200)
{
gotosite = "index.php?page=series/tayutama";
url = "images/hautmenu/tayutama.png";
alte = "Tayutama Kiss on my deity";
}
if (numimage > 200 )
{
gotosite = "index.php?page=series/mariaholic";
url = "images/hautmenu/mariya.png";
alte = "Maria Holic";
}
if(gotosite != "")
	{
	document.write ('<A HREF="' + gotosite + '">');	
	}
document.write('<IMG SRC="' + url + '" ALT="' + alte + '" BORDER=0>')
if(gotosite != "")
	{
	document.write('</A>')
	}
}
</SCRIPT>

</head>


<body>
  <div id="main">
    <div id="header">
      <div id="pageright">
	<div id="partenaires">
	  <div class="partenaires">
	    <ul>
	      <li>db0 company</li>
	      <li>
		<a href="http://www.anime-ultime.net/part/Site-93" target="_blank">
		  <img src="images/partenaires/anime-ultime.jpg" border="0" alt="Anime-ultime" />
		</a>
	      </li>
	    </ul>
	 
	  </div><!--partenaires-->
	  
	  <div class="partenaires">
	<ul>
	  <li>Fansub potes</li>
	  
	  <li><a href="http://finalfan51.free.fr/ffs/" target="_blank"><img src="images/partenaires/finalfan.png" border="0" alt="FinalFan sub" /></a></li>
	  <li><a href="http://www.mangas-arigatou.fr/" target="_blank"><img src="images/partenaires/mangas_arigatou.png" border="0" alt="Mangas Arigatou" /></a></li>
	  <li><a href="http://www.kanaii.com" target="_blank"><img src="images/partenaires/kanaii.png" border="0" alt="Kanaii" /></a></li>
	  <li><a href="http://kouhaiscantrad.wordpress.com" target="_blank"><img src="images/partenaires/kouhai.jpg" border="0" alt="Kouhai Scantrad" /></a></li>
	  <li><a href="http://samazamablog.wordpress.com/" target="_blank"><img src="images/partenaires/samazama.gif" border="0" alt="Samazama na Koto" /></a></li>
	  <li><a href="http://www.sky-fansub.com/" target="_blank"><img src="images/partenaires/sky.png" border="0" alt="Sky-fansub" /></a></li>

	</ul>
	
	  </div>
	  <div class="partenaires">
	    <ul>
	      <li>Liens</li>
	      <li><a href="http://animeka.com/fansub/teams/zero.html" target="_blank"><img src="images/partenaires/animeka.jpg" border="0" alt="Animeka" /></a></li>
	    </ul>
	    
	  </div>
	  <div class="partenaires">
	    <ul>
	      <li><a href="index.php?page=partenariat">Devenir partenaires</a></li>
	    </ul>
	    
	  </div>
	</div>
	
      </div>
      <div id="pageleft">

	<div id="menu">
	  <div id="menutop"><SCRIPT language="JavaScript">banniere();</SCRIPT></div>
	  <div class="menu">
	    <ul>
	      <li><a href="index.php">Accueil</a></li>
	      <li><a href="irc://irc.Fansub-IRC.eu/zero" target="_blank">IRC</a></li>	
	      <li><a href="http://forum.zerofansub.net" target="_blank">Forum</a></li>
	      <li><a href="http://twitter.com/db0company" target="_blank">Twitter</a></li>
	      <li><a href="#" onclick="window.open('radio','radio','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=280, height=380, left=200, top=200');return(false)">Radio</a></li>
	      <li><a href="index.php?page=contact">Contact</a></li>
	      <li><a href="index.php?page=about">À propos...</a></li>
	    </ul>
	  </div>
	  <div class="menu">
	    <ul>
	      <li><a href="index.php?page=series" style="font-size: 1.5em;">Projets</a></li>
      <li><a href="index.php?page=series">T&eacute;l&eacute;chargements</a></li>
	      <li><a href="index.php?page=team">L'&eacute;quipe</a></li>
	      <li><a href="http://forum.zerofansub.net/p32750.htm" target="_blank">Avancement</a></li>
	      <li><a href="http://forum.zerofansub.net/f21-RECRUTEMENT-Entrer-dans-la-team-de-fansub.htm" target="_blank">Recrutement</a></li>
	      <li><a href="http://www.bt-anime.net/index.php?page=tracker&team=Z%e9ro" target="_blank">Torrent</a></li>
	      <li><a href="index.php?page=xdcc">XDCC</a></li>
	    </ul>
	  </div>	
	  <div class="menu">
	    <ul>
	      <li><a href="index.php?page=dossiers">Dossiers</a></li>
	      <li><a href="galerie/index.php?spgmGal=Zero_fansub/Images" target="_blank">Images</a></li>
	      <li><a href="index.php?page=havert">Hentaï</a></li>
	    </ul>
	  </div>
	  <div class="menu">
	    <ul>
	      <li>Serveur/mois : 173,39 &euro;</li>
	      <li>Dons du mois : 20 &euro;</li>
	      <li><a  style="font-size: 1.2em;" href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=mba_06%40hotmail%2efr&item_name=Zero&no_shipping=0&no_note=1&tax=0&currency_code=EUR&lc=FR&bn=PP%2dDonationsBF&charset=UTF%2d8" target="_blank">Faire un don</a></li>
	      <li><a href="http://forum.zerofansub.net/t552.htm#p32300" target="_blank">En savoir +</a></li>
	    </ul>
	  </div>
	</div>
	<div id="page">
	  <div id="sortie">
	  <?php
if (isset($_GET['sorties']))
{
$page = $_GET['sorties'];
}
else
{
$page = "sortie";
}
require("sorties/sortie.php");
?>
	  </div>
	  <div id="pageContent"><!-- TODO remove this level when all pages will be translated in object PHP -->
	    <!-- COMCLICK France : 468 x 60 -->
	    <!--<iframe src="http://fl01.ct2.comclick.com/aff_frame.ct2?id_regie=1&num_editeur=14388&num_site=3&num_emplacement=1"
			WIDTH="468" HEIGHT="60" marginwidth="0" marginheight="0" hspace="0"
			vspace="0" frameborder="0" scrolling="no" bordercolor="#000000">
			</iframe>-->
	    <!-- FIN TAG -->

	    <?php if (isset($_GET['page']))
{
$page = $_GET['page'];
}
else
{
$page = "home";
}
if (file_exists("pages/$page.php")) {
require_once("pages/$page.php");
}
else {
require_once("pages/home.php");
}
PageContent::getInstance()->writeNow();
?>
	</div>
	</div>


      </div>
    </div>
    <div id="footer"></div>
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
      } catch(err) {}</script>
  </body>
</html>
