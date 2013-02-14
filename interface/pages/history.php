<?php
	$db = Database::getDefaultDatabase();
	$url = Url::getCurrentUrl();
	$class = $url->getQueryVar('class');
	$level = $url->getQueryVar('level');
	$table = new Table();
	if ($level == 'structure') {
		$structureHistory = $db->getClassHistory($class);
		
		/**********************************\
					FIELDS
		\**********************************/
		
		$fieldIds = $structureHistory->getAllFieldIds();
		$row = new TableRow();
		$row->setHeader(true);
		$row->addComponent("");// time + author
		$row->addComponent("CLASS");
		$table->addComponent($row);
		
		/**********************************\
					VALUES
		\**********************************/
		
		$milestones = $structureHistory->getUpdateTimes();
		rsort($milestones);
		$contentLimit = 20;
		foreach($milestones as $time) {
			$row = new TableRow();
			$row->addComponent(date("Y-m-d H:i:s", $time).'<br/>('.$structureHistory->getAuthorAt($time).')');
			
			$cell = new TableCell($structureHistory->getNameValueAt($time));
			if ($structureHistory->getNameUpdateAt($time) !== null) {
				$cell->setClass('update');
			} else {
				$cell->setClass('inherited');
			}
			$row->addComponent($cell);
			
			$updates = $structureHistory->getFieldsUpdatesAt($time);
			$values = $structureHistory->getFieldsValuesAt($time);
			foreach($fieldIds as $fieldId) {
				$content = array();
				$cell = new TableCell();
				$data = $values[$fieldId];
				$notNull = array_filter($data);
				if (empty($notNull)) {
					if (array_key_exists($fieldId, $updates)) {
						$cell->setClass('deleted');
					} else {
						$cell->setClass('inherited deleted');
					}
				} else {
					$name = $data['name'];
					$type = $data['type'];
					$mandatory = $data['mandatory'] ? 'mandatory' : 'optionnal';
					$content = "$name\n($type)\n$mandatory";
					$cell->setContent(Format::convertTextToHtml($content));
					if (array_key_exists($fieldId, $updates)) {
						$cell->setClass('update');
					} else {
						$cell->setClass('inherited');
					}
				}
				$row->addComponent($cell);
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
		
		$recordHistory = $db->getRecordHistory($class, $keyData);
		
		/**********************************\
					FIELDS
		\**********************************/
		
		$fieldIds = $recordHistory->getAllFieldIds();
		$row = new TableRow();
		$row->setHeader(true);
		$row->addComponent("");// time + author
		foreach($fieldIds as $fieldId) {
			$row->addComponent($fieldId);
		}
		$table->addComponent($row);
		
		/**********************************\
					VALUES
		\**********************************/
		
		
		$milestones = $recordHistory->getUpdateTimes();
		rsort($milestones);
		$contentLimit = 20;
		foreach($milestones as $time) {
			$row = new TableRow();
			$row->addComponent(date("Y-m-d H:i:s", $time).'<br/>('.$recordHistory->getAuthorAt($time).')');
			$updates = $recordHistory->getUpdatesAt($time);
			$values = $recordHistory->getValuesAt($time);
			foreach($fieldIds as $fieldId) {
				$content = $values[$fieldId];
				if (strlen($content) > $contentLimit) {
					$content = substr($content, 0, $contentLimit)."...";
				} else {
					// keep the full content
				}
				$cell = new TableCell($content);
				if (array_key_exists($fieldId, $updates)) {
					if ($values[$fieldId] === RecordHistory::DELETED) {
						$cell->setClass('deleted');
					} else {
						$cell->setClass('update');
					}
				} else {
					if ($values[$fieldId] === RecordHistory::DELETED) {
						$cell->setClass('inherited deleted');
					} else {
						$cell->setClass('inherited');
					}
				}
				$row->addComponent($cell);
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