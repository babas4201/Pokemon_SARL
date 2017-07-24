<?php
//Edition et modification du devis pour ajuster le nombre de pokemon voulu

include("BD.php");

//Traitement de la variable get qui permet de connaitre l'id du devis
$de_id = 0;
if (isset($_GET["devn"])) {
    $de_id = (int) $_GET["devn"];
}

//Connection à la bd
$bdd = connectionbd();

//Recup liste pour devis
$requete = "SELECT pokemon.poNom, pokemon.poPrix, pokemondevis.pdQuantite, pokemondevis.deId, pokemondevis.poId FROM pokemon INNER JOIN pokemondevis ON pokemon.poId=pokemondevis.poId INNER JOIN devis ON pokemondevis.deId=devis.deId WHERE devis.deId= :id;";
$var = array(
    'id' => $de_id,
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
            <legend style="font-size:30px; color:RGB(43, 115, 185);">Modification Devis</legend><br>

            <?php
            echo '<center><table style="text-align:center; border-collapse:collapse;">
                    <tr class="tab">
                        <th>Nom</th>
                        <th>Quantite</th>
                        <th>Prix unitaire</th>
                        <th>Prix total</th>                        
                    </tr>';


            //Pour chaque pokemon commande dans le panier on affiche sa quantite et son prix
            foreach ($result as $value) {
                echo '<tr>
                            <td class="case">';
                echo $value[0];
                echo '</td>
                            <td class="case">';
                echo $value[2];

                //Envoi de l'ajout ou de la suppression d'un pokemon
                if ($value[2] > 0) {
                    echo '<a href="modif_moins_pok.php?devn=' . $value[3] . '&pokn=' . $value[4] . '"><button class="creer" type="button" name="moins" style="margin-left:5%;">-</button></a>
                        <a href="modif_plus_pok.php?devn=' . $value[3] . '&pokn=' . $value[4] . '"><button class="creer" type="button" name="plus">+</button></a>';
                } else {
                    echo '<a href="modif_plus_pok.php?devn=' . $value[3] . '&pokn=' . $value[4] . '"/><button class="creer" type="button" name="plus">+</button></a>';
                    echo '<a href="modif_sup_pok.php?devn=' . $value[3] . '&pokn=' . $value[4] . '"/><button class="creer" type="button" name="supprimer" style="background-color:red;">Supprimer</button></a>';
                }
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
            $dev_prix = 0;
            foreach ($result as $value) {
                $a = $value[2] * $value[1];
                $dev_prix = $dev_prix + $a;
            }
            echo $dev_prix . "€";
            $_SESSION["dev_prix"] = $dev_prix;
            $_SESSION["de_id"] = $de_id;
            echo '</td>
                    </tr>
                </table>';

            //bouton valider : enregistrer les modifications
            echo '<a href="edit_devis_action.php?devn='. $de_id . '"><button class="creer" type = "submit" name = "valider" style="background-color:forestgreen;">Valider</button></a>';

        ?>
            </center></fieldset>

    </body>

</html>
