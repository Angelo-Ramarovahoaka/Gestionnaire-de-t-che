<?php
    
    function read_Event() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: ../../../index.php");
        }

        require '../../db.php';
        
        $user_id = $_SESSION['user_id'];
        if (isset($_GET["search"])) {
            $search = $_GET["search"];
            $stmt = $pdo->prepare("
                SELECT * FROM events 
                WHERE (title REGEXP :search 
                OR description REGEXP :search) 
                AND user_id = :user_id
                ORDER BY created_at DESC
            ");
            
            // Ajouter des jokers pour REGEXP
            $searchRegExp = '.*' . $search . '.*';
            $stmt->execute([
                'search' => $searchRegExp,
                'user_id'=>$user_id
            ]);
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $events;
        }
        else{
            $stmt=$pdo->prepare('SELECT * FROM events WHERE user_id = :user_id ORDER BY created_at DESC');
            $stmt->execute(['user_id'=>$user_id]);
            $events=$stmt->fetchAll();
            return $events;
        }
        }
    function modifyEvent($id){
        session_start();

        require'../../db.php';
        $user_id = $_SESSION['user_id'];
        if($_SERVER['REQUEST_METHOD']== 'POST' && isset($_GET['id'])){   
            // echo "ito ndray";
            $title=$_POST["title"];
            $description=$_POST["description"];
            $start_date= $_POST["start_date"];
            $start_time= $_POST["start_time"];
            $end_date = empty($_POST["end_date"]) ? NULL : $_POST["end_date"];
            $end_time=$_POST["end_time"];
            $id=$_GET['id'];
            // print_r($id);
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

            $stmt=$pdo->prepare('SELECT * FROM events WHERE user_id = :user_id ORDER BY created_at DESC');
            $stmt->execute(['user_id'=>$user_id]);
            $events=$stmt->fetchAll();
            return $events;
            
        }
        // header('location: read_event.php');
    }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../../css/event.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
   
    <title>lamina</title>
</head>
<body>
    <?php $events=read_Event()?>
    
    <nav>
        <div class="profile">
            <img src="../../../image/bg.jpg" alt="" class="user-photo">
            <span class="username"><?php echo $_SESSION["username"] ?></span>
        </div>
        <div>
            <span class="title-project">LAMINA</span>
        </div>
        <div class="settings">
            <span class="logout"><a href="../../account/logout.php">logout ?</a></span>
            <button type="button"><i class="fas fa-cog"></i></button>
        </div>
    </nav>
    <main>
        <div class="show">
                <form class="search" method="GET">
                    <input type="text" name="search" id="search" placeholder="search...">
                    <button type="button"><i class="fas fa-search"></i></button>
                </form>
                <div class="event">
                    <a href="create_event.php"><button class="add-event">ADD-EVENT</button></a>
                    <a href="read_event.php" class="ssp">ALL-EVENT</a>
                </div>
        </div>
        <div class="events-grid">
            <?php
                $_SESSION['events']=[];
                foreach ($events as $event){
                // print_r($event['id']);
                $_SESSION['events'][$event['id']] = [
                    'event_id' => $event['id'],
                    'title' => $event['title'],
                    'description'=>$event['description'],
                    'created_at'=>$event['created_at'],
                    'start_date'=>$event['start_date'],
                    'end_date'=>$event['end_date'],
                    'start_time'=>$event['start_time'],
                    'end_time'=>$event['end_time']
                ];
                echo '
                <div class="event '.($event['status'] ? 'complete-event' : '').'">
                <form action="'.modifyEvent($event['id']).'" method="POST">
                    <div class="event-header">
                        <input type="text" class="event-title" name="title" value="'.$event['title'].'">
                        <input type="hidden" value="'.$event['id'].'">
                        <label class="event-date">
                            Date de planification:
                            <time datetime="">'.$event['created_at'].'</time>
                        </label>
                        <a href="../crud_tasks/read_tasks.php?id='.$event['id'].'" class="ssp">
                            Details
                        </a>

                    </div>
                    <div class="event-details">
                        <textarea class="event-description" name="description">'.$event['description'].'</textarea>
                        <div class="event-timing">
                            <div class="event-start">
                                <label>Start: <input type="date" id="start_date" name="start_date" value="'.$event['start_date'].'">
                                </label>
                                <input type="time" id="start_time" name="start_time" value="'.$event['start_time'].'">
                            </div>
                            <div class="event-start">
                                <label>End: <input type="date" name="end_date" value="'.$event['end_date'].'">
                                </label>
                                <input type="time" id="end_time" name="end_time" value="'.$event['end_time'].'">
                            </div>
                        </div>
                    </div>
                    <div class="event-actions">
                        <a href="complete_event.php?id='.$event['id'].'"><i class="fas fa-check-circle" title="Complete"></i></a>
                        <button type="submit"><i class="fas fa-edit" title="Modifier" onclick=""></i></button>
                        <a href="delete_event.php?id='. $event['id'].'"><i class="fas fa-trash-alt" title="Supprimer"></i></a>
                        <a href="">  <i class="fas fa-share-alt" title="Partager"></i></a>  
                    </div>
                    <div class="edit-actions" style="display: none;">
                        <button type="button" class="save-btn" onclick="">Enregistrer</button>
                        <button type="button" class="cancel-btn" onclick="">Annuler</button>
                    </div>
                </form>
            </div>
                ';
            }
            ?>
        </div>
    </main>
</body>
</html>