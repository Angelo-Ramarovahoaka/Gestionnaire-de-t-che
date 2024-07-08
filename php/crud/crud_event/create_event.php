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
    $user_id = $_SESSION['user_id'];
    
    $start_date = empty($_POST["start_date"]) ? '2024-01-01' : $_POST["start_date"];
    $start_time = empty($_POST["start_time"]) ? '00:00' : $_POST["start_time"];
    $end_date = empty($_POST["end_date"]) ? NULL : $_POST["end_date"];
    $end_time = empty($_POST["end_time"]) ? '00:00' : $_POST["end_time"];

    $stmt=$pdo->prepare("INSERT INTO events(user_id,title,description,start_date,start_time,end_date,end_time) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([$user_id,$title,$description,$start_date,$start_time,$end_date,$end_time]);
    header('location: read_event.php');
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/event.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <title>gestion de tache</title>
</head>
<body>
    <nav>
        <div class="profile">
            
            <img src="../../../image/bg.jpg" alt="" class="user-photo">
            <span class="username"><?php 
             session_start();
             echo $_SESSION["username"] 
             ?></span>
        </div>
        <div class="title">
            <span class="title-project">LAMINA</span>
        </div>
        <div class="settings">
            <span class="logout"><a href="../../account/logout.php">logout ?</a></span>
            <button type="button"><i class="fas fa-cog"></i></button>
        </div>
    </nav>
    <main class="add">
        <div class="show">
            <div class="event end">
                <a href="read_event.php" class="ssp">ALL-EVENT</a>
            </div>
        </div>
        <form action="<?php createEvent() ?>" method="POST" class="form">
        <label for="title">title :</label>
        <input type="text" name="title" placeholder="title de la tâche" required>
        <label for="description">description :</label>
        <textarea type="text" name="description" placeholder="description de la tâche"></textarea>
        <div class="time">
            <label for="start_date">Start Time : 
                <input type="date" name="start_date">
                <input type="time" name="start_time">
            </label>
        
            <label for="start_time">End Time :
                <input type="date" name="end_date">
                <input type="time" name="end_time">
            </label>
        </div>
        <button class="btn-submit" type="submit">submit</button>
    </form> 
    </main>
</body>
</html>
