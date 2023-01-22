<!DOCTYPE html>
<html lang="en" style="font-family: Arial,sans-serif;">
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

if (isset($_FILES['photo_joueur'])) {
    $id = $_GET['id'];
    $photo_joueur = uploadImage($_FILES['photo_joueur']);
    $reqM = "UPDATE joueur SET lien_photo = '$photo_joueur' WHERE joueur.id_joueur = $id;";
    try {
        $res = $linkpdo->query($reqM);
    } catch (Exception $e) { // toujours faire un test de retour au cas ou ça crash
        die('Erreur : ' . $e->getMessage());
    }
    header("Refresh:0");
}

?>

<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="style_add.css">
    <link rel="stylesheet" href="style_header.css">
    <link rel="stylesheet" href="style_profil.css">
    <script type="text/javascript" src="script.js"></script>
</head>

<body>
    <?php
    

    $previous = "javascript:history.go(-1)";
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
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
                    <li><a href="#">Contact</a></li>
                    <li><a href="page_connection.php?session_destroy():true">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="list_page">

            <center><h1>Modification du profil du joueur </h1></center>
            <?php if (isset($_GET['id'])) { 
                $id = $_GET['id'];
                $_SESSION['id'] = $id;
                ///Sélection de tout le contenu de la table joueur
                try {
                    $res = $linkpdo->query("SELECT * FROM joueur where id_joueur='$id'");
                } catch (Exception $e) { // toujours faire un test de retour au cas ou ça crash
                    die('Erreur : ' . $e->getMessage());
                }

                $double_tab = $res->fetchAll(); // je met le result de ma query dans un double tableau
                $nombre_ligne = $res->rowCount(); // =1 car il y a 1 ligne dans ma requete
                $liste = array();
    
    
                
                $nom = ucfirst($double_tab[0][1]);
                $prenom = ucfirst($double_tab[0][2]);
                $num_licence = ucfirst($double_tab[0][3]);
                $date = date_format(new DateTime(strval($double_tab[0][4])), 'd/m/Y');            
                $taille = $double_tab[0][5];
                $poids = $double_tab[0][6];
                $post_pref = $double_tab[0][7];
               
                //si le joueur n'a pas de photo, afficher le message "Aucune photo pour ce joueur"
                if (strlen($double_tab[0][8]) < 1) {
                    $lien_photo = "Aucune photo pour ce joueur";
                } else {
                    $lien_photo = $double_tab[0][8];
                }
                
                $statut = $double_tab[0][9];
                if (strlen($double_tab[0][10]) < 1) {
                    $commentaire = "Aucun commentaire pour ce joueur";
                } else {
                    $commentaire = $double_tab[0][10];
                }
                
                
                ?>
                <div class="profil_joueur">
                    <div class="profil_joueur_photo">
                        <?php
                        
                         echo "<button class='modifier-photo' type=\"button\" onclick=\"openDialog('dialog11', this)\">Modifier la photo</button>";
                         echo "<div id=\"dialog_layer\" class=\"dialogs\">";
         
                         echo "<div role=\"dialog\" id=\"dialog11\" aria-labelledby=\"dialog11_label\" aria-modal=\"true\" class=\"hidden\">";
         
                         echo "<h2 id=\"dialog11_label\" class=\"dialog_label\">Modifier la photo</h2>";
         
                         echo "<form enctype=\"multipart/form-data\" action=\"\" method=\"POST\" class=\"dialog_form\">";
                         echo "<div class=\"dialog_form_item\">";
                         echo "<label><span class=\"label_text\"></span><input name=\"photo_joueur\" type=\"file\" class=\"zip_input\" required=\"required\"></label>";
                         echo "</div><div class=\"dialog_form_actions\">";
                         echo "  <button class='popup-btn' type=\"button\" onclick=\"closeDialog(this)\">Annuler</button>";
                         echo "<button class='popup-btn' type=\"submit\">Valider </button></div></form></div></div>";
                        
                        //si le joueur n'a pas de photo, afficher le message "Aucune photo pour ce joueur"
                        if (strlen($lien_photo) < 1) {
                            echo "<center><h2><i>Aucune photo pour ce joueur</i></h2></center>";
                        } else {
                        ?>
                        <img class="img" src="<?php echo $lien_photo; ?>" alt="">
                        <?php } ?>
                    </div>
                    <div class="profil_joueur_info">
                        <form action="page_ajt_modif.php" method="POST">
                        <h2 class="nom_joueur"><?php echo $nom . " " . $prenom; ?></h2>

                        <p class="information">Numéro de licence :<?php echo htmlspecialchars($num_licence)?></p>
                        <p class="information">Date de naissance : <?php echo $date; ?></p>
                        <p class="information">Taille : </p><input name="taille" type="taille" value="<?php echo htmlspecialchars($taille)?>">
                        <p class="information">Poids : </p><input name="poids" type="poids" value="<?php echo htmlspecialchars($poids)?>">
                        <p class="information">Poste préféré : </p><input name="post_pref" type="post_pref" value="<?php echo htmlspecialchars($post_pref)?>">
                        <p class="information">Statut : </p><input name="statut" type="statut" value="<?php echo htmlspecialchars($statut)?>">
                        <p class="information">Commentaire : </p><input name="commentaire" type="commentaire" value="<?php echo htmlspecialchars($commentaire)?>">
                        <button type="submit">Valider la modification</button>
                        </form>
                    </div>
                    
                </div>
                <a href="page_profil_joueur.php?id=<?=$_GET['id']?>"><button>Annuler</button></a>
        <?php } else { 
            echo "Aucun joueur n'a été sélectionné";
        }?>
        </div>
    </main>
    <footer>

    </footer>
    
</body>


</html>