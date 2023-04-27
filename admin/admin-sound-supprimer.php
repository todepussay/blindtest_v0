<?php

require 'admin-header.php';

$sound = "SELECT * FROM sound WHERE id_sound = :id";
$sound = $connect->prepare($sound);
$sound->bindParam(':id', $_GET['id']);
$sound->execute();
$sound = $sound->fetchAll();
$sound = $sound[0];

if (isset($_GET['yes'])) {
    $delete = "DELETE FROM sound WHERE id_sound = :id LIMIT 1";
    $delete = $connect->prepare($delete);
    $delete->bindParam(':id', $_GET['id']);
    $delete->execute();

    unlink('../opening/' . $sound['id'] . '.m4a');

    header('Location: admin-sound.php?id=' . $_GET['origine_id']);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppresion</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="asset/favicon.png">
</head>
<body>

    <?php require '../header.php'; ?>

    <div class="container">
        <div class="row">

            <h1>Suppresion</h1>

            <div class="btn-box">
                <a href="admin-sound.php?id=<?= $_GET['origine_id'] ?>" class="btn">Retour</a>
            </div>

            <h2><?= $sound['title'] ?></h2>

            <p id="suppresion">Êtes-vous sur de vouloir supprimer <?= $sound['title'] ?> de la base de données ?</p>

            <form action="" method="get">
                <input type="hidden" name="yes" value="1">
                <input type="hidden" name="origine_id" value="<?= $_GET['origine_id'] ?>">
                
                <div class="btn-box">
                    <button type="submit" class="btn highlight">Oui</button>
                </div>

            </form>

        </div>
    </div>
    
</body>
</html>