<?php
session_start(); //
// Inclure les fichiers nécessaires
require_once 'app/models/Model.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/JarvisController.php';
require_once 'app/controllers/QuizController.php';
require_once 'app/controllers/ReviewController.php';
require_once 'app/controllers/ForumController.php';
require_once 'app/controllers/UserTopicsController.php';
require_once 'app/controllers/AdminController.php';
$adminController = new AdminController();
$reviewController = new ReviewController();
$authController = new AuthController();
$userController = new UserController();
$jarvisController = new JarvisController();
$quizController = new QuizController();
$forumController = new ForumController();
$userTopicsController = new UserTopicsController();
$action = isset($_GET['action']) ? $_GET['action'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : '';

// Gérer d'abord l'action
if ($action) {
    switch ($action) {
        case 'login':
            $authController->login();
            break;
        case 'register':
            $authController->register();
            break;
        case 'logout':
            $authController->logout();
            break;
        case 'menu':
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                include 'app/views/home/menu_view.php';
            } else {
                header('Location: index.php'); // Rediriger vers la page de connexion si non connecté
                exit();
            }
            break;
        case 'moncompte':
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                $userController->showMonComptePage();
            } else {
                header('Location: index.php');
                exit();
            }
            break;
        case 'updateProfile':
            $userController->updateProfile();
            break;
        case 'quiz_list':
            $quizController->listQuizzes();
            break;
        case 'write_review':
            $reviewController = new ReviewController();
            $reviewController->writeAndListReviews();
            break;
        case 'jarvis':
            $jarvisController->showJarvisPage();
            break;

        case 'forum_topics':
            error_log("forum_topics action is reached");
            $forumController->showTopics();
            break;

        case 'view_topic':
            $topicId = $_GET['id'] ?? 0;
            $userTopicsController->showTopic($topicId);
            break;
        case 'submit_post':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $forumController->submitPost($_POST);
            }
            break;
        case 'create_topic':
            $forumController->createTopic();
            break;
        case 'delete_user':
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
                $userController->deleteUser($_POST['user_id']);
            }
            break;

        case 'admin_panel':
            // Vérifiez si l'utilisateur est administrateur avant d'afficher le panneau
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                $userController->showUserList();
            } else {
                // Rediriger l'utilisateur ou afficher une erreur
                header('Location: index.php');
                exit();
            }
            break;

            // Admin Vues


        case 'add_user':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Assurez-vous que tous les champs nécessaires sont présents
                if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['avatar'])) {
                    $userController->addUser();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis.']);
                }
            }
            break;

        case 'create_user':
            // Vérifiez si l'utilisateur est administrateur avant de créer un utilisateur
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1 && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $userController->createUser($_POST);
            } else {
                // Rediriger l'utilisateur ou afficher une erreur
                header('Location: index.php');
                exit();
            }
            break;
        case 'view_user_topics':
            $userId = $_GET['user_id'] ?? 0;
            $userTopicsController->showUserTopics($userId);
            break;
        case 'delete_topic':
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['topic_id'])) {
                $userTopicsController->deleteTopic($_POST['topic_id']);
            } else {
                // Gérer l'erreur ou ignorer la demande
            }
            break;
        default:
            include 'app/views/home/home.php';
            break;
    }
} else {
    // Si pas d'action, vérifier la page pour le quiz
    switch ($page) {
        case 'quiz_list':
            $quizController->listQuizzes();
            break;
        case 'quiz_preview':
            $quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;
            $quizController->previewQuiz($quiz_id);
            break;
        case 'start_quiz':
            $quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;
            $quizController->startQuiz($quiz_id);
            break;
        case 'quiz_question':
            $quizController->showCurrentQuestion();
            break;
        case 'quiz_end':
            $quizController->endQuiz();
            break;

        // Gérer d'autres pages ou afficher une erreur 404
    }
}

// Gérer la soumission des réponses
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer'])) {
    $quizController->handleQuestionSubmission();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'add_user') {
    // Appeler la fonction du contrôleur pour traiter le formulaire d'ajout d'utilisateur
    $userController->addUser($_POST);
}

if (!$action && !$page) {
    include 'app/views/home/home.php';
}
?>
