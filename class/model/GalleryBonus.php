<?php
class GalleryBonus extends ProjectBonus {
	
	public function __construct($maps) {
		parent::__construct("Images & Wallpaper", GalleryBonus::buildContent($maps));
	}
	
	private static function generateName($resource) {
		$name = $resource->getName();
		
		$id = $resource->getID();
		if ($id != null) {
			$name = $id.' '.$name;
		}
		$name = preg_replace("#[^a-zA-Z0-9]+#", "_", $name);
		
		$ext = $resource->getExtension();
		if ($ext != null) {
			$name = $name.'.'.$ext;
		}
		return $name;
	}
	
	private static function buildContent($maps) {
		if (!is_array($maps)) {
			throw new Exception("IDs has to be given in an array");
		} else {
			$links = "";
			$pack = new Resource();
			$pack->setExtension("zip");
			$pack->setName("packImages");
			foreach($maps as $id) {
				$pack->addResource($id);
				$resource = Resource::getResource($id);
				$name = $resource->getName();
				$ext = $resource->getExtension();
				$name = GalleryBonus::generateName($resource);
				$url = 'downloadResource.php?id='.$id.'&name='.urlencode($name);
				$links .= '<a target="_blank" href="'.$url.'"><img src="'.$url.'" alt="['.$name.']" title="'.$name.'" /></a>';
			}
			$packId = "packDownload";
			$url = 'downloadResource.php?key='.$packId.'&name='.GalleryBonus::generateName($pack);
			$allLink = '<a href="'.$url.'">[Télécharger le pack]</a>';
			$_SESSION[$packId] = $pack;
			
			return '<div class="bonusGallery">'.$allLink.'<br/>'.$links.'<br/>'.$allLink.'</div>';
		}
	}
}
?> 
