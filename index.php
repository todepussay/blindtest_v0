<?php

session_start();

require('connect.php');

$sql = $connect->prepare('SELECT * FROM categories');
$sql->execute();
$table = $sql->fetchAll();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php require('header.php'); ?>

    <div class="container">
        <div class="box">

            <?php if(isset($_SESSION['id']) || isset($_SESSION['invite'])): ?>

            <p id="p-rules">Si vous voulez voir les informations et les règles du jeu, <a href="rules.php">cliquez ici</a></p>

            <h1>Choix du jeu</h1>

            <form action="game.php" method="post">

                <div class="input" id="input_categorie">
                    <label for="categorie">Choisissez une categorie :</label><br>
                    <select name="categorie" id="categorie" require onclick="change_categorie()">
                        <option value="-2" selected disabled hidden>-- Catégorie --</option>
                        <!-- <option value="-1">Tout</option> -->
                        <?php foreach($table as $category): ?>
                            <option value="<?= $category['id']; ?>"><?= ucfirst($category['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="option-2"></div>



                <!-- Catégorie Tout -->



                <div id="option-1">
                    <p>Toutes les catégories seront jouées.</p><br><br><br><br>
                </div>



                <!-- Catégorie Opening -->



                <div id="option0">
                
                    <h2>Paramètres avancés :</h2>

                    <button class="checkbox nocheck" type="button" id="all" onclick="select_checkbox('all'); checkbox_all()">
                            <h3>Tous les openings</h3>
                            <p>Tous les openings seront joués.</p>
                            <input type="hidden" id="all-input" name="all" value="">
                    </button>

                    <div id="checkbox-notall">

                        <button class="checkbox nocheck" type="button" id="top100" onclick="select_checkbox('top100')">
                            <h3>Opening dans le Top 100</h3>
                            <p>Seulement les openings appartenant au top 100 des openings peuvent être joués, la liste est sur le site <a href='https://www.ranker.com/list/best-anime-intros-and-opening-themes/lisa-waugh' target="_blank">Ranker</a>.</p>
                            <input id="top100-input" type="hidden" name="top100" value="">
                        </button>

                        <button class="checkbox nocheck" type="button" id="premier" onclick="select_checkbox('premier')">
                            <h3>Les premiers openings</h3>
                            <p>Seulement les premiers openings de toutes les animes peuvent être joués.</p>
                            <input id="premier-input" type="hidden" name="premier" value="">
                        </button>
                        
                        <button class="checkbox nocheck" type="button" id="av2000" onclick="select_checkbox('av2000')">
                            <h3>Avant 2000</h3>
                            <p>Seulement les openings des animés sortis avant l'année 2000</p>
                            <input type="hidden" id="av2000-input" name="av2000" value="">
                        </button>

                        <button class="checkbox nocheck" type="button" id="ap2000" onclick="select_checkbox('ap2000')">
                            <h3>Après 2000</h3>
                            <p>Seulement les openings des animés sortis après l'année 2000</p>
                            <input type="hidden" id="ap2000-input" name="ap2000" value="">
                        </button>

                    </div>
                </div>



                <!-- Number Range -->

                

                <div id="range-input">
                    <input min="10" class="range" type="range" name="number" id="number">
                    <p><span class="range-value" id="range-value">10</span> génériques seront joués.</p>
                </div>

                <input type="submit" id="submit-btn" value="Jouer !" class="btn highlight">
            
            <?php else : ?>

            <h1>Bienvenue sur le site Blind Test</h1>

            <p>Il est conseillé de se connecter pour pouvoir sauvegarder vos scores, <a href="login.php">connectez-vous</a>.</p>
            <p>Sinon vous pouvez jouer en invité, <a href="invite.php">cliquer ici</a>.</p>

            <?php endif; ?>

            </form>
        </div>
    </div>

    <script src="js/select.js"></script>
    
</body>
</html>