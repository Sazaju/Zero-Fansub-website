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
else
  $_SESSION['play'] = 'mp3/';

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
if (isset($_SESSION['play']))
  {
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="280" height="320">
  <param name="movie" value="radiozanorg.swf" />
  <param name="quality" value="high" />
  <param name="menu" value="false">
  <embed src="radiozanorg.swf" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="280" height="320" menu="false"></embed>
</object>
<a href="."><img src="img/stop.gif" alt="stop player" /></a>
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
		$play = isset($_GET['play']) ? $_GET['play'] : "";
		if ($dir != 'mp3/' && strncmp($dir, $play, strlen($dir)) != 0)
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
</body>
</html>
