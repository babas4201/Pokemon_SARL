<?php

//Page permettant de generer une facture en fonction d'un devis.
//Entre dans la base de donnees facturepokemon et facture
session_start();

    include("BD.php");

    $numero_devis = htmlentities($_GET["devn"]);

    if (is_numeric($numero_devis)) {

        //Connection à la bd
        $bdd = connectionbd();

        //Recup les infos du devis
        $requete = "SELECT * FROM devis WHERE devis.deId= :id";
        $var = array(
            'id' => $numero_devis,
        );
        $result = select_bd($bdd, $requete, $var);

        //Modifier l'etat du devis
        $requete = "UPDATE devis SET deEtat = 1 WHERE devis.deId = :id";
        $var = array(
            'id' => $numero_devis,
        );
        update_delete_bd($bdd, $requete, $var);
        
        //Insert les infos du devis dans facture   
        $requete = "INSERT INTO facture (faId,deId,peId,faAdresse,faPrix,faDate) VALUES (DEFAULT,:deId,:peId,:faAdresse,:faPrix,NOW());";
        $var = array(
            'deId' => $numero_devis,
            'peId' => $result[0][1], //Id personne
            'faAdresse' => $result[0][2], //Adresse personne
            'faPrix' => $result[0][3], //Prix
        );
        insert_bd($bdd, $requete, $var);

        //Recuperation de l'id de la facture
        $requete = "SELECT LAST_INSERT_ID() FROM facture";
        $last_id = select_bd($bdd, $requete);

        //Recupère les pokemons du devis
        $requete = "SELECT * FROM pokemondevis WHERE deId= :id;";
        $var = array(
            'id' => $numero_devis,
        );
        $pokemon_devis_facture = select_bd($bdd, $requete, $var);

        //Insert les pokemons dans facturepokemon
        foreach ($pokemon_devis_facture as $poke) {
            $requete = "INSERT INTO pokemonfacture (faId,poId,pfQuantite) VALUES (:id,:poId,:quantite);";
            $var = array(
                'id' => $last_id[0],
                'poId' => $poke[1], //Id du pokemon
                'quantite' => $poke[2], //Quantite du pokemon
            );
            insert_bd($bdd, $requete, $var);
        }
    }

    header("Location: index.php");
?>
