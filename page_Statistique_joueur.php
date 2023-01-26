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
        <div classe="list_page">
            <h1>Statistique par joueur</h1>
            <table>
                <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Moyenne</th>
                </tr>
                <?php
                // on recupere les id de ou des joueurs
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
                //affichage du tableau
                echo '<br>';
                //pour chaque joueur du tableau on affiche son nom et son prenom ansi que ça moyenne des notes au match participé
                //avec la requete suivante "SELECT j.nom, j.prenom, AVG(p.note)FROM participe as p, joueur as j WHERE j.id_joueur = p.id_le_match and j.id_joueur = id_joueur"
                foreach ($tab_id as $key => $value) {
                    $sql = "SELECT j.nom, j.prenom, AVG(p.note)FROM participe as p, joueur as j WHERE j.id_joueur = p.id_joueur and j.id_joueur = $value";
                    $result = $linkpdo->query($sql);
                    $tab = $result->fetchAll();
                    // on le met dans un tableau
                    $tab_nom = array();
                    foreach ($tab as $key => $value) {
                        $tab_nom[] = $value['nom'];
                    }
                    //fermeture du curseur
                    $result->closeCursor();

                    // on le met dans un tableau
                    $tab_prenom = array();
                    foreach ($tab as $key => $value) {
                        $tab_prenom[] = $value['prenom'];
                    }
                    //fermeture du curseur
                    $result->closeCursor();

                    // on le met dans un tableau
                    $tab_moyenne = array();
                    foreach ($tab as $key => $value) {
                        if ($value['AVG(p.note)'] == null) {
                            $tab_moyenne[] = "Pas de note";
                        } else {
                            $tab_moyenne[] = $value['AVG(p.note)'];
                        }
                    }
                    //fermeture du curseur
                    $result->closeCursor();



                    //on affiche les données du tableau
                    for ($i = 0; $i < count($tab_nom); $i++) {
                        echo '<tr>';
                        echo '<td>' . $tab_nom[$i] . '</td>';
                        echo '<td>' . $tab_prenom[$i] . '</td>';
                        echo '<td>' . $tab_moyenne[$i] . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </table>

        </div>

    </main>
    <footer>

    </footer>
</body>

</html>