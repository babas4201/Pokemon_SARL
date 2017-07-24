<?php
//page pour se deconnecter

//creation de la session
	session_start();

//destruction de la session
	session_destroy();

//retour sur la page d'accueil en tant qu'utilisateur non connecte
	header('Location: index.php');
?>
<!DOCTYPE html>
	<html>

	<?php
		include('entete.html');
	?>

	<body>

	</body>

</html>