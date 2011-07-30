<?php
/*
	An image is a simple picture which can have some attributes.
*/

class Image extends DefaultHtmlComponent implements IPersistentComponent {
	private $source = '';
	private $alternative = '';
	private $databaseComponent = null;
	private $isLoaded = false;
	
	public function __construct($id) {
		$this->databaseComponent = new DatabaseImage($id);
	}
	
	public function getDatabaseComponent() {
		return $this->databaseComponent;
	}
	
	public function load() {
		$this->databaseComponent->load();
		$data = $this->databaseComponent->getData();
		$this->setSource($data['url']);
		$this->setAlternative($data['title']);
		$this->isLoaded = true;
	}

	public function isLoaded(){
		return $this->isLoaded;
	}
	
	public function getHtmlTag() {
		return 'img';
	}
	
	public function setSource($url) {
		$this->source = $url;
	}
	
	public function getSource() {
		return $this->source;
	}
	
	public function setAlternative($alt) {
		$this->alternative = $alt;
	}
	
	public function getAlternative() {
		return $this->alternative;
	}
	
	public function getOptions() {
		$source = $this->getSource();
		$alt = $this->getAlternative();
		$sourcePart = ' src="'.$source.'"';
		$altPart = !empty($alt) ? ' alt="'.$alt.'"' : '';
		return parent::getOptions().$sourcePart.$altPart;
	}
}
?>
