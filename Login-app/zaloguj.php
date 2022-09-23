<?php

	session_start();
	//Skrypt sprawdzający czy pole w formularzu zostały uzupełnione
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		//Jeśli nie jest to przenosi na stronę główną
		header('Location: index.php');
		exit();
	}
	//Skrypt łączy się z bazą danych
	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	//Skrypt jeśli napotka błąd w połączeniu odrazu się wyłącza i wyświetla kod błędu
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		//Pobieranie zmniennych z formularza 
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		//Sprawdzanie czy zmienne są zogdne z normami
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
		//Próba logowania
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE user='%s' AND pass='%s'",
		mysqli_real_escape_string($polaczenie,$login),
		mysqli_real_escape_string($polaczenie,$haslo))))
		{
			//Skrypt sprawdzający czy udało się zalogować czy nie
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				//Jeżeli tak to zwróci nam to
				$_SESSION['zalogowany'] = true;
				
				$wiersz = $rezultat->fetch_assoc();
				$_SESSION['id'] = $wiersz['id'];
				$_SESSION['user'] = $wiersz['user'];
				//Generowanie kodu do logowania dwuetapowego
				$liczba=$_SESSION['codes'] = $liczba=rand(999,999999);;
				//Oraz wyśle nam email z kodem do logowania dwuetapowego
				$e=$_SESSION['email'] = $wiersz['email'];
				$to = "$e";
                $subject = "Witaj oto logowanie dwuetapowe!";
                $txt = "$liczba Oto twój kod dostępu";
                $headers = "From: exmple@gmail.com" . "\r\n" .
                "CC: somebodyelse@example.com";
     
                mail($to,$subject,$txt,$headers);

				//Skrypt sprawdzający czy udało się zwrócić i wysłać email
				unset($_SESSION['blad']);
				$rezultat->free_result();
				//Jeżeli wszystko ok to przekierowuje
				header('Location: zalogowano.php');
				
			} else {
				//Błąd jeżeli któreś z podanych danych są nieprawidłowe
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: index.php');
				
			}
			
		}
		
		$polaczenie->close();
	}
	
?>