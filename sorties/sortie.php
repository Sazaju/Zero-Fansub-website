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
	
	$link = new Sortie("mitsudomoe", "mitsudomoe4.png");
	$link->writeNow();
	
	$link = new Sortie("mitsudomoe", "mitsudomoe5.png");
	$link->writeNow();
	
	$link = new Sortie("mitsudomoe", "mitsudomoe6.png");
	$link->writeNow();
?>
