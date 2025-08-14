<?php 

// Includes
require_once __DIR__ . '/config/databaseconnect.php';
require_once __DIR__ . '/includes/session.php';


$stmt = $mysqlClient->query("SELECT * 
FROM etudiant
WHERE statut = TRUE");
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

            <!-- Ajouter un lien pour AJOUTER DES ETUDIANTS -->
            <div class="nav">
                <a href="index.php">Accueil</a>
                <a href="ajouter_etudiant.php">Ajouter un étudiant</a>
                <a href="login.php">Login</a>
            </div>

        <main class="imageBackground">
            

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
                    <!-- Lien pour modifier l'étudiant -->
                    <a href="modifier_etudiant.php?id=<?= $etudiant['id_etudiant'] ?>">
                    Modifier l'étudiant
                    </a>

                    <!-- Lien pour supprimer l'étudiant -->
                    <a href="supprimer_etudiant.php?id=<?= $etudiant['id_etudiant']?>">
                    Supprimer l'étudiant
                    </a>
                </li>
    

                <?php endforeach; ?>

            </ul>
            <?php endif; ?>
        </div>

                </main>

        <?php require_once __DIR__ . '/includes/footer.php' ?>

    </body>
</html>


