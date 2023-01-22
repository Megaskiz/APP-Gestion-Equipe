<!DOCTYPE html>
<html lang="en" style="font-family: Arial,sans-serif;">
<?php
require('fonctions.php');
is_logged();
?>

<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="style_add.css">
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
        <div class="list_page">
            <center>
                <h1>Ajout d'un match</h1>
            </center>
            <form method="POST" action="traitement.php">
                <label for="date_match">Date du match :</label><br>
                <input type="date" id="date_match" name="date_match" required><br>

                <label for="heure_match">Heure du match :</label><br>
                <input type="time" id="heure_match" name="heure_match" required><br>

                <label for="equipe_adverse">Equipe adverse :</label><br>
                <input type="text" id="equipe_adverse" name="equipe_adverse" required><br>

                <label for="lieux">Lieux du match :</label><br>
                <input type="text" id="lieux" name="lieux" required><br>

                <label for="domicile">Domicile :</label><br>
                <select name="domicile" id="domicile">
                    <option value="1">Domicile</option>
                    <option value="0">Exterieur</option>
                </select><br>

                <label for="resultat">Score :</label><br>
                <input type="text" id="resultat" name="resultat" required><br>

                <input class="bouton" type="submit" value="Envoyer">
            </form>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>