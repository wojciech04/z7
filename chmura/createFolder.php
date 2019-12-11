<?php
if(!isset($_COOKIE["ChmuraLogUsr"])){
		header('Location: http://wojciechowskid.pl/pages/lab7.php');
		exit();
}
//jesli pole text field jest wypełnione to utworz folder
if(isset($_POST["dirName"])){
	//poleceniem mkdir tworzymy folder określony przez użytkownika i nadajemy uprawnienia read, write oraz execute
	mkdir($_SERVER['DOCUMENT_ROOT'].'/pages/lab7/chmura/directories/'.$_COOKIE["ChmuraLogUsr"].'/'.$_POST["dirName"], 0777, true);
}
exit();
?>
