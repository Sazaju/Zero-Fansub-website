<?php
class DatabaseProjectList extends DefaultDatabaseContainer {
	public function getPossibleIds() {
		$statement = $this->getDatabase()->getConnection()->prepare('select id from "project"');
		$statement->execute();
		$ids = array();
		foreach($statement->fetchAll() as $row) {
			$ids[] = $row[0];
		}
		return $ids;
	}
	
	public function getComponent($id) {
		return new DatabaseProject($id);
	}
}
?>