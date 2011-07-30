<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/

class News extends SimpleBlockComponent implements IPersistentComponent {
	private $title = '';
	private $text = '';
	private $image = null;
	private $databaseComponent = null;
	private $isLoaded = false;
	
	public function __construct($id) {
		$this->setClass('news');
		$this->databaseComponent = new DatabaseNews($id);
	}
	
	public function getDatabaseComponent() {
		return $this->databaseComponent;
	}
	
	public function load() {
		$this->databaseComponent->load();
		$data = $this->databaseComponent->getData();
		$this->setTitle($data['title']);
		$this->setText($data['text']);
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
	
	public function setText($text) {
		$this->text = $text;
	}
	
	public function getText() {
		return $this->text;
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
		$content .= '<div class="text">';
		$this->image->generateHtml();
		$pin = new Pin();
		$content .= '<div class="image">'.$this->image->getHtml().'</div>';
		$content .= Format::convertTextToHtml($this->text);
		$content .= $pin->getHtml();
		$content .= '</div>';
		
		return $content;
	}
}
?>
