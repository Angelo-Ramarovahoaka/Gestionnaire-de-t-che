<?php
function addTasks(){
    
    require'db.php';
   if(isset($_POST["title"]) && isset($_POST["description"])){
    $title=$_POST["title"];
    $description=$_POST["description"];
    
    $stmt=$pdo->prepare("INSERT INTO tasks(title,description) VALUES (?,?)");
    $stmt->execute([$title,$description]);
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
    <form action="<?php addTasks() ?>" method="POST">
        <input type="text" name="title" placeholder="title de la tâche" required>
        <textarea type="text" name="description" placeholder="description de la tâche" required></textarea>
        <button type="submit">ajouter</button>
    </form>
</body>
</html>
