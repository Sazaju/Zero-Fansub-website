<?php
/*
	The database class wrap all the needed database code (PDO-based) with the
	specific data of this website. In particular, a testing mode is available,
	giving an initial database in memory.
*/

class Database {
	private $connection;
	
	function __construct($testing = false) {
		if ($testing) {
			$this->connection = new PDO('sqlite::memory:', "", "");
		}
		else {
			throw new Exception("No database defined. Do you mean a testing base ?");
			// $this->connection = new PDO('mysql:host=localhost;dbname=test', "user", "password", array(PDO::ATTR_PERSISTENT => true));
		}
	}
}
?>
