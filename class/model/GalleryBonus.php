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
				$resource = Resource::getResource($id);
				$description = $resource->getName();
				$ext = $resource->getExtension();
				$name = $id.'_'.preg_replace("#[^a-zA-Z0-9]+#", "_", $description).'.'.$ext;
				$url = 'downloadResource.php?id='.$id.'&name='.urlencode($name);
				$links .= '<a target="_blank" href="'.$url.'"><img src="'.$url.'" alt="['.$description.']" title="'.$description.'" /></a>';
			}
			return '<div class="bonusGallery">'.$links.'</div>';
		}
	}
}
?> 
