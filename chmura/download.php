<?php
$file_path;
$userDir;
$currentPath;

if(isset($_COOKIE["ChmuraLogUsr"])){
		$userDir = '/pages/lab7/chmura/directories/'.$_COOKIE["ChmuraLogUsr"];


} else {
	$userDir = 'public_html/pages/lab7/chmura/directories/'.$_COOKIE["ChmuraLogUsr"];

	if(isset($_COOKIE["CurrentDirPath"])) {
		$currentPath = $_COOKIE["CurrentDirPath"];

	} else {

		$currentPath = $userDir;

	}
}

$filename;
if(isset($_GET["fileName"])){
	$filename = $_GET["fileName"];
	$file_path = $currentPath.'/'.$_GET["fileName"];
}
//echo $file_path;
header("Content-Type: application/octet-stream");
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"".$filename."\"");
readfile($file_path);
exit();
?>
