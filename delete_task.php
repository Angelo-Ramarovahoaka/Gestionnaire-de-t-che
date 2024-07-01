<?php
    require'db.php';
    echo'ok';
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $stmt= $pdo->prepare("DELETE FROM tasks WHERE id= ?");
        $stmt->execute([$id]);
        header('location: all.php');
    }
?>