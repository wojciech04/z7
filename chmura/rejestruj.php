<?php

session_start();

 ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>
<BODY>
<?php

$dbhost="localhost";
$dbuser="00261600_lab7";
$dbpassword="ej7D7Ag8p";
$dbname="00261600_lab7";

$polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

if (!$polaczenie) {
echo "Błąd połączenia z MySQL." . PHP_EOL;
echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
echo "Error: " . mysqli_connect_error() . PHP_EOL;
exit;
}

 $userRejestracja=$_POST['user']; // login z formularza
 $pass1=$_POST['pass1']; // hasło z formularza
 $pass2=$_POST['pass2']; // hasło2 z formularza

 $result = mysqli_query($polaczenie, "SELECT * FROM users WHERE login='$userRejestracja'"); // pobranie z BD wiersza, w którym login=login z formularza
 $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
 if($rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
 {
	 $_SESSION['blad_login']='<span style="color:red">Istnieje już użytkownik o podanym loginie, podaj inny!</span>';
	 mysqli_close($polaczenie); // zamknięcie połączenia z BD
 }

//Jeśli użytkownik o takim loginie nie istnieje to sprawdź wprowadzone hasła
 else {

   //sprawdz czy hasla sa takie same
   if($pass1==$pass2){
        //jesli hasla sa takie same dodaj login i haslo do tabel users

       //dodaj login i hasło nowego użytkownika do tabeli users
       $insert=mysqli_query($polaczenie,"INSERT INTO users (login,haslo) values('$userRejestracja','$pass1');");


       //utwórz folder dla użytkonika na Drivie
        $target_folder='/pages/lab7/chmura/directories';
        mkdir($_SERVER['DOCUMENT_ROOT'].$target_folder.'/'.$userRejestracja, 0777, true);
        //poinformuj o pomyslnym utworzeniu konta w panelu użytkownika
        $_SESSION['success']='<span style="color:green">Konto użytkownika zostało utworzone! Zaloguj się na swoje konto, bo korzystać z dysku</span>';

         //przenieś na stronę formularza rejestracji
         echo "<script>
         window.location.replace('http://wojciechowskid.pl/pages/lab7.php');
         </script>";
         mysqli_close($polaczenie);
       }
   else{ //jeśli wprowadzone hasła są rożne
     //poinforumuj o bledzie w haslach
           $_SESSION['blad_pass']='<span style="color:red">Wpisane hasła nie są takie same!</span>';
    //odeslij do formularza rejestracji/logowania
           echo "<script>
           window.location.replace('http://wojciechowskid.pl/pages/lab7.php');
           </script>";

      }    }




       ?>

</BODY>
</HTML>
