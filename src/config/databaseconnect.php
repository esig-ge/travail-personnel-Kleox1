<?php 

require_once __DIR__ . '/mysql.php'; 

// Connexion à la base de données

try 
{
$mysqlClient = new PDO(
    "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_NAME . 
    ";charset=utf8", MYSQL_USER, 
    MYSQL_PASSWORD,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage()); // Affiche un message d'erreur
}


?>