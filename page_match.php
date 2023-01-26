<!DOCTYPE html>
<html lang="en" style="font-family: Arial,sans-serif;">
<?php
require('fonctions.php');
is_logged();
?>

<head>
    <meta charset="UTF-8">
    <title>Page matchs</title>
    <link rel="stylesheet" href="style_match.css">
    <link rel="stylesheet" href="style_header.css">
</head>

<body>
    <?php
    ///Connexion au serveur MySQL
    try {
        $linkpdo = new PDO("mysql:host=localhost;dbname=bddprojetsport", "root", "");
    }
    ///Capture des erreurs éventuelles
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    ?>
    <header>
        <div>
            <a href="page_accueil.php">
                <img class="img_header" src="projet_photos/sticker-basket---joueur-n-5.png" alt="">
                <h1>BALL MANAGEMENT</h1>
            </a>
            <nav>
                <ul>
                    <li class="deroulant rubrique"><a href="page_joueur.php">Joueurs &ensp;</a>
                        <ul class="sous">
                            <li><a href="page_joueur.php">Tous les joueurs</a></li>
                            <li><a href="page_add_joueur.php">Ajouter un joueur</a></li>
                        </ul>
                    </li>
                    <li class="deroulant rubrique"><a href="page_match.php">Matchs &ensp;</a>
                        <ul class="sous">
                            <li><a href="page_match.php">Tous les matchs</a></li>
                            <li><a href="page_add_match.php">Ajouter un match</a></li>
                        </ul>
                    </li>
                    <li class="deroulant rubrique"><a href="page_stat.php">Statistique &ensp;</a>
                        <ul class="sous">
                            <li><a href="page_Statistique_match.php">Statistique par matchs</a></li>
                            <li><a href="page_Statistique_joueur.php">Statistique par joueur</a></li>
                        </ul>
                    </li>
                    <li><a href="page_connection.php?session_destroy():true">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="menu_match">
            <div class="list_page">
                <form action="page_add_match.php">
                    <button type="submit">ajouter un match</button>
                </form>
            </div>
            <div class="list_page">
                <center>
                    <h2>Liste des matchs à venir </h2>
                </center>
                <hr class="dashed">
                <?php
                ///Sélection de tout le contenu de la table enfant
                try {
                    $res = $linkpdo->query('SELECT Id_le_match,equipe_adverse, date_match,resultat FROM `le_match`  WHERE date_match > CURRENT_DATE()  and statut = 1;');
                } catch (Exception $e) { // toujours faire un test de retour en cas de crash
                    die('Erreur : ' . $e->getMessage());
                }

                ///Affichage des entrées du résultat une à une

                $double_tab = $res->fetchAll(); // je met le result de ma query dans un double tableau
                $nombre_ligne = $res->rowCount();
                $liste = array();
                echo "<table>";
                echo "<tr>";
                echo "<th>Equipe adverse</th>";
                echo "<th>Date</th>";
                echo "<th>Score</th>";
                echo "</tr>";


                for ($i = 0; $i < $nombre_ligne; $i++) {
                    for ($y = 1; $y < 3; $y++) {
                        echo "<td>";
                        print_r($double_tab[$i][$y]);
                        $liste[$y] = $double_tab[$i][$y];
                        $nom = $double_tab[$i][1];
                        $prenom = $double_tab[$i][2];
                        $Score = $double_tab[$i][3];
                        echo "</td>";
                    }
                    $id_match = $double_tab[$i][0];
                    $ScoreF  = "Match non joué";

                    echo "<td>";
                    echo $ScoreF;
                    echo "</td>";
                    echo "<td>";

                    echo '<a href="page_match_detail.php?id=' . $id_match . '"><button class="acceder">acceder</button></a>';
                    /*echo '<a href="page_feuille_de_match.php?id_match=' . $id_match .'"> <button class="equipe">Equipe</button> </a>';*/
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";

                ///Fermeture du curseur d'analyse des résultats
                $res->closeCursor();
                ?>
            </div>

            <div class="list_page">
                <center>
                    <h2>Liste des matchs qui on eu lieu</h2>
                </center>
                <hr class="dashed">
                <?php
                // 
                ///Sélection de tout le contenu de la table enfant
                try {
                    $res = $linkpdo->query('SELECT Id_le_match,equipe_adverse, date_match,resultat FROM `le_match`  WHERE date_match < CURRENT_DATE() and statut = 1;');
                } catch (Exception $e) { // toujours faire un test de retour en cas de crash
                    die('Erreur : ' . $e->getMessage());
                }

                ///Affichage des entrées du résultat une à une

                $double_tab = $res->fetchAll(); // je met le result de ma query dans un double tableau
                $nombre_ligne = $res->rowCount();
                $liste = array();
                echo "<table>";
                echo "<tr>";
                echo "<th>Equipe adverse</th>";
                echo "<th>Date</th>";
                echo "<th>Score</th>";
                echo "</tr>";

                for ($i = 0; $i < $nombre_ligne; $i++) {
                    for ($y = 1; $y < 3; $y++) {
                        echo "<td>";
                        print_r($double_tab[$i][$y]);
                        $liste[$y] = $double_tab[$i][$y];
                        $nom = $double_tab[$i][1];
                        $prenom = $double_tab[$i][2];
                        $Score = $double_tab[$i][3];
                        echo "</td>";
                    }
                    $id_match = $double_tab[$i][0];

                    if ($Score == null) {
                        //score non renseigné
                        $ScoreF  = "Score non renseigné";
                    } else {
                        //score renseigné
                        $ScoreF = explode("-", $Score);
                    }
                    //afficher le score
                    echo "<td>";
                    echo $ScoreF[0] . " - " . $ScoreF[1];
                    echo "</td>";
                    echo "<td>";


                    echo '<a href="page_match_detail.php?id=' . $id_match . '"><button class="acceder">acceder</button></a>';
                    /*echo '<a href="page_feuille_de_match.php?id_match=' . $id_match .'"> <button class="equipe">Equipe</button> </a>';*/
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";

                ///Fermeture du curseur d'analyse des résultats
                $res->closeCursor();

                ?>
            </div>


            <div class="list_page">

                <center>
                    <h2>Liste des matchs en préparation</h2>
                </center>
                <hr class="dashed">
                <?php
                //affichage des match en préparation mais pas fini donc les matchs avec le statut a 0
                $requeteS = "SELECT Id_le_match,equipe_adverse, date_match,resultat FROM `le_match` WHERE statut = 0";
                $resultatS = $linkpdo->query($requeteS);
                $double_tabS = $resultatS->fetchAll(); // je met le result de ma query dans un double tableau
                $nombre_ligneS = $resultatS->rowCount();
                $listeS = array();

                if ($nombre_ligneS == 0) {
                    echo "<center><h3>Aucun match en préparation</h3></center>";
                } else {

                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Equipe adverse</th>";
                    echo "<th>Date</th>";
                    echo "<th>Score</th>";
                    echo "</tr>";

                    for ($i = 0; $i < $nombre_ligneS; $i++) {
                        for ($y = 1; $y < 3; $y++) {
                            echo "<td>";
                            print_r($double_tabS[$i][$y]);
                            $listeS[$y] = $double_tabS[$i][$y];
                            $nom = $double_tabS[$i][1];
                            $prenom = $double_tabS[$i][2];
                            $Score = $double_tabS[$i][3];
                            echo "</td>";
                        }
                        $id_match = $double_tabS[$i][0];
                        $ScoreF  = "Match non joué";

                        echo "<td>";
                        echo $ScoreF;
                        echo "</td>";
                        echo "<td>";

                        echo '<a href="page_preparation_match.php?id=' . $id_match . '"><button class="acceder">Finir la préparation</button></a>';
                        /*echo '<a href="page_feuille_de_match.php?id_match=' . $id_match .'"> <button class="equipe">Equipe</button> </a>';*/
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
               
                
                ?>

                

            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>