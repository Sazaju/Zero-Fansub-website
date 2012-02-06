<?php
class StringExploder {
	private $descriptors = array();
	
	public function addDescriptor(StringExploderDescriptor $descriptor) {
		if (empty($descriptor)) {
			throw new Exception("Cannot take an empty descriptor.");
		} else {
			$this->descriptors[] = $descriptor;
		}
	}
	
	public function parse($string) {
		$result = array();
		foreach($this->descriptors as $descriptor) {
			$regex = $descriptor->getRegex();
			$matches = null;
			preg_match_all($regex, $string , $matches, PREG_OFFSET_CAPTURE);
			$flag = $descriptor->getFlag();
			if ($flag === null) {
				$flag = $regex;
			}
			foreach($matches[0] as $match) {
				$index = $match[1];
				$chunk = $match[0];
				if (isset($result[$index])) {
					$firstString = $result[$index][0];
					$secondString = $chunk;
					$firstFlag = StringExploder::flagToString($result[$index][1]);
					$secondFlag = StringExploder::flagToString($flag);
					throw new Exception("Conflict between $firstFlag and $secondFlag at $index ('$firstString' or '$secondString')");
				} else {
					$result[$index] = array($chunk, $flag);
				}
			}
		}
		$result[strlen($string)] = null;
		ksort($result);
		
		$previousIndex = 0;
		$previousLength = 0;
		foreach($result as $index => $entry) {
			$delta = $index - $previousLength - $previousIndex;
			if ($delta > 0) {
				$newIndex = $previousIndex + $previousLength;
				$result[$newIndex] = substr($string, $newIndex, $delta);
			} else if ($delta < 0) {
				$firstString = $result[$previousIndex][0];
				$secondString = $entry[0];
				$firstFlag = StringExploder::flagToString($result[$previousIndex][1]);
				$secondFlag = StringExploder::flagToString($entry[1]);
				throw new Exception("Conflict between $firstFlag ('$firstString' at $previousIndex) and $secondFlag ('$secondString' at $index)");
			} else {
				// empty case, no modification
			}
			$previousIndex = $index;
			$previousLength = strlen($entry[0]);
		}
		ksort($result);
		unset($result[strlen($string)]);
		
		return $result;
	}
	
	private static function flagToString($flag) {
		if (is_object($flag)) {
			return $flag->toString();
		} else {
			return "".$flag;
		}
	}
}

class StringExploderDescriptor {
	private $regex = null;
	private $flag = null;
	
	public function __construct($regex, $flag = null) {
		$this->regex = $regex;
		$this->flag = $flag;
	}
	
	public function getRegex() {
		return $this->regex;
	}
	
	public function getFlag() {
		return $this->flag;
	}
}
?>