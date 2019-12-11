<?php
if(!isset($_COOKIE["ChmuraLogUsr"])){
		header('Location: http://wojciechowskid.pl/pages/lab7.php');
		exit();
}
if(isset($_POST["dirName"])){
	mkdir($_SERVER['DOCUMENT_ROOT'].'/pages/lab7/chmura/directories/'.$_COOKIE["ChmuraLogUsr"].'/'.$_POST["dirName"], 0777, true);
}
exit();
?>
