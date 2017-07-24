<?php
//Affichage des données de la facure

include("BD.php");

//Traitement de la variable get qui permet de connaitre l'id du devis
$dev_id = 0;
if (isset($_GET["devn"])) {
    $dev_id = (int) $_GET["devn"];
}

//Connection à la bd
$bdd = connectionbd();

//Recup liste pour devis
$requete = "SELECT pokemon.poNom, pokemon.poPrix, pokemondevis.pdQuantite, pokemondevis.deId, pokemondevis.poId FROM pokemon INNER JOIN pokemondevis ON pokemon.poId=pokemondevis.poId INNER JOIN devis ON pokemondevis.deId=devis.deId WHERE devis.deId= :id;";
$var = array(
    'id' => $dev_id,
);
$result = select_bd($bdd, $requete, $var);
?>
<!DOCTYPE html>
<html>

    <?php
    include('entete.php');
    ?>

    <body>     

        <!-- Tableau recapitulatif du devis-->
        <fieldset style="margin-left:5%; margin-right:5%; margin-top:5%;">
            <legend style="font-size:30px; color:RGB(43, 115, 185);">Détail Devis</legend><br>

            <?php
            echo '<center><table style="text-align:center; border-collapse:collapse;">
                    <tr class="tab">
                        <th>Nom</th>
                        <th>Quantite</th>
                        <th>Prix unitaire</th>
                        <th>Prix total</th>                        
                    </tr>';


            //Pour chaque pokemon commande dans le devis on affiche sa quantite et son prix
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
            ?>

            <!-- bouton ok : revient en arriere -->
            <button class="creer" type = "submit" name = "valider" style="background-color:forestgreen;" onclick="document.location.href = 'histo_devis.php'">Ok</button>
            </center></fieldset>

    </body>

</html>
