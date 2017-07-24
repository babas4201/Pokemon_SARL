<?php
//page qui recapitule les informations du client

	//connexion a la base de donnee
	include("BD.php");
	$bdd = connectionbd();
?>
<!DOCTYPE html>
<html>

	<?php
		include('entete.php');
	?>

	<body>

	<?php

	//requête
		$id=$_SESSION['idClient'];
		$request="SELECT * FROM personne WHERE peid=$id";

		$reponse = $bdd->query($request);
		$donnees = $reponse->fetch();
	?>

		<fieldset style="margin-left:5%; margin-right:8%; margin-top:5%;">
			<legend style="font-size:30px; color:RGB(43, 115, 185);">Informations Personnelles</legend><br>

	<?php		

			//tableau pour resumer les informations du client
				echo '<center><table style="text-align:center; width:80%; border-collapse:collapse;">
					<tr class="tab">
						<th>Nom</th>
						<th>Prénom</th>
						<th>Email</th>
						<th>Adresse</th>
					</tr>

					<tr>
						<td class="case">';
							echo $donnees[1];
						echo '</td>
						<td class="case">';
							echo $donnees[2];
						echo '</td>
						<td class="case">';
							echo $donnees[3];
						echo '</td>
						<td class="case">';
							echo $donnees[4];
						echo '</td>
					</tr>';
	?>
				</table></center>

		</fieldset>	

	</body>

</html>