<?php

require "admin-header.php";

if (isset($_POST['n']) && isset($_POST['origine_name'])){
    
    $select = "SELECT * FROM origine WHERE categorie_id = :categorie_id AND name = :name";
    $select = $connect->prepare($select);
    $select->bindParam(':categorie_id', $_POST['categorie']);
    $select->bindParam(':name', $_POST['origine_name']);
    $select->execute();
    $select = $select->fetchAll();

    if (count($select) == 0){

        $insert = "INSERT INTO origine (categorie_id, name, annee) VALUES (:categorie_id, :name, :annee)";
        $insert = $connect->prepare($insert);
        $insert->bindParam(':categorie_id', $_POST['categorie']);
        $insert->bindParam(':name', $_POST['origine_name']);
        $insert->bindParam(':annee', $_POST['origine_annee']);
        $insert->execute();

        $id = "SELECT id FROM origine WHERE categorie_id = :categorie_id AND name = :name";
        $id = $connect->prepare($id);
        $id->bindParam(':categorie_id', $_POST['categorie']);
        $id->bindParam(':name', $_POST['origine_name']);
        $id->execute();
        $id = $id->fetchAll();
        $id = $id[0]['id'];

        for ($i = 1; $i <= $_POST['n']; $i++){

            $insert_sound = "INSERT INTO sound (origine_id, title, number, top100) VALUES (:origine_id, :title, :number, :top100)";
            $insert_sound = $connect->prepare($insert_sound);
            $insert_sound->bindParam(':origine_id', $id);
            $insert_sound->bindParam(':title', $_POST['title_' . $i]);
            $insert_sound->bindParam(':number', $i);
            $insert_sound->bindParam(':top100', $_POST['top100_' . $i]);
            $insert_sound->execute();

            $id_sound = "SELECT id FROM sound WHERE origine_id = :origine_id AND title = :title AND number = :number";
            $id_sound = $connect->prepare($id_sound);
            $id_sound->bindParam(':origine_id', $id);
            $id_sound->bindParam(':title', $_POST['title_' . $i]);
            $id_sound->bindParam(':number', $i);
            $id_sound->execute();
            $id_sound = $id_sound->fetchAll();
            $id_sound = $id_sound[0]['id'];

            $_FILES["file_" . $i]["name"] = $id_sound . ".m4a";
            move_uploaded_file($_FILES["file_" . $i]["tmp_name"], "../opening/" . $_FILES["file_" . $i]["name"]);
        }

    } else {
        $erreur = "Cette oeuvre existe déjà.";
    }
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

            <h1>Ajouter :</h1>

            <p>Vous avez ajouté une nouvelle oeuvre avec succès.</p>

            <?php if(isset($erreur)): ?>
                <p><?= $erreur ?></p>
            <?php endif; ?>

            <div class="btn-box">
                <a href="admin.php" class="btn">Retour</a>
            </div>

        </div>
    </div>
    
</body>
</html>