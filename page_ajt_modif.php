<?php

require('fonctions.php');
is_logged();


// la partie de la connexion
///Connexion au serveur MySQL
try {
    $linkpdo = new PDO("mysql:host=localhost;dbname=bddprojetsport", "root", "");
}
///Capture des erreurs éventuelles
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (
    isset($_SESSION['id'])
) {
    //je shouais faire un update de la table joueur
    // appartir des information récuperé sur la page de formulaire de la page modif_joueur.php
    //donc update la taille, poids, poste_pref,statut,commentaire

    $id = $_SESSION['id'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $poste_pref = $_POST['poste_pref'];
    $statut = $_POST['statut'];
    $commentaire = $_POST['commentaire'];

    $reqM = "UPDATE joueur SET taille = '$taille', poids = '$poids', poste_pref = '$poste_pref', statut = '$statut', commentaire = '$commentaire' WHERE joueur.id_joueur = $id;";
    try {
        $res = $linkpdo->query($reqM);
    } catch (Exception $e) { // toujours faire un test de retour au cas ou ça crash
        die('Erreur : ' . $e->getMessage());
    }

    //retour sur la page de profil du joueur en question
    header('Location: page_profil_joueur.php?id=' . $id);
    
}
