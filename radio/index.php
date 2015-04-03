<?php
//
// Made by	db0
// Contact	db0company@gmail.com
// Website	http://db0.fr/
//

define('TEST_MODE_ACTIVATED', !isset($_GET['noTest']) && in_array($_SERVER["SERVER_NAME"], array(
				'127.0.0.1',
				'localhost',
				'to-do-list.me',
				'www.sazaju-hitokage.fr'
		), true));

/**********************************\
           ERROR MANAGING
\**********************************/

function error_handler($code, $message, $file, $line)
{
    if (0 == error_reporting())
    {
        return;
    }
    throw new ErrorException($message, 0, $code, $file, $line);
}

function exception_handler($exception) {
	if (!TEST_MODE_ACTIVATED) {
		// TODO
		$administrators = "sazaju@gmail.com";
		$subject = "ERROR";
		$message = "aze";//$exception->getMessage();
		$header = "From: noreply@zerofansub.net\r\n";
		$sent = false;//mail($administrators, $subject, $message, $header);
		echo "Une erreur est survenue, ".(
			$sent ? "les administrateurs en ont été notifiés"
				  : "contactez les administrateurs : ".$administrators
			).".";
	}
	else {
		echo "Une erreur est survenue : ".$exception;
		if (defined('TESTING_FEATURE')) {
			echo "<br/><br/>".TESTING_FEATURE;
		}
		phpinfo();
	}
}

set_error_handler("error_handler");
set_exception_handler('exception_handler');

if (TEST_MODE_ACTIVATED) {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', TRUE);
} else {
	// official server, don't display errors
}

/*****************************\
           CONSTANTS
\*****************************/

define('PAGE_TITLE', 'Radio . Zéro');
define('PLAY', 'play');
define('ROOT_SONG_DIR', 'mp3');
define('CLEAR_SESSION', 'clear_session');

/*****************************\
           CLASSES
\*****************************/

class Song {
	private $path = null;
	private $title = null;
	
	public function __construct($path, $title = NULL) {
		$this->path = $path;
		if ($title !== NULL) {
			$this->title = $title;
		} else {
			$title = preg_replace("#.*/([^/]+)\\.[^.]+#", "\\1", $path);
			$title = preg_replace("#_+#", " ", $title);
			$this->title = $title;
		}
	}
	
	public function getPath() {
		return $this->path;
	}
	
	public function getTitle() {
		return $this->title;
	}
}

class SongDir {
	private $path = null;
	private $songs = null;
	private $subdirs = null;
	
	public function __construct($dirPath) {
		if (!is_dir($dirPath)) {
			throw new Exception("$dirPath is not a directory");
		} else {
			$this->path = $dirPath;
		}
		
		if (substr($dirPath, -1) == '/') {
			// already the good format
		} else {
			$dirPath = $dirPath.'/';
		}
		
		$this->songs = array();
		$this->subdirs = array();
		$handle = opendir($dirPath);
		while (($filename = readdir($handle)) !== FALSE) {
			$filePath = $dirPath.$filename;
			
			if (in_array($filename, array(".", ".."))) {
				// system directories, ignore them
			} else if (is_dir($filePath)) {
				$this->subdirs[] = new SongDir($filePath);
			} else if (substr($filename, -4) == '.mp3') {
				$this->songs[] = new Song($filePath);
			} else {
				// not a song file
			}
		}
	}
	
	public function getSongs() {
		return $this->songs;
	}
	
	public function getAllSongs() {
		$songs = array();
		foreach($this->subdirs as $subdir) {
			$songs = array_merge($songs, $subdir->getAllSongs());
		}
		$songs = array_merge($songs, $this->songs);
		return $songs;
	}
	
	public function getSubdirs() {
		return $this->subdirs;
	}
	
	public function getPath() {
		return $this->path;
	}
}

/*****************************\
           FUNCTIONS
\*****************************/

function showFileExtension($filepath) {
	preg_match('/[^?]*/', $filepath, $matches);
	$string = $matches[0];

	$pattern = preg_split('/\./', $string, -1, PREG_SPLIT_OFFSET_CAPTURE);

	if(count($pattern) > 1) {
		$filenamepart = $pattern[count($pattern)-1][0];
		preg_match('/[^?]*/', $filenamepart, $matches);
		return ($matches[0]);
	}
	return ('');
}

function generateId(SongDir $dir) {
	return preg_replace("#[^a-zA-Z0-9]#", "_", $dir->getPath());
}

