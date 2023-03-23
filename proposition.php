<?php

session_start();

if (!isset($_SESSION['id']) || isset($_SESSION['invite'])){
    header("Location: index.php");
}

require 'connect.php';

if (isset($_POST['text']) && !empty($_POST['text'])) {
    $text = htmlspecialchars($_POST['text']);

    $select = "SELECT * FROM proposition WHERE user_id = :id AND text = :text";
    $select = $connect->prepare($select);
    $select->bindParam(":id", $_SESSION['id']);
    $select->bindParam(":text", $text);
    $select->execute();
    $select = $select->fetchAll();

    if (count($select) == 0){
        $req = $connect->prepare("INSERT INTO proposition (user_id, text) VALUES (:id, :text)");
        $req->bindParam(":id", $_SESSION['id']);
        $req->bindParam(":text", $text);
        $req->execute();
        $resultat = "Votre proposition a bien été envoyé ! Merci de votre participation !";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposition de son</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php require('header.php'); ?>

    <div class="container">
        <div class="row">

            <h1>Proposition de son</h1>

            <form action="" method="post" id="form-proposition">
                <label for="text">Saisir la proposition de ce que vous voulez voir sur le site : </label><br>
                <textarea name="text" id="text" placeholder="Saisir ici" require></textarea><br>
                <?php if(isset($resultat)): ?>
                    <p><?= $resultat ?></p>
                    <div class="btn-box">
                        <a href="index.php" class="btn highlight">Retour à l'accueil</a>
                    </div>
                <?php endif; ?>
                <input type="submit" value="Envoyer" class="btn">
            </form>

        </div>
    </div>
    
</body>
</html>