<!DOCTYPE html>
<html lang="en" style=" font-family: Roboto, sans-serif;">
<?php
require('fonctions.php');
is_logged();
?>

<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
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
                            <li><a href="page_add_match_choix.php">Ajouter un match</a></li>
                        </ul>
                    </li>
                    <li class="deroulant rubrique"><a href="page_Statistique_match.php">Statistique &ensp;</a>
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
        <div class="list_page">
            <form action="page_add_joueur.php">
                <button class="bouton" type="submit">ajouter un joueur</button>
            </form>
            <hr class="dashed">
            <hr />
            <?php




            ///Sélection de tout le contenu de la table enfant
            try {
                $res = $linkpdo->query("SELECT * FROM joueur;");
            } catch (Exception $e) { // toujours faire un test de retour en cas de crash
                die('Erreur : ' . $e->getMessage());
            }

            ///Affichage des entrées du résultat une à une

            $double_tab = $res->fetchAll(); // je met le result de ma query dans un double tableau
            $nombre_ligne = $res->rowCount();
            $liste = array();
            echo "<table>";

            
            for ($i = 0; $i < $nombre_ligne; $i++) {
                $photo = $double_tab[$i][8];
                echo "<td><img class=\"photo\" src=" . $photo . "></td>";
                for ($y = 1; $y < 3; $y++) {
                    echo "<td>";
                    print_r($double_tab[$i][$y]);
                    $liste[$y] = $double_tab[$i][$y];
                    $nom = $double_tab[$i][1];
                    $prenom = $double_tab[$i][2];
                    $age = $double_tab[0][$y];
                    
                   
                    echo "</td>";
                }
                $identifiant = $double_tab[$i][0];
                echo "<td>";
                echo '<a href="page_profil_joueur.php?id=' . $identifiant . '"><button class="acceder bouton">Détails</button></a>';
                echo "</td>";
                echo"</tr>";
            }
            echo "</table>";



            /// fermeture du curseur des résultats
            $res->closeCursor();


            ?>


        </div>


    </main>
    <footer>

    </footer>
</body>

</html>