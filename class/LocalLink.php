<?php
/*
	A local link is a link refering to a resource available from the directory of the current script.
*/

class LocalLink extends Link {
	public function setUrl($url) {
		parent::setUrl(Url::getCurrentDirUrl().'/'.$url);
	}
}
?>
