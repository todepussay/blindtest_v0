<?php

session_start();

require('connect.php');

if (isset($_SESSION['id'])){
    header('Location: index.php');
} else {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])){
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $sql = $connect->prepare('SELECT * FROM users WHERE email = :email');
            $sql->bindValue(':email', $email);
            $sql->execute();
            $table = $sql->fetchAll();

            if (count($table) == 1 && password_verify($password, $table[0]['password'])) {
                $_SESSION['id'] = $table[0]['id'];
                $_SESSION['username'] = $table[0]['username'];
                $_SESSION['email'] = $table[0]['email'];
                $_SESSION['admin'] = $table[0]['admin'];

                if (isset($_SESSION['invite'])){
                    $sql_score = "SELECT * FROM score_invite WHERE invite_id = :invite";
                    $sql_score = $connect->prepare($sql_score);
                    $sql_score->bindParam(":invite", $_SESSION['invite']);
                    $sql_score->execute();
                    $score_temp = $sql_score->fetchAll();

                    var_dump($score_temp);

                    if (count($score_temp) > 0){
                        for ($i = 0; $i < count($score_temp); $i++){
                            $sql_inject = "INSERT INTO score (user_id, categorie_id, score, len, parameters, date) VALUES (:user_id, :categorie_id, :score, :len, :parameters, :date)";
                            $sql_inject = $connect->prepare($sql_inject);
                            $sql_inject->bindParam(":user_id", $_SESSION['id']);
                            $sql_inject->bindParam(":categorie_id", $score_temp[$i]["categorie_id"]);
                            $sql_inject->bindParam(":score", $score_temp[$i]["score"]);
                            $sql_inject->bindParam(":len", $score_temp[$i]["len"]);
                            $sql_inject->bindParam(":parameters", $score_temp[$i]["parameters"]);
                            $sql_inject->bindParam(":date", $score_temp[$i]["date"]);
                            $sql_inject->execute();

                            $sql_delete = "DELETE FROM score_invite WHERE id = :id LIMIT 1";
                            $sql_delete = $connect->prepare($sql_delete);
                            $sql_delete->bindParam(":id", $score_temp[$i]["id"]);
                            $sql_delete->execute();
                        }
                    }
                    unset($_SESSION['invite']);
                }

                header('Location: index.php');
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect";
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
    <title>Se connecter</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php require('header.php'); ?>

    <div class="container">
        <div class="box">

            <h1>Se connecter</h1>

            <form action="" method="post">
                <div class="input">
                    <label for="email">Email</label><br>
                    <input type="text" name="email" id="email">
                </div>
                <div class="input">
                    <label for="password">Mot de passe</label><br>
                    <input type="password" name="password" id="password">
                </div>

                <div class="error">
                    <?php if (isset($error)) { echo $error; } ?>
                </div>

                <input type="submit" value="Se connecter" class="btn">

                <p>Vous n'avez pas de compte ? <a href="signin.php">S'inscrire</a></p>

            </form>


        </div>
    </div>
    
</body>
</html>