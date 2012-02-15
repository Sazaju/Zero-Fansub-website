<?php
define("DM_SORT_NAME", "0");
define("DM_SORT_TYPE", "1");
define("DM_SORT_SIZE", "2");

class DirectoryManager {
    /*********************************************************************************\
    Retourne un tableau listant le contenu du dossier, chaque élément possède les
    informations suivantes :
        - name      : nom de l'élément
        - type      : 'file' pour les fichiers, 'directory' pour les dossiers,
                      'unknown' pour le reste
        - size      : taille en octets
        - access    : droits d'accès (rwx en octal (0-7))
        - content   : contenu du dossier (uniquement les dossiers et si $recursive = true)

    L'argument $sorting est un tableau (clé => valeur) décrivant les tris à appliquer.
	Chaque clé correspond a une des constantes suivantes :
		- DM_SORT_NAME	: tri par nom
		- DM_SORT_TYPE	: tri par type
		- DM_SORT_SIZE	: tri par taille
	Les valeurs associées à chaque clé décrivent le sens de tri est doivent valoir l'une
	de ces constantes :
		- SORT_ASC	: tri croissant
		- SORT_DESC	: tri décroissant
	Il est possible de demander plusieurs tris (jusqu'à 3). L'ordre des tris correspond
	à celui fournit dans le tableau.
    
    \*********************************************************************************/
    public static function getContent($path, $recursive = false, $sorting = array(), $ignore = array( '.', '..' )) {
        $directory = @opendir($path);
        if ( $directory === false ) {
            throw new ErrorException( "Impossible d'ouvrir le dossier '$path'.", E_USER_ERROR );
        }
    
		// safe formating
		$lastIndex = strlen($path) - 1;
        if (in_array($path[$lastIndex], array('/', '\\'))) {
            $path[$lastIndex] = '\0';
        }

		// browsing of the directory
        $list = array();
        while($file = readdir($directory)) {
            if (!in_array($file, $ignore)) {
                $element = array();
                $file_path = $path.'/'.$file;
    
                $element['name'] = $file;
    
                if (is_file($file_path)) {
                    $element['type'] = 'file';
                }
                elseif (is_dir($file_path)) {
                    $element['type'] = 'directory';
                    if ($recursive) {
						$element['content'] = DirectoryManager::getContent($file_path, $recursive, $sorting, $ignore);
					}
                }
                else {
                    $element['type'] = 'unknown';
                }
    
                $element['size'] = filesize($file_path);
    
                $element['access'] = 0;
                $element['access'] += (is_readable( $file_path ) ? 4 : 0);
                $element['access'] += (is_writable( $file_path ) ? 2 : 0);
                $element['access'] += (is_executable( $file_path ) ? 1 : 0);
    
                $list[] = $element;
            }
        }
        closedir($directory);
    
        // sorting
        if (!empty($sorting)) {
			// data formating
            $sort_order = array();
            $last_sort = NULL;
            foreach($sorting as $key => $direction) {
				switch($key) {
					case DM_SORT_NAME:
						$last_sort = 'name';
						break;
					case DM_SORT_TYPE:
						$last_sort = 'type';
						break;
					case DM_SORT_SIZE:
						$last_sort = 'size';
						break;
					default:
						throw new ErrorException("Bad formating of the sorting type: ".$key, E_USER_ERROR);
				}
				switch($direction) {
					case SORT_ASC:
					case SORT_DESC:
						$sort_order[$last_sort] = $direction;
						break;
					default:
						throw new ErrorException("Bad formating of the sorting direction: ".$direction, E_USER_ERROR);
				}
            }
			
			// sorting phase
            if (!empty($sort_order)) {
                $sort = array();
                $sort_direction = array();
                $i = 0;
                foreach($sort_order as $key => $direction) {
                    $sort_direction[$i] = $sort_order[$key];
    
                    foreach ($list as $num => $row) {
                        $sort[$i][$num] = strtolower($row[$key]);
                    }
                    ++ $i;
                }
    
                switch( $i ) {
                    case 1 :
                        array_multisort( $sort[0], $sort_direction[0], $list );
                        break;
                    case 2 :
                        array_multisort( $sort[0], $sort_direction[0], $sort[1], $sort_direction[1], $list );
                        break;
                    case 3 :
                        array_multisort( $sort[0], $sort_direction[0], $sort[1], $sort_direction[1], $sort[2], $sort_direction[2], $list );
                        break;
                    default :
                }
            }
        }
		
		// sorted list
        return $list;
    }
}
?>
