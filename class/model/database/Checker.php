<?php
class Checker {
	private $activated = true;
	private $evaluationCallback;
	private $logCallback;
	private $registeredCallbacks = array();
	
	public function __construct() {
		$this->registerCallbacks('isempty',
			function($arg) {return empty($arg);},
			function($arg) {return "'$arg' should be empty.";}
		);
		$this->registerCallbacks('isnotEmpty',
			function($arg) {return !empty($arg);},
			function($arg) {return "'$arg' should not be empty.";}
		);
		$this->registerCallbacks('isarray',
			function($arg) {return is_array($arg);},
			function($arg) {return "'$arg' should be an array.";}
		);
		$this->registerCallbacks('isnotArray',
			function($arg) {return !is_array($arg);},
			function($arg) {return "'$arg' should not be an array.";}
		);
	}
	
	public function setActivated($boolean) {
		$this->activated = $boolean;
	}
	
	public function isActivated() {
		return $this->activated;
	}
	
	private function setEvaluationCallback($function) {
		$this->evaluationCallback = $function;
	}
	
	private function setLogCallback($function) {
		$this->logCallback = $function;
	}
	
	public function __call($function, $argument) {
		if ($this->isKnownConfig(substr($function, strlen('check')))) {
			$this->check($argument[0], substr($function, strlen('check')));
		} else if (is_callable($this->$function)) {
			return call_user_func_array($this->$function, $argument);
		} else {
			throw new Exception("'$function' unknown function.");
		}
	}
	
	public function check($argument, $config = null) {
		if ($this->isActivated()) {
			if ($config === null) {
				// keep the current configuration.
			} else {
				$this->setConfig($config);
			}
			if (!is_callable($this->evaluationCallback)) {
				throw new Exception("No evaluation callback provided.");
			} else if (!is_callable($this->logCallback)) {
				throw new Exception("No log callback provided.");
			} else {
				$hasPassed = $this->evaluationCallback($argument);
				if ($hasPassed) {
					// everything is OK
				} else {
					$e = new CheckerException($this->logCallback($argument));
					$trace = $e->getTrace();
					//array_pop($trace);
					throw $e;
				}
			}
		} else {
			//do not check anything
		}
	}
	
	public function registerCallbacks($config, $evaluationCallback, $logCallback) {
		$config = strtolower($config);
		$this->registeredCallbacks[$config] = array(
			'eval' => $evaluationCallback,
			'log' => $logCallback
		);
	}
	
	public function isKnownConfig($config) {
		$config = strtolower($config);
		return array_key_exists($config, $this->registeredCallbacks);
	}
	
	public function setConfig($config) {
		if ($this->isKnownConfig($config)) {
			$config = strtolower($config);
			$this->setEvaluationCallback($this->registeredCallbacks[$config]['eval']);
			$this->setLogCallback($this->registeredCallbacks[$config]['log']);
		} else {
			throw new CheckerException("'$config' is not a registered configuration.");
		}
	}
}

class CheckerException extends Exception {
	public function __toString() {
		$trace = $this->getTrace();
		while($trace[0]['file'] == $this->getFile()) {
			array_shift($trace);
		}
		if ($trace[0]['function'] == '__call') {
			array_shift($trace);
		} else {
			// already at the level af the exact call.
		}
		$file = $trace[0]['file'];
		$line = $trace[0]['line'];
		$trace = array_map(function($a) {
			static $counter = -1;
			$counter++;
			$file = $a['file'];
			$line = $a['line'];
			$env = array_key_exists('class', $a) ? $a['class'].$a['type'] : '';
			$function = $a['function'];
			$args = array_map(function($b) {
				$b = $b === null ? 'NULL' : "".$b;
				$limit = 15;
				$b = strlen($b) > $limit ? substr($b, 0, $limit).'...' : $b;
				return $b;
			}, $a['args']);
			$args = Format::arrayToString($args);
			return "#$counter $file($line): $env$function($args)";
		}, $trace);
		$class = __CLASS__;
		$message = $this->getMessage();
		return "exception '$class' with message '$message' in $file:$line\nStack trace:\n".Format::arrayToString($trace, "\n");
	}
}
?>