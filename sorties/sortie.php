<?php
	
	class Sortie extends IndexLink {
		public function __construct($serie, $imageName) {
			$this->setUrl("page=series/".$serie);
			$image = new Image();
			$image->setSource("images/sorties/".$imageName);
			$image->setStyle("border:0;");
			$this->addComponent($image);
		}
	}
	
	$link = new Sortie("toradorasos", "lastsos.png");
	$link->writeNow();
	
	$link = new Sortie("mitsudomoe", "lastmitsudomoe3.png");
	$link->writeNow();
	
	$link = new Sortie("hitohira", "lasthitohira.png");
	$link->writeNow();
?>
