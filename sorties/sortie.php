<?php
	
	class Sortie extends IndexLink {
		public function __construct($serie, $imageName) {
			$this->setUrl("page=series/".$serie);
			$this->setClass("sortie");
			$image = new Image();
			$image->setUrl("images/sorties/".$imageName);
			$image->setStyle("border:0;");
			$this->addComponent($image);
		}
	}
	
	$link = new Sortie("mitsudomoe", "mitsudomoe6.png");
	$link->writeNow();
	
	$link = new Sortie("kodomooav", "kodomooavv3.png");
	$link->writeNow();
	
	$link = new Sortie("kodomofilm", "kodomofilm.png");
	$link->writeNow();
	
?>
