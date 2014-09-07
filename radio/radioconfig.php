<?
  //
  // Made by	db0
  // Contact	db0company@gmail.com
  // Website	http://db0.fr/
  //
 // © zanorg.com - kek

// You can change informations below :

$boutonOFF = "935836";
$boutonON = "AF836A";
$couleurbarre = "ffffff";
$couleurtexte = "ffffff";
$listefond = "AF836A";
$showbg = 1;
$autoplay = 1;
$play_random = 0;
$vol = 75;
$showliste = 1;

$fonds = array("img/fondradio.jpg");

//                 //
//   DON'T TOUCH   //
//                 //

session_start();

$nombrefonds = count($fonds);
$chansons = array();
$totalchanson = 0;

function	echodir($dir)
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
                  $tab=explode(".", $filename);
	      	  $chansons[] = substr($dir, 4).$tab[0];
		}
	    }
	  else
	    echodir($dir.$filename.'/');
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
      echodir($_SESSION['play']);
  }

$totalchanson = sizeof($chansons);

sort($chansons);
reset($chansons);
for($i=0 ; $i <= $totalchanson - 1 ; $i++)
{
  echo "&chanson" . ($i+1) . "=" . $chansons[$i];
}

echo "&nombrefonds=" . $nombrefonds;
for($i = 0;$i<= $nombrefonds-1;$i++){
  echo "&fond" . ($i+1) . "=" . $fonds[$i];
}
echo "&boutonOFF=" . $boutonOFF . "&boutonON=" . $boutonON . "&couleurbarre=" . $couleurbarre . "&couleurtexte=" . $couleurtexte . "&couleurtitre=" . $couleurtitre . "&couleuroptions=" . $couleuroptions . "&listefond=" . $listefond . "&listeselec=" . $listeselec . "&totalchanson=" . $totalchanson . "&autoplay=" . $autoplay . "&showbg=" . $showbg . "&showliste=" . $showliste . "&play_random=" . $play_random;

unset($_SESSION['play']);

?>
