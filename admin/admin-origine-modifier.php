<?php 

require 'admin-header.php';

$origine = $connect->prepare("SELECT * FROM origine WHERE id = :id");
$origine->bindParam(':id', $_GET['id']);
$origine->execute();
$origine = $origine->fetchAll();
$origine = $origine[0];

if (isset($_GET['name']) && isset($_GET['annee'])) {
    $name = $_GET['name'];
    $annee = $_GET['annee'];

    $update = $connect->prepare("UPDATE origine SET name = :name, annee = :annee WHERE id = :id");
    $update->bindParam(':name', $name);
    $update->bindParam(':annee', $annee);
    $update->bindParam(':id', $_GET['id']);
    $update->execute();

    header('Location: admin-sound.php?id=' . $_GET['id']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de l'origine</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <?php require "../header.php"; ?>

    <div class="container">
        <div class="row">

            <h1>Modification</h1>

            <div class="btn-box">
                <a href="admin-sound.php?id=<?= $_GET['id'] ?>" class="btn">Retour</a>
            </div>

            <h2><?= $origine['name'] ?></h2>

            <form action="" method="get">

                <div class="box-input">
                    <label for="name">Nom : </label><br>
                    <input type="text" name="name" id="name" value="<?= $origine['name'] ?>">
                </div>
                <div class="box-input">
                    <label for="annee">Année : </label><br>
                    <input type="text" name="annee" id="name" value="<?= $origine['annee'] ?>">
                </div>

                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <br>
                <input type="submit" value="Modifier" class="btn highlight">

            </form>

        </div>
    </div>
    
</body>
</html>