<?php
class PartnerLink extends Link {
	private $partner = false;
	private $useImage = false;
	
	public function __construct(Partner $partner, $content = null) {
		parent::__construct($partner->getWebsiteUrl(), $content);
		$this->partner = $partner;
		if ($content === null) {
			$this->setContent($partner->getName());
		}
		$this->openNewWindow(true);
	}
	
	public function setUseImage($boolean) {
		$this->useImage = $boolean;
		if ($boolean) {
			$this->setContent(new Image($this->partner->getBannerUrl(), $this->partner->getName()));
		} else {
			$this->setContent($this->partner->getName());
		}
	}
	
	public function useImage() {
		return $this->useImage;
	}
}
?>