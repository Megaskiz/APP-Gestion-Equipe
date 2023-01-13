<!DOCTYPE html>
<html lang="en" style="font-family: Arial,sans-serif;">
<?php
require('fonctions.php');
is_logged();
?>

<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="style_accueil.css">
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
            <h1><a href="page_accueil.php">Page d'accueil</a></h1> </br>
            <nav>
                <ul>
                    <li class="deroulant"><a href="page_joueur.php">Joueurs &ensp;</a>
                        <ul class="sous">
                            <li><a href="page_joueur.php">Tous les joueurs</a></li>
                            <li><a href="page_joueur.php">Ajouter un joueur</a></li>
                        </ul>
                    </li>
                    <li class="deroulant"><a href="page_match.php">Matchs &ensp;</a>
                        <ul class="sous">
                            <li><a href="">Tous les matchs</a></li>
                            <li><a href="page_match.php">Ajouter un match</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="page_connection.php?session_destroy():true">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>

 
        </div>


        <form method="POST" action="traitement.php">
  <label for="nom">Nom :</label><br>
  <input type="text" id="nom" name="nom"><br>
  <label for="prenom">Prénom :</label><br>
  <input type="text" id="prenom" name="prenom"><br>
  <label for="num_licence">Numéro de licence :</label><br>
  <input type="text" id="num_licence" name="num_licence"><br>
  <label for="date_naissance">Date de naissance :</label><br>
  <input type="date" id="date_naissance" name="date_naissance"><br>
  <label for="taille">Taille (en cm) :</label><br>
  <input type="number" step="0.01" id="taille" name="taille"><br>
  <label for="poids">Poids (en kg) :</label><br>
  <input type="number" id="poids" name="poids"><br>
  <label for="poste_pref">Poste préféré :</label><br>
  <input type="text" id="poste_pref" name="poste_pref"><br>
  <label for="statut">Statut :</label><br>
  <input type="text" id="statut" name="statut"><br>
  <label for="commentaire">Commentaires sur le joueur :</label><br>
  <textarea id="commentaire" name="commentaire"></textarea><br><br>
  <input type="submit" value="Envoyer">
</form> 
    </main>


    <footer>

    </footer>
</body>

</html>