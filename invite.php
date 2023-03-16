<?php

session_start();
$_SESSION['invite'] = 46160;
// $_SESSION['invite'] = random_int(0, 100000);
header('Location: index.php');

?>