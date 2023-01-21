<!DOCTYPE html>
<html lang="en" style="font-family: Arial,sans-serif;">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_connection.css">
    <title>Page de cOnnEctIOn</title>
</head>

<body>

    <?php
    // la partie de la connexion
    ///Connexion au serveur MySQL
    try {
        $linkpdo = new PDO("mysql:host=localhost; dbname=bddprojetsport", "root", "");
    }
    ///Capture des erreurs éventuelles
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    // je récupere les informations de mon formulaire
    if (!empty($_POST['id']) && !empty($_POST['mdp'])) {
        $id = $_POST['id'];
        $mdp = $_POST['mdp'];
        // je creé la requete
        $query = "SELECT count(*) FROM utilisateur WHERE identifiant='$id' and mdp='$mdp'";

        // Execution de la requete
        try {
            $res = $linkpdo->query($query);
        } catch (Exception $e) {
            // toujours faire un test de retour au cas ou ça crash
            die('Erreur : ' . $e->getMessage());
        }

        $count = $res->fetchColumn();
        if ($count == 1) {
            session_start();
            $_SESSION['logged_user'] = $id;
            header("location:page_accueil.php");
        } else {
            echo "identifiant ou mot de passe invalide";
        }
    }
    ?>

    <div class="corps">
        <div class="connect-page">

            <img class="img_header" src="projet_photos/sticker-basket---joueur-n-5.png" alt="">
            <h1>BALL MANAGEMENT</h1>

            <form action="" method="post">
                <input class="input_id" required type="text" name="id" placeholder="Identifiant" require /></br></br>
                <input class="input_id" required type="password" name="mdp" placeholder="Mot de passe" require /></br></br>
                <input class="button" type="submit" value="Acceder">
            </form>
        </div>
    </div>
</body>

</html>