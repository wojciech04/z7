<?php
$file_path;
$userDir;
$currentPath;
//jeśli użytkownik został zalogowany i zmienna przechowuje nazwe użytkownika
if(isset($_COOKIE["ChmuraLogUsr"])){
	//do zmiennej userDir przypis ścieżkę do folderu uzytkownika
		$userDir = '/pages/lab7/chmura/directories/'.$_COOKIE["ChmuraLogUsr"];

} else {
	$userDir = 'public_html/pages/lab7/chmura/directories/'.$_COOKIE["ChmuraLogUsr"];

	if(isset($_COOKIE["CurrentDirPath"])) {
		//przypisz wartość cookie CurrentDirPath do zmiennej $currentPath
		$currentPath = $_COOKIE["CurrentDirPath"];

	} else {
		$currentPath = $userDir;
	}
}
$filename;

if(isset($_GET["fileName"])){
	//pobieramy nazwę pliku, który ma zostac pobrany (fileName=+item)
	$filename = $_GET["fileName"];
	//do aktualnej ścieżki doklej nazwę pliku do pobrania
	$file_path = $currentPath.'/'.$_GET["fileName"];
}

header("Content-Type: application/octet-stream");
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"".$filename."\"");
//pobierz plik
readfile($file_path);
exit();
?>
