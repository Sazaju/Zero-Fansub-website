<?php
define("PATCH_REGEX_COMMENT", '#[^#]*#');
define("PATCH_REGEX_CLASS", '([0-9a-zA-Z]*)');
define("PATCH_REGEX_FIELD", '([0-9a-zA-Z]*)');
define("PATCH_REGEX_FIELD_TYPE", '([0-9a-zA-Z]*)');
define("PATCH_REGEX_FIELD_MANDATORY", '((?:mandatory)|(?:optional))');
define("PATCH_REGEX_ATTRIBUTE", '((?:type)|(?:mandatory))');
define("PATCH_REGEX_STRING", '"((?:[^"]|(?:(?<=\\\\)"))*)"');
define("PATCH_REGEX_BOOLEAN", '((?:true)|(?:false))');
define("PATCH_REGEX_INTEGER", '([0-9]*)');

define("PATCH_REGEX_PATCH_ATTRIBUTES", '\[time\='.PATCH_REGEX_INTEGER.',user\='.PATCH_REGEX_STRING.'\]');

define("PATCH_REGEX_ID_FIELDS", '\[('.PATCH_REGEX_FIELD.'(?:,'.PATCH_REGEX_FIELD.')*)\]');
define("PATCH_REGEX_SELECT_FIELD", PATCH_REGEX_CLASS.'\.'.PATCH_REGEX_FIELD);
define("PATCH_REGEX_SELECT_ATTRIBUTE", PATCH_REGEX_SELECT_FIELD.'\.'.PATCH_REGEX_ATTRIBUTE);

define("PATCH_REGEX_VALUE", '((?:'.PATCH_REGEX_STRING.'|'.PATCH_REGEX_BOOLEAN.'|'.PATCH_REGEX_INTEGER.'))');
define("PATCH_REGEX_ID_VALUES", '\[('.PATCH_REGEX_VALUE.'(?:,'.PATCH_REGEX_VALUE.')*)\]');
define("PATCH_REGEX_SELECT_RECORD", PATCH_REGEX_CLASS.PATCH_REGEX_ID_VALUES);
define("PATCH_REGEX_SELECT_RECORD_FIELD", PATCH_REGEX_SELECT_RECORD.'\.'.PATCH_REGEX_FIELD);
define("PATCH_REGEX_ATTRIBUTE_VALUE", '((?:'.PATCH_REGEX_STRING.'|'.PATCH_REGEX_BOOLEAN.'|'.PATCH_REGEX_INTEGER.'|'.PATCH_REGEX_SELECT_ATTRIBUTE.'))');
define("PATCH_REGEX_FIELD_VALUE", '((?:'.PATCH_REGEX_STRING.'|'.PATCH_REGEX_BOOLEAN.'|'.PATCH_REGEX_INTEGER.'|'.PATCH_REGEX_SELECT_RECORD_FIELD.'))');

define("PATCH_REGEX_FIELD_VALUE_ASSIGNMENT", '('.PATCH_REGEX_FIELD.'\='.PATCH_REGEX_FIELD_VALUE.')');
define("PATCH_REGEX_FIELD_VALUE_MULTIASSIGNMENT", '\(('.PATCH_REGEX_FIELD_VALUE_ASSIGNMENT.'(?:,'.PATCH_REGEX_FIELD_VALUE_ASSIGNMENT.')*'.')?\)');

define("PATCH_REGEX_ADD_FIELD", '\+'.PATCH_REGEX_SELECT_FIELD.'\('.PATCH_REGEX_FIELD_TYPE.','.PATCH_REGEX_FIELD_MANDATORY.'\)');
define("PATCH_REGEX_REMOVE_FIELD", '-'.PATCH_REGEX_SELECT_FIELD);
define("PATCH_REGEX_CHANGE_ATTRIBUTE", PATCH_REGEX_SELECT_ATTRIBUTE.'\='.PATCH_REGEX_ATTRIBUTE_VALUE);
define("PATCH_REGEX_CHANGE_KEY", PATCH_REGEX_CLASS.'\='.PATCH_REGEX_ID_FIELDS);
define("PATCH_REGEX_ADD_RECORD", '\+'.PATCH_REGEX_CLASS.PATCH_REGEX_ID_FIELDS.PATCH_REGEX_FIELD_VALUE_MULTIASSIGNMENT);
define("PATCH_REGEX_REMOVE_RECORD", '-'.PATCH_REGEX_CLASS.PATCH_REGEX_ID_FIELDS);
define("PATCH_REGEX_CHANGE_RECORD", PATCH_REGEX_SELECT_RECORD_FIELD.'\='.PATCH_REGEX_FIELD_VALUE);

class PatchManager {
	public static function buildPatch(StructureDiff $diff, $user, $time = time) {
		
	}
	
