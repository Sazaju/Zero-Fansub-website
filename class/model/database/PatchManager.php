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
	
	public static function executePatch(Database $db, $patch) {
		$patch = new Patch($patch);
		// TODO
	}
}

/*************************************\
              PATCH BASE
\*************************************/

class Patch {
	private $instructions = array();
	
	public function __construct($patch = null) {
		if ($patch == null) {
			// do nothing
		} else {
			$this->addPatch($patch);
		}
	}
	
	public function getInstructions() {
		return $this->instructions;
	}
	
	public function addPatch($patch) {
		while(!empty($patch)) {
			$patch = trim($patch);
			$in1 = new PatchAttributes();
			$in2 = new PatchAddField();
			$in3 = new PatchRemoveField();
			$in4 = new PatchSetClassKey();
			$matches = array();
			if (preg_match('#^('.$in1->getFormattedRegex('#').')\n.*$#s', $patch, $matches)) {
				$instruction = $matches[1];
				$in1->setValue($instruction);
				$in1->execute(Database::getDefaultDatabase());
				$this->instructions[] = $in1;
				$patch = substr($patch, strlen($instruction));
				/*
				echo '<b>'.$in1->getFormattedRegex('#').'</b> =X=> '.Debug::toString($matches);
				$patch = null;
				*/
			} else if (preg_match('#^('.$in2->getFormattedRegex('#').').*$#s', $patch, $matches)) {
				$instruction = $matches[1];
				$in2->setValue($instruction);
				$in2->execute(Database::getDefaultDatabase());
				$this->instructions[] = $in2;
				$patch = substr($patch, strlen($instruction));
				/*
				echo '<b>'.$in2->getFormattedRegex('#').'</b> =X=> '.Debug::toString($matches);
				$patch = null;
				*/
			} else if (preg_match('#^('.$in3->getFormattedRegex('#').').*$#s', $patch, $matches)) {
				$instruction = $matches[1];
				$in3->setValue($instruction);
				$in3->execute(Database::getDefaultDatabase());
				$this->instructions[] = $in3;
				$patch = substr($patch, strlen($instruction));
				/*
				echo '<b>'.$in3->getFormattedRegex('#').'</b> =X=> '.Debug::toString($matches);
				$patch = null;
				*/
			} else if (preg_match('#^('.$in4->getFormattedRegex('#').').*$#s', $patch, $matches)) {
				$instruction = $matches[1];
				$in4->setValue($instruction);
				$in4->execute(Database::getDefaultDatabase());
				$this->instructions[] = $in4;
				$patch = substr($patch, strlen($instruction));
				/*
				echo '<b>'.$in4->getFormattedRegex('#').'</b> =X=> '.Debug::toString($matches);
				$patch = null;
				*/
			} else {
				throw new Exception("The given patch cannot be parsed from there: $patch");
			}
			echo '<br/>';
		}
	}
}

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
	
	public function getClass() {
		return $this->getInnerValue(0);
	}
	
	public function getField() {
		return $this->getInnerValue(1);
	}
}

class PatchIDFields extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct('[',new ListPatchInstruction(new PatchField(),','),']');
	}
	
	public function getIDFields() {
		return $this->getInnerInstruction(0)->getAllValues();
	}
}

class PatchIDValues extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct('[',new ListPatchInstruction(new PatchBasicValue(),','),']');
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(0)->getAllValues();
	}
}

class PatchBasicValue extends ComposedPatchInstruction {
	// TODO add variables or manage recursivity in order to manage not restricted only
	public function __construct() {
		parent::__construct(new AlternativePatchInstruction(
				new PatchStringValue(),
				new PatchBooleanValue(),
				new PatchIntegerValue()
		));
	}
}

class PatchFieldValue extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct(new AlternativePatchInstruction(
				new PatchBasicValue(),
				new PatchSelectRecordField()
		));
	}
}

class PatchSelectRecordField extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct(new PatchSelectRecord(),'.',new PatchField());
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(0)->getIDValues();
	}
	
	public function getField() {
		return $this->getInnerValue(1);
	}
}

class PatchSelectRecord extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct(new PatchClass(),new PatchIDValues());
	}
	
	public function getClass() {
		return $this->getInnerValue(0);
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(1)->getIDValues();
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
		$time = $this->getTime();
		$user = $this->getUser();
		echo "new patch: user <b>$user</b> at <b>$time</b> (".date("Y-m-d H:i:s", (integer) $time).")";
	}
	
	public function getTime() {
		return $this->getInnerValue(0);
	}
	
	public function getUser() {
		return substr($this->getInnerValue(1), 1, -1);
	}
}

class PatchAddField extends ComposedPatchInstruction implements PatchExecutableInstruction {
	public function __construct() {
		parent::__construct('+',new PatchSelectField(),'(',new PatchFieldType(),',',new PatchFieldMandatoryValue(),')');
	}
	
	public function execute(Database $db) {
		$class = $this->getClass();
		$field = $this->getField();
		$type = $this->getType();
		$mandatory = $this->getMandatory();
		
		echo "add <b>$mandatory $type</b> field <b>$field</b> in class <b>$class</b>";
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getField() {
		return $this->getInnerInstruction(0)->getField();
	}
	
	public function getType() {
		return $this->getInnerValue(1);
	}
	
	public function getMandatory() {
		return $this->getInnerValue(2);
	}
}

class PatchRemoveField extends ComposedPatchInstruction implements PatchExecutableInstruction {
	public function __construct() {
		parent::__construct('-',new PatchSelectField());
	}
	
