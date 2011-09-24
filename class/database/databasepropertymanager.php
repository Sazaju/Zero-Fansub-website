<?php
class DatabasePropertyManager {
	
	public static function read($property) {
		$statement = Database::getDefaultDatabase()->getConnection()->
				prepare('select * from "property" where id = ?');
		$statement->execute(array($property));
		$data = $statement->fetch();
		if ($data === false) {
			throw new Exception("impossible to read the property '$property'");
		}
		else {
			return $data['value'];
		}
	}
}
?>
