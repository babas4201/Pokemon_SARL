<?php

//Suppression d'une quantite de pokemon du devis
//Demarrage de la ssion
session_start();
include("BD.php");

//Si session existe
if (isset($_SESSION)) {
//Connection a la bd
    $bdd = connectionbd();

//Selection de la quantité pour modification en fonction de l'id du pokemon et de l'id du client
    $req = "SELECT pdQuantite FROM pokemondevis WHERE deId= :id1 AND poID= :id2";
    $var = array(
        'id1' => $_GET["devn"],
        'id2' => $_GET["pokn"],
    );

    $nbpokerestant = select_bd($bdd, $req, $var);
    //Transtype en int
    $rest = intval($nbpokerestant[0][0]);

    //Si le $rest est positif alors on update dans la BD
    if ($rest > 0) {
        $requete = "UPDATE pokemondevis SET pdQuantite=pdQuantite-1 WHERE deId= :id1 AND poID= :id2";
        $variable = array(
            'id1' => $_GET["devn"],
            'id2' => $_GET["pokn"],
        );
        update_delete_bd($bdd, $requete, $variable);
    }

//Redirection avec l'id du devis
    header("location: edit_devis.php?devn=" . $_GET["devn"]);
}
?>
