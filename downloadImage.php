<?php
function findFile($fileName, $dir) {
	$expected = strtolower($dir.'/'.$fileName);
	foreach(glob($dir . '/*') as $file) {
		if (strtolower($file) == $expected) {
			return $file;
		}
		else if (is_dir($file)) {
			$file = findFile($fileName, $file);
			if ($file != null) {
				return $file;
			}
		}
	}
	return null;
}

function __autoload($className) {
	$file = findFile($className.'.php', 'class');
	if ($file != null) {
		$chunks = explode("/", $file);
		include $file;
	} else {
		throw new Exception($className." not found");
	}
}

$id = intval(Url::getCurrentUrl()->getQueryVar('id'));
$name = urldecode(Url::getCurrentUrl()->getQueryVar('name'));

$image = Image::getImage($id);
$url = $image->getURL()->toString();

$finfo = finfo_open(FILEINFO_MIME);
$mime = finfo_file($finfo, $url);
finfo_close($finfo);


/*
echo "Send the file '$url' as $name<br/>";
echo 'Content-Description: File Transfer<br/>';
echo 'Content-Type: '.$mime.'<br/>';
echo 'Content-Disposition: attachment; filename='.$name.'<br/>';
echo 'Content-Transfer-Encoding: binary<br/>';
echo 'Expires: 0<br/>';
echo 'Cache-Control: must-revalidate, post-check=0, pre-check=0<br/>';
echo 'Pragma: public<br/>';
echo 'Content-Length: ' . filesize($url).'<br/>';
exit;
*/

header('Content-Description: File Transfer');
header('Content-Type: '.$mime);
header('Content-Disposition: attachment; filename='.$name);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($url));
ob_clean();
flush();
readfile($url);
exit;
?>