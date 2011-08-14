# <?php
# # //////////////////////////////////////////////////////////////////////////////////////////////////////////////
# # /*galerie d'image par malokaff,
# # Il s'agit d'un mix de plusieurs source de phpcs que j'ai essayer de simplifier pour faire un systeme de galerie
# # simple : il suffit de metre les photos dans des sous dossiers du repertoire photo et le script se charge de
# # la création des miniatures et de la mise en page.
# #
# #vous avez besoin d'un repertoire photo qui contient les dossiers des photos,
# # un repertoire mini qui contiendra les miniatures généré par le script
# # *////////////////////////////////////////////////////////////////////////////////////////////////////////////
# /*
# **
# //Fonction compression des images
# **
# */
# function redimage($img_src,$img_dest,$dst_w,$dst_h,$alt,$title)
# {
# // Lit les dimensions de l'image
# $size = getimagesize($img_src);
# $src_w = $size[0]; $src_h = $size[1];
# $ext = strtolower(substr($img_src, -3));
# // $ext = strtolower(strstr($img_src, '.'));
#
# // Teste les dimensions tenant dans la zone
# $test_h = round(($dst_w / $src_w) * $src_h);
# $test_w = round(($dst_h / $src_h) * $src_w);
# // Si Height final non précisé (0)
# if(!$dst_h) $dst_h = $test_h;
# // Sinon si Width final non précisé (0)
# elseif(!$dst_w) $dst_w = $test_w;
# // Sinon teste quel redimensionnement tient dans la zone
# elseif($test_h>$dst_h) $dst_w = $test_w;
# else $dst_h = $test_h;
#
# // La vignette existe ?
# $test = (file_exists($img_dest));
# // L'original a été modifiée ?
# if($test)
# {
# $test = (filemtime($img_dest)>filemtime($img_src));
# }
# // Les dimensions de la vignette sont correctes ?
# if($test) {
# $size2 = getimagesize($img_dest);
# $test = ($size2[0]==$dst_w);
# $test = ($size2[1]==$dst_h);
# }
#
# // Créer la vignette ?
# if(!$test) {
# // Crée une image vierge aux bonnes dimensions
# $dst_im = imagecreatetruecolor($dst_w,$dst_h);
#
# // Copie dedans l'image initiale redimensionnée
# if ($ext == 'jpg' || $ext=='JPG')
# $src_im = imagecreatefromjpeg($img_src);
# else if ($ext == 'gif')
# $src_im = imagecreatefromgif($img_src);
# else if ($ext == 'png')
# $src_im = imagecreatefrompng($img_src);
# else{
# die ('Une erreur est survenue dans le format de l\'image. Veuillez contacter un administrateur');
# }
#
# imagecopyresized($dst_im,$src_im,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
# imagecopyresampled($dst_im,$src_im,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
#
# // Sauve la nouvelle image
# if ($ext == 'jpg' || $ext=='JPG')
# imagejpeg($dst_im,$img_dest);
# else if ($ext == 'gif')
# imagegif($dst_im,$img_dest);
# else
# imagepng($dst_im,$img_dest);
#
# chmod("$img_dest",0777);
#
# // Détruis les tampons
# imagedestroy($dst_im);
# imagedestroy($src_im);
# }
#
# // Affiche le descritif de la vignette, décommentez si vous voulez que la fonction renvoit cela à la suite de son exécution
# //return 'width="'.$dst_w.'" height="'.$dst_h.'" alt="'.$alt.'" title="'.$title.'" />';
# }
#
# //si pas d'action définie, j'affiche la page d'accueil de la galerie
# if (empty($_GET['action']))
# {$action = "accueil";}
# else { $action=$_GET['action']; }
#
#
#
# //listing des repertoires pour les afficher dans un select present sur toutes les pages
# $directoryListing = "Les photos";
# $noDir = "aucun répertoire"; //message d'erreur si aucun repertoire dans le dossier
#
# $dir="photo"; //repertoire où sont stockée les sous repertoires des photos
# $rep=opendir($dir);
# rewinddir($rep);
# ?>
# <center><form name="form1" method="post" action="index.php?page=galerie.php&action=affichephoto" class="texte">
# <select name="dossier" onchange="this.form.submit();">
# <option value=""></option>
# <?
# //$bAuMoinsUnRepertoire = false;
# while ($file = readdir($rep)){
# if($file != '..' && $file !='.' && $file !='' && $file !='Thumbs.db'){
# //if (is_dir($file)){
# $bAuMoinsUnRepertoire = true;
# ?>
# <option value="<? echo "$file"; ?>" <? if(isset($_POST['dossier']) && $_POST['dossier']=="$file") { echo "selected=\"selected\""; }
# if(isset($_GET['dossier']) && $_GET['dossier']=="$file") { echo "selected=\"selected\""; } ?>><? echo "$file"; ?></option>
# <?
# //}
# }
# }
# echo "</select></form></center>";
# if ($bAuMoinsUnRepertoire == false) {
# print("<tr><td nowrap class='texte'><div align='center'>- $noDir -</div></td>");
# print("</td></tr>");
# }
# //on ferme le repertoire et on libère la mémoire
# closedir($rep);
# clearstatcache();
#
# //affichage de la page d'accueil de la galerie si pas d'action définie
# if($action=="accueil")
# {
# echo '<p class="texte">Decouvrez nos photos, n\'hesiter pas a laisser des commentaires sur le forum! <br>
# Pour fonctionner cette galerie a besoin d\'un repertoire photos contenant les sous dossiers des photos et d\'un repertoire
# mini qui contiendra les sous dossier des miniatures généré par le script </p>';
# }
# /*
# **
# //affichage galerie
# **
# */
# function isImg ($file){if (eregi(".jpg$",$file)){return true;}} // Fonction de verification des fichiers jpeg
#
# //si action=affiche photo on affiche la page des miniatures de la galerie selectionnée
# if($action=="affichephoto")
# {
# if(isset($_GET['dossier']))
# {
# $dossier=$_GET['dossier'];
# }
# if(isset($_POST['dossier']))
# {
# $dossier=$_POST['dossier'];
# }
# $repImg = "photo/$dossier"; // Repertoire des images
# $handle = opendir("$repImg"); // On ouvre le repertoire des images
# while ($file = readdir($handle))
# {
# if ($file != "." && $file != ".." && isImg ($file))
# {
# //on crée le dossier de miniatures avec @ pour éviter message d'erreur si il n'existe pas!
# @mkdir("mini/$dossier");
# //chmod("mini/$dossier",0777);
# //on enregistre la miniatures dans le dossier mini, dans un sous repertoire portant le meme nom et avec le prefixe mini
# redimage("$repImg/$file","mini/$dossier/mini_$file",100,100,"test","test");
# $listImg[] = $file; // On place toutes les images du dossier dans le tableau $imgList
# sort($listImg);}} // On classe les fichiers dans l'orde alphabetique (c'est plus mieux ;D) )
# closedir($handle); // On ferme le repertoire des images
#
# // presentation de la page
# $lien = "index.php?page=galerie.php&action=affichephoto&dossier=$dossier&"; // Liens pour afficher votre page
# //on teste si un numero de la galerie a été envoyé par la barre d'adresse pour l'affichage sur plusieurs pages des miniatures
# if (empty($_GET['Galerie']))
# {$Galerie = 1;}
# else { $Galerie=$_GET['Galerie']; }
# $precGalerie = $Galerie-1; // Galerie precedente
# $suivGalerie = $Galerie+1; // Galerie suivante
#
# $nbImg = count($listImg); // Compte le nombre d'image
# $nbLigne = 4; // Nombre de ligne souhaité
# $nbCol = 4; // Nombre de colonne souhaité
# $nbImgParPg = $nbLigne*$nbCol; // Calcul du nombre d'image par page en fonction des parametres précédents
# $nbGalerie = $nbImg/$nbImgParPg; // Calcul du nombre de galerie
# $nbGalerie = ceil("$nbGalerie"); // Calcul du nombre de galerie, arrondi superieur du calcul
# $numImg = ($Galerie*$nbImgParPg)-$nbImgParPg; // Compteur pour le tableau $imgList
# //affichage de tableau contenant les miniatures
# echo '<table border="0" cellspacing="5" cellpadding="3" width="95%" align="center" class="texte">';
#
# $comptLigne = 0; // Mise a zero du compteur de lignes
# while ($comptLigne < $nbLigne)
# {
# echo '<tr>';
# $comtpImg = 0; // Mise a zero du compteur d'images
# while ($comtpImg < $nbCol && $numImg < $nbImg)
# {
# echo '<td align=center><a target=blank href="'.$repImg.'/'.$listImg[$numImg].'"><img src="mini/'.$dossier.'/mini_'.$listImg[$numImg].'" border="0" width="50" height="50"></a></td>';
# //changez la ligne ci-dessus pour la taille des miniatures
# $numImg++; // Incremantation du compteur de $imgList (each() et foreach() etait beaucoup moins pratique :D( )
# $comtpImg++; // Incremantation du compteur d'images
# }
# echo '</tr>';
# $comptLigne++; // Incremantation du compteur de lignes
# }
# //afichage de la barre de navigation
# echo '</table><table width="100%" border="0" class="texte"><tr><td colspan="$nbCol" align="center" width="100%">';
# for ($compt = 1; $compt <= $nbGalerie && $nbGalerie > 1; $compt++)
# {echo '| <a href="'.$lien.'Galerie='.$compt.'">'.$compt.'</a> ';}
# if ($nbGalerie > 1)
# {echo' | ';}
# echo '</td></tr><tr><td width="50%" align="left">';
# if ($Galerie > 1)
# {echo '<a href="'.$lien.'Galerie='.$precGalerie.'">Precedent</a> ';} // Lien "precedent"
# echo ' </td><td width="50%" align="right">';
# if ($Galerie < $nbGalerie)
# {echo '<a href="'.$lien.'Galerie='.$suivGalerie.'">Suivant</a>';} // Lien "suivant"
# echo '</td></tr></table></td></tr></table>';
# }
# ?> 