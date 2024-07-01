<?php
    function inscription(){
        require'db.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
        
            // Vérifier si l'utilisateur ou l'email existe déjà
            $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username OR email = :email");
            $stmt->execute(['username' => $username, 'email' => $email]);
        
            if ($stmt->fetch()) {
                die('Le nom d\'utilisateur ou l\'email est déjà utilisé.');
            }
            // $password_hash= password_hash($password,PASSWORD_BCRYPT);
            // Insérer le nouvel utilisateur dans la base de données
            $stmt = $pdo->prepare("INSERT INTO user(username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $password
            ]);
        
            echo 'Inscription réussie ! Vous pouvez maintenant <a href="connexion.php">vous connecter</a>.';
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Inscription</h2>
    <form action="<?php inscription() ?>" method="post">
        <input type="text" id="username" name="username" placeholder="username" required><br>
        <input type="text" id="email" name="email" placeholder="email"required><br>
        <input type="text" id="password" name="password" placeholder="password" required><br>

        <button type="submit">submit</button>
    </form>
</body>
</html>
