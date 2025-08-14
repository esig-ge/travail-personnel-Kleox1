<?php

// Connexion à la base de données et la gestion de session

require_once __DIR__ . '/config/databaseconnect.php';
require_once __DIR__ . '/includes/session.php';


// Vérfifiction si l'id existe ou bien est vide dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])){
    echo "ID est manquant.";
    exit;
}

// Stockage de l'id de l'étudiant
$id_etudiant = $_GET["id"];

// Récupération des informations de l'étudiant
$stmtInfos = $mysqlClient->prepare('SELECT * FROM etudiant WHERE id_etudiant = ?');
$stmtInfos->execute([$id_etudiant]);
$etudiant = $stmtInfos->fetch(PDO::FETCH_ASSOC);

if (!$etudiant){
    echo "Etudiant est introuvable.";
    exit;
}


// Requête pour mettre à jour le champs "statut"
if (isset($_POST['confirmer'])){

    // Mise à jour du statut de l'étudiant
    $stmtSuppression = $mysqlClient->prepare('UPDATE etudiant
    SET statut = FALSE 
    WHERE id_etudiant = ?');
    $stmtSuppression->execute([$id_etudiant]);
    
    // Mise à jour du statut des notes associées
    $stmtUpdateNotes = $mysqlClient->prepare('UPDATE note SET statut = FALSE WHERE id_etudiant = ?');
    $stmtUpdateNotes->execute([$id_etudiant]);

    // Redirection vers la liste des étudiants
    header('Location: etudiants.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Confirmation de suppression</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>


        <h1>Confirmer la suppression</h1>

        <p class="phraseSuppression">Voulez-vous vraiment supprimer l'étudiant <?php echo '<span class="supprimer">' . htmlspecialchars($etudiant['prenom'] . " " . $etudiant['nom']) . '</span>' . ' ?';?></p>
    
        <form method="post" action="">
            <button type="submit" name="confirmer">Oui</button>
            <button type="button" onclick="window.location='etudiants.php';">Retour à la liste des étudiants </button>
        </form>
    
    
    </body>
    
</html>




