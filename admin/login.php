<?php

session_start();

if (isset($_SESSION['admin_user']) && isset($_SESSION['admin_password'])){
    header('Location: admin.php');
}

if ($_SESSION['admin'] == 0 || !isset($_SESSION['id']) || !isset($_SESSION['admin']) || isset($_SESSION['invite']) || isset($_SESSION['admin_user'])) {
    header('Location: ../index.php');
}

if (isset($_POST['user']) && isset($_POST['password'])){
    if (!empty($_POST['user']) && !empty($_POST['password'])){
        $user = htmlspecialchars($_POST['user']);
        $password = htmlspecialchars($_POST['password']);

        
        try {
            $connect = new PDO('mysql:host=localhost;dbname=blindtest', $user, $password);
            $connect->query('SET NAMES UTF8');
            $_SESSION['admin_user'] = $user;
            $_SESSION['admin_password'] = $password;
            header('Location: admin.php');
        } catch (Exception $e) {
            echo "Connection à MySQL impossible : ", $e->getMessage();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <?php require '../header.php'; ?>

    <div class="container">
        <div class="box">

            <h1>Connexion Admin</h1>

            <form action="" method="post">

                <div class="input">
                    <label for="user">User : </label><br>
                    <input type="text" name="user" id="user">
                </div>
                <div class="input">
                    <label for="password">Mot de passe : </label><br>
                    <input type="password" name="password" id="password">
                </div>

                <div class="error">
                    <?php if (isset($error)) { echo $error; } ?>
                </div>

                <input type="submit" value="Se connecter" class="btn">

            </form>
    
        </div>
    </div>
    
</body>
</html>