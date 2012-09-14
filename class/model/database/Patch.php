<?php
define('PATCH_ID_JOKER', '*');

class Patch {
	private $user = null;
	private $time = null;
	private $instructions = array();
	
	public static function buildFromDiff(StructureDiff $diff, $user, $time = -1) {
		$time = $time === -1 ? time() : $time;// time() cannot be used as a default parameter
		$patch = new Patch();
		$patch->setUser($user);
		$patch->setTime($time);
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
	
	public static function buildFromText($text) {
		$prefix = "#^(";
		$suffix = ")(?:\n.*)?$#s";
		$patch = new Patch();
		while(!empty($text)) {
			$text = trim($text);
			$rootInstructions = array(
				new PatchComment(),
				new PatchAttributes(),
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
			} while($instruction != null && !preg_match($prefix.$instruction->getFormattedRegex('#').$suffix, $text, $matches));
			
			if ($instruction != null) {
				$extract = $matches[1];
				$instruction->setValue($extract);
				if ($instruction instanceof PatchAttributes) {
					$patch->setUser($instruction->getUser());
					$patch->setTime((int) $instruction->getTime());
				} else if ($instruction instanceof PatchComment) {
					// just ignore it
				} else {
					$patch->addInstruction($instruction);
				}
				$text = substr($text, strlen($extract));
			} else {
				throw new Exception("The given patch cannot be parsed from there: $text");
			}
			$this->progressiveCheck();
		}
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
		try {
			$attributes->setValue('[time='.$this->getTime().',user="'.$this->getUser().'"]');
			$string .= $attributes->getValue()."\n";
		} catch(Exception $ex) {
			return $ex->getMessage();
		}
		
		foreach($this->instructions as $instruction) {
			$string .= $instruction->getValue()."\n";
		}
		
		return $string;
	}
	
	public function executeOn(Database $db) {//Database::getDefaultDatabase()
		foreach($patch->getInstructions() as $instruction) {
			$instruction->execute($db);
			echo '<br/><pre>'.($instruction->getValue()).'</pre><br/><br/>';
		}
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

abstract class AbstractPatchInstruction {
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
	
	public static function toInstructionOnly($array) {
		$result = array();
		foreach($array as $element) {
			if (is_string($element)) {
				$result[] = new TextPatchInstruction($element);
			} else if ($element instanceof AbstractPatchInstruction) {
				$result[] = $element;
			} else {
				throw new Exception("$element is not an instruction");
			}
		}
		return $result;
	}
	
	public function getFormattedRegex($delimiter) {
		return AbstractPatchInstruction::formatRegex($this->getRegex(), $delimiter);
	}
	
	public function isSyntaxicallyCompatible($value) {
		return preg_match('#^'.$this->getFormattedRegex('#').'$#s', $value);
	}
}

/*************************************\
           REGEX INSTRUCTIONS
\*************************************/

abstract class RegexPatchInstruction extends AbstractPatchInstruction {
	protected function applyValue($instruction) {
		// nothing to do
	}
}

class ClassPatchRegex extends RegexPatchInstruction {
	protected function getRegex() {
		return '[0-9a-zA-Z]+';
	}
}

class FieldPatchRegex extends RegexPatchInstruction {
	protected function getRegex() {
		return '[0-9a-zA-Z]+';
	}
}

class StringTypePatchRegex extends RegexPatchInstruction {
	protected function getRegex() {
		return 'string(?:[1-9][0-9]*)?';
	}
}

class StringValuePatchRegex extends RegexPatchInstruction {
	protected function getRegex() {
		return '"(?:[^\\\\"]|(?:\\\\")|(?:\\\\\\\\))*"';
	}
}

class IntegerValuePatchRegex extends RegexPatchInstruction {
	protected function getRegex() {
		return '[0-9]+';
	}
}

/*************************************\
        COMPOSED INSTRUCTIONS
\*************************************/

class ComposedPatchInstruction extends AbstractPatchInstruction {
	private $innerInstructions;
	
	public function __construct() {
		$this->innerInstructions = AbstractPatchInstruction::toInstructionOnly(func_get_args());
	}
	
	function __clone() {
		$innerInstructions = array();
		foreach($this->innerInstructions as $element) {
			$innerInstructions[] = clone $element;
		}
		$this->innerInstructions = $innerInstructions;
	}
	
	public function getInnerInstructions() {
		return $this->innerInstructions;
	}
	
	public function getInnerInstruction($index) {
		return $this->innerInstructions[$index];
	}
	
	private function generateRegex($catchInnerInstructions = false) {
		$globalRegex = "";
		foreach($this->innerInstructions as $element) {
			$regex = $element->getRegex();
			$regex = $catchInnerInstructions ? "($regex)" : "(?:$regex)";
			$globalRegex .= $regex;
		}
		return $globalRegex;
	}
	
	public function getInnerValues() {
		$innerValues = array();
		foreach($this->innerInstructions as $instruction) {
			$innerValues[] = $instruction->getValue();
		}
		return $innerValues;
	}
	
	public function getInnerValue($index) {
		return $this->innerInstructions[$index]->getValue();
	}
	
	protected function applyValue($instruction) {
		$regex = $this->generateRegex(true);
		preg_match('#^'.AbstractPatchInstruction::formatRegex($regex, '#').'$#s', $instruction, $matches);
		array_shift($matches); // remove the full match
		foreach($this->innerInstructions as $instruction) {
			$instruction->setValue(array_shift($matches));
		}
	}
	
	protected function getRegex() {
		return $this->generateRegex(false);
	}
	
	
}

class PatchSelectField extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct(new ClassPatchRegex(),'.',new FieldPatchRegex());
	}
	
	public function getClass() {
		return $this->getInnerValue(0);
	}
	
	public function getField() {
		return $this->getInnerValue(2);
	}
}

class PatchIDFields extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct('[',new ListPatchInstruction(new FieldPatchRegex(),','),']');
	}
	
	public function getIDFields() {
		return $this->getInnerInstruction(1)->getAllValues();
	}
}

