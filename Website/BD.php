<?php
//page regroupant les fonction de la BD
function connectionbd() {
    include("param.inc.php");
    /*     * ** Connection a Mysql *** */
    try {//Permet aussi de detailler l'erreur
        $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $pseudo, $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $bdd;
}

//Fonction pour demandé des données
function select_bd($bdd, $requete, $variable = null) {

    if (isset($variable)) {
        $requeteprepa = $bdd->prepare($requete);
        $requeteprepa->execute($variable);
        $donnes = $requeteprepa->fetchAll();
        return $donnes;
    } else {
        $reponse = $bdd->query($requete);
        $donnes = $reponse->fetch();
        return $donnes;
    }
}

//fonction pour insérer dans la base de données
function resultat($bdd, $request) {
    $bdd->query($request);
}

//Fonction permettant de mettre a jour une ligne
function update_delete_bd($bdd, $requete, $variable) {
    $requeteprepa = $bdd->prepare($requete);
    $requeteprepa->execute($variable);
}

function insert_bd($bdd, $requete, $variable) {
    $requeteprepa = $bdd->prepare($requete);
    $requeteprepa->execute($variable);
}
