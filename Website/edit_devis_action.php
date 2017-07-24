<?php

//Page supprime le devis si le prix est a 0 c'est a dire aucun pokemon ou met a jour le prix
session_start();

include("BD.php");

    if (isset($_SESSION["dev_prix"])) {
        if ($_SESSION["dev_prix"] == 0) {
            $bdd = connectionbd();

            //nb pokemon dans la bd
            $requete = "DELETE FROM devis WHERE deId= :id";
            $variable = array(
                'id' => (int) $_SESSION["de_id"]
            );
            update_delete_bd($bdd, $requete, $variable);
        } 
        else {
            //Connection a la bd
            $bdd = connectionbd();
            //nb pokemon dans la bd
            $requete = "UPDATE devis SET dePrix = :prix WHERE deId= :id";
            $variable = array(
                'prix' => (int) $_SESSION["dev_prix"],
                'id' => (int) $_SESSION["de_id"]
            );
            update_delete_bd($bdd, $requete, $variable);
        }
        $_SESSION["dev_prix"] = null;
        $_SESSION["de_id"] = null;
    }
    header('Location: devis_en_cours.php');
    
    if(isset($_GET['devn'])){
        if ($_SESSION["dev_prix"] == 0) {
            $bdd = connectionbd();

            //nb pokemon dans la bd
            $requete = "DELETE FROM devis WHERE deId= :id";
            $variable = array(
                'id' => (int) $_SESSION["de_id"]
            );
            update_delete_bd($bdd, $requete, $variable);
        } 
        else {
            //Connection a la bd
            $bdd = connectionbd();
            //nb pokemon dans la bd
            $requete = "UPDATE devis SET dePrix = :prix WHERE deId= :id";
            $variable = array(
                'prix' => (int) $_SESSION["dev_prix"],
                'id' => (int) $_SESSION["de_id"]
            );
            update_delete_bd($bdd, $requete, $variable);
        }
        $_SESSION["dev_prix"] = null;
        $_SESSION["de_id"] = null;
    }
    header('Location: histo_devis.php');
   
?>
