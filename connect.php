<?php
e
try {
    $connect = new PDO('mysql:host=localhost;dbname=blindtest', 'root', '');
    $connect->query('SET NAMES UTF8');
} catch (Exception $e) {
    echo "Connection à MySQL impossible : ", $e->getMessage();
    die();
}

?>
