<!--page avec formulaire pour inscrire un client (admin ou non)-->

<!DOCTYPE html>
<html>

	<?php
		include('entete.php');
	?>

	<body>

		<?php

				//erreur d'authentification : manque mot de passe pour se connecter
					if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 1){
						echo "<strong style = 'color:red; padding-left:70%;'>Mot de passe manquant !</strong><br><br>";
					} 

				//erreur de mot de passe
					if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 2){
						echo "<strong style = 'color:red; padding-left:70%;'>Mot de passe different !</strong><br><br>";
					}

				//erreur : login déja existant
					if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 3){
						echo "<strong style = 'color:red; padding-left:70%;'>Email deja existant !</strong><br><br>";					
					}

				//erreur d'authentification : manque email pour se connecter
					if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 4){
						echo "<strong style = 'color:red; padding-left:70%;'>Email manquant !</strong><br><br>";
					} 
		?>

		

		<!-- formulaire-->
			<form class="inscrit" action = "compte.php" method = "post">	
				<fieldset style="margin-left:-5%; margin-right:10%; margin-top:5%;">
					<legend style="font-size:30px; color:RGB(43, 115, 185);">Inscription</legend><br>	

					<!-- nom -->
						<label for="nom" style="margin-left:25.5%; width:14%;">Nom</label><input id="nom" type = "text" name = "nom" value = "<?php 
							if(isset($_SESSION['form']['nom'])){
								echo $_SESSION['form']['nom'];
							}
						?>"/><br><br>
					
					<!-- prenom -->
						<label for="prenom" style="margin-left:22.7%; width:17%;">Prenom</label><input id="prenom" type = "text" name = "prenom" value = "<?php 
							if(isset($_SESSION['form']['prenom'])){
								echo $_SESSION['form']['prenom'];
							}
						?>"/><br><br>

					<!-- adresse -->
						<label for="adresse" style="margin-left:22.5%; width:17%;">Adresse</label><input id="adresse" type = "text" name = "adresse" value = "<?php 
							if(isset($_SESSION['form']['adresse'])){
								echo $_SESSION['form']['adresse'];
							}
						?>"/><br><br>

					<!-- mail -->
		<?php

					//erreur : login déja existant ou champ mail vide
						if((isset($_SESSION['erreur']) && $_SESSION['erreur'] == 3) || (isset($_SESSION['erreur']) && $_SESSION['erreur'] == 4)){
							$_SESSION['erreur'] = 0;
		?>							
						<!-- champ email encadre en rouge -->	
							<label for="mail" style="margin-left:24.5%; width:15%;">Email *</label><input id="mail" type = "text" name = "mail" style = "border:3px solid red;" value = "<?php 
							if(isset($_SESSION['form']['mail'])){
								echo $_SESSION['form']['mail'];
							}?>"/>
		<?php
						}
						else{
		?>						
						<!-- champ email normal -->
							<label for="mail" style="margin-left:24.5%; width:15%;">Email *</label><input id="mail" type = "text" name = "mail" value = "<?php 
								if(isset($_SESSION['form']['mail'])){
									echo $_SESSION['form']['mail'];
								}?>"/>
		<?php
						}
		?>				<br><br>


					<!-- mot de passe -->
		<?php

					//erreur : champ mot de passe vide
						if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 1){
							$_SESSION['erreur'] = 0;
		?>
						<!-- champ mot de passe encadre en rouge -->
							<label for="password" style="margin-left:16%; width:23.5%;">Mot de passe *</label><input id="password" type = "password" name = "password" style = "border:3px solid red;" value = "<?php 
								if(isset($_SESSION['form']['password'])){
									echo $_SESSION['form']['password'];
								}?>"/>
		<?php
						}
						else{
		?>
						<!-- champ mot de passe normal -->
							<label for="password" style="margin-left:16%; width:23.5%;">Mot de passe *</label><input id="password" type = "password" name = "password" value = "<?php 
								if(isset($_SESSION['form']['password'])){
									echo $_SESSION['form']['password'];
								}?>"/>
		<?php
						}
		?>				<br><br>


					<!-- confirmer mot de passe -->
		<?php

					//erreur : mot de passe différent
						if(isset($_SESSION['erreur']) && $_SESSION['erreur'] == 2){
							$_SESSION['erreur'] = 0;
		?>
						<!-- champ confirmez le mot de passe encadre en rouge -->
							<label for="password2" style="margin-left:1%; width:38.5%;">Confirmez le mot de passe *</label><input id="password2" type = "password" name = "password2" style = "border:3px solid red;" value = "<?php 
								if(isset($_SESSION['form']['password2'])){
									echo $_SESSION['form']['password2'];
								}?>"/>
		<?php
						}
						else{
		?>
						<!-- champ confirmez le mot de passe normal -->
							<label for="password2" style="margin-left:1%; width:38.5%;">Confirmez le mot de passe *</label><input id="password2" type = "password" name = "password2" value = "<?php 
								if(isset($_SESSION['form']['password2'])){
									echo $_SESSION['form']['password2'];
								}?>"/>
		<?php
						}
		?>				<br><br>	

			<!-- bouton valider : enregistrer donnees dans la base de donnees -->
				<center><button class="creer" type = "submit" name = "valider" style="margin-top:5%; background-color:forestgreen;">Valider</button></center>
				
				</fieldset>
			</form>

			<!-- bouton reset : detruire les sessions enregistrees dans le formulaire -->
				<center><a href="reset.php?supp=ok"><button class="creer" name = "reset" style="position:absolute; margin-top:-5%; margin-left:-1.6%; background-color:red;">Reset</button></a></center>

		</div>	
			
	</body>
</html>