function displayDir(SongDir $dir, $displayedDir, $level = 1) {
	echo '<div id="'.generateId($dir).'" ';
	if ($level != 1 && ($displayedDir === null || strncmp($dir->getPath(), $displayedDir->getPath(), strlen($dir->getPath())) != 0)) {
		echo 'style="display:none;"';
	}
	echo '>';
	
	$subdirs = $dir->getSubdirs();
	foreach ($subdirs as $subdir) {
		for ($i = 0 ; $i < $level ; ++$i) {
			echo '-- ';
		}
		echo "\n";
		
		echo '<a href="#" onClick="show(\''.generateId($subdir).'\');return(false)" id="plus">'."\n";
		echo ' <img src="img/folder.png" alt="folder" /> ';
		echo basename($subdir->getPath());
		echo '</a> '."\n";
		echo '<a href="?play='.urlencode($subdir->getPath()).'/'.'">'."\n";
		echo ' <img src="img/play.png" alt="play" />';
		echo '</a>';
		echo '<br />'."\n";
		displayDir($subdir, $displayedDir, $level+1);
	}
	
	$songs = $dir->getSongs();
	foreach ($songs as $song) {
		for ($i = 0 ; $i < $level ; ++$i) {
			echo '-- ';
		}
		echo "\n";
		
		echo '<img src="img/music.png" alt="folder" /> '."\n";
		echo ' '.$song->getTitle();
		echo ' <a href="?play='.urlencode($song->getPath()).'">'."\n";
		echo '  <img src="img/play.png" alt="play" />'."\n";
		echo '</a>'."\n";
		echo ' <a href="'.$song->getPath().'" target="_blank">'."\n";
		echo ' <img src="img/download.png" alt="download" />'."\n";
		echo '</a>'.'<br />'."\n";
	}
	
	echo '</div>';
}

function printAlert($message) {
	?>
	<script type="text/javascript" language="Javascript">
		<?php
			echo "alert(\"$message\");";
		?>
	</script>
	<?php
}

/*****************************\
            INIT
\*****************************/

session_start();

if (TEST_MODE_ACTIVATED) {
	if (isset($_GET[CLEAR_SESSION])) {
		$_SESSION = array();
	} else {
		// no clear requested
	}
} else {
	// official server, don't execute testing commands
}

if (isset($_GET[PLAY])) {
	$play = $_GET[PLAY]; // don't use urldecode, $_GET items are already decoded
	if (strncmp($play, ROOT_SONG_DIR, strlen(ROOT_SONG_DIR)) == 0 && file_exists($play)) {
		$_SESSION[PLAY] = $play;
	} else {
		throw new Exception("Requête invalide : ".$play);
	}
} else {
	// nothing requested to play
}

/*****************************\
          INTERFACE
\*****************************/

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php
			echo PAGE_TITLE;
		?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="Normal" />
		<link rel="shortcut icon" href="fav.ico" />
		<script type="text/javascript" language="Javascript">
			function show(nom_champ) {
				if(document.getElementById) {
					tabler = document.getElementById(nom_champ);
					if(tabler.style.display=="none") {
						tabler.style.display="";
					} else {
						tabler.style.display="none";
					}
				}
			}
		</script>
	</head>
	<body>
		<?php
			/*****************************\
					   TESTING
			\*****************************/
			if (TEST_MODE_ACTIVATED) {
				?>
					<div id='test'>
						Test: 
						<a href="?<?php echo CLEAR_SESSION; ?>">Clear</a>
					</div>
				<?php
			} else {
				// official server, don't display testing commands
			}
		?>
		<!-- 
		*******************************
		           PLAYER
		*******************************
		-->
		<?php
			if (isset($_SESSION[PLAY])) {
				$play = $_SESSION[PLAY];
				
				if (is_file($play)) {
					$songs = array(new Song($play));
				} else if (is_dir($play)) {
					$dir = new SongDir($play);
					$songs = $dir->getAllSongs();
				} else if (!file_exists($play)) {
					printAlert("Impossible de trouver ".$play);
					$songs = array();
				} else {
					throw new Exception("Impossible de lire $play");
				}
				
				if (empty($songs)) {
					// no songs to play
				} else {
					//sort($songs);
					$song = $songs[0];
					//reset($songs);
					?>
						<audio controls id="player" autoplay>
							<source src="<?php echo $song->getPath() ?>" type="audio/mpeg">
							Your browser does not support the audio element.
						</audio>
						<a href="."><img src="img/stop.gif" alt="stop player" /></a><br/>
						<span id="title"><?php echo $song->getTitle() ?></span><br/>
						<br/>
						
						<script>
							var current = 0;
							var paths = [
								<?php
									foreach ($songs as $song) {
										echo json_encode($song->getPath()).",\n";
									}
								?>
							];
							var titles = [
								<?php
									foreach ($songs as $song) {
										echo json_encode($song->getTitle()).",\n";
									}
								?>
							];

							var player = document.getElementById('player');
							var currentTitle = document.getElementById('title');
							player.addEventListener('ended', function() {
								current++;
								if (current >= paths.length) {
									current = 0;
								}
								currentTitle.textContent = titles[current];
								player.src = paths[current];
								player.pause();
								player.load();
								player.play();
								}
							);
						</script>
					<?php
				}
			} else {
				// nothing to play, don't display the player
			}
			
		?>

		<!-- 
		*******************************
		           SONGS
		*******************************
		-->
		<?php
			$rootDir = new SongDir(ROOT_SONG_DIR);
		?>
		<a href="#" onClick="show('<?php echo generateId($rootDir); ?>');return(false)" id="plus">All</a>
		<a href="?play=<?php echo urlencode(ROOT_SONG_DIR); ?>"><img src="img/play.png" alt="play" /></a>
		<?php
			$displayedDir = null;
			if (!isset($_SESSION[PLAY])) {
				$displayedDir = null;
			} else if (is_file($_SESSION[PLAY])) {
				$song = new Song($_SESSION[PLAY]);
				$displayedDir = new Songdir(dirname($song->getPath()));
			} else {
				$displayedDir = new SongDir($_SESSION[PLAY]);
			}
			displayDir($rootDir, $displayedDir);
		?>
	</body>
</html>
