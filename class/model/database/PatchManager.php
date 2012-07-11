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

define("PATCH_REGEX_PATCH_ATTRIBUTES", '\[time='.PATCH_REGEX_INTEGER.',user='.PATCH_REGEX_STRING.'\]');

define("PATCH_REGEX_ID_FIELDS", '\[('.PATCH_REGEX_FIELD.'(?:,'.PATCH_REGEX_FIELD.')*)\]');
define("PATCH_REGEX_SELECT_FIELD", PATCH_REGEX_CLASS.'\.'.PATCH_REGEX_FIELD);
define("PATCH_REGEX_SELECT_ATTRIBUTE", PATCH_REGEX_SELECT_FIELD.'\.'.PATCH_REGEX_ATTRIBUTE);

define("PATCH_REGEX_VALUE", '((?:'.PATCH_REGEX_STRING.'|'.PATCH_REGEX_BOOLEAN.'|'.PATCH_REGEX_INTEGER.'))');
define("PATCH_REGEX_ID_VALUES", '\[('.PATCH_REGEX_VALUE.'(?:,'.PATCH_REGEX_VALUE.')*)\]');
define("PATCH_REGEX_SELECT_RECORD", PATCH_REGEX_CLASS.PATCH_REGEX_ID_VALUES);
define("PATCH_REGEX_SELECT_RECORD_FIELD", PATCH_REGEX_SELECT_RECORD.'\.'.PATCH_REGEX_FIELD);
define("PATCH_REGEX_VALUE_EXTENDED", '((?:'.PATCH_REGEX_STRING.'|'.PATCH_REGEX_BOOLEAN.'|'.PATCH_REGEX_INTEGER.'|'.PATCH_REGEX_SELECT_ATTRIBUTE.'|'.PATCH_REGEX_SELECT_RECORD_FIELD.'))');

define("PATCH_REGEX_ADD_FIELD", '\+'.PATCH_REGEX_SELECT_FIELD.'\('.PATCH_REGEX_FIELD_TYPE.','.PATCH_REGEX_FIELD_MANDATORY.'\)');
define("PATCH_REGEX_REMOVE_FIELD", '-'.PATCH_REGEX_SELECT_FIELD);
define("PATCH_REGEX_CHANGE_ATTRIBUTE", PATCH_REGEX_SELECT_ATTRIBUTE.'='.PATCH_REGEX_VALUE_EXTENDED);
define("PATCH_REGEX_CHANGE_KEY", PATCH_REGEX_CLASS.'='.PATCH_REGEX_ID_FIELDS);
define("PATCH_REGEX_ADD_RECORD", '\+'.PATCH_REGEX_CLASS.PATCH_REGEX_ID_FIELDS);
define("PATCH_REGEX_REMOVE_RECORD", '-'.PATCH_REGEX_CLASS.PATCH_REGEX_ID_FIELDS);
define("PATCH_REGEX_CHANGE_RECORD", PATCH_REGEX_SELECT_RECORD_FIELD.'='.PATCH_REGEX_VALUE_EXTENDED);

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
				echo "create record <b>[".array_reduce($ids, function($a, $b) {return $a = empty($a) ? $b:"$a,$b";})."]</b> for class <b>$class</b>";
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
?> 
