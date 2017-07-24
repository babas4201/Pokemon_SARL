<?php

//Suppression d'un pokemon du panier

session_start();


if (isset($_SESSION["connexion"])) {
    $g = (int) $_GET["nbpo"];
    $_SESSION["pokedevis"][$g] = null;
}
header("Location: index.php"); //Redirection
?>
