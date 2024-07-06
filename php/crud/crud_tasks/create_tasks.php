<?php
session_start();
function createTask($event_id){
    
    
    if (!isset($event_id)) {
        header("Location: read_tasks.php");
        
        exit;
    }
    
    
    if($_SERVER['REQUEST_METHOD']=='POST'){
    require'../../db.php';
    $title=$_POST["title"];
    
    $description=$_POST["description"];
    $start_time=$_POST["start_time"];
    $end_time=$_POST["end_time"];
    // $event_id = $event['event_id'];
    var_dump($event_id);
    $stmt=$pdo->prepare("INSERT INTO tasks(event_id,title,description,start_time,end_time) VALUES (?,?,?,?,?)");
    $stmt->execute([$event_id,$title,$description,$start_time,$end_time]);
    header('location: read_tasks.php?id='.$event_id.'');
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
    <h1 class="">TASKS</h1>
    <div class="">
    <?php
$id = '';
if (isset($_GET['id']) && isset($_SESSION['events'][$_GET['id']])) {
    $id = $_GET['id'];
    $event = $_SESSION['events'][$id];
    $event_id = $event['event_id'];
} else {
    $event_id = ''; 
}
?>
<button>
    <a href="read_tasks.php?id=<?php echo trim($event_id); ?>">retour</a>
</button>

    </div>
</div>
 <div class="d-flex justify-content-center align-items-center w-100 h-100">
 <form action="
 <?php 
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $event = $_SESSION['events'][$id];
        $event_id = $event['event_id'];
        createTask($event_id);
    } ?>
" method="POST" class="form d-flex align-items-center flex-column justify-content-center">
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
