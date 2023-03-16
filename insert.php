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