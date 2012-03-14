<?php
/*
	The table classes allows to manage tables, meaning 2D arrays.
*/
class Table extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'table';
	}
	
	public function isAutoClose() {
		return false;
	}
	
	public function addComponent($component) {
		if ($component instanceof TableRow) {
			parent::addComponent($component);
		}
		else {
			throw new Exception("A table cannot get other components than table rows.");
		}
	}
}

class TableRow extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'tr';
	}
	
	public function isAutoClose() {
		return false;
	}
	
	public function addComponent($component) {
		if (!($component instanceof TableCell)) {
			$component = new TableCell($component);
		}
		parent::addComponent($component);
	}
}

class TableCell extends DefaultHtmlComponent {
	public function __construct($content = null) {
		$this->setContent($content);
	}
	
	public function getHtmlTag() {
		return 'td';
	}
	
	public function isAutoClose() {
		return false;
	}
}

class TableHeader extends TableCell {
	public function getHtmlTag() {
		return 'th';
	}
	
	public function isAutoClose() {
		return false;
	}
}
?>