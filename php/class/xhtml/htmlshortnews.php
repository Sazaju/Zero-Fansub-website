<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/

class HtmlShortNews extends SimpleBlockComponent {
	private $title = '';
	private $text = '';
	
	function __construct() {
		$this->setClass('short_news');
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
