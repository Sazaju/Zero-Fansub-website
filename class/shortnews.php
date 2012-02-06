<?php
/*
	A short news is a news reduced to a title and the start of the initial news.
*/

class ShortNews extends SimpleBlockComponent implements IPersistentComponent {
	private $title = '';
	private $text = '';
	private $databaseComponent = null;
	private $isLoaded = false;
	
	public function __construct($id) {
		$this->setClass('short_news');
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
	
	public function getContent() {
		$content = '';
		// TODO simplify the architecture
		$content .= '<div class="title">'.$this->title.'</div>';
		$content .= '<div class="text">';
		$content .= Format::convertTextToHtml(Format::truncateText($this->text, 150));
		$content .= '</div>';
		
		return $content;
	}
}
?>