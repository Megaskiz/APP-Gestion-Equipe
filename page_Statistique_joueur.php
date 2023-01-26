<!DOCTYPE html>
<html lang="en" style="font-family: Arial,sans-serif;">
<?php
require('fonctions.php');
is_logged();
?>

<head>
    <meta charset="UTF-8">
    <title>Page de Statistique de Joueurs</title>
    <link rel="stylesheet" href="style_add.css">
    <link rel="stylesheet" href="style_header.css">
    <link rel="stylesheet" href="style_profil.css">
    <link rel="stylesheet" href="style_stat.css">
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
        <div class="">
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
        <div class="list_page">
            <?php
            //afficher un tableau avec pour chaque joueur son nom,son prenom,son statut actuel, son poste préféré, son nombre de match joué et sa moyenne de note
            //on recupere les id de ou des joueurs
            $sql = "SELECT id_joueur FROM joueur";
            $result = $linkpdo->query($sql);
            $tab = $result->fetchAll();
            // on le met dans un tableau
            $tab_id = array();
            foreach ($tab as $key => $value) {
                $tab_id[] = $value['id_joueur'];
            }
            //fermeture du curseur
            $result->closeCursor();

            //pour chaque joueur du tableau on affiche les données suivante
            //en fonction de  l'id du tableau on affiche joueur son nom,son prenom,son statut actuel, son poste préféré, son nombre de match joué et sa moyenne de note
            //crée le tableau qui contiendra les données
            $tab_nom = array();
            $tab_prenom = array();
            $tab_statut = array();
            $tab_poste_pref = array();
            $tab_nb_match = array();
            $tab_moyenne = array();

            foreach ($tab_id as $key => $value) {
                $reqSQL= "SELECT j.nom, j.prenom, j.statut, j.poste_pref, COUNT(p.id_le_match), AVG(p.note) FROM participe as p, joueur as j WHERE j.id_joueur = p.id_joueur and j.id_joueur = $value";
                $result = $linkpdo->query($reqSQL);
                $tab = $result->fetchAll();
                // on le met dans un tableau
                foreach ($tab as $key => $value) {
                    $tab_nom[] = $value['nom'];
                    $tab_prenom[] = $value['prenom'];
                    $tab_statut[] = $value['statut'];
                    $tab_poste_pref[] = $value['poste_pref'];
                    $tab_nb_match[] = $value['COUNT(p.id_le_match)'];
                    if ($value['AVG(p.note)'] == null) {
                        $tab_moyenne[] = "Pas de note";
                    } else {
                        $tab_moyenne[] = $value['AVG(p.note)'];
                    }
                }
                //fermeture du curseur
                $result->closeCursor();


            }
            echo "<table>";
            echo "<tr>";
            echo "<th>Nom</th>";
            echo "<th>Prenom</th>";
            echo "<th>Statut</th>";
            echo "<th>Poste préféré</th>";
            echo "<th>Nombre de match joué</th>";
            echo "<th>Moyenne de note</th>";
            echo "</tr>";

            //on affiche les données du tableau
            for ($i = 0; $i < count($tab_nom); $i++) {
                echo '<tr>';
                echo '<td>' . $tab_nom[$i] . '</td>';
                echo '<td>' . $tab_prenom[$i] . '</td>';
                echo '<td>' . $tab_statut[$i] . '</td>';
                echo '<td>' . $tab_poste_pref[$i] . '</td>';
                echo '<td>' . $tab_nb_match[$i] . '</td>';
                echo '<td>' . $tab_moyenne[$i] . '</td>';
                echo '</tr>';
            }
            echo "</table>";

           
           


            ?>

        </div>

    </main>
    <footer>

    </footer>
</body>

</html>