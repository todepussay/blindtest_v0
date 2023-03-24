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

$alternatif = "SELECT * FROM alternatif";
$alternatif = $connect->prepare($alternatif);
$alternatif->execute();
$alternatif = $alternatif->fetchAll();

$score_sql = "SELECT score.id_score as 'id', users.username as 'username', users.admin as 'admin' , categories.name as 'categorie', score.score as 'score', score.len as 'len', score.parameters as 'parameters', score.date_score as 'date' FROM score, users, categories WHERE score.user_id = users.id AND score.categorie_id = categories.id";
$score = $connect->prepare($score_sql);
$score->execute();
$score = $score->fetchAll();

$score_invite = "SELECT * FROM score_invite ORDER BY score DESC";
$score_invite = $connect->prepare($score_invite);
$score_invite->execute();
$score_invite = $score_invite->fetchAll();

$proposition = "SELECT proposition.id as 'id', users.username as 'username', proposition.text as 'text', proposition.date as 'date' FROM proposition, users WHERE proposition.user_id = users.id";
$proposition = $connect->prepare($proposition);
$proposition->execute();
$proposition = $proposition->fetchAll();

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
                <div class="tab tab-1" id="tab-proposition" onclick="tab_change('proposition')">
                    <span>Proposition</span>
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
                        
                        <div class="recherche">
                            <input type="text" name="recherche" id="recherche-origine" placeholder="Recherche">
                        </div>

                        <div class="tabs" id="tabs-origine">
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
                
                <div class="recherche">
                    <input type="text" name="recherche" id="recherche-user" placeholder="Recherche">
                </div>
                
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
                
                <h2>Liste des scores : </h2>

                <ul id="table-score">
                    <?php for ($i = 0; $i < count($score); $i++): ?>
                        <li>
                            <span class="<?php if($score[$i]["admin"] == 1){echo "top100";} ?>"><?= $score[$i]["username"] ?></span>
                            <span><?= ucfirst($score[$i]["categorie"]) ?></span>
                            <span><?= $score[$i]["score"] ?></span>
                            <span><?= $score[$i]["len"] ?></span>
                            <?php
                            $l = explode(',', $score[$i]["parameters"]);
                            $parameters = "";
                            if ($l[0] == 'all'){
                                $parameters = "Tous";
                            } else {
                                for ($i = 0; $i < count($l); $i++){
                                    $parameters .= ucfirst($l[$i]);
                                }
                            }
                            ?>
                            <span><?= $parameters ?></span>
                            <?php var_dump(count($score));?>
                            <span><?= $score[$i]["date"]; ?></span>
                        </li>
                    <?php endfor; ?>
                </ul>

            </div>

            <div class="tab-selection" id="tab-selection-proposition">
                    
                <h2>Liste des propositions : </h2>

                <ul id="table-proposition">
                    <?php for($i = 0; $i < count($proposition); $i++): ?>
                        <li id="proposition_<?=$i?>">       
                            <span><?= $proposition[$i]['username'] ?></span>
                            <span><?= $proposition[$i]["text"] ?></span>
                            <span><?= $proposition[$i]["date"] ?> <a href="admin-proposition-supprimer.php?id=<?= $proposition[$i]["id"] ?>">✅</a></span>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>

        </div>
    </div>

    <div id="sup-max">
        <input type="hidden" id="max_categorie" value="<?= count($categorie) ?>">
        <input type="hidden" id="max_origine" value="<?= count($origine) ?>">
        <input type="hidden" id="max_user" value="<?= count($users) ?>">
    </div>

    <div id="sup-categorie">
        <?php for($i = 0; $i < count($categorie); $i++): ?>
            <input type="hidden" id="categorie_id_<?= $i ?>" value="<?= $categorie[$i]["id"] ?>">
            <input type="hidden" id="categorie_name_<?= $i ?>" value="<?= $categorie[$i]["name"] ?>">
        <?php endfor; ?>
    </div>
    
    <div id="sup-origine">
        <?php for($i = 0; $i < count($origine); $i++): ?>
            <input type="hidden" id="origine_id_<?= $i ?>" value="<?= $origine[$i]["id"] ?>">
            <input type="hidden" id="origine_categorie_id_<?= $i ?>" value="<?= $origine[$i]["categorie_id"] ?>">
            <input type="hidden" id="origine_name_<?= $i ?>" value="<?= $origine[$i]["name"] ?>">
        <?php endfor; ?>
    </div>

    <div id="sup-user">
        <?php for($i = 0; $i < count($users); $i++): ?>
            <input type="hidden" id="user_id_<?= $i ?>" value="<?= $users[$i]["id"] ?>">
            <input type="hidden" id="user_username_<?= $i ?>" value="<?= $users[$i]["username"] ?>">
            <input type="hidden" id="user_email_<?= $i ?>" value="<?= $users[$i]["email"] ?>">
            <input type="hidden" id="user_admin_<?= $i ?>" value="<?= $users[$i]["admin"] ?>">
        <?php endfor; ?>
    </div>
    

    <script src="../js/admin.js"></script>
</body>
</html>