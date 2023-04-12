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

$sound = "SELECT * FROM sound WHERE sound.id IN (SELECT sound.id FROM sound, origine WHERE sound.origine_id = origine.id AND origine.categorie_id = :categorie_id)";
$sound = $connect->prepare($sound);
$sound->bindValue(':categorie_id', $categorie_id);
$sound->execute();
$sound = $sound->fetchAll();

$alternatif = "SELECT * FROM alternatif, origine WHERE alternatif.origine_id = origine.id AND origine.categorie_id = :categorie_id";
$alternatif = $connect->prepare($alternatif);
$alternatif->bindValue(':categorie_id', $categorie_id);
$alternatif->execute();
$alternatif = $alternatif->fetchAll();

$origine_column = [];

for($i = 0; $i < count(array_keys($origine[0])); $i = $i + 2){
    $origine_column[] = array_keys($origine[0])[$i];
}

$sound_column = [];

for($i = 0; $i < count(array_keys($sound[0])); $i = $i + 2){
    $sound_column[] = array_keys($sound[0])[$i];
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
                <span class="question"></span>
                <span></span> 
            </div>

        </div>
    </div>

    <div class="sup">
        <div id="sup_question">

        </div>
    </div>


    <div id="del">

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
                <input type="hidden" id="origine_column_<?= $i ?>" value="<?= $sound_column[$i] ?>">
            <?php endfor; ?>

            <?php for($i = 0; $i < count($sound); $i++): ?>
                <?php for($j = 0; $j < count($sound[$i])/2; $j++): ?>
                    <input type="hidden" id="sound_<?= $sound_column[$j] ?>_<?= $i ?>" value="<?= $sound[$i][$j] ?>">
                <?php endfor; ?>
            <?php endfor; ?>

        </div>

        <input type="hidden" id="alternatif_number" value="<?= count($alternatif) ?>">
        <input type="hidden" id="question_number" value="<?= count($question) ?>">

        

        

    </div>
    
    <script src="js/game2.js"></script>
</body>
</html>