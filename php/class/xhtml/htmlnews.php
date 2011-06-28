<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/

require_once("simpleblockcomponent.php");
require_once("htmlimage.php");

class HtmlNews extends SimpleBlockComponent {
	private $title = '';
	private $text = '';
	private $image = null;
	
	function __construct() {
		$this->setClass('news');
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
		$content .= '<div class="content">';
		$this->image->generateHtml();
		$content .= '<div class="image">'.$this->image->getHtml().'</div>';
		$content .= '<div class="text">'.$this->text.'</div>';
		$content .= '</div>';
		
		return $content;
	}
}
?>
