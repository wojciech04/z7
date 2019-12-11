<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
 <meta charset="utf-8"/>
 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
 <title>Wojciechowski </title>
  <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
  <a href="http://wojciechowskid.pl">Strona główna</a>
<p> <b>Prywatna chmura</b> </p>
<div class="container">
		<div><b>ZADANIE 7 - Logowanie</b>
			<span id="dataCzas" style="float:right;"></span>
		</div>
<div>
			<form method="post" action="http://wojciechowskid.pl/pages/lab7/chmura/weryfikuj.php">
					Login:<input type="text" name="user" maxlength="20" size="20"><br>
					Hasło:<input type="password" name="pass" maxlength="20" size="20"><br>
					     <button type="submit" >Zaloguj </button>
			</form>
      <?php
      if(isset($_SESSION['blad']))
        { //informacja o tym, że podano złe dane logowania
          echo $_SESSION['blad'];
          unset($_SESSION['blad']);
        } //w przypadku gdy podano zły login
        if(isset($_SESSION['bad_password']))
        { echo $_SESSION['bad_password'];
          unset($_SESSION['bad_password']);
        }
        //informacja o tym, że przekroczono dozwoloną ilość logowań i konto zostanie zablokowane
        if(isset($_SESSION['attempt_error']))
        { echo $_SESSION['attempt_error'];
          unset($_SESSION['attempt_error']);
          //uśpij skrypt na 30 sekund
          sleep(30);
        }
      ?>
  </div>
<br><br><br>
				<div>
          <b>ZADANIE 7 - Rejestracja dla nowych użytkowników</b>
					<form method="post" action="http://wojciechowskid.pl/pages/lab7/chmura/rejestruj.php">
							Login:<input type="text" name="user" maxlength="20" size="20"><br>
							Hasło:<input type="password" name="pass1" maxlength="20" size="20"><br>
							Powtórz Hasło:<input type="password" name="pass2" maxlength="20" size="20"><br>
					         <button type="submit">Zarejestruj</button>
					</form>
        </div>
					<?php
          //informacja o tym, że podany login już istniej
          if(isset($_SESSION['blad_login']))
            { echo $_SESSION['blad_login'];
              unset($_SESSION['blad_login']);
            }
            //informacja o tym, że podane hasła nie są takie same
            if(isset($_SESSION['blad_pass']))
              { echo $_SESSION['blad_pass'];
                unset($_SESSION['blad_pass']);
              }
					if (isset($_SESSION['success'])) {
					echo $_SESSION['success'];
					unset($_SESSION['success']);
					}
					?>
				</div>
</body>
</html>
