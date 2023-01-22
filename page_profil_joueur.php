<!DOCTYPE html>
<html lang="en" style="font-family: Arial,sans-serif;">
<?php
require('fonctions.php');
is_logged();
?>

<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="style_add.css">
    <link rel="stylesheet" href="style_header.css">
    <link rel="stylesheet" href="style_profil.css">
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
                    <li class="deroulant rubrique"><a href="page_stat.php">Statistique &ensp;</a>
                        <ul class="sous">
                            <li><a href="page_Statistique_match.php">Statistique par matchs</a></li>
                            <li><a href="page_Statistique_joueur.php">Statistique par joueur</a></li>
                        </ul>
                    </li>
                    <li><a href="page_connection.php?session_destroy():true">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="list_page">
        <a href="page_joueur.php"><button>Retour</button></a>
            <center><h1>Profil du joueur</h1></center>
            <?php if (isset($_GET['id'])) { 
                $id = $_GET['id'];
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
                $lien_photo = $double_tab[0][8];
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
                        //si le joueur n'a pas de photo, afficher le message "Aucune photo pour ce joueur"
                        if (strlen($lien_photo) < 1) {
                            echo "<center><h2><i>Aucune photo pour ce joueur</i></h2></center>";
                        } else {
                        ?>
                        <img class="img" src="<?php echo $lien_photo; ?>" alt="">
                        <?php } ?>
                    </div>
                    <div class="profil_joueur_info">
                        <h2 class="nom_joueur"><?php echo $nom . " " . $prenom; ?></h2>
                        <p class="information">Numéro de licence : <?php echo $num_licence; ?></p>
                        <p class="information">Date de naissance : <?php echo $date; ?></p>
                        <p class="information">Taille : <?php echo $taille; ?> m</p>
                        <p class="information">Poids : <?php echo $poids; ?> kg</p>
                        <p class="information">Poste préféré : <?php echo $post_pref; ?></p>
                        <p class="information">Statut : <?php echo $statut; ?></p>
                        <p class="information">Commentaire : <i><?php echo $commentaire; ?></i></p>
                    </div>
                    
                </div>
                <a href="modif_joueur.php?id=<?php echo $_GET['id'];?> "><button>Modifier le Joueur</button></a> 
                

        <?php } else { 
            echo "Aucun joueur n'a été sélectionné";
        }?>
        </div>
    </main>
    <footer>

    </footer>
    
</body>


</html>