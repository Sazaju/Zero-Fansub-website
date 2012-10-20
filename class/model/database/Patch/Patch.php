<?php
define('PATCH_ID_JOKER', '*');

class Patch {
	private $user = null;
	private $time = null;
	private $instructions = array();
	
	public function __construct($user = null, $time = -1) {
		$time = $time === -1 ? time() : $time;// time() cannot be used as a default parameter
		$this->setUser($user);
		$this->setTime($time);
	}
	
	public static function buildFromDiff(StructureDiff $diff, $user, $time = -1) {
		$patch = new Patch($user, $time);
		foreach($diff->toArray() as $row) {
			$instruction = null;
			if ($row instanceof AddFieldDiff) {
				$instruction = new PatchAddField();
				$data = $row->getNewValue();
				$instruction->setValue("+".$row->getClass().'.'.$data['field']."(".$data['type'].",".($data['mandatory'] ? 'mandatory' : 'optional').")");
			} else if ($row instanceof RemoveFieldDiff) {
				$instruction = new PatchRemoveField();
				$data = $row->getOldValue();
				$instruction->setValue("-".$row->getClass().'.'.$data['field']);
			} else if ($row instanceof RenameFieldDiff) {
				throw new Exception("Not implemented yet");
			} else if ($row instanceof ChangeKeyDiff) {
				$instruction = new PatchSetClassKey();
				$instruction->setValue($row->getClass().'='.'['.implode(', ', $row->getNewValue()).']');
			} else if ($row instanceof ChangeTypeDiff) {
				$instruction = new PatchChangeFieldType();
				$instruction->setValue($row->getClass().'.'.$row->getField().'.type='.$row->getNewValue());
			} else if ($row instanceof ChangeMandatoryDiff) {
				$instruction = new PatchChangeFieldMandatory();
				$instruction->setValue($row->getClass().'.'.$row->getField().'.mandatory='.$row->getNewValue());
			} else {
				throw new Exception(get_class($row)." is not a managed diff element");
			}
			$patch->addInstruction($instruction);
		}
		return $patch;
	}
	
	public function appendScript($script) {
		$prefix = "#^(";
		$suffix = ")(?:\n.*)?$#s";
		while(!empty($script)) {
			$script = trim($script);
			$rootInstructions = array(
				new PatchComment(),
				new PatchAttributes(),// TODO extract at a higher level (static function building from text)
				new PatchUser(),
				new PatchAddField(),
				new PatchRemoveField(),
				new PatchSetClassKey(),
				new PatchAddRecord(),
				new PatchRemoveRecord(),
				new PatchChangeRecordField(),
				new PatchChangeFieldType(),
				new PatchChangeFieldMandatory(),
			);
			$instruction = null;
			$matches = array();
			do {
				$instruction = array_shift($rootInstructions);
			} while($instruction != null && !preg_match($prefix.$instruction->getFormattedRegex('#').$suffix, $script, $matches));
			
			if ($instruction != null) {
				$extract = $matches[1];
				$instruction->setValue($extract);
				if ($instruction instanceof PatchAttributes) {
					$this->setUser($instruction->getUser());
					$this->setTime((int) $instruction->getTime());
				} else if ($instruction instanceof PatchComment) {
					// just ignore it
				} else {
					$this->addInstruction($instruction);
				}
				$script = substr($script, strlen($extract));
			} else {
				throw new Exception("The given patch cannot be parsed from there: $script");
			}
			$this->progressiveCheck();
		}
	}
	
	public static function buildFromScript($script) {
		$patch = new Patch();
		$patch->appendScript($script);
		return $patch;
	}
	
	private function addInstruction($instruction) {
		$this->instructions[] = $instruction;
	}
	
	private function setUser($user) {
		$this->user = $user;
	}
	
	private function setTime($time) {
		$this->time = $time;
	}
	
	public function getInstructions() {
		return $this->instructions;
	}
	
	public function getUser() {
		return $this->user;
	}
	
	public function getTime() {
		return $this->time;
	}
	
	public function __tostring() {
		$string = "";
		
		$attributes = new PatchAttributes();
		$attributes->setValue('[time='.$this->getTime().',user="'.$this->getUser().'"]');
		$string .= $attributes->getValue()."\n";
		
		foreach($this->instructions as $instruction) {
			$string .= $instruction->getValue()."\n";
		}
		
		return $string;
	}
	
	private function progressiveCheck() {
		static $initialized = false;
		if (!$initialized) {
			$userOK = $this->user != null;
			$timeOK = $this->time >= 0;
			$instructionsEmpty = empty($this->instructions);
			if (!$userOK && !$timeOK && $instructionsEmpty) {
				// before initialization: OK
			} else if ($userOK && !$timeOK && $instructionsEmpty) {
				// during initialization: OK
			} else if (!$userOK && $timeOK && $instructionsEmpty) {
				// during initialization: OK
			} else if (!$userOK && !$timeOK && !$instructionsEmpty) {
				throw new Exception("User and time attributes are missing, cannot have instructions before them.");
			} else if ($userOK && !$timeOK && !$instructionsEmpty) {
				throw new Exception("Time attribute is missing, cannot have instructions before it.");
			} else if (!$userOK && $timeOK && !$instructionsEmpty) {
				throw new Exception("User attribute is missing, cannot have instructions before it.");
			} else if ($userOK && $timeOK) {
				// initialization ended: OK
				$initialized = true;
				if ($instructionsEmpty) {
					// initialization just finished, no more check is needed
				} else {
					// check instructions
					$this->progressiveCheck();
				}
			} else {
				throw new Exception("This case should never happen");
			}
		} else {
			static $checkedInstructions = array();
			for($i = 0 ; $i < count($checkedInstructions) ; $i++) {
				if ($checkedInstructions[$i] === $this->instructions[$i]) {
					// no change, continue
				} else {
					throw new Exception("The checked instructions have changed, there is a problem in the parsing function");
				}
			}
			
			// TODO, check instructions.
			// When an instruction is checked, add it to $checkedInstructions.
			// Think about constraints discovered during the check
		}
	}
	
	public static function protectStringValue($value) {
		$value = str_replace('\\', '\\\\', $value);
		$value = str_replace('"', '\\"', $value);
		$value = '"'.$value.'"';
		return $value;
	}
	
	public static function cleanStringValue($value) {
		$value = substr($value, 1, -1);
		$value = str_replace('\\"', '"', $value);
		$value = str_replace('\\\\', '\\', $value);
		return $value;
	}
}
?>
