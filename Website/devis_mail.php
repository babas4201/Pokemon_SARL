<?php
//Page creant un devis en pdf en fonction de l'id du devis l'enregistre en pdf et l'envoie par mail au destinataire
session_start();

include("BD.php");

if (isset($_SESSION["idClient"]) && isset($_SESSION["numero_devis"]) && isset($_GET["rg"])) {

    //Recuperation de l'id du client
    $p_id = $_SESSION["idClient"];
    $d_id = $_SESSION["numero_devis"][$_GET["rg"]];

    //Connection à la bd
    $bdd = connectionbd();

    //Recuperation des info du client en fonction de l'id
    $requete = "SELECT peNom,pePrenom,peMail,peAdresse FROM personne WHERE peId= :id";
    $variable = array(
        'id' => $p_id,
    );
    $pers = select_bd($bdd, $requete, $variable); //pers[0][0] = nom
    //Info sur le tab pers pour les noms...
    //Recup liste pour devis
    $requete = "SELECT pokemon.poNom, pokemon.poPrix, pokemondevis.pdQuantite FROM pokemon INNER JOIN pokemondevis ON pokemon.poId=pokemondevis.poId INNER JOIN devis ON pokemondevis.deId=devis.deId WHERE devis.deId= :id;";
    $var = array(
        'id' => $d_id,
    );
    $result = select_bd($bdd, $requete, $var);

    //Commencement de l'enregistrement dans une variable
    ob_start();
    ?>

    <style type="text/css">
        table{
            border-collapse: collapse;
            width: 100%;
            color: #717375;   
            font-size: 12pt;
            font-family: helvetica;
            line-height: 6mm;
        }
        table strong{
            color: #000;
        }
        h1{
            color: #000;
            margin: 0;
            padding: 0;
        }
        table.border td{
            border:1px solid CFD1D2;
            padding: 3mm 1mm;
        }
        table.border th,td.black{
            background: #000;
            color: #FFF;
            font-weight: normal;
            border:solid 1px #FFF;
            padding: 1mm 1mm;
            text-align: center;
        }
        td.centre{
            text-align: center;
        }
        td.noborder{
            border:none;
        }

    </style>

    <page backtop="20mm" backleft="10mm" backright="10mm" footer="page; date;">
        <!-- Pied de page -->
        <page_footer>
            <hr />
            <h1>Bon de commande : Societé POKEMON-SARL</h1>
            <p>
                Date : <?php echo date("d/m/y"); ?>
            </p>
        </page_footer>

        <table>
            <tr>

                <!-- Information perso-->
                <td style="width: 75%">
                    SARL Pokemon, <br>
                    71 Rue Peter Fink,<br>
                    01000 Bourg-en-Bresse,<br>
                    FRANCE<br>
                    E-mail: pokemon@email.cm
                </td>

                <!-- Information client-->
                <td style="width: 25%">
    <?php echo "<br>" . $pers[0][0] . " " . $pers[0][1] . ", <br>" . $pers[0][3] . ", <br>" . $pers[0][2];
    ?>
                </td>
            </tr>
        </table>

        <!-- Titre -->
        <table style="vertical-align: bottom; margin-top:20mm; ">
            <tr>
                <td style="width: 50%">
                    <h1>Devis n°1</h1>
                </td>
                <td style="width: 50%; text-align: right;">
                    Emis le <?php echo date("d/m/y"); ?>
                </td>
            </tr>
        </table>

        <!-- Tableau recapitulatif des devis-->
        <table class="border">
            <thead>
                <tr>
                    <th style="width: 55%">Nom Pokemon </th>
                    <th style="width: 11%">Quantite</th>
                    <th style="width: 17%">Prix unitaire </th>
                    <th style="width: 17%">Montant</th>
                </tr>
            </thead>

            <tbody> 
    <?php
    //Pour chaque pokemon commande dans le panier on affiche ça quantite et son prix
    foreach ($result as $value) {
        ?>
                    <tr>
                        <td>
        <?php
        echo $value[0];
        ?>
                        </td>
                        <td class="centre">
        <?php
        echo $value[2];
        ?>
                        </td>
                        <td class="centre">
        <?php
        echo $value[1] . "€";
        ?>
                        </td>
                        <td class="centre">
        <?php
        echo $value[2] * $value[1] . "€";
        ?>
                        </td>
                    </tr>
        <?php
    }
    ?>
                <tr>
                    <td colspan="2" class="noborder">                        
                    </td>
                    <td class="black">
                        Total:
                    </td>
                    <td class="centre">
    <?php
    //Total du devis
    $a = 0;
    $tmp = 0;
    foreach ($result as $value) {
        $a = $value[2] * $value[1];
        $tmp = $tmp + $a;
    }
    echo $tmp . "€";  /* utiliser number_format(..,2) */
    ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </page>

    <?php
    //On met tout le code html dans content
    $content = ob_get_clean();

    //Include de la bibliothèque
    require("HTML2PDF_2/html2pdf.class.php");

    //Exception si erreur
    try {
        //p=paysage(a4 normal) l=portrait  fr pour date par exemple
        //Creation de l'objet
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        //Choisir son display mode page entiere
        $pdf->pdf->SetDisplayMode('fullpage');
        //Ecrit dans le pdf
        $pdf->writeHTML($content);
        //Genere le pdf sur le dossier suivant
        //$pdf->Output("devis/devis_0.pdf", 'F');
        ob_clean();
        //Genere le pdf sur l'ordi pour ensuite l'envoyé
        $pdf->Output("devis/devis_" . $p_id . "_" . $d_id . ".pdf", 'F');
    } catch (HTML2PDF_exception $ex) {
        die($ex);
    }
}

