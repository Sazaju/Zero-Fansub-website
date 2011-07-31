<?php
/*
	A database container is aware of several database components. It is not a database component
	itself, as the elements it contains are stored separately in the database (there is nothing in
	the database which groups them explicitly).
*/

interface IDatabaseContainer {
	public function getDatabase();
	public function getPossibleIds();
	public function getComponent($id);
	public function cache(IDatabaseComponent $component);
	public function cacheAll();
	public function clearCache();
	public function getCachedComponents();
}
?>
