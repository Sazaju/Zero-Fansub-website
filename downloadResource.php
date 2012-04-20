<?php
require_once("baseImport.php");

$resource = null;
if (Url::getCurrentUrl()->hasQueryVar('id')) {
	$id = intval(Url::getCurrentUrl()->getQueryVar('id'));
	$resource = Resource::getResource($id);
} else if (Url::getCurrentUrl()->hasQueryVar('key')) {
	$resource = $_SESSION[Url::getCurrentUrl()->getQueryVar('key')];
} else {
	throw new Exception("Incomplete URL");
}
$name = urldecode(Url::getCurrentUrl()->getQueryVar('name'));

if (!$resource->exists()) {
	$resource->generateTempFile();
}

$url = $resource->getURL()->toString();

$finfo = finfo_open(FILEINFO_MIME);
$mime = finfo_file($finfo, $url);
$mime = explode(";", $mime);
$mime = $mime[0];
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
// force download:
//header('Content-Disposition: attachment; filename='.$name);
header('Content-Disposition: filename='.$name);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($url));
ob_clean();
flush();
readfile($url);
if ($resource->hasTempFile()) {
	$resource->deleteFile();
}
exit;
?>