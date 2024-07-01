<?php
function defaultTitile(){
    require'db.php';
if(isset($_GET["id"])){
    $stmt=$pdo->prepare('select * from tasks where id= ?');
    $stmt->execute([$_GET["id"]]);
    $task=$stmt->fetch(PDO::FETCH_ASSOC);
    echo $task['title'];
}
}

function defaultDescription(){
    require'db.php';
if(isset($_GET["id"])){
    $stmt=$pdo->prepare('select * from tasks where id= ?');
    $stmt->execute([$_GET["id"]]);
    $task=$stmt->fetch(PDO::FETCH_ASSOC);
    echo $task['description'];
}
}
function modifyTask(){
    
    require'db.php';
   if(isset($_POST["title"]) && isset($_POST["description"]) && isset($_GET["id"])){

    $title=$_POST["title"];
    $description=$_POST["description"];
    $id=$_GET["id"];
    
    $stmt=$pdo->prepare("UPDATE tasks SET title= ? , description= ? WHERE id= ?");
    $stmt->execute([$title,$description,$id]);
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
    <form action="<?php modifyTask() ?>" method="POST">
        <input type="text" name="title" placeholder="title de la tâche" value="<?php defaultTitile() ?>">
        <textarea type="text" name="description" placeholder="description de la tâche"><?php defaultDescription() ?></textarea>
        <button type="submit">Modify</button>
    </form>
</body>
</html>
