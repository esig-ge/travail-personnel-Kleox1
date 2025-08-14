<?php

// Démarre la session 
session_start();

// Connexion à la base de données
require_once __DIR__ . '/config/databaseconnect.php';

// Précision : Je ne mets pas l'include de session.php, je ne veux pas
// bloquer l'accès à cette page

// Initialisation de la variable stockant les erreurs
$_erreur = '';

// Vérification si le formulaire a été soumis avec les champs requis
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Récupération de l'utilsiteur par rapport au login fourni
    $stmt = $mysqlClient->prepare('SELECT * FROM utilisateur WHERE login = :login');
    $stmt->execute(['login' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification de l'existance de l'utilisateur et que le mot de passe corresponde au hash stocké
    // (J'ai écho un mot de passe haché dans ma base de données pour un seul utilisateur)
    // (Pour l'instant, je désire uniquement qu'un seul utilisateur ait accès au site)
    if ($user && password_verify($password, $user['mot_de_passe'])){
        // Connexion réussie
        // clé primaire : id_utilisateur
        $_SESSION['utilisateur_id'] = $user['id_utilisateur'];
        $_SESSION['login'] = $user['login'];

        // Redirection ver la page d'accueil
        header('Location: index.php');
        exit;
    } else {
        // Erreur si le login ou le mot de passe est incorrect
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

        <?php require_once __DIR__ . '/includes/footer.php' ?>

    </body>
</html>