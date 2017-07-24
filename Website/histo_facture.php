<?php
//page listant l'historique des factures en fonction de l'id de session

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

        //Si l'id client est connu

            if (isset($_SESSION["idClient"])) {
             
                if (isset($_SESSION["envoi_mail"])) {
                    echo $_SESSION["envoi_mail"];
                    $_SESSION["envoi_mail"] = null;
                }

            //nb facture dans la bd
                $requete = "SELECT count(faId) FROM facture WHERE peId= :id";
                $variable = array(
                    'id' => $_SESSION["idClient"],
                );
                $nb_facture = select_bd($bdd, $requete, $variable);

            //parcours toute la bd et on met dans des variable les variables de la facture
                $requete = "SELECT faDate, faAdresse, faPrix, faId FROM facture WHERE peId= :id ORDER BY faId DESC";
                $variable = array(
                    'id' => $_SESSION["idClient"],
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
                        <legend style="font-size:30px; color:RGB(43, 115, 185);">Liste des Factures</legend><br>

        <?php
                        echo '<center><table style="text-align:center; width:80%; border-collapse:collapse;">
                            <tr class="tab">
                                <th>Date de création</th>
                                <th>Montant</th>
                                <th colspan="4">Options</th>
                            </tr>';

                        $_SESSION["numero_facture"] = array();


                    //Affichage des devis
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

                                echo '<a href="voir_facture.php?factn=' . $fact_id[$i] . '"><button class="creer" type="button" name="voir_facture" style="background-color:forestgreen;">Voir</button></a>';
                                echo '</td>
                            <td class="case">';
                                $_SESSION["numero_facture"][$i] = $fact_id[$i];
                                echo '<a href="facture.php?rang=' . $i . '"><button class="creer" type="button" name="facture" style="background-color:orange;">PDF</button></a>';
                                echo '</td>';
                                echo '<td class="case">';
                                echo '<a href="facture_mail.php?rang=' . $i . '"><button class="creer" type="button" name="facture_mail" style="background-color:RGB(43, 115, 185);">Envoyer par mail</button></a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
            ?>
                        </table></center>

            <?php
                        //gestionnaire des pages
                            //premiere page avec moins de 10 pokemons
                            if($page == 0 && $nb_valeur_tot <= 10){

                            }
                            //Premiere page avec plus de 10 pokemons
                            elseif ($page == 0 && $nb_valeur_tot > 10) {
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

            
            else{
                //Si aucun devis alors proposition de redirection
                echo '<center>La liste des factures est vide !<br> Sélectionner des Pokémons <a href="index.php"><button class="creer" type="button" name="ici" style="background-color:red;">ici</button></a></center>';
            }
        }
            
            ?>

     </body>

</html>
