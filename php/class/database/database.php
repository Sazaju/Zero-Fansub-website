<?php
/*
	The database class wrap all the needed database code (PDO-based) with the
	specific data of this website. In particular, a testing mode is available,
	giving an initial database in memory.
*/

class Database {
	private $connection;
	
	function __construct($testing = false) {
		if ($testing) {
			$this->connection = new PDO('sqlite:test.db');
		}
		else {
			$this->connection = new PDO('sqlite:database.db');
			// TODO replace by :
			// $this->connection = new PDO('mysql:host=localhost;dbname=base', "user", "password", array(PDO::ATTR_PERSISTENT => true));
		}
	}
	
	public function getConnection() {
		return $this->connection;
	}
	
	function clearDatabase() {
		$this->connection->exec('DROP TABLE IF EXISTS "property"');
		$this->connection->exec('DROP TABLE IF EXISTS "news"');
	}
	
	function initializeDatabase() {
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
		
		$this->connection->exec('CREATE TABLE "image" (
			id       INTEGER(10),
			url      VARCHAR(256),
			title    VARCHAR(128),
			
			PRIMARY KEY (id)
		)');
		$statement = $this->connection->prepare('INSERT INTO "image" (id, url, title) VALUES (?, ?, ?)');
		$statement->execute(array('0', 'images/news/test_news.jpg', 'Random Test News Mitsudomoe'));
		$statement->execute(array('1', 'images/interface/logo/zero.png', 'Zéro ~fansub~'));
		
		$this->connection->exec('CREATE TABLE "news" (
			id       INTEGER(10),
			title    VARCHAR(128),
			text     TEXT,
			image_id INTEGER(10),
			
			PRIMARY KEY (id)
		)');
		$statement = $this->connection->prepare('INSERT INTO "news" (id, title, image_id, text) VALUES (?, ?, ?, ?)');
		$statement->execute(array(0, '[ fansub ] Mitsudomoe épisode 01', '0', '
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					Donec vitae porttitor arcu. Proin non condimentum lorem.
					Aenean in ante a ligula pulvinar pellentesque in vel
					ipsum. Nullam metus sapien, faucibus sit amet tincidunt
					nec, ultrices ut tellus. Quisque varius pharetra felis,
					eget pretium quam mattis a. Mauris at turpis vel arcu
					molestie vulputate ac sit amet lorem. In hac habitasse
					platea dictumst. Quisque pharetra neque id eros
					elementum facilisis. Nullam augue nulla, laoreet ut
					vulputate ac, auctor id enim. Vivamus varius eleifend
					lectus, a dignissim ante blandit eget. Donec congue,
					quam non pharetra faucibus, nunc nisi feugiat augue,
					nec sollicitudin quam lorem eget augue. In fringilla,
					felis ac pharetra convallis, eros mi pulvinar velit, ac
					congue quam turpis et dolor. In pellentesque tincidunt
					purus, eget laoreet orci semper in. Sed pulvinar justo
					nunc, sit amet eleifend tellus. Donec non elit tellus.
				</p>
				<p>
					Integer in arcu massa, id venenatis mauris. Nulla non
					felis dui. Integer nec ipsum nisi, sed commodo purus.
					Pellentesque habitant morbi tristique senectus et netus
					et malesuada fames ac turpis egestas. Donec in blandit
					diam. Suspendisse vel arcu purus, nec rhoncus lorem.
					Etiam ac consectetur lorem. Aliquam fringilla, velit sit
					amet ornare tempor, turpis lacus tristique orci, ut
					porta justo diam id sem. Etiam imperdiet nibh nec nibh
					eleifend ut accumsan leo dapibus. Etiam sem leo, egestas
					sed consequat vel, euismod quis metus. Ut gravida
					placerat metus sed tincidunt. Integer lacinia viverra
					dolor, non porta tortor aliquam a. Donec sodales justo
					eget magna sollicitudin blandit. Ut molestie, augue in
					pretium condimentum, orci erat facilisis tortor, nec
					auctor enim felis sed tellus. Vestibulum blandit massa
					eget mi tincidunt a aliquet dolor convallis. Nullam et
					magna vitae est imperdiet mattis. Ut semper urna tortor.
				</p>
		'));
		
		$this->connection->exec('CREATE TABLE "project" (
			id       INTEGER(10),
			title    VARCHAR(128),
			description     TEXT,
			image_id INTEGER(10),
			
			PRIMARY KEY (id)
		)');
		$statement = $this->connection->prepare('INSERT INTO "project" (id, title, image_id, description) VALUES (?, ?, ?, ?)');
		$statement->execute(array(0, 'Mitsudomoe', '0', '
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					Donec vitae porttitor arcu. Proin non condimentum lorem.
					Aenean in ante a ligula pulvinar pellentesque in vel
					ipsum. Nullam metus sapien, faucibus sit amet tincidunt
					nec, ultrices ut tellus. Quisque varius pharetra felis,
					eget pretium quam mattis a. Mauris at turpis vel arcu
					molestie vulputate ac sit amet lorem. In hac habitasse
					platea dictumst. Quisque pharetra neque id eros
					elementum facilisis. Nullam augue nulla, laoreet ut
					vulputate ac, auctor id enim. Vivamus varius eleifend
					lectus, a dignissim ante blandit eget. Donec congue,
					quam non pharetra faucibus, nunc nisi feugiat augue,
					nec sollicitudin quam lorem eget augue. In fringilla,
					felis ac pharetra convallis, eros mi pulvinar velit, ac
					congue quam turpis et dolor. In pellentesque tincidunt
					purus, eget laoreet orci semper in. Sed pulvinar justo
					nunc, sit amet eleifend tellus. Donec non elit tellus.
				</p>
				<p>
					Integer in arcu massa, id venenatis mauris. Nulla non
					felis dui. Integer nec ipsum nisi, sed commodo purus.
					Pellentesque habitant morbi tristique senectus et netus
					et malesuada fames ac turpis egestas. Donec in blandit
					diam. Suspendisse vel arcu purus, nec rhoncus lorem.
					Etiam ac consectetur lorem. Aliquam fringilla, velit sit
					amet ornare tempor, turpis lacus tristique orci, ut
					porta justo diam id sem. Etiam imperdiet nibh nec nibh
					eleifend ut accumsan leo dapibus. Etiam sem leo, egestas
					sed consequat vel, euismod quis metus. Ut gravida
					placerat metus sed tincidunt. Integer lacinia viverra
					dolor, non porta tortor aliquam a. Donec sodales justo
					eget magna sollicitudin blandit. Ut molestie, augue in
					pretium condimentum, orci erat facilisis tortor, nec
					auctor enim felis sed tellus. Vestibulum blandit massa
					eget mi tincidunt a aliquet dolor convallis. Nullam et
					magna vitae est imperdiet mattis. Ut semper urna tortor.
				</p>
		'));
		
		$this->connection->commit();
	}
}
?>
