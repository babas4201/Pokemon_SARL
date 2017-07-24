<?php
//Page d'accueil, page affichant les pokemons pouvant les ajouter ou sup dans le panier 
//Possibilité de faire une recherche de pokemon
//Demarrage de la session
include("BD.php");
//Connection a la bd
$bdd = connectionbd();
?>
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="style.css">
<html>
    <body>

        <?php

            if (isset($_POST["recherche"]) && $_POST["recherche"] != "") {
                $_SESSION["recherche"] = $_POST["recherche"];
            }
            else {
                $_SESSION["recherche"] = null;
            }

            if (!isset($_SESSION["recherche"])) {

            //nb pokemon dans la bd
                $nb_pokemon = select_bd($bdd, "SELECT count(poId) FROM pokemon");

            //parcours toute la bd et on met dans des variable les noms et les img
                for ($i = 1; $i <= $nb_pokemon[0]; $i++) {
                    $requete = "SELECT poNom,poImage,poPrix FROM pokemon where poId= :id";
                    $variable = array(
                        'id' => $i,
                    );
                    $tmp = select_bd($bdd, $requete, $variable);
                    $pok_nom[$i] = $tmp[0][0];
                    $pok_image[$i] = $tmp[0][1];
                    $pok_prix[$i] = $tmp[0][2];
                }

            //nb tot valeurs
                $nb_valeur_tot = $nb_pokemon[0];


            //nb de pok par page
                $nb_value_page = 20;

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

                <fieldset style="margin-left:5%; margin-right:5%; margin-top:5%;">
                    <legend style="font-size:30px; color:RGB(43, 115, 185);">Liste Pokémon</legend><br>             
                        <div style="width:100%;">

                            <form action="#" method = "post" style="text-align: center; margin-top:0px; margin-bottom: 10px;">
                                <input type="text" placeholder="Ex: Bulbizarre" style="width:35%" name="recherche"/>
                                <button class="creer" type = "submit" style="width:26%">Rechercher</button>
                            </form>

        <?php
                            for ($i = $page * $nb_value_page + 1; $i <= $page * $nb_value_page + $nb_value_page; $i = $i + 1) {
                                if ($i <= $nb_valeur_tot) {
                                    echo "<div class='carte'>";
                                    echo '<img class="image" src="' . $pok_image[$i] . '" alt="image"/>' . "<br>";
                                    echo '<div style="font-weight:bold; margin:5px;">' . $pok_nom[$i] . "</div>";
                                    echo '<div style="font-weight:bold; color:red;">' . $pok_prix[$i] . '€</div>';

                                    $bool = 0;
                                    if (isset($_SESSION["pokedevis"])) {
                                        foreach ($_SESSION["pokedevis"] as $value) {
                                            if ($value == $i) {
                                                if (isset($_SESSION["pokedevis"][$i])) {
                                                    echo '<a href="sup.php?nbpo=' . $i . '"  style="color:red;"><button class="creer" type="button" name="suppr" style="background-color:red;">Supprimer</button></a>';
                                                    $bool = 1;
                                                }
                                            }
                                        }
                                    }

                                    if ($bool == 0) {
                                        if (isset($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == 1 && $_SESSION['admin'] == 0) {
                                            echo '<a href="ajout.php?nbpo=' . $i . '" style="color:forestgreen;"><button class="creer" type="button" name="ajout" style="background-color:forestgreen;">Ajouter</button></a>';
                                        }
                                    }
                                    echo "</div>";
                                }
                            }
                        echo "</div>";



                        //gestionnaire des pages
                        //première page avec moins de 20 pokemons
                        if($page == 0 && $nb_valeur_tot <= 20){

                        }
                        //Premiere page avec plus de 20 pokemons
                        elseif ($page == 0 && $nb_valeur_tot > 20) {
        ?>      
                            <center><a href="?page=<?php echo $page + 1; ?>"><button class="creer" type="button" name="suivant">Suivant</button></a>
                                <a href="?page=<?php echo (int) $nb_page; ?>"><button class="creer" type="button" name="fin">Fin</button></a></center>
        <?php
                        }
                        //Derniere page
                        elseif ($page == (int) $nb_page) {
                  
        ?>      
                        <center><a href="?page=0"><button class="creer" type="button" name="debut" style="margin-left:92.5px;">Début</button></a>
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

            //nb pokemon dans la bd correspondant a la recherche
                $requete = "SELECT count(poId) FROM pokemon WHERE poNom like :recherche";
                $variable = array(
                    'recherche' => $_SESSION["recherche"] . "%",
                );
                $nb_pokemon = select_bd($bdd, $requete, $variable);

                if ((int) $nb_pokemon[0][0] >= 1) {
                    
                //Stockage des id des pokemon correspondant a la recherche
                    $requete = "SELECT  poNom,poImage,poPrix,poId FROM pokemon WHERE poNom like :recherche";
                    $variable = array(
                        'recherche' => $_SESSION["recherche"] . "%",
                    );
                    $pokerecherche = select_bd($bdd, $requete, $variable);
                    
                //Tableau d'affichage
        ?> 

                    <fieldset style="margin-left:5%; margin-right:5%; margin-top:5%;">
                        <legend style="font-size:30px; color:RGB(43, 115, 185);">Liste Pokémon</legend><br>             
                            <div style="width:100%; ">

                                <form action="" method = "post" style="text-align: center; margin-top:0px; margin-bottom: 10px;">
                                    <input type="text" placeholder="Ex: Bulbizarre" style="width:35%" name="recherche"/>
                                    <button class="creer" type = "submit" style="width:26%">Rechercher</button>
                                </form>  

        <?php
                                foreach ($pokerecherche as $pok) {
                                    echo "<div class='carte'>";
                                    echo '<img class="image" src="' . $pok[1] . '" alt="image"/>' . "<br>";
                                    echo '<div style="font-weight:bold; margin:5px;">' . $pok[0] . "</div>";
                                    echo '<div style="font-weight:bold; color:red;">' . $pok[2] . '€</div>';

                                    $bool = 0;
                                    if (isset($_SESSION["pokedevis"])) {
                                        foreach ($_SESSION["pokedevis"] as $value) {
                                            if ($value == $pok[3]) {
                                                if (isset($_SESSION["pokedevis"][$pok[3]])) {
                                                    echo '<a href="sup.php?nbpo=' . $pok[3] . '"  style="color:red;"><button class="creer" type="button" name="suppr" style="background-color:red;">Supprimer</button></a>';
                                                    $bool = 1;
                                                }
                                            }
                                        }
                                    }

                                    if ($bool == 0) {
                                        if (isset($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == 1 && $_SESSION['admin'] == 0) {
                                            echo '<a href="ajout.php?nbpo=' . $pok[3] . '" style="color:forestgreen;"><button class="creer" type="button" name="ajout" style="background-color:forestgreen;">Ajouter</button></a>';
                                        }
                                    }
                                    echo "</div>";
                                }
                                echo "</div>";
        ?>
                            </fieldset>


        <?php
                } 
                else {
                    echo "<center>Aucun élement correspond à votre recherche<br> <a href='index.php'><button class='creer' type='button' name='ici' style='background-color:red;'>cliquez ici pour revevenir</button></a></center>";
                }
            }
        ?>

    </body>

</html>