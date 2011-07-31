<?php
/*
	A index link is a link refering to a resource available from the index (home) page. It is more
	controled than a local link (available from the local server). Especially, the given url is
	automatically completed with the index address, giving a link to the index page simply creating
	a new index link (without giving url).
*/

class IndexLink extends Link {
	public function getUrl() {
		return $_SERVER['PHP_SELF'].'?'.parent::getUrl();
	}
}
?>
