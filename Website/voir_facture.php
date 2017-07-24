<?php
//Affichage des données de la facture

include("BD.php");

//Traitement de la variable get qui permet de connaitre l'id du devis
    $fa_id = 0;

    if (isset($_GET["factn"])) {
        $fa_id = (int) $_GET["factn"];
    }

//Connection à la bd
    $bdd = connectionbd();

//Recup liste pour facture
    $requete = "SELECT pokemon.poNom, pokemon.poPrix, pokemonfacture.pfQuantite, pokemonfacture.faId, pokemonfacture.poId FROM pokemon INNER JOIN pokemonfacture ON pokemon.poId=pokemonfacture.poId INNER JOIN facture ON pokemonfacture.faId=facture.faId WHERE facture.faId= :id;";
    $var = array(
        'id' => $fa_id,
    );
    $result = select_bd($bdd, $requete, $var);
?>
<!DOCTYPE html>
<html>

        <?php
            include('entete.php');
        ?>

    <body>     

        <?php 

        //si c'est un client
            if($_SESSION['admin'] == 0){
        ?>

                 <!-- Tableau recapitulatif de la facture-->
            <fieldset style="margin-left:5%; margin-right:5%; margin-top:5%;">
                <legend style="font-size:30px; color:RGB(43, 115, 185);">Détail Facture</legend><br>

        <?php
                echo '<center><table style="text-align:center; border-collapse:collapse;">
                        <tr class="tab">
                            <th>Nom</th>
                            <th>Quantite</th>
                            <th>Prix unitaire</th>
                            <th>Prix total</th>                        
                        </tr>';


                //Pour chaque pokemon commande dans la facture on affiche sa quantite et son prix
                foreach ($result as $value) {
                    echo '<tr>
                                <td class="case">';
                    echo $value[0];
                    echo '</td>
                                <td class="case">';
                    echo $value[2];


                    echo '</td>
                                <td class="case">';
                    echo $value[1] . "€";
                    echo '</td>
                                <td class="case">';
                    echo $value[2] * $value[1] . "€";
                    echo '</td>                            
                            </tr>';
                }

                //Affichage du prix total
                echo '<tr><td colspan="5" style="height:20px;"></td></tr>
                        <tr>
                            <th class="tab" colspan ="3">
                                Total:
                            </th>
                            <td class="case" colspan="2" style="color:red; font-size:22px;">';

                //Total du devis
                $a = 0;
                $facture_prix = 0;
                foreach ($result as $value) {
                    $a = $value[2] * $value[1];
                    $facture_prix = $facture_prix + $a;
                }
                echo $facture_prix . "€";
                echo '</td>
                        </tr>
                    </table>';

            // bouton ok : revient en arriere 
                echo '<a href="histo_facture.php"><button class="creer" type = "submit" name = "valider" style="background-color:forestgreen;">Ok</button></a>';
            }
            else{
                
                //si c'est un administrateur
                if (isset($_GET["perid"])) {
                    $p_id = (int) $_GET["perid"];
                }

        ?>
                <!-- Tableau recapitulatif de la facture-->
                <fieldset style="margin-left:5%; margin-right:5%; margin-top:5%;">
                    <legend style="font-size:30px; color:RGB(43, 115, 185);">Détail Facture</legend><br>

        <?php
                    echo '<center><table style="text-align:center; border-collapse:collapse;">
                            <tr class="tab">
                                <th>Nom</th>
                                <th>Quantite</th>
                                <th>Prix unitaire</th>
                                <th>Prix total</th>                        
                            </tr>';


                    //Pour chaque pokemon commande dans la facture on affiche sa quantite et son prix
                    foreach ($result as $value) {
                        echo '<tr>
                                    <td class="case">';
                        echo $value[0];
                        echo '</td>
                                    <td class="case">';
                        echo $value[2];


                        echo '</td>
                                    <td class="case">';
                        echo $value[1] . "€";
                        echo '</td>
                                    <td class="case">';
                        echo $value[2] * $value[1] . "€";
                        echo '</td>                            
                                </tr>';
                    }

                    //Affichage du prix total
                    echo '<tr><td colspan="5" style="height:20px;"></td></tr>
                            <tr>
                                <th class="tab" colspan ="3">
                                    Total:
                                </th>
                                <td class="case" colspan="2" style="color:red; font-size:22px;">';

                    //Total du devis
                    $a = 0;
                    $facture_prix = 0;
                    foreach ($result as $value) {
                        $a = $value[2] * $value[1];
                        $facture_prix = $facture_prix + $a;
                    }
                    echo $facture_prix . "€";
                    echo '</td>
                            </tr>
                        </table>';

                //bouton ok : revient en arriere 
                    echo '<a href="visualisation.php?rang=' . $p_id . '"><button class="creer" type = "submit" name = "valider" style="background-color:forestgreen;">Ok</button></a>';
        ?>
                    </center></fieldset>

        <?php
                }       
        ?>

    </body>

</html>
