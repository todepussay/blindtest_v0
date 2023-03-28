<?php

require "admin-header.php";

if (isset($_GET['id'])){
    $delete = "DELETE FROM proposition WHERE id = :id";
    $delete = $connect->prepare($delete);
    $delete->bindParam(':id', $_GET['id']);
    $delete->execute();
}

header('Location: admin.php');

?>