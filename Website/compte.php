<?php
//page action de l'inscription

//creation de la session
	session_start();

//connection a la base de donnee
	include("BD.php");
	$bdd = connectionbd();

//variables pour la requete
	$identifiant = 0;
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$adresse = $_POST['adresse'];
	$mail = $_POST['mail'];
	$password = md5($_POST['password']);

//requêtes
	$request = "INSERT INTO personne VALUES ('$identifiant', '$nom', '$prenom', '$mail', '$adresse', '$password')";
	$request2 = "SELECT peMail FROM personne WHERE peMail = '$mail'";

//s'il y a une erreur lors de la connexion
	$_SESSION['erreur'] = 0;

?>
<!DOCTYPE html>
<html>

		<body>

		<?php			
				$reponse = $bdd->query($request2);
				$donnees = $reponse->fetch();

			//test si les champs mail et password ne sont pas vides
				if(isset($mail) && isset($_POST['password']) && (!empty($mail)) && (!empty($_POST['password']))){  
					$_SESSION['form'] = $_POST;
				
					if(($password != md5($_POST['password2'])) || ($mail == $donnees[0])){ //si les deux mots de passe sont differents ou que le mail est deja enregistre dans la base de donnees

						if($mail == $donnees[0]){ //s'il existe deja un mail dans la base de donnees (login) alors il y a l'erreur : "mail existant"
							$_SESSION['erreur'] = 3;
						}
						else{						
							$_SESSION['erreur'] = 2; //si les deux mots de passe sont differents alors il y a l'erreur : "mot de passe different"
						}					
						header('Location: inscription.php'); //retour sur la meme page formulaire
					}
					else{					
						resultat($bdd, $request); //si tout le formulaire est fonctionnel, extraction des resultats en fonction de la requete
						header('Location: index.php'); //retour sur la page d'accueil pour ensuite se connecter a son compte
						$_SESSION['form'] = 0;
					}
				}
				else{
					if(empty($mail)){ //si le champ mail est vide alors il y a l'erreur : "mail manquant"
						$_SESSION['erreur'] = 4;
					}
					else{					
						$_SESSION['erreur'] = 1; //si le champ mot de passe est vide alors il y a l'erreur : "mot de passe manquant"
					}
					header('Location: inscription.php'); //retour sur la meme page formulaire
				}
				
		?>		

	</body>

</html>