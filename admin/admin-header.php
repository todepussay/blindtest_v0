<?php

session_start();

if ($_SESSION['admin'] == 0 || !isset($_SESSION['id']) || !isset($_SESSION['admin']) || isset($_SESSION['invite']) || !isset($_SESSION['admin_user'])) {
    header('Location: ../index.php');
}

try {
    $connect = new PDO('mysql:host=localhost;dbname=blindtest', $_SESSION['admin_user'], $_SESSION['admin_password']);
    $connect->query('SET NAMES UTF8');
} catch (Exception $e) {
    echo "Connection à MySQL impossible : ", $e->getMessage();
    die();
}

?>