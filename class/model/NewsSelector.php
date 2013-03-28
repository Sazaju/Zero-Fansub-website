<?php
define('NEWSSELECTOR_DB0COMPANY', 'c');
define('NEWSSELECTOR_MISC', 'm');
define('NEWSSELECTOR_PARTNERS', 'p');
define('NEWSSELECTOR_RELEASES', 'r');
define('NEWSSELECTOR_TEAM', 't');
define('NEWSSELECTOR_ALL', '');

class NewsSelector {
	public static $readers;//initialized out of the class
	
	public function __construct($string = NEWSSELECTOR_ALL, $hMode = false) {
		$this->setHModeActivated($hMode);
		$this->parseString($string);
	}
	
	private $hMode = false;
	public function setHModeActivated($boolean) {
		$this->hMode = $boolean;
	}
	
	public function isHModeActivated() {
		return $this->hMode;
	}
	
	private $preparedShown = false;
	public function setPreparedShown($boolean) {
		$this->preparedShown = $boolean;
	}
	
	public function isPreparedShown() {
		return $this->preparedShown;
	}
	
	private $constraints = array();
	private function set($key, $value) {
		if ($value === null) {
			unset($this->constraints[$key]);
		} else {
			$this->constraints[$key] = $value;
		}
	}
	
	private function get($key) {
		return array_key_exists($key, $this->constraints)
				? $this->constraints[$key]
				: null;
	}
	
	public function setDb0CompanySelected($boolean) {
		$this->set(NEWSSELECTOR_DB0COMPANY, $boolean);
	}
	
	public function isDb0CompanySelected() {
		return $this->set(NEWSSELECTOR_DB0COMPANY);
	}
	
	public function setMiscSelected($boolean) {
		$this->set(NEWSSELECTOR_MISC, $boolean);
	}
	
	public function isMiscSelected() {
		return $this->set(NEWSSELECTOR_MISC);
	}
	
	public function setPartnersSelected($boolean) {
		$this->set(NEWSSELECTOR_PARTNERS, $boolean);
	}
	
	public function isPartnersSelected() {
		return $this->set(NEWSSELECTOR_PARTNERS);
	}
	
	public function setReleasesSelected($boolean) {
		$this->set(NEWSSELECTOR_RELEASES, $boolean);
	}
	
	public function isReleasesSelected() {
		return $this->set(NEWSSELECTOR_RELEASES);
	}
	
	public function setTeamSelected($boolean) {
		$this->set(NEWSSELECTOR_TEAM, $boolean);
	}
	
	public function isTeamSelected() {
		return $this->set(NEWSSELECTOR_TEAM);
	}
	
	public function parseString($string) {
		$this->clear();
		for($i = 0 ; $i < strlen($string) ; $i++) {
			$c = $string[$i];
			$l = strtolower($c);
			$value = ctype_lower($c);
			switch($l) {
				case NEWSSELECTOR_DB0COMPANY:
				case NEWSSELECTOR_MISC:
				case NEWSSELECTOR_PARTNERS:
				case NEWSSELECTOR_RELEASES:
				case NEWSSELECTOR_TEAM:
					$this->set($l, $value);
					break;
				default: throw new Exception("Invalid filter string '$string' (at character $i)");
			}
		}
	}
	
	public function getString() {
		$string = "";
		foreach($this->constraints as $key => $isLower) {
			$string .= $isLower ? strtolower($key) : strtoupper($key);
		};
		return $string;
	}
	
	public function clear() {
		$this->constraints = array();
	}
	
	public function isSelectingNews(News $news) {
		if ($this->isHModeActivated() && !$news->displayInHentaiMode() // wrong mode (H)
		    || !$this->isHModeActivated() && !$news->displayInNormalMode() // wrong mode (not H)
		    || !$this->isPreparedShown() && !$news->isPublished() // unpublished news
		    ) {
			return false;
		} else {
			foreach($this->constraints as $key => $constraint) {
				$reader = NewsSelector::$readers[$key];
				if ($reader($news) != $constraint) {
					return false;
				} else {
					continue;
				}
			}
			return true;
		}
	}
	
	public function getCallback() {
		$selector = $this;
		return function(News $news) use($selector) {
			return $selector->isSelectingNews($news);
		};
	}
}

NewsSelector::$readers = array(
		NEWSSELECTOR_DB0COMPANY => function(News $news) {return $news->isDb0CompanyNews();},
		NEWSSELECTOR_PARTNERS => function(News $news) {return $news->isPartnerNews();},
		NEWSSELECTOR_RELEASES => function(News $news) {return $news->isReleasing();},
		NEWSSELECTOR_TEAM => function(News $news) {return $news->isTeamNews();},
		NEWSSELECTOR_MISC => function(News $news) {return !$news->isDb0CompanyNews() && !$news->isPartnerNews() && !$news->isReleasing() && !$news->isTeamNews();}
);

?>