<?php

session_start();

require('connect.php');

if (isset($_SESSION['id'])) {
    $sql = $connect->prepare('SELECT * FROM users WHERE id = :id');
    $sql->bindValue(':id', $_SESSION['id']);
    $sql->execute();
    $table = $sql->fetchAll();
    $user = $table[0];
} else {
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profils - <?= $user['username']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php require('header.php'); ?>

    <div class="container">
        <div class="box">
            <h1>Profils de <?= $user['username'] ?></h1>
        </div>
    </div>
    
</body>
</html>