	// TODO use a testing mode or rely on exceptions and begin/commit transaction?
	public static function executePatch(Database $db, $patch) {
		$matches = array();
		preg_match_all('#'.PATCH_REGEX_STRING.'#s ', $patch, $matches);
		$strings = array();
		foreach($matches[0] as $string) {
			$strings[$string] = str_replace("\n", "\\n", $string);
		}
		
		foreach($strings as $from => $to) {
			$patch = str_replace($from, $to, $patch);
		}
		$instructions = preg_split("#\n#", $patch);
		$instructions = array_filter($instructions, function($i) {
			$i = trim($i);
			return !empty($i);
		});
		foreach($instructions as $key => $instruction) {
			foreach($strings as $from => $to) {
				$instructions[$key] = str_replace($to, $from, $instruction);
			}
		}
		echo Debug::toString($instructions, "instructions");
		
		$time = null;
		$user = null;
		//TODO create an object which keep track of the data and apply when another data is considered
		foreach($instructions as $instruction) {
			$matches = array();
			if (preg_match('#^'.PATCH_REGEX_PATCH_ATTRIBUTES.'$#', $instruction, $matches)) {
				$time = $matches[1];
				$user = $matches[2];
				echo "new patch: user <b>$user</b> at <b>$time</b> (".date("Y-m-d H:i:s.u", $time).")";
			} else if (empty($time)) {
				throw new Exception("No time defined for the patch");
			} else if (empty($user)) {
				throw new Exception("No user defined for the patch");
			} else if (preg_match('#^'.PATCH_REGEX_ADD_FIELD.'$#', $instruction, $matches)) {
				$class = $matches[1];
				$fieldName = $matches[2];
				$type = $matches[3];
				$mandatory = $matches[4];
				echo "add <b>$mandatory $type</b> field <b>$fieldName</b> in class <b>$class</b>";
			} else if (preg_match('#^'.PATCH_REGEX_REMOVE_FIELD.'$#', $instruction, $matches)) {
				$class = $matches[1];
				$fieldName = $matches[2];
				echo "remove field <b>$fieldName</b> from class <b>$class</b>";
			} else if (preg_match('#^'.PATCH_REGEX_CHANGE_ATTRIBUTE.'$#', $instruction, $matches)) {
				$class = $matches[1];
				$fieldName = $matches[2];
				$attribute = $matches[3];
				$value = $matches[4];
				echo "change attribute <b>$attribute</b> of field <b>$fieldName</b> from class <b>$class</b> to <b>".nl2br($value)."</b>";
			} else if (preg_match('#^'.PATCH_REGEX_CHANGE_KEY.'$#', $instruction, $matches)) {
				$class = $matches[1];
				$fieldNames = preg_split("#,#", $matches[2]);
				echo "set ID to <b>".array_reduce($fieldNames, function($a, $b) {return $a = empty($a) ? $b:"$a,$b";})."</b> for class <b>$class</b>";
			} else if (preg_match('#^'.PATCH_REGEX_ADD_RECORD.'$#', $instruction, $matches)) {
				$class = $matches[1];
				$ids = preg_split("#,#", $matches[2]);
				$assignments = array();
				if (count($matches) > 4) {
					$fieldAssignments = preg_split("#,#", $matches[5]);
					foreach($fieldAssignments as $assignment) {
						$data = preg_split("#=#", $assignment);
						$assignments[$data[0]] = $data[1];
					}
				}
				echo "create record <b>[".array_reduce($ids, function($a, $b) {return $a = empty($a) ? $b:"$a,$b";})."]</b> for class <b>$class</b>";
				//echo Debug::toString($matches, "matches");
				//echo Debug::toString($assignments, "assign");
			} else if (preg_match('#^'.PATCH_REGEX_REMOVE_RECORD.'$#', $instruction, $matches)) {
				$class = $matches[1];
				$ids = preg_split("#,#", $matches[2]);
				echo "remove record <b>[".array_reduce($ids, function($a, $b) {return $a = empty($a) ? $b:"$a,$b";})."]</b> for class <b>$class</b>";
			} else if (preg_match('#^'.PATCH_REGEX_CHANGE_RECORD.'$#', $instruction, $matches)) {
				$class = $matches[1];
				$ids = preg_split("#,#", $matches[2]);
				$fieldName = $matches[11];
				$value = $matches[12];
				echo "set field <b>$fieldName</b> from record <b>[".array_reduce($ids, function($a, $b) {return $a = empty($a) ? $b:"$a,$b";})."]</b> for class <b>$class</b> to <b>".nl2br($value)."</b>";
			} else {
				throw new Exception("<i>$instruction</i> is not a recognised instruction");
			}
			echo "<br/>";
		}
	}
}

/*************************************\
              PATCH BASE
\*************************************/

abstract class PatchInstruction {
	abstract protected function getRegex();
	abstract protected function applyValue($value);
	
