<?php

// Connexion à la base de données et gestion de session
require_once __DIR__ . '/config/databaseconnect.php';
require_once __DIR__ . '/includes/session.php';

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title>Page d'accueil</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <header>

            <div class="container">
                <h1>Accueil</h1>
            </div>

            <!-- Barre de navigation -->
            <div class="nav">
                <a href="etudiants.php">Page Etudiants</a>

                <?php 
                    if (isset($_SESSION['utilisateur_id'])){
                        echo '<a href="logout.php">Déconnexion</a>';
                    } else {
                        echo '<a href="login.php">Login</a>';
                    } 
                ?>

            </div>
        </header>

        <!-- Image de fond -->
        <main class="imageBackground">
                <!-- Pas de contenu -->
        </main>

    <?php 
        // Pied de page 
        require_once __DIR__ . '/includes/footer.php'; 
    ?>

    </body>
    
</html>



