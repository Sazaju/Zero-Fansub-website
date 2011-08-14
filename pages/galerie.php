
    *
    * <tr>
    * <td colspan="3" id="borduretitre"><h1>Liste des MANGAS disponible</h1></td>
    * </tr>
    * <tr>
    * <td height="21" id="bordure"></td>
    * </tr>
    * <tr>
    * <td colspan="3" id="tableau" align="center">
    * <?php
     function filelist ($startdir="./", $searchSubdirs=1, $directoriesonly=0, $maxlevel="all", $level=1) {
    $ignoredDirectory[] = ".";
    $ignoredDirectory[] = "..";
    $ignoredDirectory[] = "_vti_pvt";
    $ignoredDirectory[] = "_vti_cnf";
    $ignoredDirectory[] = "_private";
    global $directorylist;
    if (is_dir($startdir)) {
    if ($dh = opendir($startdir)) {
    while (($file = readdir($dh)) !== false) {
     if (!(array_search($file,$ignoredDirectory) > -1)) {
    if (filetype($startdir . $file) == "dir") {
    $directorylist[$startdir . $file]['dir'] = 1;
    $directorylist[$startdir . $file]['name'] = $file;
    }}}
    closedir($dh);
    }}
    return($directorylist);
    }
    $files = filelist("imagess/",1,1); // nous demandons de scanner le repertoire images/ les valeurs qui suivent permetent de preciser si on veut compter les sous dossiers, enfin bref, on met tout a 1 ici
 {
    echo "<a href=?page=imagess/" . $list['name'] . "/index>" . $list['name'] ."</a><br>"; // on affiche la liste sous forme de lien
    }?>
    * </td>
    * </tr>