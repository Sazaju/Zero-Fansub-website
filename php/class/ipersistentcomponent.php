<?php
/*
	A persistent component is an HTML component which can be stored in the
	database.
*/

interface IPersistentComponent {
	public function getHtmlComponent();
	public function getDatabaseComponent();
	public function load();
}
?>
