<?php

//Page permettant la création du devis en fonction du panier,
//Remet à 0 la variable de panier
//Redirige vers la liste des devis
//Met a jour le prix du devis
//Demarrage session
session_start();

include("BD.php");

    if (isset($_SESSION)) {
        if (isset($_SESSION["pokedevis"]) && isset($_SESSION["idClient"])) {
            $bdd = connectionbd();
            $requete = "SELECT peAdresse FROM personne WHERE peId= :id;";
            $var = array(
                'id' => $_SESSION["idClient"],
            );
            $result = select_bd($bdd, $requete, $var);

            $prix_devis = 0;
            foreach ($_SESSION["pokedevis"] as $a) {
                $requete = "SELECT poPrix FROM pokemon WHERE poId= :id;";
                $var = array(
                    'id' => $a,
                );
                $resultat_prix = select_bd($bdd, $requete, $var);
                $prix_devis = $prix_devis + $resultat_prix[0][0];
            }




            $requete = "INSERT INTO devis(deId,peId,deAdresse,dePrix,deDate) VALUES(DEFAULT,:peId,:peAdresse,:pePrix,NOW())";
            $variable = array(
                'peId' => $_SESSION["idClient"],
                'peAdresse' => $result[0][0],
                'pePrix' => $prix_devis
            );
            insert_bd($bdd, $requete, $variable);

            $requete = "SELECT LAST_INSERT_ID() FROM devis";
            $last_id = select_bd($bdd, $requete);

            foreach ($_SESSION["pokedevis"] as $valeur) {
                if ($valeur != 0) {
                    $requete = "INSERT INTO pokemondevis(deId,poId,pdQuantite) VALUES(:deId,:poId,1)";
                    $variable = array(
                        'deId' => $last_id[0],
                        'poId' => $valeur,
                    );
                    insert_bd($bdd, $requete, $variable);
                }
            }
            $_SESSION["pokedevis"] = null;
        }
    }
    header("Location: devis_en_cours.php");
?>
