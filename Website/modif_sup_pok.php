<?php

//Suppresion d'un pokemon d'un devis
//Demarrage session
session_start();
include("BD.php");

if (isset($_SESSION)) {

    //Connextion a la BD
    $bdd = connectionbd();

    //Suppression du pokemon 
    $requete = "DELETE FROM pokemondevis WHERE deId= :id1 AND poID= :id2";
    $variable = array(
        'id1' => $_GET["devn"],
        'id2' => $_GET["pokn"],
    );
    update_delete_bd($bdd, $requete, $variable);

    //Redirection        
    header("location: edit_devis.php?devn=" . $_GET["devn"]);
}
?>