class PatchIDValues extends ComposedPatchInstruction {
	public function __construct($useJoker) {
		parent::__construct('[',new ListPatchInstruction(
				($useJoker ? new AlternativePatchInstruction(new PatchBasicValue(), PATCH_ID_JOKER) : new PatchBasicValue())
				,','),']');
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(1)->getAllValues();
	}
}

class PatchFieldValueAssignment extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct(new FieldPatchRegex(),'=',new PatchFieldValue());
	}
	
	public function getField() {
		return $this->getInnerValue(0);
	}
	
	public function getFieldValue() {
		return $this->getInnerValue(2);
	}
}

class PatchChainFieldValueAssignment extends ComposedPatchInstruction {
	public function __construct() {
		parent::__construct('(',new ListPatchInstruction(new PatchFieldValueAssignment(),','),')');
	}
	
	public function getAssignments() {
		$assignments = array();
		foreach($this->getInnerInstruction(1)->getAllInstructions() as $instruction) {
			$assignments[$instruction->getField()] = $instruction->getFieldValue();
		}
		return $assignments;
	}
}

class PatchSelectRecordField extends ComposedPatchInstruction {
	public function __construct($useJoker) {
		parent::__construct(new PatchSelectRecord($useJoker),'.',new FieldPatchRegex());
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(0)->getIDValues();
	}
	
	public function getField() {
		return $this->getInnerValue(2);
	}
}

class PatchSelectRecord extends ComposedPatchInstruction {
	public function __construct($useJoker) {
		parent::__construct(new ClassPatchRegex(),new PatchIDValues($useJoker));
	}
	
	public function getClass() {
		return $this->getInnerValue(0);
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(1)->getIDValues();
	}
}

