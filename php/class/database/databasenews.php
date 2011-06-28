<?php
require_once("defaultdatabasecomponent.php");

class DatabaseNews extends DefaultDatabaseComponent {
	
	public function getDatabaseTable() {
		return 'news';
	}
}
?>
