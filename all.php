<?php
require'db.php';
    
    function searchTask() {
        require 'db.php';
        
        if (isset($_GET["search"])) {
            $search = $_GET["search"];
            $stmt = $pdo->prepare("
                SELECT * FROM tasks 
                WHERE title REGEXP :search 
                OR description REGEXP :search 
                ORDER BY created_at DESC
            ");
            
            // Ajouter des jokers pour REGEXP
            $searchRegExp = '.*' . $search . '.*';
            $stmt->execute(['search' => $searchRegExp]);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $tasks;
        }
        else{
            $stmt=$pdo->query('select * from tasks order by created_at desc');
            $tasks=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $tasks;
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
    <div class="nav-items d-flex">
    
        <form action="" method="GET">
            <input type="text" name="search" id="search" placeholder="search">
            <button type="submit">search</button>
        </form>
    <button><a href="add_task.php">ADD-TASKS </a></button>
    </div>
</div>
<?php $tasks=searchTask()?>
    <ul class="d-flex align-item-center justify-content-around flex-wrap w-100 h-100">
        <?php foreach ($tasks as $task){
            echo'
        <li class="task-item d-flex flex-column justify-content-center p-3 m-2">
            <h2>'.$task['title'].'</h2>
            <p>'.$task['description'].'</p>
            <div class="btn">
            <a href="modify.php?id='.$task['id'].'">Modify</a>
            <a href="delete_task.php?id='. $task['id'].'">Delete</a>
            </div>
        </li>';
        }
     ?>
    </ul>
</body>
</html>