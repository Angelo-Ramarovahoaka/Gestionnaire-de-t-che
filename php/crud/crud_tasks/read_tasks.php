<?php
session_start();
function read_Task($event_id) {
    require '../../db.php'; 
    if (isset($_GET["search"])) {
        $search = $_GET["search"];
        $stmt = $pdo->prepare("
            SELECT * FROM tasks 
            WHERE (title REGEXP :search 
            OR description REGEXP :search) 
            AND event_id = :event_id
            ORDER BY created_at DESC
        ");
        $searchRegExp = '.*' . $search . '.*';
        $stmt->execute([
            'search' => $searchRegExp,
            'event_id' => $event_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $pdo->prepare('SELECT * FROM tasks WHERE event_id = :event_id ORDER BY title ASC');
        $stmt->execute(['event_id' => $event_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (isset($_GET['id'])) {
    if (isset($_SESSION['events'][$_GET['id']])) {
        $id = $_GET['id'];
        $event = $_SESSION['events'][$id];
        $event_id = $event['event_id'];

        $tasks = read_Task($event_id);

        echo  '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>gestion de tache</title>
</head>
<body>
<div class="d-flex justify-content-around nav p-2">
    <h1 class="">TASKS FOR '. $_SESSION['username'].' event '.$event['title'].'</h1>
    <div class="">
        <button><a href="../crud_event/read_event.php">retour </a></button>
    </div>
    <div class="nav-items d-flex">
    <form action="read_tasks.php" method="GET"> <!-- Changed action to specify the correct script -->
        <input type="text" name="search" id="search" placeholder="search">
        <input type="hidden" name="id" value="'.$id.'"> <!-- Added hidden input for id -->
        <button type="submit">search</button>
    </form>
    <button><a href="create_tasks.php?id='.$id.'">ADD-TASK</a></button>
    <button><a href="../../account/logout.php">LOGOUT</a></button>
    </div>
</div>
<ul class="d-flex align-item-center justify-content-around flex-wrap w-100 h-100">';
foreach ($tasks as $task){
    echo '<li class="A task-item d-flex flex-column justify-content-center p-3 m-2 '.($task['status'] ? 'complete-task' : 'pending-task').'">
            <h3>'.$task['title'].'</h3>
            <input type="text" value="'.$task['description'].'" disabled>
            <time>'.$task['created_at'].'</time>
            <div class="btn">
                <a href="complete_tasks.php?id='.$task['id'].'&event_id='.$event_id.'">complete</a>
                <a href="../crud_tasks/read_tasks.php?id='.$task['id'].'&event_id='.$event_id.'">Detail</a>
                <a href="delete_tasks.php?id='. $task['id'].'&event_id='.$event_id.'">Delete</a>
            </div>
        </li>';
}
echo '</ul>
</body>
</html>';

    } else {
        echo "Événement non trouvé.";
    }
} else {
    echo "ID de l'événement non spécifié.";
}
?>
