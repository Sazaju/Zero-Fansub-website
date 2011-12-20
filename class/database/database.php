<?php
/*
	The database class wrap all the needed database code (PDO-based) with the
	specific data of this website. In particular, a testing mode is available,
	working on a separated database which is auto initialized (if needed).
	
	Static methods are available to create and get the default database. This default database is
	used by default in the persistent components.
*/

class Database {
	private static $defaultDatabase = null;
	private $connection;
	
	public static function createDefaultDatabase($testing = false) {
		Database::$defaultDatabase = new Database($testing);
	}
	
	public static function getDefaultDatabase() {
		$db = Database::$defaultDatabase;
		if ($db === null) {
			throw new Exception('default database not created yet');
		}
		else {
			return $db;
		}
	}
	
	public function __construct($testing = false) {
		if ($testing) {
			$this->connection = new PDO('sqlite:test.db');
			if (!$this->isInitialized()) {
				$this->initialize();
			}
		}
		else {
			$this->connection = new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS);
		}
	}
	
	public function getConnection() {
		return $this->connection;
	}
	
	public function clear() {
		$this->connection->exec('DROP TABLE IF EXISTS "property"');
		$this->connection->exec('DROP TABLE IF EXISTS "news"');
		$this->connection->exec('DROP TABLE IF EXISTS "project"');
	}
	
	public function isInitialized() {
		$result = $this->connection->query('select * from "property"');
		return $result !== false;
	}
	
	public function initialize() {
		$this->connection->beginTransaction();
		
		$this->connection->exec('CREATE TABLE "property" (
			id     VARCHAR(128),
			value  TEXT,
			
			PRIMARY KEY (id)
		)');
		$statement = $this->connection->prepare('INSERT INTO "property" (id, value) VALUES (?, ?)');
		$statement->execute(array('title', 'Zéro ~fansub~ :: Sous-titrage bénévole français d\'animation Japonaise'));
		$statement->execute(array('footer', 'crédits blabla'));
		$statement->execute(array('quickbar', 'Quick bar : images random vers : series, articles, pages,...'));
		$statement->execute(array('meta_author', 'The db0 company, http://db0.fr Contact db0company@gmail.com'));
		$statement->execute(array('meta_copyright', 'The db0 company, Copyright 2010, Tout droits résérvés. Si du contenu vous appartient et que vous souhaitez qu\'il soit retiré du 	site, demandez-le par mail db0company@gmail.com'));
		$statement->execute(array('meta_keywords', ''));
		$statement->execute(array('meta_description', ''));
		
		$this->connection->exec('CREATE TABLE "image" (
			id       INTEGER(10),
			url      VARCHAR(256),
			title    VARCHAR(128),
			
			PRIMARY KEY (id)
		)');
		$statement = $this->connection->prepare('INSERT INTO "image" (id, url, title) VALUES (?, ?, ?)');
		$statement->execute(array(0, 'images/news/test_news.jpg', 'Random Test News Mitsudomoe'));
		$statement->execute(array(1, 'images/interface/logo/zero.png', 'Zéro ~fansub~'));
		$statement->execute(array(2, 'images/project/0/image.jpg', 'Mitsudomoe'));
		$statement->execute(array(3, 'images/project/0/short.jpg', 'Mitsudomoe'));
		$statement->execute(array(4, 'images/project/1/image.jpg', 'Mitsudomoe 2'));
		$statement->execute(array(5, 'images/project/1/short.jpg', 'Mitsudomoe 2'));
		
		$this->connection->exec('CREATE TABLE "news" (
			id             INTEGER(10),
			title          VARCHAR(128),
			text           TEXT,
			image_id       INTEGER(10),
			
			PRIMARY KEY (id)
		)');
		$statement = $this->connection->prepare('INSERT INTO "news" (id, title, image_id, text) VALUES (?, ?, ?, ?)');
		$statement->execute(array(0, '[ fansub ] Mitsudomoe épisode 01', '0', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae porttitor arcu. Proin non condimentum lorem. Aenean in ante a ligula pulvinar pellentesque in vel ipsum. Nullam metus sapien, faucibus sit amet tincidunt nec, ultrices ut tellus. Quisque varius pharetra felis, eget pretium quam mattis a. Mauris at turpis vel arcu molestie vulputate ac sit amet lorem. In hac habitasse platea dictumst. Quisque pharetra neque id eros elementum facilisis. Nullam augue nulla, laoreet ut vulputate ac, auctor id enim. Vivamus varius eleifend lectus, a dignissim ante blandit eget. Donec congue, quam non pharetra faucibus, nunc nisi feugiat augue, nec sollicitudin quam lorem eget augue. In fringilla, felis ac pharetra convallis, eros mi pulvinar velit, ac congue quam turpis et dolor. In pellentesque tincidunt purus, eget laoreet orci semper in. Sed pulvinar justo nunc, sit amet eleifend tellus. Donec non elit tellus.

Integer in arcu massa, id venenatis mauris. Nulla non felis dui. Integer nec ipsum nisi, sed commodo purus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec in blandit diam. Suspendisse vel arcu purus, nec rhoncus lorem. Etiam ac consectetur lorem. Aliquam fringilla, velit sit amet ornare tempor, turpis lacus tristique orci, ut porta justo diam id sem. Etiam imperdiet nibh nec nibh eleifend ut accumsan leo dapibus. Etiam sem leo, egestas sed consequat vel, euismod quis metus. Ut gravida placerat metus sed tincidunt. Integer lacinia viverra dolor, non porta tortor aliquam a. Donec sodales justo eget magna sollicitudin blandit. Ut molestie, augue in pretium condimentum, orci erat facilisis tortor, nec auctor enim felis sed tellus. Vestibulum blandit massa eget mi tincidunt a aliquet dolor convallis. Nullam et magna vitae est imperdiet mattis. Ut semper urna tortor.'));
		$statement->execute(array(1, '[ fansub ] Mitsudomoe épisode 02', '0', 'News de l\'épisode 2'));
		$statement->execute(array(2, '[ fansub ] Mitsudomoe épisode 03', '0', 'News de l\'épisode 3'));
		$statement->execute(array(3, '[ fansub ] Mitsudomoe épisode 04', '0', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae porttitor arcu. Proin non condimentum lorem. Aenean in ante a ligula pulvinar pellentesque in vel ipsum. Nullam metus sapien, faucibus sit amet tincidunt nec, ultrices ut tellus. Quisque varius pharetra felis, eget pretium quam mattis a. Mauris at turpis vel arcu molestie vulputate ac sit amet lorem. In hac habitasse platea dictumst. Quisque pharetra neque id eros elementum facilisis. Nullam augue nulla, laoreet ut vulputate ac, auctor id enim. Vivamus varius eleifend lectus, a dignissim ante blandit eget. Donec congue, quam non pharetra faucibus, nunc nisi feugiat augue, nec sollicitudin quam lorem eget augue. In fringilla, felis ac pharetra convallis, eros mi pulvinar velit, ac congue quam turpis et dolor. In pellentesque tincidunt purus, eget laoreet orci semper in. Sed pulvinar justo nunc, sit amet eleifend tellus. Donec non elit tellus.

Integer in arcu massa, id venenatis mauris. Nulla non felis dui. Integer nec ipsum nisi, sed commodo purus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec in blandit diam. Suspendisse vel arcu purus, nec rhoncus lorem. Etiam ac consectetur lorem. Aliquam fringilla, velit sit amet ornare tempor, turpis lacus tristique orci, ut porta justo diam id sem. Etiam imperdiet nibh nec nibh eleifend ut accumsan leo dapibus. Etiam sem leo, egestas sed consequat vel, euismod quis metus. Ut gravida placerat metus sed tincidunt. Integer lacinia viverra dolor, non porta tortor aliquam a. Donec sodales justo eget magna sollicitudin blandit. Ut molestie, augue in pretium condimentum, orci erat facilisis tortor, nec auctor enim felis sed tellus. Vestibulum blandit massa eget mi tincidunt a aliquet dolor convallis. Nullam et magna vitae est imperdiet mattis. Ut semper urna tortor.'));
		
		$this->connection->exec('CREATE TABLE "project" (
			id             INTEGER(10),
			title          VARCHAR(128),
			description    TEXT,
			image_id       INTEGER(10),
			shortimage_id  INTEGER(10),
			
			PRIMARY KEY (id)
		)');
		$statement = $this->connection->prepare('INSERT INTO "project" (id, title, image_id, shortimage_id, description) VALUES (?, ?, ?, ?, ?)');
		$statement->execute(array(0, 'Mitsudomoe', 2, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae porttitor arcu. Proin non condimentum lorem. Aenean in ante a ligula pulvinar pellentesque in vel ipsum. Nullam metus sapien, faucibus sit amet tincidunt nec, ultrices ut tellus. Quisque varius pharetra felis, eget pretium quam mattis a. Mauris at turpis vel arcu molestie vulputate ac sit amet lorem. In hac habitasse platea dictumst. Quisque pharetra neque id eros elementum facilisis. Nullam augue nulla, laoreet ut vulputate ac, auctor id enim. Vivamus varius eleifend lectus, a dignissim ante blandit eget. Donec congue, quam non pharetra faucibus, nunc nisi feugiat augue, nec sollicitudin quam lorem eget augue. In fringilla, felis ac pharetra convallis, eros mi pulvinar velit, ac congue quam turpis et dolor. In pellentesque tincidunt purus, eget laoreet orci semper in. Sed pulvinar justo nunc, sit amet eleifend tellus. Donec non elit tellus.

Integer in arcu massa, id venenatis mauris. Nulla non felis dui. Integer nec ipsum nisi, sed commodo purus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec in blandit diam. Suspendisse vel arcu purus, nec rhoncus lorem. Etiam ac consectetur lorem. Aliquam fringilla, velit sit amet ornare tempor, turpis lacus tristique orci, ut porta justo diam id sem. Etiam imperdiet nibh nec nibh eleifend ut accumsan leo dapibus. Etiam sem leo, egestas sed consequat vel, euismod quis metus. Ut gravida placerat metus sed tincidunt. Integer lacinia viverra dolor, non porta tortor aliquam a. Donec sodales justo eget magna sollicitudin blandit. Ut molestie, augue in pretium condimentum, orci erat facilisis tortor, nec auctor enim felis sed tellus. Vestibulum blandit massa eget mi tincidunt a aliquet dolor convallis. Nullam et magna vitae est imperdiet mattis. Ut semper urna tortor.'));
		$statement->execute(array(1, 'Mitsudomoe 2', 4, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae porttitor arcu. Proin non condimentum lorem. Aenean in ante a ligula pulvinar pellentesque in vel ipsum. Nullam metus sapien, faucibus sit amet tincidunt nec, ultrices ut tellus. Quisque varius pharetra felis, eget pretium quam mattis a. Mauris at turpis vel arcu molestie vulputate ac sit amet lorem. In hac habitasse platea dictumst. Quisque pharetra neque id eros elementum facilisis. Nullam augue nulla, laoreet ut vulputate ac, auctor id enim. Vivamus varius eleifend lectus, a dignissim ante blandit eget. Donec congue, quam non pharetra faucibus, nunc nisi feugiat augue, nec sollicitudin quam lorem eget augue. In fringilla, felis ac pharetra convallis, eros mi pulvinar velit, ac congue quam turpis et dolor. In pellentesque tincidunt purus, eget laoreet orci semper in. Sed pulvinar justo nunc, sit amet eleifend tellus. Donec non elit tellus.

Integer in arcu massa, id venenatis mauris. Nulla non felis dui. Integer nec ipsum nisi, sed commodo purus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec in blandit diam. Suspendisse vel arcu purus, nec rhoncus lorem. Etiam ac consectetur lorem. Aliquam fringilla, velit sit amet ornare tempor, turpis lacus tristique orci, ut porta justo diam id sem. Etiam imperdiet nibh nec nibh eleifend ut accumsan leo dapibus. Etiam sem leo, egestas sed consequat vel, euismod quis metus. Ut gravida placerat metus sed tincidunt. Integer lacinia viverra dolor, non porta tortor aliquam a. Donec sodales justo eget magna sollicitudin blandit. Ut molestie, augue in pretium condimentum, orci erat facilisis tortor, nec auctor enim felis sed tellus. Vestibulum blandit massa eget mi tincidunt a aliquet dolor convallis. Nullam et magna vitae est imperdiet mattis. Ut semper urna tortor.'));
		
		$this->connection->commit();
	}
}
?>
