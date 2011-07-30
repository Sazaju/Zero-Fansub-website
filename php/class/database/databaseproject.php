<?php
require_once("defaultdatabasecomponent.php");

class DatabaseProject extends DefaultDatabaseComponent {
	
	public function getDatabaseTable() {
		return 'project';
	}
}
?>
