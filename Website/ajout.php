<?php

//Ajout d'un pokemon dans le panier
//Demarrage de la session
session_start();

//Creation de rang si n'existe pas
if (!isset($_SESSION["rang"])) {
    $_SESSION["rang"] = 0;
}

//Si l'utilisateur est connecte
if (isset($_SESSION['estConnecte'])) {
    if ($_SESSION['estConnecte'] == 1) {
        //Session rang est l'id du pokemon
        $_SESSION["rang"] = $_GET["nbpo"];
        //pokedevis= panier 
        $_SESSION["pokedevis"][$_SESSION["rang"]] = $_GET["nbpo"];
    }
}
header("Location: index.php"); //Redirection
?>
