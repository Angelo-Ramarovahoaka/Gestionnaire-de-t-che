<?php
    require "../../db.php";
    if(isset($_GET['event_id'])){
            $event_id= $_GET['event_id'];
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("SELECT status FROM tasks WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);   
            if ($result !== false) { 
                $newStatus = (int)!$result['status']; // Si status est TRUE (1), $newStatus devient FALSE (0) et vice versa
                print_r($newStatus);
        
                $updateStmt = $pdo->prepare("UPDATE tasks SET status = :newStatus WHERE id = :id");
                $updateStmt->execute(['newStatus' => $newStatus, 'id' => $id]);
            } 
        }
    }
   
       
     header('location: read_tasks.php?id='.$event_id.'');
?>