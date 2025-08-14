<?php 

// Connexion à la base de données et gestion de session

require_once __DIR__ . '/config/databaseconnect.php';
require_once __DIR__ . '/includes/session.php';

// Vérification que l'id de l'étudiant est fourni et que l'id est un nombre ou une chaîne numérique

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID étudiant manquant ou invalide.');
}

$id_etudiant = $_GET['id'];

// Récupération des informations de l'étudiant
$stmtEtudiant = $mysqlClient->prepare('SELECT * FROM etudiant WHERE id_etudiant = ?');
$stmtEtudiant->execute([$id_etudiant]);
$etudiant = $stmtEtudiant->fetch(PDO::FETCH_ASSOC);

// Si aucun étudiant n'est trouvé
if (!$etudiant){
    die('Etudiant non trouvé.');
}

// Récupération des notes et du nom de la matière liées à l'étudiant (jointure)
// (Table note est une table d'assocation)
$stmtNotes = $mysqlClient->prepare('SELECT note.*, matiere.nom AS matiere_nom 
FROM note 
JOIN matiere ON note.id_matiere = matiere.id_matiere
WHERE id_etudiant = ?
');

$stmtNotes->execute([$id_etudiant]);
$notes = $stmtNotes->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <title>Détails de l'étudiant <?php echo htmlspecialchars($etudiant['nom']) . htmlspecialchars($etudiant['prenom']) ?></title> 
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Barre de navigation -->
    
    <div class="nav">
        <a href="index.php">Accueil</a>
        <a href="login.php">Login</a>
    </div>

    <h1>Détails de l'étudiant</h1>

    <!-- Affichage des détails de l'étudiant -->

    <h2><?php echo htmlspecialchars($etudiant['prenom']) . " " ?>
    <?php echo htmlspecialchars($etudiant['nom']) ?></h2>
    <h3>Classe : <?php echo htmlspecialchars($etudiant['classe'])?></h3>
    <h3>Date de naissance : <?php echo htmlspecialchars($etudiant['date_naissance'])?></h3>

    <!-- Affichage des notes -->
    <?php if (empty($notes)) {
        echo "<p>Aucune note enregistrée pour cet étudiant</p>";
    } else {
        echo "<table>";
        echo "<thead>
                <tr>
                    <th>Matières</th>
                    <th>Période</td>
                    <th>Niveau de satisfaction</th>
                </tr>
            </thead>";
        echo "<tbody>";
        foreach ($notes as $note) {
            echo "<tr>";
                echo "<td>" . htmlspecialchars($note['matiere_nom']) . "</td>";
                echo "<td>" . htmlspecialchars($note['periode']) . "</td>";
                echo "<td>" . htmlspecialchars($note['niveau_satisfaction']) . "</td>";
            echo "</tr>";

        }
        echo "</tbody>";
    echo "</table>";
    }

    ?>

    <p class="retour"><a href="etudiants.php">Retour à la liste des étudiants</a></p>

</body>


</html>