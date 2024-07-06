<?php
    require'../../db.php';
    
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        print_r($id);
        $stmt= $pdo->prepare("DELETE FROM tasks WHERE event_id = :event_id ; DELETE FROM events WHERE id = :event_id");
        $stmt->execute([
            'event_id' => $id
        ]);
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
        header('location: read_event.php');
    }
?>