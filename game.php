<?php

session_start();

require('connect.php');

if(!isset($_SESSION['id']) && !isset($_SESSION['invite'])) {
    header('Location: index.php');
}

if (!isset($_POST['categorie']) || $_POST['categorie'] == -2) {
    header('Location: index.php');
}

$categorie_id = $_POST['categorie'];

$categorie_sql = $connect->prepare("SELECT name FROM categories WHERE id = :id");
$categorie_sql->bindValue(':id', $categorie_id);
$categorie_sql->execute();
$categorie_sql = $categorie_sql->fetchAll();
$categorie_name = ucfirst($categorie_sql[0]['name']);



$sound_sql = "SELECT origine.id as 'origine_id', origine.name as 'origine', sound.id as 'id', sound.title as 'title', sound.number as 'number_opening' FROM origine, sound, categories WHERE categories.id = origine.categorie_id AND sound.origine_id = origine.id AND categories.id = :categorie_id";

if ($_POST['top100'] == 1){
    $sound_sql .= " AND sound.top100 = 1";
}
if ($_POST['premier'] == 1){
    $sound_sql .= " AND sound.number = 1";
    $premier = 1;
}
if ($_POST['av2000'] == 1){
    $sound_sql .= " AND origine.annee < 2000";
}
if ($_POST['ap2000'] == 1){
    $sound_sql .= " AND origine.annee > 2000";
}

$sound_sql .= " ORDER BY RAND() LIMIT :number ";

$sound_sql = $connect->prepare($sound_sql);
$sound_sql->bindValue(':categorie_id', $categorie_id);
$sound_sql->bindValue(':number', $_POST['number'], PDO::PARAM_INT);
$sound_sql->execute();
$array = $sound_sql->fetchAll();


$title = $connect->prepare("SELECT origine.id, origine.name FROM origine WHERE origine.categorie_id = :id ORDER BY origine.name ASC");
$title->bindValue(':id', $categorie_id);
$title->execute();
$origine_array = $title->fetchAll();

$title_sound = $connect->prepare("SELECT sound.id as 'sound_id', sound.title as 'sound_title' FROM sound, origine WHERE sound.origine_id = origine.id AND origine.categorie_id = :id");
$title_sound->bindValue(':id', $categorie_id);
$title_sound->execute();
$title_sound_array = $title_sound->fetchAll();

