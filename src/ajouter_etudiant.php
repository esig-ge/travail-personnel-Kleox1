<?php

// Connexion à la base de données et gestion de session
require_once __DIR__ . '/config/databaseconnect.php';
require_once __DIR__ . '/includes/session.php';


// Insertion des matières uniquement si la table est vide afin d'éviter les doublons
$stmtCount = $mysqlClient->query("SELECT COUNT(*) FROM matiere"); // Requête
$count = $stmtCount->fetchColumn(); // Nombre de colonnes respectant la requête

if ($count == 0) {
    $matieres = ['Français', 'Mathématiques', 'Histoire'];
    try {
        foreach ($matieres as $matiere) {
            $stmt = $mysqlClient->prepare("INSERT INTO matiere (nom) VALUES (?)"); // Insère ? 
            $stmt->execute([$matiere]);
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion des matières : " . htmlspecialchars($e->getMessage());
    }
}

// Récupération des matières pour le formulaire
$stmtMatiere = $mysqlClient->query("SELECT * FROM matiere");
$matieres = $stmtMatiere->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire si tous les champs sont remplis

if (!empty($_POST['nom']) 
    && !empty($_POST['prenom']) 
    && !empty($_POST['classe']) 
    && !empty($_POST['date_naissance'])
    && !empty($_POST['niveau_satisfaction']) 
    && !empty($_POST['periode'])){
    
    try {
        
    // Insertion de l'étudiant
    $stmtEtudiant = $mysqlClient->prepare('INSERT INTO etudiant 
    (nom, prenom, classe, date_naissance) VALUES (?,?,?,?)');

    $stmtEtudiant->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['classe'],
        $_POST['date_naissance']
    ]);

    // Récupération de l'id de l'étudiant qui a été ajouté
    $stmtSelectId = $mysqlClient->prepare("SELECT id_etudiant 
    FROM etudiant 
    WHERE nom = :nom AND prenom = :prenom AND classe = :classe AND date_naissance = :date_naissance
    ORDER BY id_etudiant  
    DESC LIMIT 1");

    $stmtSelectId->execute([
        ':nom' => $_POST['nom'],
        ':prenom' => $_POST['prenom'],
        ':classe' => $_POST['classe'],
        ':date_naissance' => $_POST['date_naissance'],
    ]);

    $result = $stmtSelectId->fetch(PDO::FETCH_ASSOC);
    $id_etudiant = $result['id_etudiant'];

    if (!$id_etudiant){
        throw new Exception("Impossible de retrouver l'étudiant inséré !");
    }

    // Insertion de la note associée (La table note est une association)
    $stmtNote = $mysqlClient->prepare("INSERT INTO note (periode, niveau_satisfaction, id_etudiant, id_matiere) 
    VALUES (?,?,?,?)"); // Les ? seront remplacés par les valeurs lors de l'éxécution ci-dessous

    $stmtNote->execute([
        $_POST['periode'],
        $_POST['niveau_satisfaction'],
        $id_etudiant,
        $_POST['id_matiere']
    ]);

    // Redirection vers la page 'etudiants.php'
    header('Location: etudiants.php');
    exit;

} catch (PDOException $e){
    echo "<p> Erreur lors de l'insertion : " . htmlspecialchars($e->getMessage()) ."</p>";
    
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ajouter un étudiant</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>

    <h1>Ajouter un étudiant</h1>

    <!-- Formulaire pour ajouter des étudiants -->

    <form method="POST" action="ajouter_etudiant.php">
        <label>Nom : <input type="text" name="nom" required></label><br>
        <label>Prénom : <input type="text" name="prenom" required></label><br>
        <label>Classe : <input type="text" name="classe" required></label><br>
        <label>Date de naissance : <input type="date" name="date_naissance" required></label><br>
        <label>Période : <input type="date" name="periode" required ></label><br>
        
        <label>Niveau de satisfaction : <input type="text" name="niveau_satisfaction" required></label><br>
        

        <label>Matière :
            <select name="id_matiere" required>
                <?php foreach ($matieres as $matiere): ?>
                    <option value="<?= htmlspecialchars($matiere['id_matiere']) ?>"
                        <?= ($matiere['nom'] === 'Français') ? 'selected' : '' ?>>
                        <?= htmlspecialchars($matiere['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>


    <button type="submit">Ajouter un étudiant</button>

    </form>

    </body>

</html>

