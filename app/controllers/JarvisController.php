<?php
require_once 'app/models/Model.php';

class UserController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function getUserAvatarPath($userId) {
        return $this->userModel->getAvatarPath($userId);
    }
}


class JarvisController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function chat() {
        // Supposons que l'ID de l'utilisateur est stocké dans $_SESSION['user_id']
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        if ($userId) {
            $userAvatarPath = $this->userModel->getUserAvatarPath($userId);
            require_once 'app/views/jarvis/JarvisView.php';
        } else {
            // Gérer le cas où l'utilisateur n'est pas connecté
            // Par exemple, rediriger vers la page de connexion
        }
    }
}

?>