<?php
	class VersionDescriptor {
		private $version;
		private $comment;
		private $url;
		
		public function __construct($version, $comment, $url = null) {
			$this->version = $version;
			$this->comment = $comment;
			$this->url = $url;
		}
		
		public function getVersion() {return $this->version;}
		public function getComment() {return $this->comment;}
		public function getUrl() {return $this->url;}
	}
	
	$versions = array(
		new VersionDescriptor('1.0', "Zéro était un site de ddl."),
		new VersionDescriptor('1.1', "Zéro devient une team de fansub avec pour seul projet [project=kimikiss][/project].", new Url('http://zero.xooit.fr/index.php?theme=test')),
		new VersionDescriptor('2.0', "On essaye un design plus moderne, et c'est jouli. Enfin, je trouve. Et puis c'est rose !", new Url('http://zerofansub.net/v2/?s_theme=rose')),
		new VersionDescriptor('2.1', "On laisse le choix à l'utilisateur, si il préfère le bleu ^^", new Url('http://zerofansub.net/v2/index.php?s_theme=bleu')),
		new VersionDescriptor('2.2', "Et pour les tristes, du noir. Du black !", new Url('http://zerofansub.net/v2/index.php?s_theme=noir')),
		new VersionDescriptor('3.0', "Le petit rond de la v2 n'étant pas pratique, on change de systéme pour la v3. De couleurs aussi.", new Url('index3.0.php')),
	);
	
	$tags = null;
	exec("git tag", $tags);
	foreach($tags as $tag) {
		if (!preg_match('#^v[0-9]+(\\.[0-9]+)*$#', $tag)) {
			continue;
		} else {
			$version = substr($tag, 1);
			$output = null;
			exec("git tag -v $tag", $output);
			array_shift($output); // remove hash
			array_shift($output); // remove type
			array_shift($output); // remove tag name
			array_shift($output); // remove tagger
			array_shift($output); // remove empty line
			$output = array_reduce($output, function($result, $item) {return $result == null ? $item : "$result\n$item";});
			// TODO create a link to access the old websites (clone in temp if not yet there)
			$desc = new VersionDescriptor($version, $output);
			$versions[] = $desc;
		}
	}
	
	/***********************\
	         DISPLAY
	\***********************/
	
	$page = PageContent::getInstance();
	$page->addComponent(new Title("À propos...", 1));

	$page->addComponent(new Title("Historique des versions", 2));
	
	$table = new Table();
	$page->addComponent($table);

	$row = new TableRow();
	$head = new TableHeader("Version");
	$head->setClass("version");
	$row->addComponent($head);
	$head = new TableHeader("Déscription");
	$head->setClass("description");
	$row->addComponent($head);
	$head = new TableHeader("Aperçu");
	$head->setClass("preview");
	$row->addComponent($head);
	$table->addComponent($row);

	foreach($versions as $desc) {
		$row = new TableRow();
		$row->addComponent(preg_match('#^[0-9]+(\\.0+)*$#', $desc->getVersion()) ? '<b>'.$desc->getVersion().'</b>' : $desc->getVersion());
		$row->addComponent(Format::convertTextToHtml($desc->getComment()));
		$row->addComponent(WEBSITE_VERSION == $desc->getVersion() ? 'Version actuelle !' : ($desc->getUrl() == null ? 'Non dispo' : Link::newWindowLink($desc->getUrl(), "Utiliser cette version")));
		$table->addComponent($row);
	}
?>