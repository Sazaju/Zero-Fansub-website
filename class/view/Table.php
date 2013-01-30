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
			$component = new TableCell($component, $this->isHeader());
		}
		parent::addComponent($component);
	}
	
	private $isHeader = false;
	public function setHeader($boolean) {
		$this->isHeader = $boolean;
	}
	
	public function isHeader() {
		return $this->isHeader;
	}
}

class TableCell extends DefaultHtmlComponent {
	public function __construct($content = null, $isHeader = false) {
		$this->setContent($content);
		$this->setHeader($isHeader);
	}
	
	public function getHtmlTag() {
		return $this->isHeader() ? 'th' : 'td';
	}
	
	public function isAutoClose() {
		return false;
	}
	
	private $isHeader;
	public function setHeader($boolean) {
		$this->isHeader = $boolean;
	}
	
	public function isHeader() {
		return $this->isHeader;
	}
}
?>