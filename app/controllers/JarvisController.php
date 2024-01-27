<?php
require_once 'app/models/Model.php';

class JarvisController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function showJarvisPage() {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        if ($userId) {
            $userAvatarPath = $this->userModel->getUserAvatarPath($userId);
            require_once 'app/views/jarvis/jarvis_view.php';
        } else {
            // Redirigez vers la page de connexion ou affichez une erreur
            header('Location: index.php?action=login');
            exit();
        }
    }
}

?>