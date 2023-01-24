<?php

require('fonctions.php');

    session_start();
    
    

    try {
        $linkpdo = new PDO("mysql:host=localhost;dbname=bddprojetsport", "root", "");
    }
    ///Capture des erreurs éventuelles
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    

$id_joueur = $_POST['id_joueur'];
$id_match = $_POST['id_match'];
$poste = $_POST['poste'];
$note = $_POST['note'];
$titulaire = $_POST['titulaire'];

try {
    $linkpdo->query("INSERT INTO participe (Id_joueur, Id_le_match, poste, note, titulaire) VALUES ($id_joueur, $id_match, '$poste', $note, '$titulaire')");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


header('Location: page_accueil.php');
        ?>


    

