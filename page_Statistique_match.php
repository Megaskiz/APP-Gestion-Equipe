<!DOCTYPE html>
<html lang="en" style="font-family: Arial,sans-serif;">
<?php
require('fonctions.php');
is_logged();
?>

<head>
    <meta charset="UTF-8">
    <title>Page de Statistique match</title>
    <link rel="stylesheet" href="style_add.css">
    <link rel="stylesheet" href="style_header.css">
    <link rel="stylesheet" href="style_profil.css">
    <link rel="stylesheet" href="style_stat.css">
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
        <div class="block list_page">
            <center>
                <h1>Statistique par match</h1>
            </center>
            <hr class="dashed">
            <h1>Graphique des victoire et defaites</h1>

            <?php
            //afficher un graphique fromage des statistiques de match gagné, p perdu, n nul
            $sql = "SELECT COUNT(*) AS nb_match, resultat FROM le_match GROUP BY resultat ";
            $result1 = $linkpdo->query($sql);   //exécution de la requête
            $data = $result1->fetchAll(PDO::FETCH_ASSOC); //récupération des données

            //afficher les statistiques
            $gagne = 0;
            $perdu = 0;
            $nul = 0;
            foreach ($data as $row) {
                $nb_match = $row['nb_match'];
                $score = $row['resultat'];

                //match gagné ou perdu ou ,nul
                $result = explode("-", $score);
                // si le match n'a pas été joué, on ne l'affiche pas
                if ($score == null) {
                    continue;
                } else {
                    if ($result[0] > $result[1]) {

                        $gagne++;
                    } elseif ($result[0] < $result[1]) {

                        $perdu++;
                    } else {

                        $nul++;
                    }
                }
            }

            //afficher le pourcentage de match gagné, perdu, nul
            $total = $gagne + $perdu + $nul;
            $pourcentage_gagne = round($gagne / $total * 100, 2);
            $pourcentage_perdu = round($perdu / $total * 100, 2);
            $pourcentage_nul = round($nul / $total * 100, 2);
            echo "<p>Il y a eu $total matchs joués</p>";
            echo "<p>Il y a eu $gagne matchs gagnés, soit $pourcentage_gagne %</p>";
            echo "<p>Il y a eu $perdu matchs perdus, soit $pourcentage_perdu %</p>";
            echo "<p>Il y a eu $nul matchs nuls, soit $pourcentage_nul %</p>";

            ?>



            <canvas id="myChart" class="graph"></canvas>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
            <script>
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Match gagné', 'Match perdu', 'Match nul'],
                        datasets: [{
                            label: 'Pourcentage de match gagné, perdu, nul',
                            data: [<?php echo $pourcentage_gagne ?>, <?php echo $pourcentage_perdu ?>, <?php echo $pourcentage_nul ?>],
                            backgroundColor: [
                                'rgba(85, 42, 134, 1S)',
                                'rgba(100, 162, 235, 0.2)',
                                'rgba(100, 206, 86, 0.2)'
                            ],
                            borderColor: [
                                'rgba(0, 0, 0, 0)',
                                'rgba(0, 0, 0, 0)',
                                'rgba(0, 0, 0, 0)'
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

        <div class="block list_page">
            <h1>Courbe avec l'évolution de la moyenne des points par match dans le temps</h1>
            <?php
            //recupérer les points de chaque match
            $sql = "SELECT resultat FROM le_match WHERE resultat is NOT null order BY resultat  ";
            $result1 = $linkpdo->query($sql);   //exécution de la requête
            $data = $result1->fetchAll(PDO::FETCH_ASSOC); //récupération des données
            $scoreAddition = 0;

            foreach ($data as $row) {

                $score = $row['resultat'];


                //match gagné ou perdu ou ,nul
                $result = explode("-", $score);
                //afficher le score de chaque match


                // si le match n'a pas été joué, on ne l'affiche pas
                if ($score == null) {
                    continue;
                } else {
                    $scoreAddition = $scoreAddition + intval($result[0]);
                }
            }
            //fermer le curseur
            $result1->closeCursor();
            echo "<p>Le nombre de points total est de $scoreAddition</p>";
            //calculer la moyenne des points en fonction du nombre de matchs
            //on recupere le nombre de matchs
            $sql = "SELECT COUNT(*) AS nb_match FROM le_match WHERE resultat is NOT null ";
            //exécution de la requête
            $result1 = $linkpdo->query($sql);
            //récupération des données
            $data = $result1->fetchAll(PDO::FETCH_ASSOC);
            //on parcours les données
            foreach ($data as $row) {
                $nb_match = $row['nb_match'];
            }
            //fermer le curseur
            $result1->closeCursor();

            //calculer la moyenne des points par match
            $moyenne = round($scoreAddition / $nb_match, 2);

            echo "<p>La moyenne des points par match est de $moyenne</p>";


            //recuperer la date et le score de chaque match et on le stock dans un tableau
            $sql = "SELECT date_match, resultat FROM le_match WHERE resultat is NOT null order BY date_match; ";
            //exécution de la requête
            $result1 = $linkpdo->query($sql);
            //récupération des données
            $data = $result1->fetchAll(PDO::FETCH_ASSOC);
            //on cree un tableau pour stocker les données
            $tabDate = array();
            $tabResultat = array();
            //on parcours les données 
            foreach ($data as $row) {
                $date = $row['date_match'];
                $score = $row['resultat'];
                //on stocke les données dans les tableaux
                array_push($tabDate, $date);
                array_push($tabResultat, $score);
            }
            //on ajoute une colonne au tableau dans la quelle on stocke la moyenne des points par match cumulé dans le temps
            $tabMoyenne = array();
            $moyenne = 0;
            $scoreAddition = 0;
            $i = 0;
            foreach ($tabResultat as $row) {
                $score = $row;
                $result = explode("-", $score);
                $scoreAddition = $scoreAddition + intval($result[0]);
                $moyenne = $scoreAddition / ($i + 1);
                array_push($tabMoyenne, $moyenne);
                $i++;
            }
            //fermer le curseur
            $result1->closeCursor();

            //crée une courbe avec l'évolution de la moyenne des points par match dans le temps
            ?>

            <canvas id="myChart2" class="graph"></canvas>
            <script>
                var ctx = document.getElementById('myChart2').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [<?php echo "'" . implode("','", $tabDate) . "'" ?>],
                        datasets: [{
                            label: 'Evolution de la moyenne des points par match dans le temps',
                            data: [<?php echo implode(",", $tabMoyenne) ?>],
                            backgroundColor: [
                                'rgba(85, 42, 134, 0.2)'
                            ],
                            borderColor: [
                                'rgba(85, 42, 134, 1)'
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
            <h1>Graphique de l'évolution des points par match</h1>
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


    </main>
    <footer>

    </footer>
</body>

</html>