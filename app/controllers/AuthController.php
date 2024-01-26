<?php
require_once 'app/models/Model.php'; // Assurez-vous d'inclure le modèle UserModel

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                // Le mot de passe est correct, démarrer une nouvelle session
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["user_id"] = $user['user_id'];
                $_SESSION["username"] = $user['username'];

                // Rediriger vers la page d'accueil
                header("location: index.php");
                exit;
            } else {
                // Afficher une erreur de connexion
                $login_err = "Identifiants invalides.";
                require_once 'app/views/auth/loginModalView.php';
            }
        } else {
            require_once 'app/views/auth/loginModalView.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $avatar = $_POST['avatar'];

            // Hacher le mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Appel à la fonction d'inscription du modèle
            $result = $this->userModel->registerUser($username, $email, $hashed_password, $avatar);

            if ($result) {
                // Rediriger vers la page de connexion après l'inscription réussie
                header("Location: index.php?action=login");
                exit;
            } else {
                $register_err = "Erreur lors de l'inscription.";
                require_once 'app/views/auth/registerModalView.php';
            }
        } else {
            require_once 'app/views/auth/registerModalView.php';
        }
    }
}
