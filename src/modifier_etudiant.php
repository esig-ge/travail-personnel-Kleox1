<?php

require_once __DIR__ . '/config/databaseconnect.php';

// Vérfifiction si l'id existe ou bien est vide
if (!isset($_GET['id']) || empty($_GET['id'])){
    echo "ID est manquant.";
    exit;
}

$id_etudiant = $_GET["id"];

// Requête avec jointure étudiant et note
$stmtModification = $mysqlClient->prepare('SELECT 
e.*, n.periode, n.niveau_satisfaction, n.id_matiere 
FROM etudiant e  
JOIN note n ON e.id_etudiant = n.id_etudiant
WHERE e.id_etudiant = ?');

// Exécuter la requête concernant les étudiants
$stmtModification->execute([$id_etudiant]);

// Récupérer les données de la table étudiant et note
$etudiant = $stmtModification->fetch(PDO::FETCH_ASSOC);

// Requête Matière
$stmtMatiere = $mysqlClient->prepare('SELECT * FROM matiere');

// Exécuter la requête concernant les matières
$stmtMatiere->execute();

// Récupérer les données de la table matière
$matieres = $stmtMatiere->fetchAll(PDO::FETCH_ASSOC);;


// Formulaire pour modifier les étudiants
?>

    <form method="POST" action="modifier_etudiant.php?id=<?=$etudiant['id_etudiant']?>">
        <label>Nom : <input type="text" name="nom" value="<?= $etudiant['nom'] ?>" required></label><br>
        <label>Prénom : <input type="text" name="prenom" value = "<?= $etudiant['prenom'] ?>" required></label><br>
        <label>Classe : <input type="text" name="classe" value = "<?= $etudiant['classe'] ?>" required></label><br>
        <label>Date de naissance : <input type="date" name="date_naissance" value="<?= $etudiant['date_naissance'] ?>" required></label><br>
        <label>Période : <input type="date" name="periode" value="<?= $etudiant['periode'] ?>" required ></label><br>
        
        <label>Niveau de satisfaction : <input type="text" name="niveau_satisfaction" value="<?= $etudiant['niveau_satisfaction']?>" required></label><br>
        
        <label>Matière : 
            <select name="id_matiere">
                
            <option value="">Choisissez une matière</option>

                <?php foreach ($matieres as $matiere) {
                    echo '<option value="'. htmlspecialchars($matiere["id_matiere"]) . '"'
                    . ($matiere['id_matiere'] == $etudiant['id_matiere'] ? ' selected' : '')  
                    . '>'
                    . htmlspecialchars($matiere['nom']) 
                    . '</option>';
            
                } 
                ?>

            </select>
        </label><br><br>

    <button type="submit">Enregistrer les modifications</button>

    </form>
