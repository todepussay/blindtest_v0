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
    <title>Les règles</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="asset/favicon.png">
</head>
<body>

<?php require('header.php'); ?>

    <div class="container">
        <div class="box">
            <h1>Les choses a savoir avant de jouer :</h1>
            <p>
                Tout d'abord, vous allez avoir le choix du mode de jeu selon plusieurs critères sur la page <a href="index.php">Accueil</a>. <br>
                Selon la catégorie que vous choisissez, vous allez avoir différentes musiques à deviner. <br>
                Vous avez le choix entre <?=count($table) + 1;?> catégories : Tout <?php foreach($table as $category){echo " - " . ucfirst($category['name']);} ?> <br>
                <br><br>
                La catégorie "Tout" vous permet de jouer à toutes les catégories suivantes. <br>
                La catégorie "Opening" vous permet de jouer les génériques d'animés. <br>
                <br><br>
                Pour chaque catégorie, vous avez différent paramétre de personnalisation. <br>
                <br><br>
                Pendant le jeu, vous allez avoir une musique qui sera jouer. Vous avez 20 secondes pour répondre aux questions. <br>
                Pour répondre, vous allez avoir un champ de saisie, entrez votre réponse et sélectionnez votre réponse dans la liste déroulante. <br>
                Les questions dépendent des catégories mais resterons toujours les mêmes. <br>
                <br><br>
                Le score est défini selon la difficulté de la question. <br>
            </p>

            <a href="index.php" class="btn">Retour</a>
        </div>
    </div>
    
</body>
</html>