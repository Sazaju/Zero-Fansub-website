<?php
/*
	A project is a complete presentation of a specific projet of teh team.
*/

class Project extends SimpleBlockComponent implements IPersistentComponent {
	private $title = '';
	private $description = '';
	private $image = null;
	private $databaseComponent = null;
	private $isLoaded = false;
	
	public function __construct($id) {
		$this->setClass('project');
		$this->databaseComponent = new DatabaseProject($id);
	}
	
	public function getDatabaseComponent() {
		return $this->databaseComponent;
	}
	
	public function load() {
		$this->databaseComponent->load();
		$data = $this->databaseComponent->getData();
		$this->setTitle($data['title']);
		$this->setdescription($data['description']);
		$image = new Image($data['image_id']);
		$image->load();
		$this->setImage($image);
		$this->isLoaded = true;
	}

	public function isLoaded(){
		return $this->isLoaded;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setImage(Image $image) {
		$this->image = $image;
	}
	
	public function getImage() {
		return $this->image;
	}
	
	public function getContent() {
		$content = '';
		// TODO simplify the architecture
		$content .= '<div class="title">'.$this->title.'</div>';
		$content .= '<div class="description">';
		$this->image->generateHtml();
		$pin = new Pin();
		$content .= '<div class="image">'.$this->image->getHtml().'</div>';
		$content .= Format::convertTextToHtml($this->description);
		$content .= $pin->getHtml();
		$content .= '</div>';
		
		return $content;
	}
}
?>
