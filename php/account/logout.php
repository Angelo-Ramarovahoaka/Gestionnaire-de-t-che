<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['username']);

// Suppression de toutes les variables de session
session_unset();

// Destruction de la session
session_destroy();
header('Location: ../../index.php');
exit();
?>