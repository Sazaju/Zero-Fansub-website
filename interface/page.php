<div id="page"><!-- TODO remove this level when all pages will be translated in object PHP -->
	<!-- COMCLICK France : 468 x 60 -->
	<!--<iframe src="http://fl01.ct2.comclick.com/aff_frame.ct2?id_regie=1&num_editeur=14388&num_site=3&num_emplacement=1"
	WIDTH="468" HEIGHT="60" marginwidth="0" marginheight="0" hspace="0"
	vspace="0" frameborder="0" scrolling="no" bordercolor="#000000">
	</iframe>-->
	<!-- FIN TAG -->

	<?php
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		}
		else {
			$page = "home";
		}
		
		if (isset($_GET[DISPLAY_H_AVERT])) {
			$page = "havert";
		}
		
		if (file_exists("pages/$page.php")) {
			require_once("pages/$page.php");
		}
		else {
			$parts = preg_split("#/#", $page);
			if (strcmp($parts[0], 'series') === 0) {
				$project = Project::getProject($parts[1]);
				
				if ($project->isHentai() && $_SESSION[MODE_H] == false) {
					require_once("pages/havert.php");
				}
				else {
					$project = new ProjectComponent($project);
					$project->writeNow();
				}
			}
			else {
				require_once("pages/home.php");
			}
		}
		PageContent::getInstance()->setId(null); // TODO remove when all pages will be translated in object PHP
		PageContent::getInstance()->writeNow();
	?>
</div>
