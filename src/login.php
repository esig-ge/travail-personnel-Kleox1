<?php

session_start();
require_once __DIR__ . '/config/databaseconnect.php';

$_erreur = '';

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqlClient->prepare('SELECT * FROM utilisateur WHERE login = :login');
    $stmt->execute(['login' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mot_de_passe'])){
        // Connexion réussie
            // clé primaire : id_utilisateur
        $_SESSION['utilisateur_id'] = $user['id_utilisateur'];
        $_SESSION['login'] = $user['login'];

        
        // Redirection ver la page d'accueil
        header('Location: index.php');
        exit;
    } else {
        $_erreur = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

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

            <?php 
                if (!empty($_erreur)){
                    echo "<p>" .  htmlspecialchars($_erreur) . "</p>";
                }
            ?>

            <div>
                <label for="username">Username : </label>
                <input type="text" name="username" required>
            </div>

            <div> 
                <label for="password">Password : </label>
                <input type="password" name="password" required>
            </div>

            <div>
                <button type="submit">Login</button>
            </div>


        </form>


    </body>
</html>