/*************************************\
 ALTERNATIVE INSTRUCTIONS (... OR ...)
\*************************************/

class AlternativePatchInstruction extends AbstractPatchInstruction {
	private $alternatives;
	private $compatibleInstruction;
	
	public function __construct() {
		$this->alternatives = AbstractPatchInstruction::toInstructionOnly(func_get_args());
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

class PatchBasicValue extends AlternativePatchInstruction {
	// TODO add variables or manage recursivity in order to manage not restricted only
	public function __construct() {
		parent::__construct(
				new StringValuePatchRegex(),
				new PatchBooleanValue(),
				new IntegerValuePatchRegex(),
				new PatchNullValue()
		);
	}
}

class PatchFieldValue extends AlternativePatchInstruction {
	public function __construct() {
		parent::__construct(
				new PatchBasicValue(),
				new PatchSelectRecordField(false)
		);
	}
}

class PatchFieldTypeValue extends AlternativePatchInstruction {
	public function __construct() {
		parent::__construct(
				'boolean',
				'integer',
				'double',
				'array',
				'resource',
				new StringTypePatchRegex()
		);
	}
}

class PatchFieldMandatoryValue extends AlternativePatchInstruction {
	public function __construct() {
		parent::__construct(
				'mandatory',
				'optional'
		);
	}
}

class PatchFieldAttribute extends AlternativePatchInstruction {
	public function __construct() {
		parent::__construct(
				'type',
				'mandatory'
		);
	}
}

class PatchBooleanValue extends AlternativePatchInstruction {
	public function __construct() {
		parent::__construct(
				'true',
				'false'
		);
	}
}

/*************************************\
   COMPLETE INSTRUCTIONS (EXECUTABLE)
\*************************************/

interface PatchCompleteInstruction {
	public function execute(Database $db);
}

class PatchComment extends RegexPatchInstruction implements PatchCompleteInstruction {
	protected function getRegex() {
		return '#[^\n]*\n';
	}
	
	public function execute(Database $db) {
		// do nothing (ignore the comment)
		$comment = trim(substr($this->getValue(), 1));
		echo "(comment: $comment)";
	}
}

class PatchAttributes extends ComposedPatchInstruction implements PatchCompleteInstruction {
	public function __construct() {
		parent::__construct('[time=',new IntegerValuePatchRegex(),',user=',new StringValuePatchRegex(),']');
	}
	
	public function execute(Database $db) {
		$time = $this->getTime();
		$user = $this->getUser();
		echo "new patch: user <b>$user</b> at <b>$time</b> (".date("Y-m-d H:i:s", (integer) $time).")";
	}
	
	public function getTime() {
		return $this->getInnerValue(1);
	}
	
	public function getUser() {
		return Patch::cleanStringValue($this->getInnerValue(3));
	}
}

class PatchAddField extends ComposedPatchInstruction implements PatchCompleteInstruction {
	public function __construct() {
		parent::__construct('+',new PatchSelectField(),'(',new PatchFieldTypeValue(),',',new PatchFieldMandatoryValue(),')');
	}
	
	public function execute(Database $db) {
		$class = $this->getClass();
		$field = $this->getField();
		$type = $this->getType();
		$mandatory = $this->getMandatory();
		
		echo "add <b>$mandatory $type</b> field <b>$field</b> in class <b>$class</b>";
	}
	
	public function getClass() {
		return $this->getInnerInstruction(1)->getClass();
	}
	
	public function getField() {
		return $this->getInnerInstruction(1)->getField();
	}
	
	public function getType() {
		return $this->getInnerValue(3);
	}
	
	public function getMandatory() {
		return $this->getInnerValue(5);
	}
}

class PatchRemoveField extends ComposedPatchInstruction implements PatchCompleteInstruction {
	public function __construct() {
		parent::__construct('-',new PatchSelectField());
	}
	
	public function execute(Database $db) {
		$class = $this->getClass();
		$field = $this->getField();
		
		echo "remove field <b>$field</b> from class <b>$class</b>";
	}
	
	public function getClass() {
		return $this->getInnerInstruction(1)->getClass();
	}
	
	public function getField() {
		return $this->getInnerInstruction(1)->getField();
	}
}

class PatchSetClassKey extends ComposedPatchInstruction implements PatchCompleteInstruction {
	public function __construct() {
		parent::__construct(new ClassPatchRegex(),'=',new PatchIDFields());
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
		return $this->getInnerInstruction(2)->getIDFields();
	}
}

class PatchAddRecord extends ComposedPatchInstruction implements PatchCompleteInstruction {
	public function __construct() {
		parent::__construct('+',new PatchSelectRecord(false),new PatchChainFieldValueAssignment());
	}
	
	// TODO manage 0 ID values
	public function execute(Database $db) {
		$class = $this->getClass();
		$IdValues = $this->getIDValues();
		$assignments = array();
		foreach($this->getAssignments() as $field => $value) {
			$assignments[] = "$field($value)";
		}
		
		echo "Add record <b>[".array_reduce($IdValues, function($a, $b) {return $a = $a === null ? "$b":"$a,$b";})."]</b> for class <b>$class</b>,";
		if (empty($assignments)) {
			echo " setting no field";
		} else {
			echo " setting the fields <b>".array_reduce($assignments, function($a, $b) {return $a = empty($a) ? $b:"$a,$b";})."</b>";
		}
	}
	
	public function getClass() {
		return $this->getInnerInstruction(1)->getClass();
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(1)->getIDValues();
	}
	
	public function getAssignments() {
		return $this->getInnerInstruction(2)->getAssignments();
	}
}

class PatchRemoveRecord extends ComposedPatchInstruction implements PatchCompleteInstruction {
	public function __construct() {
		parent::__construct('-',new PatchSelectRecord(true));
	}
	
	public function execute(Database $db) {
		$class = $this->getClass();
		$values = $this->getIDValues();
		
		echo "remove the record <b>[".array_reduce($values, function($a, $b) {return $a = empty($a) ? $b:"$a,$b";})."]</b> from class <b>$class</b>";
	}
	
	public function getClass() {
		return $this->getInnerInstruction(1)->getClass();
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(1)->getIDValues();
	}
}

class PatchChangeRecordField extends ComposedPatchInstruction implements PatchCompleteInstruction {
	public function __construct() {
		parent::__construct(new PatchSelectRecordField(true),'=',new PatchFieldValue());
	}
	
	public function execute(Database $db) {
		$class = $this->getClass();
		$values = $this->getIDValues();
		$field = $this->getField();
		$fieldValue = $this->getFieldValue();
		
		$records = null;
		if (in_array(PATCH_ID_JOKER, $values)) {
			$records = 'all the records';
		} else {
			$records = 'the record';
		}
		
		echo "set the field <b>$field($fieldValue)</b> of $records <b>[".array_reduce($values, function($a, $b) {return $a = empty($a) ? $b:"$a,$b";})."]</b> for class <b>$class</b>";
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getIDValues() {
		return $this->getInnerInstruction(0)->getIDValues();
	}
	
	public function getField() {
		return $this->getInnerInstruction(0)->getField();
	}
	
	public function getFieldValue() {
		return $this->getInnerValue(2);
	}
}

class PatchChangeFieldType extends ComposedPatchInstruction implements PatchCompleteInstruction {
	public function __construct() {
		parent::__construct(new PatchSelectField(),'.type=',new PatchFieldTypeValue());
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getField() {
		return $this->getInnerInstruction(0)->getField();
	}
	
	public function getTypeValue() {
		return $this->getInnerValue(2);
	}
	
	public function execute(Database $db) {
		$class = $this->getClass();
		$field = $this->getField();
		$value = $this->getTypeValue();
		
		echo "set the type <b>$value</b> for the field <b>$field</b> of the class <b>$class</b>";
	}
}

class PatchChangeFieldMandatory extends ComposedPatchInstruction implements PatchCompleteInstruction {
	public function __construct() {
		parent::__construct(new PatchSelectField(),'.mandatory=',new PatchFieldMandatoryValue());
	}
	
	public function getClass() {
		return $this->getInnerInstruction(0)->getClass();
	}
	
	public function getField() {
		return $this->getInnerInstruction(0)->getField();
	}
	
	public function getMandatoryValue() {
		return $this->getInnerValue(2);
	}
	
	public function execute(Database $db) {
		$class = $this->getClass();
		$field = $this->getField();
		$value = $this->getMandatoryValue();
		
		echo "set the mandatory attribute to <b>$value</b> for the field <b>$field</b> of the class <b>$class</b>";
	}
}

/*************************************\
         SPECIAL INSTRUCTIONS
\*************************************/

class ListPatchInstruction extends AbstractPatchInstruction {
	private $instruction;
	
	public function __construct(AbstractPatchInstruction $instruction, $separator = null, $min = 0, $max = null) {
		$repeat = new ComposedPatchInstruction(is_object($separator) ? clone $separator : $separator,clone $instruction);
		if ($separator == null) {
			$this->instruction = new RepetitivePatchInstruction($repeat, $min, $max);
		} else {
			$max = $max === null ? $max : $max - 1;
			$min = $min > 0 ? $min - 1 : $min;
			$this->instruction = new ComposedPatchInstruction(clone $instruction, new RepetitivePatchInstruction($repeat, $min, $max));
			if ($min <= 0) {
				$this->instruction = new OptionalPatchInstruction($this->instruction);
			} else {
				// keep as is
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
		$instructions = array();
		$reference = $this->instruction;
		if ($reference instanceof OptionalPatchInstruction) {
			$reference = $reference->getSingleInstruction();
		} else {
			// go directly to the next step
		}
		
		if ($reference === null) {
			// no result, just ignore everything until the end
		} else {
			if ($reference instanceof ComposedPatchInstruction) {
				$instructions[] = $reference->getInnerInstruction(0);
				$reference = $reference->getInnerInstruction(1);
			} else {
				// go directly to the next step
			}
			
			// now, we should have a RepetitivePatchInstruction
			foreach($reference->getAllInstructions() as $instruction) {
				// each instruction is a repeating stuff (ComposedPatchInstruction)
				// we need the last element (we do not know if there is 1 or 2 instructions)
				$in = $instruction->getInnerInstructions();
				$instructions[] = array_pop($in);
			}
		}
		return $instructions;
	}
	
	public function getAllValues() {
		$values = array();
		foreach($this->getAllInstructions() as $instruction) {
			$values[] = $instruction->getValue();
		}
		return $values;
	}
}

class RepetitivePatchInstruction extends AbstractPatchInstruction {
	private $instructions = array();
	private $reference;
	private $min;
	private $max;
	
	public function __construct(AbstractPatchInstruction $reference, $min = 0, $max = null) {
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
			preg_match('#^('.AbstractPatchInstruction::formatRegex($regex, '#').').*$#s', $value, $matches);
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
	public function __construct(AbstractPatchInstruction $instruction) {
		parent::__construct($instruction, 0, 1);
	}
	
	public function getSingleInstruction() {
		$instructions = $this->getAllInstructions();
		return array_shift($instructions);
	}
}

class TextPatchInstruction extends RegexPatchInstruction {
	private $text;
	
	public function __construct($text) {
		$this->text = $text;
	}
	
	protected function getRegex() {
		return preg_quote($this->text);
	}
}

class PatchNullValue extends TextPatchInstruction {
	public function __construct() {
		parent::__construct("null");
	}
}
?>
