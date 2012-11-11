<?php
  $theme = array('rose' => "",
		 'bleu' => "",
		 'old' => "");

if (isset($_COOKIE['theme']) && $_POST['s_theme'] == "" && $_GET['s_theme'] == "")
  $_POST['s_theme'] = $_COOKIE['theme'];

if ($_POST['s_theme'] == 'bleu' || $_GET['s_theme'] == 'bleu')
{
  $url_bg = "menuzerobleu.png";
  $url_cl = "#ffffff";
  $theme['bleu'] = " selected";
  setcookie("theme", "bleu", time()+(3600*24*31), "/", "." . $_SERVER['SERVER_NAME'], 0);

}
else if ($_POST['s_theme'] == 'noir' || $_GET['s_theme'] == 'noir')
{
  $url_bg = "menuzeroblack.jpg";
  $url_cl = "#000000";
  $theme['noir'] = " selected";
  setcookie("theme", "noir", time()+(3600*24*31), "/", "." . $_SERVER['SERVER_NAME'], 0);

}
else if ($_POST['s_theme'] == 'old' || $_GET['s_theme'] == 'old')
{
  header("Location: ancientheme/ancientheme.html");
  exit();
}
else 
{
  $url_bg = "menuzerorose2%20.jpg";
  $url_cl = "#ffffff";
  $theme['rose'] = " selected";
  if ($_POST['s_theme'] == 'rose' || $_GET['s_theme'] == 'rose')
    setcookie("theme", "", time()+(3600*24*31), "/", "." . $_SERVER['SERVER_NAME'], 0);
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Z&eacute;ro | team de fansub</title>

<link rel="icon" type="image/gif" href="/fav.gif">
<link rel="shortcut icon" href="/fav.ico">

</head>


<body style="background-image: url(<?php echo $url_bg; ?>); font-family: Tahoma; font-size: 12px; background-repeat: no-repeat; background-color:<?php echo $url_cl; ?>;">

<table style="height: 701px; width: 995px; text-align: left; margin-left: 0px; margin-right: auto;" border="0">

  <tbody>

    <tr>

      <td style="height: 171px; width: 191px; text-align: left;" colspan="5" rowspan="1"><img src="http://apu.mabul.org/up/apu/2008/05/19/img-2136272z4gc.gif" alt="." usemap="#testmap2" border="0"></td>

    </tr>

    <tr>

      <td style="width: 340px; height: 368px;"><img src="http://apu.mabul.org/up/apu/2008/05/18/img-2325249al9p.png" usemap="#testmap" border="0" width="100%" alt="."></td>

      <td colspan="3" rowspan="1" align="left" valign="top"><iframe src="accueil.html" name="lool" id="lol" frameborder="0" height="80%" width="90%"></iframe>
      </td>

      <td style="width: 124px; height: 368px;" valign="top" align="right">


<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="43" height="250">
  <param name="movie" value="radiozanorg.swf" />
  <param name="quality" value="high" />
  <embed src="radiozanorg.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="43" height="250" menu="false"></embed>
</object>


</td>

    </tr>

    <tr>

      <td style="width: 340px; height: 160px;"><img src="http://apu.mabul.org/up/apu/2008/05/19/img-221744ooqkl.gif" usemap="#testmap3" border="0" alt="."></td>

      <td style="width: 336px; height: 160px;"><img src="http://apu.mabul.org/up/apu/2008/05/19/img-232033627k3.gif" usemap="#testmap4" border="0" alt="."></td>

      <td style="width: 191px; height: 160px;" valign="top"><font color="#4d4d4d" face="Georgia">



<marquee direction="up" height="140" scrollamount="2">


<span style="font-family: Georgia; font-size: 12px; color: rgb(209, 39, 85);"><center>
 <a target="_blank" href="http://www.anime-ultime.net/part/Site-93" target=_blank"><img src="partenaires/Anime-ultime_bouton-93.jpg" border="0"></a><br>
 <a target="_blank" href="http://animeka.com/fansub/teams/zero.html" target=_blank"><img src="partenaires/animeka.jpg" border="0"></a><br>
 <a target="_blank" href="http://anime-no-seirei.com/fansub-detail.php?id_fansub=16&PHPSESSID=7d54275e8c4866ecdb328d361b9f6a04" target=_blank"><img src="http://www.anime-no-seirei.com/images/affiliation-anime-no-seirei-logo.png" border="0"></a><br>
 <a target="_blank" href="http://animekami.com/"><img src="partenaires/animekami.jpg" border="0" width="88" height="31"></a><br> 
 <a target="_blank" href="http://kanaii.com/"><img src="partenaires/kanaii.gif" border="0" width="88" height="31"></a><br>
 <a target="_blank" href="http://kirei-no-tsubasa.com/"><img src="http://img214.imageshack.us/img214/685/kireiud5.gif" border="0"  width="88" height="31"></a><br>
 <a target="_blank" href="http://zerofansub.net/ketsueki" target=_blank"><img src="partenaires/ketsueki.jpg" border="0"></a><br>
 <a target="_blank" href="http://japanslash.free.fr" target=_blank"><img src="partenaires/maboroshi.jpg" border="0"></a><br>
 <a target="_blank" href="http://manga-mania.forums-actifs.com/" target=_blank"><img src="partenaires/mangamania.png" border="0"></a><br>
 <a target="_blank" href="http://www.sky-animes.com/index.php?file=Download&op=categorie&cat=1076" target=_blank"><img src="http://www.sky-animes.com/public/Partenariat/ban-mini_sky-animes.com.gif" border="0"></a><br>
 <a target="_blank" href="http://shin-chidori.oldiblog.com/" target=_blank"><img src="partenaires/shin.jpg" border="0"></a><br>
 <a target="_blank" href="http://touzai-sekai.com/" target=_blank"><img src="partenaires/touzai.gif" border="0"></a><br>
<a href="partenaires/partenaires.html" target="lool">Devenir Partenaire</a></center>


</marquee>




      </font><br>

      </td>

      <td style="width: 94px; height: 210px;" colspan="2" rowspan="1"></td>

    </tr>

  </tbody>
</table><div align="right">
C O P Y R I G H T 2 o o 8 <a href="http://db0.fr" target="_blank">db0 company</a> 
| <img src="donate.jpg" border="0">  <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=mba_06%40hotmail%2efr&item_name=Zero&no_shipping=0&no_note=1&tax=0&currency_code=EUR&lc=FR&bn=PP%2dDonationsBF&charset=UTF%2d8" target="_blank" > Faire un don</a> 
| <img src="news.jpg" border="0"> <a href="http://zero.xooit.fr/profile.php?mode=register&agreed=true" target="_blank" >Newsletter</a> | <a href="http://zerofansub.feedxs.com/zero.rss" target="_blank" ><img src="rss.jpg" border="0"> RSS</a>
| <img src="help.jpg" border="0"> <a href="aide.html" target="lool">Aide</a> 
| Choisir un théme :</span>

<?php 
  echo "<form name='theme' method='post' action='index.php'>"; 
    echo "<select name='s_theme' onchange='javascript:this.form.submit();'>"; 
      echo "<option value='rose'" . $theme['rose'] . ">Rose</option>"; 
      echo "<option value='bleu'" . $theme['bleu'] . ">Bleu</option>"; 
      echo "<option value='noir'" . $theme['noir'] . ">Black</option>"; 
      echo "<option value='old'" . $theme['old'] . ">Ancien thème</option>"; 
    echo "</select>"; 
  echo "</form>";
?>


<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>




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


<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-4691079-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>

<map name="testmap">
<area shape="rect" coords="53,29,285,79" href="team.html" target="lool" alt="team">
<area shape="rect" coords="6,151,319,217" href="projetsdl/projetsdl.html" target="lool" alt="projetsdl">
<area shape="rect" coords="60,282,306,331" href="http://zero.xooit.fr/index.php" target="_blank" alt="forum">
</map>

<map name="testmap2">
<area shape="rect" coords="150,80,391,150" href="accueil.html" target="lool" alt="accueil">
<area shape="rect" coords="720,0,995,154" href="accueil.html" target="lool" alt="accueil">
</map>

<map name="testmap3">
<area shape="rect" coords="156,0,400,30" href="bonus/bonus.html" target="lool" alt="bonus">
<area shape="rect" coords="110,110,148,180" href="http://db0.fr" target="_blank" alt="copyright">
</map>

<map name="testmap4">
<area shape="circle" coords="148,7,26" href="irc://irc.fansub-irc.eu/zero" alt="irc">
<area shape="circle" coords="196,62,26" href="http://download.mozilla.org/?product=firefox-3.0&os=win&lang=fr" alt="firefox">
<area shape="circle" coords="253,111,26" href="ts.html" target="lool" alt="teamspeak">
</map>

</body>
</html>