<?php
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
?>