<?php
session_start();
function createTask($event_id,$event){
    
    
    if (!isset($event_id)) {
        header("Location: read_tasks.php");
        
        exit;
        }
        
        // print_r($event['event_id']);
    
    if($_SERVER['REQUEST_METHOD']=='POST'){
        echo "ito"; 
    require'../../db.php';
    $title=$_POST["title"];
    $description=$_POST["description"];
    $task_date=empty($_POST["task_date"])? $event['start_date']: $_POST["task_date"] ;
    $start_time=empty($_POST["start_time"])? $event['start_time']: $_POST["start_time"];
    $end_time=empty($_POST["end_time"])? $event['end_time']: $_POST["end_time"];
    $event_id = $event['event_id'];
    $stmt=$pdo->prepare("INSERT INTO tasks(event_id,title,description,task_date,start_time,end_time) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$event_id,$title,$description,$task_date,$start_time,$end_time]);
    header('location: read_tasks.php?id='.$event_id.'');
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/task.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <title>gestion de tache</title>
</head>
<body>
<div class="nav_create">
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
    <a href="read_tasks.php?id=<?php echo trim($event_id); ?>"><i class="fas fa-arrow-right"></i></a>
</button>

    </div>
</div>
 <div class="cover_form">
 <form action="
 <?php 
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        // print_r($id);
        $event = $_SESSION['events'][$id];
        $event_id = $event['event_id'];
        createTask($event_id,$event);
    } ?>
" method="POST" class="form">
        <label for="title">title : </label>
        <input type="text" name="title" placeholder="title de la tâche" required>
        <label for="description">description :</label>
        <textarea type="text" name="description" placeholder="description de la tâche"></textarea>
        <div class="time">
            <div class="start_time">
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" >
            </div>
            <div class="task">
                <label for="task_date">Task date</label>
                <input type="date" name="task_date" >
            </div>
            <div class="end_time">
                <label for="start_time">End Time</label>
                <input type="time" name="end_time" >
            </div>
        </div>
        <button class="btn-submit" type="submit">submit</button>
    </form> 
 </div>
    
</body>
</html>
