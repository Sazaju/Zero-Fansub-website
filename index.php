<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>Z&eacute;ro ~fansub~ :: Le Site Officiel</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Language" content="fr" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="DC.Language" scheme="RFC3066" content="fr" />
<link rel="stylesheet" href="style3.0.css" type="text/css" media="screen" title="Normal" />
<link rel="alternate" title="Zero news" href="http://zerofansub.feedxs.com/zero.rss" type="application/rss+xml" />
<link rel="icon" type="image/gif" href="/fav.gif">
<link rel="shortcut icon" href="/fav.ico">

<! --- Javascript bandeau défilant -- >

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
var nbimage= 150;
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
url = "images/interface/hautmenu/konata.png";
alte = "Konata";
}
if (numimage > 10 && numimage <= 20)
{
gotosite = "index.php?page=series/kimikiss";
url = "images/interface/hautmenu/futami.png";
alte = "Futami";
}
if (numimage > 20 && numimage <= 30)
{
gotosite = "index.php?page=series/hitohira";
url = "images/interface/hautmenu/mugi.png";
alte = "Mugi";
}
if (numimage > 30 && numimage <= 40)
{
gotosite = "http://www.kojikan.fr/";
url = "images/interface/hautmenu/rin.png";
alte = "Rin";
}
if (numimage > 40 && numimage <= 50)
{
gotosite = "index.php?page=series/toradora";
url = "images/interface/hautmenu/taiga.png";
alte = "Taiga";
}
if (numimage > 50 && numimage <= 60)
{
gotosite = "index.php?page=series/genshiken";
url = "images/interface/hautmenu/ohno.png";
alte = "Ohno";
}
if (numimage > 60 && numimage <= 70)
{
gotosite = "index.php?page=series/sketchbook";
url = "images/interface/hautmenu/sora.png";
alte = "Sora";
}
if (numimage > 70 && numimage <= 80)
{
gotosite = "index.php?page=series/kujibiki";
url = "images/interface/hautmenu/kujian.png";
alte = "Tokino-présidente";
}
if (numimage > 80 && numimage <= 90)
{
gotosite = "index.php?page=series/mermaid";
url = "images/interface/hautmenu/lucia.png";
alte = "Lucia";
}
if (numimage > 90 && numimage <= 100)
{
gotosite = "index.php?page=series/kodomoo";
url = "images/interface/hautmenu/rin2.png";
alte = "Rin";
}
if (numimage > 100 && numimage <= 110)
{
gotosite = "index.php?page=series/kissxsis";
url = "images/interface/hautmenu/ako.png";
alte = "Kiss X Sis";
}
if (numimage > 110 && numimage <= 120)
{
gotosite = "index.php?page=series/guardian";
url = "images/interface/hautmenu/hina.png";
alte = "Guardian Hearts";
}
if (numimage > 120 && numimage <= 130)
{
gotosite = "index.php?page=series/kurokami";
url = "images/interface/hautmenu/kuro.png";
alte = "Kurokami";
}
if (numimage > 130 && numimage <= 140)
{
gotosite = "";
url = "images/interface/hautmenu/pika.png";
alte = "Pikachu";
}
if (numimage > 140 )
{
gotosite = "index.php?page=series/mariaholic";
url = "images/interface/hautmenu/mariya.png";
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


<! --- Javascript infobulle -- >



<script language="javascript" type="text/javascript">
<!--
function GetId(id)
{
return document.getElementById(id);
}
var i=false; // La variable i nous dit si la bulle est visible ou non
 
function move(e) {
  if(i) {  // Si la bulle est visible, on calcul en temps reel sa position ideale
    if (navigator.appName!="Microsoft Internet Explorer") { // Si on est pas sous IE
    GetId("curseur").style.left=e.pageX + 5+"px";
    GetId("curseur").style.top=e.pageY + 10+"px";
    }
    else { // Modif proposé par TeDeum, merci à  lui
    if(document.documentElement.clientWidth>0) {
GetId("curseur").style.left=20+event.x+document.documentElement.scrollLeft+"px";
GetId("curseur").style.top=10+event.y+document.documentElement.scrollTop+"px";
    } else {
GetId("curseur").style.left=20+event.x+document.body.scrollLeft+"px";
GetId("curseur").style.top=10+event.y+document.body.scrollTop+"px";
         }
    }
  }
}
 
function montre(text) {
  if(i==false) {
  GetId("curseur").style.visibility="visible"; // Si il est cacher (la verif n'est qu'une securité) on le rend visible.
  GetId("curseur").innerHTML = text; // on copie notre texte dans l'élément html
  i=true;
  }
}
function cache() {
if(i==true) {
GetId("curseur").style.visibility="hidden"; // Si la bulle est visible on la cache
i=false;
}
}
document.onmousemove=move; // dès que la souris bouge, on appelle la fonction move pour mettre à jour la position de la bulle.
//-->
</script>








<SCRIPT language=javascript>
function popup(page,nom,option) {
window.open(page,nom,option); }
</SCRIPT>









</head>


<body style="direction: ltr;">
<table align="center"><tr><td>
<div id="curseur" class="infobulle"></div>
<div id="menuvertical">
		<p><br /><br /><br /><br /><SCRIPT language="JavaScript">banniere();</SCRIPT></p>
	<div class="sousmenu">
	<ul>
		<li><a href="index.php">Accueil</a></li>
		<li><a href="irc://irc.Fansub-IRC.eu/zero" target="_blank">IRC</a></li>	
		<li><a href="http://zero.xooit.fr" target="_blank">Forum</a></li>
		<li><a href="http://zerofansub.feedxs.com/zero.rss" target="_blank">RSS</a></li>
		<li><A HREF="#" onClick="window.open('radio','radio','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=280, height=350, left=200, top=200');return(false)">Radio</a></li>

		<li><a href="index.php?page=contact">Contact</a></li>
		<li><a href="index.php?page=dons">Dons</a></li>
		<li><a href="index.php?page=about">À propos...</a></li>
	</ul>
	</div>
		<p><img src="images/interface/bas_menu.png" /></p>
		<p><img src="images/interface/fansub.png" /></p>

	<div class="sousmenu">
	<ul>
		<li><a href="index.php?page=team">La team</a></li>
		<li><a href="index.php?page=recrutement">Recrutement</a></li>
		<li><a href="index.php?page=avancement">Avancement</a></li>
		<li><a href="index.php?page=series" style="font-size: 1.5em;">Projets</a></li>
		<li><a href="index.php?page=dl">Télécharger</a></li>
		<li><a href="http://bt.fansub-irc.eu/tracker_team/index.php?id_tracker=26" target="_blank">Torrent</a></li>
		<li><a href="index.php?page=xdcc">XDCC</a></li>
		<li><a href="index.php?page=kanaiiddl">Kanaii DDL</a></li>
	</ul>
	</div>
		<p><img src="images/interface/bas_menu.png" /></p>
		<p><a href="#" onClick="show('i2');return(false)" id="plus"><img src="images/interface/bonuss.png" /></a></p>
<div id="i2" style="display:none; padding: 0px;">
	<div class="sousmenu">
	<ul>	
	
		<li><a href="galerie/index.php?spgmGal=Zero_fansub/Images" target="_blank">Images</a></li>
		<li><a href="galerie/index.php?spgmGal=Zero_fansub/Wallpaper" target="_blank">Wallpaper</a></li>
		<li><a href="index.php?page=ost">OST</a></li>
		<li><a href="index.php?page=karaoke">Karaokés</a></li>
		<li><a href="indexH.php">H-Zone</a></li>
	</ul>
	</div>
</div>
		<p><img src="images/interface/bas_menu.png" /></p>
<script type="text/javascript"><!--
google_ad_client = "pub-1841682561759438";
/* zero menu bis */
google_ad_slot = "2907189565";
google_ad_width = 125;
google_ad_height = 125;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>




<div id="contenu">

<table class="haut" margin="0px" cellspacing="0"><tr class="lign"><td style="width: 694px;">

<table align="center" border="0" cellspacing="20">
    <tr>
<?php if (isset($_GET['sorties']))
{
$page = $_GET['sorties'];
}
else
{
$page = "sortie";
}
if (file_exists("sorties/$sortie.php")) {
require("sorties/$sortie.php");
}
else {
require("sorties/sortie.php");
}
?>
    </tr>
</table>

<?php if (isset($_GET['page']))
{
$page = $_GET['page'];
}
else
{
$page = "home";
}
if (file_exists("pages/$page.php")) {
require("pages/$page.php");
}
else {
require("pages/home.php");
}
?>


</td><td class="droit" valign="top"><img src="images/interface/logo.png" /><br /><br /><br />	<div class="sousmenu">
<div class="partenaires" height="550">


<a href="index.php?page=dakko"><img src="images/part/d0.png"></a><br />
<a href="http://www.kanaii.com/" target="_blank"><img src="images/part/d1_kanaii.png"></a><br />
<a href="http://kyoutsu-subs.over-blog.com/" target="_blank"><img src="images/part/d2_kyoutsu.png"></a><br />
<a href="http://www.sky-fansub.com/" target="_blank"><img src="images/part/d3_sky.png"></a><br />
<img src="images/part/d4_bas.png"><br />


<a href="index.php?page=dakko"><img src="images/part/t0.png"></a><br />
<a href="http://www.stream-anime.org/" target="_blank"><img src="images/part/t1.png"></a><br />
<a href="http://japanslash.free.fr" target="_blank"><img src="images/part/t2.png"></a><br />
<a href="http://toradora.fr" target="_blank"><img src="images/part/t3.png"></a><br />
<img src="images/part/d4_bas.png"><br />

 
	<ul>
		<li><a target="_blank" href="http://www.anime-ultime.net/part/Site-93" target=_blank"><img src="images/partenaires/Anime-ultime_bouton-93.jpg" border="0" /></a></li>
		<li><a target="_blank" href="http://animeka.com/fansub/teams/zero.html" target=_blank"><img src="images/partenaires/animeka.jpg" border="0" /></a></li>
		<li><a target="_blank" href="http://anime-no-seirei.com/fansub-detail.php?id_fansub=16&PHPSESSID=7d54275e8c4866ecdb328d361b9f6a04" target=_blank"><img src="images/partenaires/anime-no-seirei.jpg" border="0" /></a></li>
		<li><a target="_blank" href="http://animekami.com/"><img src="images/partenaires/animekami.jpg" border="0" width="88" height="31" /></a></li>
		<li><a target="_blank" href="http://kirei-no-tsubasa.com/"><img src="images/partenaires/kirei.jpg" border="0"  width="88" height="31" /></a></li>
		<li><a target="_blank" href="http://manga-mania.forums-actifs.com/" target=_blank"><img src="images/partenaires/mangamania.png" border="0" /></a></li>
		<li><a target="_blank" href="http://mangazaki.over-blog.com/" target=_blank"><img src="http://japanslash.free.fr/images/partenaires/mangazaki.jpg" border="0" /></a></li
		<li><a target="_blank" href="http://shin-chidori.oldiblog.com/" target=_blank"><img src="images/partenaires/shin.jpg" border="0" /></a></li>
				<li><a target="_blank" href="http://touzai-sekai.com/" target=_blank"><img src="images/partenaires/touzai.jpg" border="0" /></a></li>
								<li><a target="_blank" href="http://www.ecchi-scan.com/" target=_blank"><img src="images/partenaires/ecchi.png" border="0" /></a></li>
<li><a href="index.php?page=partenariat" style="color: #ffffff;">Partenariat</a></li>
	</ul>
	</div>
	</div></td></tr></table>
</div>





<div id="footer">
<script type="text/javascript"><!--
google_ad_client = "pub-1841682561759438";
/* 728x90, date de création 31/07/08 */
google_ad_slot = "2046291153";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
</td></tr></table>
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