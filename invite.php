<?php

session_start();
$_SESSION['invite'] = random_int(0, 10000000);
header('Location: index.php');

?>