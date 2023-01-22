<?php
    session_start();

    // Vérifie si les données du formulaire ont été soumises
    if (isset($_POST['poste']) && isset($_POST['note']) && isset($_POST['titulaire']) && isset($_POST['id_match']) && isset($_POST['id_joueur'])) {
        $id_joueur = $_POST['id_joueur'];
        $id_match = $_POST['id_match'];
        $poste = $_POST['poste'];
        $note = $_POST['note'];
        $titulaire = $_POST['titulaire'];
        // Connexion à la base de données
        try {
            $linkpdo = new PDO("mysql:host=localhost;dbname=bddprojetsport", "root", "");
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        // Préparation de la requête d'insertion
        $query = $linkpdo->prepare("INSERT INTO participe (Id_joueur, Id_le_match, poste, note, titulaire) VALUES (:Id_joueur, :Id_le_match, :poste, :note, :titulaire)");
        $query->bindValue(':Id_joueur', $id_joueur);
        $query->bindValue(':Id_le_match', $id_match);
        $query->bindValue(':poste', $poste);
        $query->bindValue(':note', $note);
        $query->bindValue(':titulaire', $titulaire);
        // Exécution de la requête
        $query->execute();
        // Vérifie si la requête a réussi
        if ($query->rowCount() > 0) {
        echo "Les données ont été ajoutées avec succès à la table participe";
        } else {
        echo "Il y a eu une erreur lors de l'ajout des données à la table participe";
        }
        } else {
        echo "Les données du formulaire ne sont pas complètes";
        }
        
    var_dump($_POST);

        ?>