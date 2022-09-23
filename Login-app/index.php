<?php

	session_start();
	//Skrypt sprawdzający czy użytkownik jest zalogowany
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		//Jeśli jest to przenosi na stronę domową
		header('Location: zalogowano.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Panel Logowania</title>
</head>

<body>
	
Panel Logowania<br /><br />
	
	<form action="zaloguj.php" method="post">
	
		Login: <br /> <input type="text" name="login" /> <br />
		Hasło: <br /> <input type="password" name="haslo" /> <br /><br />
		<input type="submit" value="Zaloguj się" />
	
	</form>
		
<?php
	//Skrypt wyświetla błąd logowania
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
?>

</body>
</html>