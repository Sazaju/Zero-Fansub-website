<?php
/*
	A release component is an HTML element displaying a single release.
*/
class ReleaseComponent extends SimpleBlockComponent {
	public function __construct(Release $release) {
		$title = ucfirst($release->getName());
		$project = $release->getProject();
		if ($project !== null) {
			$title = $project->getName().($title == null ? null : " - ".$title);
		}
		$link = new Link(null, $title);
		$title = new Title($link);
		$title->setClass("title");
		$this->addComponent($title);
		
		if ($release->isReleased()) {
			$this->setClass("released");
			$link->setUrl("#");
			$link->setOnClick("show('".$release->getID()."');return(false)");
			
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
			$torrentLinks = new GroupedLinks(new Link("http://www.bt-anime.net/index.php?page=tracker&team=Z%e9ro", new Image("images/icones/torrent.png")));
			$torrentLinks->setClass("torrentLink");
			$fileDescriptors = $release->getFileDescriptors();
			foreach($fileDescriptors as $descriptor) {
				$description = new SimpleTextComponent();
				
				$name = $descriptor->getFileName();
				$description->addLine($name);
				
				$url = "ddl/".$name;
				
				$size = "";
				try {
					$size = "Taille : ".Format::formatSize(filesize($url))." ";
				} catch(Exception $e) {
				}
				$description->addComponent($size);
				
				if ($descriptor->getCRC() !== null) {
					$description->addComponent("CRC : ".$descriptor->getCRC()." ");
				}
				
				$array = array();
				if ($descriptor->getID() != null) {
					$array[] = $descriptor->getID();
				}
				if ($descriptor->getVideoCodec() !== null) {
					$array[] = $descriptor->getVideoCodec()->getName();
				}
				if ($descriptor->getSoundCodec() !== null) {
					$array[] = $descriptor->getSoundCodec()->getName();
				}
				if ($descriptor->getContainerCodec() !== null) {
					$array[] = $descriptor->getContainerCodec()->getName();
				}
				$codecs = "";
				if (!empty($array)) {
					$codecs = "Codecs : ".Format::arrayToString($array, " ");
				}
				$description->addComponent($codecs);
				
				$description->addLine();
				$fileList->addcomponent($description);
				
				$linkName = count($fileDescriptors) == 1 ? "Télécharger" : $array[0];
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
				if ($descriptor->getTorrentUrl() !== null) {
					$torrentLinks->addLink(new Link($descriptor->getTorrentUrl(), $linkName));
				}
			}
			
			$previewImage = null;
			if ($release->getPreviewUrl() !== null) {
				$previewImage = new Image($release->getPreviewUrl());
				$previewImage->setClass("previewImage");
				$description = getimagesize($release->getPreviewUrl());
				if ($description[0] < $description[1]) {
					$previewImage->setStyle("float : right;");
				}
			}
			
			$synopsis = new SimpleBlockComponent();
			$synopsis->setClass("synopsis");
			if ($release->getSynopsis() !== null) {
				$synopsis->addComponent(new Title("Synopsis"));
				$synopsis->addComponent($release->getSynopsis());
			}
			
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
			
			$originalName = new SimpleBlockComponent();
			$originalName->setClass("originalName");
			if ($release->getOriginalName() !== null) {
				$originalName->addComponent(new Title("Nom original"));
				$originalName->addComponent($release->getOriginalName());
			}
			
			$localizedName = new SimpleBlockComponent();
			$localizedName->setClass("localizedName");
			if ($release->getLocalizedName() !== null) {
				$localizedName->addComponent(new Title("Nom de l'épisode FR"));
				$localizedName->addComponent($release->getLocalizedName());
			}
			
			$bonusLinks = new GroupedLinks(new Image("images/icones/bonus.png"));
			$bonusLinks->setClass("bonusLinks");
			foreach($release->getBonuses() as $link) {
				$bonusLinks->addLink($link);
			}
			
			$streamingsLinks = new GroupedLinks(new Image("images/icones/streaming.png"));
			$streamingsLinks->setClass("streamingsLinks");
			foreach($release->getStreamings() as $link) {
				$streamingsLinks->addLink($link);
			}
			
			$content = new SimpleBlockComponent();
			$content->setID($release->getID());
			$content->setStyle("display:none;");
			$content->setClass("content");
			$this->addComponent($content);
			$content->addComponent($previewImage);
			$content->addComponent($localizedName);
			$content->addComponent($originalName);
			$content->addComponent($synopsis);
			$content->addComponent($staff);
			$content->addComponent(new title("Fichiers"));
			$content->addComponent($fileList);
			$content->addComponent(new title("Téléchargements"));
			$list = new SimpleListComponent();
			$list->setClass("linkList");
			$list->addcomponent($ddlLinks);
			if (!$megauploadLinks->isEmpty()) {
				$list->addComponent($megauploadLinks);
			}
			if (!$freeLinks->isEmpty()) {
				$list->addComponent($freeLinks);
			}
			if (!$rapidShareLinks->isEmpty()) {
				$list->addComponent($rapidShareLinks);
			}
			$list->addComponent($torrentLinks);
			$list->addComponent(new XdccLink());
			if (!$streamingsLinks->isEmpty()) {
				$list->addComponent($streamingsLinks);
			}
			if (!$bonusLinks->isEmpty()) {
				$list->addComponent($bonusLinks);
			}
			$content->addComponent($list);
		}
		else {
			$this->setClass("notReleased");
			$link->setUrl(null);
			$link->addComponent(" - Non disponible");
		}
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
		$this->addComponent(" [ ");
		$this->addComponent($link);
		$this->addComponent(" ]");
	}
}
?>
