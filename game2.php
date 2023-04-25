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

$categorie = $connect->prepare("SELECT name FROM categories WHERE id = :id");
$categorie->bindValue(':id', $categorie_id);
$categorie->execute();
$categorie = $categorie->fetchAll();
$categorie_name = $categorie[0]['name'];

$question = $connect->prepare("SELECT * FROM question WHERE categorie_id = :categorie_id");
$question->bindValue(':categorie_id', $categorie_id); 
$question->execute();
$question = $question->fetchAll();

$origine = $connect->prepare("SELECT * FROM origine WHERE categorie_id = :categorie_id");
$origine->bindValue(':categorie_id', $categorie_id);
$origine->execute();
$origine = $origine->fetchAll();

$sound = "SELECT * FROM sound WHERE sound.id_sound IN (SELECT sound.id_sound FROM sound, origine WHERE sound.origine_id = origine.id AND origine.categorie_id = :categorie_id)";
$sound = $connect->prepare($sound);
$sound->bindValue(':categorie_id', $categorie_id);
$sound->execute();
$sound = $sound->fetchAll();

$alternatif = "SELECT * FROM alternatif WHERE alternatif.id IN (SELECT alternatif.id FROM alternatif, origine WHERE alternatif.origine_id = origine.id AND origine.categorie_id = :categorie_id)";
$alternatif = $connect->prepare($alternatif);
$alternatif->bindValue(':categorie_id', $categorie_id);
$alternatif->execute();
$alternatif = $alternatif->fetchAll();

$game_sound = "SELECT sound.id_sound FROM origine, sound, categories WHERE categories.id = origine.categorie_id AND sound.origine_id = origine.id AND categories.id = :categorie_id";

if ($_POST['top100'] == 1){
    $game_sound .= " AND sound.top100 = 1";
}
if ($_POST['premier'] == 1){
    $game_sound .= " AND sound.number = 1";
    $premier = 1;
}
if ($_POST['av2000'] == 1){
    $game_sound .= " AND origine.annee < 2000";
}
if ($_POST['ap2000'] == 1){
    $game_sound .= " AND origine.annee > 2000";
}

$game_sound .= " ORDER BY RAND() LIMIT :number ";

$game_sound = $connect->prepare($game_sound);
$game_sound->bindValue(':categorie_id', $categorie_id);
$game_sound->bindValue(':number', $_POST['number'], PDO::PARAM_INT);
$game_sound->execute();
$game_sound = $game_sound->fetchAll();

$origine_column = [];

for($i = 0; $i < count(array_keys($origine[0])); $i = $i + 2){
    $origine_column[] = array_keys($origine[0])[$i];
}

$sound_column = [];

for($i = 0; $i < count(array_keys($sound[0])); $i = $i + 2){
    $sound_column[] = array_keys($sound[0])[$i];
}

$alternatif_column = [];

for($i = 0; $i < count(array_keys($alternatif[0])); $i = $i + 2){
    $alternatif_column[] = array_keys($alternatif[0])[$i];
}

$question_column = [];

