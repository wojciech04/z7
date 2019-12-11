<?php
$dbhost="localhost";
$dbuser="*****";
$dbpassword="*****";
$dbname="*****";

$polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

if (!$polaczenie) {
echo "Błąd połączenia z MySQL." . PHP_EOL;
echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
echo "Error: " . mysqli_connect_error() . PHP_EOL;
exit;
}
mysqli_query($polaczenie, "SET NAMES 'utf8'"); // ustawienie polskich znaków
?>
