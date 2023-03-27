<?php

session_start();

require('connect.php');

if (isset($_SESSION['username'])) {
    header('Location: index.php');
} else {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])) {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password2 = htmlspecialchars($_POST['password2']);

        if (!empty($username) && !empty($email) && !empty($password) && !empty($password2)) {
            if ($password == $password2) {

                $sql = $connect->prepare('SELECT * FROM users WHERE email = :email');
                $sql->bindValue(':email', $email);
                $sql->execute();
                $table1 = $sql->fetchAll();

                if (count($table1) == 0) {
                    $sql = $connect->prepare('SELECT * FROM users WHERE username = :username');
                    $sql->bindValue(':username', $username);
                    $sql->execute();
                    $table2 = $sql->fetchAll();

                    if (count($table2) == 0){
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $sql = $connect->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
                        $sql->bindValue(':username', $username);
                        $sql->bindValue(':email', $email);
                        $sql->bindValue(':password', $password);
                        $sql->execute();

                        header('Location: login.php');
                    } else {
                        $error = "Ce nom d'utilisateur est déjà utilisé";
                    }

                } else {
                    $error = "Cette adresse e-mail est déjà utilisée";
                }
            } else {
                $error = "Les mots de passe ne correspondent pas";
            }
        } else {
            $error = "Veuillez remplir tous les champs";
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
    <title>S'identifier</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="asset/favicon.png">
</head>
<body>

    <?php require('header.php'); ?>

    <div class="container">
        <div class="box">
            <h1>Création de compte</h1>
            <form action="" method="post">
                <div class="input">
                    <label for="username">Nom d'utilisateur :</label><br>
                    <input type="text" name="username" id="username" required autofocus autocomplete="off">
                </div>
                <div class="input">
                    <label for="email">Adresse e-mail :</label><br>
                    <input type="email" name="email" id="email" required autocomplete="off">
                </div>
                <div class="input">
                    <label for="password">Mot de passe :</label><br>
                    <input type="password" name="password" id="password" required autocomplete="off">
                </div>
                <div class="input">
                    <label for="password2">Confirmer le mot de passe :</label><br>
                    <input type="password" name="password2" id="password2" required autocomplete="off">
                </div>

                <div class="error">
                    <?php if (isset($error)) { echo $error; } ?>
                </div>

                <input type="submit" value="S'identifier" class="btn">

                <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous</a></p>

            </form>

        </div>
    </div>
    
</body>
</html>