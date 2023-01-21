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
?>


<?php
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$num_licence = $_POST['num_licence'];
$date_naissance = $_POST['date_naissance'];
$taille = $_POST['taille'];
$poids = $_POST['poids'];
$poste_pref = $_POST['poste_pref'];
$statut = $_POST['statut'];
$commentaire = $_POST['commentaire'];
$ajouterMembre = $linkpdo->prepare('INSERT INTO joueur (nom, prenom, num_licence, date_naissance, taille, poids, poste_pref, statut, commentaire) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');

if (!$ajouterMembre) {
    die("Erreur execute");
}
$ajouterMembre->execute(array($nom, $prenom, $num_licence, $date_naissance, $taille, $poids, $poste_pref, $statut, $commentaire));
if (!$ajouterMembre) {
    die("Erreur");
}



header('Location: page_accueil.php');

exit;


?>
