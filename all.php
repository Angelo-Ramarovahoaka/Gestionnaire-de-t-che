<?php
require'db.php';
    $stmt=$pdo->query('select * from tasks order by created_at desc');
    $tasks=$stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <button><a href="add_task.php">ADD-TASKS </a></button>
    <ul class="d-flex align-item-center justify-content-around flex-wrap p-0">
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