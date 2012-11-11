<?php
/*
	A URL is a Web address to a given resource. This class offer several features
	to get and format URLs.
*/

define('URL_PROTOCOL', "protocol");
define('URL_USER', "user");
define('URL_PASSWORD', "password");
define('URL_SERVER', "server");
define('URL_PORT', "port");
define('URL_PATH', "path");
define('URL_QUERY', "query");
define('URL_FRAGMENT', "fragment");
class Url {
	private $data = null;
	
	public function __construct($url = null, $autoFill = true) {
		if ($url instanceof Url) {
			$this->data = array();
			$this->data[URL_PROTOCOL] = $url->data[URL_PROTOCOL];
			$this->data[URL_USER] = $url->data[URL_USER];
			$this->data[URL_PASSWORD] = $url->data[URL_PASSWORD];
			$this->data[URL_SERVER] = $url->data[URL_SERVER];
			$this->data[URL_PORT] = $url->data[URL_PORT];
			$this->data[URL_PATH] = $url->data[URL_PATH];
			$this->data[URL_QUERY] = $url->data[URL_QUERY];
			$this->data[URL_FRAGMENT] = $url->data[URL_FRAGMENT];
		} else {
			if ($url == null) {
				$url = Url::getCurrentUrl();
			}
		
			$this->setUrl($url);
			if ($autoFill) {
				$this->fillRelativeUrl();
			}
		}
	}
	
	public function setUrl($url) {
		$this->data = Url::parseUrl($url);
	}
	
	public function __toString() {
		return $this->toString();
	}
	
	public function toString($full = false) {
		$url = $this->data[URL_PATH];
		
		if ($this->data[URL_QUERY] != null) {
			$url .= '?'.$this->data[URL_QUERY];
		}
		
		if ($this->data[URL_FRAGMENT] != null) {
			$url .= '#'.$this->data[URL_FRAGMENT];
		}
		
		$currentDir = dirname($_SERVER["SCRIPT_NAME"]).'/';
		if (!$full && !Url::getCurrentUrl()->isStrangeUrl() && strpos($url, $currentDir) === 0) {
			if (strlen($url) > strlen($currentDir)) {
				$url = substr($url, strlen($currentDir));
			}
		} else {
			if ($this->data[URL_SERVER] != null) {
				$serverPart = $this->data[URL_SERVER];
				if ($this->data[URL_PORT] != null) {
					$serverPart .= ':'.$this->data[URL_PORT];
				}
				$url = $serverPart.$url;
				
				if ($this->data[URL_USER] != null) {
					$userPart = $this->data[URL_USER];
					if ($this->data[URL_PASSWORD] != null) {
						$userPart .= ':'.$this->data[URL_PASSWORD];
					}
					$url = $userPart.'@'.$url;
				}
			
				if ($this->data[URL_PROTOCOL] != null) {
					$url = $this->data[URL_PROTOCOL].'://'.$url;
				}
			}
		}
		
		return $url;
	}
	
	public function toFullString() {
		return $this->toString(true);
	}
	
	public function set($part, $value) {
		if (array_key_exists($part, $this->data)) {
			$this->data[$part] = $value;
		}
		else {
			throw new Exception($part." is not a known part.");
		}
	}
	
	public function get($part) {
		if (array_key_exists($part, $this->data)) {
			return $this->data[$part];
		}
		else {
			throw new Exception($part." is not a known part.");
		}
	}
	
	public function getQueryVars() {
		$query = $this->data[URL_QUERY];
		$vars = array();
		if ($query != null) {
			$blocs = preg_split("#&#", $query);
			foreach($blocs as $bloc) {
				$content = preg_split("#=#", $bloc);
				if (count($content) == 1) {
					$content[] = null;
				}
				$vars[urldecode($content[0])] = urldecode($content[1]);
			}
		}
		return $vars;
	}
	
	public function hasQueryVar($name) {
		return array_key_exists($name, $this->getQueryVars());
	}
	
	public function getQueryVar($name) {
		$vars = $this->getQueryVars();
		if (isset($vars[$name])) {
			return $vars[$name];
		}
		else {
			throw new Exception($name." is not in the query vars.");
		}
	}
	
	public function setQueryVars($vars) {
		$query = "";
		if (count($vars) > 0) {
			foreach($vars as $name => $value) {
				$query .= '&'.urlencode($name);
				if ($value != null) {
					$query .= '='.urlencode($value);
				}
			}
		}
		$query = empty($query) ? "" : substr($query, 1);
		$this->data[URL_QUERY] = $query;
	}
	
	public function setQueryVar($name, $value = null, $removeIfNull = false) {
		if ($value === null && $removeIfNull) {
			$this->removeQueryVar($name);
		} else {
			$vars = $this->getQueryVars();
			$vars[$name] = $value;
			$this->setQueryVars($vars);
		}
	}
	
	public function removeQueryVar($name) {
		$vars = $this->getQueryVars();
		unset($vars[$name]);
		$this->setQueryVars($vars);
	}
	
	public function fillRelativeUrl() {
		if ($this->data[URL_PROTOCOL] == null && $this->data[URL_SERVER] == null) {
			$this->data = Url::parseUrl(Url::getCurrentDirUrl()->toString().'/'.$this->toString());
		}
	}
	
	public function isLocalUrl() {
		$local = Url::getCurrentUrl();
		return $this->get(URL_SERVER) === $local->get(URL_SERVER);
	}
	
	public function isCurrentDirUrl() {
		return $this->isLocalUrl() && dirname($this->get(URL_PATH)) === dirname(Url::getCurrentDirUrl()->get(URL_PATH));
	}
	
	public function isStrangeUrl() {
		return $this->hasStrangePath();
	}
	
	private function hasStrangePath() {
		// examples of strange scripts recognized by this code :
		// index.php/%22onmouseover=prompt(987201)%3E
		$current = $this->data[URL_PATH];
		$script = $_SERVER['SCRIPT_NAME'];
		if (strpos($current, $script) === 0 && strlen($current) > strlen($script)) {
			return true;
		}
	}
	
	public function cleanStrangeParts() {
		if ($this->hasStrangePath()) {
			$this->data[URL_PATH] = $_SERVER['SCRIPT_NAME'];
		}
	}
	
	public static function getCurrentUrl() {
		return new Url("http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
	}
	
	public static function getCurrentScriptUrl() {
		return new Url("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]);
	}
	
	public static function getCurrentDirUrl() {
		return new Url(dirname("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]));
	}
	
	public static function parseUrl($url) {
		if ($url instanceof Url) {
			$url = $url->toFullString();
		}
		
		$data = array();
		$data[URL_PROTOCOL] = parse_url($url, PHP_URL_SCHEME);
		$data[URL_USER] = parse_url($url, PHP_URL_USER);
		$data[URL_PASSWORD] = parse_url($url, PHP_URL_PASS);
		$data[URL_SERVER] = parse_url($url, PHP_URL_HOST);
		$data[URL_PORT] = parse_url($url, PHP_URL_PORT);
		$data[URL_PATH] = parse_url($url, PHP_URL_PATH);
		$data[URL_QUERY] = parse_url($url, PHP_URL_QUERY);
		$data[URL_FRAGMENT] = parse_url($url, PHP_URL_FRAGMENT);
		foreach($data as $part => $value) {
			if ($value === false) {
				throw new Exception("The URL is malformed, especially regarding the part ".$part);
			}
		}
		return $data;
	}
	
	public static function completeUrl($url) {
		$url = new Url($url, false);
		$url->fillRelativeUrl();
		return $url->toString();
	}
	
	public static function indexUrl() {
		return new Url('index.php');
	}
}
?>