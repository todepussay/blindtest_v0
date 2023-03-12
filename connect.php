<?php

try {
    $connect = new PDO('mysql:host=51.15.218.4;dbname=blindtest', 'test', 'Playxids1477');
    $connect->query('SET NAMES UTF8');
} catch (Exception $e) {
    echo "Connection à MySQL impossible : ", $e->getMessage();
    die();
}

?>