	private $value;
	public function setValue($value) {
		if ($this->isSyntaxicallyCompatible($value)) {
			$this->value = $value;
			$this->applyValue($value);
		} else {
			throw new Exception("Incompatible value for ".get_class($this).": $value");
		}
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public static function formatRegex($regex, $delimiter) {
		if (strlen($delimiter) > 1) {
			throw new Exception("The delimiter should be a single character");
		} else if ($delimiter == ' ' || $delimiter == '\\') {
			throw new Exception("The delimiter cannot be a space nor a backslash");
		} else {
			return str_replace($delimiter, '\\'.$delimiter, $regex);
		}
	}
	
	public function getFormattedRegex($delimiter) {
		return PatchInstruction::formatRegex($this->getRegex(), $delimiter);
	}
	
	public function isSyntaxicallyCompatible($value) {
		return preg_match('#^'.$this->getFormattedRegex('#').'$#s', $value);
	}
}

/*************************************\
           LEAF INSTRUCTIONS
\*************************************/

abstract class LeafPatchInstruction extends PatchInstruction {
	protected function applyValue($instruction) {
		// nothing to do
	}
}

class PatchComments extends LeafPatchInstruction {
	protected function getRegex() {
		return '#[^#]*#';
	}
}

class PatchClass extends LeafPatchInstruction {
	protected function getRegex() {
		return '[0-9a-zA-Z]+';
	}
}

class PatchField extends LeafPatchInstruction {
	protected function getRegex() {
		return '[0-9a-zA-Z]+';
	}
}

class PatchFieldType extends LeafPatchInstruction {
	protected function getRegex() {
		return '[0-9a-zA-Z]+';
	}
}

class PatchFieldMandatoryValue extends LeafPatchInstruction {
	protected function getRegex() {
		return '(?:mandatory)|(?:optional)';
	}
}

class PatchFieldAttribute extends LeafPatchInstruction {
	protected function getRegex() {
		return '(?:type)|(?:mandatory)';
	}
}

class PatchStringValue extends LeafPatchInstruction {
	protected function getRegex() {
		return '"(?:[^"]|(?:(?<=\\\\)"))*"';
	}
}

class PatchBooleanValue extends LeafPatchInstruction {
	protected function getRegex() {
		return '(?:true)|(?:false)';
	}
}

class PatchIntegerValue extends LeafPatchInstruction {
	protected function getRegex() {
		return '[0-9]+';
	}
}

/*************************************\
        COMPOSED INSTRUCTIONS
\*************************************/

class ComposedPatchInstruction extends PatchInstruction {
	private $composition;
	
	public function __construct() {
		$composition = array();
		for ($i = 0 ; $i < func_num_args() ; $i ++) {
			$element = func_get_arg($i);
			if (is_string($element) || $element instanceof PatchInstruction) {
				$composition[] = $element;
			} else {
				throw new Exception("$element is not managed in composed instructions");
			}
		}
		$this->composition = $composition;
	}
	
	function __clone() {
		$composition = array();
		foreach($this->composition as $element) {
			if (is_string($element)) {
				$composition[] = $element;
			} else if ($element instanceof PatchInstruction) {
				$composition[] = clone $element;
			} else {
				throw new Exception($element." is not a managed element");
			}
		}
		$this->composition = $composition;
	}
	
	protected function getComposition() {
		return $this->composition;
	}
	
	private function generateRegex($catchInnerInstructions = false) {
		$globalRegex = "";
		foreach($this->getComposition() as $element) {
			if (is_string($element)) {
				$globalRegex .= preg_quote($element);
			} else if ($element instanceof PatchInstruction) {
				$regex = $element->getRegex();
				$regex = $catchInnerInstructions ? "($regex)" : "(?:$regex)";
				$globalRegex .= $regex;
			} else {
				throw new Exception($element." is not a managed element");
			}
		}
		return $globalRegex;
	}
	
	public function getInnerInstructions() {
		$instructions = array();
		foreach($this->getComposition() as $element) {
			if ($element instanceof PatchInstruction) {
				$instructions[] = $element;
			} else {
				continue;
			}
		}
		return $instructions;
	}
	
	public function getInnerInstruction() {
		$ref = $this;
		$depth = 0;
		$i = 0;
		for (; $i < func_num_args() - 1 ; $i ++) {
			$index = func_get_arg($i);
			if (!is_int($index)) {
				throw new Exception("$index is not an index");
			} else if(!($ref instanceof ComposedPatchInstruction)) {
				throw new Exception("the element at depth $depth is not a composed instruction, you cannot ask for deepest parts");
			} else {
				$ref = $ref->getInnerInstruction($index);
				$depth++;
			}
		}
		$index = func_get_arg($i);
		$instructions = $ref->getInnerInstructions();
		return $instructions[$index];
	}
	
