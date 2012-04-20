<?php
class GalleryBonus extends ProjectBonus {
	public function __construct($maps) {
		parent::__construct("Images & Wallpaper", GalleryBonus::buildContent($maps));
	}
	
	private static function buildContent($maps) {
		if (!is_array($maps)) {
			throw new Exception("IDs has to be given in an array");
		} else {
			$links = "";
			foreach($maps as $id) {
				$image = Image::getImage($id);
				$description = $image->getDescription();
				$ext = $image->getExtension();
				$name = $id.'_'.preg_replace("#[^a-zA-Z0-9]+#", "_", $description).'.'.$ext;
				$url = 'downloadImage.php?id='.$id.'&name='.urlencode($name);
				$links .= '<a target="_blank" href="'.$url.'"><img src="'.$url.'" alt="['.$description.']" title="'.$description.'" /></a>';
			}
			return '<div class="bonusGallery">'.$links.'</div>';
		}
	}
}
?> 
