<?php
require_once 'app/models/Model.php';

class AdminController
{
    private $userModel;
    private $forumModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->forumModel = new ForumModel();
    }

    public function showAdminPanel() {
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            $users = $this->userModel->getAllUsersWithAvatar(); // Utilisez la nouvelle méthode que vous avez ajoutée
            require 'app/views/admin/admin_panel_view.php';
        } else {
            // Rediriger vers la page de connexion ou une page d'erreur si l'utilisateur n'est pas un admin
            header('Location: index.php');
            exit();
        }
    }
}

