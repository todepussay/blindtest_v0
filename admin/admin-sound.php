<?php

require 'admin-header.php';

$origine = "SELECT * FROM origine WHERE id = :id";
$origine = $connect->prepare($origine);
$origine->bindParam(':id', $_GET['id']);
$origine->execute();
$origine = $origine->fetchAll();
$origine = $origine[0];

$sound = "SELECT * FROM sound WHERE origine_id = :id";
$sound = $connect->prepare($sound);
$sound->bindParam(':id', $_GET['id']);
$sound->execute();
$sound = $sound->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sound</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="asset/favicon.png">
</head>
<body>

    <?php require('../header.php'); ?>

    <div class="container">
        <div class="row" id="admin-sound">

            <h1>Information</h1>

            <div class="btn-box">
                <a href="admin.php" class="btn">Retour</a>
            </div>

            <h2><?= $origine['name'] ?> (<?= $origine['annee'] ?>)</h2>

            <ul>
                <?php for($i = 0; $i < count($sound); $i++): ?>
                    <li class="<?php if($sound[$i]['top100'] == 1){echo 'top100';} ?>">
                        <?= $sound[$i]['number'] ?>. <?= $sound[$i]['title'] ?> <br>
                        <audio controls src="../opening/<?= $sound[$i]["id_sound"] ?>.m4a"></audio><br>
                        <a href="admin-sound-modifier.php?id=<?= $sound[$i]['id_sound'] ?>&origine_id=<?= $origine['id'] ?>">Modifier</a>
                        <a href="admin-sound-supprimer.php?id=<?= $sound[$i]['id_sound'] ?>&origine_id=<?= $origine['id'] ?>">Supprimer</a>
                    </li>
                <?php endfor; ?>
            </ul>

            <div class="btn-box">
                <a href="admin-origine-modifier.php?id=<?= $_GET['id'] ?>" class="btn highlight">Modifier</a>
                <a href="admin-origine-supprimer.php?id=<?= $_GET['id'] ?>" class="btn">Supprimer</a>
            </div>

        </div>
    </div>
    
</body>
</html>