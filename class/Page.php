<?php
class Page {
	private $id = null;
	private $content = null;
	
	public function setContent($content) {
		$this->content = $content;
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function setID($id) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
	}
	
	private static $allPages = null;
	public static function getAllPages() {
		if (Page::$allPages === null) {
			Page::$allPages = array();
			
			$page = new Page();
			$page->setID('contact');
			$page->setContent("[title]Contact[/title]


Un commentaire à faire ?
Une critique ?
Un lien mort ?
Une proposition ?
Un lien de streaming ?

Une seule adresse pour contacter la team :


[size=25px][mail]zero.fansub@gmail.com[/mail][/size]");
			Page::$allPages[] = $page;
			
			$page = new Page();
			$page->setID('bug');
			$page->setContent("[title]Signaler un bug[/title]


Le site étant en plein raffinage, il est possible que vous tombiez sur des bogues (ou bug) au cours de votre navigation. Si tel est le cas, vous retomberez généralement sur cette page. Par conséquent, si vous vous trouvez ici sans trop savoir pourquoi, c'est probablement parce que vous venez de tomber sur un de ces bogues. Pour nous le signaler, plusieurs moyens sont à votre disposition :

[url=https://github.com/Sazaju/Zero-Fansub-website/issues]Enregistrer un bug sur GitHub[/url]

[mail=5]Envoyer un mail à l'administrateur Web[/mail]

La première solution est de loin la meilleure, car en plus d'avertir les administrateurs, le problème est enregistré et peut donc être suivi efficacement. Néanmoins, si vous ne savez pas comment utiliser ce système, la seconde option vous permet d'envoyer directement un mail aux admins. De préférence utilisez la première solution, n'utilisez la seconde que si vraiment vous avez des soucis avec la première.

Soyez sûrs de donner le maximum de détails, en particulier l'adresse actuelle de la page, la page ou vous étiez juste avant le bogue, votre navigateur et sa version (ou au moins dire si vous l'avez mis à jour récemment), et les plugins ou programmes que vous auriez installé qui vous semble être une cause potentielle du problème (gestionnaire de scripts, antivirus, ...).

En voici quelques unes, vous pouvez les recopier et les compléter :
[left][list]
[item]adresse actuelle : [currentUrl=full][/item]
[item]adresse précédente : [refererUrl=full][/item]
[item]infos navigateur : [serverData=HTTP_USER_AGENT][/item]
[/list][/left]");
			Page::$allPages[] = $page;
		}
		return Page::$allPages;
	}
	
	public static function getPage($id) {
		foreach(Page::getAllPages() as $page) {
			if ($page->getID() === $id) {
				return $page;
			}
		}
		throw new Exception($id.' si not a known page ID');
	}
}
?>
