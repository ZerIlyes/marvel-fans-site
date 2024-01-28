<?php
session_start(); // Placez session_start() ici
// Inclure les fichiers nécessaires
require_once 'app/models/Model.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/JarvisController.php';
require_once 'app/controllers/QuizController.php';
require_once 'app/controllers/ReviewController.php';
require_once 'app/controllers/ForumController.php';
require_once 'app/controllers/TopicController.php';


$reviewController = new ReviewController();
$authController = new AuthController();
$userController = new UserController();
$jarvisController = new JarvisController();
$quizController = new QuizController();
$forumController = new ForumController();
$topicController = new TopicController();
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
            $topicController->showTopic($topicId);
            break;
        case 'submit_post':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $forumController->submitPost($_POST);
            }
            break;
        case 'create_topic':
            $forumController->createTopic();
            break;

        // Autres cas d'action...
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
if (!$action && !$page) {
    include 'app/views/home/menu_view.php';
}
?>
