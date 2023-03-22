<?php

require 'admin-header.php';

$categorie = $connect->prepare("SELECT categories.id as 'id', categories.name as 'name' FROM categories");
$categorie->execute();
$categorie = $categorie->fetchAll();

$origine = "SELECT * FROM origine";
$origine = $connect->prepare($origine);
$origine->execute();
$origine = $origine->fetchAll();

$users = "SELECT * FROM users";
$users = $connect->prepare($users);
$users->execute();
$users = $users->fetchAll();


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

    <?php require('../header.php'); ?>

    <div class="container">
        <div class="box" id="box-admin">

        <!-- 1er choix d'onglets -->

            <div class="tabs">
                <div class="tab tab-1" id="tab-sound" onclick="tab_change('sound')">
                    <span>Sons</span>
                </div>
                <div class="tab tab-1" id="tab-user" onclick="tab_change('user')">
                    <span>Utilisateurs</span>
                </div>
                <div class="tab tab-1" id="tab-score" onclick="tab_change('score')">
                    <span>Scores</span>
                </div>
                <div class="tab tab-1" id="tab-suggestion" onclick="tab_change('suggestion')">
                    <span>Suggestion</span>
                </div>
            </div>

        <!-- 2eme choix d'onglets -->

            <div class="tab-selection" id="tab-selection-sound">
                <div class="tabs">
                    <?php for($i = 0; $i < count($categorie); $i++) : ?>
                        <div class="tab tab-2" id="categorie<?= $categorie[$i]['id'] ?>" onclick="tab_change2('<?= $categorie[$i]['id'] ?>')">
                            <span><?= ucfirst($categorie[$i]['name']) ?></span>
                        </div>
                    <?php endfor; ?>
                </div>

                <?php for ($i = 0; $i < count($categorie); $i++): ?>
                    <div class="tab-selection2" id="tab-selection-<?= $categorie[$i]['id'] ?>">
                        <div class="tabs">
                            <?php for($j = 0; $j < count($origine); $j++) : ?>
                                <?php if($origine[$j]["categorie_id"] == $categorie[$i]["id"]) : ?>
                                    <div class="tab" id="sound<?= $origine[$j]["id"] ?>" onclick="redirect(<?= $origine[$j]['id'] ?>)">
                                        <span><?= ucfirst($origine[$j]["name"]) ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>                            
                        </div>
                    </div>
                <?php endfor; ?>

            </div>

            <div class="tab-selection" id="tab-selection-user">
                <h2>Liste des utilisateurs : </h2>

                <ul id="table-user">
                    <?php for($i = 0; $i < count($users); $i++): ?>
                        <li>
                            <span class="<?php if($users[$i]['admin'] == 1){echo 'top100';} ?>" id="username"><?= $users[$i]['username'] ?></span>
                            <span id="email"><?= $users[$i]['email'] ?></span> 
                            <span>
                                <a href="admin-user-modifier.php?id=<?= $users[$i]["id"] ?>">Modifier</a>
                                <a href="admin-user-supprimer.php?id=<?= $users[$i]["id"] ?>">Supprimer</a>
                            </span>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>

            <div class="tab-selection" id="tab-selection-score">

            </div>

            <div class="tab-selection" id="tab-selection-suggestion">

            </div>

        </div>
    </div>
    

    <script src="../js/admin.js"></script>
</body>
</html>