<?php
// Inclure les fichiers nécessaires
require_once 'app/models/config.php';
require_once 'app/models/Model.php'; // Si nécessaire
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/UserController.php'; // Ajout du contrôleur UserController.php

// Créer une instance de AuthController
$authController = new AuthController();

// Créer une instance de UserController
$userController = new UserController();

// Récupérer l'action de l'URL (si définie)
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Routeur simple
switch ($action) {
    case 'login':
        // Appeler la méthode de connexion
        $authController->login();
        break;
    case 'register':
        // Appeler la méthode d'inscription
        $authController->register();
        break;
    case 'logout':
        // Appeler la méthode de déconnexion
        $authController->logout();
        break;
    case 'menu':
        // Assurez-vous d'avoir démarré la session si vous utilisez les variables de session dans menu_view.php
        session_start();
        // Vérifiez si l'utilisateur est connecté avant de montrer le carrousel
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            include 'app/views/home/menu_view.php';
        } else {
            header('Location: index.php'); // Rediriger vers la page de connexion si non connecté
            exit();
        }
        break;
    case 'moncompte':
        // Assurez-vous que l'utilisateur est connecté avant d'afficher cette page
        session_start();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            // Au lieu d'inclure directement la vue, appelez la méthode qui prépare les données.
            $userController->showMonComptePage();
        } else {
            header('Location: index.php'); // Rediriger vers la page de connexion si non connecté
            exit();
        }
        break;
    case 'updateProfile':
        // Appeler la méthode de mise à jour du profil
        $userController->updateProfile();
        break;
    default:
        // Chargement de la page d'accueil ou une action par défaut
        include 'app/views/home/home.php';
        break;
}
?>
