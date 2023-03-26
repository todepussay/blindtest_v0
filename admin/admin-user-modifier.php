<?php

require "admin-header.php";

$users = "SELECT * FROM users WHERE id = :id";
$users = $connect->prepare($users);
$users->bindParam(":id", $_GET['id']);
$users->execute();
$users = $users->fetchAll();
$users = $users[0];

if (isset($_GET['name']) && isset($_GET['email']) && isset($_GET['admin'])) {
    $name = $_GET['name'];
    $email = $_GET['email'];
    $admin = $_GET['admin'];

    $update = $connect->prepare("UPDATE users SET username = :username, email = :email, admin = :admin WHERE id = :id LIMIT 1");
    $update->bindParam(':username', $name);
    $update->bindParam(':email', $email);
    $update->bindParam(':admin', $admin);
    $update->bindParam(':id', $_GET['id']);
    $update->execute();

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
</head>
<body>

    <?php require "../header.php"; ?>

    <div class="container">
        <div class="row">

            <h1>Modification du joueur</h1>

            <div class="btn-box">
                <a href="admin.php" class="btn">Retour</a>
            </div>

            <h2><?= $users['username'] ?></h2>

            <form action="" method="get">

                <div class="box-input">
                    <label for="name">Nom d'utilisateur : </label><br>
                    <input type="text" name="name" id="name" value="<?= $users['username'] ?>">
                </div>

                <div class="box-input">
                    <label for="email">Email : </label><br>
                    <input type="text" name="email" id="email" value="<?= $users['email'] ?>">
                </div>

                <div class="box-input">
                    <label for="admin">Admin : </label><br>
                    <input type="number" min="0" max="1" name="admin" id="admin" value="<?= $users['admin'] ?>">
                </div>

                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <br>
                <input type="submit" value="Modifier" class="btn highlight">

            </form>

        </div>
    </div>

</body>
</html>