<!--page pour se connecter en tant qu'administrateur ou autre-->

<!DOCTYPE html>
<html>

	<body>

		<?php

		//test pour savoir si le client est connecté ou non
			if(isset($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == 1){

				if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){ //si l'utilisateur est administrateur
		?>
				<!-- si l'utilisateur est administrateur -->
		<?php 
						include('admin.php');
				}
				else{
		?>

				<!-- si l'utilisateur est client -->
					<div>
						<ul id="identification">
							<li class="compte"><img id="utilisateur" src="img/Utilisateur.png" alt="image" style="width:17%; height:130%; margin-top:-5%;">Espace personnel
								<ul>

								<!-- panier -->			
									<li><button class="bouton" type="button" name="panier" onclick="document.location.href='creation_devis.php'">Panier</button></li>

								<!-- devis -->
									<li><button class="bouton" type="button" name="devis" onclick="document.location.href='histo_devis.php'">Devis</button></li>

								<!-- facture -->			
									<li><button class="bouton" type="button" name="facture" onclick="document.location.href='histo_facture.php'">Factures</button></li>

								<!-- informations personnelles -->
									<li><button class="bouton" type="button" name="info" onclick="document.location.href='informations.php'">Informations</button></li>

									<li>---------------------------</li>

								<!-- deconnexion -->
									<li><button class="creer" type="button" name="deconnexion" onclick="document.location.href='deco.php'">Déconnexion</button></li>
								</ul>
							</li>
						</ul>
					</div>
		<?php
				}
			}
			else{		
		?>

			<!-- si le client n'est pas connecté alors il remplit les champs -->
				<form method="post" action="verif.php">
		
			<!-- creer compte ou se connecter -->
				<ul id="identification">
					<li class="compte"><img id="utilisateur" src="img/Connexion.png" alt="image">Connexion
						<ul>

						<!-- mail -->			
							<li><input class="lettre" type="identifiant" name="mail" placeholder="Adresse email" value = "<?php 
								if(isset($_SESSION['connexion'])){
									echo $_SESSION['connexion']['mail'];
								}
							?>"/></li>									

						<!-- mot de passe -->
							<li><input class="lettre" type="password" name="password" placeholder="Mot de passe"/></li>							

						<!-- valider -->
							<li><button class="ok" type="submit" name="ok">Ok</button></li>
							<li>---------------------------</li>

						<!-- creer son compte -->
							<li><button class="creer" type="button" name="creation" onclick="document.location.href='inscription.php'">Créer votre compte</button></li>
						</ul>

		<?php

					//erreur d'authentification : mot de passe manquant
						if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 5){
		?>
							<ul style="overflow:visible;">

							<!-- mail -->			
								<li><input class="lettre" type="identifiant" name="mail" placeholder="Adresse email" value = "<?php 
									if(isset($_SESSION['connexion'])){
										echo $_SESSION['connexion']['mail'];
									}
								?>"/></li>

							<!-- mot de passe -->
								<li><input class="lettre" type="password" name="password" placeholder="Mot de passe" style = "border: 3px solid red;"/></li>
									
							<!-- valider -->
								<li><button class="ok" type="submit" name="ok">Ok</button></li>
								<li>---------------------------</li>

							<!-- creer son compte -->
								<li><button class="creer" type="button" name="creation" onclick="document.location.href='inscription.php'">Créer votre compte</button></li>
							</ul>
		<?php
						}

					//erreur d'authentification : mot de passe incorrect pour se connecter
						if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 6){
		?>
							<ul style="overflow:visible;">

							<!-- mail -->			
								<li><input class="lettre" type="identifiant" name="mail" placeholder="Adresse email" value = "<?php 
									if(isset($_SESSION['connexion'])){
										echo $_SESSION['connexion']['mail'];
									}
								?>"/></li>

							<!-- mot de passe -->
								<li><input class="lettre" type="password" name="password" placeholder="Mot de passe" style = "border: 3px solid red;"/></li>
									
							<!-- valider -->
								<li><button class="ok" type="submit" name="ok">Ok</button></li>
								<li>---------------------------</li>

							<!-- creer son compte -->
								<li><button class="creer" type="button" name="creation" onclick="document.location.href='inscription.php'">Créer votre compte</button></li>
							</ul>
		<?php
						}

						//erreur d'authentification : mail manquant
						if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 7){
		?>
							<ul style="overflow:visible;">

							<!-- mail -->			
								<li><input class="lettre" type="identifiant" name="mail" placeholder="Adresse email" value = "<?php 
									if(isset($_SESSION['connexion'])){
										echo $_SESSION['connexion']['mail'];
									}
								?>" style = "border: 3px solid red;"/></li>

							<!-- mot de passe -->
								<li><input class="lettre" type="password" name="password" placeholder="Mot de passe"/></li>
									
							<!-- valider -->
								<li><button class="ok" type="submit" name="ok">Ok</button></li>
								<li>---------------------------</li>

							<!-- creer son compte -->
								<li><button class="creer" type="button" name="creation" onclick="document.location.href='inscription.php'">Créer votre compte</button></li>
							</ul>
		<?php
						}
		?>

					</li>
				</ul>
			</form>

		<?php 
			} 
		?>
		
	</body>

</html>