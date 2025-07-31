<?php

require_once __DIR__ . '/config/databaseconnect.php';

$stmtMatiere = $mysqlClient->query("SELECT * FROM matiere");
$matieres = $stmtMatiere->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_POST['nom']) 
    && !empty($_POST['prenom']) 
    && !empty($_POST['classe']) 
    && !empty($_POST['date_naissance'])
    && !empty($_POST['niveau_satisfaction']) 
    && !empty($_POST['id_matiere']) 
    && !empty($_POST['periode'])){
    
    try {
        
    $stmtEtudiant = $mysqlClient->prepare('INSERT INTO etudiant 
    (nom, prenom, classe, date_naissance) VALUES (?,?,?,?)');

    $stmtEtudiant->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['classe'],
        $_POST['date_naissance']
    ]);

    // Récupération de l'id de l'étudiant 
    $stmtSelectId = $mysqlClient->prepare("SELECT id_etudiant 
    FROM etudiant WHERE nom = ? AND prenom = ? AND date_naissance = ? ORDER BY 
    id_etudiant DESC LIMIT 1");

    $stmtSelectId->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['date_naissance']
    ]);

    $result = $stmtSelectId->fetch(PDO::FETCH_ASSOC);
    $id_etudiant = $result['id_etudiant'];

    // Insertion de la note
    $stmtNote = $mysqlClient->prepare("INSERT INTO note (periode, niveau_satisfaction, id_etudiant, id_matiere) 
    VALUES (?,?,?,?)");

    $stmtNote->execute([
        $_POST['periode'],
        $_POST['niveau_satisfaction'],
        $id_etudiant,
        $_POST['id_matiere']
    ]);

    echo "<p>Etudiant et note ajoutés avec succès !</p>";

} catch (PDOException $e){
    echo "<p> Erreur lors de l'insertion : " . htmlspecialchars($e->getMessage()) ."</p>";
    
    }
}



?>