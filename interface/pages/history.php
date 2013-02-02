<?php
	$db = Database::getDefaultDatabase();
	$url = Url::getCurrentUrl();
	if (!$url->hasQueryVar('class')) {
		throw new Exception("No class provided.");
	} else {
		// continue loading
	}
	$class = $url->getQueryVar('class');
	$keyData = array();
	foreach($db->getIDFieldsForClass($class) as $field) {
		if ($url->hasQueryVar('key_'.$field)) {
			$keyData[$field] = $url->getQueryVar('key_'.$field);
		} else {
			throw new Exception("Incomplete key: the field '".$field."' is not provided");
		}
	}
	
	$history = $db->getRecordHistory($class, $keyData, true);
	$table = new Table();
	
	/**********************************\
	               FIELDS
	\**********************************/
	
	$fields = $history->getAllFields();
	$row = new TableRow();
	$row->setHeader(true);
	$row->addComponent("");// time + author
	foreach($fields as $field) {
		$row->addComponent($field);
	}
	$table->addComponent($row);
	
	/**********************************\
	              VALUES
	\**********************************/
	
	
	$milestones = $history->getUpdateTimes();
	rsort($milestones);
	$contentLimit = 20;
	foreach($milestones as $time) {
		$row = new TableRow();
		$row->addComponent(date("Y-m-d H:i:s", $time).'<br/>('.$history->getAuthorAt($time).')');
		$updates = $history->getUpdatesAt($time);
		foreach($fields as $field) {
			if (array_key_exists($field, $updates)) {
				$content = $updates[$field];
				if (strlen($content) > $contentLimit) {
					$content = substr($content, 0, $contentLimit)."...";
				} else {
					// keep the full content
				}
				$cell = new TableCell($content);
				$cell->setClass($content === null ? 'deleted' : '');
				$row->addComponent($cell);
			} else {
				$cell = new TableCell();
				$cell->setClass('same');
				$row->addComponent($cell);
			}
		}
		$table->addComponent($row);
	}
	
	/**********************************\
	               DISPLAY
	\**********************************/
	
	$page = PageContent::getInstance();
	$page->setClass('history');
	$page->addComponent(new Title("Historique Enregistrement", 1));
	$page->addComponent(new Title($class.'('.Format::arrayWithKeysToString($keyData).')', 2));
	$page->addComponent($table);
?>