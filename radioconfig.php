<?
////****************************************/////

//Changez les couleurs de la radio ici - Change colors here
$boutonOFF="f079d6";
$boutonON="f11c69";
$couleurbarre="f079d6";
$couleurposition="cf0c52";
$couleurtexte="cf0c52";
$couleurtitre="cf0c52";
$couleurfondtitre = "cf0c52";
$couleurvolume="f3397c";
$couleurfond="ffffff";

//Autoplay : 0=NO / 1=YES
$autoplay = 0;
////****************************************/////






// NE PAS TOUCHER EN DESSOUS DE CETTE LIGNE  - DON'T TOUCH ANYTHING HERE ///////////////////

$handle=opendir('./mp3');
$totalchanson = 0;
$chansons = array();
while (false!==($filename = readdir($handle))){
	if((!is_dir($filename)) && ($filename != '.') && ($filename != '..')){
		$tab=explode(".",$filename);
		$titre=$tab[0];
		array_push($chansons,$titre);
		$totalchanson++;
	}
}
sort($chansons);
reset($chansons);
for($i=0;$i<=$totalchanson - 1;$i++){
	echo "&chanson" . ($i+1) . "=" . $chansons[$i];
}
echo "&nombrefond=" . $nombrefond . "&boutonOFF=" . $boutonOFF . "&boutonON=" . $boutonON . "&couleurbarre=" . $couleurbarre . "&couleurposition=" . $couleurposition . "&couleurtexte=" . $couleurtexte . "&couleurtitre=" . $couleurtitre . "&couleurfondtitre=" . $couleurfondtitre . "&couleurvolume=" . $couleurvolume . "&couleurfond=" . $couleurfond ."&totalchanson=" . $totalchanson . "&autoplay=" . $autoplay;


//© zanorg.com
?>