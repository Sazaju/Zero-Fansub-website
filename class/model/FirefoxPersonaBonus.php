<?php
class FirefoxPersonaBonus extends ProjectBonus {
	public function __construct($ids, $description = null) {
		parent::__construct("Thèmes pour Firefox (Skin Persona)", FirefoxPersonaBonus::buildContent($ids, $description));
	}
	
	private static function buildContent($ids, $description) {
		if (!is_array($ids)) {
			throw new Exception("IDs and descriptions has to be given in an array");
		} else {
			$rootLink = 'http://www.getpersonas.com/en-US/persona/';
			$rootPicture = 'http://getpersonas-cdn.mozilla.net/static/';
			
			$links = "";
			foreach($ids as $id) {
				$id = "$id";
				$pathPicture = $id[strlen($id)-2].'/'.$id[strlen($id)-1].'/';
				$links .= '<a target="_blank" href="'.$rootLink.$id.'"><img src="'.$rootPicture.$pathPicture.$id.'/preview.jpg" alt="'.$description.'" /></a>';
			}
			return $links;
		}
	}
}
?>