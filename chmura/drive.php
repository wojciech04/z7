<?php
if(!isset($_COOKIE["ChmuraLogUsr"])){
  header('http://wojciechowskid.pl/pages/lab7.php');
  exit();}
/*  echo "<script>
  window.location.replace('http://wojciechowskid.pl/pages/lab7.php');
  </script>";
*/
?>
<?php include('header.php'); ?>
<BODY>
	<div class="container1">
				<b>Zalogowany jako:
					<?php if(isset($_COOKIE["ChmuraLogUsr"])){
					echo $_COOKIE["ChmuraLogUsr"];
					} ?>
			</b>	<!--ostanie błędne logowanie wyświetlone na podstawie Cookie LastErrorLogin -->
				<span id="ostatnieBledneLogowanie" style="float:right;">
					<?php if(isset($_COOKIE["LastErrorLogin"])){
						print "<b style='color:red;'>Ostatnie nieudane logowanie: ".$_COOKIE["LastErrorLogin"]."</b>";
					} ?>
				</span>
								<!--Wylogowywanie ze strony -->
				<span id="logout" style="float:right;">
					<a href="http://wojciechowskid.pl/pages/lab7.php">Wyloguj</a>
				</span>
	</div>
			<div class="line"></div>
			<div class="lista" id="lista">
          <!-- zalacz skrypt printdir.php, który będzie odpowiedzialny za listowanie folderów -->
      	<?php include('printdir.php'); ?>
			</div>
      			<div class="line"></div>
      <br>
	<script>
	//wejdz do podfolderu
	function goToDir(item){
	var dir = $(item).text();
	$.post("printdir.php", {'dir': dir}, function(response){
       $('#lista').empty().append(response);
	});
	}
	//wróć z podfolderu do katalogu glównego
	function goBack(){
	$.post("printdir.php", {'back': 'true'}, function(response){
     $('#lista').empty().append(response);
	});
	}
  //funkcja powodująca pobranie pliku z dysku, bedzie wywolany w momencie kliknieca na przycisk Pobierz
	function downloadFile(item){
    //obiekt window.location pozwala uzyskać adres URL aktulanej strony
			window.location = 'download.php?fileName='+item;
  	}
    //funkcja umożliwiająca dodanie nowego katalogu
	function addFolder(){
    //#createFolder jest nazwa pola input type=text
	var dirName = $("#createFolder").val();
  //nazwa katalogu niemoże zawierać dużych liter oraz znakow specjalnych
	var pattern = /^[a-z0-9]+$/i;
  if(!dirName.match(pattern))
	return;
	console.log(dirName);
  //wywołanie skryptu tworzącego folder createFolder.php
  $.post("createFolder.php", {'dirName': dirName}, function(response){
		$("#lista").load("printdir.php");
	});
	}
	</script>
</BODY>
</html>
