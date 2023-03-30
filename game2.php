<?php



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
    
    <script src="js/game2.js"></script>
</body>
</html>