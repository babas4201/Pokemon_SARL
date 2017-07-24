<?php
//page action de la connexion

//creation de la session
	session_start();
	
//connection à la base de donnée
	include("BD.php");
	$bdd = connectionbd();

//variables pour la requête
	$mail = $_POST['mail'];
	$password = md5($_POST['password']);

//requête SQL
	$request = "SELECT peMail, peMdp, peId FROM personne WHERE peMail = '$mail' AND peMdp = '$password'";

//s'il y a une erreur lors de la connexion
	$_SESSION['erreur'] = 0;

//savoir si le client est connecté
	$_SESSION['estConnecte'] = 0;

//l'id du client
	$_SESSION['idClient'] = "";

//s'il est administrateur
	$_SESSION['admin'] = 0;

//récupérer les donnees de la base
	$reponse = $bdd->query($request);
	$donnees = $reponse->fetch();
?>
<!DOCTYPE html>
	<html>

	<?php
		include('entete.html');
	?>

	<body>

	<!-- presentation de la page html -->
		<header>
			<div id="menu">
				<img src="img/Pokemon.png" alt="image" style="width:300px; height:100px;"/>
			</div>
		</header>

		<?php

		//test si les champs mail et password ne sont pas vides
			if(isset($mail) && isset($_POST['password']) && (!empty($mail)) && (!empty($_POST['password']))){	
				$_SESSION['connexion'] = $_POST;

				if($mail == "edej@orange.fr" && $password == $donnees[1]){ //si l'utilisateur est administrateur
					$_SESSION['admin'] = 1; 
					$_SESSION['estConnecte'] = 1; //l'utilisateur est connecte
					header('Location: index.php'); //retour sur la page d'accueil si l'utilisateur est connecte
				}
				elseif ($mail == $donnees[0] && $password == $donnees[1]) {
					$_SESSION['estConnecte'] = 1; //l'utilisateur est connecte
					$_SESSION['idClient'] = $donnees[2]; //recuperation de l'id du client
					header('Location: index.php'); //retour sur la page d'accueil si l'utilisateur est connecte
				}
				else if($password != $donnees[1]){ //si le mot de passe est different de celui stocke dans la base de donnees
					$_SESSION['erreur'] = 6; //erreur : "mot de passe incorrect"
					header('Location: index.php'); //retour sur la page d'accueil pour se connecter a nouveau
				}
			}			     		
			else{
				if(isset($mail) && empty($mail)){ //si le champ mail est vide
					$_SESSION['erreur'] = 7; //erreur : "mail manquant"
				}
				else{
					$_SESSION['erreur'] = 5; //erreur : "mot de passe manquant"
				}
				header('Location: index.php'); //retour a la page d'accueil pour se connecter a nouveau
			}
			resultat($bdd, $request); //si tout est fonctionnel, extraction des resultats

		?>

	</body>

</html>