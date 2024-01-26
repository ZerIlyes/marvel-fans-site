<?php
session_start();
require_once 'app/controllers/AuthController.php'; // Inclure le contrôleur AuthController

// Créer une instance du contrôleur
$authController = new AuthController();

// Exécuter une action spécifique du contrôleur, par exemple, la méthode "login"
$authController->login();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Site Fans Marvel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<!-- Contenu principal -->
<div class="container">
    <!-- Inclure la page d'accueil ici -->
    <?php include('app/views/home/home.php'); ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>