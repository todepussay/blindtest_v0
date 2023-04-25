<?php

session_start();

if(!isset($_SESSION['id']) && !isset($_SESSION['invite'])) {
    header('Location: index.php');
}

if (!isset($_POST['categorie']) || !isset($_POST['score'])) {
    header('Location: index.php');
}

require "connect.php";

$today = getdate();
    
$date = "";
$date .= $today['year'] . "-";
if ($today['mon'] < 10) {
    $date .= "0" . $today['mon'] . "-";
} else {
    $date .= $today['mon'] . "-";
}
if ($today['mday'] < 10) {
    $date .= "0" . $today['mday'] . " ";
} else {
    $date .= $today['mday']. " ";
}
$date .= $today['hours'] . ":";
$date .= $today['minutes'];

if (!isset($_SESSION['id'])) {

    $sql_select = "SELECT id_score_invite FROM score_invite WHERE invite_id = :invite_id AND categorie_id = :categorie_id AND score = :score AND len = :len AND parameters = :parameters";
    $sql_select = $connect->prepare($sql_select);
    $sql_select->bindParam(':invite_id', $_SESSION['invite']);
    $sql_select->bindParam(':categorie_id', $_POST['categorie']);
    $sql_select->bindParam(':score', $_POST['score']);
    $sql_select->bindParam(':len', $_POST['number']);

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
    $result = $sql_select->fetchAll();

    echo count($result); 
    
    if (count($result) == 0){
        
        $sql = "INSERT INTO  score_invite (invite_id, categorie_id, score, len, parameters, date_score) VALUES (:invite_id, :categorie_id, :score, :len, :parameters, :date_score)";

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
        $sql->bindParam(':date_score', $date);
        $sql->execute();

    }

} else {

    $sql_user_select = "SELECT id_score FROM score WHERE user_id = :user_id AND categorie_id = :categorie_id AND score = :score AND len = :len AND parameters = :parameters AND date_score = :date_score";
    $sql_user_select = $connect->prepare($sql_user_select);
    $sql_user_select->bindParam(':user_id', $_SESSION['id']);
    $sql_user_select->bindParam(':categorie_id', $_POST['categorie']);
    $sql_user_select->bindParam(':score', $_POST['score']);
    $sql_user_select->bindParam(':len', $_POST['number']);

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

    $sql_user_select->bindParam(':parameters', $parameters_select);
    $sql_user_select->bindParam(':date_score', $date);
    $sql_user_select->execute();
    $result = $sql_user_select->fetchAll();

    if (count($result) == 0){

        $sql_user = "INSERT INTO  score (user_id, categorie_id, score, len, parameters, date_score) VALUES (:user_id, :categorie_id, :score, :len, :parameters, :date_score)";

        $sql_user = $connect->prepare($sql_user);

        $sql_user->bindParam(':user_id', $_SESSION['id']);
        $sql_user->bindParam(':categorie_id', $_POST['categorie']);
        $sql_user->bindParam(':score', $_POST['score']);
        $sql_user->bindParam(':len', $_POST['number']);

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
        
        $sql_user->bindParam(':parameters', $parameters);
        $sql_user->bindParam(':date_score', $date);
        $sql_user->execute();
    }
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
    <link rel="icon" href="asset/favicon.png">
</head>
<body>

    <?php require 'header.php'; ?>

    <div class="container">
        <div class="box">

            <h1>Fin de jeu</h1>

            <?php if(isset($_SESSION['invite']) && !isset($_SESSION['id'])): ?>
                <p>Vous avez un score de <strong><?= $_POST['score'] ?></strong>.</p>
                <p>Malheureusement vous n'êtes pas connecté votre score ne sera pas sauvegarder.</p>
            <?php else: ?>
                <p>Vous avez un score de <strong><?= $_POST['score'] ?></strong>.</p>
                <p>Votre score a été sauvegarder.</p>
            <?php endif; ?>

            <div class="wrap">
                <?php if(isset($_SESSION['invite']) && !isset($_SESSION['id'])): ?>
                    <a href="login.php" class="btn highlight">Se connecter</a>
                <?php endif; ?>
                <a href="index.php" class="btn">Retour</a>
            </div>

        </div>
    </div>
    
</body>
</html>
