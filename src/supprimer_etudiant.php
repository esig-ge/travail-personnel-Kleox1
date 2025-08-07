<?php

require_once __DIR__ . '/config/databaseconnect.php';

// Vérfifiction si l'id existe ou bien est vide
if (!isset($_GET['id']) || empty($_GET['id'])){
    echo "ID est manquant.";
    exit;
}

$id_etudiant = $_GET["id"];

// Requête pour mettre à jour le champs "statut"
if (isset($_POST['confirmer'])){
    $stmtSuppression = $mysqlClient->prepare('UPDATE etudiant
    SET statut = FALSE 
    WHERE id_etudiant = ?');

    $stmtSuppression->execute([$id_etudiant]);
    header('Location: etudiants.php');
    exit;
}



// récupère les informations de l'étudiant pour l'affichage
$stmtInfos = $mysqlClient->prepare('SELECT *
FROM etudiant
WHERE id_etudiant = ?');
$stmtInfos->execute([$id_etudiant]);
$etudiant = $stmtInfos->fetch(PDO::FETCH_ASSOC);

if (!$etudiant){
    echo "Etudiant est introuvable.";
    exit;
}


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Confirmation de suppression</title>
    </head>

    <body>
        <h1>Confirmer la suppression</h1>

        <p>Voulez-vous vraiment supprimer l'étudiant <?php echo $etudiant['prenom'] . " " . $etudiant['nom']; ?></p>
    
        <form method="post" action="">
            <button type="submit" name="confirmer">Oui</button>
            <a href="etudiants.php">Annuler</a>
        </form>
    
    
    </body>
    
</html>




