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

if (isset($_GET['yes'])) {
    $delete_sound = "DELETE FROM sound WHERE origine_id = :id";
    $delete_sound = $connect->prepare($delete_sound);
    $delete_sound->bindParam(':id', $_GET['id']);
    $delete_sound->execute();

    $delete_origine = "DELETE FROM origine WHERE id = :id";
    $delete_origine = $connect->prepare($delete_origine);
    $delete_origine->bindParam(':id', $_GET['id']);
    $delete_origine->execute();

    for ($i = 0; $i < count($sound); $i++) {
        unlink('../opening/' . $sound[$i]['id_sound'] . '.m4a');
    }
    
    header('Location: admin.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppresion de l'origine</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="asset/favicon.png">
</head>
<body>

    <?php require '../header.php'; ?>
    
    <div class="container">
        <div class="row">

            <h1>Suppresion</h1>

            <div class="btn-box">
                <a href="admin-sound.php?id=<?= $_GET['id'] ?>" class="btn">Retour</a>
            </div>

            <h2><?= $origine['name'] ?></h2>

            <p id="suppresion">Êtes-vous sur de vouloir supprimer <?= $origine['name'] ?> de la base de données, avec toutes les dépendances ?</p>

            <form action="" method="get">
                <input type="hidden" name="yes" value="1">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                
                <div class="btn-box">
                    <button type="submit" class="btn highlight">Oui</button>
                </div>

            </form>

        </div>
    </div>

</body>
</html>