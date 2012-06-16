<?php
/*
	A release component is an HTML element displaying a single release.
*/
class ReleaseComponent extends SimpleBlockComponent {
	public function __construct(Release $release, $forceDisplay = false) {
		$this->addComponent(new Anchor($release->getID()));
		
		$link = new Link(null, $release->getCompleteName());
		$title = new Title($link);
		$title->setClass("title");
		$this->addComponent($title);
		
		if ($release->isReleased() || $forceDisplay) {
			$this->setClass("released");
			$link->setUrl(new Url());
			$link->setOnClick("show('".$release->getID()."');return(false)");
			
			$releaseContent = new SimpleBlockComponent();
			$releaseContent->setID($release->getID());
			$releaseContent->setClass("content");
			$this->addComponent($releaseContent);
			
			$previewImage = null;
			if ($release->getPreviewUrl() !== null) {
				try {
					$pUrl = $release->getPreviewUrl()->toString();
					$previewImage = new AutoFloatImage($pUrl);
					$previewImage->setClass("previewImage");
					
					$description = getimagesize($pUrl);
					$width = $description[0];
					if ($width < 150) {
						$previewImage->makeRightFloating();
					}
				} catch(ErrorException $ex) {
					$previewImage = Debug::createWarningTag("Preview introuvable");
				}
			}
			$releaseContent->addComponent($previewImage);
			
			$localizedName = new SimpleBlockComponent();
			$localizedName->setClass("localizedName");
			if ($release->getLocalizedTitle() !== null) {
				$localizedName->addComponent(new Title("Nom de l'épisode FR"));
				$localizedName->addComponent($release->getLocalizedTitle());
			}
			$releaseContent->addComponent($localizedName);
			
			$originalName = new SimpleBlockComponent();
			$originalName->setClass("originalName");
			if ($release->getOriginalTitle() !== null) {
				$originalName->addComponent(new Title("Nom original"));
				$originalName->addComponent($release->getOriginalTitle());
			}
			$releaseContent->addComponent($originalName);
			
			$synopsis = new SimpleBlockComponent();
			$synopsis->setClass("synopsis");
			if ($release->getSynopsis() !== null) {
				$synopsis->addComponent(new Title("Synopsis"));
				$synopsis->addComponent(Format::convertTextToHtml($release->getSynopsis()));
			}
			$releaseContent->addComponent($synopsis);
			
			$comment = new SimpleBlockComponent();
			$comment->setClass("comment");
			if ($release->getComment() !== null) {
				$comment->addComponent($release->getComment());
			}
			$releaseContent->addComponent($comment);
			
			$staff = new SimpleBlockComponent();
			$staff->setClass("staff");
			$members = $release->getStaffMembers();
			if (!empty($members)) {
				$staff->addComponent(new Title("Staff"));
				$strings = array();
				foreach($members as $member) {
					$string = $member->getPseudo();
					$roles = $release->getAssignmentFor($member->getID())->getRoles();
					if (!empty($roles)) {
						$strings2 = array();
						foreach($roles as $role) {
							$strings2[] = $role->getName();
						}
						$string .= " : ".Format::arrayToString($strings2);
					}
					$strings[] = $string;
				}
				$staff->addComponent(format::arrayToString($strings, " | "));
			}
			$releaseContent->addComponent($staff);
			
			if ($release->isLicensed()) {
				$this->fillWithLicenseData($releaseContent, $release);
			}
			else {
				$this->fillWithDownloadData($releaseContent, $release);
			}
			
			$releaseContent->addComponent(new Pin());
			$url = new Url();
			$vars = $url->getQueryVars();
			if (!isset($vars['show']) || !(strcmp($vars['show'], "*") == 0 || preg_match("#(,|^)".preg_quote($release->getID())."(,|$)#", $vars['show']) > 0)) {
				$releaseContent->addComponent("<script type='text/javascript'>show('".$release->getID()."');</script>");
			}
		}
		else {
			$this->setClass("notReleased");
			$link->setUrl(new Url());
			$link->addComponent(" - Non disponible");
		}
	}
	
