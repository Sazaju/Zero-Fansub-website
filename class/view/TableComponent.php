<?php
/*
	The table classes allows to manage tables, meaning 2D arrays.
*/
class TableComponent extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'table';
	}
	
	public function isAutoClose() {
		return false;
	}
	
	public function addComponent($component) {
		if ($component instanceof TableRowComponent) {
			parent::addComponent($component);
		}
		else {
			throw new Exception("A table cannot get other components than table rows.");
		}
	}
}

class TableRowComponent extends DefaultHtmlComponent {
	public function getHtmlTag() {
		return 'tr';
	}
	
	public function isAutoClose() {
		return false;
	}
	
	public function addComponent($component) {
		if (!($component instanceof TableCellComponent)) {
			$component = new TableCellComponent($component);
		}
		parent::addComponent($component);
	}
}

class TableCellComponent extends DefaultHtmlComponent {
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

class TableHeaderComponent extends TableCellComponent {
	public function getHtmlTag() {
		return 'th';
	}
	
	public function isAutoClose() {
		return false;
	}
}
?>