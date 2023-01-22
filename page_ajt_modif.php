<?php

require('fonctions.php');
is_logged();


// la partie de la connexion
///Connexion au serveur MySQL
try {
    $linkpdo = new PDO("mysql:host=localhost;dbname=bddsae", "root", "");
}
///Capture des erreurs éventuelles
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$id=$_SESSION['id'];
$taille = $_POST['taille'];
$poids = $_POST['poids'];
$post_pref = $_POST['post_pref'];
$statut = $_POST['statut'];
$commentaire = $_POST['commentaire'];

$reqSQL = "UPDATE joueur  SET taille=".$taille." ,poids=". $poids.",post_pref=".$post_pref.",statut= ".$statut.",commentaire= ".$commentaire." WHERE id= ".$_SESSION['id']."";

$req = $linkpdo->prepare('UPDATE joueur  SET taille=? ,poids= ?,poste_pref= "?",statut= "?",commentaire= "?" WHERE id_joueur= ?');

if ($req == false) {
    die("erreur linkpdo");
}
///Exécution de la requête
try {
    $req->execute([$taille, $poids, $post_pref, $statut, $commentaire,$_SESSION['id']]);

    if ($req == false) {
        $req->debugDumpParams();
        die("erreur execute");
    }
    echo $reqSQL;
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
/*
header('Location: page_profil_joueur.php?id=' . $_SESSION['id'] . '');
exit();*/
