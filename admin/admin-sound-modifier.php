<?php

require 'admin-header.php';

$sound = "SELECT * FROM sound WHERE id = :id";
$sound = $connect->prepare($sound);
$sound->bindParam(':id', $_GET['id']);
$sound->execute();
$sound = $sound->fetchAll();
$sound = $sound[0];

if (isset($_GET['name']) && isset($_GET['top100']) && isset($_GET['number'])) {
    $name = $_GET['name'];
    $top100 = $_GET['top100'];
    $number = $_GET['number'];

    $update = $connect->prepare("UPDATE sound SET title = :title, top100 = :top100, number = :number WHERE id = :id");
    $update->bindParam(':title', $name);
    $update->bindParam(':top100', $top100);
    $update->bindParam(':number', $number);
    $update->bindParam(':id', $_GET['id']);
    $update->execute();

    header('Location: admin-sound.php?id=' . $_GET['origine_id']);
}


?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <?php require '../header.php'; ?>

    <div class="container">
        <div class="row">

            <h1>Modification</h1>

            <div class="btn-box">
            <a href="admin-sound.php?id=<?= $_GET['origine_id'] ?>" class="btn">Retour</a>
            </div>

            <h2><?= $sound['title'] ?></h2>

            <form action="" method="get">

                <div class="box-input">
                    <label for="name">Nom : </label><br>
                    <input type="text" name="name" id="name" value="<?= $sound['title'] ?>">
                </div>

                <div class="box-input">
                    <label for="top100">Top 100 : </label><br>
                    <input type="number" min="0" max="1" name="top100" id="top100" value="<?= $sound['top100'] ?>">
                </div>

                <div class="box-input">
                    <label for="number">Numéro : </label><br>
                    <input type="number" min="1" max="50" name="number" id="number" value="<?= $sound['number'] ?>">
                </div>

                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <input type="hidden" name="origine_id" value="<?= $_GET['origine_id'] ?>">
                <br>
                <input type="submit" value="Modifier" class="btn highlight">

            </form>

        </div>
    </div>
    
</body>
</html>