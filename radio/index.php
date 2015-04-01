<?php
  //
  // Made by	db0
  // Contact	db0company@gmail.com
  // Website	http://db0.fr/
  //

// You can change informations below :

$page_title = "Radio . db0";


//                 //
//   DON'T TOUCH   //
//                 //

session_start();

if (isset($_GET['play']))
   $_SESSION['play'] = $_GET['play'];

header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php
	echo $page_title;
?></title>
  <link rel="stylesheet" href="style.css" type="text/css" media="screen" title="Normal" />
  <link rel="shortcut icon" href="fav.ico" />
  <script type="text/javascript" language="Javascript">
    function show(nom_champ)
     {
       if(document.getElementById)
	{
	 tabler = document.getElementById(nom_champ);
	 if(tabler.style.display=="none")
	  {
	   tabler.style.display="";
	  }
	 else
	  {
	   tabler.style.display="none";
	  }
	}
     }
  </script>
</head>
<body>
 <div>
<?php
$chansons = array();
$totalchanson = 0;

function	getchansons($dir)
{
  global $chansons, $totalchanson;

  $handle = opendir($dir);
  while ($filename = readdir($handle))
    {
      if ($filename[0] != '.')
	{
	  if (!is_dir($dir.$filename))
	    {
	      if (substr($filename, -4) == '.mp3')
		{
		  $chansons[] = substr($dir, 4).$filename;
		}
	    }
	  else
	    getchansons($dir.$filename.'/');
	}
    }
}

if (isset($_SESSION['play']))
  {
      if (is_file($_SESSION['play']))
	  {
	      $tab = explode(".", $_SESSION['play']);
	      $chansons[] = substr($tab[0], 4);
	  }
      else
	  getchansons($_SESSION['play']);

      $totalchanson = sizeof($chansons);

      sort($chansons);
      reset($chansons);
?>
<audio controls id="player" autoplay>
<source src="mp3/<?php echo $chansons[0] ?>" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
<a href="."><img src="img/stop.gif" alt="stop player" /></a><br>
<span id="currentsong"><?php echo $chansons[0] ?></span>
<br />
<br />
<?php
    }
?>
<?php
 function ShowFileExtension($filepath)
    {
	preg_match('/[^?]*/', $filepath, $matches);
	$string = $matches[0];

	$pattern = preg_split('/\./', $string, -1, PREG_SPLIT_OFFSET_CAPTURE);

	if(count($pattern) > 1)
	{
	    $filenamepart = $pattern[count($pattern)-1][0];
	    preg_match('/[^?]*/', $filenamepart, $matches);
	    return ($matches[0]);
	}
	return ('');
    }
?>
<a href="#" onClick="show('mp3/');return(false)" id="plus">All</a>
<?php
echo '<a href="?play=mp3/">';
echo '<img src="img/play.png" alt="play" />';
echo '</a>'."\n";
	function echodir($dir, $level)
	{
		$handle = opendir($dir);
		echo '<div id="'.$dir.'" ';
		if (strncmp($dir, $_GET['play'], strlen($dir)) != 0)
		  echo 'style="display:none;"';
		echo '>'."\n";
		while ($filename = readdir($handle))
		  $songs[] = $filename;
		sort($songs);
		foreach ($songs as $filename)
		{
		  if ($filename[0] != '.')
		    {
			if (is_dir($dir.$filename) || ShowFileExtension($filename) == 'mp3')
			   {
				for ($i = 0 ; $i < $level ; ++$i)
				    echo '-- ';
				echo "\n";
				if (is_dir($dir.$filename))
				  {
					echo '<a href="#" onClick="show(\''.$dir.$filename.'/'.'\');return(false)" id="plus">'."\n";
					echo ' <img src="img/folder.png" alt="folder" /> ';
					echo $filename;
					echo '</a> '."\n";
					echo '<a href="?play='.$dir.$filename.'/'.'">'."\n";
					echo ' <img src="img/play.png" alt="play" />';
					echo '</a>';
					echo '<br />'."\n";
					echodir($dir.$filename.'/', $level+1);
				  }
				else
				  {
					echo '<img src="img/music.png" alt="folder" /> '."\n";
					echo ' '.substr($filename, 0, -4);
					echo ' <a href="?play='.$dir.$filename.'">'."\n";
					echo '  <img src="img/play.png" alt="play" />'."\n";
					echo '</a>'."\n";
					echo ' <a href="'.$dir.$filename.'" target="_blank">'."\n";
					echo ' <img src="img/download.png" alt="download" />'."\n";
					echo '</a>'.'<br />'."\n";
				  }
			  }
		    }
		}
		echo '</div>'."\n";
	}
	echodir('mp3/', 1);
?>
 </div>
<script>
     var current = 0;
var songs = [
	  <?php foreach ($chansons as $chanson) {
		echo '\'', $chanson. '\',
	  ';
	    } ?>
	  ];

var audio = document.getElementById('player');
var currentsong = document.getElementById('currentsong');
audio.addEventListener('ended',function() {
	current++;
	if (current >= songs.length) {
	    current = 0;
	}
	currentsong.textContent = songs[current];
	audio.src = 'mp3/' + songs[current];
	audio.pause();
	audio.load();
	audio.play();
    });
</script>
</body>
</html>
