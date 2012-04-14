<?php
class Image {
	private $id = null;
	private $extension = null;
	private $description = null;
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function setExtension($extension) {
		$this->extension = $extension;
	}
	
	public function getExtension() {
		return $this->extension;
	}
	
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getURL() {
		return new Url('ddl/images/'.$this->id.'.'.$this->extension);
	}
	
	private static $allImages = null;
	public static function getAllImages() {
		if (Image::$allImages === null) {
			$image = new Image();
			$image->setID(1);
			$image->setExtension("png");
			$image->setDescription("Wallpaper Mitsudomoe 1");
			Image::$allImages[] = $image;
			
			$image = new Image();
			$image->setID(2);
			$image->setExtension("png");
			$image->setDescription("Wallpaper Mitsudomoe 2");
			Image::$allImages[] = $image;
			
			$image = new Image();
			$image->setID(3);
			$image->setExtension("png");
			$image->setDescription("Wallpaper Mitsudomoe 3");
			Image::$allImages[] = $image;
			
			$image = new Image();
			$image->setID(4);
			$image->setExtension("png");
			$image->setDescription("Wallpaper Mitsudomoe 4");
			Image::$allImages[] = $image;
			
			$image = new Image();
			$image->setID(5);
			$image->setExtension("png");
			$image->setDescription("Wallpaper Mitsudomoe 5");
			Image::$allImages[] = $image;
			
			$image = new Image();
			$image->setID(6);
			$image->setExtension("png");
			$image->setDescription("Wallpaper Mitsudomoe 6");
			Image::$allImages[] = $image;
			
			$image = new Image();
			$image->setID(7);
			$image->setExtension("png");
			$image->setDescription("Wallpaper Mitsudomoe 7");
			Image::$allImages[] = $image;
			
			$image = new Image();
			$image->setID(8);
			$image->setExtension("png");
			$image->setDescription("Wallpaper Mitsudomoe 8");
			Image::$allImages[] = $image;
		}
		
		return Image::$allImages;
	}
	
	public static function getImage($id) {
		foreach(Image::getAllImages() as $image) {
			if ($image->getID() === $id) {
				return $image;
			}
		}
		throw new Exception($id." is not a known image ID.");
	}
}
?>