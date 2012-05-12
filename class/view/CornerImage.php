<?php
/*
	A corner image appear in the top left corner of the website.
*/
class CornerImage extends Link {
	private $project = null;
	
	function __construct($imageName, $name, $projectId = null) {
		$this->setClass("cornerImage");
		
		if ($projectId !== null) {
			$this->project = Project::getProject($projectId);
		}
		
		$content = new Image("images/hautmenu/".$imageName, $name);
		$this->setContent($content);
		
		if ($projectId != null) {
			$url = Url::getCurrentScriptUrl();
			$url->setQueryVar('page', 'project');
			$url->setQueryVar('id', $projectId);
			$this->setUrl($url);
		} else {
			$this->setUrl(new Url('#'));
		}
	}
	
	public function getProject() {
		return $this->project;
	}
	
	private static $allImages = null;
	static function getAllImages() {
		if (CornerImage::$allImages === null) {
			CornerImage::$allImages[] = new CornerImage("konata.png", "Konata");
			CornerImage::$allImages[] = new CornerImage("rin.png", "Rin", "kodomooav");
			CornerImage::$allImages[] = new CornerImage("Toradora0.png", "Taiga", "toradora");
			CornerImage::$allImages[] = new CornerImage("Toradora1.png", "Taiga", "toradora");
			CornerImage::$allImages[] = new CornerImage("Genshiken0.png", "Ohno", "genshiken");
			CornerImage::$allImages[] = new CornerImage("Genshiken1.png", "Ogiue", "genshiken");
			CornerImage::$allImages[] = new CornerImage("Sketchbook1.png", "Kate", "sketchbook");
			CornerImage::$allImages[] = new CornerImage("kujian.png", "Présidente & Tokino", "kujibiki");
			CornerImage::$allImages[] = new CornerImage("rin.png", "Rin", "kodomo2");
			CornerImage::$allImages[] = new CornerImage("Working1.png", "? & ?", "working");
			CornerImage::$allImages[] = new CornerImage("Working1.png", "? & ?", "working2");
			CornerImage::$allImages[] = new CornerImage("KissXSis1.png", "Riko & Ako", "kissxsis");
			CornerImage::$allImages[] = new CornerImage("KissXSis2.png", "Ako & Riko", "kissxsis");
			CornerImage::$allImages[] = new CornerImage("Denpa1.png", "Erio", "denpa");
			CornerImage::$allImages[] = new CornerImage("Denpa2.png", "Erio", "denpa");
			CornerImage::$allImages[] = new CornerImage("Denpa5.png", "Erio", "denpa");
			CornerImage::$allImages[] = new CornerImage("Denpa6.png", "?", "denpa");
			CornerImage::$allImages[] = new CornerImage("rin.png", "Rin", "kodomo");
			CornerImage::$allImages[] = new CornerImage("pika.png", "Pikachu");
			CornerImage::$allImages[] = new CornerImage("canaan.png", "Canaan", "canaan");
			CornerImage::$allImages[] = new CornerImage("isshoni.png", "Hinako", "training");
			CornerImage::$allImages[] = new CornerImage("isshoni.png", "Hinako", "sleeping");
			CornerImage::$allImages[] = new CornerImage("Kanamemo0.png", "Kana", "kanamemo");
			CornerImage::$allImages[] = new CornerImage("Kanamemo1.png", "Kana & ?", "kanamemo");// TODO retrieve the name of the character
			CornerImage::$allImages[] = new CornerImage("Kannagi0.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = new CornerImage("Kannagi1.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = new CornerImage("Kannagi2.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = new CornerImage("Kannagi3.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = new CornerImage("Hyakko1.png", "Torako", "hyakko");
			CornerImage::$allImages[] = new CornerImage("Hyakko1.png", "Torako", "hyakkooav");
			CornerImage::$allImages[] = new CornerImage("potemayo.png", "Sunao & Potemayo", "potemayo");
			CornerImage::$allImages[] = new CornerImage("tayutama.png", "Mashiro", "tayutama");
			CornerImage::$allImages[] = new CornerImage("MariaHolic0.png", "Mariya", "mariaholic");
			CornerImage::$allImages[] = new CornerImage("MariaHolic1.png", "Maid", "mariaholic");
			CornerImage::$allImages[] = new CornerImage("fumino.png", "Fumino", "mayoi");
			CornerImage::$allImages[] = new CornerImage("hshiyo.png", "Akina", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo2.png", "Akina", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo3.png", "Haruka", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo4.png", "Haruka", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo5.png", "Suzuran", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo6.png", "Suzuran", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo7.png", "Aoi", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe.png", "Airi", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe2.png", "Shiori", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe3.png", "Miku", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe4.png", "Mitsuba", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe5.png", "Futaba", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe6.png", "Hitoha", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe7.png", "Sakiko", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("BokuTomo1.png", "?", "haganai");
			CornerImage::$allImages[] = new CornerImage("BokuTomo2.png", "Kobato", "haganai");
			CornerImage::$allImages[] = new CornerImage("BokuTomo3.png", "Kobato", "haganai");
			CornerImage::$allImages[] = new CornerImage("BokuTomo4.png", "Maria", "haganai");
			CornerImage::$allImages[] = new CornerImage("BokuTomo5.png", "Yukimura", "haganai");
			CornerImage::$allImages[] = new CornerImage("BokuTomo6.png", "Yukimura", "haganai");
		}
		
		return CornerImage::$allImages;
	}
	
	public static function getHentaiImages() {
		$list = array();
		foreach(CornerImage::getAllImages() as $image) {
			if ($image->getProject() === null || $image->getProject()->isHentai()) {
				$list[] = $image;
			}
		}
		return $list;
	}
	
	public static function getNotHentaiImages() {
		$list = array();
		foreach(CornerImage::getAllImages() as $image) {
			if ($image->getProject() === null || !$image->getProject()->isHentai()) {
				$list[] = $image;
			}
		}
		return $list;
	}
}
?>