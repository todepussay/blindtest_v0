<?php

session_start();
$_SESSION['invite'] = '1';
header('Location: index.php');

?>