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
			
			$corner = new CornerImage("futami.png", "Futami", "kimikiss");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("mugi.png", "Mugi", "hitohira");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("rin.png", "Rin", "kodomooav");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("taiga.png", "Taiga", "toradora");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("ohno.png", "Ohno", "genshiken");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("sora.png", "Sora", "sketchbook");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("kujian.png", "Tokino & présidente", "kujibiki");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("lucia.png", "Lucia", "mermaid");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("rin.png", "Rin", "kodomo2");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("ako.png", "Ako", "kissxsis");
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
			
			$corner = new CornerImage("kanamemo.png", "Kana", "kanamemo");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("kannagi.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("potemayo.png", "Sunao & Potemayo", "potemayo");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("tayutama.png", "Mashiro", "tayutama");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("mariya.png", "Mariya", "mariaholic");
			CornerImage::$allImages[] = $corner;
			
			$corner = new CornerImage("fumino.png", "Fumino", "mayoi");
			CornerImage::$allImages[] = $corner;
		}
		
		return CornerImage::$allImages;
	}
}

?>



























