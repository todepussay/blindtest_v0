<?php

session_start();

if(!isset($_SESSION['id']) && !isset($_SESSION['invite'])) {
    header('Location: index.php');
}

if (!isset($_POST['categorie']) || !isset($_POST['score'])) {
    header('Location: index.php');
}

require "connect.php";



if (!isset($_SESSION['id'])) {

    $sql_select = "SELECT * FROM score_invite WHERE invite_id = :invite_id AND categorie_id = :categorie_id AND score = :score AND len = :len AND parameters = :parameters";
    $sql = $connect->prepare($sql_select);
    $sql->bindParam(':invite_id', $_SESSION['invite']);
    $sql->bindParam(':categorie_id', $_POST['categorie']);
    $sql->bindParam(':score', $_POST['score']);
    $sql->bindParam(':len', $_POST['number']);

    $parameters_select = "";

    if ($_POST['all'] == 1){
        $parameters_select .= "all,";
    }
    if ($_POST['top100'] == 1){
        $parameters_select .= "top100,";
    }
    if ($_POST['premier'] == 1){
        $parameters_select .= "premier,";
    }
    if ($_POST['av2000'] == 1){
        $parameters_select .= "av2000,";
    }
    if ($_POST['ap2000'] == 1){
        $parameters_select .= "ap2000,";
    }

    $sql_select->bindParam(':parameters', $parameters_select);
    $sql_select->execute();


    $sql = "INSERT INTO  score_invite (invite_id, categorie_id, score, len, parameters) VALUES (:invite_id, :categorie_id, :score, :len, :parameters    )";

    $sql = $connect->prepare($sql);

    $sql->bindParam(':invite_id', $_SESSION['invite']);
    $sql->bindParam(':categorie_id', $_POST['categorie']);
    $sql->bindParam(':score', $_POST['score']);
    $sql->bindParam(':len', $_POST['number']);

    $parameters = "";

    if ($_POST['all'] == 1){
        $parameters .= "all,";
    }
    if ($_POST['top100'] == 1){
        $parameters .= "top100,";
    }
    if ($_POST['premier'] == 1){
        $parameters .= "premier,";
    }
    if ($_POST['av2000'] == 1){
        $parameters .= "av2000,";
    }
    if ($_POST['ap2000'] == 1){
        $parameters .= "ap2000,";
    }

    $sql->bindParam(':parameters', $parameters);
    $sql->execute();

} else {

    $sql = "INSERT INTO  score (user_id, categorie_id, score, len, parameters) VALUES (:invite_id, :categorie_id, :score, :len, :parameters    )";

    $sql = $connect->prepare($sql);

    $sql->bindParam(':user_id', $_SESSION['id']);
    $sql->bindParam(':categorie_id', $_POST['categorie']);
    $sql->bindParam(':score', $_POST['score']);
    $sql->bindParam(':len', $_POST['number']);

    $parameters = "";

    if ($_POST['all'] == 1){
        $parameters .= "all,";
    }
    if ($_POST['top100'] == 1){
        $parameters .= "top100,";
    }
    if ($_POST['premier'] == 1){
        $parameters .= "premier,";
    }
    if ($_POST['av2000'] == 1){
        $parameters .= "av2000,";
    }
    if ($_POST['ap2000'] == 1){
        $parameters .= "ap2000,";
    }

    $sql->bindParam(':parameters', $parameters);
    $sql->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fin de jeu - BlindTest</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php require 'header.php'; ?>

    <div class="container">
        <div class="box">

            <h1>Fin de jeu</h1>

            <?php if(isset($_SESSION['invite']) && !isset($_SESSION['id'])): ?>
                <p>Vous avez un score de <strong><?= $_POST['score'] ?></strong>.</p>
                <p>Malheureusement vous n'êtes pas connecté votre score ne sera pas sauvegarder.</p>
                <p><a href="login.php">Connectez-vous</a> pour sauvegarder votre score.</p>
            <?php else: ?>
                <p>Vous avez un score de <strong><?= $_POST['score'] ?></strong>.</p>
                <p>Votre score a été sauvegarder.</p>
            <?php endif; ?>

            <a href="index.php" class="btn">Retour</a>

        </div>
    </div>
    
</body>
</html>
