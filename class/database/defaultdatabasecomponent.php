<?php
/*
	This class gives the default implementation of a database component.
*/

require_once("database.php");
require_once("idatabasecomponent.php");

abstract class DefaultDatabaseComponent implements IDatabaseComponent {
	private $database = null;
	private $databaseId = null;
	private $data = null;
	
	public function __construct($id) {
		$this->setDatabase(Database::getDefaultDatabase());
		$this->setDatabaseId($id);
	}
	
	public function setDatabase(Database $db) {
		$this->database = $db;
	}
	
	public function getDatabase() {
		return $this->database;
	}
	
	public function setDatabaseId($id) {
		$this->databaseId = $id;
	}
	
	public function getDatabaseId() {
		return $this->databaseId;
	}
	
	public function getData() {
		return $this->data;
	}
	
	public function load() {
		$statement = $this->getDatabase()->getConnection()->prepare('select * from "'.$this->getDatabaseTable().'" where id = ?');
		$statement->execute(array($this->getDatabaseId()));
		$this->data = $statement->fetch();
	}
	
}
?>
