<?php
// Initialiser la session
session_start();

// Détruire toutes les données de session
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil (index) ou toute autre page de votre choix
header("location: index.php");
exit;
?>
s