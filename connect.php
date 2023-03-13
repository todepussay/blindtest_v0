<<<<<<< HEAD
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
=======
<?php
eeee
try {
    $connect = new PDO('mysql:host=localhost;dbname=blindtest', 'root', '');
    $connect->query('SET NAMES UTF8');
} catch (Exception $e) {
    echo "Connection à MySQL impossible : ", $e->getMessage();
    die();
}

?>
>>>>>>> a49d7adaa6fbc7e3b77f1f90ca618ea87a5c467b
