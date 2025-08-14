<?php

// Déconnexion

// Démarrage de la session
session_start();

// Destruction de toutes les données de session pour déconnexion
session_destroy();

// Redirection vers la page de login
header('location: login.php');
exit; 

?>