$alternatif = $connect->prepare("SELECT alternatif.id as 'alternatif_id', origine.id as 'origine_id', alternatif.name as 'alternatif_name' FROM alternatif, origine WHERE alternatif.origine_id = origine.id AND origine.categorie_id = :id");
$alternatif->bindValue(':id', $categorie_id);
$alternatif->execute();
$alternatif_array = $alternatif->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu - <?= $categorie_name ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php require('header.php'); ?>

    <div id="container-overlay">
        <div id="begin" class="begin">

            <h2 id="title-begin">Le jeu va commencer ! <br> Attention le son peut être très fort selon le générique.</h2>


            <div id="time-box-begin">
                    <span id="time-begin">03</span>
            </div>

            <button class="btn" id="btn-begin">Commencer !</button>
        </div>
    </div>


    <div class="container" id="container-game">

        <div class="box-game">

            <div class="bar">
                
                <h2 id="score-game">Score : <span id="score">0</span></h1>

                <div id="time-box">
                    <span id="time">30</span>
                </div>
                
                <div class="progress-box">
                    <span>Générique <span id="number-progression">1</span> / <?= $_POST['number']; ?><span>
                    <div id="progress">
                        <div id="value"></div>
                    </div>
                </div>
                
            </div>

            <div id="question-box">
                <span class="question-txt">Question : <span id="question">De quel anime est tiré ce générique ?</span> <span id="answer_origine"></span></span><br>
                <?php if (!isset($premier)) : ?>
                    <span class="question-txt" id="question-bonus1">Question : Quel est le numéro de l'opening ? <span id="answer_number"></span></span>
                <?php endif; ?>
                <span class="question-txt" id="question-bonus2">Question : Quel est le titre de l'opening ? <span id="answer_title"></span></span>
            </div>

            <div class="input-box-proposition">
                <div class="input-box" id="animation">
                    <ion-icon id="search-ico" name="search-outline"></ion-icon>
                    <input autocomplete="off" placeholder="Saisir votre proposition" type="search" name="search" onkeyup="keyboard()" id="search">
                    <ion-icon id="del" name="close-outline"></ion-icon>
                    <ion-icon id="volume-ico-on" name="volume-high-outline" onclick="change_volume()"></ion-icon>
                    <ion-icon id="volume-ico-off"name="volume-mute-outline" onclick="change_volume()"></ion-icon>
                </div>
                
                <ul class="proposition" id="proposition">
                    <?php foreach ($origine_array as $proposition) : ?>
                        <li id="sound_proposition<?= $proposition['id']; ?>" value="<?= $proposition['name'] ?>"  onclick="li_proposition(`<?= $proposition['name'] ?>`)"><?= $proposition['name'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="btn-box">
                <button class="btn" id="skip">Passer</button>
            </div>

            <?php
            
            if (($_POST['top100'] != 1 && $_POST['premier'] != 1 && $_POST['av2000'] != 1 && $_POST['ap2000'] != 1) || $_POST['all'] == 1){
                $all = 1;
            } else {
                $all = 0;
            }
            
            ?>

            <form id="form" action="endgame.php" method="post">
                <input type="hidden" name="categorie" value="<?= $categorie_id ?>">
                <input type="hidden" name="all" value="<?= $all ?>">
                <input type="hidden" id="number" name="number" value="<?= $_POST['number'] ?>">
                <input type="hidden" name="top100" value="<?php if($_POST['top100'] == 1 || $_POST['all'] == 1){echo 1;} else {echo 0;} ?>">
                <input type="hidden" name="premier" value="<?php if($_POST['premier'] == 1 || $_POST['all'] == 1){echo 1;} else {echo 0;} ?>">
                <input type="hidden" name="av2000" value="<?php if($_POST['av2000'] == 1 || $_POST['all'] == 1){echo 1;} else {echo 0;} ?>">
                <input type="hidden" name="ap2000" value="<?php if($_POST['ap2000'] == 1 || $_POST['all'] == 1){echo 1;} else {echo 0;} ?>">
                <input type="hidden" name="score" id="score_input" value="">
                <div id="input-sup">
                    <input type="hidden" name="max" value="<?= count($origine_array)?>" id="max">
                    <input type="hidden" name="max_sound" value="<?= count($title_sound_array) ?>" id="max_sound">
                    <?php for ($i = 0; $i < count($array); $i++) : ?>
                        <input type="hidden" value="<?= $array[$i]["id"] ?>" id="sound_id<?= $i ?>">
                        <input type="hidden" value="<?= $array[$i]["origine_id"] ?>" id="sound_origine_id<?= $i ?>">
                        <input type="hidden" value="<?= $array[$i]["origine"] ?>" id="sound_origine<?= $i ?>">
                        <input type="hidden" value="<?= $array[$i]["title"] ?>" id="sound_title<?= $i ?>">
                        <input type="hidden" value="<?= $array[$i]["number_opening"] ?>" id="sound_number<?= $i ?>">
                    <?php endfor; ?>
                </div>
                <div id="input-sup2">
                    <?php for ($i = 0; $i < count($title_sound_array); $i++): ?>
                        <input type="hidden" value="<?= $title_sound_array[$i]["sound_id"] ?>" id="all_sound_id<?= $i ?>" >
                        <input type="hidden" value="<?= $title_sound_array[$i]["sound_title"] ?>" id="all_sound_title<?= $i ?>">
                    <?php endfor; ?>
                </div>
                <div id="input-sup3">
                    <input type="hidden" id="max_alternatif" value="<?= count($alternatif_array) ?>">
                    <?php for ($i = 0; $i < count($alternatif_array); $i++): ?>
                        <input type="hidden" value="<?= $alternatif_array[$i]["alternatif_id"] ?>" id="alternatif_id<?= $i ?>">
                        <input type="hidden" value="<?= $alternatif_array[$i]["origine_id"] ?>" id="origine_id<?= $i ?>">
                        <input type="hidden" value="<?= $alternatif_array[$i]["alternatif_name"] ?>" id="alternatif_name<?= $i ?>">
                    <?php endfor; ?>
                </div>
            </form>
            
        </div>
    </div>
    
    <script src="js/game.js"></script>
</body>
</html>