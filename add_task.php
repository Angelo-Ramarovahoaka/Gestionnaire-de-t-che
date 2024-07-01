<?php
function addTasks(){
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: connection.php");
        exit;
    }
    
   if(isset($_POST["title"]) && isset($_POST["description"])){
    require'db.php';
    $title=$_POST["title"];
    $description=$_POST["description"];
    $user_id = $_SESSION['user_id'];
    
    $stmt=$pdo->prepare("INSERT INTO tasks(user_id,title,description) VALUES (?,?,?)");
    $stmt->execute([$user_id,$title,$description]);
    header('location: all.php');
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>gestion de tache</title>
</head>
<body>
<div class="d-flex justify-content-around nav p-2">
    <h1 class="">MY TASKS</h1>
    <div class="">
        <button><a href="all.php">ALL-TASKS </a></button>
    </div>
</div>
 <div class="d-flex justify-content-center align-items-center w-100 h-100">
 <form action="<?php addTasks() ?>" method="POST" class="form d-flex align-items-center flex-column justify-content-center">
        <input type="text" name="title" placeholder="title de la tâche" required>
        <textarea type="text" name="description" placeholder="description de la tâche" required></textarea>
        <button class="btn-submit" type="submit">submit</button>
    </form> 
 </div>
    
</body>
</html>
