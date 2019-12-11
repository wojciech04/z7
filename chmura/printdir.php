<?php
session_start();
function printDir($dirPath, $withBack) {
			//panel ładowania plików, przekierowanie do skryptu addFile.php
	print "
		<div class='container'>
					<div>
								<b>Załaduj plik</b>
					<form action='addFile.php' method='POST' ENCTYPE='multipart/form-data'>
						<div>
							<input type='file' name='plik'/>
						</div>
						<br/>
						 <button type='submit'>Wyślij plik</button>
					</form>
				</div>";

				if(isset($_SESSION['size_error']))
					{
						//informacja o tym, że rozmiar pliku jest zbyt duży
						echo $_SESSION['size_error'];
						unset($_SESSION['size_error']);
					}

		if(!$withBack){
			//formularz tworzenia folderu, klikniece na Dodaj katalog powoduje wywołanie jQuery addFolder
		print "
			<div>
			<br>
			<br>
						<b>Dodaj katalog</b>
							<div>
								<input type='text' id='createFolder'name='createFolder' placeholder='Podaj nazwę folderu'>
							 </div>
							 <br>
								<button onclick='addFolder();'>Dodaj katalog</button>
								";}

		print "</div>
		<br>";
		//ustaw kolor brazowy dla katalogu
echo"<span style='background-color:#00ff00'>";
//podaj informację użytkownikowi w jakim katalogu się teraz znajduje
		print "	Katalog główny  ";  echo "/".$_COOKIE["ChmuraLogUsr"];
echo"</span>";

	//tabela z utworzonymi plikami
	print "<table>";
		print "
			<thead>
				<tr>
				  <th scope='col'>FILE</th>
				  <th scope='col'>Download</th>
				</tr>
			</thead>";

  $files = preg_grep('~\.*$~', scandir($dirPath));
	print "<tbody>";
	foreach ($files as &$value) {
		if($value !== '.' && $value !== '..'){
			print "<tr>";
			print "<td>";
				//sprawdz, czy stringu value jest znak '.' jesli tak to oznacza to, ze to plik
				if (strpos($value, '.') !== false) {
					//dodaj styl dla pliku
					print "<span class='plik' style='background-color:#87CEFA' ';'>{$value}</span>";
					print "</td>";
					//dodaj akcję do przycisu Pobierz, będzie to wywołanie metody downloadFile, którego argumentem jest dana nazwa pliku
					print "<td><span onclick='downloadFile(\"{$value}\")'><button name='button_download' id='button_download'>Pobierz</button>
					</span></td>";
				}
				//w innym wypadku jest to katalog
				else {
					print "<span class='folder' style='background-color:#DAA520' onclick='goToDir(this);'><button style='background-color:#DAA520'>{$value}</button></span>";
					print "</td>";
					print "<td></td>";
				}
			print "</tr>";
		}
	}
echo"	</div>";
//akcja gdy jesteśmy w podfolderze
	if($withBack){
		print "<tr>";
		print "<td>";
		print "<span style='background-color:red' onclick='goBack();'>
		<button name='Cofnij'> Cofnij </button>
		</span>";
		print "</td>";
		print "<td></td>";
		print "</tr>";
	}
	print "</tbody>";
	print "</table>";
}
$currentPath = '';
$userDir = '';
//jesli cookie nie ma ustawionej nazwy usera
if(!isset($_COOKIE["ChmuraLogUsr"])){
	exit();
echo "<script>
	window.location.replace('http://wojciechowskid.pl/pages/lab7.php');
	</script>";
  //jeśli użytkownik ma ustawione cookie i jest to jego nazwa
		} else {
			//ustaw userDir na ściezkę do folderu glównego
					$userDir = '/public_html/pages/lab7/chmura/directories/'.$_COOKIE["ChmuraLogUsr"];
					if(isset($_COOKIE["CurrentDirPath"])) {
					$currentPath = $_COOKIE["CurrentDirPath"];
					}else {
		$currentPath = $userDir;
	}
}
//doklej adred do podkatalogu
if(isset($_POST["dir"])){
	$currentPath = $currentPath.'/'.$_POST["dir"];
}
//przy akcji powrotu ustaw z powrotem ścieżkę cuurentPath na zmienna userDir ( katalog główny)
if(isset($_POST["back"])){
	$currentPath = $userDir;
}
$withBack = false;
if($currentPath != $userDir)
{
	$withBack = true;
}
//wywołaj ustawienie cookie dla $currentPath i ustal czas na 10 minut
setcookie("CurrentDirPath", $currentPath , time()+10*60);
//wyświetl foldery dla aktualnej ścieżki
printDir($currentPath, $withBack);
?>
