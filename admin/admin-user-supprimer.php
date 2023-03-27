<?php

require "admin-header.php";

$users = "SELECT * FROM users WHERE id = :id";
$users = $connect->prepare($users);
$users->bindParam(':id', $_GET['id']);
$users->execute();
$users = $users->fetchAll();
$users = $users[0];

if (isset($_GET['yes'])){
    $score = "DELETE FROM score WHERE user_id = :id";
    $score = $connect->prepare($score);
    $score->bindParam(':id', $_GET['id']);
    $score->execute();

    $proposition = "DELETE FROM proposition WHERE user_id = :id";
    $proposition = $connect->prepare($proposition);
    $proposition->bindParam(':id', $_GET['id']);
    $proposition->execute();

    $delete = "DELETE FROM users WHERE id = :id";
    $delete = $connect->prepare($delete);
    $delete->bindParam(':id', $_GET['id']);
    $delete->execute();
    
    header('Location: admin.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="asset/favicon.png">
</head>
<body>

    <?php require "../header.php"; ?>

    <div class="container">
        <div class="row">

        <h1>Suppresion de joueur</h1>

        <div class="btn-box">
            <a href="admin.php" class="btn">Retour</a>
        </div>

        <?php if($users['admin'] == 0): ?>

            <p id="suppresion">Êtes-vous sur de vouloir supprimer <?= $users['username'] ?> de la base de données, avec toutes les dépendances ?</p>

            <form action="" method="get">
                <input type="hidden" name="yes" value="1">

                <div class="btn-box">
                    <button type="submit" class="btn highlight">Oui</button>
                </div>

            </form>

        <?php else : ?>

            <p id="suppresion">L'utilisateur est un administrateur, il ne peut pas être supprimer maintenant.</p>

        <?php endif; ?>

        </div>
    </div>
    
</body>
</html>