	public function execute(Database $db) {
		$class = $this->getClass();
		$field = $this->getField();
		
		echo "remove field <b>$field</b> from class <b>$class</b>";
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getField() {
		return $this->getInnerInstruction(0)->getField();
	}
}

class PatchSetClassKey extends ComposedPatchInstruction implements PatchExecutableInstruction {
	public function __construct() {
		parent::__construct(new PatchClass(),'=',new PatchIDFields());
	}
	
	public function execute(Database $db) {
		$class = $this->getClass();
		$fields = $this->getIDFields();
		
		echo "set ID to <b>[".array_reduce($fields, function($a, $b) {return $a = empty($a) ? $b:"$a,$b";})."]</b> for class <b>$class</b>";
	}
	
	public function getClass() {
		return $this->getInnerValue(0);
	}
	
	public function getIDFields() {
		return $this->getInnerInstruction(1)->getIDFields();
	}
}

/*************************************\
         SPECIAL INSTRUCTIONS
\*************************************/

class ListPatchInstruction extends PatchInstruction {
	private $instruction;
	
	public function __construct(PatchInstruction $instruction, $separator = null, $min = 0, $max = null) {
		$repeat = new ComposedPatchInstruction(is_object($separator) ? clone $separator : $separator,clone $instruction);
		if ($separator == null) {
			$this->instruction = new RepetitivePatchInstruction($repeat, $min, $max);
		} else {
			$max = $max === null ? $max : $max - 1;
			if ($min <= 0) {
				$this->instruction = new ComposedPatchInstruction(clone $instruction, new RepetitivePatchInstruction($repeat, $min, $max));
				$this->instruction = new OptionalPatchInstruction($this->instruction);
			} else {
				$this->instruction = new ComposedPatchInstruction(clone $instruction, new RepetitivePatchInstruction($repeat, $min-1, $max));
			}
		}
	}
	
	public function __clone() {
		$this->instruction = clone $this->instruction;
	}
	
	protected function getRegex() {
		return $this->instruction->getRegex();
	}
	
	protected function applyValue($value) {
		$this->instruction->setValue($value);
	}
	
	public function getAllInstructions() {
		$origin = $this->instruction;
		if ($origin instanceof RepetitivePatchInstruction) {
			return $origin->getAllInstructions();
		} else if ($origin instanceof ComposedPatchInstruction) {
			$instructions == array();
			$instructions[] = $origin->getInnerInstruction(1)->getInnerValue(0);
			foreach($origin->getInnerInstruction(1, 1)->getAllInstructions() as $instruction) {
				$instructions[] = $instruction->getInnerInstruction(0)->getValue();
			}
			return $instructions;
		} else if ($origin instanceof OptionalPatchInstruction) {
			$instructions == array();
			$origin = $origin->getSingleInstruction();
			if ($origin != null) {
				$instructions[] = $origin->getInnerInstruction(1)->getInnerValue(0);
				foreach($origin->getInnerInstruction(1, 1)->getAllInstructions() as $instruction) {
					$instructions[] = $instruction->getInnerInstruction(0)->getValue();
				}
			} else {
				// no value
			}
			return $instructions;
		} else {
			throw new Exception("This case should never happen: ".get_class($instruction));
		}
	}
	
	public function getAllValues() {
		$values = array();
		foreach($this->getAllInstructions() as $instruction) {
			$values[] = $instruction->getValue();
		}
		return $values;
	}
}

class RepetitivePatchInstruction extends PatchInstruction {
	private $instructions = array();
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
		} else if ($min === $max) {
			$regex = "(?:$regex)\{$min\}";
		} else {
			$regex = "(?:$regex)\{$min,$max\}";
		}
		return $regex;
	}
	
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

class OptionalPatchInstruction extends RepetitivePatchInstruction {
	public function __construct(PatchInstruction $instruction) {
		parent::__construct($instruction, 0, 1);
	}
	
	public function getSingleInstruction() {
		$instructions = $this->getAllInstructions();
		return array_shift($instructions);
	}
}

class AlternativePatchInstruction extends PatchInstruction {
	private $alternatives;
	private $compatibleInstruction;
	
	public function __construct() {
		$alternatives = array();
		foreach(func_get_args() as $element) {
			if ($element instanceof PatchInstruction) {
				$alternatives[] = $element;
			} else {
				throw new Exception("$element is not managed in alternative instructions");
			}
		}
		$this->alternatives = $alternatives;
	}
	
	function __clone() {
		$alternatives = array();
		foreach($this->alternatives as $element) {
			$alternatives[] = clone $element;
		}
		$this->alternatives = $alternatives;
		$this->compatibleInstruction = $this->compatibleInstruction === null ? null : clone $this->compatibleInstruction;
	}
	
	public function getAlternatives() {
		return $this->alternatives;
	}
	
	protected function getRegex() {
		$globaleRegex = "";
		foreach($this->alternatives as $instruction) {
			$regex = $instruction->getRegex();
			$globaleRegex .= "|(?:$regex)";
		}
		$globaleRegex = substr($globaleRegex, 1);
		return "(?:$globaleRegex)";
	}
	
	protected function applyValue($value) {
		foreach($this->alternatives as $instruction) {
			if ($instruction->isSyntaxicallyCompatible($value)) {
				$instruction->setValue($value);
				$this->compatibleInstruction = $instruction;
			} else {
				continue;
			}
		}
	}
	
	public function getCompatibleInstruction() {
		return $this->compatibleInstruction;
	}
}
?>