for($i = 0; $i < count(array_keys($question[0])); $i = $i + 2){
    $question_column[] = array_keys($question[0])[$i];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php require "header.php"; ?>

    <div class="container-overlay">
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

                <h2 id="score-game">Score : <span id="score">0</span></h2>

                <div id="time-box">
                    <span id="time">30</span>
                </div>

                <div class="progress-box">
                    <span>Générique <span id="number-progression">1</span> / <?= $_POST['number'] ?></span>
                    <div id="progress">
                        <div id="value"></div>
                    </div>
                </div>

            </div>

            <div id="question-box">
                
            </div>

            <div class="input-box-proposition">
                <div class="input-box" id="animation">
                    <ion-icon id="search-ico" name="search-outline"></ion-icon>
                    <input autocomplete="off" placeholder="Saisir votre proposition" type="search" id="search">
                    <div id="del">
                        <ion-icon id="del" name="close-outline"></ion-icon>
                    </div>
                    <div id="volume-ico">
                        <ion-icon id="volume-ico-on" name="volume-high-outline"></ion-icon>
                        <ion-icon id="volume-ico-off" name="volume-mute-outline"></ion-icon>
                    </div>
                </div>
                
                <ul class="proposition" id="proposition">
                </ul>
            </div>

            <div class="btn-box">
                <button class="btn" id="skip">Passer</button>
            </div>

        </div>
    </div>


    <div id="delete">

        <div id="categorie">
            <input type="hidden" id="categorie_id" value="<?= $categorie_id ?>">
            <input type="hidden" id="categorie_name" value="<?= $categorie_name ?>">
        </div>

        <div id="origine">

            <input type="hidden" id="origine_number" value="<?= count($origine) ?>">
            <input type="hidden" id="origine_column_number" value="<?= count(array_keys($origine[0]))/2 ?>">

            <?php for($i = 0; $i < count($origine_column); $i++): ?>
                <input type="hidden" id="origine_column_<?= $i ?>" value="<?= $origine_column[$i] ?>">
            <?php endfor; ?>

            <?php for($i = 0; $i < count($origine); $i++): ?>
                <?php for($j = 0; $j < count($origine[$i])/2; $j++): ?>
                    <input type="hidden" id="origine_<?= $origine_column[$j] ?>_<?= $i ?>" value="<?= $origine[$i][$j] ?>">
                <?php endfor; ?>
            <?php endfor; ?>

        </div>

        <div id="sound">

            <input type="hidden" id="sound_number" value="<?= count($sound) ?>">
            <input type="hidden" id="sound_column_number" value="<?= count(array_keys($sound[0]))/2 ?>">

            <?php for($i = 0; $i < count($sound_column); $i++): ?>
                <input type="hidden" id="sound_column_<?= $i ?>" value="<?= $sound_column[$i] ?>">
            <?php endfor; ?>

            <?php for($i = 0; $i < count($sound); $i++): ?>
                <?php for($j = 0; $j < count($sound[$i])/2; $j++): ?>
                    <input type="hidden" id="sound_<?= $sound_column[$j] ?>_<?= $i ?>" value="<?= $sound[$i][$j] ?>">
                <?php endfor; ?>
            <?php endfor; ?>

        </div>

        <div id="alternatif">

            <input type="hidden" id="alternatif_number" value="<?= count($alternatif) ?>">
            <input type="hidden" id="alternatif_column_number" value="<?= count(array_keys($alternatif[0]))/2 ?>">

            <?php for($i = 0; $i < count($alternatif_column); $i++): ?>
                <input type="hidden" id="alternatif_column_<?= $i ?>" value="<?= $alternatif_column[$i] ?>">
            <?php endfor; ?>

            <?php for($i = 0; $i < count($alternatif); $i++): ?>
                <?php for($j = 0; $j < count($alternatif[$i])/2; $j++): ?>
                    <input type="hidden" id="alternatif_<?= $alternatif_column[$j] ?>_<?= $i ?>" value="<?= $alternatif[$i][$j] ?>">
                <?php endfor; ?>
            <?php endfor; ?>

        </div>

        <div id="question">

            <input type="hidden" id="question_number" value="<?= count($question) ?>">
            <input type="hidden" id="question_column_number" value="<?= count(array_keys($question[0]))/2 ?>">

            <?php for($i = 0; $i < count($question_column); $i++): ?>
                <input type="hidden" id="question_column_<?= $i ?>" value="<?= $question_column[$i] ?>">
            <?php endfor; ?>

            <?php for($i = 0; $i < count($question); $i++): ?>
                <?php for($j = 0; $j < count($question[$i])/2; $j++): ?>
                    <input type="hidden" id="question_<?= $question_column[$j] ?>_<?= $i ?>" value="<?= $question[$i][$j] ?>">
                <?php endfor; ?>
            <?php endfor; ?>

        </div>

        <div id="game_sound">

            <input type="hidden" id="game_sound_number" value="<?= $_POST["number"] ?>">

            <?php for($i = 0; $i < $_POST['number']; $i++): ?>
                <input type="hidden" id="game_sound_<?= $i ?>" value="<?= $game_sound[$i]["id_sound"] ?>">
            <?php endfor; ?>

        </div>

        <form id="form" action="endgame.php" method="post">
            <input type="hidden" name="categorie" value="<?= $categorie_id ?>">
            <input type="hidden" name="all" value="<?= $all ?>">
            <input type="hidden" id="number" name="number" value="<?= $_POST['number'] ?>">
            <input type="hidden" name="top100" value="<?php if($_POST['top100'] == 1 || $_POST['all'] == 1){echo 1;} else {echo 0;} ?>">
            <input type="hidden" name="premier" id="premier_input" value="<?php if($_POST['premier'] == 1){echo 1;} else {echo 0;} ?>">
            <input type="hidden" name="av2000" value="<?php if($_POST['av2000'] == 1 || $_POST['all'] == 1){echo 1;} else {echo 0;} ?>">
            <input type="hidden" name="ap2000" value="<?php if($_POST['ap2000'] == 1 || $_POST['all'] == 1){echo 1;} else {echo 0;} ?>">
            <input type="hidden" name="score" id="score_input" value="">
        </form>

    </div>
    
    <script src="js/game2.js"></script>
</body>
</html>