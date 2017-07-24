<?php
//supprimer les champs dans la page inscription

//creation de la session
	session_start();

//fonction du bouton reset
	if($_GET['supp']=='ok'){  
		unset($_SESSION['form']);
		header('Location: inscription.php');
	}
?>