<?php
class PersistentTable {
	private $type;
	private $isArchiveMode = false;
	
	private function __construct($type) {
		$this->type = $type;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function setArchiveMode($boolean) {
		$this->isArchiveMode = $boolean;
	}
	
	public function isArchiveMode() {
		return $this->isArchiveMode;
	}
	
	public function getName() {
		return ($this->isArchiveMode() ? 'archive_' : 'working_').$this->type;
	}
	
	private function getColumnDescriptors() {
		$columns = array();
		$columns[] = new ColumnDescriptor('id', 'INTEGER NOT NULL');
		
		if ($this->type == 'class') {
			$columns[] = new ColumnDescriptor('class', 'VARCHAR(128) NOT NULL');
		} else if ($this->type == 'field') {
			$columns[] = new ColumnDescriptor('class_id', 'INTEGER NOT NULL');
			$columns[] = new ColumnDescriptor('field', 'VARCHAR(128) NOT NULL');
			$columns[] = new ColumnDescriptor('type', 'VARCHAR(128) NOT NULL');
			$columns[] = new ColumnDescriptor('mandatory', 'BOOLEAN NOT NULL');
		} else if ($this->type == 'key') {
			$columns[] = new ColumnDescriptor('field_id', 'INTEGER NOT NULL');
		} else {
			$columns[] = new ColumnDescriptor('field_id', 'INTEGER NOT NULL');
			$dbType = null;
			if ($this->type == "boolean") {
				$dbType = 'BOOLEAN';
			} else if ($this->type == "integer") {
				$dbType = 'INTEGER';
			} else if ($this->type == "double") {
				$dbType = 'DOUBLE';
			} else if ($this->type == "string") {
				$dbType = 'TEXT';
			} else if (preg_match("#^string[0-9]+$#", $this->type)) {
				$dbType = 'VARCHAR('.substr($this->type, 6).')';
			} else {
				throw new Exception("'".$this->type."' is not a managed type.");
			}
			$columns[] = new ColumnDescriptor('value', $dbType);
		}
		
		if ($this->isArchiveMode()) {
			$columns[] = new ColumnDescriptor('timeCreate', 'INTEGER NOT NULL');
			$columns[] = new ColumnDescriptor('authorCreate_id', 'INTEGER NOT NULL');
			$columns[] = new ColumnDescriptor('timeArchive', 'INTEGER NOT NULL');
			$columns[] = new ColumnDescriptor('authorArchive_id', 'INTEGER NOT NULL');
		} else {
			$columns[] = new ColumnDescriptor('timestamp', 'INTEGER NOT NULL');
			$columns[] = new ColumnDescriptor('author_id', 'INTEGER NOT NULL');
		}
		return $columns;
	}
	
	public function getColumnNames() {
		return array_map(function($d) {return $d->getName();}, $this->getColumnDescriptors());
	}
	
	public function getColumnDefinitions() {
		return array_map(function($d) {return $d->getDefinition();}, $this->getColumnDescriptors());
	}
	
	public function getConstraints() {
		$constraints = array();
		$specific = $this->isArchiveMode() ? ', timeCreate' : '';
		if ($this->type == 'class') {
			$constraints[] = 'PRIMARY KEY (id'.$specific.')';
			$constraints[] = 'UNIQUE(class'.$specific.')';
		} else if ($this->type == 'field') {
			$constraints[] = 'PRIMARY KEY (id'.$specific.')';
			$constraints[] = 'UNIQUE(class_id, field'.$specific.')';
		} else if ($this->type == 'key') {
			$constraints[] = 'PRIMARY KEY (id'.$specific.')';
			$constraints[] = 'UNIQUE (id, field_id'.$specific.')';
		} else {
			$constraints[] = 'PRIMARY KEY (id, field_id'.$specific.')';
		}
		
		if ($this->isArchiveMode()) {
			$constraints[] = 'FOREIGN KEY (authorCreate_id) REFERENCES user(id)';
			$constraints[] = 'FOREIGN KEY (authorArchive_id) REFERENCES user(id)';
		} else {
			$constraints[] = 'FOREIGN KEY (author_id) REFERENCES user(id)';
			
			// Specific foreign keys which cannot be in archive tables.
			// (can be linked to working or archive stuff)
			if (in_array('class_id', $this->getColumnNames())) {
				$constraints[] = 'FOREIGN KEY (class_id) REFERENCES working_class(id)';
			} else if (in_array('field_id', $this->getColumnNames())) {
				$constraints[] = 'FOREIGN KEY (field_id) REFERENCES working_field(id)';
			}
		}
		return $constraints;
	}
	
	public function getCreationScript($ifNotExists = false) {
		$check = $ifNotExists ? 'IF NOT EXISTS' : '';
		$name = $this->getName();
		$columns = Format::arrayToString($this->getColumnDefinitions());
		$constraints = Format::arrayToString($this->getConstraints());
		return 'CREATE TABLE '.$check.' "'.$name.'" ('.$columns.', '.$constraints.')';
	}
	
	private static $tables = array();
	public static function getTableFor($type) {
		if (array_key_exists($type, PersistentTable::$tables)) {
			// do not recreate it
		} else {
			PersistentTable::$tables[$type] = new PersistentTable($type);
		}
		return PersistentTable::$tables[$type];
	}
}

class ColumnDescriptor {
	private $name;
	private $parameters;
	
	public function __construct($name, $parameters) {
		$this->name = $name;
		$this->parameters = $parameters;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getDefinition() {
		return $this->name.' '.$this->parameters;
	}
}
?>