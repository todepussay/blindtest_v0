<?php

session_start();

if ($_SESSION['admin'] == 0 || !isset($_SESSION['id']) || !isset($_SESSION['admin']) || isset($_SESSION['invite'])) {
    header('Location: index.php');
}

require 'connect.php';

$categorie = $connect->prepare("SELECT categories.id as 'id', categories.name as 'name' FROM categories");
$categorie->execute();
$categorie = $categorie->fetchAll();

$origine = "SELECT * FROM origine";
$origine = $connect->prepare($origine);
$origine->execute();
$origine = $origine->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php require('header.php'); ?>

    <div class="container">
        <div class="box" id="box-admin">

            <div class="tabs">
                <div class="tab tab-active" id="tab-sound">
                    <span>Sons</span>
                </div>
                <div class="tab" id="tab-user">
                    <span>Utilisateurs</span>
                </div>
                <div class="tab" id="tab-score">
                    <span>Scores</span>
                </div>
                <div class="tab" id="tab-suggestion">
                    <span>Suggestion</span>
                </div>
            </div>

            <div class="tab-selection" id="tab-selection-sound">
                <div class="tabs">
                    <?php for($i = 0; $i < count($categorie); $i++) : ?>
                        <div class="tab tab-active" id="categorie<?= $categorie[$i]['id'] ?>">
                            <span><?= ucfirst($categorie[$i]['name']) ?></span>
                        </div>
                    <?php endfor; ?>
                </div>

                <?php for ($i = 0; $i < count($categorie); $i++): ?>
                    <div class="tab-selection" id="tab-selection-<?= $categorie[$i]['name'] ?>">
                        <div class="tabs">
                            <?php for($j = 0; $j < count($origine); $j++) : ?>
                                <?php if($origine[$j]["categorie_id"] == $categorie[$i]["id"]) : ?>
                                    <div class="tab" id="sound<?= $origine[$j]["id"] ?>">
                                        <span><?= ucfirst($origine[$j]["name"]) ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>                            
                        </div>
                    </div>
                <?php endfor; ?>

            </div>

        </div>
    </div>
    
</body>
</html>