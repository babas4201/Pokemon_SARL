<!DOCTYPE html>
<html>
    <?php
    //Affichage du panier avec l'intégralité des pokemon selectionner si aucun pokemon alors on a un lien vers l'acceuil
    include('entete.php');

    $nbpokemondanspanier = 0; //Compte le nb de pokemon

    //Si la session existe alors
    $verification = 0;
    if (isset($_SESSION["pokedevis"])) {
        foreach ($_SESSION["pokedevis"] as $verif) {
            if ($verif != null) {
                $verification = 1;
            }
        }
    }
    if ($verification == 0) {
        $_SESSION["pokedevis"] = null;
    }
    if (isset($_SESSION)) {
        if (isset($_SESSION["pokedevis"])) {
            include("BD.php");
            $bdd = connectionbd();
            foreach ($_SESSION["pokedevis"] as $valeur) {
                if ($valeur != 0 && $valeur != null) {
                    //echo $valeur;
                    $requete = "SELECT poNom,poImage,poPrix FROM pokemon where poId= :id";
                    $variable = array(
                        'id' => $valeur,
                    );
                    $tmp = select_bd($bdd, $requete, $variable);
                    $pok_nom[$nbpokemondanspanier] = $tmp[0][0];
                    $pok_image[$nbpokemondanspanier] = $tmp[0][1];
                    $pok_prix[$nbpokemondanspanier] = $tmp[0][2];
                    $nbpokemondanspanier++;
                }
            }


            //nb tot valeurs
            $nb_valeur_tot = $nbpokemondanspanier;
            //nb de pok par page
            $nb_value_page = 5;

            //nb de page
            $nb_page = $nb_valeur_tot / $nb_value_page;

            //par defaut page 0
            if (!isset($_GET['page'])) {
                $page = 0;
            } else {
                $page = $_GET['page'];
            }
            //Tableau d'affichage
            ?>

            <body>

                <fieldset style="margin-left:5%; margin-right:5%; margin-top:5%;">
                    <legend style="font-size:30px; color:RGB(43, 115, 185);">Panier</legend><br>
                    <center><table style="text-align:center; border-collapse:collapse;">
                            <tr class="tab">
                                <th>Nom</th>
                                <th>Image</th>
                                <th>Prix</th>
                            </tr>
                            <?php
                            for ($i = $page * $nb_value_page; $i < $page * $nb_value_page + $nb_value_page; $i = $i + 1) {
                                if ($i < $nb_valeur_tot) {
                                    ?>
                                    <tr>
                                        <td class="case">
                                            <?php echo $pok_nom[$i];
                                            ?>
                                        </td>
                                        <td class="case">
                                            <?php
                                            echo '<img src="' . $pok_image[$i] . '"/>';
                                            ?> 
                                        </td>
                                        <td class="case">
                                            <?php
                                            echo $pok_prix[$i];
                                            ?>
                                        </td>
                                    </tr>


                                    <?php
                                }
                            }
                            ?>
                        </table>

                        <form method="post" action="creation_devis_action.php"> 
                            <!-- bouton creation de devis -->
                            <button class="creer" type = "submit" name = "devis" style="background-color:forestgreen;">Création Devis</button>
                        </form>

        <?php
                        //gestionnaire des pages
                        //premiere page avec moins de 5 pokemons
                        if($page == 0 && $nb_valeur_tot <= 5){

                        }
                        //Premiere page avec plus de 5 pokemons
                        elseif ($page == 0 && $nb_valeur_tot > 5) {
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
                    </center></fieldset>

            </body>
        </html>

        <?php
        //Si aucun devis alors proposition de redirection
    } else {
        echo '<center>La panier est vide !<br> Sélectionner des Pokémons <a href="index.php"><button class="creer" type="button" name="ici" style="background-color:red;">ici</button></a></center>';
    }
}
?>