<?php

require "admin-header.php";

if (isset($_POST['id'])){
    $delete = "DELETE FROM proposition WHERE id = :id";
    $delete = $connect->prepare($delete);
    $delete->bindParam(':id', $_POST['id']);
    $delete->execute();
}

header('Location: admin-proposition.php');

?>