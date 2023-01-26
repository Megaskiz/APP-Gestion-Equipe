
<?php
require('fonctions.php');
is_logged();
///Connexion au serveur MySQL
try {
    $linkpdo = new PDO("mysql:host=localhost;dbname=bddprojetsport", "root", "");
}
///Capture des erreurs éventuelles
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


if (
    isset($_POST['date_match'])
    && isset($_POST['heure_match'])
    && isset($_POST['equipe_adverse'])
) {

    $date_match = $_POST['date_match'];
    $heure_match = $_POST['heure_match'];
    $equipe_adverse = $_POST['equipe_adverse'];
    $lieu_match = $_POST['lieux'];
    $domicile = $_POST['domicile'];
    $resulat = $_POST['resultat'];

    $req = $linkpdo->prepare('INSERT INTO le_match(date_match, heure_match, equipe_adverse, lieux, domicile, resultat) VALUES (?, ?, ?, ?, ?, ?)');

    if (!$req) {
        die("Erreur execute");
    }

    $req->execute(array($date_match, $heure_match, $equipe_adverse, $lieu_match, $domicile, $resulat));
    if (!$req) {
        die("Erreur");
    }
    //récupération de l'id du match ajouté
    $id_match = $linkpdo->lastInsertId();
    //redirection vers la page de préparation du match
    header('Location: page_preparation_match.php?id='. $id_match);
    exit();
}
