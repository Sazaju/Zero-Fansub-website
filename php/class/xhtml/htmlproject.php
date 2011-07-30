<?php
/*
	A project is a complete presentation of a specific projet of teh team.
*/

class HtmlProject extends SimpleBlockComponent {
	private $title = '';
	private $description = '';
	private $image = null;
	
	function __construct() {
		$this->setClass('project');
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
	
	public function setImage(HtmlImage $image) {
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
