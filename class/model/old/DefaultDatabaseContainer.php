<?php
/*
	This class gives the default implementation of a database container.
*/

abstract class DefaultDatabaseContainer implements IDatabaseContainer {
	private $database = null;
	private $databaseId = null;
	private $cachedComponents = array();
	private $data = null;
	
	public function __construct() {
		$this->setDatabase(Database::getDefaultDatabase());
	}
	
	public function setDatabase(Database $db) {
		$this->database = $db;
	}
	
	public function getDatabase() {
		return $this->database;
	}
	
	public function cache(IDatabaseComponent $component) {
		$this->cachedComponents[] = $component;
	}
	
	public function cacheAll() {
		foreach($this->getPossibleIds() as $id) {
			$this->cache($this->getComponent($id));
		}
	}
	
	public function clearCache() {
		$cachedComponents = array();
	}
	
	public function getCachedComponents() {
		return $this->cachedComponents;
	}
}
?>