<?php
class Resource {
	private $id = null;
	private $extension = null;
	private $name = null;
	
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
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getURL() {
		return new Url('resources/'.$this->id.'.'.$this->extension);
	}
	
	private static $allResource = null;
	public static function getAllResources() {
		if (Resource::$allResource === null) {
			$resource = new Resource();
			$resource->setID(1);
			$resource->setExtension("png");
			$resource->setName("Wallpaper Mitsudomoe 1");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(2);
			$resource->setExtension("png");
			$resource->setName("Wallpaper Mitsudomoe 2");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(3);
			$resource->setExtension("png");
			$resource->setName("Wallpaper Mitsudomoe 3");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(4);
			$resource->setExtension("png");
			$resource->setName("Wallpaper Mitsudomoe 4");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(5);
			$resource->setExtension("png");
			$resource->setName("Wallpaper Mitsudomoe 5");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(6);
			$resource->setExtension("png");
			$resource->setName("Wallpaper Mitsudomoe 6");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(7);
			$resource->setExtension("png");
			$resource->setName("Wallpaper Mitsudomoe 7");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(8);
			$resource->setExtension("png");
			$resource->setName("Wallpaper Mitsudomoe 8");
			Resource::$allResource[] = $resource;
		}
		
		return Resource::$allResource;
	}
	
	public static function getResource($id) {
		foreach(Resource::getAllResources() as $resource) {
			if ($resource->getID() === $id) {
				return $resource;
			}
		}
		throw new Exception($id." is not a known image ID.");
	}
}
?>