<!DOCTYPE html>
<html lang="en" style="font-family: Arial,sans-serif;">
<?php
require('fonctions.php');
is_logged();
?>

<head>
    <meta charset="UTF-8">
    <title>Page matchs</title>
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
        <div class="menu_match">

            <div class="list_page">
               
                <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    try {
                        $sql = "SELECT * FROM le_match WHERE id_le_match = $id";
                        $res = $linkpdo->query($sql);
                    }catch (Exception $e) {
                        die('Erreur : ' . $e->getMessage());
                    }

                    $double_tab = $res->fetchAll();
                    $nombre_ligne = $res->rowCount();
                    $liste = array();

                    //stockage des information du match dans des variables
                    $id_match = $double_tab[0]['id_le_match'];
                    $date_match = $double_tab[0]['date_match'];
                    $heure_match = $double_tab[0]['heure_match'];
                    $equipe_adverse = $double_tab[0]['equipe_adverse'];
                    $lieux = $double_tab[0]['lieux'];

                    //si domicile = 1 alors domicile sinon exterieur
                    if($double_tab[0]['domicile'] == 1){
                        $domicile = "Domicile";
                    }else{
                        $domicile = "Exterieur";
                    }
                    $resultat = $double_tab[0]['resultat'];
                }

                ?>
                <center><h1>Details du matchc</h1></center>
                <a href="page_match.php"><button>Retour</button></a>
                <div>
                    <p class="information" >Date : <?php echo $date_match; ?></p>
                    <p class="information">Heure : <?php echo $heure_match; ?></p>
                    <p class="information">Equipe adverse : <?php echo $equipe_adverse; ?></p>
                    <p class="information">Lieux : <?php echo $lieux; ?></p>
                    <p class="information">Domicile/Exterieur : <?php echo $domicile; ?></p>
                    <p class="information">Resultat : <?php echo $resultat; ?></p>
                </div>
                <?php

                $req2="SELECT joueur.num_licence,joueur.nom,joueur.prenom,id_le_match,joueur.id_joueur, poste,note,titulaire FROM participe,joueur WHERE id_le_match =".$id_match." AND joueur.id_joueur = participe.id_joueur; ";
              
                try {
                    $res2 = $linkpdo->query($req2);
                }catch (Exception $e) {
                    die('Erreur : ' . $e->getMessage());
                }
                $double_tab2 = $res2->fetchAll();
                $nombre_ligne2 = $res2->rowCount();
                $liste2 = array();

                if ($nombre_ligne2<1){
                    echo("Aucun joueur n'a participer à ce match");
                }else{
                //0 si le joueur est titulaire alors titulaire sinon remplaçant
                if($double_tab2[0]['titulaire'] == 1){
                    $titulaire = "Titulaire";
                }else{
                    $titulaire = "Remplaçant";
                }

                echo "<h4>Joueurs qui ont participer au match</h4>";
                echo "<br>";
                echo "<table>";
                echo "<tr>";
                echo "<th>Nom</th>";
                echo "<th>Prenom</th>";
                echo "<th>Poste</th>";
                echo "<th>Note du match</th>";
                echo "<th>Titulaire</th>";
                echo "</tr>";

                for($i=0;$i<$nombre_ligne2;$i++){
                    echo "<tr>";
                    echo "<td>".$double_tab2[$i]['nom']."</td>";
                    echo "<td>".$double_tab2[$i]['prenom']."</td>";
                    echo "<td>".$double_tab2[$i]['poste']."</td>";
                    echo "<td>".$double_tab2[$i]['note']."</td>";
                    echo "<td>".$titulaire."</td>";
                    echo "<td><a href='page_profil_joueur.php?id=".$double_tab2[$i]['id_joueur']."'><button>profil</button></a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                }
                ?>
            </div>
            <div>

            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>