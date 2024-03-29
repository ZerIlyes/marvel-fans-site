<?php
require_once 'app/models/Model.php'; // Assurez-vous d'inclure le modèle UserModel

class UserController {
    private $userModel;
    private $passwordError;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // UserController.php
    public function showMonComptePage() {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            // Récupérer les informations de l'utilisateur
            $userInfo = $this->userModel->getUserInfo($userId);

            // Passer les informations à la vue
            $avatarPath = $userInfo['avatar_path'];
            $email = $userInfo['email'];

            include 'app/views/home/moncompte_view.php';
        } else {
            // Redirigez vers la page de connexion ou affichez une erreur
        }
    }

    public function deleteUser($userId) {
        if ($this->userModel->deleteUser($userId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Impossible de supprimer l\'utilisateur.']);
        }
        exit();
    }
    public function addUser() {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $avatar = $_POST['avatar'];

        $result = $this->userModel->addUser($username, $email, $password, $avatar);

        if ($result['success']) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
        exit();
    }





    public function showUserList() {
        $users = $this->userModel->getUsers();
        require 'app/views/admin/user_list_view.php';
    }


    public function updateProfile() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userId = $_SESSION['user_id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $avatarPath = $_POST['avatar']; // Récupérer le chemin de l'avatar choisi
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Vérifiez si les champs obligatoires sont vides
            if (empty($username) || empty($email) || empty($avatarPath)) {
                $this->passwordError = "Veuillez remplir tous les champs.";
                $this->showMonComptePage(); // Affichez à nouveau la page avec le message d'erreur
                exit();
            }

            // Vérifiez si le champ de mot de passe est rempli
            $hashedPassword = null;
            if (!empty($password)) {
                // Vérifiez si les mots de passe correspondent
                if ($password !== $confirmPassword) {
                    $this->passwordError = "La confirmation du mot de passe n'est pas identique.";
                    $this->showMonComptePage(); // Affichez à nouveau la page avec le message d'erreur
                    exit();
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                }
            }

            // Appelez la méthode de modèle pour mettre à jour les informations de l'utilisateur
            $success = $this->userModel->updateUserProfile($userId, $username, $email, $avatarPath, $hashedPassword);

            if ($success) {
                // Mettez à jour les informations de session si nécessaire
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['avatar_path'] = $avatarPath; // Mettre à jour le chemin de l'avatar dans la session

                // Redirigez l'utilisateur vers la page de profil ou une autre page appropriée
                header('Location: index.php?action=moncompte');
                exit();
            } else {
                // Gérez l'erreur si la mise à jour échoue
                $this->passwordError = "Une erreur s'est produite lors de la mise à jour du profil.";
                $this->showMonComptePage();
                exit();
            }
        }
    }



}
?>
