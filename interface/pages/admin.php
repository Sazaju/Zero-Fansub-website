<?php
	$page = PageContent::getInstance();
	$page->setClass('admin');
	$page->addComponent(new Title("Administration BDD", 1));
	
	$db = Database::getDefaultDatabase();
	
	$table = new Table();
	$row = new TableRow();
	$row->setHeader(true);
	$row->addComponent("ID");
	$row->addComponent("VALEUR");
	$table->addComponent($row);
	foreach($db->getPropertyNames() as $id) {
		$row = new TableRow();
		$row->addComponent($id);
		$row->addComponent($db->getProperty($id));
		$table->addComponent($row);
	}
	$page->addComponent(new Title("Propriétés", 2));
	$page->addComponent($table);
	
	$table = new Table();
	$row = new TableRow();
	$row->setHeader(true);
	$row->addComponent("ID");
	$row->addComponent("PASS");
	$table->addComponent($row);
	foreach($db->getUsers() as $name) {
		$row = new TableRow();
		$row->addComponent($name);
		$row->addComponent($db->isIdentifiableUser($name) ? "oui" : "non");
		$table->addComponent($row);
	}
	$page->addComponent(new Title("Utilisateurs", 2));
	$page->addComponent($table);
	
	$table = new Table();
	$row = new TableRow();
	$row->setHeader(true);
	$row->addComponent("");//history
	$row->addComponent("CLASSES");
	$table->addComponent($row);
	$classMetas = $db->getClassesMetadata();
	foreach($db->getClasses() as $class) {
		$row = new TableRow();
		
		$toolUrl = new Url();
		$toolUrl->setQueryVar("page", "history");
		$toolUrl->setQueryVar("level", "structure");
		$toolUrl->setQueryVar("class", $class);
		$row->addComponent(new Link($toolUrl->toString(), "H"));
		
		$structureUrl = Url::getCurrentUrl();
		$structureUrl->setQueryVar('class', $class);
		$cell = new TableCell(new Link($structureUrl->toString(), $class));
		$cell->setClass('class');
		$cell->setMetaData('title', 'Modifié le '.date("Y-m-d H:i:s", $classMetas[$class]['timestamp']).'&#013;par '.$classMetas[$class]['author']);
		$row->addComponent($cell);
		
		$keys = $db->getKeys($class);
		$key = $keys[0];
		foreach($db->getFieldsMetadata($class) as $field => $data) {
			$cell = new TableCell($field);
			$cell->setClass('field '.(in_array($field, $key) ? 'key' : ''));
			$cell->setMetaData('title', 'type = '.$data['type'].'&#013;'.($data['mandatory'] ? 'obligatoire' : 'facultatif').'&#013;modifié le '.date("Y-m-d H:i:s", $data['timestamp']).'&#013;par '.$data['author']);
			$row->addComponent($cell);
		}
		$table->addComponent($row);
	}
	$page->addComponent(new Title("Structures", 2));
	$page->addComponent($table);
	
	/**********************************\
	       DISPLAY SPECIFIC CLASS
	\**********************************/
	
	$url = Url::getCurrentUrl();
	if ($url->hasQueryVar('class')) {
		$class = $url->getQueryVar('class');
		$table = new Table();
		$row = new TableRow();
		$row->setHeader(true);
		$row->addComponent("");//tools
		$keys = $db->getKeys($class);
		$key = $keys[0];
		$fields = $db->getFieldsMetadata($class);
		foreach($fields as $field => $data) {
			$cell = new TableCell($field, true);
			$cell->setClass('field '.(in_array($field, $key) ? 'key' : ''));
			$cell->setMetaData('title', 'type = '.$data['type'].'&#013;'.($data['mandatory'] ? 'obligatoire' : 'facultatif').'&#013;modifié le '.date("Y-m-d H:i:s", $data['timestamp']).'&#013;par '.$data['author']);
			$row->addComponent($cell);
		}
		$table->addComponent($row);
		
		$contentLimit = 20;
		foreach($db->getDataMetadata($class) as $record) {
			$row = new TableRow();
			$toolCell = new TableCell();
			$row->addComponent($toolCell);
			$toolUrl = new Url();
			$toolUrl->setQueryVar("class", $class);
			foreach($fields as $field => $data) {
				$metadata = $record[$field];
				$content = $metadata['value'];
				if (in_array($field, $key)) {
					$toolUrl->setQueryVar('key_'.$field, $content);
				} else {
					// do not consider it in the history link
				}
				if ($data['type'] == 'string' && strlen($content) > $contentLimit) {
					$content = substr($content, 0, $contentLimit)."...";
				} else {
					// keep the full content
				}
				$cell = new TableCell($content);
				$cell->setClass('value '.(in_array($field, $key) ? 'key' : ''));
				$cell->setMetaData('title', 'type = '.$data['type'].'&#013;'.($data['mandatory'] ? 'obligatoire' : 'facultatif').'&#013;modifié le '.date("Y-m-d H:i:s", $metadata['timestamp']).'&#013;par '.$metadata['author']);
				$row->addComponent($cell);
			}
			$toolUrl->setQueryVar("page", "history");
			$toolUrl->setQueryVar("level", "data");
			$toolCell->addComponent(new Link($toolUrl->toString(), "H"));
			$toolUrl->setQueryVar("page", "changeRecord");
			$toolUrl->removeQueryVar("level");
			$toolCell->addComponent(new Link($toolUrl->toString(), "M"));
			$table->addComponent($row);
		}
		$page->addComponent(new Title("Enregistrements ".$class, 2));
		$page->addComponent($table);
	} else {
		$page->addComponent("Cliquez sur le nom d'une classe pour afficher les enregistrements concernés, ou cliquez sur son lien d'historique pour afficher les évolutions de sa structure.");
	}
?>