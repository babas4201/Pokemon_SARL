<?php
//page où l'administrateur fait des recherches sur le client

//Demarrage de la session
include("BD.php");
//Connection a la bd
$bdd = connectionbd();
?>
<!DOCTYPE html>
<html>

	<?php
		include('entete.php');
	?>

    <body>

        <?php

             global $nb_valeur_tot, $nb_value_page, $nb_page;

             //par defaut page 0
                if (!isset($_GET['page'])) {
                    $page = 0;
                } else {
                    $page = $_GET['page'];
                }

            if (isset($_POST["recherche"]) && $_POST["recherche"] != "") {
                $_SESSION["recherche"] = $_POST["recherche"];
            }
            else {
                $_SESSION["recherche"] = null;
            }

            //s'il n'y a pas de recherche faite
            if (!isset($_SESSION["recherche"])) {

            //nb personne dans la bd
            	$nb_personne = select_bd($bdd, "SELECT count(peId) FROM personne");

			//parcours toute la bd et on met dans des variables les noms, les prenoms,...
	            for ($i = 1; $i <= $nb_personne[0]; $i++) {
	                $request = "SELECT peNom, pePrenom, peMail, peAdresse FROM personne where peId= :id";
	                $variable = array(
	                    'id' => $i,
	                );
	                $tmp = select_bd($bdd, $request, $variable);
	                $per_nom[$i] = $tmp[0][0];
	                $per_prenom[$i] = $tmp[0][1];
	                $per_mail[$i] = $tmp[0][2];
	                $per_adresse[$i] = $tmp[0][3];
	            }

            //nb tot valeurs
                $nb_valeur_tot = $nb_personne[0];

            //nb de personne par page
                $nb_value_page = 11;

            //nb de page
                $nb_page = $nb_valeur_tot / $nb_value_page;
            //Tableau d'affichage
            
        ?> 

                <fieldset style="margin-left:5%; margin-right:5%; margin-top:5%;">
                    <legend style="font-size:30px; color:RGB(43, 115, 185);">Liste Clients</legend><br>             
                        <div style="width:100%;">

                            <form action="#" method = "post" style="text-align: center; margin-top:0px; margin-bottom: 10px;">
                                <input type="text" placeholder="Ex: Dupond" style="width:35%" name="recherche"/>
                                <button class="creer" type = "submit" style="width:26%">Rechercher</button>
                            </form><br>

        <?php
                            //tableau pour resumer les informations du client
							echo '<center><table style="text-align:center; width:80%; border-collapse:collapse;">
									<tr class="tab">
										<th>Nom</th>
										<th>Prénom</th>
										<th>Email</th>
										<th>Adresse</th>
										<th>Visualiser historiques</th>
									</tr>';

	                        for ($i = $page * $nb_value_page + 1; $i <= $page * $nb_value_page + $nb_value_page; $i = $i + 1 ) {
	                            if($i != $nb_valeur_tot[0] && $i <= $nb_valeur_tot){
	                                echo '<tr><td class="case">'.$per_nom[$i].'</td>';
	                                echo '<td class="case">'.$per_prenom[$i].'</td>';
	                                echo '<td class="case">'.$per_mail[$i].'</td>';
	                                echo '<td class="case">'.$per_adresse[$i].'</td>';
	                                echo '<td class="case"><a href="visualisation.php?rang=' . $i . '"><button class="creer" type="button" name="visualisation" style="background-color:forestgreen;">Visualiser</button></a></td></tr>';
	                            }
	                        }
	                    echo "</table></center></div>";



                        //gestionnaire des pages
                        //premiere page avec moins de 11 clients
                        if($page == 0 && $nb_valeur_tot <= 11){

                        }
                        //Premiere page avec plus de 11 clients
                        elseif ($page == 0 && $nb_valeur_tot > 11) {
        ?>      
                            <center><a href="?page=<?php echo $page + 1; ?>"><button class="creer" type="button" name="suivant">Suivant</button></a>
                                <a href="?page=<?php echo (int) $nb_page; ?>"><button class="creer" type="button" name="fin">Fin</button></a></center>
        <?php
                        }
                        //Derniere page
                        elseif ($page == (int) $nb_page) {
        ?>      
                        <center><a href="?page=0"><button class="creer" type="button" name="debut">Début</button></a>
                            <a href="?page=<?php echo $page - 1; ?>"><button class="creer" type="button" name="precedent">Précédent</button></a></center>

        <?php
                        }
                        else {
                            //Autre page
        ?>
                            <center><a href="?page=0"><button class="creer" type="button" name="debut">Début</button></a>
                                <a href="?page=<?php echo $page - 1; ?>"><button class="creer" type="button" name="precedent">Précédent</button></a> 
                                <a href="?page=<?php echo $page + 1; ?>"><button class="creer" type="button" name="suivant">Suivant</button></a>
                                <a href="?page=<?php echo (int) $nb_page; ?>"><button class="creer" type="button" name="fin">Fin</button></a></center>
        <?php
                        }
        ?>
                </fieldset>


        <?php
            } 
            else {
                //s'il y a une recherche faite

            //nb pokemon dans la bd correspondant a la recherche
                $requete = "SELECT count(peId) FROM personne WHERE peNom like :recherche";
                $variable = array(
                    'recherche' => $_SESSION["recherche"] . "%",
                );
                $nb_personne = select_bd($bdd, $requete, $variable);

                //enlever l'administrateur
                $requete = "SELECT peId FROM personne WHERE peNom='DEJ'";                
                $une_personne = select_bd($bdd, $requete, $variable);


                if ((int) $nb_personne[0][0] >= 1) {
                    
                //Stockage des id des pokemon correspondant a la recherche
                    $requete = "SELECT peId, peNom, pePrenom, peMail, peAdresse FROM personne WHERE peNom like :recherche";
                    $variable = array(
                        'recherche' => $_SESSION["recherche"] . "%",
                    );
                    $per_recherche = select_bd($bdd, $requete, $variable);
                    
                //Tableau d'affichage
        ?> 

                    <fieldset style="margin-left:5%; margin-right:5%; margin-top:5%;">
                        <legend style="font-size:30px; color:RGB(43, 115, 185);">Liste Clients</legend><br>             
                            <div style="width:100%; ">

                                <form action="" method = "post" style="text-align: center; margin-top:0px; margin-bottom: 10px;">
                                    <input type="text" placeholder="Ex: Dupond" style="width:35%" name="recherche"/>
                                    <button class="creer" type = "submit" style="width:26%">Rechercher</button>
                                </form><br>

        <?php
                            //tableau pour resumer les informations du client
								echo '<center><table style="text-align:center; width:80%; border-collapse:collapse;">
									<tr class="tab">
										<th>Nom</th>
										<th>Prénom</th>
										<th>Email</th>
										<th>Adresse</th>
										<th>Visualiser historiques</th>
									</tr>';

                                foreach ($per_recherche as $pers) {
                                    if($pers[0] != $une_personne[0][0]){
                                        echo '<tr><td class="case">'.$pers[1].'</td>';
                                        echo '<td class="case">'.$pers[2].'</td>';
                                        echo '<td class="case">'.$pers[3].'</td>';
                                        echo '<td class="case">'.$pers[4].'</td>';
                                        echo '<td class="case"><a href="visualisation.php?rang=' . $pers[0] . '"><button class="creer" type="button" name="visualisation" style="background-color:forestgreen;">Visualiser</button></a></td></tr>';
                                    }                              
                                }
                                echo "</table></center></div><br>";
                                echo '<center><a href="liste_client.php"><button class="creer" type="button" name="retour" style="background-color:red;">Retour</button></a></center>';
        ?>
                    </fieldset>
                    


        <?php
                } 
                else {
                    echo "<center>Aucun élement correspond à votre recherche<br> <a href='liste_client.php'><button class='creer' type='button' name='ici' style='background-color:red;'>cliquez ici pour revevenir</button></a></center>";
                }
            }
        ?>

    </body>

</html>