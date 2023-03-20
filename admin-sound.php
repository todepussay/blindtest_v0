<?php

if ($_SESSION['admin'] == 0 || !isset($_SESSION['id']) || !isset($_SESSION['admin']) || isset($_SESSION['invite'])) {
    header('Location: index.php');
}

require 'connect.php';

$sound = "SELECT * FROM sound WHERE id = :id";
$sound = $connect->prepare($sound);
$sound->bindParam(':id', $_GET['id']);
$sound->execute();
$sound = $sound->fetchAll();
$sound = $sound[0];

var_dump($sound);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sound</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php require('header.php'); ?>

    <div class="container">
        <div class="row">

        </div>
    </div>
    
</body>
</html>