<?php
    function login() {
        require 'db.php';
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            
            $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            var_dump($user);
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                var_dump($_SESSION['username']);
                // session_regenerate_id(true);
                header("Location: all.php");
                exit;
            } else {
                echo 'Email ou mot de passe incorrect.';
            }
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connection</title>
</head>
<body>
    <h2>CONNECTION</h2>
    <form action="<?php login() ?>" method="post">
        <label for="email"></label>
        <input type="text" name="email" placeholder="email">
        <label for="password"></label>
        <input type="password" name="password" placeholder="password">
        <button type="submit">login</button>
    </form>
</body>
</html>