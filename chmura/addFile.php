<?php
session_start();
$currentPath = '';
$userDir = '';
if(!isset($_COOKIE["ChmuraLogUsr"])){
	echo "<script>
	window.location.replace('http://wojciechowskid.pl/pages/lab7/chmura/drive.php');
	</script>";
		exit();

} else {
	//katalog użytkonika uzyskujemy poprzez doklejenie do statycznej ścieżki nazwy uzytkownika przechowywanej za pomocą ciasteczek
	$userDir = '/pages/lab7/chmura/directories/'.$_COOKIE["ChmuraLogUsr"];
	if(isset($_COOKIE["CurrentDirPath"])) {
		//jeśli cookie jest juz ustawione to zmiena $currentPath trzyma jego zawartość
		$currentPath = $_COOKIE["CurrentDirPath"];
		//jeśli COOKIE nie zostało jeszcze ustawione to ustaw zmienna $currentPath na zmienną $userDir
	} else {
		$currentPath = $userDir;
	}
}
//ustal maksymalny rozmiar pliku, który może być przesłany
$max_rozmiar = 1000;
//jeśli plik zostal wczytany
if (is_uploaded_file($_FILES['plik']['tmp_name'])) {

	if($_FILES['plik']['size'] > $max_rozmiar ){
		$_SESSION['size_error']='<span style="color:red">Plik, który chcesz dodać ma więcej niż 1GB!</span>';
	}
	else{
		//zapisanie pliku do odpowiedniego folderu
move_uploaded_file($_FILES['plik']['tmp_name'],$currentPath.'/'.$_FILES['plik']['name']);
}
}
else {echo 'Błąd przy przesyłaniu danych!';}
echo "<script>
window.location.replace('http://wojciechowskid.pl/pages/lab7/chmura/drive.php');
</script>";
exit();
?>
