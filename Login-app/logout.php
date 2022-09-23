<?php
//Skrypt wylogowywania
	session_start();
	
	session_unset(); //usuwanie sesji
	
	header('Location: index.php'); //przenoszenie do innej sesji

?>