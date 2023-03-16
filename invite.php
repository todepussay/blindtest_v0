<?php

session_start();
$_SESSION['invite'] = random_int(0, 100000);
header('Location: index.php');

?>