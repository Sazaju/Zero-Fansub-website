<?php
/*
	A corner image appear in the top left corner of the website.
*/
class CornerImage extends DefaultHtmlComponent {
	
	function __construct($imageName, $name, $serieId = null) {
		$content = new Image("images/hautmenu/".$imageName, $name);
		if ($serieId != null) {
			$content = new IndexLink("page=series/".$serieId, $content);
		}
		$this->setContent($content);
		$this->setClass("cornerImage");
	}
	
	function getHtmlTag() {
		return 'div';
	}
	
	private static $allImages = null;
	static function getAllImages() {
		if (CornerImage::$allImages === null) {
			$corner = new CornerImage("konata.png", "Konata");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("rin.png", "Rin", "kodomooav");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Toradora0.png", "Taiga", "toradora");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Toradora1.png", "Taiga", "toradora");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Genshiken0.png", "Ohno", "genshiken");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Genshiken1.png", "Ogiue", "genshiken");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Sketchbook1.png", "Kate", "sketchbook");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("kujian.png", "Présidente & Tokino", "kujibiki");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("rin.png", "Rin", "kodomo2");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("BokuTomo1.png", "?"); // TODO link to the corresponding project
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Working1.png", "? & ?", "working");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Working1.png", "? & ?", "working2");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("KissXSis1.png", "Riko & Ako", "kissxsis");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("KissXSis2.png", "Ako & Riko", "kissxsis");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Denpa1.png", "Erio", "denpa");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Denpa5.png", "Erio", "denpa");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Denpa6.png", "?", "denpa");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("rin.png", "Rin", "kodomo");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("pika.png", "Pikachu");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("canaan.png", "Canaan", "canaan");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("isshoni.png", "Hinako", "training");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("isshoni.png", "Hinako", "sleeping");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Kanamemo0.png", "Kana", "kanamemo");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Kanamemo1.png", "Kana & ?", "kanamemo");// TODO retrieve the name of the character
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Kannagi0.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Kannagi1.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Kannagi2.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Kannagi3.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Hyakko1.png", "Torako", "hyakko");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("Hyakko1.png", "Torako", "hyakkooav");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("potemayo.png", "Sunao & Potemayo", "potemayo");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("tayutama.png", "Mashiro", "tayutama");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("MariaHolic0.png", "Mariya", "mariaholic");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("MariaHolic1.png", "Maid", "mariaholic");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("fumino.png", "Fumino", "mayoi");
			CornerImage::$allImages[] = $corner;
		}
		
		return CornerImage::$allImages;
	}
}

?>



























