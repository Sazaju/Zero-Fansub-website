<?php
class Resource {
	private $id = null;
	private $extension = null;
	private $content = array();
	private $name = null;
	private $tempUrl = null;
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function addResource($id) {
		$this->content[] = $id;
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function hasContent() {
		return !empty($this->content);
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
	
	public function getFullName() {
		$name = $this->name;
		if ($this->extension != null) {
			$name .= '.'.$this->extension;
		}
		return $name;
	}
	
	public function getURL() {
		if ($this->tempUrl != null) {
			return new URL($this->tempUrl);
		} else if ($this->id == null) {
			return null;
		} else {
			$url = 'resources/'.$this->id;
			if ($this->extension != null) {
				$url .= '.'.$this->extension;
			} else {
				// ignore extension
			}
			return new Url($url);
		}
	}
	
	public function exists() {
		$url = $this->getURL();
		return $url != null && file_exists($url->toString());
	}
	
	public function hasTempFile() {
		return $this->tempUrl != null;
	}
	
	public function deleteFile() {
		$isTemp = $this->hasTempFile();
		unlink($this->getURL()->toString());
		if ($isTemp) {
			$this->tempUrl = null;
		}
	}
	
	public function generateTempFile() {
		if ($this->exists()) {
			throw new Exception("The file ".$this->getFullName()." already exists at ".$this->getURL()->toString());
		} else {
			if ($this->hasContent()) {
				if (!file_exists('temp')) {
					mkdir('temp');
					chmod('temp', 0777);// put the rights in the mkdir does not always work
				}
				$zipPath = tempnam('temp', 'res');
				$zip = new ZipArchive();
				if ($zip->open($zipPath, ZIPARCHIVE::CREATE) === TRUE) {
					foreach($this->content as $id) {
						$resource = Resource::getResource($id);
						$name = $resource->getFullName();
						$url = $resource->getURL()->toString();
						$zip->addFile($url, $name);
					}
					$zip->close();
					$this->tempUrl = $zipPath;
				} else {
					throw new Exception("Failed to open ".$zipPath);
				}
			} else {
				throw new Exception("Cannot generate ".$this);
			}
		}
	}
	
	public function __toString() {
		$id = $this->id;
		if ($id === null) {
			$id = '#';
		}
		$ext = $this->extension;
		if ($ext != null) {
			$ext = '.'.$ext;
		}
		
		return $id.$ext;
	}
	
	private static $allResource = null;
	public static function getAllResources() {
		if (Resource::$allResource === null) {
			$resource = new Resource();
			$resource->setID(1);
			$resource->setName("Wallpaper Mitsudomoe 1");
			$resource->setExtension("png");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(2);
			$resource->setName("Wallpaper Mitsudomoe 2");
			$resource->setExtension("png");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(3);
			$resource->setName("Wallpaper Mitsudomoe 3");
			$resource->setExtension("png");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(4);
			$resource->setName("Wallpaper Mitsudomoe 4");
			$resource->setExtension("png");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(5);
			$resource->setName("Wallpaper Mitsudomoe 5");
			$resource->setExtension("png");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(6);
			$resource->setName("Wallpaper Mitsudomoe 6");
			$resource->setExtension("png");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(7);
			$resource->setName("Wallpaper Mitsudomoe 7");
			$resource->setExtension("png");
			Resource::$allResource[] = $resource;
			
			$resource = new Resource();
			$resource->setID(8);
			$resource->setName("Wallpaper Mitsudomoe 8");
			$resource->setExtension("png");
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