<?php
//page pour visualiser les factures des clients par le biais de l'administrateur

include("BD.php");

    //Connection à la bd
    $bdd = connectionbd();

    if(isset($_GET['rang'])){
		$p_id= (int) $_GET['rang'];
		
	}
?>
<!DOCTYPE html>
<html>

	<?php

		include('entete.php');
	?>

	<body>

		<?php
			

			if (isset($p_id)) {

            //nb facture dans la bd
                $requete = "SELECT count(faId) FROM facture WHERE peId= :id";
                $variable = array(
                    'id' => $p_id,
                );
                $nb_facture = select_bd($bdd, $requete, $variable);

            //parcours toute la bd et on met dans des variable les variables de la facture
                $requete = "SELECT faDate, faAdresse, faPrix, faId FROM facture WHERE peId= :id ORDER BY faId DESC";
                $variable = array(
                    'id' => $p_id,
                );
                $resultat = select_bd($bdd, $requete, $variable);
                $i = 0;

                foreach ($resultat as $tmp) {
                    $fact_date[$i] = $tmp[0];
                    $fact_adresse[$i] = $tmp[1];
                    $fact_prix[$i] = $tmp[2];
                    $fact_id[$i] = (int) $tmp[3];
                    $i++;
                }

                if (isset($fact_id[0])) {

                //nb tot valeurs
                    $nb_valeur_tot = (int) $nb_facture[0][0];

                //nb de pok par page
                    $nb_value_page = 10;

                //nb de page
                    $nb_page = ($nb_valeur_tot) / ($nb_value_page);

                 //par defaut page 0
                    if (!isset($_GET['page'])) {
                        $page = 0;
                    } else {
                        $page = $_GET['page'];
                    }
                //Tableau d'affichage 
        ?> 

                    <fieldset style="margin-left:5%; margin-right:5%; margin-top:5%;">
                        <legend style="font-size:30px; color:RGB(43, 115, 185);">Liste des Factures de

		<?php
							$requete = "SELECT peNom, pePrenom FROM personne WHERE peId= :id";
			                $variable = array(
			                    'id' => $p_id,
			                );
			                $resultat = select_bd($bdd, $requete, $variable);
			                
			                echo $resultat[0][0]." ".$resultat[0][1];
		?>
                        </legend><br>

        <?php
                        echo '<center><table style="text-align:center; width:80%; border-collapse:collapse;">
                            <tr class="tab">
                                <th>Date de création</th>
                                <th>Montant</th>
                                <th colspan="4">Options</th>
                            </tr>';

                        $_SESSION["numero_facture"] = array();


                    //Affichage des factures
                        for ($i = $page * $nb_value_page; $i < $page * $nb_value_page + $nb_value_page; $i = $i + 1) {
                            if ($i < $nb_valeur_tot) {
                                echo '<tr>
                            <td class="case">';
                                echo $fact_date[$i];
                                echo '</td>
                            <td class="case">';
                                echo $fact_prix[$i].'€';
                                echo '</td>';
                                echo'
                            <td class="case">';

                                echo '<a href="voir_facture.php?factn=' . $fact_id[$i] . '&perid=' . $p_id . '"><button class="creer" type="button" name="voir_facture" style="background-color:forestgreen;">Voir</button></a>';
                                echo '</td>
                            <td class="case">';
                                $_SESSION["numero_facture"][$i] = $fact_id[$i];
                                echo '<a href="facture.php?rang=' . $i . '&perid=' . $p_id . '"><button class="creer" type="button" name="facture" style="background-color:orange;">PDF</button></a>';
                                echo '</td></tr>';
                            }
                        }
            ?>
                        </table></center>

            <?php
                        //gestionnaire des pages
                            //Premiere page avec moins de 10 personnes
                            if ($page == 0 && $nb_valeur_tot <= 10) {
            ?>
                            	<center><a href="liste_client.php"><button class="creer" type="button" name="retour" style="background-color:red;">Retour</button></a></center>   	
	        <?php
                            }
                            //première page avec plus de 10 personnes
                            elseif ($page == 0 && $nb_valeur_tot > 10) {
            ?>
                            	<center><a href="liste_client.php"><button class="creer" type="button" name="retour" style="background-color:red;">Retour</button></a>
                            		<a href="?rang=<?php echo $p_id; ?>&page=<?php echo $page + 1; ?>"><button class="creer" type="button" name="suivant">Suivant</button></a>
	                                <a href="?rang=<?php echo $p_id; ?>&page=<?php echo (int) $nb_page; ?>"><button class="creer" type="button" name="fin">Fin</button></a></center>
	        <?php
                            }

                            //Derniere page
                            elseif ($page == (int) $nb_page) {
            ?>      
                            <center><a href="liste_client.php"><button class="creer" type="button" name="retour" style="background-color:red;">Retour</button></a>
                            	<a href="?rang=<?php echo $p_id; ?>rang=<?php echo $p_id; ?>&page=0"><button class="creer" type="button" name="debut">Début</button></a>
                                <a href="?rang=<?php echo $p_id; ?>&page=<?php echo $page - 1; ?>"><button class="creer" type="button" name="precedent">Précédent</button></a></center>

            <?php
                            }
                            else {
                                //Autre page
            ?>
                                <center><a href="liste_client.php"><button class="creer" type="button" name="retour" style="background-color:red;">Retour</button></a>
                                	<a href="?rang=<?php echo $p_id; ?>&page=0"><button class="creer" type="button" name="debut">Début</button></a>
                                    <a href="?rang=<?php echo $p_id; ?>&page=<?php echo $page - 1; ?>"><button class="creer" type="button" name="precedent">Précédent</button></a> 
                                    <a href="?rang=<?php echo $p_id; ?>&page=<?php echo $page + 1; ?>"><button class="creer" type="button" name="suivant">Suivant</button></a>
                                    <a href="?rang=<?php echo $p_id; ?>&page=<?php echo (int) $nb_page; ?>"><button class="creer" type="button" name="fin">Fin</button></a></center>
            <?php
                            }
            ?>
                    </fieldset>

            <?php
    
                } 
                else{
            	//Si aucun devis alors proposition de redirection
                echo '<center>La liste des factures est vide !<br> Sélectionner une autre personne <a href="liste_client.php"><button class="creer" type="button" name="ici" style="background-color:red;">ici</button></a></center>';
            	}
            }
            else{
            	//Si aucun devis alors proposition de redirection
                echo '<center>La liste des factures est vide !<br> Sélectionner une autre personne <a href="liste_client.php"><button class="creer" type="button" name="ici" style="background-color:red;">ici</button></a></center>';
            	}


            

		?>

	</body>

</html>