<?php
class PartnerLink extends Link {
	public function __construct(Partner $partner) {
		parent::__construct($partner->getWebsiteUrl(), new Image($partner->getBannerUrl(), $partner->getName()));
		$this->openNewWindow(true);
	}
}
?>
