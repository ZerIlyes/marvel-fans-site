<?php
require_once 'app/models/Model.php'; // Assurez-vous d'inclure le modèle UserModel

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email']; // Validez et nettoyez
            $password = $_POST['password'];
            $user = $this->userModel->loginUser($email, $password);

            if ($user) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];
                echo json_encode(['error' => false, 'redirect' => 'index.php?action=menu']);
            } else {
                // Échec de la connexion
                echo json_encode(['error' => true, 'message' => "L'adresse email ou le mot de passe est incorrect."]);
            }
            exit();
        }
    }


    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username']; // Valider et nettoyer ces données
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $avatarPath = $_POST['avatar'];
            $userId = $this->userModel->registerUser($username, $email, $password,$avatarPath);
            if ($userId) {
                // Inscription réussie, connectez l'utilisateur automatiquement
                $_SESSION['loggedin'] = true; // Ajout de cette ligne
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $username;
                header('Location: index.php?action=menu');
                exit();
            } else {
                // Échec de l'inscription, gérer l'erreur
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy(); // Cela effacera toutes les variables de session
        header('Location: index.php'); // Redirige vers la page d'accueil
        exit(); // Assurez-vous que le script s'arrête après la redirection
    }

}
