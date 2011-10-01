<?php
/*
	A release component is an HTML element displaying a single release.
*/
class ReleaseComponent extends SimpleBlockComponent {
	public function __construct(Release $release) {
		$title = ucfirst($release->getName());
		$project = $release->getProject();
		if ($project !== null) {
			$title = $project->getName()." - ".$title;
		}
		$link = new Link(null, $title);
		$title = new Title($link);
		$title->setClass("title");
		$this->addComponent($title);
		
		if ($release->isReleased()) {
			$this->setClass("released");
			$link->setUrl("#");
			$link->setOnClick("show('".$release->getID()."');return(false)");
			
			$fileName = new SimpleTextComponent($release->getFileName());
			$fileName->setClass("fileName");
			
			$fileLink = new DirectDownloadLink(null, "Télécharger");
			$fileLink->getLink()->setUrl("ddl/".$release->getFileName());
			
			$torrentLink = new TorrentLink($release->getTorrentID());
			
			$previewImage = new Image($release->getPreviewUrl());
			$previewImage->setClass("previewImage");
			
			$size = new SimpleBlockComponent();
			$size->setClass("size");
			try {
				$size->addComponent(new Title("Taille"));
				$size->addComponent(Format::formatSize(filesize($this->fileLink->getLink()->getUrl())));
			} catch(Exception $e) {
				$size->clear();
			}
			
			$codecs = new SimpleBlockComponent();
			$codecs->setClass("codecs");
			$array = array();
			if ($release->getVideoCodec() !== null) {
				$array[] = $release->getVideoCodec()->getName();
			}
			if ($release->getSoundCodec() !== null) {
				$array[] = $release->getSoundCodec()->getName();
			}
			if ($release->getContainerCodec() !== null) {
				$array[] = $release->getContainerCodec()->getName();
			}
			if (!empty($array)) {
				$codecs->addComponent(new Title("Codecs"));
				$codecs->addComponent(Format::arrayToString($array, " "));
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
			$list = new SimpleListComponent();
			$list->setClass("fileList");
			$list->addcomponent($fileName);
			$content->addComponent($list);
			$content->addComponent($size);
			$content->addComponent($codecs);
			$content->addComponent(new title("Téléchargements"));
			$list = new SimpleListComponent();
			$list->setClass("linkList");
			$list->addcomponent($fileLink);
			$list->addComponent($torrentLink);
			$list->addComponent(new XdccLink());
			$content->addComponent($list);
		}
		else {
			$this->setClass("notReleased");
			$link->setUrl(null);
			$link->addComponent(" - Non disponible");
		}
	}
}

?>