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
            <center><h1>Ajout d'un Joueur</h1></center>
            <form method="POST" action="traitement.php">
                <label for="nom">Nom :</label><br>
                <input type="text" id="nom" name="nom" required><br>

                <label for="prenom">Prénom :</label><br>
                <input type="text" id="prenom" name="prenom" required><br>

                <label for="num_licence">Numéro de licence :</label><br>
                <input type="text" id="num_licence" name="num_licence" required><br>

                <label for="date_naissance">Date de naissance :</label><br>
                <input type="date" id="date_naissance" name="date_naissance" required><br>

                <label for="taille">Taille (en cm) :</label><br>
                <input type="number" step="0.01" id="taille" name="taille" required><br>

                <label for="poids">Poids (en kg) :</label><br>
                <input type="number" id="poids" name="poids" required><br>
                
                <label for="poste_pref">Poste préféré :</label><br>
                <select name="poste_pref" id="poste_pref">
                    <option value="Meneur">Poste 1 : Meneur (point guard)</option>
                    <option value="Arrière">Poste 2 : Arrière (shooting guard)</option>
                    <option value="Ailier"> Poste 3 : Ailier (small forward)</option>
                    <option value="Ailier fort">Poste 4 : Ailier fort (power forward)</option>
                    <option value="Pivot">Poste 5 : Pivot (center)</option>
                </select><br>
                

                
                <label for="statut">Statut :</label><br> 
                <select name="statut" id="statut">
                    <option value="Actif">Actif</option>
                    <option value="Inactif">Inactif</option>
                </select><br>   

                <label for="commentaire">Commentaires sur le joueur :</label><br>
                <textarea id="commentaire" name="commentaire"></textarea><br><br>

                <input class="bouton" type="submit" value="Envoyer">
            </form>
        </div>
    </main>


    <footer>

    </footer>
</body>

</html>