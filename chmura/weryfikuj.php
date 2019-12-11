<?php
session_start();
include('dbconnection.php');

 $user=$_POST['user']; // login z formularza
 $pass=$_POST['pass']; // hasło z formularza

 // pobranie z BD wiersza, w którym login=login z formularza
 $result = mysqli_query($polaczenie, "SELECT * FROM users WHERE login='$user'");
 $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
 if(!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
 {
// zamknięcie połączenia z BD
 //poinformuj o nieprawidłowości poprzez zmienną sesyjną
 $_SESSION['blad']='<span style="color:red">Podana nazwa konta lub hasło są niepoprawne</span>';
 echo "<script>
 window.location.replace('http://wojciechowskid.pl/pages/lab7.php');
 </script>";
 }
 else
 { // Jeśli użytkownik posiada konto
	$userId = $rekord['id'];  //id konta użytkownika
	$haslo = $rekord['haslo']; //hasło uzytkownika
	$iloscNieudanych = $rekord['ilosc_nieudanych_logowan']; // pobierz z bazy ilość nieudanych prób logowania
	$ostatniaData = $rekord['data_zmiany']; //ostatnia data niepoprawnego logowania

  //tworzymy obiekt typu DateTime
	$datetime1 = new DateTime($ostatniaData);
	$datetime2 = new DateTime();
	$interval = $datetime1->diff($datetime2);
	//echo $interval->format('%Y-%m-%d %H:%i:%s');
	$minut = $interval->format('%i');
  //gdy użytkownik poda na przykład 3 krotnie niepoprawne dane zablokuj jego konto w ciągu mniej niz 1 minuty
	if($iloscNieudanych>2 && $minut<1) {
		 $_SESSION['attempt_error']='<span style="color:red">Konto zablokowane, spróbuj ponownie za 30 sekund</span>';
     echo "<script>
     window.location.replace('http://wojciechowskid.pl/pages/lab7.php');
     </script>";
         exit();
}

	if($haslo==$pass) // czy hasło zgadza się z BD
	{
		setcookie("LastErrorLogin", '', 1, '/');
		$poprawne = 1;

    //wyzeruj licznik nieudanych logowań
		if($rekord['ilosc_nieudanych_logowan'] > 0){

    //dodaj do tabeli users informację o ilości nieudanych logowań równą 0 oraz aktualny czas dla uzytkownika zawartego w zmiennej $userId
    $insert="update `users` set ilosc_nieudanych_logowan = 0, data_zmiany = now() where id = $userId";
    mysqli_query($polaczenie, $insert);
		setcookie("LastErrorLogin", $datetime1->format('Y-m-d H:i:s') , time()+10*60, '/');
		}

    //dodaj do tabeli logs nowy wpis dla użytkownika, który się zalogował
    $insert="insert into logs (user_id, poprawne_logowanie) values ('$userId', $poprawne);";
    mysqli_query($polaczenie, $insert);

	  mysqli_close($polaczenie);

		setcookie("ChmuraLogUsr", '', 1, '/');
		setcookie("CurrentDirPath", '', 1, '/');
		setcookie("ChmuraLogUsr", $user , time()+10*60, '/');


    echo "<script>
    window.location.replace('http://wojciechowskid.pl/pages/lab7/chmura/drive.php');
    </script>";
    exit();
	 }

	 else
	 {
    //jeśli logowanie jest niepoprawne, tzn. mamy na przyklad błedne haslo
		 $poprawne = 0;
     //zwieksz liczbe niudanych logowa oraz dodaj datę tego logowania
    $update = "update users set ilosc_nieudanych_logowan = ilosc_nieudanych_logowan + 1, data_zmiany = now() where id = $userId;";
    mysqli_query($polaczenie, $update);
    //dodaj do logow informacje czy logowania bylo poprawne, czy nie
    $insert="insert into logs (user_id, poprawne_logowanie) values ('$userId', $poprawne);";
    mysqli_query($polaczenie, $insert);
	  mysqli_close($polaczenie);
    //poinformuj użytkownika, że podał nie poprawne dane
   $_SESSION['bad_password']= '<span style="color:red">Niepoprawny login lub hasło!</span>';

   echo "<script>
   window.location.replace('http://wojciechowskid.pl/pages/lab7.php');
   </script>";
	 }
}
?>
