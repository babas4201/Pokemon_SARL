<?php
//Page creant un devis/facture en pdf en fonction de l'id du devis dans un onglet
session_start();

include("BD.php");

//si c'est le client
    if($_SESSION['admin'] == 0){

        if (isset($_SESSION["idClient"]) && isset($_SESSION["numero_facture"]) && isset($_GET["rang"])) {

            //Recupeartion de l'id du client
            $p_id = $_SESSION["idClient"];
            $d_id = $_SESSION["numero_facture"][$_GET["rang"]];

            //Connection à la bd
            $bdd = connectionbd();

            //Recuperation des info du client en fonction de l'id
            $requete = "SELECT peNom,pePrenom,peMail,peAdresse FROM personne WHERE peId= :id";
            $variable = array(
                'id' => $p_id,
            );
            $pers = select_bd($bdd, $requete, $variable); //pers[0][0] = nom
            //Info sur le tab pers pour les noms...
            //Recup liste pour facture
            $requete = "SELECT pokemon.poNom, pokemon.poPrix, pokemonfacture.pfQuantite FROM pokemon INNER JOIN pokemonfacture ON pokemon.poId=pokemonfacture.poId INNER JOIN facture ON pokemonfacture.faId=facture.faId WHERE facture.faId= :id;";
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
                            <h1>Facture n°1</h1>
                        </td>
                        <td style="width: 50%; text-align: right;">
                            Emis le <?php echo date("d/m/y"); ?>
                        </td>
                    </tr>
                </table>

                <!-- Tableau recapitulatif des factures-->
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
                        //Pour chaque pokemon commande dans la facture on affiche ça quantite et son prix
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
                <br>
                <p text-align="center">
                    Le chèque d'une valeur de <?php echo $tmp . "€" ?> est à envoyer à l'adresse suivante : 71 Rue Peter Fink, 01000 Bourg-en-Bresse
                </p>
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
                //Genere le pdf sur le navigateur
                $pdf->Output("devis.pdf");
            } catch (HTML2PDF_exception $ex) {
                die($ex);
            }
        }
    }

    //si c'est l'administrateur
    elseif($_SESSION['admin'] == 1){
        
        if (isset($_GET["perid"])) {
            $p_id = (int) $_GET["perid"];            
        }

        if(isset($p_id) && isset($_SESSION["numero_facture"]) && isset($_GET["rang"])){
            $d_id = $_SESSION["numero_facture"][$_GET["rang"]];

            //Connection à la bd
            $bdd = connectionbd();

            //Recuperation des info du client en fonction de l'id
            $requete = "SELECT peNom,pePrenom,peMail,peAdresse FROM personne WHERE peId= :id";
            $variable = array(
                'id' => $p_id,
            );
            $pers = select_bd($bdd, $requete, $variable); //pers[0][0] = nom
            //Info sur le tab pers pour les noms...
            //Recup liste pour facture
            $requete = "SELECT pokemon.poNom, pokemon.poPrix, pokemonfacture.pfQuantite FROM pokemon INNER JOIN pokemonfacture ON pokemon.poId=pokemonfacture.poId INNER JOIN facture ON pokemonfacture.faId=facture.faId WHERE facture.faId= :id;";
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
                            <h1>Facture n°1</h1>
                        </td>
                        <td style="width: 50%; text-align: right;">
                            Emis le <?php echo date("d/m/y"); ?>
                        </td>
                    </tr>
                </table>

                <!-- Tableau recapitulatif des factures-->
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
                        //Pour chaque pokemon commande dans la facture on affiche ça quantite et son prix
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
                <br>
                <p text-align="center">
                    Le chèque d'une valeur de <?php echo $tmp . "€" ?> est à envoyer à l'adresse suivante : 71 Rue Peter Fink, 01000 Bourg-en-Bresse
                </p>
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
                //Genere le pdf sur le navigateur
                $pdf->Output("devis.pdf");
            } catch (HTML2PDF_exception $ex) {
                die($ex);
            }
        }

        
    }
?>
