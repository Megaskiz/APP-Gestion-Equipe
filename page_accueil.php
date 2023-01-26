<!DOCTYPE html>
<html lang="en" style="font-family: Arial,sans-serif;">
<?php
require('fonctions.php');
is_logged();
?>

<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="style_accueil.css">
    <link rel="stylesheet" href="style_header.css">
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
                            <li><a href="page_add_match_choix.php">Ajouter un match</a></li>
                        </ul>
                    </li>
                    <li class="deroulant rubrique"><a href="page_Statistique_match.php">Statistique &ensp;</a>
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
        <div class="container">
            <div class="row">
                <div class="block_contenu">
                    <h1>Bienvenue sur le site de gestion de votre équipe de basket</h1>


                </div>
            </div>
            <div class="row">
                <div class="col-12 block_contenu">
                    <h2>Vous pouvez gérer vos joueurs, vos matchs et vos statistiques</h2>
                    <hr class="dashed">

                    <div>
                        <h2>Affichage des joueur star </h2>
                        <div class="stars">

                            <div class="player">
                                <?php
                                //affiche le qui a paticipé au plus de matchs
                                $sql = "SELECT joueur.nom, joueur.prenom,joueur.lien_photo, COUNT(*) AS nb_matchs FROM joueur, participe WHERE joueur.id_joueur = participe.id_joueur GROUP BY joueur.nom, joueur.prenom ORDER BY nb_matchs DESC LIMIT 1;";
                                $result = $linkpdo->query($sql);
                                $row = $result->fetch();

                                ?>
                                <h3>Le joueur qui a participé au plus de matchs est : </h3>
                                <img src="<?php echo $row['lien_photo'] ?>" alt="">
                                <p><?php echo $row['nom'] . " " . $row['prenom'] ?></p>
                            </div>
                            <div class="player">
                                <?php
                                //affiche le joueur qui a la plus grande moyenne de points par match
                                $sql = "SELECT joueur.nom, joueur.prenom,joueur.lien_photo, AVG(participe.note) AS moyenne_points FROM joueur, participe WHERE joueur.id_joueur = participe.id_joueur GROUP BY joueur.nom, joueur.prenom ORDER BY moyenne_points DESC LIMIT 1; ";
                                $result = $linkpdo->query($sql);
                                $row = $result->fetch();

                                ?>
                                <h3>Le joueur qui a la plus grande moyenne de points par match est : </h3>
                                <img src="<?php echo $row['lien_photo'] ?>" alt="">
                                <p><?php echo $row['nom'] . " " . $row['prenom'] ?></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 block_contenu">
                    <h2>Vous pouvez aussi consulter les statistiques de vos joueurs ou de vos matchs</h2>
                    <div class="block list_page">
                        <?php
                        //afficher un graphique avec le nombre de point par match dans le temps
                        //on vas recupérer la date et le resultat de chaque match
                        $reqSQl = "SELECT date_match, resultat FROM le_match WHERE resultat is NOT null GROUP BY date_match";
                        //exécution de la requête
                        $result1 = $linkpdo->query($reqSQl);
                        //récupération des données
                        $data = $result1->fetchAll(PDO::FETCH_ASSOC);
                        //on cree un tableau pour stocker les données
                        $tabDate = array();
                        $tabResultat = array();
                        //on parcours les données
                        foreach ($data as $row) {
                            //on recupère la date et le resultat
                            $date = $row['date_match'];
                            $minitabres =  $result = explode("-", $row['resultat']);
                            $resultat = $minitabres[0];
                            //on ajoute les données dans les tableaux
                            array_push($tabDate, $date);
                            array_push($tabResultat, $resultat);
                        }




                        //fermer le curseur
                        $result1->closeCursor();
                        //on affiche les données du tableau dans un graphique en barre avec l'ordonnée qui commence à 0
                        ?>
                        <center><h2>Graphique de l'évolution des points par match</h2></center>
                        <canvas id="myChart3" class="graph"></canvas>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

                        <script>
                            var ctx = document.getElementById('myChart3').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: [<?php echo "'" . implode("','", $tabDate) . "'" ?>],
                                    datasets: [{
                                        label: 'Nombre de points par match',
                                        data: [<?php echo implode(",", $tabResultat) ?>],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>