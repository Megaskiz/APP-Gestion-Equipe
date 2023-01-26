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
    isset($_POST['nom'])
    && isset($_POST['prenom'])
    && isset($_POST['num_licence'])
) {

    //on recpure la photo du joueur
    $photo_joueur   = uploadImage($_FILES['photo_joueur']);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $num_licence = $_POST['num_licence'];
    $date_naissance = $_POST['date_naissance'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $poste_pref = $_POST['poste_pref'];
    $statut = $_POST['statut'];
    $commentaire = $_POST['commentaire'];

    $ajouterMembre = $linkpdo->prepare('INSERT INTO joueur (nom, prenom, num_licence, date_naissance, taille, poids, poste_pref, statut, commentaire, lien_photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)');

    
    $ajouterMembre->execute(array($nom, $prenom, $num_licence, $date_naissance, $taille, $poids, $poste_pref, $statut, $commentaire, $photo_joueur));

    header('Location: page_joueur.php');
    exit();
}

//ajouter un match a partir de la page page_add_match.php
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


  
    header('Location: page_match.php');
    exit();
}
