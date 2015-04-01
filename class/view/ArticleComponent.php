<?php
/*
	This is the basic implementation of an article component (article tag), which is independent to the articles just before/after.
*/

class ArticleComponent extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'article';
	}
	
	public function isAutoClose() {
		return false;
	}
}
?>