<?php
/*
	A persistent component is an HTML component which can be stored in the
	database.
*/

interface IPersistentComponent extends IHtmlComponent {
	public function getDatabaseComponent();
	public function load();
	public function isLoaded();
}
?>
