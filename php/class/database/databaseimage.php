<?php
require_once("defaultdatabasecomponent.php");

class DatabaseImage extends DefaultDatabaseComponent {
	
	public function getDatabaseTable() {
		return 'image';
	}
}
?>
