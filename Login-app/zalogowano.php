<?php

	session_start();
	//Skrypt sprawdzający czy użytkownik nie jest zalogowany
	if (!isset($_SESSION['zalogowany']))
	{
		//Jeśli nie jest to przenosi na stronę główną
		header('Location: index.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Zalogowano!</title>
</head>

<body>
	
<?php
	//Skrypt sprawdzający poprawność kodu do werfikacji
        $c=$_POST['code'] ?? null;
        if($c==$_SESSION['codes']){
			//Skrypt wylogowywania ze sesji
			echo "<p>Witaj ".$_SESSION['user'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';
        }else{
			echo"Podaj kod, który został wysłany na twój adres email!";
			echo<<<END
								<form method="POST">
								<input type="text" name="code" placeholder="Kod" required><br/>
								<input type="submit" value="Zweryfikuj">
								</form>
			END;
        }
	

	
?>

</body>
</html>