<?php
    //Information de connection
    $host="localhost";
    $dbname="pokemon_placement";
    $pseudo="root";
    $mdp="";
    /**** Connection a Mysql ****/
    try
    {//Permet aussi de detailler l'erreur
            $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $pseudo, $mdp,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }

for($i=0;$i<152;$i++){
    //$lien='C:/wamp64/www/PHP_Project/Pokemon_Placement/img/'.$i.'.png';
    $lien='img/'.$i.'.png';
    $reqprepa= $bdd->prepare('UPDATE pokemon SET poImage = :lien WHERE poId = :id');
        $reqprepa->execute(array(
           'lien'=>$lien,
           'id' => $i
        )); 
    echo $i;
}