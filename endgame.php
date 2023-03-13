<?php
<<<<<<< HEAD
e
=======
eee
>>>>>>> a49d7adaa6fbc7e3b77f1f90ca618ea87a5c467b
session_start();

if(!isset($_SESSION['id']) && !isset($_SESSION['invite'])) {
    header('Location: index.php');
}

if (!isset($_POST['categorie']) || !isset($_POST['score'])) {
    header('Location: index.php');
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

            <p>Vous avez un score de <?= $_POST['score'] ?> !</p>

        </div>
    </div>
    
</body>
</html>