	private function fillWithLicenseData($releaseContent, $release) {
		$license = $release->getLicense();
		
		$releaseContent->addComponent(new title("Licencié"));
		$list = new SimpleListComponent();
		$list->setClass("licenseList");
		if ($license->getOwner() != null) {
			$list->addComponent("Propriétaire : ".$license->getOwner());
		}
		$releaseContent->addComponent($list);
		
		$list = new SimpleListComponent();
		$list->setClass("linkList");
		$bonusLinks = new GroupedLinks(new Image("images/icones/bonus.png"));
		$bonusLinks->setClass("bonusLinks");
		foreach($release->getLicenseSafeBonuses() as $link) {
			$bonusLinks->addLink($link);
		}
		if (!$bonusLinks->isEmpty()) {
			$list->addComponent($bonusLinks);
		}
		$releaseContent->addComponent($list);
	}
	
	private function fillWithDownloadData($releaseContent, $release) {
		$fileList = new SimpleListComponent();
		$fileList->setClass("fileList");
		$ddlLinks = new GroupedLinks(new Image("images/icones/ddl.png"));
		$ddlLinks->setClass("ddlLinks");
		$megauploadLinks = new GroupedLinks(new Image("images/icones/megaup.jpg"));
		$megauploadLinks->setClass("megauploadLinks");
		$freeLinks = new GroupedLinks(new Image("images/icones/free.jpg"));
		$freeLinks->setClass("freeLinks");
		$rapidShareLinks = new GroupedLinks(new Image("images/icones/rapidshare.jpg"));
		$rapidShareLinks->setClass("rapidShareLinks");
		$mediaFireLinks = new GroupedLinks(new Image("images/icones/mediafire.jpg", "Mediafire"));
		$mediaFireLinks->setClass("mediaFireLinks");
		$torrentLinks = new GroupedLinks(new Link($release->getTorrentUrl(), new Image("images/icones/torrent.png")));
		$torrentLinks->setClass("torrentLink");
		$fileDescriptors = $release->getFileDescriptors();
		$index = 1;
		foreach($fileDescriptors as $descriptor) {
			$description = new SimpleTextComponent();
			
			$path = $descriptor->getFilePath();
			$name = basename($path);
			if (empty($name)) {
				$name = Debug::createWarningTag("aucun fichier renseigné");
			}
			$description->addLine($name);
			
			$url = "ddl/".$path;
			
			$size = "Taille : ";
			try {
				$size .= Format::formatSize(filesize($url));
			} catch(Exception $e) {
				$size .= Debug::createWarningTag("inconnue");
			}
			$size .= " ";
			$description->addComponent($size);
			
			if ($descriptor->getCRC() !== null) {
				$description->addComponent("CRC : ".$descriptor->getCRC()." ");
			}
			
			$id = null;
			if ($release->getProject()->isDoujin()) {
				$pages = "";
				if ($descriptor->getPageNumber() != null) {
					$n = $descriptor->getPageNumber();
					$pages = $n." page".($n > 1 ? "s" : null)." ";
				}
				$description->addComponent($pages);
			}
			else {
				$array = array();
				if ($descriptor->getVideoCodec() !== null) {
					$array[] = $descriptor->getVideoCodec()->getName();
					if ($id == null) {
						$id = $descriptor->getVideoCodec()->getName();
					}
				}
				if ($descriptor->getSoundCodec() !== null) {
					$array[] = $descriptor->getSoundCodec()->getName();
					if ($id == null) {
						$id = $descriptor->getSoundCodec()->getName();
					}
				}
				if ($descriptor->getContainerCodec() !== null) {
					$array[] = $descriptor->getContainerCodec()->getName();
					if ($id == null) {
						$id = $descriptor->getContainerCodec()->getName();
					}
				}
				$codecs = "";
				if (!empty($array)) {
					$codecs = "Codecs : ".implode(" ", $array)." ";
				}
				$description->addComponent($codecs);
			}
			
			if ($descriptor->getReleaseSource() !== null) {
				$description->addComponent("Source : ".$descriptor->getReleaseSource()." ");
			}
			
			if ($descriptor->getID() != null) {
				$id = $descriptor->getID();
			}
			else if ($id == null) {
				$id = $index;
			}
			$index ++;
			
			if ($descriptor->getComment() !== null) {
				$description->addLine();
				$comment = new SimpleBlockComponent();
				$comment->setClass("comment");
				$comment->setContent($descriptor->getComment());
				$description->addComponent($comment);
			}
			
			$description->addLine();
			$fileList->addcomponent($description);
			
			$linkName = count($fileDescriptors) == 1 ? "Télécharger" : $id;
			$ddlLinks->addLink(new Link($url, $linkName));
			if ($descriptor->getMegauploadUrl() !== null) {
				$megauploadLinks->addLink(new Link($descriptor->getMegauploadUrl(), $linkName));
			}
			if ($descriptor->getFreeUrl() !== null) {
				$freeLinks->addLink(new Link($descriptor->getFreeUrl(), $linkName));
			}
			if ($descriptor->getRapidShareUrl() !== null) {
				$rapidShareLinks->addLink(new Link($descriptor->getRapidShareUrl(), $linkName));
			}
			if ($descriptor->getMediaFireUrl() !== null) {
				$mediaFireLinks->addLink(new Link($descriptor->getMediaFireUrl(), $linkName));
			}
			if ($descriptor->getTorrentUrl() !== null) {
				$torrentLinks->addLink(new Link($descriptor->getTorrentUrl(), $linkName));
			}
		}
		$releaseContent->addComponent(new title("Fichiers"));
		$releaseContent->addComponent($fileList);
		
		$releaseContent->addComponent(new title("Téléchargements"));
		$list = new SimpleListComponent();
		$list->setClass("linkList");
		$list->addcomponent($ddlLinks);
		if (!$megauploadLinks->isEmpty()) {
			// MU links removed because MU down
			//$list->addComponent($megauploadLinks);
		}
		if (!$freeLinks->isEmpty()) {
			$list->addComponent($freeLinks);
		}
		if (!$rapidShareLinks->isEmpty()) {
			$list->addComponent($rapidShareLinks);
		}
		if (!$mediaFireLinks->isEmpty()) {
			$list->addComponent($mediaFireLinks);
		}
		$list->addComponent($torrentLinks);
		$list->addComponent(new XdccLink());
		$streamingsLinks = new GroupedLinks(new Image("images/icones/streaming.png"));
		$streamingsLinks->setClass("streamingsLinks");
		foreach($release->getStreamings() as $link) {
			$streamingsLinks->addLink($link);
		}
		if (!$streamingsLinks->isEmpty()) {
			$list->addComponent($streamingsLinks);
		}
		$bonusLinks = new GroupedLinks(new Image("images/icones/bonus.png"));
		$bonusLinks->setClass("bonusLinks");
		foreach($release->getBonuses() as $link) {
			$bonusLinks->addLink($link);
		}
		if (!$bonusLinks->isEmpty()) {
			$list->addComponent($bonusLinks);
		}
		$releaseContent->addComponent($list);
	}
}

class GroupedLinks extends SimpleTextComponent {
	private $prefix = null;
	
	public function __construct($prefix) {
		$this->addComponent($prefix);
		$this->prefix = $prefix;
	}
	
	public function isEmpty() {
		return count($this->getComponents()) < ($this->prefix === null ? 1 : 2);
	}
	
	public function getPrefix() {
		return $this->prefix;
	}
	
	public function addLink(Link $link) {
		$link->getComponents();
		$this->addComponent(" [ ");
		$this->addComponent($link);
		$this->addComponent(" ]");
	}
}
?>