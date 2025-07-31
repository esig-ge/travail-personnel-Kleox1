<?php 

// include
require_once __DIR__ . '/config/databaseconnect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID étudiant manquant ou invalide.');
}

$id_etudiant = $_GET['id'];

// Récupère les informations des étudiants
$stmtEtudiant = $mysqlClient->prepare('SELECT * FROM etudiant WHERE id_etudiant = ?');
$stmtEtudiant->execute([$id_etudiant]);
$etudiant = $stmtEtudiant->fetch(PDO::FETCH_ASSOC);

if (!$etudiant){
    die('Etudiant non trouvé.');
}

// Récupère les notes liées à l'étudiant en question, avec le nom de la matière
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
    <title>Détails de l'étudiant <?php echo $etudiant['nom'] . $etudiant['prenom']?></title> 
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Barre de navigation -->
    
    <div class="nav">
        <a href="index.php">Accueil</a>
        <a href="login.php">Login</a>
        <a href="contact.php">Contact</a>
    </div>

    <h1>Détails de l'étudiant</h1>

    <h2><?php echo htmlspecialchars($etudiant['prenom']) . " " ?>
    <?php echo htmlspecialchars($etudiant['nom']) ?></h2>

    <p>Classe : <?php echo htmlspecialchars($etudiant['classe'])?></p>
    <p>Date de naissance : <?php echo htmlspecialchars($etudiant['date_naissance'])?></p>

    <h3>Notes : </h3>

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

</body>


</html>