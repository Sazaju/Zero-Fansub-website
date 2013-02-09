<?php
	$db = Database::getDefaultDatabase();
	$url = Url::getCurrentUrl();
	$class = $url->getQueryVar('class');
	$level = $url->getQueryVar('level');
	$table = new Table();
	if ($level == 'structure') {
		$history = $db->getClassHistory($class);
		
		/**********************************\
					FIELDS
		\**********************************/
		
		$fieldIds = $history->getAllFieldIds();
		$row = new TableRow();
		$row->setHeader(true);
		$row->addComponent("");// time + author
		$row->addComponent("CLASS");
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
			
			$update = $history->getNameUpdateAt($time);
			if ($update !== null) {
				$row->addComponent($update);
			} else {
				$cell = new TableCell();
				$cell->setClass('same');
				$row->addComponent($cell);
			}
			
			$updates = $history->getFieldsUpdatesAt($time);
			foreach($fieldIds as $fieldId) {
				if (array_key_exists($fieldId, $updates)) {
					$content = array();
					$cell = new TableCell();
					$data = $updates[$fieldId];
					$notNull = array_filter($data);
					if (empty($notNull)) {
						$cell->setClass(empty($content) ? 'deleted' : '');
					} else {
						$name = $data['name'];
						$type = $data['type'];
						$mandatory = $data['mandatory'] ? 'mandatory' : 'facultative';
						$content = "$name\n($type)\n$mandatory";
						$cell->setContent(Format::convertTextToHtml($content));
					}
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
		
		$historyType = "Structure";
		$pageTitle = $class;
	} else if ($level == 'data') {
		$keyData = array();
		$keys = $db->getKeys($class);
		$key = $keys[0];
		foreach($key as $field) {
			if ($url->hasQueryVar('key_'.$field)) {
				$keyData[$field] = $url->getQueryVar('key_'.$field);
			} else {
				throw new Exception("Incomplete key: the field '".$field."' is not provided");
			}
		}
		
		$history = $db->getRecordHistory($class, $keyData);
		
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
		
		$historyType = "Enregistrement";
		$pageTitle = $class.'('.Format::arrayWithKeysToString($keyData).')';
	} else {
		throw new Exception("The level '$level' is not managed.");
	}
	
	$page = PageContent::getInstance();
	$page->setClass('history');
	$page->addComponent(new Title("Historique ".$historyType, 1));
	$page->addComponent(new Title($pageTitle, 2));
	$page->addComponent($table);
?>