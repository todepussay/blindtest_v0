<?php

session_start();

if ($_SESSION['admin'] == 0 || !isset($_SESSION['id']) || !isset($_SESSION['admin']) || isset($_SESSION['invite'])) {
    header('Location: index.php');
}

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
                <div class="tab tab-active" id="tab-categorie">
                    <span>Catégories</span>
                </div>
                <div class="tab" id="tab-sound">
                    <span>Sons</span>
                </div>
                <div class="tab" id="tab-user">
                    <span>Utilisateurs</span>
                </div>
                <div class="tab" id="tab-score-invite">
                    <span>Scores Invité</span>
                </div>
                <div class="tab" id="tab-score">
                    <span>Scores</span>
                </div>
                <div class="tab" id="tab-suggestion">
                    <span>Suggestion</span>
                </div>

                <

            </div>
        </div>
    </div>
    
</body>
</html>