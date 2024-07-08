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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../../css/task.css">
    <title>gestion de tache</title>
</head>
<body>
    <nav>
        <div class="profile">
            <img src="../../../image/bg.jpg" alt="" class="user-photo">
            <span class="username">'.$_SESSION["username"].'</span>
        </div>
        <div>
            <span class="title-project">LAMINA</span>
        </div>
        <div class="settings">
            <span class="logout"><a href="../../account/logout.php">logout ?</a></span>
            <button type="button"><i class="fas fa-cog"></i></button>
        </div>
    </nav>
        <div class="event">
            <form>
                <div class="event-header">
                    <input type="text" class="event-title" value="'.$event['title'].'" disabled>
                    <label class="event-date">
                        Date de planification:
                        <time datetime="">'.$event['created_at'].'</time>
                    </label>
                </div>
                <div class="event-details">
                    <textarea class="event-description" disabled>'.$event['description'].'</textarea>
                    <div class="event-timing">
                        <div class="event-start">
                            <label>Start: <input type="date" id="start_date" name="start_date" value="'.$event['start_date'].'"disabled>
                            </label>
                            <input type="time" id="start_time" name="start_time" value="'.$event['start_time'].'"disabled>
                        </div>
                        <div class="event-start">
                            <label>End: <input type="date" name="end_date" value="'.$event['end_date'].'" disabled>
                            </label>
                            <input type="time" id="start_time" name="end_time" value="'.$event['end_time'].'"disabled>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <div class="task-search">
        <form class="search" method="GET">
            <input type="text" name="search" id="search" placeholder="search...">
            <button type="button"><i class="fas fa-search"></i></button>
        </form>
        <a href="read_event.php"><button><i class="fas fa-arrow-right"></i></button></a>
    </div>   
    <div class="all-task">
        <div class="task-details">
            <form action="" method="post" class="form">
                <div class="top">
                    <input type="text" name="title" value="title" placeholder="title">
                    <input type="date" name="date" value="12-12-12" >
                </div>
                <textarea name="description" id="description"></textarea>
                <div class="bottom">
                    <div class="time">
                        <input type="time" name="start_time" value="12:12">
                        <input type="time" name="end_time" value="12:12">
                    </div>
                    
                    <div class="actions">
                        <a href=""><button  title="Compléter"><i class="fas fa-check complete-icon"></i></button></a>
                        <a href=""><button  title="Modifier"><i class="fas fa-edit edit-icon"></i></button></a>
                        <a href=""><button  title="Supprimer"><i class="fas fa-trash delete-icon"></i></button></a>
                    </div>
                </div>
            </form>   
        </div>
        <!-- ici se trouve d\'autre tache -->
    </div>
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
    echo '<li class="A task-item d-flex flex-column justify-content-center p-3 m-2 '.($task['status'] ? 'complete-task' : '').'">
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

                