<?php
//page listant le devis en fonction de l'id de session

include("BD.php");
?>
<!DOCTYPE html>
<html>

        <?php

            include('entete.php');

        //Si l'id client est connu
            if (isset($_SESSION["idClient"])) {

                if (isset($_SESSION["envoi_mail"])) {
                    echo $_SESSION["envoi_mail"];
                    $_SESSION["envoi_mail"] = null;
                }
        ?>

        <body>

        <?php

            //Connection a la bd
                $bdd = connectionbd();

            //nb pokemon dans la bd
                $requete = "SELECT count(deId) FROM devis WHERE peId= :id";
                $variable = array(
                    'id' => $_SESSION["idClient"],
                );
                $nb_devis = select_bd($bdd, $requete, $variable);
            //parcours toute la bd et on met dans des variable les variables du devis

                $requete = "SELECT deDate, deAdresse, dePrix, deId FROM devis WHERE peId= :id ORDER BY deId DESC";
                $variable = array(
                    'id' => $_SESSION["idClient"],
                );
                $resultat = select_bd($bdd, $requete, $variable);
                $i = 0;

                foreach ($resultat as $tmp) {
                    $dev_date[$i] = $tmp[0];
                    $dev_adresse[$i] = $tmp[1];
                    $dev_prix[$i] = $tmp[2];
                    $dev_id[$i] = (int) $tmp[3];
                    $i++;
                }

                if (isset($dev_id[0])) {

                     //nb tot valeurs
                    $nb_valeur_tot = (int) $nb_devis[0][0];

                //nb de pok par page
                    $nb_value_page = 5;

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
                        <legend style="font-size:30px; color:RGB(43, 115, 185);">Devis</legend><br>

        <?php
                        echo '<center><table style="text-align:center; width:100%; border-collapse:collapse;">
                            <tr class="tab">
                                <th>Date de création</th>
                                <th>Adresse</th>
                                <th>Montant</th>
                                <th colspan="4">Options</th>
                            </tr>';

                        $_SESSION["numero_devis"] = array();

                                echo '<tr>
                            <td class="case">';
                                echo $dev_date[0];
                                echo '</td>
                            <td class="case">';
                                echo $dev_adresse[0];
                                echo '</td>
                            <td class="case">';
                                echo $dev_prix[0].'€';
                                echo '</td>';
                            echo '<td class="case">';
                                echo '<a href="edit_devis.php?devn=' . $dev_id[0] . '"><button class="creer" type="button" name="dev_id" style="background-color:red;">Modifier</button></a>';
                                echo '</td>
                            <td class="case">';
                            
                            for ($i = $page * $nb_value_page; $i < $page * $nb_value_page + $nb_value_page; $i = $i + 1) {
                                if($i <= $nb_valeur_tot[0]){
                                    $_SESSION["numero_devis"][$i] = $dev_id[0];
                                    echo '<a href="devis.php?rg=' . $i . '"><button class="creer" type="button" name="devis" style="background-color:orange;">PDF</button></a>';
                                    echo '</td>
                                    <td class="case">';
                                    echo '<a href="devis_mail.php?rg=' . $i . '"><button class="creer" type="button" name="devis_mail" style="background-color:RGB(43, 115, 185);">Envoyer par mail</button></a>';
                                    echo '</td>';
                                }
                            }
                            
                            echo '<td class="case">';
                                echo '<a href="generation_facture.php?devn=' . $dev_id[0] . '"><button class="creer" type="button" name="generation_facture" style="background-color:forestgreen;">Générer facture</button></a>';
                                echo '</td>
                        </tr>';
        ?>
                        </table></center>
                        
                    </fieldset>

        <?php
    //Si aucun devis alors proposition de redirection
        } 
        else {
            echo '<center>La liste des devis est vide !<br> Sélectionner des Pokémons <a href="index.php"><button class="creer" type="button" name="ici" style="background-color:red;">ici</button></a></center>';
        }
    }
        ?>
    </body>

</html>