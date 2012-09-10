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
			CornerImage::$allImages[] = new CornerImage("canaan0.png", "Canaan", "canaan");
			
			CornerImage::$allImages[] = new CornerImage("denpa1.png", "Erio", "denpa");
			CornerImage::$allImages[] = new CornerImage("denpa2.png", "Erio", "denpa");
			CornerImage::$allImages[] = new CornerImage("denpa5.png", "Erio", "denpa");
			CornerImage::$allImages[] = new CornerImage("denpa6.png", "?", "denpa");
			
			CornerImage::$allImages[] = new CornerImage("genshiken0.png", "Ohno", "genshiken");
			CornerImage::$allImages[] = new CornerImage("genshiken1.png", "Ogiue", "genshiken");
			
			CornerImage::$allImages[] = new CornerImage("haganai0.png", "Yozora", "haganai");
			CornerImage::$allImages[] = new CornerImage("haganai1.png", "?", "haganai");
			CornerImage::$allImages[] = new CornerImage("haganai2.png", "Kobato", "haganai");
			CornerImage::$allImages[] = new CornerImage("haganai3.png", "Kobato", "haganai");
			CornerImage::$allImages[] = new CornerImage("haganai4.png", "Maria", "haganai");
			CornerImage::$allImages[] = new CornerImage("haganai5.png", "Yukimura", "haganai");
			CornerImage::$allImages[] = new CornerImage("haganai6.png", "Yukimura", "haganai");
			
			CornerImage::$allImages[] = new CornerImage("hshiyo0.png", "Akina", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo2.png", "Akina", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo3.png", "Haruka", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo4.png", "Haruka", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo5.png", "Suzuran", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo6.png", "Suzuran", "hshiyo");
			CornerImage::$allImages[] = new CornerImage("hshiyo7.png", "Aoi", "hshiyo");
			
			CornerImage::$allImages[] = new CornerImage("hyakko1.png", "Torako", "hyakko");
			CornerImage::$allImages[] = new CornerImage("hyakko1.png", "Torako", "hyakkooav");
			
			CornerImage::$allImages[] = new CornerImage("isshoni0.png", "Hinako", "training");
			CornerImage::$allImages[] = new CornerImage("isshoni0.png", "Hinako", "sleeping");
			
			CornerImage::$allImages[] = new CornerImage("kanamemo0.png", "Kana", "kanamemo");
			CornerImage::$allImages[] = new CornerImage("kanamemo1.png", "Kana & ?", "kanamemo");// TODO retrieve the name of the character
			
			CornerImage::$allImages[] = new CornerImage("kannagi0.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = new CornerImage("kannagi1.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = new CornerImage("kannagi2.png", "Nagi", "kannagi");
			CornerImage::$allImages[] = new CornerImage("kannagi3.png", "Nagi", "kannagi");
			
			CornerImage::$allImages[] = new CornerImage("kissXSis1.png", "Riko & Ako", "kissxsis");
			CornerImage::$allImages[] = new CornerImage("kissXSis2.png", "Ako & Riko", "kissxsis");
			
			CornerImage::$allImages[] = new CornerImage("kodomo0.png", "Rin", "kodomooav");
			CornerImage::$allImages[] = new CornerImage("kodomo0.png", "Rin", "kodomo2");
			CornerImage::$allImages[] = new CornerImage("kodomo0.png", "Rin", "kodomo");
			
			CornerImage::$allImages[] = new CornerImage("kujian0.png", "Présidente & Tokino", "kujibiki");
			
			CornerImage::$allImages[] = new CornerImage("luckyStar0.png", "Konata");
			
			CornerImage::$allImages[] = new CornerImage("mariaHolic0.png", "Mariya", "mariaholic");
			CornerImage::$allImages[] = new CornerImage("mariaHolic1.png", "?", "mariaholic");
			
			CornerImage::$allImages[] = new CornerImage("mayoi0.png", "Fumino", "mayoi");
			
			CornerImage::$allImages[] = new CornerImage("mitsudomoe0.png", "Airi", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe2.png", "Shiori", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe3.png", "Miku", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe4.png", "Mitsuba", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe5.png", "Futaba", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe6.png", "Hitoha", "mitsudomoe");
			CornerImage::$allImages[] = new CornerImage("mitsudomoe7.png", "Sakiko", "mitsudomoe");
			
			CornerImage::$allImages[] = new CornerImage("pokemon0.png", "Pikachu");
			
			CornerImage::$allImages[] = new CornerImage("potemayo0.png", "Sunao & Potemayo", "potemayo");
			
			CornerImage::$allImages[] = new CornerImage("sketchbook1.png", "Kate", "sketchbook");
			
			CornerImage::$allImages[] = new CornerImage("tayutama0.png", "Mashiro", "tayutama");
			
			CornerImage::$allImages[] = new CornerImage("toradora0.png", "Taiga", "toradora");
			CornerImage::$allImages[] = new CornerImage("toradora1.png", "Taiga", "toradora");
			
			CornerImage::$allImages[] = new CornerImage("working1.png", "? & ?", "working");
			CornerImage::$allImages[] = new CornerImage("working1.png", "? & ?", "working2");
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