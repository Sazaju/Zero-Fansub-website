<?php
	$page = PageContent::getInstance();
	$page->setTitle("&Agrave; propos...");
?>
<!--<h2>Hébergement du site</h2>
		    <p style="text-align: center;">
		      Le site Zéro fansub ainsi que tous les autres sites de la <a href="http://db0.fr" target="_blank">db0 company</a> sont hébergés par :<br /><br />
		      <a href="http://www.anime-ultime.net/part/Site-93" target="_blank"><img src="images/partenaires/anime-ultime.gif" border="0"></a><br />
		    </p>-->

<?php
	$page->addComponent(new Title("Historique des versions", 2));
	
	$table = new Table();
	$table->setClass("about");
	$page->addComponent($table);
?>
<?php
	$row = new TableRow();
	$head = new TableHeader("Version");
	$head->setClass("version");
	$row->addComponent($head);
	$head = new TableHeader("D&eacute;scription");
	$head->setClass("description");
	$row->addComponent($head);
	$head = new TableHeader("Aperçu");
	$head->setClass("preview");
	$row->addComponent($head);
	$table->addComponent($row);
?>
<?php
	$row = new TableRow();
	$row->addComponent(new TableCell("<b>1.0</b>"));
	$row->addComponent(new TableCell("Z&eacute;ro était un site de ddl."));
	$row->addComponent(new TableCell("Non dispo."));
	$table->addComponent($row);
?>
<?php
	$row = new TableRow();
	$row->addComponent(new TableCell("1.1"));
	$content = new SimpleTextComponent("Z&eacute;ro devient une team de fansub avec pour seul projet ");
	$content->addComponent(new IndexLink("page=series/kimikiss", "Kimikiss pure rouge"));
	$content->addComponent(".");
	$row->addComponent(new TableCell($content));
	$row->addComponent(new TableCell(new NewWindowLink("http://zero.xooit.fr/index.php?theme=test", "Utiliser cette version")));
	$table->addComponent($row);
?>
<?php
	$row = new TableRow();
	$row->addComponent(new TableCell("<b>2.0</b>"));
	$row->addComponent(new TableCell("On essaye un design plus moderne, et c'est jouli. Enfin, je trouve. Et puis c'est rose !"));
	$row->addComponent(new TableCell(new NewWindowLink("http://zerofansub.net/v2/?s_theme=rose", "Utiliser cette version")));
	$table->addComponent($row);
?>
<?php
	$row = new TableRow();
	$row->addComponent(new TableCell("2.1"));
	$row->addComponent(new TableCell("On laisse le choix &agrave; l'utilisateur, si il pr&eacute;f&egrave;re le bleu ^^"));
	$row->addComponent(new TableCell(new NewWindowLink("http://zerofansub.net/v2/index.php?s_theme=bleu", "Utiliser cette version")));
	$table->addComponent($row);
?>
<?php
	$row = new TableRow();
	$row->addComponent(new TableCell("2.2"));
	$row->addComponent(new TableCell("Et pour les tristes, du noir. Du black !"));
	$row->addComponent(new TableCell(new NewWindowLink("http://zerofansub.net/v2/index.php?s_theme=noir", "Utiliser cette version")));
	$table->addComponent($row);
?>
<?php
	$row = new TableRow();
	$row->addComponent(new TableCell("<b>3.0</b>"));
	$row->addComponent(new TableCell("Le petit rond de la v2 n'&eacute;tant pas pratique, on change de syst&eacute;me pour la v3. De couleurs aussi."));
	$row->addComponent(new TableCell(new NewWindowLink("index3.0.php", "Utiliser cette version")));
	$table->addComponent($row);
?>
<?php
	$row = new TableRow();
	$row->addComponent(new TableCell("3.1"));
	$row->addComponent(new TableCell("&Agrave; part le design g&eacute;n&eacute;ral change, mais le contenu des pages reste le m&ecirc;me. C'est juste histoire d'am&eacute;liorer le code."));
	$row->addComponent(new TableCell("Version actuelle !"));
	$table->addComponent($row);
?>
<!--<h2>Optimisation</h2>
   <p style="text-align: center;">Il est conseillé pour une bonne navigation d'utiliser le navigateur Mozilla Firefox :
     <a href="http://download.mozilla.org/?product=firefox-3.0.3&os=win&lang=fr" target="_blank"><img src="images/icones/firefox.png" border="0"></a></p>

   <h2>db0 company</h2>
<p>Zéro est une marque déposée pour de faux :P<br />
  C'est un sous-groupe de la <a href="http://db0.fr" target="_blank">db0 company</a>. Et db0, c'est moi. Et moi, c'est dieu. Oui, en personne. Si vous voulez rejoindre ma secte, <a href="http://zero.xooit.fr/t164-Contrat-d-esclavagisme-volontaire.htm" target="_blank">cliquez ici :)</a><br />
  Plus sérieusement, Zéro fansub est un sous-groupe de Zéro, lui-même un sous-groupe de la <a href="http://db0.fr" target="_blank">db0 company</a>.<br />
  <span style="text-align: center;">Pour en savoir plus sur la <a href="http://db0.fr" target="_blank">db0 company</a> :<br />
    <a href="http://db0.fr" target="_blank"><img src="images/partenaires/db0company.png" border="0"></a>
  </span>
</p>-->








