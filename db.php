<?php
$dsn='mysql:host=localhost;dbname=list_task';
$username='ramaro';
$password='E100001e';
try {
    $pdo= new PDO($dsn,$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
} catch (PDOException $e) {
    echo"error: ".$e->getMessage();
}
?>