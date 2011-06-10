<?php
/*
	This file is the root of the website. Here is the global code generating the
	complete page.
*/

require_once("php/constants.php");
require_once("php/class/htmlbuilder.php");
require_once("php/util/format.php");

$builder = new HtmlBuilder();
$builder->setTitle(TITLE);
$builder->generateHtml();
$html = $builder->getHtml();

// TODO debugging
$html = formatHtml($html);
// TODO /debugging
echo $html;
?>
