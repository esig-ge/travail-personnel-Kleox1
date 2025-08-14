<?php

// Connexion à la base de données et la gestion de session

require_once __DIR__ . '/config/databaseconnect.php';
require_once __DIR__ . '/includes/session.php';


// Vérfifiction si l'id de l'étudiant existe ou bien est vide dans l'URL

if (!isset($_GET['id']) || empty($_GET['id'])){
    echo "ID est manquant."; // Message d'erreur si l'id de l'étudiant est absent
    exit;
}

$id_etudiant = $_GET["id"]; // Récupération l'id de l'étudiant

// Traitement du formulaire après soumission

if (!empty($_POST)) {
    // Vérification si tous les champs obligatoires sont présents et non vides
    if (
        isset($_POST['nom'], $_POST['prenom'], $_POST['classe'], $_POST['date_naissance'], $_POST['periode'], $_POST['niveau_satisfaction'], $_POST['id_matiere']) 
        && !empty($_POST['nom'])
        && !empty($_POST['prenom']) 
        && !empty($_POST['classe']) 
        && !empty($_POST['date_naissance']) 
        && !empty($_POST['periode']) 
        && !empty($_POST['niveau_satisfaction']) 
        && !empty($_POST['id_matiere'])
    ) {
        try {
            // Mise à jour de la table etudiant si les conditions sont respectées
            $stmtUpdateEtudiant = $mysqlClient->prepare('UPDATE etudiant SET nom = ?, prenom = ?, classe = ?, date_naissance = ? WHERE id_etudiant = ?');
            $stmtUpdateEtudiant->execute([
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['classe'],
                $_POST['date_naissance'],
                $id_etudiant
            ]);

            // Mise à jour de la table note 
            //(on suppose qu'il y a une seule note par étudiant ici)
            $stmtUpdateNote = $mysqlClient->prepare('UPDATE note SET periode = ?, niveau_satisfaction = ?, id_matiere = ? WHERE id_etudiant = ?');
            $stmtUpdateNote->execute([
                $_POST['periode'],
                $_POST['niveau_satisfaction'],
                $_POST['id_matiere'],
                $id_etudiant
            ]);

            // Redirection vers la liste des étudiants après mise à jour
            header('Location: etudiants.php');
            exit;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Merci de remplir tous les champs.";
    }
}


// Récupération des informations actuelles de l'étudiant 
// (Jointure avec la table note)
$stmtModification = $mysqlClient->prepare('SELECT 
e.*, n.periode, n.niveau_satisfaction, n.id_matiere 
FROM etudiant e  
JOIN note n ON e.id_etudiant = n.id_etudiant
WHERE e.id_etudiant = ?');

// Exécuter la requête concernant les étudiants
$stmtModification->execute([$id_etudiant]);

// Récupérer les données de la table étudiant et note
$etudiant = $stmtModification->fetch(PDO::FETCH_ASSOC);

// Requête concernant les matières
$stmtMatiere = $mysqlClient->prepare('SELECT * FROM matiere');

// Exécuter la requête concernant les matières
$stmtMatiere->execute();

// Récupérer les données de la table matière
$matieres = $stmtMatiere->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Page d'accueil</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <!-- Formulaire pour modifier les étudiants -->

        <!-- Vérification de l'existance de l'étudiant -->
        <?php 
            if (!$etudiant){
                echo "Etudiant introuvable";
                exit;
            }
        ?>

        <form method="POST" action="modifier_etudiant.php?id=<?= htmlspecialchars($etudiant['id_etudiant']) ?>">
            
            <label>Nom : <input type="text" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>" required></label><br>
            <label>Prénom : <input type="text" name="prenom" value = "<?= htmlspecialchars($etudiant['prenom']) ?>" required></label><br>
            <label>Classe : <input type="text" name="classe" value = "<?= htmlspecialchars($etudiant['classe']) ?>" required></label><br>
            <label>Date de naissance : <input type="date" name="date_naissance" value="<?= htmlspecialchars($etudiant['date_naissance']) ?>" required></label><br>
            <label>Période : <input type="date" name="periode" value="<?= htmlspecialchars($etudiant['periode']) ?>" required ></label><br>
            <label>Niveau de satisfaction : <input type="text" name="niveau_satisfaction" value="<?= htmlspecialchars($etudiant['niveau_satisfaction'])?>" required></label><br>
            
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
    </body>
</html>



