<h3>Working!!</h3>

<div style="float : right; display:block; margin-right: 20px;">
        <img src="images/series/working.jpg" border="0">
</div>
<h2>Informations g&eacute;n&eacute;rales</h2>
<h4>Source : <a href="http://animeka.com/fansub/teams/zero.html" target="_blank">Animeka</a></h4>

<p>
<b>Titre Original</b> Working!!<br />
<b>Site officiel</b> <a href="http://www.wagnaria.com/" target="_blank">Wagnaria.com</a><br />
<b>Ann&eacute;e de production</b> 2010<br />
<b>Studio</b> A-1 Pictures Inc<br />
<b>Genre</b> Com&eacute;die<br />
<b>Synopsis</b> Takanashi Souta est un lyc&eacute;en qui a une passion pour les petites choses mignonnes. Quand une fille, Taneshima Popla, l&apos;aborde dans la rue et lui demande si il cherche un travail &agrave; mi-temps, il la trouve mignonne car elle ressemble &agrave; une coll&eacute;gienne, peut-&ecirc;tre m&ecirc;me une &eacute;coli&egrave;re. Mais il se rend compte quelle a un an de plus que lui. Passant par dessus ce d&eacute;tail, il accepte le travail &agrave; mi-temps car elle est toute petite et craquante &agrave; souhait. Il commence donc &agrave; travailler dans un restaurant familial, mais on peut dire que le personnel est unique ici ! 
</p>

<p style="text-align: right;"><a href="http://zero.xooit.fr/t471-Liens-morts.htm" target="_blank">Signaler un lien mort</a></p><h2>&Eacute;pisodes</h2>


<?php
for ($i = 1; $i <= 13; $i++)
{
  $file = "episodes/working" . $i . ".php";
  if (file_exists($file))
    require($file);
  else
    echo '<h6>Working!! &Eacute;pisode '.($i < 10 ? '0' : '').$i.' - Non disponible</h6>';
}
?>
<p></p>
