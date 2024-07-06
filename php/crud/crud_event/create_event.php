<?php
function createEvent(){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../../index.php");
        exit;
    }
    
   if(isset($_POST["title"]) && isset($_POST["description"])){
    require'../../db.php';
    $title=$_POST["title"];
    $description=$_POST["description"];
    $start_time=$_POST["start_time"];
    $end_time=$_POST["end_time"];
    $user_id = $_SESSION['user_id'];
    
    $stmt=$pdo->prepare("INSERT INTO events(user_id,title,description,start_time,end_time) VALUES (?,?,?,?,?)");
    $stmt->execute([$user_id,$title,$description,$start_time,$end_time]);
    header('location: read_event.php');
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>gestion de tache</title>
</head>
<body>
<div class="d-flex justify-content-around nav p-2">
    <h1 class="">MY EVENT</h1>
    <div class="">
        <button><a href="read_event.php">ALL-EVENTS </a></button>
    </div>
</div>
 <div class="d-flex justify-content-center align-items-center w-100 h-100">
 <form action="<?php createEvent() ?>" method="POST" class="form d-flex align-items-center flex-column justify-content-center">
        <label for="title">title :</label>
        <input type="text" name="title" placeholder="title de la tâche" required>
        <label for="description">description :</label>
        <textarea type="text" name="description" placeholder="description de la tâche"></textarea>
        <label for="start_time">Start Time</label>
        <input type="datetime-local" name="start_time" placeholder="start time">
        <label for="start_time">End Time</label>
        <input type="datetime-local" name="end_time" placeholder="end time">
        <button class="btn-submit" type="submit">submit</button>
    </form> 
 </div>
    
</body>
</html>
