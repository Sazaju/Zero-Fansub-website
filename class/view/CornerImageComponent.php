<?php
/*
	A corner image appear in the top left corner of the website.
*/
class CornerImageComponent extends LinkComponent {
	private $project = null;
	
	function __construct($imageName, $name, $projectId = null) {
		$this->setClass("cornerImage");
		
		if ($projectId !== null) {
			$this->project = Project::getProject($projectId);
		}
		
		$content = new ImageComponent("images/hautmenu/".$imageName, $name);
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
		if (CornerImageComponent::$allImages === null) {
			CornerImageComponent::$allImages[] = new CornerImageComponent("konata.png", "Konata");
			CornerImageComponent::$allImages[] = new CornerImageComponent("rin.png", "Rin", "kodomooav");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Toradora0.png", "Taiga", "toradora");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Toradora1.png", "Taiga", "toradora");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Genshiken0.png", "Ohno", "genshiken");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Genshiken1.png", "Ogiue", "genshiken");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Sketchbook1.png", "Kate", "sketchbook");
			CornerImageComponent::$allImages[] = new CornerImageComponent("kujian.png", "Présidente & Tokino", "kujibiki");
			CornerImageComponent::$allImages[] = new CornerImageComponent("rin.png", "Rin", "kodomo2");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Working1.png", "? & ?", "working");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Working1.png", "? & ?", "working2");
			CornerImageComponent::$allImages[] = new CornerImageComponent("KissXSis1.png", "Riko & Ako", "kissxsis");
			CornerImageComponent::$allImages[] = new CornerImageComponent("KissXSis2.png", "Ako & Riko", "kissxsis");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Denpa1.png", "Erio", "denpa");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Denpa5.png", "Erio", "denpa");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Denpa6.png", "?", "denpa");
			CornerImageComponent::$allImages[] = new CornerImageComponent("rin.png", "Rin", "kodomo");
			CornerImageComponent::$allImages[] = new CornerImageComponent("pika.png", "Pikachu");
			CornerImageComponent::$allImages[] = new CornerImageComponent("canaan.png", "Canaan", "canaan");
			CornerImageComponent::$allImages[] = new CornerImageComponent("isshoni.png", "Hinako", "training");
			CornerImageComponent::$allImages[] = new CornerImageComponent("isshoni.png", "Hinako", "sleeping");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Kanamemo0.png", "Kana", "kanamemo");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Kanamemo1.png", "Kana & ?", "kanamemo");// TODO retrieve the name of the character
			CornerImageComponent::$allImages[] = new CornerImageComponent("Kannagi0.png", "Nagi", "kannagi");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Kannagi1.png", "Nagi", "kannagi");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Kannagi2.png", "Nagi", "kannagi");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Kannagi3.png", "Nagi", "kannagi");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Hyakko1.png", "Torako", "hyakko");
			CornerImageComponent::$allImages[] = new CornerImageComponent("Hyakko1.png", "Torako", "hyakkooav");
			CornerImageComponent::$allImages[] = new CornerImageComponent("potemayo.png", "Sunao & Potemayo", "potemayo");
			CornerImageComponent::$allImages[] = new CornerImageComponent("tayutama.png", "Mashiro", "tayutama");
			CornerImageComponent::$allImages[] = new CornerImageComponent("MariaHolic0.png", "Mariya", "mariaholic");
			CornerImageComponent::$allImages[] = new CornerImageComponent("MariaHolic1.png", "Maid", "mariaholic");
			CornerImageComponent::$allImages[] = new CornerImageComponent("fumino.png", "Fumino", "mayoi");
			CornerImageComponent::$allImages[] = new CornerImageComponent("hshiyo.png", "Akina", "hshiyo");
			CornerImageComponent::$allImages[] = new CornerImageComponent("hshiyo2.png", "Akina", "hshiyo");
			CornerImageComponent::$allImages[] = new CornerImageComponent("hshiyo3.png", "Haruka", "hshiyo");
			CornerImageComponent::$allImages[] = new CornerImageComponent("hshiyo4.png", "Haruka", "hshiyo");
			CornerImageComponent::$allImages[] = new CornerImageComponent("hshiyo5.png", "Suzuran", "hshiyo");
			CornerImageComponent::$allImages[] = new CornerImageComponent("hshiyo6.png", "Suzuran", "hshiyo");
			CornerImageComponent::$allImages[] = new CornerImageComponent("hshiyo7.png", "Aoi", "hshiyo");
			CornerImageComponent::$allImages[] = new CornerImageComponent("mitsudomoe.png", "Airi", "mitsudomoe");
			CornerImageComponent::$allImages[] = new CornerImageComponent("mitsudomoe2.png", "Shiori", "mitsudomoe");
			CornerImageComponent::$allImages[] = new CornerImageComponent("mitsudomoe3.png", "Miku", "mitsudomoe");
			CornerImageComponent::$allImages[] = new CornerImageComponent("mitsudomoe4.png", "Mitsuba", "mitsudomoe");
			CornerImageComponent::$allImages[] = new CornerImageComponent("mitsudomoe5.png", "Futaba", "mitsudomoe");
			CornerImageComponent::$allImages[] = new CornerImageComponent("mitsudomoe6.png", "Hitoha", "mitsudomoe");
			CornerImageComponent::$allImages[] = new CornerImageComponent("mitsudomoe7.png", "Sakiko", "mitsudomoe");
			CornerImageComponent::$allImages[] = new CornerImageComponent("BokuTomo1.png", "?", "haganai");
			CornerImageComponent::$allImages[] = new CornerImageComponent("BokuTomo2.png", "Kobato", "haganai");
			CornerImageComponent::$allImages[] = new CornerImageComponent("BokuTomo3.png", "Kobato", "haganai");
			CornerImageComponent::$allImages[] = new CornerImageComponent("BokuTomo4.png", "Maria", "haganai");
			CornerImageComponent::$allImages[] = new CornerImageComponent("BokuTomo5.png", "Yukimura", "haganai");
			CornerImageComponent::$allImages[] = new CornerImageComponent("BokuTomo6.png", "Yukimura", "haganai");
		}
		
		return CornerImageComponent::$allImages;
	}
	
	public static function getHentaiImages() {
		$list = array();
		foreach(CornerImageComponent::getAllImages() as $image) {
			if ($image->getProject() === null || $image->getProject()->isHentai()) {
				$list[] = $image;
			}
		}
		return $list;
	}
	
	public static function getNotHentaiImages() {
		$list = array();
		foreach(CornerImageComponent::getAllImages() as $image) {
			if ($image->getProject() === null || !$image->getProject()->isHentai()) {
				$list[] = $image;
			}
		}
		return $list;
	}
}
?>