	public function getInnerValues() {
		$innerValues = array();
		foreach($this->getInnerInstructions() as $instruction) {
			$innerValues[] = $instruction->getValue();
		}
		return $innerValues;
	}
	
	public function getInnerValue($index) {
		$values = $this->getInnerValues();
		return $values[$index];
	}
	
	protected function applyValue($instruction) {
		$regex = $this->generateRegex(true);
		preg_match('#^'.PatchInstruction::formatRegex($regex, '#').'$#s', $instruction, $matches);
		array_shift($matches); // remove the full match
		foreach($this->getInnerInstructions() as $instruction) {
			$instruction->setValue(array_shift($matches));
		}
	}
	
	protected function getRegex() {
		return $this->generateRegex(false);
	}
	
	
}

class PatchSelectField extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct(new PatchClass(),'.',new PatchField());
	}
}

class PatchIDFields extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct('[',new PatchField(),new RepetitivePatchInstruction(new ComposedPatchInstruction(',',new PatchField())),']');
	}
}

/*************************************\
     ROOT INSTRUCTIONS (EXECUTABLE)
\*************************************/

interface PatchExecutableInstruction {
	public function execute(Database $db);
}

class PatchAttributes extends ComposedPatchInstruction implements PatchExecutableInstruction {
	public function __construct() {
		parent::__construct('[time=',new PatchIntegerValue(),',user=',new PatchStringValue(),']');
	}
	
	public function execute(Database $db) {
		$time = $this->getInnerValue(0);
		$user = substr($this->getInnerValue(1), 1, -1);
		echo "new patch: user <b>$user</b> at <b>$time</b> (".date("Y-m-d H:i:s", (integer) $time).")";
	}
}

class PatchAddField extends ComposedPatchInstruction implements PatchExecutableInstruction {
	public function __construct() {
		parent::__construct('+',new PatchSelectField(),'(',new PatchFieldType(),',',new PatchFieldMandatoryValue(),')');
	}
	
	public function execute(Database $db) {
		$class = $this->getInnerInstruction(0)->getInnerValue(0);
		$field = $this->getInnerInstruction(0)->getInnerValue(1);
		$type = $this->getInnerValue(1);
		$mandatory = $this->getInnerValue(2);
		
		echo "add <b>$mandatory $type</b> field <b>$field</b> in class <b>$class</b>";
	}
}

class PatchRemoveField extends ComposedPatchInstruction implements PatchExecutableInstruction {
	public function __construct() {
		parent::__construct('-',new PatchSelectField());
	}
	
	public function execute(Database $db) {
		$class = $this->getInnerInstruction(0)->getInnerValue(0);
		$field = $this->getInnerInstruction(0)->getInnerValue(1);
		
		echo "remove field <b>$field</b> from class <b>$class</b>";
	}
}

/*************************************\
         SPECIAL INSTRUCTIONS
\*************************************/

class RepetitivePatchInstruction extends PatchInstruction {
	private $reference;
	private $min;
	private $max;
	
	public function __construct(PatchInstruction $reference, $min = 0, $max = null) {
		$this->reference = $reference;
		$this->min = $min;
		$this->max = $max;
	}
	
	function __clone() {
		$this->reference = clone $this->reference;
		$instructions = array();
		foreach($this->instructions as $element) {
			$instructions[] = clone $element;
		}
		$this->instructions = $instructions;
	}
	
	public function getReference() {
		return $this->reference;
	}
	
	public function getMin() {
		$this->min = $min;
	}
	
	public function getMax() {
		$this->max = $max;
	}
	
	protected function getRegex() {
		$regex = $this->reference->getRegex();
		$min = $this->min;
		$max = $this->max;
		if ($min === 0 && $max === null) {
			$regex = "(?:$regex)*";
		} else if ($min === 1 && $max === null) {
			$regex = "(?:$regex)+";
		} else if ($min === 0 && $max === 1) {
			$regex = "(?:$regex)?";
		} else {
			$regex = "(?:$regex)\{$min,$max\}";
		}
		return $regex;
	}
	
	private $instructions;
	protected function applyValue($value) {
		$regex = $this->reference->getRegex();
		$this->instructions = array();
		while(!empty($value)) {
			$matches = array();
			preg_match('#^('.PatchInstruction::formatRegex($regex, '#').').*$#s', $value, $matches);
			$chunk = $matches[1];
			$instruction = clone $this->reference;
			$instruction->setValue($chunk);
			$this->instructions[] = $instruction;
			$value = substr($value, strlen($chunk));
		}
	}
	
	public function getAllValues() {
		$values = array();
		foreach($this->instructions as $instruction) {
			$values[] = $instruction->getValue();
		}
		return $values;
	}
	
	public function getAllInstructions() {
		return $this->instructions;
	}
}
?>