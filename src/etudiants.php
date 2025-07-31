<?php 

require_once __DIR__ . '/config/databaseconnect.php';

$stmt = $mysqlClient->query("SELECT * FROM etudiant");
$etudiants = $stmt->fetchALL(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Liste des étudiants</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div class="container">
            <h1> Liste des étudiants </h1>
        </div>

            <!-- Barre de navigation -->
            <div class="nav">
                <a href="index.php">Accueil</a>
                <a href="login.php">Login</a>
                <a href="contact.php">Contact</a>
            </div>


        <div class="container">

            <?php if (count($etudiants) === 0): ?>
                <p>Aucun étudiant trouvé</p>
            <?php else: ?>

            <ul>
                <?php foreach ($etudiants as $etudiant): ?>

                <li>
                    <a href="details_etudiant.php?id=<?= $etudiant['id_etudiant']?>">
                        <?= htmlspecialchars($etudiant['prenom'])?> <?= htmlspecialchars($etudiant['nom']) ?>
                        (<?= htmlspecialchars($etudiant['classe']) ?>)
                    </a>
                </li>
    

                <?php endforeach; ?>

            </ul>
            <?php endif; ?>
        </div>

    </body>
</html>


