<?php
/*
	A database component is a (HTML) component which has its data stored in the
	database. This interface allow to read/write in the database.
*/

interface IDatabaseComponent {
	public function getDatabase();
	public function getDatabaseTable();
	public function getDatabaseId();
	public function load();
}
?>
