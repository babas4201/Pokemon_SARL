<!--page avec les fonctionnalites de l'administrateur-->

<!DOCTYPE html>
<html>

	<body>

		<div>
			<ul id="identification">
				<li class="compte"><img id="utilisateur" src="img/Admin.png" alt="image" style="width:20%; height:160%;">Administrateur
					<ul>

					<!-- bouton pour lister les clients -->			
						<li><button class="bouton" type="button" name="liste" onclick="document.location.href='liste_client.php'">Liste des clients</button></li>

						<!-- bouton pour inscrire un nouveau client -->			
						<li><button class="bouton" type="button" name="nouveau" onclick="document.location.href='inscription.php'">Nouveau client</button></li>

						<li>---------------------------</li>

					<!-- deconnexion -->
						<li><button class="creer" type="button" name="deconnexion" onclick="document.location.href='deco.php'">Déconnexion</button></li>

					</ul>
				</li>
			</ul>
		</div>

	</body>

</html>

