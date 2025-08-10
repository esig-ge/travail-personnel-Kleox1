<?php

session_start();
require_once __DIR__ . '/config/databaseconnect.php';

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqlClient->prepare('SELECT * FROM utilisateur WHERE login = :login');
    $stmt->execute(['login' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* TO DO */

?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>

        <form method="post" action="login.php">
            <h1> Login</h1>

            <div>
                <label name="username">Username : </label>
                <input type="text" name="username" required>
            </div>

            <div> 
                <label name="password">Password : </label>
                <input type="password" name="password" required>
            </div>

            <div>
                <button type="submit">Login</button>
            </div>


        </form>


    </body>
</html>