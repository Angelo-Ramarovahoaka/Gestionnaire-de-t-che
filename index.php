<?php
    function login() {
        require 'php/db.php';
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            var_dump($user);
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                var_dump($_SESSION['username']);
                header("Location: php/crud/crud_event/read_event.php");
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
    <link rel="stylesheet" href="css/account/login.css">
    <title>lamina</title>
</head>
<body>
        
    <h1 class="">LAMINA</h1>
    <div class="loader-container">
        <div class="spinner"></div>
        <div class="btn">
        <form id="login" action="<?php login() ?>" method="post">
            <div class="text">
               
                <input type="text" name="email" placeholder="email">
                <input type="password" name="password" placeholder="password">
            </div>
            <div class="btn-btn">
                <button class="signup-btn" type="submit">login</button>
                <button class="signup-btn"><a href="php/account/inscription.php">inscription</a></button>
            </div>
            
        </form>   
    </div>
    </div>
    <script src="script.js"></script>
</body>
</html>