$lien = "devis/devis_" . $p_id . "_" . $d_id . ".pdf";
$nom_pdf = "devis_" . $p_id . "_" . $d_id . ".pdf";


//Envoyer par mail comment
$mail = $pers[0][2]; // Déclaration de l'adresse de destination.

if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) { // On filtre les serveurs qui présentent des bogues.
    $passage_ligne = "\r\n";
} else {
    $passage_ligne = "\n";
}

//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "Bonjour, voici un e-mail envoye automatiquement avec piece jointe contenant votre devis.";
$message_html = "<html><head></head><body><b>Bonjour</b>,<br> voici un e-mail envoye automatiquement,<br> ci-joint vous pouvez trouver votre devis.<br>Cordialement, <br>SARL POKEMON</body></html>";
//==========
//=====Lecture et mise en forme de la pièce jointe.
$fichier = fopen($lien, "r");
$attachement = fread($fichier, filesize($lien));
$attachement = chunk_split(base64_encode($attachement));
fclose($fichier);
//==========
//=====Création de la boundary.
$boundary = "-----=" . md5(rand());
$boundary_alt = "-----=" . md5(rand());
//==========
//=====Définition du sujet.
$sujet = "SARL_Pokemon Devis";
//=========
//=====Création du header de l'e-mail.
$header = "From: \"SARL_Pokemon\"<sarl_pokemon@sfr.fr>" . $passage_ligne;
$header.= "Reply-to: \"SARL_Pokemon\" <sarl_pokemon@sfr.fr>" . $passage_ligne;
$header.= "MIME-Version: 1.0" . $passage_ligne;
$header.= "Content-Type: multipart/alternative;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;
//==========
//=====Création du message.
$message = $passage_ligne . "--" . $boundary . $passage_ligne;
$message.= "Content-Type: multipart/alternative;" . $passage_ligne . " boundary=\"$boundary_alt\"" . $passage_ligne;
$message.= $passage_ligne . "--" . $boundary_alt . $passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"" . $passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
$message.= $passage_ligne . $message_txt . $passage_ligne;
//==========

$message.= $passage_ligne . "--" . $boundary_alt . $passage_ligne;

//=====Ajout du message au format HTML.
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
$message.= $passage_ligne . $message_html . $passage_ligne;
//==========
//=====On ferme la boundary alternative.
$message.= $passage_ligne . "--" . $boundary_alt . "--" . $passage_ligne;
//==========



$message.= $passage_ligne . "--" . $boundary . $passage_ligne;

//=====Ajout de la pièce jointe.
$message.= "Content-Type: text/plain; name=$nom_pdf" . $passage_ligne;
$message.= "Content-Transfer-Encoding: base64" . $passage_ligne;
$message.= "Content-Disposition: attachment; filename=$nom_pdf" . $passage_ligne;
$message.= $passage_ligne . $attachement . $passage_ligne . $passage_ligne;
$message.= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
//========== 


//=====Envoi de l'e-mail.
if (mail($mail, $sujet, $message, $header)) {
    header('Location: devis_en_cours.php');
    $_SESSION["envoi_mail"] = "Votre email contenant le devis a bien été envoyé";
} else {
    $_SESSION["envoi_mail"] = "L'envoi a échoué réessayer plus tard";
    header('Location: devis_en_cours.php');
}
?>


