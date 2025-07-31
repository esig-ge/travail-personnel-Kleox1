<?php 

require_once __DIR__ . '/mysql.php'; 

// CONNEXION A LA BASE DE DONNEES

try 
{
$mysqlClient = new PDO(
    "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_NAME . 
    ";charset=utf8", MYSQL_USER, 
    MYSQL_PASSWORD,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] // AFFICHE LES ERREURS
);

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


?>