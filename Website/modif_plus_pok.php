<?php

//Ajout d'une quantite de pokemon du devis
//Demarrage session
session_start();

include("BD.php");

if (isset($_SESSION)) {

    //Connexion a la BD
    $bdd = connectionbd();

    //Ajout dans le BD d'un pokemon en fonction des ID
    $requete = "UPDATE pokemondevis SET pdQuantite=pdQuantite+1 WHERE deId= :id1 AND poID= :id2";
    $variable = array(
        'id1' => $_GET["devn"],
        'id2' => $_GET["pokn"],
    );

    update_delete_bd($bdd, $requete, $variable);

    header("location: edit_devis.php?devn=" . $_GET["devn"]);
}
?>
