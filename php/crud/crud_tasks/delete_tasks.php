<?php
    require'../../db.php';
    if(isset($_GET['event_id'])){
        $event_id=$_GET['event_id'];
        print_r($event_id);

        if(isset($_GET['id'])){
            $id=$_GET['id'];
            $stmt= $pdo->prepare("DELETE FROM tasks WHERE id= ?");
            $stmt->execute([$id]);
            echo 'delete';
            header('location: read_tasks.php?id='.$event_id.'');
        }
    }  
?>