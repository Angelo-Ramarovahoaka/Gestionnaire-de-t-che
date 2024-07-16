<?php
    require'../../db.php';
   if( isset($_GET["id"])){   
       echo "ito ndray";
       $title=$_POST["title"];
       print_r($_POST["title"]);
       $description=$_POST["description"];
       $start_date= $_POST["start_date"];
       $start_time= $_POST["start_time"];
       $end_date=$_POST["end_date"];
       $end_time=$_POST["end_time"];
       $id=$_GET["id"];
       print_r($id);
       $stmt=$pdo->prepare("UPDATE events SET title = :title , description = :description , start_date= :start_date , start_time= :start_time , end_date= :end_date , end_time= :end_time WHERE id = :id ");
       $stmt->execute([
        'title' => $title,
        'description' => $description,
        'start_date' => $start_date,
        'start_time' => $start_time,
        'end_date' => $end_date,
        'end_time' => $end_time,
        'id' => $id
        ]);
    header('location: read_event.php');
   }
?>
